# Extending Dashboard

To extend the Dashboard, make use of an event subscriber.

In the following example, the `DashboardEventSubscriber.php` reverses the order of sections of the Dashboard
(in a default installation this makes the **Common content** block appear above the **My content** block):

``` php
<?php

namespace App\EventSubscriber;

use EzSystems\EzPlatformAdminUi\Component\Event\RenderGroupEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DashboardEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            RenderGroupEvent::NAME => ['onRenderGroupEvent', 20],
        ];
    }

    public function onRenderGroupEvent(RenderGroupEvent $event)
    {
        if ($event->getGroupName() !== 'dashboard-blocks') {
            return;
        }

        $components = $event->getComponents();

        $reverseOrder = array_reverse($components);

        $event->setComponents($reverseOrder);

    }
}
```
