<?php declare(strict_types=1);

use Ibexa\Contracts\ProductCatalog\ProductServiceInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\ProductQuery;
use Ibexa\Contracts\ProductCatalogSymbolAttribute\Search\Criterion\SymbolAttribute;

$query = new ProductQuery();
$query->setFilter(new SymbolAttribute('ean', ['5023920187205']));
/** @var ProductServiceInterface $productService */
$results = $productService->findProducts($query);
