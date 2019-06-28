# Customizing calendar widget

The calendar widget allows you to display all scheduled events.
You can also configure it to display your custom event types or display them from [external resources](#configuring-custom-calendar-event-sources).

Optionally, you can customize the color of a custom event and make it look different depending on the [SiteAccess configuration](../guide/siteaccess.md#configuring-siteaccesses). 

You can also [change the calendar](#accessing-calendar-configuration) configuration by accessing the configuration from the JavaScript.

## Configuring custom calendar events

Configuring custom events allows you to tailor the calendar to your needs.
You can create a custom event by taking a few steps to define the event and actions for it.

First, create a new event by creating `src\Calendar\EventType\MyEvent.php`

``` PHP hl_lines="7"

<?php

declare(strict_types=1);

namespace App\Calendar\Event;

use App\Calendar\EventType\MyEventType;
use DateTimeInterface;
use EzSystems\EzPlatformCalendar\Calendar\Event;

final class MyEvent extends Event
{
    public function __construct(string $id, DateTimeInterface $dateTime, MyEventType $type)
    {
        parent::__construct($type, $id, $dateTime);
    }
}
```

Here, you create a new class for you event based on `\EzSystems\EzPlatformCalendar\Calendar\Event`.
Line 7 points out to the custom event definition of associated actions.

Provide a definition for your event by creating `\App\Calendar\EventType\MyEventType.php`:

``` PHP hl_lines="28 29 30 31"

<?php

declare(strict_types=1);

namespace App\Calendar\EventType;

use EzSystems\EzPlatformCalendar\Calendar\Event;
use EzSystems\EzPlatformCalendar\Calendar\EventType\EventTypeInterface;
use Symfony\Component\Translation\TranslatorInterface;

final class MyEventType implements EventTypeInterface
{
    private const EVENT_TYPE_IDENTIFIER = 'MyEvent';

    /** @var \Symfony\Component\Translation\TranslatorInterface */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getTypeIdentifier(): string;
    {
        return self::EVENT_TYPE_IDENTIFIER;
    }

    public function getEventName(Event $event): string
    {
        return $this->translator->trans($event->getId(), [], 'MyEvents');
    }
}
```
Here, lines 28-31 are responsible for building names for your custom events using a pattern.

Complete the procedure by registering the new event:

``` YAML
services:

  App\Calendar\EventType\CustomEventType:
        tags:
            - { name: ezplatform.calendar.event_type }

```


## Configuring custom calendar event sources

You can configure the calendar through `CalendarService` to display events from:

- In-memory collection (`\EzSystems\EzPlatformCalendar\Calendar\EventSource\InMemoryEventSource`)
- External API
- Date-based publisher

For adding an in-memory collection as event source, create `MyEventSourceFactory.php`:

``` PHP
<?php

declare(strict_types=1);

namespace App\Calendar\EventSourceFactory;

use App\Calendar\Event\HolidayEvent;
use App\Calendar\EventType\HolidayEventType;
use DateTime;
use DateTimeInterface;
use EzSystems\EzPlatformCalendar\Calendar\EventCollection;
use EzSystems\EzPlatformCalendar\Calendar\EventSource\EventSourceInterface;
use EzSystems\EzPlatformCalendar\Calendar\EventSource\InMemoryEventSource;

final class MyEventSourceFactory
{
    /** @var \App\Calendar\EventType\HolidayEventType */
    private $eventType;
    public function __construct(HolidayEventType $eventType)
    {
        $this->eventType = $eventType;
    }

    public function createEventSource(): EventSourceInterface
    {
        $holidays = new EventCollection([
            $this->createEvent("Event 1", new DateTime("YYYY-MM-DD")),
            $this->createEvent("Event 2", new DateTime("YYYY-MM-DD")),
            $this->createEvent("Event 3", new DateTime("YYYY-MM-DD")),
            $this->createEvent("Event 4", new DateTime("YYYY-MM-DD")),
            // ...
        ]);
        return new InMemoryEventSource($MyEvents);
    }

    private function createEvent(string $id, DateTimeInterface $dateTime): MyEvent
    {
        return new MyEvent($id, $dateTime, $this->eventType);
    }
}
```

You must also register the new source:

``` YAML
services:

    App\Calendar\EventSourceFactory\MyEventSourceFactory:
        arguments:
            $eventType: '@App\Calendar\EventType\MyEventType'
    
    App\Calendar\EventSource\HolidaysEventSource:
        class: EzSystems\EzPlatformCalendar\Calendar\EventSource\InMemoryEventSource
        factory: 'App\Calendar\EventSourceFactory\MyEventSourceFactory:createEventSource'
        tags:
            - { name: ezplatform.calendar.event_source }
```

## Customizing custom events appearance

You can change the foreground and background color of a custom event.
The setting is SiteAccess-aware.

To customize the the color of a custom event, add the following configuration to `config/packages/ezplatform.yml`:

```yaml hl_lines="6"
ezpublish:
    system:
        admin_group:
            calendar:
                event_types:
                    event:
                        color: '#FFFFFF'
```

Note that line 6 points out to the event you want to customize.

## Accessing calendar configuration

The calendar widget configuration is accessible from JavaScript by using the `eZ.calendar.config` global variable.
You can configure a label, color and actions for each of the events that the widget displays.

For example:

```javascript
{
   "types":{
      "event":{
         "label":"My Custom Event",
         "color":"#000000",
         "actions":[],
         "isSelectable":false
      },
   }
}
```



