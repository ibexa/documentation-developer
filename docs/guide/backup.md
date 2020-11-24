# Backup 

You should always make sure that your solution is properly backed up. The following example shows you how to do this on a Linux-UNIX-based system where [[= product_name =]] is using a MySQL database called "example". You should shut down Platform if it's running before making a backup or an upgrade.

!!! note "Externally stored assets"

    If you store assets in any external service or localization, you should back them up before proceeding.

1\. Navigate into the [[= product_name =]] directory:
 
```
cd /path/to/ezplatform
```
 
2\. Clear all caches:

```
var/cache/*
var/logs/*
```

3\. Create a dump of the database:
 
```
# MySQL
mysqldump -u <database_user> --add-drop-table <database_name> > db_backup.sql

# PostgreSQL
pg_dump -c --if-exists <database_name> > db_backup.sql
```

4\. In parent directory create a tar archive of the files (including the DB dump) using the "tar" command:

```
tar cfz backup_of_ezplatform.tar.gz ezplatform
```

At this point, the file `backup_of_ezplatform.tar.gz` should contain a backup of DB and files.
