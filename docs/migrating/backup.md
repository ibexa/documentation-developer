# Backup 

You should always make sure that the current solution is properly backed up. In other words, you should create a copy of the entire eZ Platform directory and the database. The following example shows how this can be done on a Linux/UNIX based system where eZ Platform is using a MySQL database called "example". Note that the system should be closed for access during backups and upgrades.

/1. Navigate into the eZ Platform directory:
 
 ```
$ cd /path/to/ez_platform
```

/2. Unclusterize or backup the NFS folder.
 
/3. Clear all caches:

```
$ var/cache/*
$ var/logs/*
$ var/<var_dir>/logs/*
$ var/<var_dir>/cache/*
```

/4. Create a dump of the database:
 
 ```
$ mysqldump -u root --add-drop-table example > db_backup.sql
```

/5. In parent directory create a tape archive of the files (including the DB dump) using the "tar" command:

```
$ tar cfz backup_of_ez_publish.tar.gz ez_publish
```

 At this point, the file "backup_of_ez_publish.tar.gz" should contain a backup of everything (both files and DB).

## Consistency checks

The administration interface makes it possible to quickly check whether the current installation is in a consistent state or not. This can be done using the "Upgrade check" section of the "Setup" part. There are two checks that can be run:

- File consistency check
- Database consistency check
 
### File consistency check

The file consistency tool checks if you have altered any of the files that came with the current installation. If this is the case, then the altered files should be backed up before the system is upgraded because they will most likely be overwritten by new versions. Make sure that you backup and then merge in your custom changes into the new versions of the files.

### Database consistency check

The database consistency feature checks if the current database is consistent with the database schema that came with the eZ Platform distribution that is currently running. If there are any inconsistencies, the system will suggest the necessary SQL statements that should be ran in order to bring the database into a consistent state. Make sure that the database is backed up and run the suggested SQL statements before upgrading.

!!! note 

    If your installation does not have the eZ Network installed, you will get an error message about database inconsistency. This is to be expected and the error message will disappear as soon as the eZ Network is installed.

!!! note 

    If using cluster with the same database as eZ Platform then you will get error message about database inconsistency (specifically: ezdbfile* or ezdfsfile tables). This is a known issue with database inconsistency check combined with clustering, and can safely be ignored. To avoid this you can install cluster tables in a separate database, and make sure this is reflected in config.php and file.ini settings, see (Clustering section)[../guide/clustering] for generic information about how to install cluster.
    