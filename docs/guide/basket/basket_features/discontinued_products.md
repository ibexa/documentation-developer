# Discontinued products

A listener can check if a product is not sold anymore (discontinued), so the user can be informed that this product is not available any more. This feature can be disabled by setting `discontinued_products_listener_active` to false:

``` yaml
siso_basket.default.discontinued_products_listener_active: true
```

The listener will check if the current stock is equal or greater than the quantity the customer wants to order. In this case the order is allowed. The optional config setting `discontinued_products_listener_consider_packaging_unit` enables skipping the packaging unit in order to sell the remaining products even if remaining stock does not fit to the packing unit rule (e.g. packing unit = 10 pieces but 9 are left in stock). The listener reduces the quantity in the order to the number of products which are in stock. 

``` yaml
siso_basket.default.discontinued_products_listener_consider_packaging_unit: true
```
