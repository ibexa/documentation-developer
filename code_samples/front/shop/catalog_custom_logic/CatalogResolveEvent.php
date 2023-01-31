<?php

namespace App\EventSubscriber;

use Ibexa\Contracts\ProductCatalog\CatalogServiceInterface;
use Ibexa\Contracts\Storefront\Repository\Event\CatalogResolveEvent;
use Ibexa\Contracts\Storefront\Menu\Event\ConfigureMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CatalogSubscriber implements EventSubscriberInterface
{
    private CatalogServiceInterface $catalogService;

    public function __construct(CatalogServiceInterface $catalogService) 
    {
        $this->catalogService = $catalogService;
    }

    public static function getSubscribedEvents(): array 
    {
        return [
            CatalogResolveEvent::class => 'onCatalogResolve',
        ];
    }

    public function onCatalogResolve(CatalogResolveEvent $event): void
    {
        $user = $event->getUser();
        if (str_ends_with($user->email, '@ibexa.co')) {
            // Custom catalog for Ibexa employees 
            $event->setCatalog($this->catalogService->getCatalogByIdentifier('employees'));
        }      
    }
}