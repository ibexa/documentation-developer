---
description: Periodically back up your Repository information by making a database backup.
---

# Backup

You should always make sure that your solution is properly backed up.
The following example shows you how to do this on a Linux-UNIX-based system.
You should shut down the [[= product_name =]] if it's running before making a backup.

!!! note "Externally stored assets"

    If you store assets in any external service or localization, you should back them up before proceeding.

1\. Navigate into the [[= product_name =]] directory:

```bash
cd /path/to/ibexa
```

2\. Clear all caches:

``` bash
rm -rf var/cache/*
rm -rf var/share/*
rm -rf var/logs/*
```

3\. Create a dump of the database:

=== "MySQL"

    ``` bash
    mysqldump -u <database_user> --add-drop-table <database_name> > db_backup.sql
    ```

=== "PostgreSQL"

    ``` bash
    pg_dump -c --if-exists <database_name> > db_backup.sql
    ```

4\. In parent directory create a tar archive of the files (including the database dump) using the "tar" command:

```bash
tar cfz backup_of_ibexa.tar.gz ibexa
```

At this point, the file `backup_of_ibexa.tar.gz` should contain a backup of database and files.
