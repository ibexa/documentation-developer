<?php declare(strict_types=1);

namespace App\EventSubscriber;

use EzSystems\EzPlatformAdminUi\Menu\Event\ConfigureMenuEvent;
use EzSystems\EzPlatformAdminUi\Menu\MainMenuBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyMenuSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            ConfigureMenuEvent::MAIN_MENU => ['onMainMenuConfigure', 0],
            ConfigureMenuEvent::CONTENT_SIDEBAR_RIGHT => ['onContentSidebarConfigure', 0],
        ];
    }

    public function onMainMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        $menu[MainMenuBuilder::ITEM_CONTENT]->addChild(
            'all_content_list',
            [
                'label' => 'Content List',
                'route' => 'all_content_list.list',
                'attributes' => [
                    'class' => 'custom-menu-item',
                ],
                'linkAttributes' => [
                    'class' => 'custom-menu-item-link',
                ],
            ]
        );
    }

    public function onContentSidebarConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();

        $menu->removeChild('content__sidebar_right__copy_subtree');

        $menu->getChild('content__sidebar_right__create')
             ->setExtra('icon_path', '/bundles/ibexaplatformicons/img/all-icons.svg#notice');
    }
}
