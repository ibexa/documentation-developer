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

## Details

The details component consists of the following blocks:

- `details_header`
- `details_items`

Variables:

|Name|Type|Values|
|----|----|-----------|
|`headline` (optional)|string|if not specified, the header is not rendered|
|`headline_items`|array|
|`view_mode`|string|`vertical`, default set to `''`|
|`items`|hash|{`label`, `content_raw`, `content`}|

If `headline` is not specified, the `headline_items` is not rendered.

`headline` and `headline_items` have `action` variable used in `@ibexadesign/ui/component/table/table_header.html.twig`

## Modal

The modal component consists of the following blocks:

```html+twig
{% block dialog %}
    {% block content_before %}
	{% block content %}
		{% block header %}
		{% block subheader %}
		{% block body %}
		{% block footer %}
	{% block content_after %}
```

Variables:

|Name|Type|Values|
|----|----|-----------|
|`size`|string|`small`, `large`, `extra-large`, default set to: `''`|
|`subtitle`|string|no default value, if not defined, the `subheader` is not rendered|
|`no_header`|boolean|default set to `false`|
|`no_header_border`|boolean|default set to `false`|
|`class`|string|default `''`|
|`id`|string||
|`has_static_backdrop`|boolean|default set to `false`|

`attr` and other `attr_*` hold all HTML attributes rendered on their respective elements.

`attr`

|Name|Type|Values|
|----|----|-----------|
|`class`|string|default `''`|
|`role`|string|default `dialog`|
|`tabindex`|string|default `-1`|

`attr_dialog`

|Name|Type|Values|
|----|----|-----------|
|`class`|string|default set to `''`|
|`role`|string|default set to `document`|

`attr_content`

|Name|Type|Values|
|----|----|-----------|
|`class`|string|default set to `''`|

`attr_title`

|Name|Type|Values|
|----|----|-----------|
|`class`|string|default set to `''`|

`attr_close_btn`

|Name|Type|Values|
|----|----|-----------|
|`class`|string|default set to `''`|
|`type`|string|default set to `button`|
|`title`|string|default set to `Close`|

## Tables

The table component consists of the following blocks:

- `header` - headline for the table section
- `headline` - table name
- `actions` - action buttons, for example, create, bulk delete
- `table` - the table itself
- `thead` - table header content
- `tbody` - table body content


### Override specific cell

For the `twig` table component to have full control over rendering the rows of specific cells, only data are passed to it.
Data rows are passed in an array - one row per one array element.
It is neccessary to make each array an object with the columns data.

There are a few types of table columns:

- normal content column - `{ content: col_name }`
- a column icon - `{ has_icon: true, content: col_icon }`
- a checkbox column - `{ has_checkbox: true, content: col_checkbox }`
- action buttons column - `{ has_action_btns: true, content: col_action_btns }`

Each column has the `raw` parameter which prevents the component from the escaping content (untrusted user-generated content).

If you want to create an array based on some data from the backend, create an empty array and fill it with items (which corresponds to table rows) inside for loop:

```html+twig
{% set body_rows = [] %}
{% for article in pager.currentPageResults %}
    {# we may render checkbox using form_widget and just put HTML #}
    {% set col_checkbox %}
        {{ form_widget(form_remove.articles[article.id]) }}
    {% endset %}
    ​
    {% set col_icon %}
        <svg class="ibexa-icon ibexa-icon--small">
            <use xlink:href="{{ ibexa_content_type_icon(article.contentType.identifier) }}"></use>
        </svg>
    {% endset %}
```

### Render hyperlink

The following example shows how to render both text and hyperlink which redirect to the specified content.

```html+twig
{% set col_name %}
    <a href="{{ path('ibexa.content.view', { contentId: article.contentInfo.id, locationId: article.id }) }}">
        {{ ibexa_content_name(article.contentInfo) }}
    </a>
{% endset %}

{% set col_action_btns %}
    {% if article.userCanEdit %}
        <a
            href="#"
            class="btn ibexa-btn ibexa-btn--ghost ibexa-btn--no-text"
            title="{{ 'article.list.content.edit'|trans|desc('Edit content') }}"
        >
            <svg class="ibexa-icon ibexa-icon--small ibexa-icon--edit">
                <use xlink:href="{{ ibexa_icon_path('edit') }}"></use>
            </svg>
        </a>
    {% endif %}
{% endset %}

{% set body_rows = body_rows|merge([{ cols: [
    { has_checkbox: true, content: col_checkbox },
    { has_icon: true, content: col_icon },
    { content: col_name },
    { content: article.contentType.name },
    { has_action_btns: true, content: col_action_btns },
]}]) %}
{% endfor %}
```

### Actions

See the example below to learn how to create an action button which removes the article in the table.
The table component has to be wrapped into the remove article form.

Adding the `ibexa-toggle-btn-state` CSS class to the form with `data-toggle-button-id` data-attribute causes that button with `#article_remove_remove` id is enabled whenever any chceckbox is selected.

This is a built-in mechanism, you have to tell the system to render the button, make it disabled by default. 
Next, pass it under the `action` parameter to the table headline.

Action buttons are rendered on the right side of the table headline (do not confuse it with the table header).
You can also specify the table headline element with table title above it.

You can set headline title using the `results_headline` macro, and generate different headlines based on parameters:

- `count` - of all results, not only displayed on the first page
- `has_filters` - when using filters
- `phrase` - filtering phrase
- `results_headline` - ensures the headlines consistency across the platform
- `head_cols` - an array for table header (not headline), corresponds with consecutive column

For table header there are the following column types:

- normal content column `{ content: col_name }` (content is the title of the column)
- icon column `{ has_icon: true }`
- checkbox column `{ has_checkbox: true }`
- action buttons column ` {  }` with additional parameters available for all of the objects mentioned earlier:
 
    - class (CSS class)
    - attr (HTML attributes)

See the example:

```html+twig
{
    content: 'foo',
    class: 'bar',
    attr: {
        colspan: 2,
    },

```

- `empty_table_info_text` and `empty_table_action_text` specify texts which are displayed when the table is empty.


```html+twig
{{ form_start(form_remove, {
    action: path('ibexa.article.remove'),
    attr: { class: 'ibexa-toggle-btn-state', 'data-toggle-button-id': '#article_remove_remove' }
}) }}
{% include '@ibexadesign/ui/component/table/table.html.twig' with {
    headline: results_headline(pager.getNbResults()),
    head_cols: [
        { has_checkbox: true },
        { has_icon: true },
        { content: 'article.list.name'|trans|desc('Name') },
        { content: 'article.list.content_type'|trans|desc('Content Type') },
        { },
    ],
    body_rows,
    actions: form_widget(form_remove.remove, { attr:
        {
            class: 'btn ibexa-btn ibexa-btn--ghost ibexa-btn--small',
            disabled: true,
        }}),
    empty_table_info_text: 'article.list.empty'|trans|desc('You have no articles yet. Your articles will show up here.'),
    empty_table_action_text: 'article.list.empty_desc'|trans|desc('Articles you create will show up here.'),
} %}
{{ form_end(form_remove) }}
```

Other table component parameters include:

- `class` - (CSS table class)
- `attr` - (other HTML attributes applied on the HTML table element), for example:
    - `attr: { 'data-some-data-attribute-you-need': 'foo' }`
- `table_body_class` and `table_body_attr` are the same as mentioned earlier, but applied on the table element
- `show_head_cols_if_empty` - (default: `false`), by default, when `body_rows` is empty, the table component does not show the table header,it can be useful, for example, when rows are rendered dynamically with JavaScript on the browser side.

To avoid wrapping headline inside the form, as it's done in the earlier example, you can `embed` table and override the `between_header_and_table` block:

```html+twig
{% block between_header_and_table %}
    {{ form_start(form_remove, {
        action: path('ibexa.article.remove'),
        attr: { class: 'ibexa-toggle-btn-state', 'data-toggle-button-id': '#article_remove_remove' }
    }) }}
{% endblock %}
```

This method is useful in case of another form inside headline actions or to avoid interferences with the form like button triggering its sumbmission.

By default, tables are wrapped in a scrollable wrapper which prevents them from being too long.
To disable it, set the `is_scrollable` parameter to `false`.



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
