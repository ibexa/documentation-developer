# Updating eZ Platform


This page explains how to update eZ Platform to a new version.

In the instructions below, replace` <version>` with the version of eZ Platform you are updating to (for example: `v1.7.0`). If you are testing a release candidate, use the [latest rc tag](https://github.com/ezsystems/ezplatform/releases) (for example: `v1.7.1-rc1`).

## Update procedure

## 1. Check out a tagged version

**1.1.** From the project's root, create a new branch from the project's master, or from the branch you're updating on:

**From your master branch**

``` bash
git checkout -b <branch_name>
```

This creates a new project branch for the update based on your current project branch, typically `master`. An example `<branch_name>` would be `update-1.4`.

**1.2.** If it's not there, add `ezsystems/ezplatform` (or `ezsystems/ezplatform-ee`, when updating an Enterprise installation) as an upstream remote:

**From your new update branch**

``` bash
git remote add ezplatform http://github.com/ezsystems/ezplatform.git
or
git remote add ezplatform-ee http://github.com/ezsystems/ezplatform-ee.git
```

**1.3.** Then pull the tag into your branch.

If you are unsure which version to pull, run `git ls-remote --tags` to list all possible tags.

**From your new update branch**

``` bash
git pull ezplatform <version>
or
git pull ezplatform-ee <version>
```

!!! tip

    Don't forget the `v` here, you want to pull the tag `<version>` and not the branch `<version>` (i.e: `v1.11.0` and not `1.11.0`).

At this stage you may get conflicts, which are a normal part of the procedure and no reason to worry. The most common ones will be on `composer.json` and `composer.lock`.

The latter can be ignored, as it will be regenerated when we execute `composer update` later. The easiest is to checkout the version from the tag and add it to the changes:

If you get a **lot** of conflicts (on the `doc` folder for instance), and eZ Platform was installed from the [share.ez.no](http://share.ez.no) tarball, it might be because of incomplete history. You will have to run `git fetch ezplatform --unshallow` (or `git fetch ezplatform-ee --unshallow`) to load the full history, and run the merge again.

**From your new update branch**

``` bash
git checkout --theirs composer.lock && git add composer.lock
```

If you do not keep a copy in the branch, you may also run:

**From your new update branch**

``` bash
git rm composer.lock
```

## 2. Merge composer.json

#### Manual merging

Conflicts in `composer.json` need to be fixed manually. If you're not familiar with the diff output, you may checkout the tag's version and inspect the changes. It should be readable for most:

**From your new update branch**

``` bash
git checkout --theirs composer.json && git diff HEAD composer.json
```

You should see what was changed, as compared to your own version, in the diff output. The update changes the requirements for all of the `ezsystems/` packages. Those changes should be left untouched. All of the other changes will be removals of what you added for your own project. Use `git checkout -p` to selectively cancel those changes:

``` bash
git checkout -p composer.json
```

Answer `no` (do not discard) to the requirement changes of `ezsystems` dependencies. Answer `yes` (discard) to removals of your changes.

Once you are done, inspect the file, either using an editor or by running `git diff composer.json`. You may also test the file's sanity with `composer validate`, and test the dependencies by running `composer update --dry-run`. (will output what it would do to dependencies, without applying the changes.

Once finished, run `git add composer.json` and commit`.`

#### Fixing other conflicts (if any)

Depending on the local changes you have done, you may get other conflicts on configuration files, kernel, etc.

There shouldn't be many, and you should be able to figure out which value is the right one for all of them:

-   Edit the file, and identify the conflicting changes. If a setting you have modified has also been changed by us, you should be able to figure out which value is the right one.
-   Run `git add conflicting-file` to add the changes

## 3. Update the app

At this point, you should have a `composer.json` file with the correct requirements. Run `composer update` to update the dependencies. 

``` bash
composer update
```

If you want to first test how the update proceeds without actually updating any packages, you can try the command with the `--dry-run` switch:

`composer update --dry-run`

??? note "When updating from <1.13"

    ##### Adding EzSystemsPlatformEEAssetsBundle

    !!! enterprise "EZ ENTERPRISE"

        When upgrading to v1.10, you need to enable the new `EzSystemsPlatformEEAssetsBundle` by adding:

        `new EzSystems\PlatformEEAssetsBundle\EzSystemsPlatformEEAssetsBundle(),`

        in `app/AppKernel.php`.

!!! caution "Common errors"

    If you experienced issues during the update, please check [Common errors](../getting_started/troubleshooting.md#cloning-failed-using-an-ssh-key) section on the Composer about page.

## 4. Update database

Some versions require updates to the database. Look through [the list of database update scripts](https://github.com/ezsystems/ezpublish-kernel/tree/master/data/update/mysql) for a script for the version you are updating to (database version numbers correspond to the `ezpublish-kernel` version). If you find one, apply it like this:

`mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.7.0-to-6.8.0.sql`

??? note "When updating from <1.7"

    ##### Solr index time boosting

    Solr Bundle v1.4 introduced among other things index time boosting feature, this involves a slight change to the Solr scheme that will need to be applied to your config.

    To make sure indexing continues to work, apply the following change, restart Solr and reindex your content:

    ``` xml
    diff --git a/lib/Resources/config/solr/schema.xml b/lib/Resources/config/solr/schema.xml
    index 49a17a9..80c4cd7 100644
    --- a/lib/Resources/config/solr/schema.xml
    +++ b/lib/Resources/config/solr/schema.xml
    @@ -92,7 +92,7 @@ should not remove or drastically change the existing definitions.
         <dynamicField name="*_s" type="string" indexed="true" stored="true"/>
         <dynamicField name="*_ms" type="string" indexed="true" stored="true" multiValued="true"/>
         <dynamicField name="*_l" type="long" indexed="true" stored="true"/>
    -    <dynamicField name="*_t" type="text" indexed="true" stored="true"/>
    +    <dynamicField name="*_t" type="text" indexed="true" stored="true" multiValued="true" omitNorms="false"/>
         <dynamicField name="*_b" type="boolean" indexed="true" stored="true"/>
         <dynamicField name="*_mb" type="boolean" indexed="true" stored="true" multiValued="true"/>
         <dynamicField name="*_f" type="float" indexed="true" stored="true"/>
    @@ -104,13 +104,6 @@ should not remove or drastically change the existing definitions.
         <dynamicField name="*_c" type="currency" indexed="true" stored="true"/>

         <!--
    -      Full text field is indexed through proxy fields matching '*_fulltext' pattern.
    -    -->
    -    <field name="text" type="text" indexed="true" multiValued="true" stored="false"/>
    -    <dynamicField name="*_fulltext" type="text" indexed="false" multiValued="true" stored="false"/>
    -    <copyField source="*_fulltext" dest="text" />
    -
    -    <!--
           This field is required since Solr 4
         -->
         <field name="_version_" type="long" indexed="true" stored="true" multiValued="false" />
    ```

??? note "When updating from <1.13"

    ##### `content/publish` permission

    v1.8.0 introduced a new `content/publish` permission separated out of the `content/edit` permission. `edit` now covers only editing content, without the right to publishing it. For that you need the `publish` permission. `edit` without `publish` can be used in conjunction with the Content review workflow to ensure that a user cannot publish content themselves, but must pass it on for review.

    To make sure existing users will be able to both edit and publish content, those with the `content/edit` permission will be given the `content/publish` permission by the following database update script:

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.7.0-to-6.8.0.sql
    ```

    ##### Folder for form-uploaded files

    To complete this step you have to [dump assets](#5-dump-assets) first.

    Since v1.8 you can add a File field to the Form block on a Landing Page. Files uploaded through such a form will be automatically placed in a specific folder in the repository.

    If you are upgrading to v1.8 you need to create this folder and assign it to a new specific Section. Then, add them in the config (for example, in `app/config/default_parameters.yml`, depending on how your configuration is set up):

    ``` bash
        #Location id of the root for form uploads
        form_builder.upload_folder.location_id: <folder location id>

        #Section identifier for form uploads
        form_builder.upload_folder.section_identifier: <section identifier>
    ```

    ##### `ezsearch_return_count` table removal

    v1.11.0 removes the `ezsearch_return_count` table, which had been removed in eZ Publish legacy since 5.4/2014.11. This avoids issues which would occur when you upgrade using legacy bridge. Apply the following database update script if your installation has not had the table removed by an earlier eZ Publish upgrade:

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.10.0-to-6.11.0.sql
    ```

    ##### Increased password hash length

    v1.12.0 improves password security by introducing support for PHP's `PASSWORD_BCRYPT` and `PASSWORD_DEFAULT` hashing algorithms. By default `PASSWORD_DEFAULT` is used. This currently uses bcrypt, but this may change in the future as PHP adds support for new and stronger algorithms.
    Apply the following database update script to change the schema and enable the storage of longer passwords:
    Note that the script is available for PostgreSQL as well.

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.11.0-to-6.12.0.sql
    ```


    These algorithms produce longer hashes, and so the length of the `password_hash` column of the `ezuser` table must be increased, like this:

    **MySQL**

    ​``` sql
    ALTER TABLE ezuser CHANGE password_hash password_hash VARCHAR(255) default NULL;
    ​```


    **PostgreSQL**

    ​``` sql
    ALTER TABLE ezuser ALTER COLUMN password_hash TYPE VARCHAR(255);
    ​```

??? note "When updating from <2.2"

    ##### Change from UTF8 to UTF8MB4

    Since v2.2 the character set for MySQL/MariaDB database tables changes from `utf8` to `utf8mb4` to support 4-byte characters.

    To apply this change, use the following database update script:

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.1.0-to-7.2.0.sql
    ```

    If you use DFS, also execute the following database update script:

    ``` bash
    mysql -u <username> -p <password> <dfs_database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.1.0-to-7.2.0-dfs.sql
    ```

    Be aware that these upgrade statements may fail due to index collisions.
    This is because the indexes have been shortened, so duplicates may occur.
    If that happens, you must remove the duplicates manually, and then repeat the statements that failed.

    After successfully running those statements, change the character set and collation for each table, as described in https://github.com/ezsystems/ezpublish-kernel/blob/master/doc/upgrade/7.2.md.

    You should also change the character set that is specified in the application config:

    In `app/config/config.yml`, set the following:

    ``` yml
    doctrine:
        dbal:
            connections:
                default:
                    charset: utf8mb4
    ```
    Also make the corresponding change in `app/config/dfs/dfs.yml`.

    ##### Page builder

    To update to v2.2, you need to run the following script to add database tables for the Page Builder:

    ??? note "Database update script"

        ```
        --
        -- Page Builder
        --

        DROP TABLE IF EXISTS `ezpage_attributes`;
        CREATE TABLE `ezpage_attributes` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL DEFAULT '',
          `value` text,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        DROP TABLE IF EXISTS `ezpage_blocks`;
        CREATE TABLE `ezpage_blocks` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `type` varchar(255) NOT NULL DEFAULT '',
          `view` varchar(255) NOT NULL DEFAULT '',
          `name` varchar(255) NOT NULL DEFAULT '',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        DROP TABLE IF EXISTS `ezpage_blocks_design`;
        CREATE TABLE `ezpage_blocks_design` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `block_id` INT(11) NOT NULL,
          `style` TEXT DEFAULT NULL,
          `compiled` TEXT DEFAULT NULL,
          `class` VARCHAR(255) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        DROP TABLE IF EXISTS `ezpage_blocks_visibility`;
        CREATE TABLE `ezpage_blocks_visibility` (
          `id` INT(11) NOT NULL AUTO_INCREMENT,
          `block_id` INT(11) NOT NULL,
          `since` INT(11) DEFAULT NULL,
          `till` INT(11) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        DROP TABLE IF EXISTS `ezpage_map_attributes_blocks`;
        CREATE TABLE `ezpage_map_attributes_blocks` (
          `attribute_id` int(11) NOT NULL,
          `block_id` int(11) NOT NULL,
          PRIMARY KEY (`attribute_id`,`block_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        DROP TABLE IF EXISTS `ezpage_map_blocks_zones`;
        CREATE TABLE `ezpage_map_blocks_zones` (
          `block_id` int(11) NOT NULL,
          `zone_id` int(11) NOT NULL,
          PRIMARY KEY (`block_id`, `zone_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        DROP TABLE IF EXISTS `ezpage_map_zones_pages`;
        CREATE TABLE `ezpage_map_zones_pages` (
          `zone_id` int(11) NOT NULL,
          `page_id` int(11) NOT NULL,
          PRIMARY KEY (`zone_id`,`page_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        DROP TABLE IF EXISTS `ezpage_pages`;
        CREATE TABLE `ezpage_pages` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `version_no` int(11) unsigned NOT NULL,
          `content_id` int(11) NOT NULL,
          `language_code` varchar(255) NOT NULL DEFAULT '',
          `layout` varchar(255) NOT NULL DEFAULT '',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        DROP TABLE IF EXISTS `ezpage_zones`;
        CREATE TABLE `ezpage_zones` (
          `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(255) NOT NULL DEFAULT '',
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ```

        !!! enterprise

            When updating an Enterprise installation, you also need to run the following script due to changes in the `eznotification` table:

            ```
            ALTER TABLE `eznotification`
            CHANGE COLUMN `data` `data` BLOB NULL ;

            ALTER TABLE `eznotification`
            DROP INDEX `owner_id` ,
            ADD INDEX `eznotification_owner` (`owner_id` ASC);

            ALTER TABLE `eznotification`
            DROP INDEX `is_pending` ,
            ADD INDEX `eznotification_owner_is_pending` (`owner_id` ASC, `is_pending` ASC);
            ```

    ##### Migrate Landing Pages

    To update to v2.2 with existing Landing Pages, you need to use a dedicated script.
    The script is contained in the `ezplatform-page-migration` bundle and **works since version v2.2.2**.
    To use it:

    1. Run `composer require ezsystems/ezplatform-page-migration`
    2. Add the bundle to `app/AppKernel.php`: `new EzSystems\EzPlatformPageMigrationBundle\EzPlatformPageMigrationBundle(),`
    3. Run command `bin/console ezplatform:page:migrate`

    You can remove the bundle after the migration is complete.

    The command will migrate Landing Pages created in eZ Platform 1.x, 2.0 and 2.1 to new Pages.
    The operation is transactional and will roll back in case of errors.

    If there are missing block definitions, such as Form Block or Schedule Block,
    you have an option to continue, but migrated Landing Pages will come without those blocks.

    !!! tip

        If you use different repositories with different SiteAccesses, use the `--siteaccess` switch
        to migrate them separately.

    !!! tip

        You can use the `--dry-run` switch to test the migration.

    After the migration is finished, you need to clear cache.

    ###### Migrating custom blocks

    For block types with custom storage you need to provide a dedicated converter but for simple blocks you can use `\EzSystems\EzPlatformPageMigration\Converter\AttributeConverter\DefaultConverter` as your service class.

    You also need to redefine [YAML configuration](../guide/extending_page.md#creating-page-blocks) for your custom blocks.

    !!! caution

        Since v2.2 you no longer need to use services for custom Page Blocks, you can create them using YAML configuration.

    The service definition has to be tagged as:

    ``` yaml
    tags:
        - { name: 'ezplatform.fieldtype.ezlandingpage.migration.attribute.converter', block_type: 'my_block_type_identifier' }
    ```

    Custom converters must implement the `\EzSystems\EzPlatformPageMigration\Converter\AttributeConverter\ConverterInterface` interface.
    `convert()` will parse XML `\DOMNode $node` and return an array of `\EzSystems\EzPlatformPageFieldType\FieldType\LandingPage\Model\Attribute` objects.

!!! note "When updating from <2.3"

    ##### Form builder

    To create the "Forms" container under the content tree root use the following command:

    ``` bash
    php bin/console ezplatform:form-builder:create-forms-container
    ```

    You can also specify Content Type, Field values and language code of the container, e.g.:

    ``` bash
    php bin/console ezplatform:form-builder:create-forms-container --content-type custom --field title --value 'My Forms' --field description --value 'Custom container for the forms' --language-code eng-US
    ```

    You also need to run the following script to add database tables for the Form Builder:

    ??? note "Database update script"

        ```
        --
        -- Form Builder
        --

        DROP TABLE IF EXISTS `ezform_forms`;
        CREATE TABLE `ezform_forms` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `content_id` int(11) DEFAULT NULL,
          `version_no` int(11) DEFAULT NULL,
          `content_field_id` int(11) DEFAULT NULL,
          `language_code` varchar(16) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        DROP TABLE IF EXISTS `ezform_fields`;
        CREATE TABLE `ezform_fields` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `form_id` int(11) DEFAULT NULL,
          `name` VARCHAR(128) NOT NULL,
          `identifier` varchar(128) DEFAULT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        DROP TABLE IF EXISTS `ezform_field_attributes`;
        CREATE TABLE `ezform_field_attributes` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `field_id` int(11) DEFAULT NULL,
          `identifier` varchar(128) DEFAULT NULL,
          `value` blob,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        DROP TABLE IF EXISTS `ezform_field_validators`;
        CREATE TABLE `ezform_field_validators` (
          `id` int(11) NOT NULL AUTO_INCREMENT,
          `field_id` int(11) DEFAULT NULL,
          `identifier` varchar(128) DEFAULT NULL,
          `value` blob,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        DROP TABLE IF EXISTS `ezform_form_submissions`;
        CREATE TABLE `ezform_form_submissions` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `content_id` INT NOT NULL,
          `language_code` VARCHAR(6) NOT NULL,
          `user_id` INT NOT NULL,
          `created` INT NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

        DROP TABLE IF EXISTS `ezform_form_submission_data`;
        CREATE TABLE `ezform_form_submission_data` (
          `id` INT NOT NULL AUTO_INCREMENT,
          `form_submission_id` INT NOT NULL,
          `name` VARCHAR(128) NOT NULL,
          `identifier` VARCHAR(128) NOT NULL,
          `value` BLOB NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
        ```

    !!! caution "Form (ezform) Field Type"
    
        In eZ Platform 2.3 forms are content like everything else. After the update, in order to create forms, you have to 
        add new Content Type (e.g. named "Form") that contains `Form` field (this Content Type can contain other fields 
        as well). After that you can use forms inside Landing Pages via Embed block.

## 5. Dump assets

The web assets must be dumped again if you are using the `prod` environment. In `dev` this happens automatically:

``` bash
php bin/console assetic:dump -e prod
```

If you encounter problems, additionally clear the cache and install assets:

``` bash
php bin/console cache:clear -e prod
php bin/console assets:install --symlink -e prod
php bin/console assetic:dump -e prod
```

## 6. Commit, test and merge

Once all the conflicts have been resolved, and `composer.lock` updated, the merge can be committed. Note that you may or may not keep `composer.lock`, depending on your version management workflow. If you do not wish to keep it, run `git reset HEAD <file>` to remove it from the changes. Run `git commit`, and adapt the message if necessary. You can now verify the project and once the update has been approved, go back to `master`, and merge your update branch:

``` bash
git checkout master
git merge <branch_name>
```

**Your eZ Platform should now be up-to-date with the chosen version!**
