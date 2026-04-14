---
description: Use PHP API to manage products in PIM, their attributes, availability and prices.
month_change: false
---

# Product API

## Products

[[= product_name =]]'s Product API provides two services for handling product information, which differ in function:

| Service name | Description |
| ------------ | ----------- |
| [`ProductServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductServiceInterface.html) | Use it to retrieve product data regardless of the source: [[= product_name =]], [[[= pim_product_name =]]](/product_catalog/quable/quable.md), or [remote PIM](add_remote_pim_support.md) |
| [`LocalProductServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-LocalProductServiceInterface.html) | Use it to modify products defined in [[= product_name =]] |

!!! tip "Product REST API"

    To learn how to load products using the REST API, see [REST API reference](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/api_productcatalogproductsview_post).

### Getting product information

Get an individual product by using the `ProductServiceInterface::getProduct()` method:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 54, 57) =]]
```

Find multiple products with `ProductServiceInterface::findProducts()`.

Provide the method with optional filter, query or Sort Clauses.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 58, 68) =]]
```

See [Product Search Criteria](product_search_criteria.md) and [Product Sort Clauses](product_sort_clauses.md) references for more information about how to use the [`ProductQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-ProductQuery.html) class.

### Modifying products

To create, update and delete products, use the `LocalProductServiceInterface`.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 79, 83) =]]
```

To create a product, use `LocalProductServiceInterface::newProductCreateStruct()` to get a [`ProductCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-Values-Product-ProductCreateStruct.html).
Provide the method with the product type object and the main language code.
You also need to set (at least) the code for the product and the required Field of the underlying content type, `name`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 69, 76) =]]
```

To delete a product, use `LocalProductServiceInterface::deleteProduct()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 106, 107) =]]
```

### Product variants

#### Searching for variants of a specific product

You can access the variants of a product by using the [`ProductServiceInterface::findProductVariants()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductServiceInterface.html#method_findProductVariants) method.
The method takes the product object and a [`ProductVariantQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-ProductVariantQuery.html) object as parameters.

You can filter variants by:

- variant codes:

    ``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductVariantCommand.php', 50, 54) =]]
    ```

- product criteria:

    To use [Product Search Criteria](product_search_criteria.md) with [`ProductVariantQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-ProductVariantQuery.html), wrap it with the [`ProductCriterionAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Content-Query-Criterion-ProductCriterionAdapter.html) class, as in the example below:

    ``` php hl_lines="4"
[[= include_file('code_samples/api/product_catalog/src/Command/ProductVariantCommand.php', 55, 66) =]]
    ```

From a variant ([`ProductVariantInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-ProductVariantInterface.html)), you can access the attributes that are used to generate the variant by using the [`ProductVariantInterface::getDiscriminatorAttributes()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-ProductVariantInterface.html#method_getDiscriminatorAttributes) method.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductVariantCommand.php', 69, 73) =]]
```

#### Searching for variants across all products

To search for variants across all products, use the [`ProductServiceInterface::findVariants()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductServiceInterface.html#method_findVariants) method.
This method takes a [`ProductVariantQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-ProductVariantQuery.html) object and returns variants regardless of their base product.

Unlike `findProductVariants()`, which requires a specific product object, `findVariants()` allows you to search the entire variant catalog.

You can filter variants by:

- variant codes:

    ``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductVariantCommand.php', 83, 87) =]]
    ```

- product criteria:

    To use [Product Search Criteria](product_search_criteria.md) with [`ProductVariantQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-ProductVariantQuery.html), wrap it with the [`ProductCriterionAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Content-Query-Criterion-ProductCriterionAdapter.html) class, as in the example below:

    ``` php hl_lines="4"
[[= include_file('code_samples/api/product_catalog/src/Command/ProductVariantCommand.php', 92, 100) =]]
    ```

#### Creating variants

To create a product variant, use `LocalProductServiceInterface::createProductVariants()`.
This method takes the product and an array of [`ProductVariantCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-Values-Product-ProductVariantCreateStruct.html) objects as parameters.
`ProductVariantCreateStruct` specifies the attribute values and the code for the new variant.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductVariantCommand.php', 85, 91) =]]
```

### Product assets

You can get assets assigned to a product by using [`AssetServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-AssetServiceInterface.html).

Use `AssetServiceInterface` to get a single asset by providing the product object and the assets's ID as parameters:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductAssetCommand.php', 46, 48) =]]
```

To get all assets assigned to a product, use `AssetServiceInterface::findAssets()`.
You can retrieve the tags (corresponding to attribute values) of assets with the `AssetInterface::getTags()` method:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductAssetCommand.php', 49, 58) =]]
```

## Product types

To work with product types, use [`ProductTypeServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductTypeServiceInterface.html).

### Creating product types

To create a product type, use [`LocalProductTypeServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-LocalProductTypeServiceInterface.html).

First, create a product type struct with `LocalProductTypeServiceInterface::newProductTypeCreateStruct()`, providing the identifier and main language code:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 48, 52) =]]
```

You can set names in multiple languages by using `setNames()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 53, 57) =]]
```

To create a virtual product type (for products that don't require shipping), use `setVirtual()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 58, 59) =]]
```

#### Adding field definitions

To add custom field definitions to the product type, use `getContentTypeCreateStruct()` to access the underlying content type struct.
For more information about working with content types, see [Adding content types](../content_management/content_api/managing_content.md#adding-content-types).

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 62, 69) =]]
```

#### Assigning attributes

To assign product attributes to the product type, use `setAssignedAttributesDefinitions()` with an array of [`AssignAttributeDefinitionStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-Values-ProductType-AssignAttributeDefinitionStruct.html) objects.

First, retrieve the attribute definition by using [`AttributeDefinitionServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-AttributeDefinitionServiceInterface.html):

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 70, 71) =]]
```

Then create the assignment struct with the attribute definition, and set whether it's required and whether it's a discriminator (used for product variants):

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 72, 79) =]]
```

For more information about working with attributes through PHP API, see [Attributes](#attributes).

#### Storing new product type

Finally, create the product type with `LocalProductTypeServiceInterface::createProductType()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 80, 81) =]]
```

### Getting product types

Get a product type object by using `ProductTypeServiceInterface::getProductType()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 82, 83) =]]
```

You can also get a list of product types with `ProductTypeServiceInterface::findProductTypes()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductTypeCommand.php', 86, 91) =]]
```

## Product availability

Product availability is an object which defines whether a product is available, and if so, in what stock.
To manage it, use [`ProductAvailabilityServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductAvailabilityServiceInterface.html).

To check whether a product is available (with or without stock defined), use `ProductAvailabilityServiceInterface::hasAvailability()`.

Get the availability object with `ProductAvailabilityServiceInterface::getAvailability()`.
You can then use `ProductAvailabilityServiceInterface::getStock()` to get the stock number for the product:

```php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 90, 95) =]][[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 104, 105) =]]
```

To change availability for a product, use `ProductAvailabilityServiceInterface::updateProductAvailability()` with a [`ProductAvailabilityUpdateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Availability-ProductAvailabilityUpdateStruct.html) and provide it with the product object.
The second parameter defines whether product is available, and the third whether its stock is infinite. The fourth parameter is the stock number:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/ProductCommand.php', 98, 101) =]]
```

## Attributes

To get information about product attribute groups, use the [`AttributeGroupServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-AttributeGroupServiceInterface.html), or [`LocalAttributeGroupServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-LocalAttributeGroupServiceInterface.html) to modify attribute groups.

`AttributeGroupServiceInterface::getAttributeGroup()` enables you to get a single attribute group by its identifier.
`AttributeGroupServiceInterface::findAttributeGroups()` gets attribute groups, all of them or filtered with an optional [`AttributeGroupQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-AttributeGroup-AttributeGroupQuery.html) object:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 53, 54) =]]
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 74, 79) =]]
```

To create an attribute group, use `LocalAttributeGroupServiceinterface::createAttributeGroup()` and provide it with an [`AttributeGroupCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-Values-AttributeGroup-AttributeGroupCreateStruct.html):

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 48, 52) =]]
```

To get information about product attributes, use the [`AttributeDefinitionServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-AttributeDefinitionServiceInterface.html), or [`LocalAttributeDefinitionServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-LocalAttributeDefinitionServiceInterface.html) to modify attributes.

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 60, 62) =]]
```

To create an attribute, use `LocalAttributeGroupServiceinterface::createAttributeDefinition()` and provide it with an [`AttributeDefinitionCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-Values-AttributeDefinition-AttributeDefinitionCreateStruct.html):

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/AttributeCommand.php', 65, 71) =]]
```
