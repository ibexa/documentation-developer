<?php declare(strict_types=1);

namespace App\Tracking;

use Ibexa\Contracts\ConnectorRaptor\Tracking\EventMapperInterface;
use Ibexa\Contracts\ConnectorRaptor\Tracking\EventType;
use Ibexa\Contracts\ConnectorRaptor\Tracking\ServerSideTrackingDispatcherInterface;
use Ibexa\Contracts\ProductCatalog\Values\ProductInterface;

class EventMapper
{
    public function __construct(
        private readonly EventMapperInterface $eventMapper,
        private readonly ServerSideTrackingDispatcherInterface $trackingDispatcher,
    ) {
    }

    public function trackProductView(ProductInterface $product, string $url): void
    {
        // Map product to VisitEventData automatically
        $eventData = $this->eventMapper->map(EventType::VISIT, $product);

        // Send tracking event
        $this->trackingDispatcher->dispatch($eventData);
    }
}
