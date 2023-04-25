---
description: Use PHP API to manage shipping methods in Commerce. Create and update shipping methods, delete shipping methods and their translations.
edition: commerce
---

# Shipping method API

!!! tip "Shipping management REST API"

    To learn how to manage shipping with the REST API, see the [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-shipping).

To get shipping methods and manage them, use the `Ibexa\Contracts\Checkout\ShippingMethodServiceInterface` interface.

Shipping methods are referenced with identifiers defined manually at method creation stage in user interface. 

## Get shipping method

### Get shipping method by identifier

To access a shipping method by using its identifier, use the `ShippingMethodServiceInterface::getShippingMethod` method.
The method takes a string as `$identifier` parameter and uses a prioritized language from SiteAccess settings unless you pass another language as `forcedLanguage`.

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 58, 68) =]]
```

### Get shipping method by ID

To access a shipping method by using its ID, use the `ShippingMethodServiceInterface::getShippingMethod` method.
The method takes a string as `$id` parameter and uses a prioritized language from SiteAccess settings unless you pass another language as `forcedLanguage`.

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 47, 56) =]]
```

## Get multiple shipping methods

To fetch multiple shipping methods, use the `ShippingMethodServiceInterface::getShippingMethod` method. 
It follows the same search query pattern as other APIs:

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 70, 88) =]]
```

## Create shipping method

To create a shipping method, use the `ShippingMethodServiceInterface::createShippingMethod` method and provide it with the `Ibexa\Contracts\Checkout\Value\ShippingMethodCreateStruct` object that you created by using the  `newShippingMethodCreateStruct` method.

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 90, 105) =]]
```

## Update shipping method

To update a shipping method, use the `ShippingMethodServiceInterface::updateShippingMethod` method and provide it with the `Ibexa\Contracts\Checkout\Value\ShippingMethodUpdateStruct`  object that you created by using the  `newShippingMethodUpdateStruct` method.

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 107, 117) =]]
```

## Delete shipping method

To update a shipping method, use the `ShippingMethodServiceInterface::deleteShippingMethod` method.

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 119, 125) =]]
```

## Delete shipping method translation

To delete shipping method translation, use the `ShippingMethodServiceInterface::deleteShippingMethodTranslation` method.

``` php
[[= include_file('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 127, 138) =]]
```