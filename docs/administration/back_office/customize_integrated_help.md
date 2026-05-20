---
description: Customize the integrated help menu.
edition: lts-update
month_change: false
---

# Customize integrated help

The integrated help menu is part of the Integrated help introduced as an [LTS Update](editions.md#lts-updates).
By default, it provides editors and developers with convenient access to documentation, training and other resources directly from the back office.

You can extend or modify the integrated menu in the following ways:

- by disabling it for all users
- by modifying a link to user documentation
- by subscribing to the `ibexa_integrated_help.menu_configure.help_menu` event

## Disable integrated help functionalities

After you have installed the integrated help package, you can disable the entire feature or specific functionalities on the system level.

### Disable all functionalities

To disable both the Help center and the Product tour globally, for example, to run UI tests in a `dev` [environment](environments.md), in `config/packages`, create the `ibexa_integrated_help.yaml` file with the following configuration:

``` yaml
ibexa_integrated_help:
    enabled: false
```

### Disable functionalities independently

To disable only the Help center or only the Product tour functionalities, use the dedicated flags as in the example below:

``` yaml
ibexa_integrated_help:
    help_center:
        enabled: false # Disable only the Help center
    product_tour: 
        enabled: false # Disable only the Product tour
```

## Modify user documentation link

[[= product_name =]] provides a comfortable method for replacing a link to user documentation, when you do not want to modify the rest of the integrated help menu.
This way you can direct application users such as editors or store managers to specific guidelines in force at your organization, without having to resort to development.

To do it, in `config/packages` create the `ibexa_integrated_help.yaml` file, with the following configuration:

``` yaml
ibexa_integrated_help:
    user_documentation: <https://custom.user.documentation.address>
```

## Intercept and modify event

[[= product_name =]] uses [KnpMenuBundle](https://github.com/KnpLabs/KnpMenuBundle) to build its backend menus.
When it builds the integrated help menu, it dispatches the `ibexa_integrated_help.menu_configure.help_menu` event to pass information about the contents of the help menu to the front end.

You can intercept this event, and change its contents by creating a subscriber.
With that subscriber, you can access the `menu` object, which is an instance of the `Knp\Menu\MenuItem`, and all the options passed by this object, and modify them.
This way you can adjust menu sections that are reproduced by the front end as tabs, add new items, or integrate custom links into the help system.

### Menu object structure

The default `menu` object is structured as follows.
Recreate this pattern when modifying an existing event with an intention to send it to the front end.

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

`help_general` and `help_developers` are menu sections, or tabs.
Sections consist of entries, and each entry carries the following information:

- `label` - a name of the help menu item
- `uri` - an external link to the resource
- `isHighlighted` - a Boolean switch that decides whether the menu item should be placed at the top of the tab
- `icon` - a link to a graphic file to accompany the menu item
- `description` - a summary of what users can expect after clicking the menu item

### Create a subscriber

Build a subscriber that intercepts the event and modifies it.
In this example, it removes a product roadmap entry from the menu and adds a help menu tab with links to product videos.
The tab is displayed in a production environment only.

``` php
[[= include_code('code_samples/back_office/menu/menu_item/src/EventSubscriber/HelpMenuSubscriber.php') =]]
```

!!! tip

    If `autoconfigure` is enabled, the event subscriber is registered as a service by default.
    If not, register it as a service and tag with `kernel.event.subscriber`.

    ```yaml
    services:
        App\EventSubscriber\HelpMenuSubscriber:
            arguments:
                $kernelDebug: '%kernel.debug%'
            tags:
                - { name: kernel.event_subscriber }
    ```

For more ideas on how you can extend the help menu, see [Back office menus](back_office_menus.md).
