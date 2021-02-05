# Extending menus

Back Office menus are based on the [KnpMenuBundle](https://github.com/KnpLabs/KnpMenuBundle) and are easily extensible.

!!! tip

    For general information on how to use `MenuBuilder`,
    see [the official KnpMenuBundle documentation](https://symfony.com/doc/master/bundles/KnpMenuBundle/index.html).

Menus are extensible using event subscribers/listeners. You can hook into the following events:

- `ConfigureMenuEvent::MAIN_MENU`
- `ConfigureMenuEvent::USER_MENU`
- `ConfigureMenuEvent::CONTENT_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::CONTENT_EDIT_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::CONTENT_CREATE_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::CONTENT_SIDEBAR_LEFT`
- `ConfigureMenuEvent::TRASH_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::SECTION_EDIT_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::SECTION_CREATE_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::POLICY_EDIT_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::POLICY_CREATE_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::ROLE_EDIT_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::ROLE_CREATE_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::USER_EDIT_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::USER_CREATE_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::ROLE_ASSIGNMENT_CREATE_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::LANGUAGE_CREATE_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::LANGUAGE_EDIT_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::CONTENT_TYPE_GROUP_CREATE_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::CONTENT_TYPE_GROUP_EDIT_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::CONTENT_TYPE_CREATE_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::CONTENT_TYPE_EDIT_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::URL_EDIT_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::USER_PASSWORD_CHANGE_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::OBJECT_STATE_GROUP_CREATE_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::OBJECT_STATE_GROUP_EDIT_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::OBJECT_STATE_CREATE_SIDEBAR_RIGHT`
- `ConfigureMenuEvent::OBJECT_STATE_EDIT_SIDEBAR_RIGHT`

An event subscriber can be implemented as follows:

``` php
<?php
namespace App\EventListener;

use EzSystems\EzPlatformAdminUi\Menu\Event\ConfigureMenuEvent;
use EzSystems\EzPlatformAdminUi\Menu\MainMenuBuilder;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MenuListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            ConfigureMenuEvent::MAIN_MENU => ['onMenuConfigure', 0],
        ];
    }

    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        $factory = $event->getFactory();
        // options passed from the context (i.e. Content item in Content View)
        $options = $event->getOptions();

        // your customizations
    }
}
```

If [the autoconfigure option](https://symfony.com/doc/5.0/service_container.html#the-autoconfigure-option) is disabled,
you need to register the service with the `kernel.event.subscriber` tag in `config/services.yaml`:

``` yaml
services:
    App\EventListener\MenuListener:
        tags:
           - { name: kernel.event.subscriber }

```

## Adding menu items

Add a new menu item under "Content" with custom attributes

``` php
$menu[MainMenuBuilder::ITEM_CONTENT]->addChild(
    'form_manager',
    [
        'route' => '_ezpublishLocation',
        'routeParameters' => ['locationId' => 2],
        // attributes directly on <a> element
        'linkAttributes' => [
            'class' => 'test_class another_class',
            'data-property' => 'value',
        ],
        // attributes on container <li> element
        'attributes' => [
            'data-property' => 'value',
        ],
    ]
);
```

Add a top-level menu item with a child:

``` php
$menu->addChild(
    'menu_item_1',
    ['label' => 'Menu Item 1', 'extras' => ['icon' => 'file']]
);
$menu['menu_item_1']->addChild(
    '2nd_level_menu_item',
    ['label' => '2nd level menu item', 'uri' => 'http://example.com']
);
```

Add an item depending on a condition:

``` php
$condition = true;
if ($condition) {
    $menu->addChild(
        'menu_item_2',
        ['label' => 'Menu Item 2', 'extras' => ['icon' => 'article']]
    );
}
```

Add a top-level menu item with URL redirection:

``` php
$menu->addChild(
    'menu_item_3',
    [
        'label' => 'Menu Item 3',
        'uri' => 'http://example.com',
        'extras' => ['icon' => 'article'],
    ]
);
```

## Modifying menu items

Reorder menu items, i.e. reverse the order:

``` php
$menu->reorderChildren(
    array_reverse(array_keys($menu->getChildren()))
);
```

## Removing menu items

To remove a menu item, for example, to remove the **eCommerce** item from the top menu,
use the following event Listener:

``` php
[[= include_file('code_samples/back_office/menu/remove_menu_item/src/EventListener/RemoveCommerceMenuListener.php') =]]
```

## Other menu operations

### Pass a parameter to a menu item

You can pass parameters to menu items with `template_parameters`:

``` php
$menu->addChild(
    'menu_item_with_params',
    [
        'extras' => [
            'template' => 'admin_ui/menu_item_template.html.twig',
            'template_parameters' => [
                'custom_parameter' => 'value',
            ],
        ],
    ]
);
```

You can then use the variable `custom_parameter` in `templates/admin_ui/menu_item_template.html.twig`.

### Translatable labels

To have translatable labels, use `translation.key` from the `messages` domain:

``` php
$menu->addChild(
    'menu_item_3',
    [
        'label' => 'translation.key',
        'uri' => 'http://example.com',
        'extras' => [
            'icon' => 'article',
            'translation_domain' => 'messages',
        ],
    ]
);
```

### Custom icons

You can use the `extras.icon` parameter to select an icon from the built-in set.

To use your custom icon, use the `extras.icon_path` parameter:

``` php
$menu->addChild(
    'menu_item_with_icon',
    [
        'extras' => [
            'icon_path' => '/assets/images/icons/custom.svg',
            'icon_class' => 'my-custom-class',
        ],
    ]
);
```

The `extras.icon_class` parameter adds a custom CSS class to the `<svg>` element.
