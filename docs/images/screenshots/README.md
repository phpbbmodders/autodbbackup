# Auto Database Backup screenshots

Taken on phpBB 3.3.19 with SQLite, so the MySQL-only optimize setting is not offered.

## ACP settings

**ACP → Maintenance → Database → Auto Database Backup**, set to make a gzip backup every day and keep the newest seven.

[<img src="autodbbackup-acp-settings.png" width="640" height="451" alt="Auto Database Backup settings page with backups enabled, gzip file type, a frequency of 1 day, 7 stored backups and the next backup time." />](autodbbackup-acp-settings.png)

## ACP Restore

Automatic backups appear in phpBB's own **ACP → Maintenance → Restore** list, next to manual ones.

[<img src="autodbbackup-acp-restore.png" width="640" height="176" alt="phpBB Restore page listing two backups made by the extension." />](autodbbackup-acp-restore.png)
