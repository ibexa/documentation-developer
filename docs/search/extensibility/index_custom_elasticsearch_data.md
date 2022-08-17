---
description: Index custom data when using the Elasticsearch search engine.
---

# Index custom Elasticsearch data

[Elasticsearch](elasticsearch_search_engine.md) indexes content and Location data out of the box.
Besides what is indexed automatically, you can add additional data to the Elasticsearch index.

To do so, subscribe to one of the following events:

- `Ibexa\Contracts\ElasticSearchEngine\Mapping\Event\ContentIndexCreateEvent`
- `Ibexa\Contracts\ElasticSearchEngine\Mapping\Event\LocationIndexCreateEvent`

These events are called when the index is created for the content and Location documents, respectively.

You can pass the event to a subscriber which gives you access to the document that you can modify.

In the following example, when an index in created for a content or a Location document,
the event subscriber adds a `custom_field` of the type `StringField` to the index:

``` php hl_lines="19 20 21"
<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Search\Field;
use Ibexa\Contracts\Core\Search\FieldType\StringField;
use Ibexa\Contracts\Elasticsearch\Mapping\Event\ContentIndexCreateEvent;
use Ibexa\Contracts\Elasticsearch\Mapping\Event\LocationIndexCreateEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CustomIndexDataSubscriber implements EventSubscriberInterface
{
    public function onContentDocumentCreate(ContentIndexCreateEvent $event): void
    {
        $document = $event->getDocument();
        $document->fields[] = new Field(
            'custom_field',
            'Custom field value',
            new StringField()
        );
    }

    public function onLocationDocumentCreate(LocationIndexCreateEvent $event): void
    {
        $document = $event->getDocument();
        $document->fields[] = new Field(
            'custom_field',
            'Custom field value',
            new StringField()
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ContentIndexCreateEvent::class => 'onContentDocumentCreate',
            LocationIndexCreateEvent::class => 'onLocationDocumentCreate'
        ];
    }
}
```

Remember to register the subscriber as a service:

``` yaml
services:
    App\EventSubscriber\CustomIndexDataSubscriber:
        tags:
            - { name: kernel.event_subscriber }
```
