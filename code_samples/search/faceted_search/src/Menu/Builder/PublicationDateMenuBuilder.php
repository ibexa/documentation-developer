<?php

declare(strict_types=1);

namespace App\Menu\Builder;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Range;
use Ibexa\Contracts\Core\Repository\Values\Content\Search\AggregationResult\RangeAggregationResult;
use Ibexa\Core\MVC\Symfony\Routing\RouteReference;
use Knp\Menu\ItemInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @template TOptions array{route: RouteReference, aggregation_result: RangeAggregationResult}
 */
final class PublicationDateMenuBuilder extends AbstractFacetsMenuBuilder
{
    /**
     * @param TOptions $options
     */
    public function doBuild(ItemInterface $menu, array $options): void
    {
        foreach ($options['aggregation_result'] as $range => $count) {
            if ($count > 0) {
                $menu->addChild($this->createMenuItem($range, $count, $options['route']));
            }
        }
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->define('aggregation_result')->required()->allowedTypes(RangeAggregationResult::class);
        $resolver->define('route')->required()->allowedTypes(RouteReference::class);
    }

    private function createMenuItem(Range $range, int $count, RouteReference $route): ItemInterface
    {
        $parameters = $route->getParams();
        $parameters['start'] = $range->getFrom()?->getTimestamp();
        $parameters['end'] = $range->getTo()?->getTimestamp();

        return $this->itemFactory->createItem(
            'range_' . $range,
            [
                'label' => $this->getLabel($range, $count),
                'route' => $route->getRoute(),
                'routeParameters' => $parameters,
            ]
        );
    }

    private function getLabel(Range $range, int $count): string
    {
        $date = $range->getFrom();

        return sprintf(
            '%s (%d)',
            $date !== null ? $date->format('F Y') : 'Older then 12 months',
            $count
        );
    }
}
