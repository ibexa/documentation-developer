# Customizing the calendar widget

## Custom calendar events

The calendar widget allows you to display all scheduled events.
You can also configure it to display your custom event types or from [multiple external resources](#displaying-events-from-multiple-resources-in-calendar).

## Configuring custom calendar events

Configuring custom events allows you to tailor the calendar to your needs.
You can create a custom event by taking a few steps to define the event and actions for it.

First, create a new event by creating `\EzSystems\EzPlatformCalendar\Calendar\EventType\MyEvent.php`

``` PHP hl_lines="7"

<?php

declare(strict_types=1);

namespace AppBundle\Calendar\Event;

use AppBundle\Calendar\EventType\MyEventType;
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

Provide a definition for your event by creating `\EzSystems\EzPlatformCalendar\Calendar\EventType\MyEventType.php`:

``` PHP hl_lines="28 29 30 31"

<?php

declare(strict_types=1);

namespace AppBundle\Calendar\EventType;

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

  AppBundle\Calendar\EventType\CustomEventType:
        tags:
            - { name: ezplatform.calendar.event_type }

```


## Displaying events from multiple resources in calendar

You can configure the calendar through `CalendarService` to display events from:

- In-memory collection (`\EzSystems\EzPlatformCalendar\Calendar\EventSource\InMemoryEventSource`)
- External API
- Date-based publisher

For adding an in-memory collection as event source, create `MyEventSourceFactory.php`:

``` PHP
<?php

declare(strict_types=1);

namespace AppBundle\Calendar\EventSourceFactory;

use AppBundle\Calendar\Event\HolidayEvent;
use AppBundle\Calendar\EventType\HolidayEventType;
use DateTime;
use DateTimeInterface;
use EzSystems\EzPlatformCalendar\Calendar\EventCollection;
use EzSystems\EzPlatformCalendar\Calendar\EventSource\EventSourceInterface;
use EzSystems\EzPlatformCalendar\Calendar\EventSource\InMemoryEventSource;

final class MyEventSourceFactory
{
    /** @var \AppBundle\Calendar\EventType\HolidayEventType */
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

    AppBundle\Calendar\EventSourceFactory\MyEventSourceFactory:
        arguments:
            $eventType: '@AppBundle\Calendar\EventType\MyEventType'
    
    AppBundle\Calendar\EventSource\HolidaysEventSource:
        class: EzSystems\EzPlatformCalendar\Calendar\EventSource\InMemoryEventSource
        factory: 'AppBundle\Calendar\EventSourceFactory\MyEventSourceFactory:createEventSource'
        tags:
            - { name: ezplatform.calendar.event_source }
```