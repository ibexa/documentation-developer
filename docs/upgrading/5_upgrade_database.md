# 5. Upgrade the database

Apply the following database update script:

`mysql -u <username> -p <password> <database_name> < upgrade/db/mysql/ezplatform-2.5.latest-to-3.0.0.sql`

or for PostgreSQL:

`psql <database_name> < upgrade/db/postgresql/ezplatform-2.5.latest-to-3.0.0.sql`

!!! dxp

    ### Date-based publisher database update

    Apply the following database update script for the Date-based publisher.

    For MySQL:

    ``` sql
    BEGIN;
    ALTER TABLE  `ezdatebasedpublisher_scheduled_version`
    CHANGE COLUMN `publication_date` `date` INT(11) NOT NULL;
    ALTER TABLE  `ezdatebasedpublisher_scheduled_version`
    ADD COLUMN `action` VARCHAR(32);
    UPDATE `ezdatebasedpublisher_scheduled_version` SET `action` = 'publish';
    ALTER TABLE  `ezdatebasedpublisher_scheduled_version` CHANGE COLUMN `action` `action` VARCHAR(32) NOT NULL;
    COMMIT;
    ```

    For PostgreSQL:

    ``` sql
    BEGIN;
    ALTER TABLE ezdatebasedpublisher_scheduled_version RENAME COLUMN publication_date TO date;
    ALTER TABLE ezdatebasedpublisher_scheduled_version ADD COLUMN action VARCHAR(32);
    UPDATE ezdatebasedpublisher_scheduled_version SET action = 'publish';
    ALTER TABLE ezdatebasedpublisher_scheduled_version ALTER COLUMN action SET NOT NULL ;
    COMMIT;
    ```