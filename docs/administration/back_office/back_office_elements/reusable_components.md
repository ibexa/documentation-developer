---
description: Speed up creating Back Office templates with the help of ready-made reusable components.
---

# Reusable components

When you extend the Back Office, you can use base Twig templates for commonly used UI components such as tables or tabs.

The available templates are:

- `@ibexadesign/ui/component/table/alert.html.twig`
- `@ibexadesign/ui/component/table/table.html.twig`
- `@ibexadesign/ui/component/tab/tabs.html.twig`

To use the components, [`embed`](https://twig.symfony.com/doc/3.x/tags/embed.html) them in templates.
With `embed` you can override blocks that are defined inside the included template.

## Alerts

The alert component has the following properties:

- `type` - available types of alert: error, info, success and warning
- `icon` - name of the icon, taken from the default icon set
- `icon_path` - full icon path, in case you do not want to use an icon from the default icon set
- `title` - alert title
- `subtitle` - displays subtitle content
- `show_subtitle_below` - default set to `false`, the subtitle is displayed next to the title
- `extra_content` - use to add custom elements, such as buttons or additional text
- `show_close_btn` - by default set to `false`, if set to `true`, an 'X' button is displayed but requires additional JavaScript configuration on your side to work
- `is_toast` - default set to `false`, applies the toast design
- `class` - additional CSS classes
- `attributes` - additional HTML attributes

``` html+twig
{% include '@ibexadesign/ui/component/alert/alert.html.twig' with {
    type: 'info',
    title: 'Some title',
    subtitle: 'Some subtitle',
    show_subtitle_below: true,
    icon_path: ibexa_icon_path('hide'),
    class: 'mb-4',
} only %}
```

## Tables

The table component consists of the following blocks:

- `header` - headline for the table section
- `headline` - table name
- `actions` - action buttons, for example create, bulk delete
- `table` - the table itself
- `thead` - table header content
- `tbody` - table body content

The table component supports the following variable:

- `table_class` - additional CSS classes attached to the `<table>` tag

``` html+twig
{% embed '@ibexadesign/ui/component/table/table.html.twig' %}
    {% block headline %}
        Headline
    {% endblock %}

    {% block actions %}
        <a href="#" class="btn btn-icon">
            <svg class="ibexa-icon ibexa-icon--small ibexa-icon--create">
                <use xlink:href="{{ ez_icon_path('create') }}"></use>
            </svg>
        </a>
    {% endblock %}
    
    {% block thead %}
        <tr>
            <th></th>
            <th>Column A</th>
            <th>Column B</th>
            <th>Column C</th>
        </tr>
    {% endblock %}

    {% block tbody %}
        {% for i in 1..10 %}
            <tr>
                <td></td>
                <td>A{{ i }}</td>
                <td>B{{ i }}</td>
                <td>C{{ i }}</td>
            </tr>
        {% endfor %}
    {% endblock %}
{% endembed %}
```

!!! tip

    For an example of using the table component, see [Add menu item](add_menu_item.md).

## Tabs

The tab component consists of the following block:

- `tab_content` - tab content

The tab component supports the following variables:

- `tabs`
- `id` - tab ID
- `label` - human-readable label for the tab
- `active` - true if tab is active
- `content` - HTML content of tab if `tab_content` is not overridden
- `tab_content_class` - additional CSS classes attached to `.tab-content`
- `tab_content_attributes` - additional HTML attributes added to `.tab-content`

``` html+twig
{% embed '@ibexadesign/ui/component/tab/tabs.html.twig' with {
    tabs: [
        { id: 'first', label: 'First' },
        { id: 'second', label: 'Second' },
     ]
} %}
    {% block tab_content %}
        {% embed '@ibexadesign/ui/component/tab/tab_pane.html.twig' with { id: 'first', active: true } %}
            {% block content %}
                First
            {% endblock %}
        {% endembed %}

        {% embed '@ibexadesign/ui/component/tab/tab_pane.html.twig' with { id: 'second' } %}
            {% block content %}
                Second. <p>Some <b>Rich</b> HTML <a href="#">content</a></p>
            {% endblock %}
        {% endembed %}
    {% endblock %}
{% endembed %}
```

With tabs, you can use [`include`](https://twig.symfony.com/doc/3.x/tags/include.html) instead of `embed`
when you pass tab content as a variable while rendering the template:

``` html+twig
{% include '@ibexadesign/ui/component/tab/tabs.html.twig' with {
        tabs: [
          { id: 'first', label: 'First', content: 'First tab content' },
          { id: 'second', label: 'Second', content: 'Second tab content', active: true },
        ]
} %}
```
