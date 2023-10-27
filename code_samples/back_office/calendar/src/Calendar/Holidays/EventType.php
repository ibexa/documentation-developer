<?php declare(strict_types=1);

namespace App\Calendar\Holidays;

use EzSystems\EzPlatformCalendar\Calendar\Event;
use EzSystems\EzPlatformCalendar\Calendar\EventAction\EventActionCollection;
use EzSystems\EzPlatformCalendar\Calendar\EventType\EventTypeInterface;

class EventType implements EventTypeInterface
{
    private const EVENT_TYPE_IDENTIFIER = 'holiday';

    private $actions;

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
