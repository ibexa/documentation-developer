<?php

use DateTimeImmutable;
use Ibexa\Contracts\CoreSearch\Values\Query\Criterion\FieldValueCriterion;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalogDateTimeAttribute\Search\Criterion\DateTimeAttributeRange;

$query = new ProductQuery();
$query->setFilter(new DateTimeAttributeRange('event_date', new DateTimeImmutable('2025-01-01')));
/** @var \Ibexa\Contracts\ProductCatalog\ProductServiceInterface $productService*/
$results = $productService->findProducts($query);
