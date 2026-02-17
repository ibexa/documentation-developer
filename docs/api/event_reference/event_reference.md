---
description: Ibexa DXP dispatches events before and after you perform different operations in the back office and on the Repository.
page_type: reference
---

# Event reference

[[= product_name =]] dispatches events during different actions.
You can subscribe to these events to extend the functionality of the system.

In most cases, two events are dispatched for every action, one before the action is completed, and one after.

For example, copying a content item is connected with two events: `BeforeCopyContentEvent` and `CopyContentEvent`.

``` php
[[= include_file('code_samples/api/public_php_api/src/EventSubscriber/MyEventSubcriber.php') =]]
```

[[= cards([
    "api/event_reference/ai_action_events",
    "api/event_reference/cart_events",
    "api/event_reference/catalog_events",
    "api/event_reference/collaboration_events",
    "api/event_reference/content_events",
    "api/event_reference/content_type_events",
    "api/event_reference/discounts_events",
    "api/event_reference/integrated_help_events",
    "api/event_reference/language_events",
    "api/event_reference/location_events",
    "api/event_reference/object_state_events",
    "api/event_reference/order_management_events",
    "api/event_reference/other_events",
    "api/event_reference/page_events",
    "api/event_reference/payment_events",
    "api/event_reference/role_events",
    "api/event_reference/section_events",
    "api/event_reference/segmentation_events",
    "api/event_reference/site_events",
    "api/event_reference/taxonomy_events",
    "api/event_reference/trash_events",
    "api/event_reference/twig_component_events",
    "api/event_reference/url_events",
    "api/event_reference/user_events",
], columns=3) =]]
