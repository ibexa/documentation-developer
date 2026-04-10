<?php declare(strict_types=1);
use Ibexa\Contracts\ConnectorRaptor\Tracking\Event\VisitEventData;

$eventData = new VisitEventData(
    productCode: $product->getCode(),
    productName: $product->getName(),
    categoryPath: '25#Electronics;26#Smartphones',  // Build manually
        currency: 'USD',
    itemPrice: '999.99'
);

$this->trackingDispatcher->dispatch($eventData);
