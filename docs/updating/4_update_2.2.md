# Updating from <2.2
    
If you are updating from a version prior to 1.13, you have to implement all the changes from [Updating from <1.13](4_update_1.13.md) before following the steps below.

!!! note

    During database update, you have to go through all the changes between your current version and your final version
    **e.g. during update from v2.2 to v2.5 you have to perform all the steps from: <2.3, <2.4 and <2.5**.
    Only after applying all changes your database will work properly.

## Change from UTF8 to UTF8MB4

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

After successfully running those statements, change the character set and collation for each table, as described in [kernel upgrade documentation.](https://github.com/ezsystems/ezpublish-kernel/blob/v7.2.4/doc/upgrade/7.2.md)

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

## Page builder

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

## Migrate Landing Pages

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

The Page Builder in 2.2 does not offer all blocks that Landing Page editor did. The removed blocks include Schedule and Form blocks.
The Places Page Builder block has been removed from the clean installation and will only be available in the demo out of the box. If you had been using this block in your site, re-apply its configuration based on the [demo](https://github.com/ezsystems/ezplatform-ee-demo/blob/v2.2.2/app/config/blocks.yml)
Later versions of Page Builder come with a Content Scheduler block, but migration of Schedule blocks to Content Scheduler blocks is not supported. 

If there are missing block definitions, such as Form Block or Schedule Block,
you have an option to continue, but migrated Landing Pages will come without those blocks.

!!! tip

    If you use different repositories with different SiteAccesses, use the `--siteaccess` switch
    to migrate them separately.

!!! tip

    You can use the `--dry-run` switch to test the migration.

After the migration is finished, you need to clear cache.

### Migrate layouts

The `ez_block:renderBlockAction` controller used in layout templates has been replaced by `EzPlatformPageFieldTypeBundle:Block:render`. This controller has two additional parameters, `locationId` and `languageCode`. Only `languageCode` is required.
Also, the html class `data-studio-zone` has been replaced with `data-ez-zone-id`
See [documentation](../guide/page_rendering.md#layout-template) for an example on usage of the new controller.

### Migrate custom blocks

Landingpage blocks (2.1 and earlier) was defined using a class implementing `EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType`. 
In pagebuilder (2.2), this interface is no longer present. Instead the logic of your block must be implemented in a [Listener](../guide/extending/extending_page.md#block-rendering-events).
Typically, what you previously would do in `getTemplateParameters()`, you'll now do in the `onBlockPreRender()` event handler.

The definition of block parameters has to be moved from `createBlockDefinition()` to the [YAML configuration](../guide/extending/extending_page.md#creating-page-blocks) for your custom blocks.

More information about how custom blocks are implemented in Pagebuilder, please have a look at the [documentation](../guide/extending/extending_page.md)

For the migration of blocks from landingpage you Pagebuilder, you'll need to provide a converter for attributes of custom blocks. For simple blocks you can use `\EzSystems\EzPlatformPageMigration\Converter\AttributeConverter\DefaultConverter`.
Custom converters must implement the `\EzSystems\EzPlatformPageMigration\Converter\AttributeConverter\ConverterInterface` interface.
`convert()` will parse XML `\DOMNode $node` and return an array of `\EzSystems\EzPlatformPageFieldType\FieldType\LandingPage\Model\Attribute` objects.

Below is an example of a simple converter for a custom block:

``` yaml
    app.block.foobar.converter:
        class: EzSystems\EzPlatformPageMigration\Converter\AttributeConverter\DefaultConverter
        tags:
            - { name: ezplatform.fieldtype.ezlandingpage.migration.attribute.converter, block_type: foobar }
```

Notice service tag `ezplatform.fieldtype.ezlandingpage.migration.attribute.converter` that must be used for attribute converters.

This converter is only needed when running the `ezplatform:page:migrate` script and can be removed once that has completed.

#### Example on how to migrate layouts and blocks to the new Page Builder

In the `upgraded_to_2.2` branch in this [git repo](https://github.com/ezsystems/ezplatform-ee-beginner-tutorial/tree/upgraded_to_2.2) you may see an example on how to migrate your source code in order to make a layout and a block work with the new Page Builder.

You can now follow the steps from [Updating from <2.3](4_update_2.3.md).
