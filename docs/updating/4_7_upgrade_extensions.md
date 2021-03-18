# 4.7. Upgrade extended code

## Universal Discovery Widget

If you extended the Universal Discovery Widget
(e.g. added your own tabs or triggered opening the UDW for your own customizations),
you need to rewrite this extension using the [new YAML configuration](../extending/extending_udw.md).

## Back Office extensibility

If you added custom tab groups in the Back Office,
you now need to [make use of the `TabsComponent`](../extending/extending_tabs.md#adding-a-new-tab-group).
