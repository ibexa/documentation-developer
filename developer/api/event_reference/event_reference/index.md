# Event reference

Ibexa DXP dispatches events before and after you perform different operations in the back office and on the Repository.

Ibexa DXP dispatches events during different actions. You can subscribe to these events to extend the functionality of the system.

In most cases, two events are dispatched for every action, one before the action is completed, and one after.

For example, copying a content item is connected with two events: `BeforeCopyContentEvent` and `CopyContentEvent`.

```php
<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\Events\Content\CopyContentEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyEventSubcriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            CopyContentEvent::class => ['onCopyContent', 0],
        ];
    }

    public function onCopyContent(CopyContentEvent $event): void
    {
        // your implementation
    }
}
```

- [AI Actions events](../ai_action_events/index.md): Events that are triggered when working with AI actions.
- [Cart events](../cart_events/index.md): Events that are triggered when working with carts.
- [Product catalog events](../product_catalog_events/index.md): Events that are triggered when working with products, prices, currencies, and attribute rendering.
- [Collaboration events](../collaboration_events/index.md): Events that are triggered when working with collaborative editing feature.
- [Content events](../content_events/index.md): Events that are triggered when working with content.
- [Content type events](../content_type_events/index.md): Events that are triggered when working with content types.
- [Discounts events](../discounts_events/index.md): Events that are triggered when working with discounts.
- [Integrated help events](../integrated_help_events/index.md): Events that are triggered when working with integrated help features like product tours.
- [Language events](../language_events/index.md): Events that are triggered when working with languages.
- [Location events](../location_events/index.md): Events that are triggered when working with content Locations.
- [Object state events](../object_state_events/index.md): Events that are triggered when working with object states and object state groups.
- [Order management events](../order_management_events/index.md): Events that are triggered when working with orders.
- [Other events](../other_events/index.md): Events that are triggered when working with bookmarks, notifications, settings, forms and others.
- [Page events](../page_events/index.md): Events that are triggered when working with pages and page blocks.
- [Payment events](../payment_events/index.md): Events that are triggered when working with payments and payment methods.
- [Role events](../role_events/index.md): Events that are triggered when working with roles.
- [Section events](../section_events/index.md): Events that are triggered when working with sections.
- [Segmentation events](../segmentation_events/index.md): Events that are triggered when working with segments.
- [Site events](../site_events/index.md): Events that are triggered when working with sites.
- [Taxonomy events](../taxonomy_events/index.md): Events that are triggered when working with taxonomy.
- [Trash events](../trash_events/index.md): Events that are triggered when working with Trash.
- [Twig Components events](../twig_component_events/index.md): Events that are triggered when rendering Twig Components.
- [URL events](../url_events/index.md): Events that are triggered when working with URLs, URL aliases and URL wildcards.
- [User events](../user_events/index.md): Events that are triggered when working with users and user groups.
