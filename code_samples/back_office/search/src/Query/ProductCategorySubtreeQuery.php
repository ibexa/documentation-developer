<?php declare(strict_types=1);

use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductCategorySubtree;

$taxonomyEntryId = 42;
$criteria = new ProductCategorySubtree($taxonomyEntryId);

/** @var ProductServiceInterface $productService */
$productQuery = new ProductQuery();
$productQuery->setQuery($criteria);
$results = $productService->findProducts($productQuery);
