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
