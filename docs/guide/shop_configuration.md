# Shop configuration

## Basket [[% include 'snippets/commerce_badge.md' %]]

### Basket storage time

The time for which a basket is stored depends on whether the basket belongs to an anonymous user or a logged-in user.

A basket for a logged-in customer is stored forever.

A basket for an anonymous user is stored for 120 hours by default.
You can configure a different value:

``` yaml
ibexa.commerce.site_access.config.basket.default.validHours: 120
```

You can use the `ibexa:commerce:clear-baskets` command to delete expired baskets:

``` bash
php bin/console ibexa:commerce:clear-baskets <validHours>
```

It deletes all baskets from the database that are older than `validHours`.

For example:

``` bash
php bin/console ibexa:commerce:clear-baskets 720
```

### Product quantity validation

You can configure the minimum and maximum quantity that can be ordered per basket line:

``` yaml
ibexa.commerce.basket.basketline_quantity_max: 1000000
ibexa.commerce.basket.basketline_quantity_min: 1
```

If the quantity is more than the maximum or less than the minimum, it is set to either max or min.

### Shared baskets

A basket can be shared if a user logs in from a different browser (default), or it can be bound to the session.

If you do not want the basket to be shared between different sessions, change the following setting to `true`:

``` yaml
ibexa.commerce.site_access.config.basket.default.basketBySessionOnly: true
```

## Navigation

The `navigation_ez_location_root` parameter is the entry root Location point for the whole navigation in the Back Office.
This value is usually set to `2`, the Location of the content structure.

``` yaml
parameters:
    ibexa.commerce.site_access.config.core.default.navigation_ez_location_root: 2
    ibexa.commerce.site_access.config.core.default.navigation_ez_depth: 3
    ibexa.commerce.site_access.config.core.default.navigation_sort_order: 'asc'
```

The `navigation_ez_depth` parameter is responsible for the main navigation depth.
Content from the Back Office is fetched only up to this depth.
This does not include the product catalog, which has its own depth specified.

Use `navigation_sort_order` to set the order of sorting by priority.
