<?php
/**
*
* Auto Database Backup
*
* @copyright (c) 2023 Rich McGirr
* @copyright (c) 2014 Lukasz Kaczynski
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace pico\autodbbackup\cron\task;

/**
* @ignore
*/
use phpbb\config\config;
use phpbb\db\driver\driver_interface as db;
use phpbb\db\tools\tools_interface as db_tools;
use phpbb\log\log;
use phpbb\user;
use Symfony\Component\DependencyInjection\ContainerInterface;

class auto_db_backup extends \phpbb\cron\task\base
{
	// Combined with unique_id(), this fits phpBB's 32-character backup identifier.
	private const BACKUP_MARKER = 'picoautodbbackup';

	protected $config;
	protected $db;
	protected $db_tools;
	protected $log;
	protected $user;
	/** @var ContainerInterface */
	protected $phpbb_container;
	protected $root_path;
	protected $php_ext;

	/**
	* Constructor.
	*/
	public function __construct(config $config, db $db, db_tools $db_tools, log $log, user $user, ContainerInterface $phpbb_container, $root_path, $php_ext)
	{
		$this->config = $config;
		$this->db = $db;
		$this->db_tools = $db_tools;
		$this->log = $log;
		$this->user = $user;
		$this->phpbb_container = $phpbb_container;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	* Runs this cron task.
	*
	* @return null
	*/
	public function run()
	{
		// this is required for the get_usable_memory function
		include($this->root_path . 'includes/acp/acp_database.' . $this->php_ext);

		$last_backup = (int) $this->config['auto_db_backup_last_gc'];
		if ($this->config['auto_db_backup_gc_unit'] === 'hours')
		{
			// Keep the configured cadence when cron starts late. Skip missed runs.
			$interval = max(3600, (int) $this->config['auto_db_backup_gc']);
			$last_backup_date = $last_backup + intdiv(max(0, time() - $last_backup), $interval) * $interval;
		}
		else
		{
			$backup_date = getdate($last_backup);
			$last_backup_date = mktime($backup_date['hours'], $backup_date['minutes'], 0, date("m"), date("j"), date("Y"));
		}

		$this->config->set('auto_db_backup_last_gc', $last_backup_date, false);

		// Optimize database tables before backup them (only unoptimized tables)
		if ($this->config['auto_db_backup_optimize'])
		{
			if ($result = $this->db->sql_query('SHOW TABLE STATUS'))
			{
				$tables = $this->db->sql_fetchrowset($result);
				$size = sizeof($tables);

				for ($i = 0; $i < $size; $i++)
				{
					if ($tables[$i]['Data_free'] != 0)
					{
						$for_optimize[] = $tables[$i]['Name'];
					}
				}

				if (!empty($for_optimize))
				{
					$tables = implode(',', $for_optimize);
					$this->db->sql_query('OPTIMIZE TABLE ' . $tables);
				}
			}
		}

		@set_time_limit(1200);
		@set_time_limit(0);

		$time = time();
		$format = $this->config['auto_db_backup_filetype'];
		$filename = 'backup_' . $time . '_' . self::BACKUP_MARKER . unique_id();

		/** @var phpbb\db\extractor\extractor_interface $extractor Database extractor */
		$extractor = $this->phpbb_container->get('dbal.extractor');
		$extractor->init_extractor($format, $filename, $time, false, true);

		global $table_prefix;

		$tables = $this->db_tools->sql_list_tables();

		$extractor->write_start($table_prefix);

		foreach ($tables as $table_name)
		{
			$extractor->write_table($table_name);
			$extractor->write_data($table_name);
		}

		$extractor->write_end();

		$suffixes = ['text' => '.sql', 'gzip' => '.sql.gz', 'bzip2' => '.sql.bz2'];
		$current = $filename . $suffixes[$format];
		$storage = null;
		if (defined('BACKUPS_TABLE') && $this->phpbb_container->has('storage.backup'))
		{
			$storage = $this->phpbb_container->get('storage.backup');
			$this->store_backup($storage, $current);
		}

		$copies = (int) $this->config['auto_db_backup_copies'];
		if ($copies > 0)
		{
			$this->prune_backups($current, $copies, $storage);
		}

		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_AUTO_DB_BACKUP');
	}


	/**
	 * Publish the extractor's temporary file through phpBB 4.0 backup storage.
	 */
	private function store_backup($storage, string $filename): void
	{
		$path = $this->phpbb_container->get('filesystem.temp')->get_dir() . '/' . $filename;
		$stream = fopen($path, 'rb');
		if ($stream === false)
		{
			throw new \phpbb\exception\runtime_exception('CANNOT_OPEN_FILE');
		}

		try
		{
			$storage->write($filename, $stream);
			$this->db->sql_query('INSERT INTO ' . BACKUPS_TABLE . ' ' .
				$this->db->sql_build_array('INSERT', ['filename' => $filename]));
		}
		finally
		{
			fclose($stream);
			unlink($path);
		}
	}

	/**
	 * Retain the newest marked backups. Legacy and manual backups are unmarked.
	 */
	private function prune_backups(string $current, int $copies, $storage): void
	{
		$pattern = '#\Abackup_([0-9]{10,})_' . self::BACKUP_MARKER . '[a-z0-9]{16}\.sql(?:\.(?:gz|bz2))?\z#';
		$files = [];
		$store = $this->root_path . 'store/';
		if ($storage !== null)
		{
			$result = $this->db->sql_query('SELECT filename FROM ' . BACKUPS_TABLE);
			while ($row = $this->db->sql_fetchrow($result))
			{
				if (preg_match($pattern, $row['filename'], $matches))
				{
					$files[$row['filename']] = (int) $matches[1];
				}
			}
			$this->db->sql_freeresult($result);
		}
		else
		{
			foreach (new \FilesystemIterator($store) as $entry)
			{
				$file = $entry->getFilename();
				if (!$entry->isLink() && $entry->isFile() && preg_match($pattern, $file, $matches))
				{
					$files[$file] = (int) $matches[1];
				}
			}
		}

		// Keep the new backup first if two filenames have the same timestamp.
		if (isset($files[$current]))
		{
			$files = [$current => $files[$current]] + $files;
		}
		arsort($files);

		foreach (array_slice(array_keys($files), $copies) as $file)
		{
			try
			{
				if ($storage !== null)
				{
					$storage->delete($file);
					$this->db->sql_query('DELETE FROM ' . BACKUPS_TABLE . " WHERE filename = '" . $this->db->sql_escape($file) . "'");
				}
				else if (!@unlink($store . $file))
				{
					$this->log_delete_failure($file);
				}
			}
			catch (\phpbb\storage\exception\storage_exception $e)
			{
				$this->log_delete_failure($file);
			}
		}
	}

	private function log_delete_failure(string $file): void
	{
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_AUTO_DB_BACKUP_DELETE_FAILED', false, [$file]);
	}

	/**
	* Returns whether this cron task can run, given current board configuration.
	*
	* @return bool
	*/
	public function is_runnable()
	{
		return (bool) $this->config['auto_db_backup_enable'];
	}

	/**
	* Returns whether this cron task should run now, because enough time
	* has passed since it was last run.
	*
	* @return bool
	*/
	public function should_run()
	{
		return $this->config['auto_db_backup_last_gc'] < time() - $this->config['auto_db_backup_gc'];
	}
}
