---
description: Use PHP API to manage products in PIM, their attributes, availability and prices.
---

# Product API

## Products

[[= product_name =]]'s Product API provides two services for handling product information, which differ in function:

- `ProductServiceInterface` is used to request product data
- `LocalProductServiceInterface` is used to modify products

!!! tip "Product REST API"

    To learn how to load products using the REST API, see [REST API reference](../api/rest_api/rest_api_reference/rest_api_reference.html#product-catalog-create-product-type).

### Getting product information

Get an individual product by using the `productService::getProduct()` method:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 68, 71) =]]
```

Find multiple products with `productService::findProducts()`.
Provide the method with optional filter, query or Sort Clauses.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 72, 82) =]]
```

### Modifying products

To create, update and delete products, use the `LocalProductServiceInterface`.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 93, 97) =]]
```

To create a product, use `LocalProductService::newProductCreateStruct()`.
Provide the method with the product type object and the main language code.
You also need to set (at least) the code for the product and the required Field of the underlying content type, `name`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 83, 90) =]]
```

To delete a product, use `LocalProductService::deleteProduct()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 120, 121) =]]
```

### Product variants

You can access the variants of a product by using `ProductServiceInterface::findProductVariants()`.
The method takes the product object and a `ProductVariantQuery` object as parameters.

A `ProductVariantQuery` lets you define the offset and limit of the variant query.
The default offset is 0, and limit is 25.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductVariantCommand.php', 57, 60) =]]
```

From a variant, you can access the attributes that are used to generate the variant
by using `ProductVariant::getDiscriminatorAttributes()`.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductVariantCommand.php', 61, 68) =]]
```

#### Creating variants

To create a product variant, use `LocalProductService::createProductVariants()`.
This method takes the product and an array of `ProductVariantCreateStruct` objects as parameters.
`ProductVariantCreateStruct` specifies the attribute values and the code for the new variant.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductVariantCommand.php', 70, 76) =]]
```

### Product assets

You can get assets assigned to a product by using `AssetServiceInterface`.

Use `AssetServiceInterface` to get a single asset by providing the product object and the assets's ID as parameters:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductAssetCommand.php', 54, 56) =]]
```

To get all assets assigned to a product, use `AssetServiceInterface::findAssets()`.
You can retrieve the tags (corresponding to attribute values) of assets with the `getTags()` method:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductAssetCommand.php', 57, 66) =]]
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
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 104, 109) =]]        }
```

To change availability for a product, use `updateProductAvailability()` with a `ProductAvailabilityUpdateStruct`
and provide it with the product object. The second parameter defines whether product is available,
and the third whether its stock is infinite. The fourth parameter is the stock number:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 112, 115) =]]
```

## Attributes

To get information about product attribute groups, use the `AttributeGroupServiceInterface`,
or `LocalAttributeGroupServiceInterface` to modify attribute groups.

`AttributeGroupServiceInterface::getAttributeGroup()` enables you to get a single attribute group by its identifier.
`AttributeGroupServiceInterface::findAttributeGroups()` get all attribute groups, base on optional query:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 71, 72) =]]
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 92, 97) =]]
```

To create an attribute group, use `LocalAttributeGroupServiceinterface::createAttributeGroup`
and provide it with an `AttributeGroupCreateStruct`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 66, 70) =]]
```

To get information about product attributes, use the `AttributeDefinitionServiceInterface`,
or `LocalAttributeDefinitionServiceInterface` to modify attributes.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 78, 80) =]]
```

To create an attribute, use `LocalAttributeGroupServiceinterface::createAttributeDefinition`
and provide it with an `AttributeDefinitionCreateStruct`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 83, 89) =]]
```
