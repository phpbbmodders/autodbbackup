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

namespace phpbbmodders\autodbbackup\migrations\v1xx;

class m2_initial_module extends \phpbb\db\migration\migration
{
	public function update_data()
	{
		return array(
			array('if', array(
				array('module.exists', array('acp', 'ACP_CAT_DATABASE', 'ACP_AUTO_BACKUP_INDEX_TITLE')),
				array('module.remove', array('acp', 'ACP_CAT_DATABASE', 'ACP_AUTO_BACKUP_INDEX_TITLE')),
			)),

			array('module.add', array(
				'acp', 'ACP_CAT_DATABASE', array(
					'module_basename'	=> '\phpbbmodders\autodbbackup\acp\auto_db_backup_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
