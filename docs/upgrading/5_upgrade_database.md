# 5. Upgrade the database

Apply the following database update script:

`mysql -u <username> -p <password> <database_name> < upgrade/db/mysql/ezplatform-2.5.latest-to-3.0.0.sql`

or for PostgreSQL:

`psql <database_name> < upgrade/db/postgresql/ezplatform-2.5.latest-to-3.0.0.sql`

### Solr configuration

If you use Solr as a search engine, make sure that Solr configuration is set to commit Solr index changes directly on Repository updates.
For more information, see [Solr configuration](../guide/search/solr/#further-configuration).

!!! dxp

    ### Site Factory upgrade

    For production, it is recommended that you create the `ezsite` and `ezsite_public_access` tables and manually importing their schema definitions.
    
    For MySQL:
    
    ```sql
    DROP TABLE IF EXISTS `ezsite`;
    
    CREATE TABLE `ezsite` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
      `created` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    
    --
    --
    
    DROP TABLE IF EXISTS `ezsite_public_access`;
    
    CREATE TABLE `ezsite_public_access` (
      `public_access_identifier` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
      `site_id` int(11) NOT NULL,
      `site_access_group` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
      `status` int(11) NOT NULL,
      `config` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
      `site_matcher_host` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
      PRIMARY KEY (`public_access_identifier`),
      KEY `ezsite_public_access_site_id` (`site_id`),
      CONSTRAINT `fk_ezsite_public_access_site_id` FOREIGN KEY (`site_id`) REFERENCES `ezsite` (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```
    
    For PostgreSQL:
    
    ```sql
    DROP TABLE IF EXISTS ezsite;
    
    CREATE SEQUENCE ezsite_seq;
    
    CREATE TABLE ezsite (
      id int NOT NULL DEFAULT NEXTVAL ('ezsite_seq'),
      name varchar(255) NOT NULL DEFAULT '',
      created int NOT NULL,
      PRIMARY KEY (id)
    ) ;
    
    --
    --
    
    DROP TABLE IF EXISTS ezsite_public_access;
    
      CREATE TABLE ezsite_public_access (
      public_access_identifier varchar(255) NOT NULL,
      site_id int NOT NULL,
      site_access_group varchar(255) NOT NULL DEFAULT '',
      status int NOT NULL,
      config text NOT NULL,
      site_matcher_host varchar(255) DEFAULT NULL,
      PRIMARY KEY (public_access_identifier),
      CONSTRAINT fk_ezsite_public_access_site_id FOREIGN KEY (site_id) REFERENCES ezsite (id)
    ) ;
    
    CREATE INDEX ezsite_public_access_site_id ON ezsite_public_access (site_id);
    ```

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
