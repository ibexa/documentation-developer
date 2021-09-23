# Reusable components

When you extend the Back Office, you can use base Twig templates for commonly used UI components such as alerts, tables or tabs.

The available templates are:

- `@ezdesign/ui/component/alert/alert.html.twig`
- `@ezdesign/ui/component/table/table.html.twig`
- `@ezdesign/ui/component/tab/tabs.html.twig`

To use the components, [`embed`](https://twig.symfony.com/doc/3.x/tags/embed.html) them in templates.
With `embed` you can override blocks that are defined inside the included template.

## Alerts

The alert component consists of the following elements:

- `type` - available types of alert: error, info, success and warning
- `icon_path` - overrides the path to the default icons set, can be modified
- `title` - alert title
- `subtitle` - displays subtitle content
- `show_subtitle_below` - default set to false, the subtitle is displayed next to the title
- `extra_content` - use to add custom elements, such as buttons or additional text
- `close_btn` - by default set to false, if set to true, an 'X' button is displayed but requires additional JavaScript configuration to work
- `class` - additional CSS classes
- `attributes` - additional HTML attributes

``` html+twig
{% include '@ezdesign/ui/component/alert/alert.html.twig' with {
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
{% embed '@ezdesign/ui/component/table/table.html.twig' %}
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
{% embed '@ezdesign/ui/component/tab/tabs.html.twig' with {
    tabs: [
        { id: 'first', label: 'First' },
        { id: 'second', label: 'Second' },
     ]
} %}
    {% block tab_content %}
        {% embed '@ezdesign/ui/component/tab/tab_pane.html.twig' with { id: 'first', active: true } %}
            {% block content %}
                First
            {% endblock %}
        {% endembed %}

        {% embed '@ezdesign/ui/component/tab/tab_pane.html.twig' with { id: 'second' } %}
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
{% include '@ezdesign/ui/component/tab/tabs.html.twig' with {
        tabs: [
          { id: 'first', label: 'First', content: 'First tab content' },
          { id: 'second', label: 'Second', content: 'Second tab content', active: true },
        ]
} %}
```
