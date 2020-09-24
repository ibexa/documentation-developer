# 4.9. Upgrade Site Factory

!!! enterprise

    For production, it is recommended to create the `ezsite` and `ezsite_public_access` tables manually importing their schemas definition:
    
    ??? "Table structure for table `ezsite` and `ezsite_public_access` (MySQL)"
    
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
    
    ??? "Table structure for table `ezsite` and `ezsite_public_access` (PostgreSQL)"
    
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
