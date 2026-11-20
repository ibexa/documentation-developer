# Product API

Use PHP API to manage products in PIM, their attributes, availability, and prices.

## Products

Ibexa DXP's Product API provides two services for handling product information, which differ in function:

| Service name                                                                                                                                                               | Description                                                                                                                                                                                                                                     |
| -------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| [`Ibexa\Contracts\ProductCatalog\ProductServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/ProductServiceInterface.php)                 | Use it to retrieve product data regardless of the source: Ibexa DXP, [Quable](../quable/quable/index.md), or [remote PIM](../add_remote_pim_support/index.md) |
| [`Ibexa\Contracts\ProductCatalog\Local\LocalProductServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/Local/LocalProductServiceInterface.php) | Use it to modify products defined in Ibexa DXP                                                                                                                                                                                                  |

> **Tip: Product REST API**
>
> To learn how to load products using the REST API, see [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Product/operation/api_productcatalogproductsview_post).

### Getting product information

Get an individual product by using the `ProductServiceInterface::getProduct()` method:

```php
$product = $this->productService->getProduct($productCode);

$output->writeln('Product with code ' . $product->getCode() . ' is ' . $product->getName());
```

Find multiple products with `ProductServiceInterface::findProducts()`.

Provide the method with optional filter, query or Sort Clauses.

```php
$criteria = new Criterion\ProductType([$productType]);
$sortClauses = [new SortClause\ProductName(ProductQuery::SORT_ASC)];

$productQuery = new ProductQuery(null, $criteria, $sortClauses);

$products = $this->productService->findProducts($productQuery);

foreach ($products as $product) {
    $output->writeln($product->getName() . ' of type ' . $product->getProductType()->getName());
}
```

See [Product Search Criteria](../../search/criteria_reference/product_search_criteria/index.md) and [Product Sort Clauses](../../search/sort_clause_reference/product_sort_clauses/index.md) references for more information about how to use the [`Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/ProductQuery.php) class.

### Modifying products

To create, update and delete products, use the `LocalProductServiceInterface`.

```php
$productUpdateStruct = $this->localProductService->newProductUpdateStruct($product);
$productUpdateStruct->setCode('NEWMODIFIEDPRODUCT');

$this->localProductService->updateProduct($productUpdateStruct);
```

To create a product, use `LocalProductServiceInterface::newProductCreateStruct()` to get a [`Ibexa\Contracts\ProductCatalog\Local\Values\Product\ProductCreateStruct`](../../../../../ibexa/product-catalog/src/contracts/Local/Values/Product/ProductCreateStruct.php). Provide the method with the product type object and the main language code. You also need to set (at least) the code for the product and the required Field of the underlying content type, `name`:

```php
$productType = $this->productTypeService->getProductType($productType);

$createStruct = $this->localProductService->newProductCreateStruct($productType, 'eng-GB');
$createStruct->setCode('NEWPRODUCT');
$createStruct->setField('name', 'New Product');

$this->localProductService->createProduct($createStruct);
```

To delete a product, use `LocalProductServiceInterface::deleteProduct()`:

```php
$this->localProductService->deleteProduct($product);
```

### Product variants

#### Searching for variants of a specific product

You can access the variants of a product by using the [`ProductServiceInterface::findProductVariants()`](../../../../../ibexa/product-catalog/src/contracts/ProductServiceInterface.php) method. The method takes the product object and a [`Ibexa\Contracts\ProductCatalog\Values\Product\ProductVariantQuery`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/ProductVariantQuery.php) object as parameters.

You can filter variants by:

- variant codes:

  ```php
  // Get variants filtered by variant codes
  $codeQuery = new ProductVariantQuery();
  $codeQuery->setVariantCodes(['DESK-red', 'DESK-blue']);
  $specificVariants = $this->productService->findProductVariants($product, $codeQuery)->getVariants();
  ```

- product criteria:

  To use [Product Search Criteria](../../search/criteria_reference/product_search_criteria/index.md) with [`Ibexa\Contracts\ProductCatalog\Values\Product\ProductVariantQuery`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/ProductVariantQuery.php), wrap it with the [`Ibexa\Contracts\ProductCatalog\Values\Content\Query\Criterion\ProductCriterionAdapter`](../../../../../ibexa/product-catalog/src/contracts/Values/Content/Query/Criterion/ProductCriterionAdapter.php) class, as in the example below:

  ```php
  // Get variants with specific attributes
  $combinedQuery = new ProductVariantQuery();
  $combinedQuery->setAttributesCriterion(
      new ProductCriterionAdapter(
          new Criterion\LogicalAnd([
              new Criterion\ColorAttribute('color', ['red', 'blue']),
              new Criterion\IntegerAttribute('size', 42),
          ])
      )
  );
  $filteredVariants = $this->productService->findProductVariants($product, $combinedQuery)->getVariants();
  ```

From a variant ([`Ibexa\Contracts\ProductCatalog\Values\ProductVariantInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/ProductVariantInterface.php)), you can access the attributes that are used to generate the variant by using the [`ProductVariantInterface::getDiscriminatorAttributes()`](../../../../../ibexa/product-catalog/src/contracts/Values/ProductVariantInterface.php) method.

```php
$attributes = $variant->getDiscriminatorAttributes();
foreach ($attributes as $attribute) {
    $output->writeln($attribute->getIdentifier() . ': ' . $attribute->getValue() . ' ');
}
```

#### Searching for variants across all products

To search for variants across all products, use the [`ProductServiceInterface::findVariants()`](../../../../../ibexa/product-catalog/src/contracts/ProductServiceInterface.php) method. This method takes a [`Ibexa\Contracts\ProductCatalog\Values\Product\ProductVariantQuery`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/ProductVariantQuery.php) object and returns variants regardless of their base product.

Unlike `findProductVariants()`, which requires a specific product object, `findVariants()` allows you to search the entire variant catalog.

You can filter variants by:

- variant codes:

  ```php
  // Search variants across all products
  $query = new ProductVariantQuery();
  $query->setVariantCodes(['DESK-red', 'DESK-blue']);
  $variantList = $this->productService->findVariants($query);
  ```

- product criteria:

  To use [Product Search Criteria](../../search/criteria_reference/product_search_criteria/index.md) with [`Ibexa\Contracts\ProductCatalog\Values\Product\ProductVariantQuery`](../../../../../ibexa/product-catalog/src/contracts/Values/Product/ProductVariantQuery.php), wrap it with the [`Ibexa\Contracts\ProductCatalog\Values\Content\Query\Criterion\ProductCriterionAdapter`](../../../../../ibexa/product-catalog/src/contracts/Values/Content/Query/Criterion/ProductCriterionAdapter.php) class, as in the example below:

  ```php
  // Search variants with attribute criterion
  $colorQuery = new ProductVariantQuery();
  $colorQuery->setAttributesCriterion(
      new ProductCriterionAdapter(
          new Criterion\ColorAttribute('color', ['red'])
      )
  );
  $redVariants = $this->productService->findVariants($colorQuery);
  ```

#### Creating variants

To create a product variant, use `LocalProductServiceInterface::createProductVariants()`. This method takes the product and an array of [`Ibexa\Contracts\ProductCatalog\Local\Values\Product\ProductVariantCreateStruct`](../../../../../ibexa/product-catalog/src/contracts/Local/Values/Product/ProductVariantCreateStruct.php) objects as parameters. `ProductVariantCreateStruct` specifies the attribute values and the code for the new variant.

```php
$query->setVariantCodes(['DESK-red', 'DESK-blue']);
$variantList = $this->productService->findVariants($query);

foreach ($variantList->getVariants() as $variant) {
    $output->writeln($variant->getName());
}
```

### Product assets

You can get assets assigned to a product by using [`Ibexa\Contracts\ProductCatalog\AssetServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/AssetServiceInterface.php).

Use `AssetServiceInterface` to get a single asset by providing the product object and the assets's ID as parameters:

```php
$singleAsset = $this->assetService->getAsset($product, '1');
$output->writeln($singleAsset->getName());
```

To get all assets assigned to a product, use `AssetServiceInterface::findAssets()`. You can retrieve the tags (corresponding to attribute values) of assets with the `AssetInterface::getTags()` method:

```php
$assetCollection = $this->assetService->findAssets($product);

foreach ($assetCollection as $asset) {
    $output->writeln($asset->getIdentifier() . ': ' . $asset->getName());
    $tags = $asset->getTags();
    foreach ($tags as $tag) {
        $output->writeln($tag);
    }
}
```

## Product types

To work with product types, use [`Ibexa\Contracts\ProductCatalog\ProductTypeServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/ProductTypeServiceInterface.php).

### Creating product types

To create a product type, use [`Ibexa\Contracts\ProductCatalog\Local\LocalProductTypeServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/Local/LocalProductTypeServiceInterface.php).

First, create a product type struct with `LocalProductTypeServiceInterface::newProductTypeCreateStruct()`, providing the identifier and main language code:

```php
$productTypeCreateStruct = $this->localProductTypeService->newProductTypeCreateStruct(
    'digital_product',
    'eng-GB'
);
```

You can set names in multiple languages by using `setNames()`:

```php
$productTypeCreateStruct->setNames([
    'eng-GB' => 'Digital Product',
    'pol-PL' => 'Produkt Cyfrowy',
]);
```

To create a virtual product type (for products that don't require shipping), use `setVirtual()`:

```php
$productTypeCreateStruct->setVirtual(true);
```

#### Adding field definitions

To add custom field definitions to the product type, use `getContentTypeCreateStruct()` to access the underlying content type struct. For more information about working with content types, see [Adding content types](../../content_management/content_api/managing_content/index.md#adding-content-types).

```php
$marketingDescriptionFieldDefinition = $this->contentTypeService->newFieldDefinitionCreateStruct(
    'marketing_description',
    'ibexa_string'
);
$marketingDescriptionFieldDefinition->names = ['eng-GB' => 'Marketing Description'];
$marketingDescriptionFieldDefinition->position = 100;
$contentTypeCreateStruct->addFieldDefinition($marketingDescriptionFieldDefinition);
```

#### Assigning attributes

To assign product attributes to the product type, use `setAssignedAttributesDefinitions()` with an array of [`Ibexa\Contracts\ProductCatalog\Local\Values\ProductType\AssignAttributeDefinitionStruct`](../../../../../ibexa/product-catalog/src/contracts/Local/Values/ProductType/AssignAttributeDefinitionStruct.php) objects.

First, retrieve the attribute definition by using [`Ibexa\Contracts\ProductCatalog\AttributeDefinitionServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/AttributeDefinitionServiceInterface.php):

```php
$sizeAttribute = $this->attributeDefinitionService->getAttributeDefinition('size');
```

Then create the assignment struct with the attribute definition, and set whether it's required and whether it's a discriminator (used for product variants):

```php
$attributeAssignment = new AssignAttributeDefinitionStruct(
    $sizeAttribute,
    false,
    false
);

$productTypeCreateStruct->setAssignedAttributesDefinitions([$attributeAssignment]);
```

For more information about working with attributes through PHP API, see [Attributes](#attributes).

#### Storing new product type

Finally, create the product type with `LocalProductTypeServiceInterface::createProductType()`:

```php
$newProductType = $this->localProductTypeService->createProductType($productTypeCreateStruct);
```

### Getting product types

Get a product type object by using `ProductTypeServiceInterface::getProductType()`:

```php
$productType = $this->productTypeService->getProductType($productTypeIdentifier);
```

You can also get a list of product types with `ProductTypeServiceInterface::findProductTypes()`:

```php
$productTypes = $this->productTypeService->findProductTypes();

foreach ($productTypes as $productType) {
    $output->writeln($productType->getName() . ' with identifier ' . $productType->getIdentifier());
}
```

## Product availability

Product availability is an object which defines whether a product is set as available, in what stock, and whether it can be ordered. To manage it, use [`Ibexa\Contracts\ProductCatalog\ProductAvailabilityServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/ProductAvailabilityServiceInterface.php).

The [`Ibexa\Contracts\ProductCatalog\Values\Availability\AvailabilityInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/Availability/AvailabilityInterface.php) provides two distinct availability values:

- `getAvailability()` returns the value of availability flag as set for the product
- `getComputedAvailability()` returns whether the product can be ordered

For more information about the distinction between these two values, see [Availability and computed availability](../products/index.md#availability-and-computed-availability).

To check whether a product is set as available, use `ProductAvailabilityServiceInterface::hasAvailability()`.

You can get the availability object with `ProductAvailabilityServiceInterface::getAvailability()`. The returned object contains both the stored and computed availability:

```php
if ($this->productAvailabilityService->hasAvailability($product)) {
    $availability = $this->productAvailabilityService->getAvailability($product);

    $output->writeln($availability->getAvailability() ? 'Available flag: true' : 'Available flag: false');
    $output->writeln($availability->getComputedAvailability() ? 'Can be ordered: true' : 'Can be ordered: false');
    $output->writeln('Stock: ' . $availability->getStock());
}
```

To evaluate computed availability for a [specific context](../create_custom_availability_strategy/index.md), for example, a specific requested quantity or customer group, pass an optional [`Ibexa\Contracts\ProductCatalog\Values\Availability\AvailabilityContextInterface`](../../../../../ibexa/product-catalog/src/contracts/Values/Availability/AvailabilityContextInterface.php) object as the second argument:

```php
$availability = $this->productAvailabilityService->getAvailability(
    $product,
    new PurchasableWithoutStockAvailabilityContext()
);

$canBeOrdered = $availability->getComputedAvailability();
$output->writeln('Can be ordered: ' . ($canBeOrdered ? 'true' : 'false') . ', Stock: ' . $availability->getStock());
```

To change availability for a product, use `ProductAvailabilityServiceInterface::updateProductAvailability()` with a [`Ibexa\Contracts\ProductCatalog\Values\Availability\ProductAvailabilityUpdateStruct`](../../../../../ibexa/product-catalog/src/contracts/Values/Availability/ProductAvailabilityUpdateStruct.php) and provide it with the product object. The second parameter defines whether product is available, and the third whether its stock is infinite. The fourth parameter is the stock number:

```php
$productAvailabilityUpdateStruct = new ProductAvailabilityUpdateStruct($product, true, false, 80);

$this->productAvailabilityService->updateProductAvailability($productAvailabilityUpdateStruct);
```

## Attributes

To get information about product attribute groups, use the [`Ibexa\Contracts\ProductCatalog\AttributeGroupServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/AttributeGroupServiceInterface.php), or [`Ibexa\Contracts\ProductCatalog\Local\LocalAttributeGroupServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/Local/LocalAttributeGroupServiceInterface.php) to modify attribute groups.

`AttributeGroupServiceInterface::getAttributeGroup()` enables you to get a single attribute group by its identifier. `AttributeGroupServiceInterface::findAttributeGroups()` gets attribute groups, all of them or filtered with an optional [`Ibexa\Contracts\ProductCatalog\Values\AttributeGroup\AttributeGroupQuery`](../../../../../ibexa/product-catalog/src/contracts/Values/AttributeGroup/AttributeGroupQuery.php) object:

```php
$attributeGroup = $this->attributeGroupService->getAttributeGroup('dimensions');

$attributeGroups = $this->attributeGroupService->findAttributeGroups();

foreach ($attributeGroups as $attributeGroup) {
    $output->writeln('Attribute group ' . $attributeGroup->getIdentifier() . ' with name ' . $attributeGroup->getName());
}
```

To create an attribute group, use `LocalAttributeGroupServiceinterface::createAttributeGroup()` and provide it with an [`Ibexa\Contracts\ProductCatalog\Local\Values\AttributeGroup\AttributeGroupCreateStruct`](../../../../../ibexa/product-catalog/src/contracts/Local/Values/AttributeGroup/AttributeGroupCreateStruct.php):

```php
$attributeGroupCreateStruct = $this->localAttributeGroupService->newAttributeGroupCreateStruct('dimensions');
$attributeGroupCreateStruct->setNames(['eng-GB' => 'Size']);

$this->localAttributeGroupService->createAttributeGroup($attributeGroupCreateStruct);
```

To get information about product attributes, use the [`Ibexa\Contracts\ProductCatalog\AttributeDefinitionServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/AttributeDefinitionServiceInterface.php), or [`Ibexa\Contracts\ProductCatalog\Local\LocalAttributeDefinitionServiceInterface`](../../../../../ibexa/product-catalog/src/contracts/Local/LocalAttributeDefinitionServiceInterface.php) to modify attributes.

```php
$attribute = $this->attributeDefinitionService->getAttributeDefinition('length');
$output->writeln($attribute->getName());
```

To create an attribute, use `LocalAttributeGroupServiceinterface::createAttributeDefinition()` and provide it with an [`Ibexa\Contracts\ProductCatalog\Local\Values\AttributeDefinition\AttributeDefinitionCreateStruct`](../../../../../ibexa/product-catalog/src/contracts/Local/Values/AttributeDefinition/AttributeDefinitionCreateStruct.php):

```php
$attributeCreateStruct = $this->localAttributeDefinitionService->newAttributeDefinitionCreateStruct('size');
$attributeCreateStruct->setType($attributeType);
$attributeCreateStruct->setName('eng-GB', 'Size');
$attributeCreateStruct->setGroup($attributeGroup);

$this->localAttributeDefinitionService->createAttributeDefinition($attributeCreateStruct);
```
