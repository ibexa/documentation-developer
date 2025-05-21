<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Bundle\Storefront\Menu\Builder\BreadcrumbsMenuBuilder;
use Ibexa\Contracts\Storefront\Menu\Event\ConfigureMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BreadcrumbsMenuSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            BreadcrumbsMenuBuilder::PRODUCT_MENU => ['onBreadcrumbsMenuConfigure', 0],
        ];
    }

    public function onBreadcrumbsMenuConfigure(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();

        // Replace link to home with link to product catalog root
        $menu->getChild('location_2')->setUri('/product-catalog');
    }
}
