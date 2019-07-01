# Customizing Calendar widget

By default, the calendar widget allows you to display all scheduled events.
You can also configure it to display your custom event types or display them from [custom sources](#configuring-custom-calendar-event-sources).

Optionally, you can [change the color of a custom event](#customizing-event-color) and make it look differently depending on the [SiteAccess configuration](../guide/siteaccess.md#configuring-siteaccesses).

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

Here, you define a new class for you event based on `\EzSystems\EzPlatformCalendar\Calendar\Event`.
Line 7 points to the custom event definition for actions associated with your event.

Proceed with providing the definition for your event by creating `\App\Calendar\EventType\MyEventType.php`:

``` PHP hl_lines="28 29 30 31 33 34 35 36"

<?php

declare(strict_types=1);

namespace App\Calendar\EventType;

use EzSystems\EzPlatformCalendar\Calendar\Event;
use EzSystems\EzPlatformCalendar\Calendar\EventType\EventTypeInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

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
    
    public function getTypeLabel(): string
        {
            return $this->translator->trans('event_type.private.label', [], 'my_calendar_extension');
        }
}
```
Here, lines 28-31 are responsible for building names for your custom events using a pattern.
Lines 33-36 use the `\EzSystems\EzPlatformCalendar\Calendar\EventType\EventTypeInterface::getTypeLabel` to generate a label.

Complete the procedure by registering the new event:

``` YAML
services:

  App\Calendar\EventType\CustomEventType:
        tags:
            - { name: ezplatform.calendar.event_type }

```

### Adding actions to events

The definition of the event action implements [`Calendar\EventAction\EventActionInterface`](https://github.com/ezsystems/ezplatform-calendar/blob/master/src/lib/Calendar/EventAction/EventActionInterface.php).
The [`EventTypeInterface::getActions`](https://github.com/ezsystems/ezplatform-calendar/blob/b88392263deec46d7603d7ecf67ab9bb908787e0/src/lib/Calendar/EventType/EventTypeInterface.php#L44) 
method specifies actions supported by a specific even type.

You can add an action to an event by injecting it using the event type constructor:

``` PHP
<?php

# ...

final class ExampleEventType implements EventTypeInterface
{
    /** @var \EzSystems\EzPlatformCalendar\Calendar\EventAction\EventActionCollection */
    private $actions;

    public function __construct(iterable $actions)
    {
        $this->actions = new EventActionCollection($actions);
    }

    # ...

    public function getActions(): EventActionCollection
    {
        return $this->actions;
    }
}
```

The added actions require registering them as services:

``` YAML hl_lines="4 7 10 15"
services:

    EzSystems\EzPlatformCalendarDemo\Event\Example\Action\FooAction:
        tags: ['ezplatform.calendar.event_type.example.action']

    EzSystems\EzPlatformCalendarDemo\Event\Example\Action\BarAction:
        tags: ['ezplatform.calendar.event_type.example.action']  

    EzSystems\EzPlatformCalendarDemo\Event\Example\Action\BazAction:
        tags: ['ezplatform.calendar.event_type.example.action']    
# ...

    EzSystems\EzPlatformCalendarDemo\Event\Example\ExampleEventType:
        arguments:
            $actions: !tagged ezplatform.calendar.event_type.example.action
```

Note that in lines: 4, 7, 10 you provide custom-created tags used in line 15 to assign actions to an event.


## Configuring custom calendar event sources

You can implement a custom event source by using:

- [`EzSystems\EzPlatformCalendar\Calendar\EventSourceInterface`](https://github.com/ezsystems/ezplatform-calendar/blob/master/src/lib/Calendar/EventSource/EventSourceInterface.php)
- [`EzSystems\EzPlatformCalendar\Calendar\InMemoryEventSource`](https://github.com/ezsystems/ezplatform-calendar/blob/master/src/lib/Calendar/EventSource/InMemoryEventSource.php)

To add an in-memory collection as an event source, create `app/Calendar/EventSourceFactory/MyEventSourceFactory.php`:

``` PHP hl_lines="26 27 28"
<?php

declare(strict_types=1);

namespace App\Calendar\EventSourceFactory;

use App\Calendar\Event\ExampleEvent;
use App\Calendar\EventType\ExampleEventType;
use DateTime;
use DateTimeInterface;
use EzSystems\EzPlatformCalendar\Calendar\EventCollection;
use EzSystems\EzPlatformCalendar\Calendar\EventSource\EventSourceInterface;
use EzSystems\EzPlatformCalendar\Calendar\EventSource\InMemoryEventSource;

final class MyEventSourceFactory
{
    /** @var \App\Calendar\EventType\ExampleEventType */
    private $eventType;
    public function __construct(ExampleEventType $eventType)
    {
        $this->eventType = $eventType;
    }

    public function createEventSource(): EventSourceInterface
    {
        $collection_name = new EventCollection([
            $this->createEvent("Event 1", new DateTime("YYYY-MM-DD")),
            $this->createEvent("Event 2", new DateTime("YYYY-MM-DD")),
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

!!! note

    When providing the list of events for  `$collection_name = new EventCollection()`, you must put all the `createEvent()` elements sorted according to their time stamp.
    
    For example:
    
    ```PHP
    $collection_name = new EventCollection([
        $this->createEvent("Event 1", new DateTime("2019-01-01")),
        $this->createEvent("Event 2", new DateTime("2019-01-02")),
        // ...
    ```
    

Complete the procedure by registering the new source:

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

## Customizing event color

You can change the foreground and background color of a custom event.
The setting is SiteAccess-aware.

To customize the color of a custom event, add the following configuration to `config/packages/ezplatform.yml`:

``` YAML hl_lines="6"
ezpublish:
    system:
        admin_group:
            calendar:
                event_types:
                    event_name:
                        color: '#FFFFFF'
```

Note that line 6 points to the event name you want to customize.



