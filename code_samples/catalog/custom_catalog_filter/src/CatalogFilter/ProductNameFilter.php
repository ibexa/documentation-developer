<?php

declare(strict_types=1);

namespace App\CatalogFilter;

use Ibexa\Contracts\ProductCatalog\CatalogFilters\FilterDefinitionInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductName;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\CriterionInterface;

final class ProductNameFilter implements FilterDefinitionInterface
{
    public function getIdentifier(): string
    {
        return 'product_name';
    }

    public function getName(): string
    {
        return 'Product name';
    }

    public function supports(CriterionInterface $criterion): bool
    {
        return $criterion instanceof ProductName;
    }

    public static function getTranslationMessages(): array
    {
        return [];
    }

    public function getGroupName(): string
    {
        return 'Custom filters';
    }
}
