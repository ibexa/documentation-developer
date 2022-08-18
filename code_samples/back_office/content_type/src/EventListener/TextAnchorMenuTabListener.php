<?php
namespace App\EventListener;
use Ibexa\AdminUi\Menu\ContentEditAnchorMenuBuilder;
use Ibexa\AdminUi\Menu\Event\ConfigureMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
class TextAnchorMenuTabListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [ConfigureMenuEvent::CONTENT_EDIT_ANCHOR_MENU => 'onAnchorMenuConfigure'];
    }
    public function onAnchorMenuConfigure(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();

        $menu[ContentEditAnchorMenuBuilder::ITEM__CONTENT];

        $menu[ContentEditAnchorMenuBuilder::ITEM__META];

        $menu->addChild('item', ['attributes' => ['data-target-id' => 'ibexa-edit-content-sections-item']]);

        $menu['item']->addChild('item_2', ['attributes' => ['data-target-id' => 'ibexa-edit-content-sections-item-item_2']]);
    }
}