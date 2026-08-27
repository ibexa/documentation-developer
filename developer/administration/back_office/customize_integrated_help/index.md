# Customize integrated help

Customize the integrated help menu.

Editions: LTS Update

The integrated help menu is part of the Integrated help introduced as an [LTS Update](../../../ibexa_products/editions/index.md#lts-updates). By default, it provides editors and developers with convenient access to documentation, training and other resources directly from the back office.

You can extend or modify the integrated menu in the following ways:

- by disabling it for all users
- by modifying a link to user documentation
- by subscribing to the `ibexa_integrated_help.menu_configure.help_menu` event

## Disable integrated help functionalities

After you have installed the integrated help package, you can disable the entire feature or specific functionalities on the system level.

### Disable all functionalities

To disable both the Help center and the Product tour globally, for example, to run UI tests in a `dev` [environment](../../../infrastructure_and_maintenance/environments/index.md), in `config/packages`, create the `ibexa_integrated_help.yaml` file with the following configuration:

```yaml
ibexa_integrated_help:
    enabled: false
```

### Disable functionalities independently

To disable only the Help center or only the Product tour functionalities, use the dedicated flags as in the example below:

```yaml
ibexa_integrated_help:
    help_center:
        enabled: false # Disable only the Help center
    product_tour: 
        enabled: false # Disable only the Product tour
```

## Modify user documentation link

Ibexa DXP provides a comfortable method for replacing a link to user documentation, when you do not want to modify the rest of the integrated help menu. This way you can direct application users such as editors or store managers to specific guidelines in force at your organization, without having to resort to development.

To do it, in `config/packages` create the `ibexa_integrated_help.yaml` file, with the following configuration:

```yaml
ibexa_integrated_help:
    user_documentation: <https://custom.user.documentation.address>
```

## Intercept and modify event

Ibexa DXP uses [KnpMenuBundle](https://github.com/KnpLabs/KnpMenuBundle) to build its backend menus. When it builds the integrated help menu, it dispatches the `ibexa_integrated_help.menu_configure.help_menu` event to pass information about the contents of the help menu to the front end.

You can intercept this event, and change its contents by creating a subscriber. With that subscriber, you can access the `menu` object, which is an instance of the `Knp\Menu\MenuItem`, and all the options passed by this object, and modify them. This way you can adjust menu sections that are reproduced by the front end as tabs, add new items, or integrate custom links into the help system.

### Menu object structure

The default `menu` object is structured as follows. Recreate this pattern when modifying an existing event with an intention to send it to the front end.

```text
root (MenuItem)
│
├── help__general // ("General" section)
│   ├── help__user_documentation // (User docs, highlighted menu option)
│   │   (...)
│   └── help__submit_idea // (Submit idea, regular option)
│
└── help__developers // (conditional "Developers" section)
    ├── help__developer_documentation // (Developer docs, highlighted)
    │   (...)
    └── help__support_portal
```

`help_general` and `help_developers` are menu sections, or tabs. Sections consist of entries, and each entry carries the following information:

- `label` - a name of the help menu item
- `uri` - an external link to the resource
- `isHighlighted` - a Boolean switch that decides whether the menu item should be placed at the top of the tab
- `icon` - a link to a graphic file to accompany the menu item
- `description` - a summary of what users can expect after clicking the menu item

### Create a subscriber

Build a subscriber that intercepts the event and modifies it. In this example, it removes a product roadmap entry from the menu and adds a help menu tab with links to product videos. The tab is displayed in a production environment only.

```php
<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\AdminUi\Menu\Event\ConfigureMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class HelpMenuSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private bool $kernelDebug
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'ibexa_integrated_help.menu_configure.help_menu' => 'onHelpMenuConfigure',
        ];
    }

    public function onHelpMenuConfigure(ConfigureMenuEvent $event): void
    {
        $menu = $event->getMenu();

        // Remove roadmap menu item
        if ($menu->getChild('help__general')) {
            $generalSection = $menu->getChild('help__general');
            if ($generalSection->getChild('help__product_roadmap')) {
                $generalSection->removeChild('help__product_roadmap');
            }
        }

        // Add videos tab, shown only in production
        if ($this->kernelDebug === false) {
            $resourcesSection = $menu->addChild('help__videos', [
                'label' => 'Product videos',
            ]);

            $resourcesSection->addChild('help__webinar_v5', [
                'label' => 'Webinar: Introducing Ibexa DXP v5',
                'uri' => 'https://www.youtube.com/watch?v=qWaBHG2LRm8',
                'extras' => [
                    'isHighlighted' => false,
                    'icon' => 'https://doc.ibexa.co/en/5.0/templating/twig_function_reference/img/icons/video.svg.png',
                    'description' => 'Discover new features and improvements brought by Ibexa DXP v5.',
                ],
            ]);
        }
    }
}
```

> **Tip: Tip**
>
> If `autoconfigure` is enabled, the event subscriber is registered as a service by default. If not, register it as a service and tag with `kernel.event.subscriber`.
>
> ```yaml
> services:
>     App\EventSubscriber\HelpMenuSubscriber:
>         arguments:
>             $kernelDebug: '%kernel.debug%'
>         tags:
>             - { name: kernel.event_subscriber }
> ```

For more ideas on how you can extend the help menu, see [Back office menus](../back_office_menus/back_office_menus/index.md).
