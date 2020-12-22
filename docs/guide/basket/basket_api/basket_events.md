# Basket events [[% include 'snippets/commerce_badge.md' %]]

## Basket event listeners

### StandardBasketListener

The basket comes with a standard event listener that provides the following checks:

- check whether the quantity is valid for a `catalogElement`
- check for a minimum quantity 
- check for a maximum quantity
- check the packaging unit
- purge the basket cache after changes in the basket

### DiscontinuedProductsListener

This listener handles discontinued products. It is active when it's enabled in configuration:

``` yaml
siso_basket.default.discontinued_products_listener_active: true
```

This listener is only active for products that are marked as discontinued.

``` php
$catalogElement.dataMap.discontinued = new TextLineField(array('text' => 1));
```

If stock is not available, an error message is displayed that there is no information about the availability for product, but it is discontinued.

It stock is 0, the item is removed from the basket and an error message is displayed that the item is discontinued and not available anymore.

If the ordered quantity is larger than stock, the quantity is modified in the basket line and a notice message is set in the basket.

## BasketLine Events

The following events are thrown when interacting with the [`BasketService`](basketservice.md) on a basket line object.

| Event name         | Dispatched in         | Event ID             |
| ------------------ | --------------------- | -------------------- |
| `PreAddBasketLineEvent` | `BasketService.addBasketLineToBasket()` | `silver_eshop.pre_add_basketline` |
| `PostAddBasketLineEvent` | `BasketService.addBasketLineToBasket()` | `silver_eshop.post_add_basketline` |
| `PreUpdateBasketLineEvent` | `BasketService.updateBasketLineInBasket()` | `silver_eshop.pre_update_basketline` |
| `PostUpdateBasketLineEvent` | `BasketService.updateBasketLineInBasket()` | `silver_eshop.post_update_basketline` |
| `PreRemoveBasketLineEvent` | `BasketService.removeBasketLineFromBasket()` | `silver_eshop.pre_remove_basketline` |
| `PostRemoveBasketLineEvent` | `BasketService.removeBasketLineFromBasket()` | `silver_eshop.post_remove_basketline` |

## Basket Events

The following events are thrown when interacting with the [BasketService](basketservice.md) on a basket object.

|Event name|Dispatched in|Event ID|
|--- |--- |--- |
|`PostPriceCalculationBasketEvent`|`BasketService:storeBasket()`|`silver_eshop.post_price_calculation_basket`|
|`PreBasketShowEvent`|`BasketController:showBasket()`|`silver_eshop.pre_basket_show`|
|`PreRemoveBasketEvent`|`BasketService:removeBasket()`|`silver_eshop.pre_remove_basket`|
