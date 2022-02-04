---
latest_tag: '4.0.0'
---

# Update from v3.3.x to v4.0

This update procedure applies if you are using v3.3.

Go through the following steps to update to v4.0.

Besides updating the application and database, you need to account for changes related to code refactoring and numerous namespace changes.
See [a list of all changed namespaces, configuration key, service names, and other changes](../../releases/ibexa_dxp_v4.0_deprecations.md#configuration-files-names).

An additional compatibility layer makes the process of updating your code easier.

## Update the app to v4.0

``` bash
composer require ibexa/content:4.0.0 --with-all-dependencies --no-scripts
composer recipes:install ibexa/content --force -v
```

The `recipes:install` command installs new YAML configuration files,
which have been [renamed in this release](../../releases/ibexa_dxp_v4.0_deprecations.md#configuration-files-names).

Look through the old YAML files and move your custom configuration to the relevant new files.

## Prepare new database tables

For every database connection you have configured, perform the following steps:

1. Run `php bin/console doctrine:schema:update --dump-sql --em=ibexa_{connection}`
2. Check the queries and verify that they are safe and will not damage the data.
3. Run `php bin/console doctrine:schema:update --dump-sql --em=ibexa_{connection} --force`

Next, run the following commands to import necessary data migration scripts:

``` bash
php bin/console ibexa:migrations:import vendor/ibexa/taxonomy/src/bundle/Resources/install/migrations/content_types.yaml --name=000_taxonomy_content_types.yml
php bin/console ibexa:migrations:import vendor/ibexa/taxonomy/src/bundle/Resources/install/migrations/sections.yaml --name=001_taxonomy_sections.yml
php bin/console ibexa:migrations:import vendor/ibexa/taxonomy/src/bundle/Resources/install/migrations/content.yaml --name=002_taxonomy_content.yml
php bin/console ibexa:migrations:import vendor/ibexa/taxonomy/src/bundle/Resources/install/migrations/permissions.yaml --name=003_taxonomy_permissions.yml
```

Run `php bin/console ibexa:migrations:migrate -v --dry-run` to ensure that all migrations are ready to be performed.
If the dry run is successful, run:

``` bash
php bin/console ibexa:migrations:migrate
```

## Update your custom code

### Add compatibility layer package

You can use the provided compatibility layer to speed up adaptation of your custom code to the new namespaces.

Add the compatibility layer package using Composer:

``` bash
composer require ibexa/compatibility-bundle
composer recipes:install ibexa/compatibility-layer --force
```

### Online editor

#### Custom plugins and buttons

If you added your own Online Editor plugins or buttons, you need to rewrite them
using [CKEditor 5's extensibility](https://ckeditor.com/docs/ckeditor5/latest/framework/guides/plugins/creating-simple-plugin.html).

#### Custom tags

If you created a custom tag, you need to adapt it to the new configuration, for example:

``` yaml
ibexa:
    system:
        admin_group:
            fieldtypes:
                ezrichtext:
                    custom_tags: [ezfactbox]
                    toolbar:
                        custom_tags_group:
                            buttons:
                                ezfactbox:
                                    priority: 5
```

### Personalization

In Personalization, the `included_content_types` configuration key has changed to `included_item_types`.
Update your configuration, if it applies.

## Update the database

Apply the following database update script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-3.3.latest-to-4.0.0.sql
```

``` bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-3.3.latest-to-4.0.0.sql
```

## Finish update

Then, finish the update process:

``` bash
composer run post-install-cmd
```
