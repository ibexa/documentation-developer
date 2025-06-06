<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\LogicalAnd;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ObjectStateIdentifier;
use Ibexa\Contracts\Elasticsearch\Query\Event\QueryFilterEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CustomQueryFilterSubscriber implements EventSubscriberInterface
{
    public function onQueryFilter(QueryFilterEvent $event): void
    {
        $query = $event->getQuery();

        $additionalCriteria = new ObjectStateIdentifier('locked');

        if ($query->filter !== null) {
            $query->filter = $additionalCriteria;
        } else {
            // Append Criterion to existing filter
            $query->filter = new LogicalAnd([
                $query->filter,
                $additionalCriteria,
            ]);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            QueryFilterEvent::class => 'onQueryFilter',
        ];
    }
}
