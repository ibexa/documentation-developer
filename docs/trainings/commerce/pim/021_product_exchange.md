---
description: "PIM training: Product exchange"
edition: experience
page_type: training
---

# Product exchange

## Remote PIM

Even if this is outside the scope of this training, this is important to know that the products could be stored outside Ibexa DXP.
With a [remote PIM](pim_guide.md#remote-pim-support), Ibexa DXP role is to display them on the storefront, and, for the Commerce edition, to allow their purchase.

## Product model migration

After having modeled your catalog organization on your developer instance,
you may want/need to [generate migration files](exporting_data.md) for backup, or to install the model on a shared instance
(for example a staging instance, or the production instance where the creation of the final products is then done).

Export attribute groups, attributes, and product types:

``` bash
php bin/console ibexa:migrations:generate \
  --type=attribute_group --mode=create \
  --match-property=identifier --value=bike --value=mtb-s4 --value=mtb-s5 \
  --siteaccess=admin;

# Where 2, 3, and 4 are the IDs of the attribute groups bike, mtb-s4, and mtb-s5
php bin/console ibexa:migrations:generate \
  --type=attribute --mode=create \
  --match-property=attribute_group_id --value=2 --value=3 --value=4 \
  --siteaccess=admin;

php bin/console ibexa:migrations:generate \
  --type=content_type --mode=create \
  --match-property=content_type_identifier --value=mtb-s4 --value=mtb-s5 \
  --siteaccess=admin;
```

Export product categories:

``` bash
# Where 63 is the "Product Root Tag" Location ID (Product catalog > Categories)
php bin/console ibexa:migrations:generate \
  --type=content --mode=create \
  --match-property=parent_location_id --value=63 \
  --siteaccess=admin;
```

TODO: What about product migration limitation, and product variant migration inexistence?

## REST API

Thanks to REST API, [[= product_name =]]'s PIM can be shared with other applications.

### Attribute groups and attributes

| CRUD action | Method verb | Route                                  |
|-------------|-------------|----------------------------------------|
| Create      | POST        | /product/catalog/attribute_groups      |
| Read        | GET         | /product/catalog/attribute_groups/{id} |
| Update      | PATCH       | /product/catalog/attribute_groups/{id} |
| Delete      | DELETE      | /product/catalog/attribute_groups/{id} |

TODO: GET /product/catalog/attribute_types
TODO: GET /product/catalog/attribute_types/{identifier}

TODO: DELETE /product/catalog/attribute_groups/translation/{id}/{languageCode}

| CRUD action | Method verb | Route                                       |
|-------------|-------------|---------------------------------------------|
| Create      | POST        | /product/catalog/attributes                 |
| Read        | POST        | /product/catalog/attributes/view            |
| Read        | GET         | /product/catalog/attributes/{id}            |
| Update      | PATCH       | /product/catalog/attributes/{id}/{group_id} |
| Delete      | DELETE      | /product/catalog/attributes/{id}            |

TODO: DELETE /product/catalog/attributes/translation/{id}/{languageCode}

### Product types

| CRUD action | Method verb | Route                                               |
|-------------|-------------|-----------------------------------------------------|
| Create      | POST        | /product/catalog/product_types                      |
| Read        | GET         | /product/catalog/product_types/{id}                 |
| Read        | GET         | /product/catalog/product_types/is_used/{identifier} |
| Read        | POST        | /product/catalog/product_types/view                 |
| Update      | PATCH       | /product/catalog/product_types/{id}                 |
| Delete      | DELETE      | /product/catalog/product_types/{id}                 |

### Product and product variants

| CRUD action | Method verb | Route                                                |
|-------------|-------------|------------------------------------------------------|
| Create      | POST        | /product/catalog/products/{productTypeIdentifier}    |
| Read        | GET         | /product/catalog/products/{code}                     |
| Read        | POST        | /product/catalog/products/view                       |
| Read        | POST        | /product/catalog/catalogs/{identifier}/products/view |
| Update      | PATCH       | /product/catalog/products/{code}                     |
| Delete      | DELETE      | /product/catalog/products/{identifier}               |

| CRUD action | Method verb | Route                                                        |
|-------------|-------------|--------------------------------------------------------------|
| Create      | POST        | /product/catalog/product_variants/{baseProductCode}          |
| Create      | POST        | /product/catalog/product_variants/generate/{baseProductCode} |
| Read        | GET         | /product/catalog/product_variant/{code}                      |
| Read        | POST        | /product/catalog/product_variants/view/{baseProductCode}     |
| Update      | PATCH       | /product/catalog/product_variants/{code}                     |
| Delete      | DELETE      | /product/catalog/product_variants/{code}                     |

#### Product assets

TODO

### Catalogs

| CRUD action | Method verb | Route                                       |
|-------------|-------------|---------------------------------------------|
| Create      | POST        | /product/catalog/catalogs                   |
| Create      | POST        | /product/catalog/catalogs/copy/{identifier} |
| Read        | GET         | /product/catalog/catalogs/{identifier}      |
| Read        | POST        | /product/catalog/catalogs/view              |
| Update      | PATCH       | /product/catalog/catalogs/{identifier}      |
| Delete      | DELETE      | /product/catalog/catalogs/{identifier}      |

### Categories

TODO

### TODO: Exercises

TODO: Exercise request through REST the bikes from "5 series"
TODO: /product/catalog/catalogs/{identifier}/products/view

## PHP API

[[= product_name =]]'s PIM can be extended, accessed through custom controllers, command lines, or whatever you imagine, thanks to the PHP API.

There are several services to read or modify the product model, the products, and other product related features.

### Attribute groups and attributes

[Product API > Attributes](product_api.md#attributes) gives example about attribute groups and attributes reading and writing.

Notice that there are `AttributeGroupServiceInterface` and `AttributeDefinitionServiceInterface` for reading,
and `LocalAttributeGroupServiceInterface` and `LocalAttributeDefinitionServiceInterface` for writing.
This is due to reading being available for both local and remote PIM, while writing is available only locally.
This `Local` prefix in names of services allowing to write is recurrent.

### Product types

[Product API > Product types](product_api.md#product-types) illustrates how to access product types through the `ProductTypeServiceInterface`.

To create product types, you could use
<code><small>\Ibexa\ProductCatalog\Local\Repository\ProductType\</small>ContentTypeFactoryInterface::createContentTypeCreateStruct</code>
<small>(`vendor/ibexa/product-catalog/src/lib/Local/Repository/ProductType/ContentTypeFactoryInterface.php`)</small>.
Notice that this interface isn't in the `Ibexa\Contracts` namespace, which means that its behavior could change in a future minor version.
As you can see in its `ContentTypeFactory::createContentTypeCreateStruct` implementation,
this function is responsible for the default fields of a new product type.

### Product and product variants

[Product API > Products](product_api.md#products) gets examples of products and product variants reading and writing.

Notice again that there is a `ProductServiceInterface` for reading and a `LocalProductServiceInterface` for writing,
to distinguish what is available on both local and remote PIM, and what is available only locally.

About product search with `ProductServiceInterface::findProducts()`, also see the following references:

- [Criteria](product_search_criteria.md)
- [Sort Clauses](product_sort_clauses.md)

#### Product assets

[Product API > Products > Product assets](product_api.md#product-assets) has an example of asset reading.

[`AssetServiceInterface`](../../../api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-AssetServiceInterface.html) is used to read product assets,
and [`LocalAssetServiceInterface`](../../../api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-LocalAssetServiceInterface.html) to write some.

An asset collection as seen in the back office is represented by an associative array of tags (with attribute identifiers as keys),
and related getters and setters are named `getTags()` and `setTags` (for example, `AssetInterface::getTags()` or `AssetUpdateStruct::setTags()`).

Write a command that display the assets of the 4 Series Fuji.

```php
    $fuji = $this->productService->getProduct('MTB-S4-4');
    $assets = $this->assetService->findAssets($fuji);
    dump($assets);
```

Notice that `AssetServiceInterface::findAssets()` returns an `AssetCollectionInterface`.
`AssetCollectionInterface` isn't an asset collection as in the back office. It's just a traversable storing a list of assets without any hierarchy.
You can take a look at
<code><small>\Ibexa\Bundle\ProductCatalog\UI\AssetGroup\</small>AssetGroupCollectionFactory::createFromAssetCollection()</code>
<small>(`vendor/ibexa/product-catalog/src/bundle/UI/AssetGroup/AssetGroupCollectionFactory.php`)</small>.
to see how the back office transform the flat asset list into an "Assets collection for variant" list.

### Catalogs

[Catalog API](catalog_api.md)

### Categories

[Taxonomy API for product categories](taxonomy_api.md)

### TODO: Exercises

TODO: Exercise: Write a command/controller listing all mountain bikes by series.

TODO: Exercise: "4 Series" has been discontinued. Create a "Retired product" category below root, move…
