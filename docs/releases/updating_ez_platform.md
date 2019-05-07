# Updating eZ Platform


This page explains how to update eZ Platform to a new version.

In the instructions below, replace `<version>` with the version of eZ Platform you are updating to (for example: `v1.7.0`). If you are testing a release candidate, use the latest rc tag (for example: `v1.7.1-rc1`).

## Update procedure

## 1. Check out a tagged version

**1.1.** From the project's root, create a new branch from the project's "master", or from the branch you're updating on:

**From your master branch, create a branch for handling update changes**

``` bash
git checkout -b <branch_name>
```

This creates a new project branch for the update based on your current project branch, typically `master`. An example `<branch_name>` would be `update-1.4`.

**1.2.** If it's not there, add `ezsystems/ezplatform` as an "upstream" remote
(on an Enterprise installation use `ezsystems/ezplatform-ee`, and on an eZ Commerce installation, `ezsystems/ezcommerce`):

**From your new update branch**

``` bash hl_lines="1 3 5"
git remote add upstream http://github.com/ezsystems/ezplatform.git
or
git remote add upstream http://github.com/ezsystems/ezplatform-ee.git
or
git remote add upstream http://github.com/ezsystems/ezcommerce.git
```

**1.3.** Prepare for pulling changes

??? note "Adding `sort-packages` option when updating from <=1.7.8, 1.13.4, 2.2.3, 2.3.2"

    To reduce the number of conflicts in the future, [EZP-29835](https://jira.ez.no/browse/EZP-29835) adds a setting to
    Composer to make it sort packages listed in `composer.json`. If you don't already do this, you should prepare for
    this update to make it clearer which changes you introduce.

    Assuming you have installed packages on your installation (`composer install`), do the following steps:

    1. Add [sort-packages](https://getcomposer.org/doc/06-config.md#sort-packages) to the `config` section in `composer.json` as shown in the highlighted line:

    ``` json hl_lines="3"
    "config": {
        "bin-dir": "bin",
        "sort-packages": true,
        "preferred-install": {
            "ezsystems/*": "dist"
        }
    },
    ```

    2. Use `composer require` to get Composer to sort your packages:

    With this new option you should ideally always use `composer require` to add or adjust packages to make sure they
    are sorted. The following code example updates a few requirements with what you can also expect in the upcoming
    change:

    ``` bash hl_lines="1 2 4"
    composer require --no-scripts --no-update doctrine/doctrine-bundle:^1.9.1
    composer require --dev --no-scripts --no-update  behat/behat:^3.5.0
    # The upcoming change also moves security-advisories to dev as advised by the package itself
    composer require --dev --no-scripts --no-update roave/security-advisories:dev-master
    ```

    3. Check that you can install/update packages:

    ``` bash
    composer update
    ```

    You can consider the result a success if Composer says there were no updates, or if it updated packages without stopping with conflicts.

    4. Now that packages are sorted, save your work.

    With packages sorted you are ready to pull in changes
    As they will also be sorted, it will be easier to see which changes are relevant to your `composer.json`.

    ``` bash
    git commit -am "Sort my existing composer packages in anticipation of update with sorted merge"
    ```

**1.4.** Then pull the tag into your branch.

If you are unsure which version to pull, run `git ls-remote --tags` to list all possible tags.

**From your new update branch**

``` bash
git pull upstream <version>
```

!!! tip

    Don't forget the `v` here, you want to pull the tag `<version>` and not the branch `<version>` (i.e: `v1.11.0`, and NOT `1.11.0` or `1.10` which is dev branch).

At this stage you may get conflicts, which are a normal part of the procedure and no reason to worry. The most common ones will be on `composer.json` and `composer.lock`.

The latter can be ignored, as it will be regenerated when we execute `composer update` later. The easiest is to checkout the version from the tag and add it to the changes:

If you get a **lot** of conflicts (on the `doc` folder for instance), and eZ Platform was installed from the [ezplatform.com](https://ezplatform.com) or [support.ez.no](https://support.ez.no) (for Enterprise and eZ Commerce) tarball, it might be because of incomplete history. You will have to run `git fetch upstream --unshallow` to load the full history, and run the merge again.

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

!!! note "Sorted packages since 2.4 changes"

    Since 2.4 packages in `composer.json` are sorted, which means more conflicts when updating to 2.4, but far fewer conflicts in the future. This is controlled by [sort-packages](https://getcomposer.org/doc/06-config.md#sort-packages) config in `composer.json`.

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

!!! note "Updating from <2.5"

    Since v2.5 eZ Platform uses [Webpack Encore](https://symfony.com/doc/3.4/frontend.html#webpack-encore) for asset management.
    You need to install [Node.js](https://nodejs.org/en/) and [Yarn](https://yarnpkg.com/lang/en/docs/install) to update to this version.

    In v2.5 it is still possible to use Assetic, like in earlier versions.
    However, if you are using the latest Bootstrap version, [`scssphp`](https://github.com/leafo/scssphp)
    will not compile correctly with Assetic.
    In this case, use Webpack Encore. See [Importing assets from a bundle](../guide/bundles.md#importing-assets-from-a-bundle) for more information.

!!! caution "Common errors"

    If you experienced issues during the update, please check [Common errors](../getting_started/troubleshooting.md#cloning-failed-using-an-ssh-key) section on the Composer about page.

## 4. Update database

Some versions require updates to the database. Look through [the list of database update scripts](https://github.com/ezsystems/ezpublish-kernel/tree/master/data/update/mysql) for a script for the version you are updating to (database version numbers correspond to the `ezpublish-kernel` version).

??? note "Updating from <1.7"

    ### Updating from <1.7

    Apply the following database update script:

    `mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.7.7-to-6.7.8.sql`

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

??? note "Updating from <1.13"

    ### Updating from <1.13

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

    ##### Run general database update script

    Apply the following database update script:

    `mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.13.3-to-6.13.4.sql`

??? note "Updating from <2.2"

    ### Updating from <2.2

    ##### Change from UTF8 to UTF8MB4

    Since v2.2 the character set for MySQL/MariaDB database tables changes from `utf8` to `utf8mb4` to support 4-byte characters.

    To apply this change, use the following database update script:

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.1.0-to-7.2.0.sql
    ```

    If you use DFS Cluster, also execute the following database update script:

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

    !!! enterprise

        To update to v2.2, you need to run a script to add database tables for the Page Builder.
        You can find it in https://github.com/ezsystems/ezplatform-ee-installer/blob/2.2/Resources/sql/schema.sql#L58

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

    !!! tip

        This script will use the layout defined in your Landing Page.
        To migrate successfully, you need to copy your zone configuration
        from `ez_systems_landing_page_field_type` under `ezplatform_page_fieldtype` in the new config.
        Otherwise the script will encounter errors.


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
        - { name: ezplatform.fieldtype.ezlandingpage.migration.attribute.converter, block_type: my_block_type_identifier }
    ```

    Custom converters must implement the `\EzSystems\EzPlatformPageMigration\Converter\AttributeConverter\ConverterInterface` interface.
    `convert()` will parse XML `\DOMNode $node` and return an array of `\EzSystems\EzPlatformPageFieldType\FieldType\LandingPage\Model\Attribute` objects.

??? note "Updating from <2.3"

    ### Updating from <2.3

    Apply the following database update script:

    `mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.2.0-to-7.3.0.sql`

    ##### Trashed timestamp

    A new timestamp column has been added in order to keep track of when items were trashed, this is exposed in the API but not yet in UI.

    To apply this change, use the following database update script:

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.2.0-to-7.3.0.sql
    ```

    ##### Form builder

    !!! enterprise

        To create the "Forms" container under the content tree root use the following command:

        ``` bash
        php bin/console ezplatform:form-builder:create-forms-container
        ```

        You can also specify Content Type, Field values and language code of the container, e.g.:

        ``` bash
        php bin/console ezplatform:form-builder:create-forms-container --content-type custom --field title --value 'My Forms' --field description --value 'Custom container for the forms' --language-code eng-US
        ```

        You also need to run a script to add database tables for the Form Builder.
        You can find it in https://github.com/ezsystems/ezplatform-ee-installer/blob/2.3/Resources/sql/schema.sql#L136

        !!! caution "Form (ezform) Field Type"

            After the update, in order to create forms, you have to add a new Content Type (e.g. named "Form") that contains `Form` Field (this Content Type can contain other fields
            as well). After that you can use forms inside Landing Pages via Embed block.

??? note "Updating from <2.4"

    ### Updating from <2.4

    !!! enterprise

        #### Workflow

        When updating an Enterprise installation, you need to run a script to add database tables for the Editorial Workflow.
        You can find it in https://github.com/ezsystems/ezplatform-ee-installer/blob/2.4/Resources/sql/schema.sql#L198

        #### Changes to the Forms folder

        The built-in Forms folder is located in the Form Section in versions 2.4+.

        If you are updating your installation, you need to add this Section manually and move the folder to it.

        To allow anonymous users to access Forms, you also need to add the `content/read` Policy
        with the "Form" Section to the Anonymous User.

    #### Custom tag configuration

    v2.4 changed the way of configuring custom tags. They are no longer configured under the `ezpublish` key,
    but one level higher in the YAML structure:

    ``` yaml
    ezpublish:
        system:
            <siteaccess>:
                fieldtypes:
                    ezrichtext:
                        custom_tags: [exampletag]

    ezrichtext:
        custom_tags:
            exampletag:
                # ...
    ```

    The old configuration is deprecated, so if you use custom tags, you need to modify your config accordingly.

!!! note "Updating from <2.5"

    ### Updating from <2.5

    Apply the following database update script:

    `mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.4.0-to-7.5.0.sql`

    #### Changes to database schema

    The introduction of [support for PostgreSQL](../guide/databases.md#using-postgresql) includes a change in the way database schema is generated.

    It is now created based on [YAML configuration](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/config/storage/legacy/schema.yaml), using the new [`DoctrineSchemaBundle`](https://github.com/ezsystems/doctrine-dbal-schema).

    If you are updating your application according to the usual procedure, no additional actions are required.
    However, if you do not update your meta-repository, you need to take two additional steps:

    - enable `EzSystems\DoctrineSchemaBundle\DoctrineSchemaBundle()` in `AppKernel.php`
    - add [`ez_doctrine_schema`](https://github.com/ezsystems/ezplatform/blob/master/app/config/config.yml#L33) configuration

    #### Changes to Matrix Field Type

    To migrate your content from legacy XML format to a new `ezmatrix` value use the following command:

    ```bash
    bin/console ezplatform:migrate:legacy_matrix
    ```

    #### Required manual cache clearing if using Redis

    If you are using Redis as your persistence cache storage you should always clear it manually after an upgrade.
    You can do it in two ways, by using `redis-cli` and executing the following command:

    ```bash
    FLUSHALL
    ```

    or by executing the following command:

    ```bash
    bin/console cache:pool:clear cache.redis
    ```

## 5. Dump assets

The web assets must be dumped again if you are using the `prod` environment. In `dev` this happens automatically:

``` bash
php bin/console assetic:dump -e prod
yarn install
yarn encore prod
```

If you encounter problems, additionally clear the cache and install assets:

``` bash
php bin/console cache:clear -e prod
php bin/console assets:install --symlink -e prod
php bin/console assetic:dump -e prod
yarn install
yarn encore prod
```

## 6. Commit, test and merge

Once all the conflicts have been resolved, and `composer.lock` updated, the merge can be committed. Note that you may or may not keep `composer.lock`, depending on your version management workflow. If you do not wish to keep it, run `git reset HEAD <file>` to remove it from the changes. Run `git commit`, and adapt the message if necessary. You can now verify the project and once the update has been approved, go back to `master`, and merge your update branch:

``` bash
git checkout master
git merge <branch_name>
```

**Your eZ Platform should now be up-to-date with the chosen version!**
