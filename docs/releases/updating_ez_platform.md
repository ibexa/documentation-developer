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

    ##### Form Builder

    !!! enterprise "EZ ENTERPRISE"

        To enable the Form Builder feature in eZ Platform Enterprise Edition, import the following file:

        ``` bash
        mysql -p -u <database_user> <database_name> < vendor/ezsystems/ezstudio-form-builder/bundle/Resources/install/form_builder.sql
        ```

    ##### Date Based Publisher

    !!! enterprise "EZ ENTERPRISE"

        To enable the Date-Based Publisher feature in Enterprise, import the following file:

        ``` bash
        mysql -p -u <database_user> <database_name> < vendor/ezsystems/date-based-publisher/bundle/Resources/install/datebasedpublisher_scheduled_version.sql
        ```

        In order to activate Date-Based Publisher open console (terminal) and use:

        ``` bash
        crontab -e
        ```

        and add below configuration at the end of edited file.

        For production environment:

        ``` bash
        * * * * *   (cd /path/to/your/ezplatform-ee-project && app/console ezpublish:cron:run -e prod)
        ```

        For development environment:

        ``` bash
        * * * * *   (cd /path/to/your/ezplatform-ee-project && app/console ezpublish:cron:run -e dev)
        ```

## 5. Dump assets

The web assets must be dumped again if you are using the `prod` environment. In `dev` this happens automatically:

``` bash
php app/console assetic:dump -e prod
```

If you encounter problems, additionally clear the cache and install assets:

``` bash
php app/console cache:clear -e prod
php app/console assets:install --symlink -e prod
php app/console assetic:dump -e prod
```

## 6. Commit, test and merge

Once all the conflicts have been resolved, and `composer.lock` updated, the merge can be committed. Note that you may or may not keep `composer.lock`, depending on your version management workflow. If you do not wish to keep it, run `git reset HEAD <file>` to remove it from the changes. Run `git commit`, and adapt the message if necessary. You can now verify the project and once the update has been approved, go back to `master`, and merge your update branch:

``` bash
git checkout master
git merge <branch_name>
```

**Your eZ Platform should now be up-to-date with the chosen version!**
