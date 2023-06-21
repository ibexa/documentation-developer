<?php declare(strict_types=1);

namespace App\Calendar\Holidays;

use DateTime;
use DateTimeInterface;
use Ibexa\Calendar\EventSource\InMemoryEventSource;
use Ibexa\Contracts\Calendar\EventCollection;
use Ibexa\Contracts\Calendar\EventSource\EventSourceInterface;

class EventSourceFactory
{
    private EventType $eventType;

    public function __construct(EventType $eventType)
    {
        $this->eventType = $eventType;
    }

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

    private function createEvent(string $id, DateTimeInterface $dateTime): Event
    {
        return new Event($id, $dateTime, $this->eventType);
    }
}
