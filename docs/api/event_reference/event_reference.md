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
