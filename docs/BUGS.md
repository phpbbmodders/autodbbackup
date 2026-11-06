# Bugs

## Reports from the extension audit

### Scheduled backups and retention stopped

**Status: Not reproduced locally.** The task appeared in phpBB 3.3.19's ready
list. Direct cron CLI invocation completed extraction and cleanup on disposable
SQLite boards running phpBB 3.3.19 and 4.0.0-a3-dev. The affected board's cron
invocation, scheduling settings, and logs are still needed to diagnose why its
backups stopped. [Original report](https://www.phpbb.com/customise/db/extension/auto_database_backup_2/support/topic/256063)
