Apply the following database update script:

### Ibexa DXP

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ezplatform-2.5-to-ibexa-3.3.0.sql
    ```

=== "PosgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ezplatform-2.5-to-ibexa-3.3.0.sql
    ```

If you are updating from an installation based on the `ezsystems/ezplatform-ee` metarepository,
run the following command to upgrade your database:

``` bash
php bin/console ibexa:upgrade
```

!!! caution

    You can only run this command once.

Check the Location ID of the "Components" Content item and set it as a value of the `content_tree_module.contextual_tree_root_location_ids` key in `config/ezplatform.yaml`:

```
- 60 # Components
```

If you are upgrading between [[= product_name_com =]] versions,
add the `content/read` Policy with the Owner Limitation set to `self` to the "Ecommerce registered users" Role.

### Ibexa Open Source

If you are upgrading to Ibexa Open Source v3.3 and have no access to `ibexa/installer` package, run the following SQL commands:

=== "MySQL"

    ``` sql
    START TRANSACTION;
    DELETE FROM `ezsite_data` WHERE `name` IN ('ezpublish-version', 'ezpublish-release', 'ezplatform-release');
    INSERT INTO ezsite_data (`name`, `value`) VALUES ('ibexa-release', '3.3');
    COMMIT;

    ALTER TABLE `ezcontentclass_attribute` MODIFY `data_text1` VARCHAR(255);
    ALTER TABLE `ezcontentclass_attribute` ADD COLUMN `is_thumbnail` BOOLEAN NOT NULL DEFAULT false;

    ALTER TABLE `ezkeyword_attribute_link`
        ADD COLUMN `version` INT(11) DEFAULT '0',
        ADD KEY `ezkeyword_attr_link_oaid_ver` (`objectattribute_id`, `version`);
    UPDATE `ezkeyword_attribute_link`
        SET `version` = COALESCE(
        (
            SELECT `current_version`
            FROM `ezcontentobject_attribute` AS `a`
            JOIN `ezcontentobject` AS `c`
                ON `a`.`contentobject_id` = `c`.`id` AND `a`.`version` = `c`.`current_version`
            WHERE `a`.`id` = `ezkeyword_attribute_link`.`objectattribute_id`
        ), 0);
    ALTER TABLE `ezkeyword_attribute_link` MODIFY `version` INT(11) NOT NULL DEFAULT '0';

    UPDATE `ezcontentclass_attribute`
        SET `data_text2` = '^[^@]+$'
    WHERE `data_type_string` = 'ezuser' AND `data_text2` IS NULL;

    UPDATE `ezuser`
        SET `email` =
            CASE
                WHEN `contentobject_id` = 10 THEN 'anonymous@link.invalid'
                WHEN `contentobject_id` = 14 THEN 'admin@link.invalid'
            END
        WHERE `contentobject_id` IN (10, 14) AND `email` IN ('nospam@ibexa.co', 'nospam@ez.no');

    DROP TABLE IF EXISTS `ibexa_setting`;
    CREATE TABLE `ibexa_setting` (
        `id`            int(11)                                     NOT NULL AUTO_INCREMENT,
        `group`         varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
        `identifier`    varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
        `value`         text COLLATE utf8mb4_unicode_520_ci         NOT NULL,
        PRIMARY KEY (`id`),
        UNIQUE KEY `ibexa_setting_group_identifier` (`group`, `identifier`)
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_520_ci;

    UPDATE ezcontentobject_attribute
        SET data_text=NULL
    WHERE data_type_string='ezimageasset'
        AND data_text IN ('null', '{"destinationContentId":null,"alternativeText":"null"}');
    ```

=== "PostgreSQL"

    ``` sql
    START TRANSACTION;
    DELETE FROM "ezsite_data" WHERE "name" IN ('ezpublish-version', 'ezpublish-release', 'ezplatform-release');
    INSERT INTO "ezsite_data" ("name", "value") VALUES ('ibexa-release', '3.3');
    COMMIT;

    ALTER TABLE "ezcontentclass_attribute" ALTER COLUMN "data_text1" TYPE varchar(255);
    ALTER TABLE "ezcontentclass_attribute" ADD "is_thumbnail" boolean DEFAULT false NOT NULL;

    ALTER TABLE "ezkeyword_attribute_link" ADD COLUMN "version" INT;
    UPDATE "ezkeyword_attribute_link"
        SET "version" = COALESCE(
        (
            SELECT "current_version"
            FROM "ezcontentobject_attribute" AS a
            JOIN "ezcontentobject" AS c
                ON a.contentobject_id = c.id AND a.version = c.current_version
            WHERE a.id = ezkeyword_attribute_link.objectattribute_id
        ), 0);
    ALTER TABLE "ezkeyword_attribute_link" ALTER COLUMN "version" SET NOT NULL;
    CREATE INDEX "ezkeyword_attr_link_oaid_ver" ON "ezkeyword_attribute_link" ("objectattribute_id", "version");

    UPDATE "ezcontentclass_attribute"
        SET "data_text2" = '^[^@]+$'
    WHERE "data_type_string" = 'ezuser' AND "data_text2" IS NULL;

    UPDATE "ezuser"
        SET "email" =
            CASE
                WHEN "contentobject_id" = 10 THEN 'anonymous@link.invalid'
                WHEN "contentobject_id" = 14 THEN 'admin@link.invalid'
            END
    WHERE "contentobject_id" IN (10, 14) AND "email" IN ('nospam@ibexa.co', 'nospam@ez.no');

    DROP TABLE IF EXISTS "ibexa_setting";
    CREATE TABLE "ibexa_setting" (
        "id" SERIAL NOT NULL,
        "group" varchar(128) NOT NULL,
        "identifier" varchar(128) NOT NULL,
        "value" json NOT NULL,
        PRIMARY KEY ("id"),
        CONSTRAINT "ibexa_setting_group_identifier" UNIQUE ("group", identifier)
    );

    UPDATE ezcontentobject_attribute
        SET data_text=NULL
    WHERE data_type_string='ezimageasset'
        AND data_text IN ('null', '{"destinationContentId":null,"alternativeText":"null"}');
    ```
