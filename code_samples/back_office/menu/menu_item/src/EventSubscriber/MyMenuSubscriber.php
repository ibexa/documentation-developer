<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\AdminUi\Menu\Event\ConfigureMenuEvent;
use Ibexa\AdminUi\Menu\MainMenuBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MyMenuSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ConfigureMenuEvent::MAIN_MENU => ['onMainMenuConfigure', 0],
        ];
    }

    public function onMainMenuConfigure(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();

        $customMenuItem = $menu[MainMenuBuilder::ITEM_CONTENT]->addChild(
            'main__content__custom_menu',
            [
                'extras' => [
                    'orderNumber' => 100,
                ],
            ],
        );

        $customMenuItem->addChild(
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

        $menu->removeChild('main__bookmarks');

        $menu->getChild('main__admin')
            ->setExtra('icon_path', '/bundles/ibexaicons/img/all-icons.svg#notice');
    }
}
