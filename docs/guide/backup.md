# Backup 

You should always make sure that your solution is properly backed up. The following example shows you how to do this on a Linux-UNIX-based system where eZ Platform is using a MySQL database called "example". You should shut down Platform if it's running before making a backup or an upgrade.

!!! note "Externally stored assets"

    If you store assets in any external service or localization, you should back them up before proceeding.

1\. Navigate into the eZ Platform directory:
 
```
cd /path/to/ezplatform
```

2\. Unclusterize or backup the NFS folder.
 
3\. Clear all caches:

```
var/cache/*
var/logs/*
var/<var_dir>/logs/*
var/<var_dir>/cache/*
```

4\. Create a dump of the database:
 
```
mysqldump -u root --add-drop-table example > db_backup.sql
```

5\. In parent directory create a tar archive of the files (including the DB dump) using the "tar" command:

```
tar cfz backup_of_ezplatform.tar.gz ezplatform
```

At this point, the file `backup_of_ezplatform.tar.gz` should contain a backup of DB and files.

## Consistency checks

You can check if your installation is in a consistent state by running below checks from the "Upgrade check" section of the "Setup".
 
### File consistency check

This tool checks for any alterations in files that came with the eZ Platform installation. You should back up those files before the system upgrade because they will be overwritten by the new versions. After upgrade you can merge changed files into the new version.

### Database consistency check

This feature checks if the database is consistent with the schema that came with the current eZ Platform distribution. The system will suggest the necessary SQL statements to run in order to bring the database into a consistent state. Make sure that the database is backed up and run the suggested SQL statements before upgrading.

!!! note "eZ Network"

    If your installation does not have the eZ Network installed, you will get an error message about database inconsistency. This is to be expected and the error message will disappear as soon as the eZ Network is installed.

!!! note "Cluster"

    If you are using a cluster with the same database as eZ Platform then you will get an error message about database inconsistency (specifically: `ezdbfile` or `ezdfsfile` tables). This is a known issue with database inconsistency check combined with clustering, and can safely be ignored. To avoid this you can install cluster tables in a separate database, and make sure this is reflected in config.php and file.ini settings, see [Clustering section](clustering.md) for generic information about how to install cluster.
    