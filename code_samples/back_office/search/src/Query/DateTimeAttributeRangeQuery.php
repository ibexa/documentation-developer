<?php declare(strict_types=1);

use DateTimeImmutable;
use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalogDateTimeAttribute\Search\Criterion\DateTimeAttributeRange;

$query = new ProductQuery();
$query->setFilter(new DateTimeAttributeRange('event_date', new DateTimeImmutable('2025-01-01')));
/** @var ProductServiceInterface $productService */
$results = $productService->findProducts($query);
