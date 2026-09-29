# Back office menus

All menus in the back office are based on KnpMenuBundle and you can easily extend them with new items.

Back office menus are based on the [KnpMenuBundle](https://github.com/KnpLabs/KnpMenuBundle) and they're extensible.

> **Tip: Tip**
>
> For general information on how to use `MenuBuilder`, see [the official KnpMenuBundle documentation](https://symfony.com/bundles/KnpMenuBundle/current/index.html).

Menus are extensible using event subscribers, for example:

```php
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

    }
}
```

> **Tip: Tip**
>
> The event subscriber is registered as a service by default, if `autoconfigure` is enabled. If not, register it as a service and tag with `kernel.event.subscriber`.

## Menu events

You can listen to the following events:

|                          |                                                               |
| ------------------------ | ------------------------------------------------------------- |
| Main menu                | `ConfigureMenuEvent::MAIN_MENU`                               |
|                          | `ConfigureMenuEvent::USER_MENU`                               |
| Content view             | `ConfigureMenuEvent::CONTENT_SIDEBAR_RIGHT`                   |
|                          | `ConfigureMenuEvent::CONTENT_EDIT_SIDEBAR_RIGHT`              |
|                          | `ConfigureMenuEvent::CONTENT_CREATE_SIDEBAR_RIGHT`            |
|                          | `ConfigureMenuEvent::CONTENT_SIDEBAR_LEFT`                    |
| Trash                    | `ConfigureMenuEvent::TRASH_SIDEBAR_RIGHT`                     |
| Section                  | `ConfigureMenuEvent::SECTION_EDIT_SIDEBAR_RIGHT`              |
|                          | `ConfigureMenuEvent::SECTION_CREATE_SIDEBAR_RIGHT`            |
| Policies and permissions | `ConfigureMenuEvent::POLICY_EDIT_SIDEBAR_RIGHT`               |
|                          | `ConfigureMenuEvent::POLICY_CREATE_SIDEBAR_RIGHT`             |
|                          | `ConfigureMenuEvent::ROLE_EDIT_SIDEBAR_RIGHT`                 |
|                          | `ConfigureMenuEvent::ROLE_CREATE_SIDEBAR_RIGHT`               |
|                          | `ConfigureMenuEvent::ROLE_COPY_SIDEBAR_RIGHT`                 |
|                          | `ConfigureMenuEvent::USER_EDIT_SIDEBAR_RIGHT`                 |
|                          | `ConfigureMenuEvent::USER_CREATE_SIDEBAR_RIGHT`               |
|                          | `ConfigureMenuEvent::ROLE_ASSIGNMENT_CREATE_SIDEBAR_RIGHT`    |
| Languages                | `ConfigureMenuEvent::LANGUAGE_CREATE_SIDEBAR_RIGHT`           |
|                          | `ConfigureMenuEvent::LANGUAGE_EDIT_SIDEBAR_RIGHT`             |
| Object states            | `ConfigureMenuEvent::OBJECT_STATE_GROUP_CREATE_SIDEBAR_RIGHT` |
|                          | `ConfigureMenuEvent::OBJECT_STATE_GROUP_EDIT_SIDEBAR_RIGHT`   |
|                          | `ConfigureMenuEvent::OBJECT_STATE_CREATE_SIDEBAR_RIGHT`       |
|                          | `ConfigureMenuEvent::OBJECT_STATE_EDIT_SIDEBAR_RIGHT`         |
| Content types            | `ConfigureMenuEvent::CONTENT_TYPE_GROUP_CREATE_SIDEBAR_RIGHT` |
|                          | `ConfigureMenuEvent::CONTENT_TYPE_GROUP_EDIT_SIDEBAR_RIGHT`   |
|                          | `ConfigureMenuEvent::CONTENT_TYPE_CREATE_SIDEBAR_RIGHT`       |
|                          | `ConfigureMenuEvent::CONTENT_TYPE_EDIT_SIDEBAR_RIGHT`         |
|                          | `ConfigureMenuEvent::CONTENT_TYPE_SIDEBAR_RIGHT`              |
| URLs and wildcards       | `ConfigureMenuEvent::URL_EDIT_SIDEBAR_RIGHT`                  |
|                          | `ConfigureMenuEvent::URL_WILDCARD_EDIT_SIDEBAR_RIGHT`         |
| User settings            | `ConfigureMenuEvent::USER_PASSWORD_CHANGE_SIDEBAR_RIGHT`      |
|                          | `ConfigureMenuEvent::USER_SETTING_UPDATE_SIDEBAR_RIGHT`       |

## Adding menu items

To add a menu item, use the `addChild()` method. Provide the method with the new menu item's identifier and, optionally, with parameters.

To add an inactive menu section, don't add a route to its parameters.

The following method adds a new menu section under **Content**, and under it, a new item with custom attributes:

```php
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
```

`label` is used for the new menu item in the interface. `route` is the name of the route that the menu item leads to.

`attributes` adds attributes (such as CSS classes) to the container `<li>` element of the new menu item. `linkAttributes` adds attributes to the `<a>` element.

### Passing a parameter to a menu item

You can also pass parameters to templates used to render menu items with `template_parameters`:

```php
/** @var \Knp\Menu\ItemInterface $menu */
$menu->addChild(
    'all_content_list',
    [
        'extras' => [
            'template' => '@ibexadesign/list/all_content_list.html.twig',
            'template_parameters' => [
                'custom_parameter' => 'value',
            ],
        ],
    ]
);
```

You can then use the variable `custom_parameter` in `templates/themes/admin/list/all_content_list.html.twig`.

### Translatable labels

To have translatable labels, use `translation.key` from the `messages` domain:

```php
/** @var \Knp\Menu\ItemInterface $menu */
$menu->addChild(
    'all_content_list',
    [
        'label' => 'translation.key',
        'extras' => [
            'translation_domain' => 'messages',
        ],
    ]
);
```

## Modifying menu items

To modify the parameters of an existing menu item, use the `setExtra()` method.

### Custom icons

You can use the `extras.icon` parameter to define an icon for a menu item. For example, the following code changes the default icon for the **Create content** button in content view:

```php
$menu->getChild('main__admin')
    ->setExtra('icon_path', '/bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#alert-error');
```

## Removing menu items

To remove a menu item, for example, to remove the **Copy subtree** item from the right menu in content view, use the following event listener:

```php
$menu->removeChild('main__bookmarks');
```
