# Reusable Back Office templates

When extending the Back Office, you can use base Twig templates for commonly used UI components such as tabs or tables.

The available templates are:

- `@ezdesign/ui/component/table/table.html.twig`
- `@ezdesign/ui/component/tab/tabs.html.twig`

To use the components, either [`embed`](https://twig.symfony.com/doc/3.x/tags/embed.html)
or [`include`](https://twig.symfony.com/doc/3.x/tags/include.html) them in templates.

Using `embed` enables you to override blocks defined inside the included template, for example:

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

Use `include` instead of `embed` when you pass tab content as variable while rendering the template:

``` html+twig
{% include '@ezdesign/ui/component/tab/tabs.html.twig' with {
        tabs: [
          { id: 'first', label: 'First', content: 'First tab content' },
          { id: 'second', label: 'Second', content: 'Second tab content', active: true },
        ]
    } %}
```

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
