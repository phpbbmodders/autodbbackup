<?php
/**
 *
 * Auto Database Backup extension for the phpBB Forum Software package
 *
 * @copyright (c) 2026, phpBB Modders, https://www.phpbbmodders.com/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbmodders\autodbbackup\migrations\v1xx;

class m3_interval_unit extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\\phpbbmodders\\autodbbackup\\migrations\\v1xx\\m1_initial_config'];
	}

	public function update_data()
	{
		return [
			['config.add', ['auto_db_backup_gc_unit', 'days']],
		];
	}
}
