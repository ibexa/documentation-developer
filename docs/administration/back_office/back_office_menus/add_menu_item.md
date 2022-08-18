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

``` php hl_lines="14 22-23 31-32"
[[= include_file('code_samples/back_office/menu/menu_item/src/EventSubscriber/MyMenuSubscriber.php', 0, 43) =]]
    }
}
```

This subscriber subscribes to the `ConfigureMenuEvent::MAIN_MENU` event (see line 14).
It creates a subitem with the identifier `main__content__custom_menu` (lines 22-23).
Then, under this subitem, it creates an `all_content_list` menu item (lines 31-32).

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

Finally, create the `templates/list/all_content_list.html.twig` file indicated in line 37 in the controller:

``` html+twig hl_lines="35-42 46 48-54 56"
[[= include_file('code_samples/back_office/menu/menu_item/templates/list/all_content_list.html.twig') =]]
```

This template uses the [reusable table template](reusable_components.md#tables)
to render a table that fits the style of the Back Office.

You can configure the columns of the table in the `head_cols` variable
and the regular table rows in `body_rows`.
In this case, `body_rows` contains information about the Content item provided by the controller,
and an edit button.
