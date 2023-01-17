---
description: Ibexa DXP dispatches events before and after you perform different operations in the Back Office and on the Repository.
---

# Event reference

[[= product_name =]] dispatches events during different actions.
You can subscribe to these events to extend the functionality of the system.

In most cases, two events are dispatched for every action,
one before the action is completed, and one after.

For example, copying a Content item is connected with two events:
`BeforeCopyContentEvent` and `CopyContentEvent`.

``` php
<?php

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\Events\Content\CopyContentEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
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
