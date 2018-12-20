# Extending eZ Platform UI

## Back-end interface

The back-end interface is produced by [the ezplatform-admin-ui Bundle](https://github.com/ezsystems/ezplatform-admin-ui)
together with [ezplatform-admin-ui-modules](https://github.com/ezsystems/ezplatform-admin-ui-modules),
which contains React modules that handle specific parts of the application.
This interface is accessible in your browser at `http://[uri_of_platform]/admin`.

## General extensibility

eZ Platform's back-end interface uses React-based modules that make each part of the UI easily extensible.
The interface uses Bootstrap, which facilitates adapting and styling the interface to your needs.

Available extensibility points:

- [Menus](#menus)
- [Dashboard](#dashboard)
- [Tabs](#tabs)
- [Further extensibility using Components](#further-extensibility-using-components)
- [Universal Discovery module](extending_modules.md#universal-discovery-module)
- [Sub-items list](extending_modules.md#sub-items-list)
- [Online Editor](extending_online_editor.md)
- [Multi-file upload](extending_modules.md#multi-file-upload)

## Menus

Menus in eZ Platform are based on the [KnpMenuBundle](https://github.com/KnpLabs/KnpMenuBundle) and are easily extensible.
For a general idea on how to use MenuBuilder, refer to [the official documentation](https://symfony.com/doc/master/bundles/KnpMenuBundle/index.html).

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
namespace EzSystems\EzPlatformAdminUi\EventListener;

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
        $options = $event->getOptions(); // options passed from the context (i.e. Content item in Content View)

        // your customizations
    }
}
```

### Extending menu examples

#### Add a new menu item under "Content" with custom attributes

``` php
$menu[MainMenuBuilder::ITEM_CONTENT]->addChild(
    'form_manager',
    [
        'route' => '_ezpublishLocation',
        'routeParameters' => ['locationId' => 2],
        'linkAttributes' => [ // attributes directly on <a> element
            'class' => 'test_class another_class',
            'data-property' => 'value',
        ],
        'attributes' => [ // attributes on container <li> element
            'data-property' => 'value',
        ],
    ]
);
```

#### Remove the "Media" menu item from the Content tab

``` php
$menu[MainMenuBuilder::ITEM_CONTENT]->removeChild(
    MainMenuBuilder::ITEM_CONTENT__MEDIA
);
```

#### Add a top-level menu item with a child

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

#### Add an item depending on a condition

``` php
$condition = true;
if ($condition) {
    $menu->addChild(
        'menu_item_2',
        ['label' => 'Menu Item 2', 'extras' => ['icon' => 'article']]
    );
}
```

#### Add a top-level menu item with URL redirection

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

#### Pass a parameter to a menu item

You can pass parameters to menu items with `template_parameters`:

``` php
$menu->addChild(
    'menu_item_with_params',
    [
        'extras' => [
            'template' => 'AppBundle::menu_item_template.html.twig',
            'template_parameters' => [
                'custom_parameter' => 'value',
            ],
        ],
    ]
);
```

You can then use the variable `custom_parameter` in `AppBundle::menu_item_template.html.twig`.

#### Translatable labels

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

#### Reorder menu items, i.e. reverse the order

``` php
$menu->reorderChildren(
    array_reverse(array_keys($menu->getChildren()))
);
```

#### Custom icons

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

## Dashboard

To extend the Dashboard, make use of an event subscriber.

In the following example, the `DasboardEventSubscriber.php` reverses the order of sections of the Dashboard
(in a default installation this makes the "Everyone" block appear above the "Me" block):

``` php
namespace AppBundle\EventListener;

use EzSystems\EzPlatformAdminUi\Component\Event\RenderGroupEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DashboardEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            RenderGroupEvent::NAME => ['onRenderGroupEvent', 20],
        ];
    }

    public function onRenderGroupEvent(RenderGroupEvent $event)
    {
        if ($event->getGroupName() !== 'dashboard-blocks') {
            return;
        }

        $components = $event->getComponents();

        $reverseOrder = array_reverse($components);

        $event->setComponents($reverseOrder);

    }
}
```

## Tabs

Many elements of the back-office interface, such as System Info or Location View, are built using tabs.

![Tabs in System Information](img/tabs_system_info.png)

You can extend existing tab groups with new tabs, or create your own tab groups.

### Adding a new tab group

To create a custom tab group with additional logic you need to create it at the level of compiling the Symfony container, using a [CompilerPass](https://symfony.com/doc/3.4/service_container/compiler_passes.html):

``` php
// src/AppBundle/DependencyInjection/Compiler/CustomTabGroupPass.php

namespace AppBundle\DependencyInjection\Compiler;

use EzSystems\EzPlatformAdminUi\Tab\TabGroup;
use EzSystems\EzPlatformAdminUi\Tab\TabRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class CustomTabGroupPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition(TabRegistry::class)) {
            return;
        }

        $tabRegistry = $container->getDefinition(TabRegistry::class);
        $tabGroupDefinition = new Definition(
            TabGroup::class,  // or any class that extends TabGroup
            ['custom-tab-group']
        );
        $tabRegistry->addMethodCall('addTabGroup', [$tabGroupDefinition]);
    }
}
```

A shorter way that you can use when no custom logic is required, is to add your own tab with the new group.
If a tab's group is not defined, it will be created automatically.

A new tab group can be rendered using the [`ez_platform_tabs`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Templating/Twig/TabExtension.php#L58) Twig helper:

``` html+twig
<div class="my-tabs">
    {{ ez_platform_tabs('custom-tab-group') }}
</div>
```

This will render the group and all tabs assigned to it.

### Adding a new tab

Before you add a tab to a group you must create the tab's PHP class and define it as a Symfony service with the `ezplatform.tab` tag:

``` yaml
# services.yml

AppBundle\Custom\Tab:
    parent: EzSystems\EzPlatformAdminUi\Tab\AbstractTab
    tags:
        - { name: ezplatform.tab, group: 'custom-tab-group' }
```

This configuration also assigns the new tab to `custom-tab-group`.

!!! tip

    If the `custom-tab-group` does not yet exist, it will be created automatically at this point.

The tab class can look like this:

``` php
// src/AppBundle/Custom/Tab.php

namespace AppBundle\Custom;

use EzSystems\EzPlatformAdminUi\Tab\AbstractTab;

class Tab extends AbstractTab
{
    public function getIdentifier(): string
    {
        return 'custom-tab';
    }

    public function getName(): string
    {
        return /** @Desc("Custom Tab") */
            $this->translator->trans('custom.tab.name', [], 'some_translation_domain');
    }

    public function renderView(array $parameters): string
    {
        // Do rendering here

        return $this->twig->render('AppBundle:my_tabs/custom.html.twig', [
            'foo' => 'Bar!',
        ]);
    }
}
```

Beyond the `AbstractTab` used in the example above you can use two specializes tab types:

- `AbstractControllerBasedTab` enables you to embed the results of a controller action in the tab.
- `AbstractRouteBasedTab` embeds the results of the selected routing, passing applicable parameters.

### Modifying tab display

You can order the tabs by making the tab implement `OrderedTabInterface`.
The order will then depend on the numerical value returned by the `getOrder` method.

``` php
class Tab extends AbstractTab implements OrderedTabInterface
{
    public function getOrder(): int
    {
        return 100;
    }
}
```

The tabs will be displayed according to this value in ascending order.

!!! tip

    It is good practice to reserve some distance between these values, for example to stagger them by step of 10.
    It may come useful if you later need to place something between the existing tabs.

You can also influence tab display (e.g. order tabs, remove or modify them, etc.) by using Event Listeners:

``` php
class TabEvents
{
    /**
     * Happens just before rendering a tab group.
     */
    const TAB_GROUP_PRE_RENDER = 'ezplatform.tab.group.pre_render';

    /**
     * Happens just before rendering a tab.
     */
    const TAB_PRE_RENDER = 'ezplatform.tab.pre_render';
}
```

As an example, see how `OrderedTabInterface` is implemented:

```php
namespace EzSystems\EzPlatformAdminUi\Tab\Event\Subscriber;

use EzSystems\EzPlatformAdminUi\Tab\Event\TabEvents;
use EzSystems\EzPlatformAdminUi\Tab\Event\TabGroupEvent;
use EzSystems\EzPlatformAdminUi\Tab\OrderedTabInterface;
use EzSystems\EzPlatformAdminUi\Tab\TabInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Reorders tabs according to their Order value (Tabs implementing OrderedTabInterface).
 * Tabs without order specified are pushed to the end of the group.
 *
 * @see OrderedTabInterface
 */
class OrderedTabSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            TabEvents::TAB_GROUP_PRE_RENDER => ['onTabGroupPreRender'],
        ];
    }

    /**
     * @param TabGroupEvent $tabGroupEvent
     */
    public function onTabGroupPreRender(TabGroupEvent $tabGroupEvent)
    {
        $tabGroup = $tabGroupEvent->getData();
        $tabs = $tabGroup->getTabs();

        $tabs = $this->reorderTabs($tabs);

        $tabGroup->setTabs($tabs);
        $tabGroupEvent->setData($tabGroup);
    }

    /**
     * @param TabInterface[] $tabs
     *
     * @return array
     */
    private function reorderTabs($tabs): array
    {
        $orderedTabs = [];
        foreach ($tabs as $tab) {
            if ($tab instanceof OrderedTabInterface) {
                $orderedTabs[$tab->getIdentifier()] = $tab;
                unset($tabs[$tab->getIdentifier()]);
            }
        }

        uasort($orderedTabs, [$this, 'sortTabs']);

        return array_merge($orderedTabs, $tabs);
    }

    /**
     * @param OrderedTabInterface $tab1
     * @param OrderedTabInterface $tab2
     *
     * @return int
     */
    private function sortTabs(OrderedTabInterface $tab1, OrderedTabInterface $tab2): int
    {
        return $tab1->getOrder() <=> $tab2->getOrder();
    }
}
```

## Further extensibility using Components

Components enable you to inject widgets (e.g. Dashboard blocks) and HTML code (e.g. a tag for loading JS or CSS files) into specific places in the Back Office.

A component is any class that implements the `Renderable` interface.
It must be tagged as a service:

``` yaml
AppBundle\Component\MyNewComponent:
    tags:
        - { name: ezplatform.admin_ui.component, group: 'content-edit-form-before' }
```

`group` indicates where the widget will be displayed. The available groups are:

- [`stylesheet-head`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/layout.html.twig#L46)
- [`script-head`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/layout.html.twig#L47)
- [`stylesheet-body`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/layout.html.twig#L121)
- [`script-body`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/layout.html.twig#L122)
- [`content-edit-form-before`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/content/content_edit/content_edit.html.twig#L71)
- [`content-edit-form-after`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/content/content_edit/content_edit.html.twig#L81)
- [`content-create-form-before`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/content/content_edit/content_create.html.twig#L52)
- [`content-create-form-after`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/content/content_edit/content_create.html.twig#L59)
- [`dashboard-blocks`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/bundle/Resources/views/dashboard/dashboard.html.twig#L28)

If you do not want to write your own class and only wish to inject a short element
(e.g. render a Twig template or add a CSS link), you can make use of pre-existing base classes.
In this case all you have to do is add a service definition (with proper parameters), for example:

``` yaml
appbundle.components.my_twig_component:
    parent: EzSystems\EzPlatformAdminUi\Component\TwigComponent
    arguments:
        $template: 'path/to/file.html.twig'
        $parameters:
            first_param: 'first_value'
            second_param: 'second_value'
    tags:
        - { name: ezplatform.admin_ui.component, group: 'dashboard-blocks' }
```

This renders the `path/to/file.html.twig` template with `first_param` and `second_param` as parameters.

There are three such base components:

- `TwigComponent` renders a Twig template, like above
- `LinkComponent` renders the HTML `<link>` tag:

``` yaml
appbundle.components.my_link_component:
   parent: EzSystems\EzPlatformAdminUi\Component\LinkComponent
   arguments:
       $href: 'http://address.of/file.css'
   tags:
       - { name: ezplatform.admin_ui.component, group: 'stylesheet-head' }
```

- `ScriptComponent` renders the HTML `<script>` tag:

``` yaml
appbundle.components.my_script_component:
   parent: EzSystems\EzPlatformAdminUi\Component\ScriptComponent
   arguments:
       $src: 'http://address.of/file.js'
   tags:
       - { name: ezplatform.admin_ui.component, group: 'script-body' }
```
