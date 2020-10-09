# Product quantity validation

The quantity of added products is validated in different places.

## In the BasketController

A helper function `validateQuantity()` checks if the given quantity (string) corresponds to the rules set e.g. for float value. If the quantity matches, it is converted into a valid float value.

If the quantity doesn't validate, the quantity is just returned, but not changed - it is validated in `StandardBasketListener`.

- `addAction()` - After the quantity is validated, the `addAction` checks if it is 0. If so it is changed to 1.
- `updateAction()` - After the quantity is validated, the `updateAction` checks if it is 0. If so the `deleteAction()` is called and removes the product  from the basket.

## `StandardBasketListener`

- Checks whether the given quantity is valid (e.g. negative numbers or strings are not allowed). If it is not valid, the action is not allowed (`STATUS_FAILED`).
- Checks whether the given quantity is more than max or less than min. If so, it is set to either max or min.

In standard config in `vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/config/basket.yml`:

``` yaml
silver_basket.basketline_quantity_max: 1000000
silver_basket.basketline_quantity_min: 1
```
