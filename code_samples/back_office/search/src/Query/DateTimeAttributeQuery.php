<?php

use DateTimeImmutable;
use Ibexa\Contracts\CoreSearch\Values\Query\Criterion\FieldValueCriterion;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalogDateTimeAttribute\Search\Criterion\DateTimeAttribute;

$query = new ProductQuery();
$filter = new DateTimeAttribute('event_date', new DateTimeImmutable('2025-07-06'));
$filter->setOperator(FieldValueCriterion::EQ);
$query->setFilter($filter);
/** @var \Ibexa\Contracts\ProductCatalog\ProductServiceInterface $productService*/
$results = $productService->findProducts($query);
