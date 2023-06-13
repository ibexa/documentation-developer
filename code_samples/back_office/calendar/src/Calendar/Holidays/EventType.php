<?php declare(strict_types=1);

namespace App\Calendar\Holidays;

use Ibexa\Calendar\EventAction\EventActionCollection;
use Ibexa\Contracts\Calendar\Event;
use Ibexa\Contracts\Calendar\EventType\EventTypeInterface;

class EventType implements EventTypeInterface
{
    private const EVENT_TYPE_IDENTIFIER = 'holiday';

    private EventActionCollection $actions;

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
