<?php
/**
 *
 * Auto Database Backup
 *
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace pico\autodbbackup\migrations\v1xx;

class m3_interval_unit extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\\pico\\autodbbackup\\migrations\\v1xx\\m1_initial_config'];
	}

	public function update_data()
	{
		return [
			['config.add', ['auto_db_backup_gc_unit', 'days']],
		];
	}
}
