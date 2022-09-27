---
description: Events that are triggered when working with the basket and checkout.
edition: commerce
---

# Shop events

## BasketLine Events

The following events are dispatched when interacting with the `BasketService` on a basket line object.

| Event name         | Dispatched by         |
| ------------------ | --------------------- |
| `PreAddBasketLineEvent` | `BasketService.addBasketLineToBasket()` |
| `PostAddBasketLineEvent` | `BasketService.addBasketLineToBasket()` |
| `PreUpdateBasketLineEvent` | `BasketService.updateBasketLineInBasket()` |
| `PostUpdateBasketLineEvent` | `BasketService.updateBasketLineInBasket()` |
| `PreRemoveBasketLineEvent` | `BasketService.removeBasketLineFromBasket()` |
| `PostRemoveBasketLineEvent` | `BasketService.removeBasketLineFromBasket()` |

## Basket Events

The following events are dispatched when interacting with the `BasketService` on a basket object.

|Event name|Dispatched by|
|--- |--- |
|`PostPriceCalculationBasketEvent`|`BasketService:storeBasket()`|
|`PreBasketShowEvent`|`BasketController:showBasket()`|
|`PreRemoveBasketEvent`|`BasketService:removeBasket()`|

# Checkout events

The following events are dispatched during the checkout process:

| Event     | Dispatched |
| --------- | ---------- |
| `PreCheckoutEvent` | Before user enters the checkout process         |
| `PreFormCheckoutEvent` | Before form preparation in the checkout process |
| `PostFormCheckoutEvent` | After form preparation in the checkout process  |
| `MessageResponseEvent` | After an event is placed |
