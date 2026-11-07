<?php
/**
 *
 * Auto Database Backup extension for the phpBB Forum Software package
 *
 * @copyright (c) 2023 Rich McGirr
 * @copyright (c) 2014 Lukasz Kaczynski
 * @copyright (c) 2026, phpBB Modders, https://www.phpbbmodders.com/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace phpbbmodders\autodbbackup\acp;

class auto_db_backup_module
{
	/** @var string Form action URL */
	public $u_action;

	/** @var string Template file name */
	public $tpl_name;

	/** @var string Page title */
	public $page_title;

	public function main($id, $mode)
	{
		global $phpbb_container;

		$this->tpl_name = 'acp_auto_db_backup';
		$this->page_title = $phpbb_container->get('language')->lang('AUTO_DB_BACKUP_SETTINGS');

		// Get an instance of the admin controller
		$admin_controller = $phpbb_container->get('phpbbmodders.autodbbackup.admin.controller');

		// Make the $u_action url available in the admin controller
		$admin_controller->set_page_url($this->u_action);

		$admin_controller->settings();
	}
}
