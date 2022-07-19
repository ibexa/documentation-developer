---
description: Manipulate the search query when using the Elasticsearch search engine.
---

# Manipulate Elasticsearch query

You can customize the search query before it is executed.
To do it, subscribe to `Ibexa\Contracts\ElasticSearchEngine\Query\Event\QueryFilterEvent`.

The following example shows how to add an additional Search Criterion to all queries.

Depending on your configuration, this might impact all search queries,
including those used for search and content tree in the Back Office.

``` php hl_lines="35"
<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\LogicalAnd;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\ObjectStateIdentifier;
use Ibexa\Contracts\ElasticSearch\Query\Event\QueryFilterEvent;
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
                $additionalCriteria
            ]);
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            QueryFilterEvent::class => 'onQueryFilter'
        ];
    }
}
```

Remember to register the subscriber as a service:

``` yaml
services:
    App\EventSubscriber\CustomQueryFilterSubscriber:
        tags:
            - { name: kernel.event_subscriber }
```
