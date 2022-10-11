<?php

declare(strict_types=1);

namespace App\CatalogFilter;

use Ibexa\Bundle\ProductCatalog\Form\Type\TagifyType;
use Ibexa\Contracts\ProductCatalog\CatalogFilters\FilterDefinitionInterface;
use Ibexa\Contracts\ProductCatalog\CatalogFilters\FilterFormMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductNameFilterFormMapper implements FilterFormMapperInterface
{
    public function __construct()
    {
    }

    public function createFilterForm(
        FilterDefinitionInterface $filterDefinition,
        FormBuilderInterface $builder,
        array $context = []
    ): void {
        $builder->add(
            $filterDefinition->getIdentifier(),
            TagifyType::class,
            [
                'label' => 'Product name',
                'block_prefix' => 'catalog_criteria_product_name',
                'translation_domain' => 'product_catalog',
            ]
        );

        $builder->get($filterDefinition->getIdentifier())
            ->addModelTransformer(
                new DataTransformer\ProductNameCriterionTransformer()
            );
    }

    public function supports(FilterDefinitionInterface $filterDefinition): bool
    {
        return $filterDefinition instanceof ProductNameFilter;
    }
}
