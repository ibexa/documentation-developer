<?php declare(strict_types=1);

use DateTimeImmutable;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\Operator;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\UpdatedAt;

$criteria = new UpdatedAt(
    new DateTimeImmutable('2023-03-01'),
    Operator::GTE,
);

/** @var \Ibexa\Contracts\ProductCatalog\ProductServiceInterface $productService */
$productQuery = new ProductQuery();
$productQuery->setQuery($criteria);
$results = $productService->findProducts($productQuery);
