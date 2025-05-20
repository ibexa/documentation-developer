---
description: Tabs are used for content view, in dashboard, system information and other parts of the back office and are extensible.
---

# Back office tabs

Many elements of the back office interface, such as content view, dashboard, or system information, are built with tabs.

![Tabs in System Information](tabs_system_info.png)

You can extend existing tab groups with new tabs, or create your own tab groups.

## Tabs

A custom tab can extend one of the following classes:

- `Ibexa\Contracts\AdminUi\Tab\AbstractTab` - base tab.
- `Ibexa\Contracts\AdminUi\Tab\AbstractControllerBasedTab` - embeds the results of a controller action in the tab.
- `Ibexa\Contracts\AdminUi\Tab\AbstractRouteBasedTab` - embeds the results of the selected route, passing applicable parameters.

``` php
//...
[[= include_file('code_samples/back_office/dashboard/article_tab/src/Tab/Dashboard/Everyone/EveryoneArticleTab.php', 16, 17) =]]
    //...
[[= include_file('code_samples/back_office/dashboard/article_tab/src/Tab/Dashboard/Everyone/EveryoneArticleTab.php', 34, 43) =]][[= include_file('code_samples/back_office/dashboard/article_tab/src/Tab/Dashboard/Everyone/EveryoneArticleTab.php', 49, 51) =]]
        //...
[[= include_file('code_samples/back_office/dashboard/article_tab/src/Tab/Dashboard/Everyone/EveryoneArticleTab.php', 70, 73) =]]
```

!!! tip

    For a full example of creating a custom tab, see [Add dashboard tab](create_dashboard_tab.md).

You need to register the tab as a service.
Tag it with `ibexa.admin_ui.tab` and indicate the group in which it should appear:

``` yaml
[[= include_file('code_samples/back_office/dashboard/article_tab/config/custom_services.yaml', 0, 7) =]]
```

The group can be one of the existing components, or your own [custom tab group](#tab-groups).

### Tab order

You can order the tabs by making the tab implement `OrderedTabInterface`.
The order depends on the numerical value returned by the `getOrder` method:

``` php
[[= include_file('code_samples/back_office/dashboard/article_tab/src/Tab/Dashboard/Everyone/EveryoneArticleTab.php', 44, 48) =]]
```

Tabs are displayed according to this value in ascending order.

!!! tip

    It's a good practice to reserve some distance between these values, for example to stagger them by step of 10.
    It may come useful if you later need to place something between the existing tabs.

You can also influence tab display (for example, order tabs, remove, or modify them) by using the following event listeners:

- `TabEvents::TAB_GROUP_PRE_RENDER`
- `TabEvents::TAB_PRE_RENDER`

## Tab groups

You can create new tab groups by using the [`TabsComponent`](https://github.com/ibexa/admin-ui/blob/4.6/src/lib/Component/TabsComponent.php).

To create a tab group, register it as a service:

``` yaml
[[= include_file('code_samples/back_office/dashboard/article_tab/config/custom_services.yaml', 0, 1) =]][[= include_file('code_samples/back_office/dashboard/article_tab/config/custom_services.yaml', 7, 13) =]]
```

Tag the group with `ibexa.admin_ui.component`.
`group` indicates where the group is rendered.

For a list of possible rendering places, see [Injecting custom components](custom_components.md).
