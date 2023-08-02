<?php declare(strict_types=1);

namespace App\Calendar\Holidays;

use DateTime;
use DateTimeInterface;
use EzSystems\EzPlatformCalendar\Calendar\EventCollection;
use EzSystems\EzPlatformCalendar\Calendar\EventSource\EventSourceInterface;
use EzSystems\EzPlatformCalendar\Calendar\EventSource\InMemoryEventSource;

class EventSourceFactory
{
    private $eventType;

    public function __construct(EventType $eventType)
    {
        $this->eventType = $eventType;
    }

    public function createEventSource(): EventSourceInterface
    {
        $eventCollectionArray = [];
        $eventCollectionArray[] = $this->createEvent('April Fools', new DateTime('2022-04-01'));

        $items = json_decode(file_get_contents(__DIR__ . \DIRECTORY_SEPARATOR . 'holidays.json'), true);
        foreach ($items as $item) {
            $eventCollectionArray[] = $this->createEvent($item['name'], new DateTime($item['date']));
        }

        $collection = new EventCollection($eventCollectionArray);

        return new InMemoryEventSource($collection);
    }

    private function createEvent(string $id, DateTimeInterface $dateTime): Event
    {
        return new Event($id, $dateTime, $this->eventType);
    }
}
