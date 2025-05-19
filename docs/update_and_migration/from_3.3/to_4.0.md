---
description: Update your installation to v4.0 from the latest v3.3 version.
month_change: false
---

# Update from v3.3.x to v4.0

This update procedure applies if you're using v3.3.

Go through the following steps to update to v4.0.

Besides updating the application and database, you need to account for changes related to code refactoring and numerous namespace changes.
See [a list of all changed namespaces, configuration key, service names, and other changes](ibexa_dxp_v4.0_deprecations.md).

An additional compatibility layer makes the process of updating your code easier.

[[% include 'snippets/update/temporary_v4_conflicts.md' %]]

!!! note "Symfony 5.4"

    If you're using Symfony 5.3, you need to update your installation to Symfony 5.4.
    To do this, update your composer.json to refer to `5.4.*` instead or `5.3.*`.

    Refer to the relevant website skeleton for an example: [content](https://github.com/ibexa/content-skeleton/blob/v4.0.1/composer.json), [experience](https://github.com/ibexa/experience-skeleton/blob/v4.0.1/composer.json), [commerce](https://github.com/ibexa/commerce-skeleton/blob/v4.0.1/composer.json).

## Update the app to v4.0

First, run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_0 =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_0 =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_0 =]] --with-all-dependencies --no-scripts
    ```

### Update Flex server

The `flex.ibexa.co` Flex server has been disabled.
If you're using v4.0.2 or earlier v4.0 version, you need to update your Flex server.

To do it, in your `composer.json` check whether the `https://flex.ibexa.co` endpoint is still listed in `extra.symfony.endpoint`. 
If so, replace it with the new [`https://api.github.com/repos/ibexa/recipes/contents/index.json?ref=flex/main`](https://github.com/ibexa/website-skeleton/blob/v4.0.7/composer.json#L98) endpoint.

If your `composer.json` still uses the `https://flex.ibexa.co` endpoint in `extra.symfony.endpoint`, 
replace it with the new [`https://api.github.com/repos/ibexa/recipes/contents/index.json?ref=flex/main`](https://github.com/ibexa/website-skeleton/blob/v4.0.7/composer.json#L96) endpoint.

You can do it manually, or by running the following command:

``` bash
composer config extra.symfony.endpoint "https://api.github.com/repos/ibexa/recipes/contents/index.json?ref=flex/main"
```

Next, continue with updating the app:

=== "[[= product_name_content =]]"

    ``` bash
    composer recipes:install ibexa/content --force -v
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer recipes:install ibexa/experience --force -v
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer recipes:install ibexa/commerce --force -v
    ```

The `recipes:install` command installs new YAML configuration files,
which have been [renamed in this release](ibexa_dxp_v4.0_deprecations.md#configuration-file-names).

Look through the old YAML files and move your custom configuration to the relevant new files.

In `bundles.php`, remove all entries starting with `eZ`, `EzSystems`, `Ibexa\Platform`, `Silversolutions` and `Siso`.
Leave only third-party entires and entries added by the `recipes:install` command, starting with `Ibexa\Bundle`.

## Add compatibility layer package

You can use the provided compatibility layer to speed up adaptation of your custom code to the new namespaces.

Add the compatibility layer package using Composer:

``` bash
composer require ibexa/compatibility-layer
composer recipes:install ibexa/compatibility-layer --force
```

Make sure that `Ibexa\Bundle\CompatibilityLayer\IbexaCompatibilityLayerBundle` is last in your bundle list in `config/bundles.php`.

Next, clear the cache:

``` bash
php bin/console cache:clear
```

## Update the database

Apply the following database update script:

### [[= product_name =]]

=== "MySQL"
    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-3.3.latest-to-4.0.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-3.3.latest-to-4.0.0.sql
    ```

### Ibexa Open Source

If you have no access to [[= product_name =]]'s `ibexa/installer` package, apply the following database upgrade script:

=== "MySQL"
    ``` sql
    ALTER TABLE `ezcontentclassgroup` ADD COLUMN `is_system` BOOLEAN NOT NULL DEFAULT false;
    ```

=== "PostgreSQL"
    ``` sql
    ALTER TABLE "ezcontentclassgroup" ADD "is_system" boolean DEFAULT false NOT NULL;
    ```

### Prepare new database tables

For every database connection you have configured, perform the following steps:

1. Run `php bin/console doctrine:schema:update --dump-sql --em=ibexa_{connection}`
2. Check the queries and verify that they're safe and don't damage the data.
3. Run `php bin/console doctrine:schema:update --dump-sql --em=ibexa_{connection} --force`

Next, run the following commands to import necessary data migration scripts:

``` bash
php bin/console ibexa:migrations:import vendor/ibexa/taxonomy/src/bundle/Resources/install/migrations/content_types.yaml --name=000_taxonomy_content_types.yml
php bin/console ibexa:migrations:import vendor/ibexa/taxonomy/src/bundle/Resources/install/migrations/sections.yaml --name=001_taxonomy_sections.yml
php bin/console ibexa:migrations:import vendor/ibexa/taxonomy/src/bundle/Resources/install/migrations/content.yaml --name=002_taxonomy_content.yml
php bin/console ibexa:migrations:import vendor/ibexa/taxonomy/src/bundle/Resources/install/migrations/permissions.yaml --name=003_taxonomy_permissions.yml
php bin/console ibexa:migrations:import vendor/ibexa/product-catalog/src/bundle/Resources/migrations/product_catalog.yaml --name=001_product_catalog.yaml
php bin/console ibexa:migrations:import vendor/ibexa/product-catalog/src/bundle/Resources/migrations/currencies.yaml --name=001_currencies.yaml
```

Run `php bin/console ibexa:migrations:migrate -v --dry-run` to ensure that all migrations are ready to be performed.
If the dry run is successful, run:

``` bash
php bin/console ibexa:migrations:migrate
```

## Update your custom code

### GraphQL

TODO: Confirm it happens between 3.3 and 4.0

Some GraphQL names have changed. Adapt your queries according to the table below.

TODO: Complete the list of renamed elements

| 3.3 name                                                      | 4.0 name                                                |
|:--------------------------------------------------------------|:--------------------------------------------------------|
| `id` argument                                                 | `contentId` argument                                    |
| `_info` content item property                                 | `_contentInfo` content item property                    |
| `<ContentType>Content` (example: `FolderContent`)             | `<ContentType>Item` (example: `FolderItem`)             |
| `create<ContentType>Content` (example: `createFolderContent`) | `create<ContentType>Item` (example: `createFolderItem`) |

TODO: Example with more renamed elements
TODO: Example with mutations

Example of an updated query:

<table>
<thead><tr><th scope="col">3.3</th><th scope="col">4.0</th></tr></thead>
<tbody>
<tr><td class="compare">
```graphql
{
  content {
    folder(id: 1) {
      _info {
        id
        name
      }
    }
  }
}
```
</td><td class="compare">
```graphql
{
  content {
    folder(contentId: 1) {
       _contentInfo{
        id
        name
      }
    }
  }
}
```
</td></tr>
</tbody></table>

Notice that the argument have been updated to `contentId` while the `id` property keeps its name.

While revisiting GraphQL queries, you may consider the new feature `item`
allowing to fetch a content item without knowing its content type.
For more information, see [Get a content item](graphql_queries.md#get-a-content-item).

### Back office customization

The v4 version of [[= product_name =]] is using Bootstrap 5 in the back office. If you were using Bootstrap 4 for styling, you need to update and adjust all custom back office components [following the migration guide from Bootstrap 4](https://getbootstrap.com/docs/5.0/migration/).

### Online editor

#### Custom plugins and buttons

If you added your own Online Editor plugins or buttons, you need to rewrite them
using [CKEditor 5's extensibility](https://ckeditor.com/docs/ckeditor5/latest/tutorials/crash-course/plugins.html#creating-custom-plugins).

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

## Finish update

Adapt your `composer.json` file according to [`manifest.json`](https://github.com/ibexa/recipes/blob/master/ibexa/commerce/4.0/manifest.json#L170-L171), by adding the following lines:

``` json hl_lines="2-3"
"yarn install": "script",
"ibexa:encore:compile --config-name app": "symfony-cmd",
"bazinga:js-translation:dump %PUBLIC_DIR%/assets --merge-domains": "symfony-cmd",
"ibexa:encore:compile": "symfony-cmd"
```

Then, finish the update process:

``` bash
composer run post-install-cmd
```

Finally, generate the new GraphQl schema:

``` bash
php bin/console ibexa:graphql:generate-schema
```

### Ibexa Cloud

Update Platform.sh configuration and scripts.

Generate new configuration with the following command:

```bash
composer ibexa:setup --platformsh
```

Review the changes applied to `.platform.app.yaml`, `.platform/` and `bin/platformsh_prestart_cacheclear.sh`,
merge with your custom settings if needed, and commit them to Git.
