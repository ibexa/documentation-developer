---
description: Configure shopping list limits and the shopping list user role.
edition: commerce
month_change: false
---

# Configure shopping list

## Configure limits

By default, the maximum shopping list count per user is 10 and the maximum entries per list is 100.
When listing their shopping lists, the user see 25 lists per page
(and as it's over the shopping list count, there is always one page of shopping lists in this default scenario).

You can override the following parameters to change their values:

```yaml
parameters:
    ibexa.site_access.config.default.shopping_list.limits.max_lists_per_user: 10
    ibexa.site_access.config.default.shopping_list.limits.max_entries_per_list: 100
    ibexa.site_access.config.default.shopping_list.pagination.list_per_page_limit: 25
```

!!! caution "Max lists per user and default shopping list"

    The customer can always create the default shopping list if it doesn't exist yet, even if they have already reached the limit defined by `max_lists_per_user`.
    So, for 10 as the default limit, the user may have 11 lists if the user created 10 custom lists before creating the default one.
    If you want to restrict users to only the default shopping list, you can set `max_lists_per_user` to 0.

## Shopping list user role

To allow customers to use the shopping list feature, create a new role and assign it to registered customer groups.
To restrict authenticated users access to only their own lists, you must grant the four functions from the Shopping List module with the limitation 'Shopping List Owner: Self'.
Otherwise, they will be able to interact with all shopping lists existing in the system.
Anonymous users can't have shopping lists as they're internally sharing the same account.

To create such role, you can use a [migration file](importing_data.md#roles), for example, with the following content:

``` yaml
[[= include_file('code_samples/shopping_list/install/src/Migrations/Ibexa/migrations/shopping_list_user.yaml', 4, 29) =]]
```

On a clean install, you can, for example, assign this "Shopping List User" role to the "Customers" user group.

After placing the migration content in `src/Migrations/Ibexa/migrations/shopping_list_user.yaml`, you can import and execute it with:

```bash
php bin/console ibexa:doctrine:migrations:migrate --file=shopping_list_user.yaml --siteaccess=admin
```
