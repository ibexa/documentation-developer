---
description: Create a custom menu in the Back Office.
---

# Add menu item

To add a new menu entry in the Back Office, you need to use an event subscriber
and subscribe to [one of the events](back_office_menus.md#menu-events) dispatched when building menus.

The following example shows how to add a "Content list" item to the main top menu
and list all Content items there, with a shortcut button to edit them.

## Create event subscriber

First, create an event subscriber in `src/EventSubscriber/MyMenuSubscriber.php`:

``` php hl_lines="14 22-23"
[[= include_file('code_samples/back_office/menu/menu_item/src/EventSubscriber/MyMenuSubscriber.php', 0, 14) =]][[= include_file('code_samples/back_office/menu/menu_item/src/EventSubscriber/MyMenuSubscriber.php', 15, 36) =]]
}
```

This subscriber subscribes to the `ConfigureMenuEvent::MAIN_MENU` event (see line 14)
and creates an `all_content_list` menu item (lines 22-23).

## Add route

Next, configure the route that the menu item leads to:

``` yaml
[[= include_file('code_samples/back_office/menu/menu_item/config/custom_routes.yaml') =]]
```

## Create controller

The route indicates a controller that fetches all visible Content items and renders the view.

Create the following controller file in `src/Controller/AllContentListController.php`:

``` php hl_lines="56"
[[= include_file('code_samples/back_office/menu/menu_item/src/Controller/AllContentListController.php') =]]
```

## Add template

Finally, create the `templates/list/all_content_list.html.twig` file indicated in line 56 in the controller:

``` html+twig
[[= include_file('code_samples/back_office/menu/menu_item/templates/list/all_content_list.html.twig') =]]
```
