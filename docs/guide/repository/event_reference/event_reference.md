# Event reference

[[= product_name =]] dispatches events during different actions.
You can subscribe to these events to extend the functionality of the system.

In most cases, two events are dispatched for every action,
one before the action is completed, and one after.

For example, copying a Content item is connected with two events:
`BeforeCopyContentEvent` and `CreateContentEvent`.

``` php
<?php

namespace App\EventSubscriber;

use eZ\Publish\API\Repository\Events\Content\CopyContentEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            CopyContentEvent::class => ['onEvent', 0],
        ];
    }

    public function onEvent(CopyContentEvent $event)
    {
        // your implementation
    }
}
```
