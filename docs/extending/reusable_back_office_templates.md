# Reusable Back Office templates

When extending the Back Office, you can use base Twig templates for commonly used UI components such as tabs or tables.

The available templates are:

- `@ezdesign/ui/component/table/table.html.twig`
- `@ezdesign/ui/component/tab/tabs.html.twig`

## Table

Table contains the following blocks:

- `header` - headline for the table section
- `headline` - table name
- `actions` - action buttons, for example create, bulk delete
- `table` - the table itself
- `thead` - table header content
- `tbody` - table body content

The table component supports the following variables:

- `table_class` - additional CSS classes attached to the `<table>` tag

## Tabs

Tabs contain the following blocks:

- `tab_content` - tab content

The tabs component supports the following variables:

- `tabs`
- `id` - tab ID
- `label` - human-readable label for the tab
- `active` - true if tab is active
- `content` - HTML content of tab if `tab_content` is not overridden, 
- `tab_content_class` - additional CSS classes attached to `.tab-content`
- `tab_content_attributes` - additional HTML attributes added to `.tab-content`

To use the components, either `embed` or `include` them in templates, for example:

``` html+twig
{% embed '@ezdesign/ui/component/table/table.html.twig' %}
```

Use `include` instead of `embed` when you pass tab content as variable while rendering the template:

``` html+twig
{% include '@ezdesign/ui/component/tab/tabs.html.twig' with {
        tabs: [
          { id: 'first', label: 'First', content: 'First tab content' },
          { id: 'second', label: 'Second', content: 'Second tab content', active: true },
        ]
    } %}
```