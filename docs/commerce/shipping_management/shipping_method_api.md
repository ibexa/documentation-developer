---
description: Use PHP API to manage shipping methods in Commerce. Create and update shipping methods, delete shipping methods and their translations.
edition: commerce
---

# Shipping method API

To get shipping methods and manage them, use the `Ibexa\Contracts\Shipping\ShippingMethodServiceInterface` interface.

Shipping methods are referenced with identifiers defined manually at method creation stage in user interface.

## Get shipping method

### Get shipping method by identifier

To access a shipping method by using its identifier, use the `ShippingMethodServiceInterface::getShippingMethod` method.
The method takes a string as `$identifier` parameter and uses a prioritized language from SiteAccess settings unless you pass another language as `forcedLanguage`.

``` php
[[= include_code('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 53, 62, remove_indent=True) =]]
```

### Get shipping method by ID

To access a shipping method by using its ID, use the `ShippingMethodServiceInterface::getShippingMethod` method.
The method takes a string as `$id` parameter and uses a prioritized language from SiteAccess settings unless you pass another language as `forcedLanguage`.

``` php
[[= include_code('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 41, 50, remove_indent=True) =]]
```

## Get multiple shipping methods

To fetch multiple shipping methods, use the `ShippingMethodServiceInterface::getShippingMethod` method.
It follows the same search query pattern as other APIs:

``` php
[[= include_code('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 65, 82, remove_indent=True) =]]
```

## Create shipping method

To create a shipping method, use the `ShippingMethodServiceInterface::createShippingMethod` method and provide it with the `Ibexa\Contracts\Shipping\Value\ShippingMethodCreateStruct` object that you created by using the  `newShippingMethodCreateStruct` method.

``` php
[[= include_code('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 85, 107, remove_indent=True) =]]
```

## Update shipping method

To update a shipping method, use the `ShippingMethodServiceInterface::updateShippingMethod` method and provide it with the `Ibexa\Contracts\Shipping\Value\ShippingMethodUpdateStruct`  object that you created by using the  `newShippingMethodUpdateStruct` method.

``` php
[[= include_code('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 110, 123, remove_indent=True) =]]
```

## Delete shipping method

To update a shipping method, use the `ShippingMethodServiceInterface::deleteShippingMethod` method.

``` php
[[= include_code('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 126, 131, remove_indent=True) =]]
```

## Delete shipping method translation

To delete shipping method translation, use the `ShippingMethodServiceInterface::deleteShippingMethodTranslation` method.

``` php
[[= include_code('code_samples/api/commerce/src/Command/ShippingMethodCommand.php', 134, 142, remove_indent=True) =]]
```
