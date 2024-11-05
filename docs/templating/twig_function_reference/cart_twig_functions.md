---
description: Cart Twig functions enable checking whether product can be added to cart and formatting the price.
edition: commerce
page_type: reference
---

# Cart Twig functions

You can use cart Twig functions to check whether products can be added to cart, or to format the price value.

### `ibexa_can_be_added_to_cart()`

The `ibexa_can_be_added_to_cart()` function checks whether the provided product can be added to cart. It eliminates products that are not available, products that do not have a price that corresponds to a currency selected for the cart, and products, for which VAT category is not set. It also eliminates products that have variants but are not one of those variants. 

``` html+twig
{% set is_disabled = (is_disabled or ibexa_can_be_added_to_cart(product) == false)|default(false) %}
```

