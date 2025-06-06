---
description: Use PHP API to get information about and manage product catalogs.
---

# Catalog API

To get information about product catalogs and manage them, use `CatalogServiceInterface`.

## Get catalog

To get a single catalog, use `Ibexa\Contracts\ProductCatalog\CatalogServiceInterface::getCatalog()` and provide it with catalog ID, or `CatalogServiceInterface::getCatalogByIdentifier()` and pass the identifier:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CatalogCommand.php', 81, 83) =]]
```

## Get products in catalog

To get products from a catalog, request the product query from the catalog object with `Ibexa\Contracts\ProductCatalog\Values\CatalogInterface::getQuery()`.
Then, create a new `ProductQuery` based on it and run a product search with `ProductServiceInterface::findProduct()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CatalogCommand.php', 85, 91) =]]
```

## Create catalog

To create a catalog, you need to prepare a `CatalogCreateStruct` that contains: identifier, name, description, and Criteria for filtering products.
Then, pass this struct to `CatalogServiceInterface::createCatalog()`:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CatalogCommand.php', 71, 79) =]]
```

## Update catalog

Use `CatalogServiceInterface::updateCatalog()` to update an existing catalog.
You must pass the catalog object and a `CatalogUpdateStruct` to the method.
In the following example, you update the catalog to publish it:

``` php
[[= include_file('code_samples/api/product_catalog/src/Command/CatalogCommand.php', 93, 97) =]]
```
