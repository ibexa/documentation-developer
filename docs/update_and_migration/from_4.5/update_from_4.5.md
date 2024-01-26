# Update from v4.5.x to v4.6

This update procedure applies if you are using a v4.4 installation.

## Update from v4.5.x to v4.5.latest

Before you update to v4.6, you need to go through the following steps to update to the latest maintenance release of v4.5 (v[[= latest_tag_4_5 =]]).

### Update the application to v4.5.latest

TODO

## Update from v4.5.latest to v4.6

When you have the latest version of v4.5, you can update to v4.6.

### Update the application

TODO

### Update the database

Next, update the database.

[[% include 'snippets/update/db/db_backup_warning.md' %]]

Apply the following database update scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.5.latest-to-4.6.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.5.latest-to-4.6.0.sql
    ```
