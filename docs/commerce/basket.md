---
description: The basket functionality covers the shopping basket, as well as wishlist and stored, named baskets.
edition: commerce
---

# Basket

## Overview

![](basket.png)

Baskets are stored in the database and identified by: 

- session ID (if the user is not logged in)
- user ID (if the user is logged in)

A basket can be of one of the following types:

- `basket`
- [`quickOrder`](quick_order.md)
- [`storedBasket`](wishlist_and_stored_baskets.md)
- [`wishList`](wishlist_and_stored_baskets.md)

A standard basket (type `basket`) can have different states during the checkout process. After the order is sent, the basket is assigned the state `ordered`.

Data validation, such as for the minimum order amount, only happens when adding products to the shopping basket,
not to wishlist, or stored basket.

## Basket structure

Apart from the identifying information, the basket data model contains the following elements:

- additional fields (`dataMap` Field)
- basket lines with information for each row of the basket
- information about basket parties (buyer, invoice and delivery)
- additional costs (such as shipping, packaging, discounts etc.)

## Basket configuration 

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
