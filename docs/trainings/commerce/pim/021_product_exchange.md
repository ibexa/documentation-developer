---
description: "PIM training: Product exchange"
edition: experience
page_type: training
---

# Product exchange

## Remote PIM

Even if this is outside the scope of this training, this is important to know that the products could be stored outside Ibexa DXP.
With a [remote PIM](pim_guide.md#remote-pim-support), Ibexa DXP role is to display them on the storefront, and, for the Commerce edition, to allow their purchase.

## REST API

TODO

TODO: Exercise request through REST the bikes from "5 series"
TODO: /product/catalog/catalogs/{identifier}/products/view

## PHP API

[Product API](product_api.md)

Notice that there is a `ProductServiceInterface` for reading and a `LocalProductServiceInterface for writing.
This is due to reading being available for both local and remote PIM, while writing is available only locally.

[Criteria for `ProductServiceInterface::findProducts()`](product_search_criteria.md)

[Sort Clauses for `ProductServiceInterface::findProducts()`](product_sort_clauses.md)

To create product types, use `ContentTypeFactoryInterface::createContentTypeCreateStruct`.
As you can see in [its `ContentTypeFactory::createContentTypeCreateStruct` implementation](https://github.com/ibexa/product-catalog/blob/main/src/lib/Local/Repository/ProductType/ContentTypeFactory.php#L39-L43),
this function is responsible for the default fields of a new product type.

[Catalog API](catalog_api.md)

[Taxonomy API for product categories](taxonomy_api.md)

TODO: Exercise: Write a command/controller listing all mountain bikes by series.
TODO: Exercise: "4 Series" has been discontinued. Create a "Retired product" category below root

## Product model migration

After having modeled your catalog organization on your local developer instance,
you may want/need to [generate migration files](exporting_data.md) to install the model on a shared instance
(for example a staging instance or the production instance) where the creation of the products will be done.

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
