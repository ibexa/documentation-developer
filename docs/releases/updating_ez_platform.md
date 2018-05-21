# Updating eZ Platform


This page explains how to update eZ Platform to a new version.

In the instructions below, replace` <version>` with the version of eZ Platform you are updating to (for example: `v1.7.0`). If you are testing a release candidate, use the [latest rc tag](https://github.com/ezsystems/ezplatform/releases) (for example: `v1.7.1-rc1`).

## Version-specific steps

**Some versions introduce new features that require taking special steps; look out for colored bars with version numbers.**

If you intend to skip a version (for example, update directly from v1.3 to v1.5 without getting v1.4), remember to look at all the intermediate steps as well – this means you need to perform both the steps for v1.4 and v1.5.

## Update procedure

## 1. Prepare a branch to update your project

**1.1.** From the project's root, create a new branch from the project's master, or from the branch you're updating on:

**From your master branch**

``` bash
git checkout -b <branch_name>
```

This creates a new project branch for the update based on your current project branch, typically `master`. An example `<branch_name>` would be `update-1.4`.

**1.2.** Clone eZ Platform aside in a temporary directory.

**Clone the eZ Platform Community or Enterprise Edition**

``` bash
git clone https://github.com/ezsystems/ezplatform.git /tmp/ezplatform
or
git clone http://github.com/ezsystems/ezplatform-ee.git /tmp/ezplatform
```

**1.3.** Then checkout the tag corresponding to the version you want to update to.

If you are unsure which version to pull, run `git ls-remote --tags` to list all possible tags.

**From the temporary directory**

``` bash
cd /tmp/ezplatform
git checkout tags/<version>
```

!!! tip

    Don't forget the `v` here, you want to pull the tag `<version>` and not the branch `<version>` (i.e: `v1.11.0` and not `1.11.0`).


**1.4.** Inject the changes from the new eZ Platform version (temporary folder) to your branch created to update your project.

``` bash
rsync -avzc --exclude 'src/' --exclude 'web/var' --exclude="YOURSPECIFICS" --exclude=".idea" --delete /tmp/ezplatform <PATH_TO_YOUR_EZPLATFORM_FOLDER>
```

!!! tip

    The list of excludes is really depending on your project specifics and should be adapted. Ex: if you have eZ in a subfolder it would be
    --exclude 'ezplatform/src/' --exclude 'ezplatform/web/var' etc. etc.


## 2. Check your branch before updating to the new version

At this stage your project will be updated with the last changes coming from the new eZ Platform version. This procedure
will remove the custom configuration you have for your project specific.

No reason to worry, `git` will help. Depending on you organization and your specifics you may want to check the working branch.

 ``` bash
 git status
 ```

 !!! tip

     Or using PHPStorm: "VCS > Commit" to see the `diff` (on Mac OS: Cmd+K)


 It is time for you to check what the `rsync` did and (re)adapt accordingly. You should check and re-introduce your specifics:

 - Dependencies in `composer.json`
 - Bundles loaded in your `Kernel`
 - Configurations
 - Custom other things you will see in the `diff`

## 3. Update the app

At this point, you should have a `composer.json` file with the correct requirements. Run `composer update` to update the dependencies. 

``` bash
composer update
```

If you want to first test how the update proceeds without actually updating any packages, you can try the command with the `--dry-run` switch:

`composer update --dry-run`

On PHP conflict | 16.02 and later requires PHP 5.5 or higher

Because from release 16.02 onwards eZ Platform is compatible only with PHP 5.5 and higher, the update command above will fail if you use an older PHP version. Please update PHP to proceed.

??? note "v1.10: Adding EzSystemsPlatformEEAssetsBundle"

    !!! enterprise "EZ ENTERPRISE"

        When upgrading to v1.10, you need to enable the new `EzSystemsPlatformEEAssetsBundle` by adding:

        `new EzSystems\PlatformEEAssetsBundle\EzSystemsPlatformEEAssetsBundle(),`

        in `app/AppKernel.php`.

!!! caution "Common errors"

    If you experienced issues during the update, please check [Common errors](../getting_started/about_composer/#cloning-failed-using-an-ssh-key) section on the Composer about page.

## 4. Update database

Some versions require updates to the database. Look through [the list of database update scripts](https://github.com/ezsystems/ezpublish-kernel/tree/master/data/update/mysql) for a script for the version you are updating to (database version numbers correspond to the `ezpublish-kernel` version). If you find one, apply it like this:

`mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.7.0-to-6.8.0.sql`

These steps are only relevant for some releases:

??? note "Solr Bundle 1.4: Index time boosting"

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

??? note "v1.8: content/publish permission"

    v1.8.0 introduced a new `content/publish` permission separated out of the `content/edit` permission. `edit` now covers only editing content, without the right to publishing it. For that you need the `publish` permission. `edit` without `publish` can be used in conjunction with the Content review workflow to ensure that a user cannot publish content themselves, but must pass it on for review.

    To make sure existing users will be able to both edit and publish content, those with the `content/edit` permission will be given the `content/publish` permission by the following database update script:

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.7.0-to-6.8.0.sql
    ```

??? note "v1.8: Folder for form-uploaded files"

    To complete this step you have to [dump assets](#5-dump-assets) first.

    Since v1.8 you can add a File field to the Form block on a Landing Page. Files uploaded through such a form will be automatically placed in a specific folder in the repository.

    If you are upgrading to v1.8 you need to create this folder and assign it to a new specific Section. Then, add them in the config (for example, in `app/config/default_parameters.yml`, depending on how your configuration is set up):

    ``` bash
        #Location id of the root for form uploads
        form_builder.upload_folder.location_id: <folder location id>

        #Section identifier for form uploads
        form_builder.upload_folder.section_identifier: <section identifier>
    ```

??? note "v1.11: ezsearch_return_count table removal"

    v1.11.0 removes the `ezsearch_return_count` table, which had been removed in eZ Publish legacy since 5.4/2014.11. This avoids issues which would occur when you upgrade using legacy bridge. Apply the following database update script if your installation has not had the table removed by an earlier eZ Publish upgrade:

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.10.0-to-6.11.0.sql
    ```

??? note "v1.12: Increased password hash length"

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

??? note "v2.2: Change from UTF8 to UTF8MB4"

    Since v2.2 the character set for MySQL/MariaDB database tables changes from `utf8` to `utf8mb4` to support 4-byte characters.

    To apply this change, use the following database update script:

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.1.0-to-7.2.0.sql
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
