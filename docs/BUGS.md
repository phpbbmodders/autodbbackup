# Bugs

## Reports from the extension audit

### Scheduled backups and retention stopped

Reported in August 2026. Check whether the task becomes runnable, acquires its lock and reaches extraction and cleanup. [Source](https://www.phpbb.com/customise/db/extension/auto_database_backup_2/support/topic/256063)

### Retention can select unrelated stored files

Source finding. Cleanup selects archives by extension, sorts by access time and ignores unlink failures. Check backup ownership, ordering and error reporting with a disposable store. [Source](https://github.com/phpbbmodders/autodbbackup/blob/f0a65467ac433b273d05daade49c0c430d42fece/cron/task/auto_db_backup.php#L115)
