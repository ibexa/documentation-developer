# Manipulate Elasticsearch query

Manipulate the search query when using the Elasticsearch search engine.

You can customize the search query before it's executed. To do it, subscribe to [`Ibexa\Contracts\Elasticsearch\Query\Event\QueryFilterEvent`](../../../../../../ibexa/elasticsearch/src/contracts/Query/Event/QueryFilterEvent.php).

The following example shows how to add a Search Criterion to all queries.

Depending on your configuration, this might impact all search queries, including those used for search and content tree in the back office.

```php
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
```

If you're not using [Symfony's autoconfiguration](https://symfony.com/doc/7.4/service_container.html#the-autoconfigure-option) for event subscribers, register it as a service:

```yaml
services:
    App\EventSubscriber\CustomQueryFilterSubscriber:
        tags:
            - { name: kernel.event_subscriber }
```
