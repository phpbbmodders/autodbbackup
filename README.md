# phpBB Auto Database Backup

This is the repository for the development of the phpBB Auto Database Backup Extension.

[![Build Status](https://github.com/rmcgirr83/autodbbackup/workflows/Tests/badge.svg)](https://github.com/rmcgirr83/autodbbackup/actions)

## Quick Install

1. [Download the latest release](https://github.com/RMcGirr83/autodbbackup).
2. Unzip the downloaded release, and change the name of the folder to `autodbbackup`.
3. In the `ext` directory of your phpBB board, create a new directory named `pico` (if it does not already exist).
4. Copy the `autodbbackup` folder to `phpBB/ext/pico/`.
5. Navigate in the ACP to `Customise -> Manage extensions`.
6. Look for `Auto Database Backup` under the Disabled Extensions list, and click its `Enable` link.
7. Set up and configure `Auto Database Backup` by navigating in the ACP to `Maintenance` -> `Database` -> `Auto backup settings`.

## Backup retention

The copies setting applies to automatic backups created with the current naming
format. Older and manual backups are kept for manual review and removal. New
automatic backups appear in ACP Restore on phpBB 3.3 and 4.0.

## Uninstall

1. Navigate in the ACP to `Customise -> Extension Management -> Extensions`.
2. Look for `Auto Database Backup` under the Enabled Extensions list, and click its `Disable` link.
3. To permanently uninstall, click `Delete Data` and then delete the `/ext/pico/autodbbackup` folder.

## License
[GNU General Public License v2](http://opensource.org/licenses/GPL-2.0)