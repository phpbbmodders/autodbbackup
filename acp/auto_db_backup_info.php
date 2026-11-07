<?php
/**
 *
 * Auto Database Backup extension for the phpBB Forum Software package
 *
 * @copyright (c) 2014 Lukasz Kaczynski
 * @copyright (c) 2026, phpBB Modders, https://www.phpbbmodders.com/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbmodders\autodbbackup\acp;

class auto_db_backup_info
{
	function module()
	{
		return array(
			'filename'	=> '\phpbbmodders\autodbbackup\acp\auto_db_backup_module',
			'title'		=> 'ACP_AUTO_DB_BACKUP',
			'modes'		=> array(
				'settings'	=> array('title' => 'ACP_AUTO_DB_BACKUP', 'auth' => 'ext_phpbbmodders/autodbbackup && acl_a_board', 'cat' => ['ACP_CAT_DATABASE']),
			),
		);
	}
}
