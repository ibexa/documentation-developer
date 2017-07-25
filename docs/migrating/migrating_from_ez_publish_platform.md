# Coming to eZ Platform from eZ Publish Platform

eZ Publish Platform (5.x) was a transitional version of the eZ CMS, bridging the gap between the earlier generation called eZ Publish (sometimes referred to as *legacy*), and the current eZ Platform Enterprise Edition for Developers.

eZ Publish Platform introduced a new Symfony-based technology stack that could be run along the old (*legacy*) one. This fluid change allows eZ Publish users to migrate to eZ Platform Enterprise Edition for Developers in two steps, using the 5.x version as an intermediary stepping stone.

## Upgrading from 5.4.x and 2014.11 to 16.xx

!!! caution "Beta"

    Instructions and scripts provided here are open for testing and feedback, and for eZ Enterprise users eZ will take care about bugs over support, however until 2017 when features like custom tags are in place, and community provides feedback on how this works "in the wild", this will continue to be labeled as beta.

    Topics you should be aware of when planning an upgrade:

    - [Field Types reference](../guide/field_type_reference.md) for overview of Field Types that exists and not on eZ Platform
    - RichText Field Type capabilities, currently not covering [Custom Tags](https://jira.ez.no/browse/EZP-25357)
    - Symfony 2.8, this is also the case on later 5.4.x versions, but not the first once including 2014.11
    - API changes, while we have a strict Backwards Compatibility focus, some deprecated API features where removed, some changes where done to internal parts of the system, and as planned eZ Publish legacy and legacy bridge was removed. See [ezpublish-kernel:doc/bc/changes-6.0.md](https://github.com/ezsystems/ezpublish-kernel/blob/v6.6.0/doc/bc/changes-6.0.md)

!!! note

    Instructions for upgrading from eZ Publish to eZ Platform and eZ Enterprise are in preview starting release [16.02](../releases/ez_platform_16.02_release_notes.md). The status of the upgrade is:

    - eZ Platform: **XmlText to RichText migration**: *In Beta, and described below.*
    - eZ Enterprise: **Flow to Landing Page migration**: *Scheduled for beta version with 16.04.*

!!! note

    If you are migrating from a legacy eZ Publish version, this page contains the information you need. However, first have a look at an overview of the process in [Migrating from eZ Publish](migrating_from_ez_publish.md).

This section describes how to upgrade your existing  eZ Publish Platform  5.4/2014.11 installation to eZ Platform and eZ Enterprise. Make sure that you have a working backup of the site before you do the actual upgrade, and that the installation you are performing the upgrade on is offline.

## Note on Paths

- `<old-ez-root>/`: The root directory where the 5.4/2014.11 installation is located in, for example: `/home/myuser/old_www/` or `/var/sites/ezp/`.
- `<new-ez-root>/`: The root directory where the installation is located in, for example: `/home/myuser/new_www/` or `/var/sites/[ezplatform|ezplatform-ee]/`.

## Check for requirements

- Information regarding system requirements can be found on the [Requirements documentation page](../getting_started/requirements_and_system_configuration.md); notable changes include:
    - PHP 5.5.9 or higher
    - MySQL or MariaDB 5.5 or higher
    - Browser from 2015 or newer for use with backend UI
- This page assumes you have composer installed on the machine and that it is a somewhat recent version. See [About Composer](../getting_started/about_composer.md).

## Upgrade steps

### Step 1: Extract latest eZ Platform/Enterprise 16.02.x installation

The easiest way to upgrade the distribution files is to extract a clean installation of eZ Platform / eZ Enterprise to a separate directory.

### Step 2: Move over code and config

##### 2.1. Code

If you have code in src folder, move that over:

`<old-ez-root>/src =>  <new-ez-root>/src`

##### 2.2. Composer

###### 2.2.1 Move over own packages

Assuming you have own composer packages *(libraries and bundles, but not eZ Publish legacy packages)*, execute commands like below to add them to new install in `<new-ez-root>`:

`composer require --no-update "vendor/package:~1.3.0"`

Adapt the command with your `vendor`, `package`, version number, and add `"–dev"` if a given package is for dev use. Also check if there are other changes in `composer.json` you should move over.

###### 2.2.2 Temporarily install XmlText Field Type

While no longer bundled, the XmlText Field Type exists and is needed to perform migration from eZ Publish's XmlText to the new docbook-based format used by RichText Field Type. From `<new-ez-root>` execute:

`composer require --no-update --dev "ezsystems/ezplatform-xmltext-fieldtype:^1.1.0"`

##### 2.3. Config

To move over your own custom configurations, follow the conventions below and manually move the settings over:

- `<old-ez-root>/ezpublish/config/parameters.yml => <new-ez-root>/app/config/parameters.yml`
    -  *For parameters like before, for new parameters you'll be prompted on later step.*
- `<old-ez-root>/ezpublish/config/config.yml =>  <new-ez-root>/app/config/config.yml`
    -  *For system/framework config, and for defining global db, cache, search settings.*
- `<old-ez-root>/ezpublish/config/ezpublish.yml => <new-ez-root>/app/config/ezplatform.yml`
    -  *For site access, site groups and repository settings.*

!!! note "Changes to repository configuration"

    When moving configuration over, be aware that as of 5.4.5 and higher, repository configuration has been enhanced to allow configuring storage engine and search engine independently.

    ``` yaml
    # Default ezplatform.yml repositories configuration with comments
    ezpublish:
        # Repositories configuration, setup default repository to support solr if enabled
        repositories:
            default:
                # For storage engine use kernel default (current LegacyStorageEngine)
                storage: ~
                # For search engine, pick the one configured in parameters.yml, either "legacy" or "solr"
                search:
                    engine: %search_engine%
                    connection: default
    ```

!!! note "Make sure to adapt siteaccess names"

    In the default configurations in **ezplatform.yml** you'll find existing siteaccesses like **site**, and depending on installation perhaps a few others, all under site group **site\_group**. Make sure to change those to what you had in **ezpublish.yml** to avoid issues with having to login to your website, given user/login policy rules will need to be updated if you change names of siteaccess as part of the upgrade.

##### 2.4. Bundles

Move over registration of bundles you have from src and from composer packages, from old to new kernel:

`<old-ez-root>/ezpublish/EzPublishKernel.php => <new-ez-root>/app/AppKernel.php`

#####  2.5 Binary files

Binary files can simply be copied from the old to the new installation:

`<old-ez-root>/web/var[/<site_name>]/storage => <new-ez-root>/web/var[/<site_name>]/storage`

!!! note

    In the eZ Publish Platform 5.x install `web/var` is a symlink to `ezpublish_legacy/var`, so if you can't find it in path above you can instead copy the storage files from the similar `ezpublish_legacy` path.

#####  2.6 Re-apply permissions and update composer

Since writable directories and files have been replaced / copied, their permissions might have changed. Re-apply permissions as explained in the installation instructions. TODO: LINK

When that is done, execute the following to update and install all packages from within `<new-ez-root>`:

`composer update --prefer-dist`

!!! note

    At the end of the process, you will be asked for values for parameters.yml not already moved from old installation, or new *(as defined in parameters.yml.dist)*.

##### 2.7 Register EzSystemsEzPlatformXmlTextFieldTypeBundle

Add the following new bundle to your new kernel file, `<new-ez-root>/app/AppKernel.php`:

`new EzSystems\EzPlatformXmlTextFieldTypeBundle\EzSystemsEzPlatformXmlTextFieldTypeBundle(),` 

### Step 3: Upgrade the database

##### 3.1. Execute update SQL

Import to your database the changes provided in one of the following files, optionally read inline comments as you might not need to run some cleanup queries:

`MySQL: <new-ez-root>/vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.1.0-to-6.2.0.sql`

`Postgres: <new-ez-root>/vendor/ezsystems/ezpublish-kernel/data/update/postgres/dbupdate-6.1.0-to-6.2.0.sql`

!!! note

    *Instructions on purpose does not use `dbupdate-5.4.0-to-6.2.0.sql` [as it contains issues with the sql, and the sql update file above contains all relevant schema updates.](https://github.com/ezsystems/ezpublish-kernel/blob/v6.2.0/data/update/mysql/dbupdate-5.4.0-to-6.2.0.sql)*

##### 3.2. Execute XmlText Migration script

For migrating content from the XmlText format to the new RichText format, a migration script exists, execute the following from &lt;new-ez-root&gt;:

`php app/console ezxmltext:convert-to-richtext -v`

The migration script is currently in beta, which is why command example is suggested with verbose flag. Feedback on how it works and on how we can improve it is welcome [on the repository](https://github.com/ezsystems/ezplatform-xmltext-fieldtype).

##### 3.3. Migrate Page field to Landing Page (eZ Enterprise only)

If you have Page field (ezflow) content and an eZ Enterprise subscription, you can use a script to migrate your Page content to eZ Enterprise Landing Page. See [Migrating legacy Page field (ezflow) to Landing Page (Enterprise)](#migrating-legacy-page-field-ezflow-to-landing-page-enterprise) for more information.

### Step 4: Re-configure web server & proxy

#### Varnish *(optional)*

If you use Varnish, the recommended Varnish (3 and 4) VCL configuration can be found in the `doc/varnish` folder. See also the [Using Varnish](../guide/http_cache.md#using-varnish) page.

#### Web server configuration

The officially recommended virtual configuration is now shipped in the `doc` folder, for both apache2 (`doc/apache2`) and nginx (`doc/nginx`). Both are built to be easy to understand and use, but aren't meant as drop-in replacements for your existing configuration.

As was the case starting 5.4, one notable change is that `SetEnvIf` is now used to dynamically change rewrite rules depending on the Symfony environment. It is currently used for the assetic production rewrite rules.

### Step 5: Link assets

Assets from the various bundles need to be made available for the webserver through the web/ document root, execute the following commands from `<new-ez-root>`:

``` bash
php app/console assets:install --env=prod --symlink
php app/console assetic:dump --env=prod
```

## Potential pitfalls

##### Unstyled login screen after upgrade

It is possible that after the upgrade your admin screen will be unstyled. This may happen because the new siteaccess will not be available in the database. You can fix it by editing the permissions for the Anonymous user. Go to Roles in the Admin Panel and edit the Limitations of the Anonymous user's user/login policy. Add all siteaccesses to the Limitation, save, and clear the browser cache. The login screen should now show proper styling.

##### Translating URLs

If your legacy site uses old-style URL aliases, to upgrade them successfully you need to apply a workaround to the slug converter. Where the slug converter service is defined, set second config parameter to use `urlalias_compat` by adding a new argument to the existing settings:

``` yaml
# in vendor/ezsystems/ezpublish-kernel/eZ/Publish/Core/settings/storage\_engines/common.yml
    ezpublish.persistence.slug_converter:
        class: "%ezpublish.persistence.slug_converter.class%"
        arguments:
            - "@ezpublish.api.storage_engine.transformation_processor"
            - { transformation: "urlalias_compat" }
```

In case of URLs with extended UTF-encoded names, the workaround must make use of `urlalias_iri`:

``` yaml
    ezpublish.persistence.slug_converter:
        class: "%ezpublish.persistence.slug_converter.class%"
        arguments:
            - "@ezpublish.api.storage_engine.transformation_processor"
            - { transformation: "urlalias_iri" }
```


## Migrating legacy Page field (ezflow) to Landing Page (Enterprise)

To move your legacy Page field / eZ Flow configuration to eZ Platform Enterprise Edition you can use a script that will aid in the migration process.

The script will automatically migrate only data – to move custom views, layouts, blocks etc., you will have to provide their business logic again.

!!! caution

    The migration script will operate on your current database.

    Make sure to **back up your database** in case of an unexpected error.

To use the script, do the following:

!!! note

    Make a note of the paths to .ini files which define your legacy blocks. You will need these paths later.

**1.** Add `ezflow-migration-toolkit` to `composer.json` in your clean Platform installation.

``` json
"ezsystems/ezflow-migration-toolkit": "^1.0.0"
```

**2.** Add `ezflow-migration-toolkit` to `AppKernel.php`.

``` php
// AppKernel.php
new EzSystems\EzFlowMigrationToolkitBundle\EzSystemsEzFlowMigrationToolkitBundle()
```

**3.** Clear cache.

``` bash
app/console cache:clear
```

**4.** Run the script with the following parameters:

- absolute path of your legacy application
- list of .ini files which define your legacy blocks

**Script command**

``` bash
app/console ezflow:migrate <legacy path> —ini=<block definitions> [—ini=<another block definition> ...]
```

**Example of the migration script command**

``` bash
app/console ezflow:migrate /var/www/legacy.application.com/ —ini=extension/myapplication/settings/block.ini.append.php
```

**5.** You will be warned about the need to create a backup of your database. **Proceed only if you are sure you have done it.**

A `MigrationBundle` will be generated in the `src/` folder.

You will see a report summarizing the results of the migration.

**6.** Add `MigrationBundle` to `AppKernel.php`.

``` php
// AppKernel.php
new MigrationBundle\MigrationBundle()
```

**7.** Clear cache again.

At this point you can already view the initial effects of the migration, but they will still be missing some of your custom content.

The `MigrationBundle` generates placeholders for layouts in the form of frames with a data dump.

For blocks that could not be mapped to existing Landing Page blocks, it will also generate PHP file templates that you need to fill with your own business logic.

 
 
