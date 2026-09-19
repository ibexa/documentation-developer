# Customize calendar

Add custom events to the calendar and customize its looks.

By default, the Calendar displays scheduled events of the following types:

- Content publication (`future_publication`)
- Content hide (`future_hide`)
- Block reveal (`page_block_reveal`)
- Block hide (`page_block_hide`)

You can perform basic actions on these events.

You can also configure the calendar to display custom event types.

## Customize colors and icons

You can change the color of a calendar event or change the icon of an action. The setting is SiteAccess-aware.

To customize the appearance settings, use the `ibexa.system.<scope>.calendar.event_types` [configuration key](../../configuration/configuration/index.md#configuration-files):

```yaml
ibexa:
    system:
        admin_group:
            calendar:
                event_types:
                    future_publication:
                        color: '#47BEDB'
                        actions:
                            reschedule:
                                icon: '/bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#alert-error'
```

Line 6 contains the name of the event type, either a built-in custom one.

`color` defines the color in which events of this type are displayed in the calendar. `icon` is the icon used for a button with the relevant event action.

![Bank holiday with custom color](https://doc.ibexa.co/en/5.0/administration/img/extending_calendar_view.png)

## Configure custom events

The following example shows how to create custom events which add different holidays to the calendar.

First, create a new event in `src/Calendar/Holidays/Event.php`:

```php
<?php declare(strict_types=1);

namespace App\Calendar\Holidays;

use DateTimeInterface;
use Ibexa\Contracts\Calendar\Event as CalendarEvent;

class Event extends CalendarEvent
{
    public function __construct(string $id, DateTimeInterface $dateTime, EventType $type)
    {
        parent::__construct($type, $id, $dateTime);
    }
}
```

Here, you define a new class for your event based on `Ibexa\Contracts\Calendar\Event`.

Next, create `src/Calendar/Holidays/EventType.php`:

```php
<?php declare(strict_types=1);

namespace App\Calendar\Holidays;

use Ibexa\Contracts\Calendar\Event;
use Ibexa\Contracts\Calendar\EventAction\EventActionCollection;
use Ibexa\Contracts\Calendar\EventType\EventTypeInterface;

class EventType implements EventTypeInterface
{
    private const string EVENT_TYPE_IDENTIFIER = 'holiday';

    private readonly EventActionCollection $actions;

    public function __construct(iterable $actions)
    {
        $this->actions = new EventActionCollection($actions);
    }

    public function getTypeIdentifier(): string
    {
        return self::EVENT_TYPE_IDENTIFIER;
    }

    public function getTypeLabel(): string
    {
        return 'Holidays';
    }

    public function getEventName(Event $event): string
    {
        return $event->getId();
    }

    public function getActions(): EventActionCollection
    {
        return $this->actions;
    }
}
```

You can use the identifier defined in lines 20-23 to configure [event colors](#customize-colors-and-icons).

Complete the procedure by registering the new event type as a service:

```yaml
services:
    App\Calendar\Holidays\EventType:
        arguments:
            $actions: [ ]
        tags:
            - { name: ibexa.calendar.event.type }
```

## Configure event sources

To add specific events to your calendar, you need to create an event source.

An event source must implement `Ibexa\Contracts\Calendar\EventSource\EventSourceInterface`.

One such built-in implementation is `InMemoryEventSource`. To add an in-memory collection as an event source, create `src/Calendar/Holidays/EventSourceFactory.php`:

```php
<?php declare(strict_types=1);

namespace App\Calendar\Holidays;

use DateTime;
use DateTimeInterface;
use Ibexa\Contracts\Calendar\EventCollection;
use Ibexa\Contracts\Calendar\EventSource\EventSourceInterface;
use Ibexa\Contracts\Calendar\EventSource\InMemoryEventSource;

class EventSourceFactory
{
    public function __construct(private readonly EventType $eventType)
    {
    }

    public function createEventSource(): EventSourceInterface
    {
        $eventCollectionArray = [];
        $eventCollectionArray[] = $this->createEvent('April Fools', new DateTime('2024-04-01'));

        $collection = new EventCollection($eventCollectionArray);

        return new InMemoryEventSource($collection);
    }

    private function createEvent(string $id, DateTimeInterface $dateTime): Event
    {
        return new Event($id, $dateTime, $this->eventType);
    }
}
```

> **Note: Note**
>
> When creating the list of events, you must list all the `createEvent()` entities chronologically.
>
> For example:
>
> ```php
> use App\Calendar\Holidays\Event;
> use Ibexa\Contracts\Calendar\EventCollection;
>
> /** @var \App\Calendar\Holidays\EventType $eventType */
> $collection = new EventCollection([
>     new Event('Event 1', new DateTime('2024-01-01'), $eventType),
>     new Event('Event 2', new DateTime('2024-01-02'), $eventType),
>     // ...
> ]);
> ```

Next, register the event source as a service:

```yaml
services:
    App\Calendar\Holidays\EventSourceFactory:
        arguments:
            $eventType: '@App\Calendar\Holidays\EventType'

    App\Calendar\Holidays\EventSource:
        class: Ibexa\Calendar\EventSource\InMemoryEventSource
        factory: [ '@App\Calendar\Holidays\EventSourceFactory', 'createEventSource' ]
        tags:
            - { name: ibexa.calendar.event.source }
```

Now you can go to the **Calendar** tab and see the configured holiday.

![Custom events list view](https://doc.ibexa.co/en/5.0/administration/img/extending_calendar_list_view.png)

### Import events from external sources

You can also import events from external sources, for example, a JSON file. To do this, place the following `holidays.json` file in `src/Calendar/Holidays`:

```json
[
    {
      "date": "2024-01-01",
      "name": "New Year Day"
    },
    {
      "date": "2023-12-25",
      "name": "Christmas Day"
    }
  ]
```

Next, import this file in `src/Calendar/Holidays/EventSourceFactory.php`:

```php
public function createEventSource(): EventSourceInterface
{
    $eventCollectionArray = [];
    $eventCollectionArray[] = $this->createEvent('April Fools', new DateTime('2024-04-01'));

    $items = json_decode(file_get_contents(__DIR__ . \DIRECTORY_SEPARATOR . 'holidays.json'), true);
    foreach ($items as $item) {
        $eventCollectionArray[] = $this->createEvent($item['name'], new DateTime($item['date']));
    }

    $collection = new EventCollection($eventCollectionArray);

    return new InMemoryEventSource($collection);
}
```

The calendar now displays the events listed in the JSON file.
