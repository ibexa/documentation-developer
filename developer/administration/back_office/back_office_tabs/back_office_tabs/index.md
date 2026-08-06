# Back office tabs

Tabs are used for content view, in dashboard, system information and other parts of the back office and are extensible.

Many elements of the back office interface, such as content view, dashboard, or system information, are built with tabs.

![Tabs in System Information](https://doc.ibexa.co/en/5.0/administration/img/tabs_system_info.png)

You can extend existing tab groups with new tabs, or create your own tab groups.

## Tabs

A custom tab can extend one of the following classes:

- [`Ibexa\Contracts\AdminUi\Tab\AbstractTab`](../../../../../../../ibexa/admin-ui/src/contracts/Tab/AbstractTab.php) - base tab
- [`Ibexa\Contracts\AdminUi\Tab\AbstractControllerBasedTab`](../../../../../../../ibexa/admin-ui/src/contracts/Tab/AbstractControllerBasedTab.php) - embeds the results of a controller action in the tab
- [`Ibexa\Contracts\AdminUi\Tab\AbstractRouteBasedTab`](../../../../../../../ibexa/admin-ui/src/contracts/Tab/AbstractRouteBasedTab.php) - embeds the results of the selected route, passing applicable parameters

```php
//...
class EveryoneArticleTab extends AbstractTab implements OrderedTabInterface
{

    //...
    public function getIdentifier(): string
    {
        return 'everyone-article';
    }

    public function renderView(array $parameters): string
    {

        //...
        return $this->twig->render('@ibexadesign/ui/dashboard/tab/all_content.html.twig', [
            'data' => $this->pagerLocationToDataMapper->map($pager, true),
        ]);
    }
}
```

> **Tip: Tip**
>
> For a full example of creating a custom tab, see [Add dashboard tab](../create_dashboard_tab/index.md).

You need to register the tab as a service. Tag it with `ibexa.admin_ui.tab` and indicate the group in which it should appear:

```yaml
services:
    App\Tab\Dashboard\Everyone\EveryoneArticleTab:
        autowire: true
        autoconfigure: true
        public: false
        tags:
            - { name: ibexa.admin_ui.tab, group: dashboard-everyone }
```

The group can be one of the existing components, or your own [custom tab group](#tab-groups).

### Tab order

You can order the tabs by making the tab implement `OrderedTabInterface`. The order depends on the numerical value returned by the `getOrder` method:

```php
public function getOrder(): int
{
    return 300;
}
```

Tabs are displayed according to this value in ascending order.

> **Tip: Tip**
>
> It's a good practice to reserve some distance between these values, for example to stagger them by step of 10. It may come useful if you later need to place something between the existing tabs.

You can also influence tab display (for example, order tabs, remove, or modify them) by using the following event listeners:

- `TabEvents::TAB_GROUP_PRE_RENDER`
- `TabEvents::TAB_PRE_RENDER`

## Tab groups

You can create new tab groups by using the [`TabsComponent`](https://github.com/ibexa/admin-ui/blob/5.0/src/lib/Component/TabsComponent.php).

To create a tab group, register it as a service:

```yaml
services:
    app.my_tabs.custom_group:
        parent: Ibexa\AdminUi\Component\TabsComponent
        arguments:
            $groupIdentifier: 'custom_group'
        tags:
            - { name: ibexa.twig.component, group: 'admin-ui-dashboard-blocks' }
```

Tag the group with `ibexa.twig.component`. `group` indicates where the group is rendered.

To learn more about this mechanism, see [Twig Components](../../../../templating/components/index.md). And for the groups available in the back office, see [custom components in the back office](../../back_office_elements/custom_components/index.md).
