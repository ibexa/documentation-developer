---
description: Add custom webhook event types and control the data included in webhook payloads.
month_change: false
---

# Extend webhooks

Out of the box, webhooks can subscribe to [21 repository events](webhook_payload_reference.md#event-types).
You can make any other event available to webhooks, for example, an event dispatched by your own code or by another [[= product_name =]] package, by registering a custom event type.

## How event types work

Each event type is a service that implements the [`WebhookEventType`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Webhooks-Event-WebhookEventType.html) interface and is tagged with `ibexa.webhook.event_type`.
The tag's `event_class` attribute contains the fully qualified class name of the Symfony event that the event type maps to.

When the container is compiled, the system registers a listener for every `event_class`.
When such an event is dispatched, the listener:

1. Converts the event to a normalized `DomainEvent` with an extractor.
The extractor resolves the [identifiers](webhook_payload_reference.md#identifiers) included in the payload, and the match context, which contains the content type, section, and location path strings that webhook [filters](webhooks_guide.md#filters) are evaluated against.
1. Finds all enabled webhooks that subscribe to the event type and whose filters match the event.
1. Creates a delivery for each of them and queues it.

Registered event types are automatically listed in the back office and returned by the `GET /webhook-event-types` REST API endpoint.

!!! note "After events only"

    Map event types to events dispatched after an operation is completed, such as the repository `AfterEvent` events.
    Otherwise, webhooks can notify external systems about operations that eventually fail.

## Register event type

In most cases, you can use the built-in `GenericWebhookEventType` class and configure it in the service definition.
The following example adds a `product.published` event type that maps to a custom `ProductPublishedEvent` event:

``` yaml
services:
    app.webhook.event_type.product_published:
        class: Ibexa\Webhooks\Event\Catalog\GenericWebhookEventType
        arguments:
            $identifier: 'product.published'
            $label: 'Product published'
            $group: 'Product'
            $eventClass: 'App\Event\ProductPublishedEvent'
        tags:
            - { name: ibexa.webhook.event_type, event_class: 'App\Event\ProductPublishedEvent' }
```

The following arguments are available:

| Argument | Description |
|---|---|
| `$identifier` | Unique identifier of the event type, sent in the `event` property of the payload and in the `X-Cohesivo-Event` header. Use the `<group>.<action>` convention, for example, `product.published`. |
| `$label` | Name of the event type displayed in the back office. |
| `$group` | Name of the group under which the event type is displayed in the back office. Event types with the same group name are displayed together. |
| `$eventClass` | Fully qualified class name of the event. Must be the same as the `event_class` attribute of the tag. |
| `$extractor` | Optional. ID of the extractor service. If not set, the default extractor is used. See [Custom extractor](#custom-extractor). |

Clear the cache to apply the changes:

``` bash
php bin/console cache:clear
```

!!! caution "Changing identifiers"

    Webhooks store the identifiers of the event types that they subscribe to.
    If you change or remove the identifier of an event type, existing webhooks stop receiving the event.

### Implement event type class

If you need more control, for example, to translate the label, implement the `WebhookEventType` interface:

``` php
<?php

declare(strict_types=1);

namespace App\Webhook;

use App\Event\ProductPublishedEvent;
use Ibexa\Contracts\Webhooks\Event\WebhookEventType;

final class ProductPublishedEventType implements WebhookEventType
{
    public function getIdentifier(): string
    {
        return 'product.published';
    }

    public function getLabel(): string
    {
        return 'Product published';
    }

    public function getGroup(): string
    {
        return 'Product';
    }

    public function getEventClass(): string
    {
        return ProductPublishedEvent::class;
    }

    public function getExtractor(): ?string
    {
        return null;
    }
}
```

Then, register it as a service with the `ibexa.webhook.event_type` tag:

``` yaml
services:
    App\Webhook\ProductPublishedEventType:
        tags:
            - { name: ibexa.webhook.event_type, event_class: 'App\Event\ProductPublishedEvent' }
```

## Custom extractor

The default extractor handles events that return a content item from a `getContent()` method.
It populates the `contentId`, `languageCode`, `locationId`, `versionNo`, and `languageCodes` identifiers, and the full match context, so that all filters apply to the event.

For any other event, the default extractor produces an empty `identifiers` object and an empty match context.
Webhooks subscribed to such an event receive every occurrence, regardless of their filters.

To include your own identifiers in the payload, or to make filters work for your event, create an extractor that implements `Ibexa\Webhooks\Event\Extractor\ExtractorInterface`:

``` php
<?php

declare(strict_types=1);

namespace App\Webhook;

use App\Event\ProductPublishedEvent;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Webhooks\Value\DomainEvent;
use Ibexa\Contracts\Webhooks\Value\MatchContext;
use Ibexa\Webhooks\Event\Extractor\ExtractorInterface;
use Psr\Clock\ClockInterface;

final class ProductExtractor implements ExtractorInterface
{
    public function __construct(
        private readonly PermissionResolver $permissionResolver,
        private readonly ClockInterface $clock,
    ) {
    }

    public function extract(object $event, string $type): DomainEvent
    {
        assert($event instanceof ProductPublishedEvent);

        $product = $event->getProduct();

        return new DomainEvent(
            type: $type,
            occurredAt: $this->clock->now(),
            actorId: $this->permissionResolver->getCurrentUserReference()->getUserId(),
            identifiers: [
                'productCode' => $product->getCode(),
                'contentId' => $product->getContent()->getId(),
            ],
            matchContext: new MatchContext(
                contentTypeIdentifier: $product->getProductType()->getIdentifier(),
            ),
        );
    }
}
```

The `DomainEvent` object has the following properties:

| Property | Description |
|---|---|
| `type` | Identifier of the event type. Pass the `$type` argument of the `extract()` method. |
| `occurredAt` | Date and time of the event. |
| `actorId` | ID of the user who triggered the event, or `null` for events triggered by the system. |
| `identifiers` | Map of identifiers included in the payload. Values can be integers, strings, or lists of strings. When the map contains `contentId` or `locationId`, the payload automatically includes the matching [links](webhook_payload_reference.md#links). |
| `matchContext` | `MatchContext` object with the `contentTypeIdentifier`, `sectionId`, and `locationPathStrings` properties that filters are evaluated against. Leave a property empty if it doesn't apply. A webhook with a non-empty filter doesn't receive events whose corresponding match context property is empty. |

Register the extractor as a service with the `ibexa.webhook.extractor` tag, and reference its service ID in the `$extractor` argument of the event type:

``` yaml
services:
    App\Webhook\ProductExtractor:
        tags:
            - { name: ibexa.webhook.extractor }

    app.webhook.event_type.product_published:
        class: Ibexa\Webhooks\Event\Catalog\GenericWebhookEventType
        arguments:
            $identifier: 'product.published'
            $label: 'Product published'
            $group: 'Product'
            $eventClass: 'App\Event\ProductPublishedEvent'
            $extractor: 'App\Webhook\ProductExtractor'
        tags:
            - { name: ibexa.webhook.event_type, event_class: 'App\Event\ProductPublishedEvent' }
```

If you implement the `WebhookEventType` interface, return the service ID of the extractor from the `getExtractor()` method.

!!! caution "Extractor tag"

    Extractors are resolved from a service locator built from services tagged with `ibexa.webhook.extractor`.
    If the extractor service isn't tagged, the default extractor is used instead, without any error message.

Exceptions thrown by an extractor are logged and don't interrupt the operation that dispatched the event, but no deliveries are created for that occurrence.
Keep extractors fast and free of side effects: they run synchronously, every time the event is dispatched, in the request that triggered it.
