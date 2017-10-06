# Coming to eZ Platform from eZ Publish Platform

eZ Publish Platform (5.x) was a transitional version of the eZ CMS, bridging the gap between the earlier generation called eZ Publish (sometimes referred to as *legacy*), and the current eZ Platform and eZ Platform Enterprise Edition for Developers.

eZ Publish Platform introduced a new Symfony-based technology stack that could be run along the old (*legacy*) one. This bridging is still possible using something called Legacy Bridge, an optional package for eZ Platform. This fluid change allows eZ Publish users to migrate to eZ Platform in two steps, using the bridging as an intermediary stepping stone.

## Upgrading eZ Publish Platform 5.4.x (Enterprise-) / 2014.11 (Community-edition) to eZ Platform v1.11 or higher

!!! caution "Things to be aware of when planning a migration"

    1. While the instructions below are fully supported, we are aware that the community, partners and customers come from a wide range of different versions of eZ Publish, some with issues that do not surface before attempting a migration. That's why we and the community are actively gathering feedback on Slack and/or support channels for Enterprise customers to gradually improve the migration scripts and instructions. Reach out before you start so others who have done this before you can support you.

    1. As of eZ Platform v1.11, Legacy Bridge is a supported option for 1.x and future 2.x series. This means you can plan for a more gradual migration if you want, just like you could on eZ Publish Platform 5.x, with a more feature-rich version of eZ Platform and (with 2.x) also more recent version of Symfony. This is a great option for those who want the latest features and are comfortable with more frequent releases.

    1. Additionally there are some other topics to be aware of for the code migration from eZ Publish to eZ Platform:

        - [Field Types reference](../guide/field_type_reference.md) for overview of Field Types that do and don't exist in eZ Platform
        - eZ Platform RichText Field Type capabilities, currently not covering [Custom Tags](https://jira.ez.no/browse/EZP-25357)
        - Symfony 2.8, this is also the case on later 5.4.x versions, but not the first ones including 2014.11
        - API changes. While we have a strict backwards compatibility focus, some deprecated API features were removed and some changes were done to internal parts of the system. See [ezpublish-kernel:doc/bc/changes-6.0.md](https://github.com/ezsystems/ezpublish-kernel/blob/v6.7.0/doc/bc/changes-6.0.md)

!!! note

    If you are migrating from a legacy eZ Publish version, this page contains the information you need. However, first have a look at an overview of the process in [Migrating from eZ Publish](migrating_from_ez_publish.md).

This section describes how to upgrade your existing  eZ Publish Platform  5.4/2014.11 installation to eZ Platform and eZ Enterprise. Make sure that you have a working backup of the site before you do the actual upgrade, and that the installation you are performing the upgrade on is offline.

### Note on Paths

- `<old-ez-root>/`: The root directory where the 5.4/2014.11 installation is located in, for example: `/home/myuser/old_www/` or `/var/sites/ezp/`.
- `<new-ez-root>/`: The root directory where the installation is located in, for example: `/home/myuser/new_www/` or `/var/sites/[ezplatform|ezplatform-ee]/`.

## Check for requirements

- Information regarding system requirements can be found on the [Requirements documentation page](../getting_started/requirements_and_system_configuration.md); notable changes include:
    - PHP 5.6, 7.0 or higher
    - MariaDB or MySQL 5.5 or higher _(Postgres possible for upgrades, but not yet supported by the installer for new installations)_
    - Browser from 2016 or newer for use with eZ Platform backend UI
- This page assumes you have composer installed on the machine and that it is a somewhat recent version. See [About Composer](../getting_started/about_composer.md).

## Upgrade steps

### Step 1: Extract latest eZ Platform/Enterprise 1.11 or higher installation

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

###### 2.2.2 Install XmlText Field Type

While no longer bundled, the XmlText Field Type still exists and is needed to perform a migration from eZ Publish's XmlText to the new docbook-based format used by the RichText Field Type. If you plan to use Legacy Bridge for a while before migrating content, you'll also need this for rendering content with XMLText. From `<new-ez-root>` execute:

`composer require --no-update "ezsystems/ezplatform-xmltext-fieldtype:^1.3.0"`

!!! note

    As of v1.3, be aware this Field Type now uses the Content View system introduced in eZ Platform 1.0, so make sure you adapt custom templates and override rules if you plan to use this for rendering content _(in Legacy Bridge setup)_.


##### 2.3. Config

To move over your own custom configurations, follow the conventions below and manually move the settings over:

- `<old-ez-root>/ezpublish/config/parameters.yml => <new-ez-root>/app/config/parameters.yml`
    -  *For parameters like before, for new parameters you'll be prompted on later step.*
- `<old-ez-root>/ezpublish/config/config.yml =>  <new-ez-root>/app/config/config.yml`
    -  *For system/framework config, and for defining global db, cache, search settings.*
- `<old-ez-root>/ezpublish/config/ezpublish.yml => <new-ez-root>/app/config/ezplatform.yml`
    -  *For SiteAccess, site groups and repository settings.*

!!! note "Changes to repository configuration"

    When moving configuration over, be aware that as of 5.4.5 and higher, repository configuration has been enhanced to allow configuring storage engine and search engine independently.

    ``` yaml
    # Default ezplatform.yml repositories configuration with comments
    ezpublish:
        # Repositories configuration, set up default repository to support solr if enabled
        repositories:
            default:
                # For storage engine use kernel default (current LegacyStorageEngine)
                storage: ~
                # For search engine, pick the one configured in parameters.yml, either "legacy" or "solr"
                search:
                    engine: %search_engine%
                    connection: default
    ```

!!! note "Make sure to adapt SiteAccess names"

    In the default configurations in **ezplatform.yml** you'll find existing SiteAccesses like `site`, and depending on installation perhaps a few others, all under a site group called `site\_group`. Make sure to change those to what you had in **ezpublish.yml** to avoid issues with having to log in to your website, given user/login policy rules will need to be updated if you change names of SiteAccess as part of the upgrade.

##### 2.4. Bundles

Move over registration of _your_ bundles you have from src and from composer packages, from old to new kernel:

`<old-ez-root>/ezpublish/EzPublishKernel.php => <new-ez-root>/app/AppKernel.php`


##### 2.5. Optional: Install Legacy Bridge

If you don't plan to migrate content directly to newer eZ Platform Field Types, you can optionally install Legacy Bridge and gradually handle code and subsequent content migration afterwards. For installation instructions see [here](https://github.com/ezsystems/LegacyBridge/blob/master/INSTALL.md).

!!! note

    The Legacy Bridge integration does not have the same performance, scalability or integrated experience as a pure Platform setup. Like on eZ Publish Platform 5.x there are known edge cases where, for instance, cache or search index won't always be immediately updated across the two systems using the bridge. This is one of the many reasons why we recommend a pure Platform setup where that is possible.

###### 2.5.1 Set up symlinks for legacy folders

As eZ Publish legacy is installed via composer, we need to take care of placing some files outside its generated `<new-ez-root>/ezpublish_legacy/` folder, and for instance use symlink to place them inside during installation.

1. For design and settings files that you typically version in git, you can now take advantage of Legacy Bridge's built-in symlink convention. So as installation already hinted about, you can generate a structure and set up symlinks using `app/console ezpublish:legacy:symlink -c`. This will create folders you can use below in `<new-ez-root>/src/legacy_files/`.

1. The same goes for the `<new-ez-root>/ezpublish_legacy/var/[<site>/]storage` folder. However, as it is typically not versioned in git, there's no predefined convention for this. If you create a folder within your project structure for symlinking into this folder, as opposed to a mount somewhere else, make sure to mark this folder as ignored by git once it and the corresponding `.keep` file have been added to your checkout. The example below will assume `<new-ez-root>/src/legacy_files/storage` was created for this purpose, if you opt for something else just adjust the instructions.

###### 2.5.2 Upgrade the legacy distribution files

The easiest way to upgrade the distribution files is to copy the directories that contain site-specific files from the existing 5.4 installation into `/<ezplatform>/ezpublish_legacy`. Make sure you copy the following directories:

- `<old-ez-root>/ezpublish_legacy/design/<your_designs>` => `<new-ez-root>/src/legacy_files/design/<your_designs>`
    - *Do NOT include built-in designs: admin, base, standard or admin2*
- `<old-ez-root>/ezpublish_legacy/settings/siteaccess/<your_siteaccesses>` => `<new-ez-root>/src/legacy_files/settings/siteaccess/<your_siteaccesses>`
- `<old-ez-root>/ezpublish_legacy/settings/override/*` => `<new-ez-root>/src/legacy_files/settings/override/*`
- Other folders to move over *(or potentially set up symlinks for)* if applicable:
    - ezpublish_legacy/var/storage/packages
    - ezpublish_legacy/extension/\* *(do NOT include the built-in / composer provided ones, like: ezflow, ezjscore, ezoe, ezodf, ezie, ezmultiupload, ezmbpaex, ez_network, ezprestapiprovider, ezscriptmonitor, ezsi, ezfind)*
    - ezpublish_legacy/config.php and ezpublish_legacy/config.cluster.php

!!! note

    Since writable directories and files have been replaced / copied, their permissions might have changed. You most likely need to reconfigure webserver user permissions as instructed further down.

#####  2.6 Binary files

Binary files can simply be copied from the old to the new installation:

`<old-ez-root>/web/var[/<site_name>]/storage => <new-ez-root>/web/var[/<site_name>]/storage`

!!! note

    In the eZ Publish Platform 5.x installation `web/var` is a symlink to `ezpublish_legacy/var`, so if you can't find it in path above you can instead copy the storage files to the similar `ezpublish_legacy/var[/<site_name>]/storage` path.

#####  2.7 Re-apply permissions and update composer

Since writable directories and files have been replaced / copied, their permissions might have changed. Re-apply permissions as explained in [the installation instructions](../getting_started/install_manually.md#setup-folder-rights).

When that is done, execute the following to update and install all packages from within `<new-ez-root>`:

`composer update --prefer-dist`

!!! note

    At the end of the process, you will be asked for values for parameters.yml not already moved from old installation, or new *(as defined in parameters.yml.dist)*.

##### 2.8 Register EzSystemsEzPlatformXmlTextFieldTypeBundle

Add the following new bundle to your new kernel file, `<new-ez-root>/app/AppKernel.php`:

`new EzSystems\EzPlatformXmlTextFieldTypeBundle\EzSystemsEzPlatformXmlTextFieldTypeBundle(),` 

### Step 3: Upgrade the database

##### 3.1. Execute update SQL

Import to your database the changes provided in one of the following files. It's also recommended to read inline comments as you might not need to run some of the queries:

`MySQL: <new-ez-root>/vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-5.4.0-to-6.11.0.sql`

`MySQL: <new-ez-root>/vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.11.0-to-6.12.0.sql`

`Postgres: <new-ez-root>/vendor/ezsystems/ezpublish-kernel/data/update/postgres/dbupdate-5.4.0-to-6.11.0.sql`

`Postgres: <new-ez-root>/vendor/ezsystems/ezpublish-kernel/data/update/postgres/dbupdate-6.11.0-to-6.12.0.sql`

##### 3.2. Once you are ready to migrate content to Platform Field Types

Steps here should only be done once you are ready to move away from legacy and Legacy Bridge, as the following Field Types are not supported by legacy. In other words, content you have migrated will not be editable in legacy admin interface anymore, but rather in the more modern eZ Platform back-end UI, allowing you to take full advantage of what the Platform has to offer.

###### 3.2.1 Migrate XmlText content to RichText

**If** you are ready to migrate your eZ Publish XMLText content to the eZ Platform RichText format and start using pure eZ Platform setup, you can use a script to migrate content from the XmlText format to the new RichText format. Execute the following from &lt;new-ez-root&gt;:

`php bin/console ezxmltext:convert-to-richtext -v`

The command example suggests using the verbose flag. This is optional, but recommended as we are actively gathering feedback on how it works with older eZ Publish content, and on how we can improve it both [via issues in the repository](https://github.com/ezsystems/ezplatform-xmltext-fieldtype), and on Slack.

###### 3.2.2 Migrate Page field to Landing Page (eZ Enterprise only)

**If** you use Page field (ezflow) and an eZ Enterprise subscription, and are ready to migrate your eZ Publish Flow content to the eZ Enterprise Landing Page forma, you can use a script to migrate your Page content to Landing Page, to start using a pure eZ Enterprise setup. See [Migrating legacy Page field (ezflow) to Landing Page (Enterprise)](#migrating-legacy-page-field-ezflow-to-landing-page-enterprise) for more information.

###### 3.2.3 Add other eZ Enterprise schemas (eZ Enterprise only)

For date-based publisher and form builder, there are additional tables, you can import them to your database using the following sql files:
`<new-ez-root>/vendor/ezsystems/date-based-publisher/bundle/Resources/install/datebasedpublisher_scheduled_version.sql`
`<new-ez-root>/vendor/ezsystems/ezstudio-form-builder/bundle/Resources/install/form_builder.sql`

### Step 4: Re-configure web server and proxy

#### Varnish *(optional)*

If you use Varnish, the recommended Varnish (3 and 4) VCL configuration can be found in the `doc/varnish` folder. See also the [Using Varnish](../guide/http_cache.md#using-varnish) page.

#### Web server configuration

The officially recommended virtual configuration is now shipped in the `doc` folder, for both apache2 (`doc/apache2`) and nginx (`doc/nginx`). Both are built to be easy to understand and use, but aren't meant as drop-in replacements for your existing configuration.

As was the case starting 5.4, one notable change is that `SetEnvIf` is now used to dynamically change rewrite rules depending on the Symfony environment. It is currently used for the assetic production rewrite rules.

### Step 5: Link assets

Assets from the various bundles need to be made available for the webserver through the web/ document root. Execute the following commands from `<new-ez-root>`:

``` bash
php bin/console assets:install --env=prod --symlink
php bin/console assetic:dump --env=prod
```

## Potential pitfalls

##### Unstyled login screen after upgrade

It is possible that after the upgrade your admin screen will be unstyled. This may happen because the new SiteAccess will not be available in the database. You can fix it by editing the permissions for the Anonymous user. Go to Roles in the Admin Panel and edit the Limitations of the Anonymous user's user/login policy. Add all SiteAccesses to the Limitation, save, and clear the browser cache. The login screen should now show proper styling.

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
bin/console cache:clear
```

**4.** Run the script with the following parameters:

- absolute path of your legacy application
- list of .ini files which define your legacy blocks

**Script command**

``` bash
bin/console ezflow:migrate <legacy path> —ini=<block definitions> [—ini=<another block definition> ...]
```

**Example of the migration script command**

``` bash
bin/console ezflow:migrate /var/www/legacy.application.com/ —ini=extension/myapplication/settings/block.ini.append.php
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
