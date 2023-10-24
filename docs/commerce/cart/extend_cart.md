---
description: Extend cart with new options.
edition: commerce
---

# Extend cart

This section covers available extensions for the [[= product_name =]] cart feature.

## Adding context data

Context data is extra information that you can attach to the cart or cart entries to provide additional details or attributes related to the shopping experience. 
It can include any relevant information that you want to associate with a particular cart or cart entry, for example, coupon codes, custom products attributes or user preferences.

### Adding context data to a cart

To add context data to a cart, follow this example:

```php 
$createStruct = new CartCreateStruct(...);
$createStruct->setContext(new ArrayMap([
    'coupon_code' => 'X1MF7699',
]));

$cart = $cartService->createCart($createStruct);
```

In the above example, you create a cart using the `CartCreateStruct`, 
and set the context data using the `setContext` method.
You've also added "X1MF7699" coupon code as context data to the cart.

### Adding context data to a cart entry

To attach context data to a cart entry, proceed as follows:

```php
$entryAddStruct = new EntryAddStruct(...);
$entryAddStruct->setContext(new ArrayMap([
    'tshirt_text' => 'EqEqEqEq',
]));

 $cartService->addEntry($cart, $entryAddStruct);
```

In the above example, you create a cart entry using the `EntryAddStruct`. 
The `setContext` method allows you to attach context data to the cart entry. 
In this case, you've attached a "tshirt_text" attributed to the cart entry, which might represent custom text for a T-shirt.