---
description: Use PHP API to manage shipping methods in Commerce: create, update and delete shipping methods.
edition: commerce
---

# Shipping method API

!!! tip "Shipping management REST API"

    To learn how to manage shipping with the REST API, see the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-shipping).

To get shipping methods and manage them, use the `Ibexa\Contracts\Checkout\ShippingMethodServiceInterface` interface.

## Get shipping method

### Get shipping method by identifier

To access a shipping method  by using its identifier, use the `ShippingMethodServiceInterface::getShippingMethod` method.
The method takes a string as `$identifier` parameter and uses a prioritized language from SiteAccess settings unless you pass another language as `forcedLanguage`.

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', x, y) =]]
```

### Get shipping method by ID

To access a shipping method  by using its ID, use the `ShippingMethodServiceInterface::getShippingMethod` method.
The method takes a string as `$id` parameter and uses a prioritized language from SiteAccess settings unless you pass another language as `forcedLanguage`.

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', x, y) =]]
```

## Get multiple shipping methods

To fetch multiple shipping methods, use the `ShippingMethodServiceInterface::getShippingMethod` method. 
It follows the same search query pattern as other APIs:

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', x, y) =]]
```

## Create shipping method

To create a shipping method, use the `ShippingMethodServiceInterface::createShippingMethod` method and provide it with the `Ibexa\Contracts\Checkout\Value\ShippingMethodCreateStruct` object that contains ...

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', x, y) =]]
```

## Update shipping method

To update a shipping method, use the `ShippingMethodServiceInterface::updateShippingMethod` method and provide it with the `Ibexa\Contracts\Checkout\Value\ShippingMethodUpdateStruct` object that contains

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', x, y) =]]
```

## Delete shipping method

To update a shipping method, use the `ShippingMethodServiceInterface::deleteShippingMethod` method.

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', x, y) =]]
```
