# Catalog API

Use PHP API to get information about and manage product catalogs.

To get information about product catalogs and manage them, use `CatalogServiceInterface`.

## Get catalog

To get a single catalog, use `Ibexa\Contracts\ProductCatalog\CatalogServiceInterface::getCatalog()` and provide it with catalog ID, or `CatalogServiceInterface::getCatalogByIdentifier()` and pass the identifier:

```php
$catalog = $this->catalogService->getCatalogByIdentifier($catalogIdentifier);
$output->writeln($catalog->getName());
```

## Get products in catalog

To get products from a catalog, request the product query from the catalog object with `Ibexa\Contracts\ProductCatalog\Values\CatalogInterface::getQuery()`. Then, create a new `ProductQuery` based on it and run a product search with `ProductServiceInterface::findProduct()`:

```php
$productQuery = new ProductQuery(null, $catalog->getQuery());
$products = $this->productService->findProducts($productQuery);

foreach ($products as $product) {
    $output->writeln($product->getName());
}
```

## Create catalog

To create a catalog, you need to prepare a `CatalogCreateStruct` that contains: identifier, name, description, and Criteria for filtering products. Then, pass this struct to `CatalogServiceInterface::createCatalog()`:

```php
$catalogCriterion = new Criterion\LogicalAnd(
    [
        new Criterion\ProductType(['desk']),
        new Criterion\ProductAvailability(true),
    ]
);

$catalogCreateStruct = new CatalogCreateStruct(
    $catalogIdentifier,
    $catalogCriterion,
    ['eng-GB' => 'Desk promo'],
    ['eng-GB' => 'Desk promo description'],
);

$this->catalogService->createCatalog($catalogCreateStruct);
```

## Update catalog

Use `CatalogServiceInterface::updateCatalog()` to update an existing catalog. You must pass the catalog object and a `CatalogUpdateStruct` to the method. In the following example, you update the catalog to publish it:

```php
$catalogUpdateStruct = new CatalogUpdateStruct($catalog->getId());
$catalogUpdateStruct->setTransition(Status::PUBLISH_TRANSITION);

$this->catalogService->updateCatalog($catalog, $catalogUpdateStruct);
```
