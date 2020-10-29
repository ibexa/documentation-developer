# Extending the dashboard

To extend the **My dashboard** page, make use of an event subscriber.

In the following example, the `DashboardEventSubscriber.php` removes the **Common content** section of the **My dashboard** page,
identified by the `ezplatform.adminui.dashboard.all` key:

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

        unset($components['ezplatform.adminui.dashboard.all']);
        $event->setComponents($components);
    }
}
```
