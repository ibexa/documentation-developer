# Basket storage time

The time for which a basket is stored depends on whether the basket belongs to an anonymous user or a logged-in user.

A basket for a logged-in customer is stored forever.

A basket for an anonymous user is stored for 120 hours by default.
You can configure a different value:

``` yaml
parameters: 
    ses_basket.default.validHours: 120
```

You can use the `silversolutions:baskets:clear` command to delete anonymous expired baskets:

``` bash
php bin/console silversolutions:baskets:clear <validHours>
```

It deletes all anonymous baskets from the database that are older than `validHours`.

For example

``` bash
php bin/console silversolutions:baskets:clear 720
```
