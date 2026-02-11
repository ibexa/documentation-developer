---
description: Install the Shopping list LTS update.
editions: lts-update commerce
month_change: true
---

# Install shopping list

## Install framework

Run the following command to install the package:

``` bash
composer require ibexa/shopping-list
```

The associated recipe declares the bundle and its routes.

Check that the following line have been added by the recipe to `config/bundles.php` file's array:
```php
    Ibexa\Bundle\ShoppingList\IbexaShoppingListBundle::class => ['all' => true],
```

And that you have a `config/routes/ibexa_shopping_list.yaml` file configuring the following routes:

```yaml
ibexa.shopping_list:
    resource: '@IbexaShoppingListBundle/Resources/config/routing.php'

ibexa.rest.shopping_list:
    resource: '@IbexaShoppingListBundle/Resources/config/routing_rest.php'
    prefix: '%ibexa.rest.path_prefix%'
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

Notice that a user has no shopping list at this stage, not even the default "My Wishlist" one.
Each user's default shopping list is created when used for the first time.

## Configure

By default, the maximum shopping list count per user is 10 and the maximum entries per list is 100.
When listing their shopping list, the use see 25 lists per page
(and as it's over the shopping list count, there is always one page of shopping lists in this default scenario).

You can override the following parameters to change their values:

```yaml
parameters:
    ibexa.site_access.config.default.shopping_list.limits.max_lists_per_user: 10
    ibexa.site_access.config.default.shopping_list.limits.max_entries_per_list: 100
    ibexa.site_access.config.default.shopping_list.pagination.list_per_page_limit: 25
```

!!! caution "Max lists per user and default shopping list"

    Notice that if a customer reach the `max_lists_per_user`, if not already created, this customer can still create the default shopping list.
    So, for 10 as the default limit, the user may have 11 lists if the user created 10 custom lists before even creating the default one.
    If you want to restrict to only the default shopping list, you can set `max_lists_per_user` to 0.

### Shopping list user role

Create a new role and then assign it to registered customer groups who should be able to use this feature.
The four functions from the Shopping List module must be granted with the limitation 'Shopping List Owner: Self' to restrict authenticated users to only their own lists.
Anonymous users can't have shopping lists as they're internally sharing the same account.

To create such role, you can use a [migration file](importing_data.md#roles), for example, with the following content:

``` yaml
[[= include_file('code_samples/shopping_list/install/src/Migrations/Ibexa/migrations/shopping_list_user.yaml', 4, 29) =]]
```

On a clean install, you can, for example, assign this "Shopping List User" role to the "Customers" user group.

If saved as `src/Migrations/Ibexa/migrations/shopping_list_user.yaml`, it can be imported with the command
`php bin/console ibexa:migrations:migrate --file=shopping_list_user.yaml --siteaccess=admin`.
