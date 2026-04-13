<?php declare(strict_types=1);

namespace App\Tracking;

use Ibexa\Contracts\ConnectorRaptor\Tracking\Event\VisitEventData;
use Ibexa\Contracts\ConnectorRaptor\Tracking\ServerSideTrackingDispatcherInterface;
use Ibexa\Contracts\ProductCatalog\Values\ProductInterface;

class EventData
{
    public function __construct(
        private readonly ServerSideTrackingDispatcherInterface $trackingDispatcher,
    ) {
    }

    public function dispatchVisitEvent(ProductInterface $product): void
    {
        $eventData = new VisitEventData(
            productCode: $product->getCode(),
            productName: $product->getName(),
            categoryPath: '25#Electronics;26#Smartphones',  // Build manually
            currency: 'USD',
            itemPrice: '999.99'
        );

        $this->trackingDispatcher->dispatch($eventData);
    }
}
