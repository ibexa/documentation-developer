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
        // access anchor menu root item
        $menu = $event->getMenu();

        // if you need to access "Content" tab, use ITEM__CONTENT constant:
        $menu[ContentEditAnchorMenuBuilder::ITEM__CONTENT];

        // if you need to access "Meta" tab, use ITEM__META constant:
        $menu[ContentEditAnchorMenuBuilder::ITEM__META];

        // Adding new tab called "New tab"
        $menu->addChild('New tab', ['attributes' => ['data-target-id' => 'ibexa-edit-content-sections-new-tab']]);

        // Add second level item "2nd level item" to previously created "New tab" tab
        $menu['New tab']->addChild('2nd level item', ['attributes' => ['data-target-id' => 'ibexa-edit-content-sections-new-tab-item_2']]);
    }
}
