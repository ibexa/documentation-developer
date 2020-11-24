# Migrating from eZ Publish Platform

eZ Publish Platform (5.x) was a transitional version of the Ibexa CMS, bridging the gap between the earlier generation called eZ Publish (sometimes referred to as *legacy*), and eZ Platform, the predecessor to [[= product_name =]].

eZ Publish Platform introduced a new Symfony-based technology stack that could be run along the old (*legacy*) one. This bridging is still possible using something called Legacy Bridge, an optional package for eZ Platform. This fluid change allows eZ Publish users to migrate to eZ Platform gradually, using the bridging as an intermediary stepping stone.

## Upgrade process

An upgrade from eZ Publish Platform 5.4.x (Enterprise edition) or 2014.11 (Community edition) to newer versions of eZ Platform must be performed in stages.

You can upgrade from eZ Publish Platform directly to the v1.7 LTS release.
You can then proceed with consecutive upgrades to further versions: v1.13 LTS and 2.x.

!!! caution "Things to be aware of when planning a migration"

    1. While the instructions below are fully supported, we are aware that the community, partners and customers come from a wide range of different versions of eZ Publish, some with issues that do not surface before attempting a migration. That's why we and the community are actively gathering feedback on Slack and/or support channels for Enterprise customers to gradually improve the migration scripts and instructions. Reach out before you start so others who have done this before you can support you.

    1. As of eZ Platform v1.11, Legacy Bridge is a supported option for 1.x and future 2.x series. This means you can plan for a more gradual migration if you want, just like you could on eZ Publish Platform 5.x, with a more feature-rich version of eZ Platform and (with 2.x) also more recent version of Symfony. This is a great option for those who want the latest features and are comfortable with more frequent releases.

    1. Additionally there are some other topics to be aware of for the code migration from eZ Publish to eZ Platform:

        - Symfony deprecations. The recommended version to migrate to is eZ Platform v2.5 LTS, which is using Symfony 3.4 LTS.
        - [Field Types reference](../api/field_type_reference.md) for overview of Field Types that do and don't exist in eZ Platform
        - API changes. While we have a strict backwards compatibility focus, some deprecated API features were removed and some changes were done to internal parts of the system. See [ezpublish-kernel:doc/bc/changes-6.0.md](https://github.com/ezsystems/ezpublish-kernel/blob/v6.7.0/doc/bc/changes-6.0.md)

!!! note

    If you are migrating from a legacy eZ Publish version, this page contains the information you need. However, first have a look at an overview of the process in [Migrating from eZ Publish](migrating_from_ez_publish.md).

This section describes how to upgrade your existing  eZ Publish Platform  5.4/2014.11 installation to eZ Platform and eZ Enterprise. Make sure that you have a working [backup](../guide/backup.md) of the site before you do the actual upgrade, and that the installation you are performing the upgrade on is offline.

### Note on Paths

- `<old-ez-root>/`: The root directory where the 5.4/2014.11 installation is located in, for example: `/home/myuser/old_www/` or `/var/sites/ezp/`.
- `<new-ez-root>/`: The root directory where the installation is located in, for example: `/home/myuser/new_www/` or `/var/sites/[ezplatform|ezplatform-ee]/`.

## Check for requirements

- Information regarding system requirements can be found on the [Requirements documentation page](../getting_started/requirements.md); notable changes include:
    - PHP 7.1 or higher
    - MariaDB or MySQL 5.5 or higher _(Postgres possible for upgrades, but not yet supported by the installer for new installations)_
    - Browser from 2017 or newer for use with eZ Platform backend UI
- This page assumes you have composer installed on the machine and that it is a recent version.

## Upgrade steps

### Step 1: Extract eZ Platform/Enterprise v1.7

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

- `<old-ez-root>/ezpublish/config/parameters.yaml => <new-ez-root>/app/config/parameters.yaml`
    -  *For parameters like before, for new parameters you'll be prompted on later step.*
- `<old-ez-root>/ezpublish/config/config.yaml =>  <new-ez-root>/app/config/config.yaml`
    -  *For system/framework config, and for defining global db, cache, search settings.*
- `<old-ez-root>/ezpublish/config/ezpublish.yaml => <new-ez-root>/app/config/ezplatform.yaml`
    -  *For SiteAccess, site groups and Repository settings.*

!!! note "Changes to Repository configuration"

    When moving configuration over, be aware that as of 5.4.5 and higher, Repository configuration has been enhanced to allow configuring storage engine and search engine independently.

    ``` yaml
    # Default ezplatform.yaml Repositories configuration with comments
    ezplatform:
        # Repositories configuration, set up default Repository to support solr if enabled
        repositories:
            default:
                # For storage engine use kernel default (current LegacyStorageEngine)
                storage: ~
                # For search engine, pick the one configured in parameters.yaml, either "legacy" or "solr"
                search:
                    engine: '%search_engine%'
                    connection: default
    ```

!!! note "Make sure to adapt SiteAccess names"

    In the default configurations in **ezplatform.yaml** you'll find existing SiteAccesses like `site`, and depending on installation perhaps a few others, all under a site group called `site\_group`. Make sure to change those to what you had in **ezpublish.yaml** to avoid issues with having to log in to your website, given user/login policy rules will need to be updated if you change names of SiteAccess as part of the upgrade.

###### 2.3.1 Image aliases

Image aliases defined in legacy must also be defined for eZ Platform. Since image aliases in legacy may be scattered around
in different `image.ini` files in various extensions, you may find it easier to find all image alias definitions using
the legacy admin (**Setup** > **Ini settings**).

See [Image documentation page](../../guide/images/) for information about how to define image aliases.

For an example, see a legacy image alias defined as follows in `ezpublish_legacy/settings/siteaccess/ezdemo_site/image.ini.append.php`:

```
[articleimage]
Reference=
Filters[]
Filters[]=geometry/scalewidth=770

[articlethumbnail]
Reference=
Filters[]
Filters[]=geometry/scaledownonly=170;220
```

The corresponding image alias configuration for eZ Platform would be:

``` yaml
ezpublish:
    siteaccess:
        groups:
            # Define the siteaccesses where given image aliases are in use
            image_aliases_group: [ezdemo_site, eng, ezdemo_site_admin, admin]
    system:
        image_aliases_group:
            image_variations:
                articleimage:
                    reference: null
                    filters:
                        - { name: geometry/scalewidth, params: [770] }
                articlethumbnail:
                    reference: null
                    filters:
                        - { name: geometry/scaledownonly, params: [170, 220] }
```

##### 2.4. Bundles

Move over registration of _your_ bundles you have from src and from composer packages, from old to new kernel:

`<old-ez-root>/ezpublish/EzPublishKernel.php => <new-ez-root>/app/AppKernel.php`


##### 2.5. Optional: Install Legacy Bridge

If you don't plan to migrate content directly to newer eZ Platform Field Types, you can optionally install Legacy Bridge and gradually handle code and subsequent content migration afterwards. For installation instructions see [here](https://github.com/ezsystems/LegacyBridge/blob/master/INSTALL.md).

!!! note

    The Legacy Bridge integration does not have the same performance, scalability or integrated experience as a pure Platform setup. Like on eZ Publish Platform 5.x there are known edge cases where, for instance, cache or search index won't always be immediately updated across the two systems using the bridge. This is one of the many reasons why we recommend a pure Platform setup where that is possible.

###### 2.5.1 Set up symlinks for legacy folders

As eZ Publish legacy is installed via composer, we need to take care of placing some files outside its generated `<new-ez-root>/ezpublish_legacy/` folder, and for instance use symlink to place them inside during installation.

1. For design and settings files that you typically version in git, you can now take advantage of Legacy Bridge's built-in symlink convention. So as installation already hinted about, you can generate a structure and set up symlinks using `bin/console ezpublish:legacy:symlink -c`. This will create folders you can use below in `<new-ez-root>/src/legacy_files/`.

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

Since writable directories and files have been replaced / copied, their permissions might have changed. You need to re-apply them.

When that is done, execute the following to update and install all packages from within `<new-ez-root>`:

`composer update --prefer-dist`

!!! note

    At the end of the process, you will be asked for values for parameters.yaml not already moved from old installation, or new *(as defined in parameters.yaml.dist)*.

##### 2.8 Register EzSystemsEzPlatformXmlTextFieldTypeBundle

Add the following new bundle to your new kernel file, `<new-ez-root>/app/AppKernel.php`:

`new EzSystems\EzPlatformXmlTextFieldTypeBundle\EzSystemsEzPlatformXmlTextFieldTypeBundle(),` 

### Step 3: Upgrade the database

##### 3.1. Execute update SQL

Import to your database the changes provided in one of the following files. It's also recommended to read inline comments as you might not need to run some of the queries:

`MySQL: <new-ez-root>/vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-5.4.0-to-6.13.0.sql`

`Postgres: <new-ez-root>/vendor/ezsystems/ezpublish-kernel/data/update/postgres/dbupdate-5.4.0-to-6.13.0.sql`

##### 3.2. Once you are ready to migrate content to Platform Field Types

Steps here should only be done once you are ready to move away from legacy and Legacy Bridge, as the following Field Types are not supported by legacy. In other words, content you have migrated will not be editable in legacy admin interface anymore, but rather in the more modern eZ Platform back-end UI, allowing you to take full advantage of what the Platform has to offer.

###### 3.2.1 Migrate XmlText content to RichText

You should test the XmlText to RichText conversion before you apply it to a production database. RichText has a stricter validation compared to XmlText and you may have to fix some of your XmlText before you are able to convert it to RichText.
Run the conversion script on a copy of your production database as the script is rather resource-intensive.

`php -d memory_limit=1536M bin/console ezxmltext:convert-to-richtext --dry-run --export-dir=ezxmltext-export --export-dir-filter=notice,warning,error --concurrency 4 -v`

- `-d memory_limit=1536M` specifies that each conversion process gets 1536MB of memory. This should be more than sufficient for most databases. If you have small `ezxmltext` documents, you may decrease the limit. If you have huge `ezxmltext` documents, you may need to increase it. See PHP documentation for more information about the [memory_limit setting](http://php.net/manual/en/ini.core.php#ini.memory-limit).
- `--dry-run` prevents the conversion script from writing anything back to the database. It just tests if it is able to convert all the `ezxmltext` documents.
- `--export-dir` specifies a directory where it will dump the `ezxmltext` for content object attributes which the conversion script finds problems with
- `--export-dir-filter` specifies what severity the problems found needs to be before the script dumps the `ezxmltext`:
    - `notice`: `ezxmltext` contains problems which the conversion tool was able to fix automatically and likely do not need manual intervention
    - `warning`: the conversion tool was able to convert the `ezxmltext` to valid `richtext`, but data could have been altered/removed/added in the process. Manual supervision recommended
    - `error`: the `ezxmltext` text cannot be converted and manual changes are required.
- `--concurrency 4` specifies that the conversion script will spawn four child processes which run the conversion. If you have dedicated hardware for running the conversion, you should use concurrency level that matches the number of logical CPUs on your system. If your system needs to do other tasks while running the conversion, you should run with a smaller number.
- `-v` specifies verbosity level. You may increase the verbosity level by supplying `-vv`, but `-v` will be sufficient in most cases.

The script also has an `--image-content-types` option which you should use if you have custom image classes. With this option, you specify the content class identifiers:

`php bin/console ezxmltext:convert-to-richtext --image-content-types=image,custom_image -v`

The script needs to know these identifiers in order to convert `<ezembed>` tags correctly. Failing to do so will prevent the editor from showing image thumbnails of embedded image objects. You may find the image Content Types in your installation by looking for these settings in `content.ini(.append.php)`:

```
[RelationGroupSettings]
ImagesClassList[]
ImagesClassList[]=image
```

If the `--image-content-types` option is not specified, the default setting `image` will be used.

!!! note

    Version of the migration script in ezplatform-xmltext-fieldtype prior to v1.6.0 would fail to convert embedded images correctly. If you have a database which you have already converted with an old version, you may rerun the `convert-to-richtext` command with the following options:

    `php bin/console ezxmltext:convert-to-richtext --fix-embedded-images-only -v`

    The use of `--image-content-types` is also supported together with `--fix-embedded-images-only`. Use it to specify custom image Content Types.

!!! note

    There is no corresponding `ImagesClassList[]` setting in eZ Platform. So even though you have customer image classes, you don't need to configure this in the eZ Platform configuration when migrating.

If you later realize that you provided the convert script with incorrect image Content Type identifiers, it is perfectly safe to re-execute the command as long as you use the `--fix-embedded-images-only`.

So, if you first ran the command:

`php bin/console ezxmltext:convert-to-richtext --image-content-types=image,custom_image -v`

But later realize the last identifier should be `profile`, not ``custom_image``, you may execute :

`php bin/console ezxmltext:convert-to-richtext --image-content-types=image,profile -v`

The last command would then ensure embedded objects with Content Type identifier `custom_image` are no longer tagged as images, while embedded objects with Content Type identifier `profile` are.


Using the option `--export-dir`, the conversion will export problematic `ezxmltext` to files with the name pattern `[export-dir]/ezxmltext_[contentobject_id]_[contentobject_attribute_id]_[version]_[language].xml`. A corresponding `.log` file will also be created which includes information about why the conversion failed. Be aware that the reported location of the problem may not be accurate or may be misleading.

Below is an example of a xml dump, `ezxmltext_12_1234_2_eng-GB.xml`:

```xml
<?xml version="1.0" encoding="utf-8"?>
<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/">
  <paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/" ez-temporary="1">
    <table border="1">
      <tr>
        <td>
          <paragraph>col1</paragraph>
        </td>
        <td align="right">
          <paragraph>col2</paragraph>
        </td>
        <td align="middle" xhtml:width="73">
          <paragraph>col3</paragraph>
        </td>
        <td align="center" xhtml:width="73">
          <paragraph>col4</paragraph>
        </td>
      </tr>
    </table>
  </paragraph>
</section>
```

The corresponding log file, `ezxmltext_12_1234_2_eng-GB.log`:

```
notice: Found ez-temporary attribute in a ezxmltext paragraphs. Removing such attribute where contentobject_attribute.id=1234
error: Validation errors when converting ezxmltext for contentobject_attribute.id=1234
- context : Error in 2:0: Element section has extra content: informaltable
```

The first log message is a notice about the `ez-temporary=1` attribute which the conversion tool simply will remove during conversion.
The second log message is an error, but the cause described may be confusing. During the conversion, the `<table>` element will be converted to an `<informaltable>` tag, which is problematic.
The exact problem in this case is the value of the second align attribute: `<td align="middle"....>`. An align attribute may only have the following values: `left`, `right`, `center`, `justify`.

In order to fix the problem, open the .xml file in a text editor and correct the errors:

```xml
<?xml version="1.0" encoding="utf-8"?>
<section xmlns:image="http://ez.no/namespaces/ezpublish3/image/" xmlns:xhtml="http://ez.no/namespaces/ezpublish3/xhtml/" xmlns:custom="http://ez.no/namespaces/ezpublish3/custom/">
  <paragraph xmlns:tmp="http://ez.no/namespaces/ezpublish3/temporary/">
    <table border="1">
      <tr>
        <td>
          <paragraph>col1</paragraph>
        </td>
        <td align="right">
          <paragraph>col2</paragraph>
        </td>
        <td align="center" xhtml:width="73">
          <paragraph>col3</paragraph>
        </td>
        <td align="center" xhtml:width="73">
          <paragraph>col4</paragraph>
        </td>
      </tr>
    </table>
  </paragraph>
</section>
```

Now, you may test if the modified `ezxmltext` may be converted using the `--dry-run` and `--content-object` options:

`php -d memory_limit=1536M bin/console ezxmltext:import-xml --dry-run  --export-dir=ezxmltext-export --content-object=56554 -v`

If the tool reports no errors, then the `ezxmltext` is fixed. You may rerun the command without the `--dry-run` option in order to actually update the database with the correct XmlText.

Once you have fixed all the dump files in `ezxmltext-export/`, you may skip the `--content-object` option and the script will import all the dump files located in the `export-dir`:

`php -d memory_limit=1536M bin/console ezxmltext:import-xml --export-dir=ezxmltext-export -v`

Typical problems that needs manual fixing:

**Duplicate xhtml IDs**

Xhtml IDs needs to be unique. The following `ezxmltext` will result in a warning:

```
    <paragraph>
        <link target="_blank" xhtml:id="inv5" url_id="2309">link with id inv5</link>
    </paragraph>
    <paragraph>
        <link target="_blank" xhtml:id="inv5" url_id="2309">another link with id inv5</link>
    </paragraph>
```

The conversion tool will replace the duplicate id (`inv5`) with a random value. If you need the ID value to match your CSS, you need to change it manually.
The conversion tool will also complain about IDs which contain invalid characters.

**Links with non-existing `object_remote_id` or `node_remote_id`.**

In `ezxmltext` you may have links which refer to other objects by their remote ID. This is not supported in `richtext`, so the conversion tool must look up such remote IDs and replace them with the `object_id` or `node_id`. If the conversion tool cannot find the object by its remote id, it will issue a warning about it.

In older eZ Publish databases you may also have invalid links due to lack of reference to a target (no `href`, `url_id`, etc.):

```
    <link>some text</link>
```

When the conversion tool detects links with no reference it will issue a warning and rewrite the URL to point to current page (`href="#"`).

**`<literal>`**

The `<literal>` tag is not yet supported in eZ Platform. For more information about this, please have a look at [EZP-29328](https://jira.ez.no/browse/EZP-29328) and [EZP-29027](https://jira.ez.no/browse/EZP-29027).

When you are ready to migrate your eZ Publish XmlText content to the eZ Platform RichText format and start using pure eZ Platform setup, start the conversion script without the `--dry-run` option. Execute the following from &lt;new-ez-root&gt;:

`php -d memory_limit=1536M bin/console ezxmltext:convert-to-richtext --export-dir=ezxmltext-export --export-dir-filter=notice,warning,error --concurrency 4 -v`

**Custom tags and attributes**

eZ Platform now supports custom tags, including inline custom tags, and limited use of custom tag attributes.
After migrating to RichText, you need to adapt your custom tag config for eZ Platform and rewrite the custom tags in Twig.
See [Custom tag documentation](../extending/extending_online_editor.md#custom-tags) for more info.

If you configured custom attributes in legacy in OE using [ezoe_attributes.ini](https://github.com/ezsystems/ezpublish-legacy/blob/master/extension/ezoe/settings/ezoe_attributes.ini#L33-L48), note that not all types are supported.

Below is a table of the tags that are currently supported, and their corresponding names in eZ Platform.

| [XmlText](https://github.com/ezsystems/ezpublish-legacy/blob/2019.03/extension/ezoe/settings/ezoe_attributes.ini#L33-L48) | [RichText](https://github.com/ezsystems/ezplatform-richtext/blob/v1.1.5/src/bundle/DependencyInjection/Configuration.php#L17) | Note  |
| ------------- | ------------- | ----- |
| `link`        | [`link`](../extending/extending_online_editor.md#example-link-tag) |  |
| `number`      | `number`      |  |
| `int`         | `number`      |  |
| `checkbox`    | `boolean`     |  |
| `select`      | `choice`      |  |
| `text`        | `string`      |  |
| `textarea`    | Not supported |   Use `string` as workaround |
| `email`       | Not supported |   Use `string` as workaround |
| `hidden`      | Not supported |   Use `string` as workaround |
| `color`       | Not supported |   Use `string` as workaround |
| `htmlsize`    | Not supported |   Use `string` as workaround |
| `csssize`     | Not supported |   Use `string` as workaround |
| `csssize4`    | Not supported |   Use `string` as workaround |
| `cssborder`   | Not supported |   Use `string` as workaround |


###### 3.2.2 Migrate Page field to Page (eZ Enterprise only)

**If** you use Page field (ezflow) and an eZ Enterprise subscription, and are ready to migrate your eZ Publish Flow content to the eZ Enterprise Page format, you can use a script to migrate your old Page content to new Page, to start using a pure eZ Enterprise setup. See [Migrating legacy Page field (ezflow) to new Page (Enterprise)](#migrating-legacy-page-field-ezflow-to-new-page-enterprise) for more information.

###### 3.2.3 Add other eZ Enterprise schemas (eZ Enterprise only)

For date-based publisher and form builder, there are additional tables, you can import them to your database using the following sql files:
`<new-ez-root>/vendor/ezsystems/date-based-publisher/bundle/Resources/install/datebasedpublisher_scheduled_version.sql`,
`<new-ez-root>/vendor/ezsystems/ezstudio-form-builder/bundle/Resources/install/form_builder.sql`, `<new-ez-root>/vendor/ezsystems/ezstudio-notifications/bundle/Resources/install/ezstudio-notifications.sql`

### Step 4: Re-configure web server and proxy

#### Varnish *(optional)*

If you use Varnish, the recommended Varnish (4 or higher) VCL configuration can be found in the `doc/varnish` folder. See also the [Using Varnish](../guide/http_cache.md#using-varnish) page.

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
# in vendor/ezsystems/ezplatform-kernel/eZ/Publish/Core/settings/storage\_engines/common.yaml
    ezpublish.persistence.slug_converter:
        class: '%ezpublish.persistence.slug_converter.class%'
        arguments:
            - '@ezpublish.api.storage_engine.transformation_processor'
            - { transformation: urlalias_compat }
```

In case of URLs with extended UTF-encoded names, the workaround must make use of `urlalias_iri`:

``` yaml
    ezpublish.persistence.slug_converter:
        class: '%ezpublish.persistence.slug_converter.class%'
        arguments:
            - '@ezpublish.api.storage_engine.transformation_processor'
            - { transformation: urlalias_iri }
```


## Migrating legacy Page field (ezflow) to new Page (Enterprise)

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

**5.** You will be warned about the need to create a [backup](../guide/backup.md) of your database. **Proceed only if you are sure you have done it.**

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

For blocks that could not be mapped to existing Page blocks, it will also generate PHP file templates that you need to fill with your own business logic.
