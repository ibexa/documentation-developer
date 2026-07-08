---
description: Use PHP API to manage products in PIM, their attributes, availability, and prices.
month_change: false
---

# Product API

## Products

[[= product_name =]]'s Product API provides two services for handling product information, which differ in function:

- [`ProductServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductServiceInterface.html) is used to request product data
- [`LocalProductServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-LocalProductServiceInterface.html) is used to modify products

!!! tip "Product REST API"

    To learn how to load products using the REST API, see [REST API reference](../api/rest_api/rest_api_reference/rest_api_reference.html#product-catalog-create-product-type).

### Getting product information

Get an individual product by using the `ProductServiceInterface::getProduct()` method:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductCommand.php', 70, 72, remove_indent=True) =]]
```

Find multiple products with `ProductServiceInterface::findProducts()`.

Provide the method with optional filter, query or Sort Clauses.

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductCommand.php', 74, 83, remove_indent=True) =]]
```

See [Product Search Criteria](product_search_criteria.md) and [Product Sort Clauses](product_sort_clauses.md) references for more information about how to use the [`ProductQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-ProductQuery.html) class.

### Modifying products

To create, update and delete products, use the `LocalProductServiceInterface`.

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductCommand.php', 95, 98, remove_indent=True) =]]
```

To create a product, use `LocalProductServiceInterface::newProductCreateStruct()` to get a [`ProductCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-Values-Product-ProductCreateStruct.html).
Provide the method with the product type object and the main language code.
You also need to set (at least) the code for the product and the required Field of the underlying content type, `name`:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductCommand.php', 85, 89, remove_indent=True) =]]
```

To delete a product, use `LocalProductServiceInterface::deleteProduct()`:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductCommand.php', 130, 130, remove_indent=True) =]]
```

### Product variants

You can access the variants of a product by using `ProductServiceInterface::findProductVariants()`.
The method takes the product object and a [`ProductVariantQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-ProductVariantQuery.html) object as parameters.

A `ProductVariantQuery` lets you define the offset and limit of the variant query.
The default offset is 0, and limit is 25.

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductVariantCommand.php', 58, 60, remove_indent=True) =]]
```

From a variant ([`ProductVariantInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-ProductVariantInterface.html)), you can access the attributes that are used to generate the variant by using `ProductVariantInterface::getDiscriminatorAttributes()`.

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductVariantCommand.php', 62, 68, remove_indent=True) =]]
```

#### Creating variants

To create a product variant, use `LocalProductServiceInterface::createProductVariants()`.
This method takes the product and an array of [`ProductVariantCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-Values-Product-ProductVariantCreateStruct.html) objects as parameters.
`ProductVariantCreateStruct` specifies the attribute values and the code for the new variant.

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductVariantCommand.php', 71, 76, remove_indent=True) =]]
```

### Product assets

You can get assets assigned to a product by using [`AssetServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-AssetServiceInterface.html).

Use `AssetServiceInterface` to get a single asset by providing the product object and the assets's ID as parameters:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductAssetCommand.php', 55, 56, remove_indent=True) =]]
```

To get all assets assigned to a product, use `AssetServiceInterface::findAssets()`.
You can retrieve the tags (corresponding to attribute values) of assets with the `AssetInterface::getTags()` method:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductAssetCommand.php', 58, 66, remove_indent=True) =]]
```

## Product types

To work with product types, use [`ProductTypeServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductTypeServiceInterface.html).

### Creating product types

To create a product type, use [`LocalProductTypeServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-LocalProductTypeServiceInterface.html).

First, create a product type struct with `LocalProductTypeServiceInterface::newProductTypeCreateStruct()`, providing the identifier and main language code:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 63, 66, remove_indent=True) =]]
```

You can set names in multiple languages by using `setNames()`:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 68, 71, remove_indent=True) =]]
```

To create a virtual product type (for products that don't require shipping), use `setVirtual()`:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 73, 73, remove_indent=True) =]]
```

#### Adding field definitions

To add custom field definitions to the product type, use `getContentTypeCreateStruct()` to access the underlying content type struct.
For more information about working with content types, see [Adding content types](../content_management/content_api/managing_content.md#adding-content-types).

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 77, 83, remove_indent=True) =]]
```

#### Assigning attributes

To assign product attributes to the product type, use `setAssignedAttributesDefinitions()` with an array of [`AssignAttributeDefinitionStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-Values-ProductType-AssignAttributeDefinitionStruct.html) objects.

First, retrieve the attribute definition by using [`AttributeDefinitionServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-AttributeDefinitionServiceInterface.html):

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 85, 85, remove_indent=True) =]]
```

Then create the assignment struct with the attribute definition, and set whether it's required and whether it's a discriminator (used for product variants):

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 87, 93, remove_indent=True) =]]
```

For more information about working with attributes through PHP API, see [Attributes](#attributes).

#### Storing new product type

Finally, create the product type with `LocalProductTypeServiceInterface::createProductType()`:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 94, 95, remove_indent=True) =]]
```

### Getting product types

Get a product type object by using `ProductTypeServiceInterface::getProductType()`:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 97, 97, remove_indent=True) =]]
```

You can also get a list of product types with `ProductTypeServiceInterface::findProductTypes()`:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 101, 105, remove_indent=True) =]]
```

## Product availability

Product availability is an object which defines whether a product is set as available, in what stock, and whether it can be ordered.
To manage it, use [`ProductAvailabilityServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductAvailabilityServiceInterface.html).

The [`AvailabilityInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Availability-AvailabilityInterface.html) provides two distinct availability values:

- `getAvailability()` returns the value of availability flag as set for the product
- `getComputedAvailability()` returns whether the product can be ordered

For more information about the distinction between these two values, see [Availability and computed availability](products.md#availability-and-computed-availability).

To check whether a product is set as available, use `ProductAvailabilityServiceInterface::hasAvailability()`.

You can get the availability object with `ProductAvailabilityServiceInterface::getAvailability()`.
The returned object contains both the stored and computed availability:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductCommand.php', 106, 111, remove_indent=True) =]]
[[= include_code('code_samples/api/product_catalog/src/Command/ProductCommand.php', 134, 134, remove_indent=True) =]]
```

To evaluate computed availability for a [specific context](create_custom_availability_strategy.md), for example, a specific requested quantity or customer group, pass an optional [`AvailabilityContextInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Availability-AvailabilityContextInterface.html) object as the second argument:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductCommand.php', 122, 128, remove_indent=True) =]]
```

To change availability for a product, use `ProductAvailabilityServiceInterface::updateProductAvailability()` with a [`ProductAvailabilityUpdateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Availability-ProductAvailabilityUpdateStruct.html) and provide it with the product object.
The second parameter defines whether product is available, and the third whether its stock is infinite. The fourth parameter is the stock number:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/ProductCommand.php', 113, 115, remove_indent=True) =]]
```

## Attributes

To get information about product attribute groups, use the [`AttributeGroupServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-AttributeGroupServiceInterface.html), or [`LocalAttributeGroupServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-LocalAttributeGroupServiceInterface.html) to modify attribute groups.

`AttributeGroupServiceInterface::getAttributeGroup()` enables you to get a single attribute group by its identifier.
`AttributeGroupServiceInterface::findAttributeGroups()` gets attribute groups, all of them or filtered with an optional [`AttributeGroupQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-AttributeGroup-AttributeGroupQuery.html) object:

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 72, 72, remove_indent=True) =]]
[[= include_code('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 93, 97, remove_indent=True) =]]
```

To create an attribute group, use `LocalAttributeGroupServiceinterface::createAttributeGroup()` and provide it with an [`AttributeGroupCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-Values-AttributeGroup-AttributeGroupCreateStruct.html):

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 67, 70, remove_indent=True) =]]
```

To get information about product attributes, use the [`AttributeDefinitionServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-AttributeDefinitionServiceInterface.html), or [`LocalAttributeDefinitionServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-LocalAttributeDefinitionServiceInterface.html) to modify attributes.

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 79, 80, remove_indent=True) =]]
```

To create an attribute, use `LocalAttributeGroupServiceinterface::createAttributeDefinition()` and provide it with an [`AttributeDefinitionCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-Values-AttributeDefinition-AttributeDefinitionCreateStruct.html):

``` php
[[= include_code('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 84, 89, remove_indent=True) =]]
```
