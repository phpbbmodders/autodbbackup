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
	'AUTO_DB_BACKUP_SETTINGS'				=> 'Auto Database Backup settings',
	'AUTO_DB_BACKUP_SETTINGS_EXPLAIN'		=> 'Here you can set default settings for automatic database backups. Depending on your server configuration you may be able to compress the database.<br>Backups are stored in the <samp>/store/</samp> folder unless you set a backup directory below. Backups in the default location can be restored via the <em>Restore</em> panel.',
	'AUTO_DB_BACKUP_SETTINGS_CHANGED'		=> 'Auto Database Backup Settings changed.',
	'AUTO_DB_BACKUP_ENABLE'					=> 'Enable Auto Database Backup',
	'AUTO_DB_BACKUP_ENABLE_EXPLAIN'			=> 'Enable or disable automatic database backups',
	'AUTO_DB_BACKUP_FREQ'					=> 'Backup frequency',
	'AUTO_DB_BACKUP_FREQ_UNIT'			=> 'Backup frequency unit',
	'AUTO_DB_BACKUP_FREQ_EXPLAIN'			=> 'Set the interval in hours or days. Backups run when phpBB cron next runs after the scheduled time.',
	'AUTO_DB_BACKUP_FREQ_ERROR'				=> 'Enter a backup frequency from 1 to 99 and select hours or days.',
	'AUTO_DB_BACKUP_DIRECTORY'				=> 'Backup directory',
	'AUTO_DB_BACKUP_DIRECTORY_EXPLAIN'		=> 'Leave blank to use the board default. For a custom destination, enter the absolute path to an existing private directory outside the web root. Custom archives must be recovered manually.',
	'AUTO_DB_BACKUP_DIRECTORY_ERROR'		=> 'Use an existing private absolute directory outside the web root (for example, mode 0700 or 0750). It must be readable and writable, with no symbolic links or trailing slash.',
	'AUTO_DB_BACKUP_COPIES'					=> 'Stored backups',
	'AUTO_DB_BACKUP_COPIES_EXPLAIN'			=> 'How many backups will be stored on the server. 0 means disabled and all backups will be stored on the server.',
	'AUTO_DB_BACKUP_COPIES_ERROR'			=> 'Entered value for <em>Stored backups</em> is incorrect. Value must be equal or higher than <strong>0</strong>.',
	'AUTO_DB_BACKUP_FILETYPE'				=> 'File type',
	'AUTO_DB_BACKUP_FILETYPE_EXPLAIN'		=> 'Choose the file type for backups.',
	'AUTO_DB_BACKUP_FILETYPE_ERROR'			=> 'Choose one of the file types listed.',
	'AUTO_DB_BACKUP_OPTIMIZE'				=> 'Optimize DB before backup',
	'AUTO_DB_BACKUP_OPTIMIZE_EXPLAIN'		=> 'Optimize only unoptimized database tables before making the backup. This works only for MYSQL databases.',
	'AUTO_DB_BACKUP_OPTIMIZE_NO'			=> 'The database in use on the forum is not <strong>MYSQL</strong>!',
	'AUTO_DB_BACKUP_TIME'					=> 'Next backup time',
	'AUTO_DB_BACKUP_TIME_EXPLAIN'			=> 'Specify when a following database backup should be made.<br><strong>Note</strong>: you must specify a time in the future.',
	'AUTO_DB_BACKUP_TIME_ERROR'				=> 'The <em>next backup time</em> is incorrect. The time has to be defined in the future.',
	'AUTO_DB_BACKUP_HOUR'					=> 'Hour',
	'AUTO_DB_BACKUP_MINUTE'					=> 'Minute',
));
