<?php declare(strict_types=1);

namespace App\Tracking;

use Ibexa\Contracts\ConnectorRaptor\Tracking\EventContext;
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

    public function trackProductView(ProductInterface $product): void
    {
        // Map product to BuyEventData automatically
        $eventData = $this->eventMapper->map(EventType::BUY, $product, [
            EventContext::SUBTOTAL => '200',
            EventContext::CURRENCY => 'EUR',
            EventContext::QUANTITY => '2',
        ]);

        // Send tracking event
        $this->trackingDispatcher->dispatch($eventData);
    }
}
