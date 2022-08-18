---
description: Use PHP API to manage products in the catalog, their attributes, availability and prices.
---

# Product API

## Products

To access products from the PHP API, use the `ProductServiceInterface` to request information,
or `LocalProductServiceInterface` to modify products.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 62, 65) =]]
```

You can find multiple products with `productService::findProducts()`.
Provide the method with optional filter, query or Sort Clauses.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 66, 76) =]]
```

### Modifying products

To create, update and delete products, use the `LocalProductServiceInterface`.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 87, 91) =]]
```

To create a product, use `LocalProductService::newProductCreateStruct()`.
Provide the method with the product type object and the main language code.
You also need to set (at least) the code for the product and the required Field of the underlying Content Type, `name`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 77, 84) =]]
```

To delete a product, use `LocalProductService::deleteProduct()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 115, 116) =]]
```

## Product types

To work with product types, use `ProductTypeServiceInterface`.

Get a product type object by using `ProductTypeServiceInterface::getProductType`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 43, 44) =]]
```

You can also get a list of product types with `ProductTypeServiceInterface::findProductTypes`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 47, 52) =]]
```

## Product availability

Product availability is an object which defines whether a product is available, and if so, in what stock.
To manage it, use `ProductAvailabilityServiceInterface`.

To check whether a product is available (with or without stock defined), use `ProductAvailabilityServiceInterface::hasAvailability`.

Get the availability object with `getAvailability()`.
You can then use `ProductAvailabilityServiceInterface::getStock` to get the stock number for the product:

```php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 98, 103) =]]        }
```

To change availability for a product, use `updateProductAvailability()` with a `ProductAvailabilityUpdateStruct`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 106, 110) =]]
```

## Attributes

To get information about product attribute groups, use the `AttributeGroupServiceInterface`,
or `LocalAttributeGroupServiceInterface` to modify attribute groups.

`AttributeGroupServiceInterface::getAttributeGroup()` enables you to get a single attribute group by its identifier.
`AttributeGroupServiceInterface::findAttributeGroups()` get all attribute groups, base on optional query:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 64, 65) =]]
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 85, 90) =]]
```

To create an attribute group, use `LocalAttributeGroupServiceinterface::createAttributeGroup`
and provide it with an `AttributeGroupCreateStruct`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 59, 63) =]]
```

To get information about product attributes, use the `AttributeDefinitionServiceInterface`,
or `LocalAttributeDefinitionServiceInterface` to modify attributes.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 71, 73) =]]
```

To create an attribute, use `LocalAttributeGroupServiceinterface::createAttributeDefinition`
and provide it with an `AttributeDefinitionCreateStruct`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 76, 82) =]]
```
