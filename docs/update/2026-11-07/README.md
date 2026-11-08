# Auto Database Backup update, 11/07/2026

Screenshots for the 2.2.0-dev development build, taken on phpBB 3.3.19 with phpbb-release-tools' `screenshots.py`. The full set is in the [screenshot gallery](../../images/screenshots/README.md).

## Hourly schedule and custom backup directory

The backup frequency can be set in hours or days, and backups can go to a private directory outside the web root. Here: a backup every 6 hours, kept in `/var/backups/phpbb`.

[<img src="autodbbackup-update-settings.png" width="640" height="450" alt="Auto Database Backup settings with a frequency of 6 hours and the backup directory set to /var/backups/phpbb." />](autodbbackup-update-settings.png)

## Directory checks

The settings page refuses a directory inside the board or web root, open to other users, a symbolic link, or longer than 255 characters.

[<img src="autodbbackup-update-directory-error.png" width="640" height="450" alt="Settings page warning that the backup directory must be an existing private absolute directory outside the web root." />](autodbbackup-update-directory-error.png)
