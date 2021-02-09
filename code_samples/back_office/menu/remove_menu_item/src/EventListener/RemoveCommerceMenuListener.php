<?php

namespace App\Event\EventListener;

use EzSystems\EzPlatformAdminUi\Menu\Event\ConfigureMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class RemoveCommerceMenuListener implements EventSubscriberInterface
{
    public function onMainMenuConfigure(ConfigureMenuEvent $event): void
    {
        $mainMenu = $event->getMenu();
        $mainMenu->removeChild('siso_commerce');
    }
    
    public static function getSubscribedEvents(): array
    {
        return [
            ConfigureMenuEvent::MAIN_MENU => ['onMainMenuConfigure', -10],
        ];
    }
}
