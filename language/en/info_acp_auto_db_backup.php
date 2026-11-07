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

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_AUTO_DB_BACKUP'					=> 'Auto Database Backup',
	'LOG_AUTO_DB_BACKUP'					=> '<strong>Auto database backup completed</strong>',
	'LOG_AUTO_DB_BACKUP_DIRECTORY_FAILED'	=> '<strong>Auto database backup could not write to the configured backup directory</strong>',
	'LOG_AUTO_DB_BACKUP_DELETE_FAILED'	=> '<strong>Auto database backup could not remove an old backup</strong><br>» %s',
	'LOG_AUTO_DB_BACKUP_SETTINGS_CHANGED'	=> '<strong>Altered Auto Database Backup settings</strong>',
));
