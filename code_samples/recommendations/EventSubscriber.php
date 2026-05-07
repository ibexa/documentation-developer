<?php declare(strict_types=1);

namespace App\Tracking;

use Ibexa\Contracts\ConnectorRaptor\Tracking\EventMapperInterface;
use Ibexa\Contracts\ConnectorRaptor\Tracking\EventType;
use Ibexa\Contracts\ConnectorRaptor\Tracking\ServerSideTrackingDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class EventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly EventMapperInterface $eventMapper,
        private readonly ServerSideTrackingDispatcherInterface $trackingDispatcher,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::RESPONSE => ['onResponse', -10]];
    }

    public function onResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        // Example: track only if request has specific attribute
        $product = $request->attributes->get('product');
        if (null === $product) {
            return;
        }

        $eventData = $this->eventMapper->map(EventType::VISIT, $product);
        $this->trackingDispatcher->dispatch($eventData);
    }
}
