---
description: Install the Shopping list LTS update.
editions: lts-update commerce
month_change: true
---

# Install Shopping list

## Install framework

Run the following command to install the package:

``` bash
composer require ibexa/shopping-list
```

TODO: Describe what install does

Check that the following line have been added by the recipe to `config/bundles.php` file's array:
```php
    Ibexa\Bundle\ShoppingList\IbexaShoppingListBundle::class => ['all' => true],
```

## Modify database schema

Add the tables needed by the bundle:

=== "MySQL"

    ```bash
    php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/shopping-list/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <password> <database_name>
    ```

=== "PostgreSQL"

    ```bash
    php bin/console ibexa:doctrine:schema:dump-sql --force-platform=postgres vendor/ibexa/shopping-list/src/bundle/Resources/config/schema.yaml | psql <database_name>
    ```

TODO: possible charset issue, see https://github.com/ibexa/doctrine-schema/pull/38

TODO: ~~Default shopping list creation for existing customers?~~ The default shopping lists are created when used.

## Configure

By default, the maximum shopping list count per user is 10 and the maximum entries per list is 100.

TODO: explain `list_per_page_limit`

You can override the following parameters to change their values:

```yaml
parameters:
    ibexa.site_access.config.default.shopping_list.limits.max_lists_per_user: 10
    ibexa.site_access.config.default.shopping_list.limits.max_entries_per_list: 100
    ibexa.site_access.config.default.shopping_list.pagination.list_per_page_limit: 25
```

TODO: Probably a file that will be created by recipe:

```yaml
# config/routes/ibexa_shopping_list.yaml

ibexa.shopping_list:
    resource: '@IbexaShoppingListBundle/Resources/config/routing.php'

ibexa.rest.shopping_list:
    resource: '@IbexaShoppingListBundle/Resources/config/routing_rest.php'
    prefix: '%ibexa.rest.path_prefix%'
```

TODO: Add `shopping_list/*` permissions to the right roles. Don't give the rights to Anonymous. Role migration file example? Set limitation 'Shopping List Owner: Self' so regular customers can't access each other lists.
