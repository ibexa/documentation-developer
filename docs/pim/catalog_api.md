---
description: Use PHP API to get information about and manage product catalogs.
---

# Catalog API

To get information about product catalogs and manage them, use `CatalogServiceInterface`.

## Get catalog

To get a single catalog, you can use `CatalogServiceInterface::getCatalog()` and provide it with catalog ID, or `CatalogServiceInterface::getCatalogByIdentifier()` and pass the identifier:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CatalogCommand.php', 70, 72) =]]
```

## Get products in catalog

To get products from a catalog, request the product query from the catalog object  with `catalog::getQuery()`.
Then, create a new `ProductQuery` based on it and run a product search with `ProductServiceInterface::findProduct()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CatalogCommand.php', 74, 80) =]]
```

## Create catalog

To create a catalog, you need to prepare a `CatalogCreateStruct`, with the identifier, name and description and Criteria for filtering products.
Then, pass this struct to `CatalogServiceInterface::createCatalog()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CatalogCommand.php', 53, 68) =]]
```

## Update catalog

You can update an existing catalog by using `CatalogServiceInterface::updateCatalog()`,
to which you must pass the catalog object and a `CatalogUpdateStruct`.
In the following example, you update the catalog to publish it:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CatalogCommand.php', 82, 86) =]]
```
