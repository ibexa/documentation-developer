<?php declare(strict_types=1);

use DateTimeImmutable;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\UpdatedAtRange;

$criteria = new UpdatedAtRange(
    new DateTimeImmutable('2020-07-10T00:00:00+00:00'),
    new DateTimeImmutable('2023-07-12T00:00:00+00:00'),
);

/** @var \Ibexa\Contracts\ProductCatalog\ProductServiceInterface $productService */
$productQuery = new ProductQuery();
$productQuery->setQuery($criteria);
$results = $productService->findProducts($productQuery);
