<?php

declare(strict_types=1);

namespace App\Menu\Builder;

use Ibexa\Contracts\Core\Repository\Values\Content\Search\AggregationResult\TermAggregationResult;
use Ibexa\Contracts\Taxonomy\Service\TaxonomyServiceInterface;
use Ibexa\Contracts\Taxonomy\Value\TaxonomyEntry;
use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CategoriesMenuBuilder extends AbstractFacetsMenuBuilder
{
    private readonly TaxonomyServiceInterface $taxonomyService;

    public function __construct(
        TaxonomyServiceInterface $taxonomyService,
        RequestStack $requestStack,
        FactoryInterface $itemFactory
    ) {
        parent::__construct($itemFactory, $requestStack);

        $this->taxonomyService = $taxonomyService;
    }

    protected function doBuild(ItemInterface $menu, array $options): void
    {
        $this->createTaxonomyEntryWithChildren(
            $menu,
            $this->taxonomyService->loadRootEntry('tags'),
            $options,
        );
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->define('aggregation_result')->required()->allowedTypes(TermAggregationResult::class);
    }

    private function createTaxonomyEntryWithChildren(
        ItemInterface $menu,
        TaxonomyEntry $parent,
        array $options,
        int $depth = 3,
    ): void {
        $children = $this->taxonomyService->loadEntryChildren($parent);

        foreach ($children as $child) {
            $count = $this->getCount($options['aggregation_result'], $child);
            if ($count > 1) {
                $item = $this->createMenuItem($child, $count, $options);
                if ($depth > 1) {
                    $this->createTaxonomyEntryWithChildren($item, $child, $options, $depth - 1);
                }

                $menu->addChild($item);
            }
        }
    }

    private function createMenuItem(TaxonomyEntry $entry, int $count): ItemInterface
    {
        return $this->itemFactory->createItem(
            'taxonomy_entry_' . $entry->id,
            [
                'label' => sprintf('%s (%d)', $entry->getName(), $count),
                'route' => 'ibexa.url.alias',
                'routeParameters' => [
                    'contentId' => $entry->getContent()->id,
                ] + $this->requestStack->getCurrentRequest()->query->all(),
            ]
        );
    }

    private function getCount(?TermAggregationResult $aggregations, TaxonomyEntry $needle): int
    {
        if ($aggregations !== null) {
            foreach ($aggregations as $entry => $count) {
                if ($entry->getIdentifier() === $needle->getIdentifier()) {
                    return $count;
                }
            }
        }

        return 0;
    }
}
