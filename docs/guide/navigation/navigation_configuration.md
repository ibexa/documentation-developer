# Navigation configuration [[% include 'snippets/commerce_badge.md' %]]

The `navigation_ez_location_root` parameter is the entry root Location point for the whole navigation in the Back Office.
This value is usually set to `2`, the Location of the content structure.

``` yaml
parameters:
    siso_core.default.navigation_ez_location_root: 2
    siso_core.default.navigation_ez_depth: 3
    siso_core.default.navigation_sort_order: 'asc'
```

The `navigation_ez_depth` parameter is responsible for the main navigation depth.
Content from the Back Office is fetched only up to this depth.
This does not include the product catalog, which has its own depth specified.

Use `navigation_sort_order` to set the order of sorting by priority.

## Fetching content

To define which Content Types should be included in the navigation, set the `types` parameter:

``` yaml
siso_core.default.navigation.catalog:
    types: ["st_module", "folder", "article", "landing_page", "ses_productcatalog", "blog"]
    sections: [1, 2]
    enable_priority_zero: true
```

To fetch content from different Sections, provide the Section IDs in configuration.

If you want to fetch all Content Types, even those with priority 0, use the `enable_priority_zero` parameter.
By default this is set to `false`.

## Navigation labels

To use a different field as the navigation node label, change the `label_fields` parameter.
The parameter takes Field Type identifier for `siso_core.default.navigation.content`
and Solr field name for `siso_core.default.navigation.catalog`.

The field has to exist in Solr indexed data.

``` yaml
siso_core.default.navigation.catalog:
    label_fields: ['name_s']
```

You can define the name used for navigation in configuration. The `label_fields` parameter contains a list of attribute names (Solr names) that are used as the name in the menu. 
The first available attribute is used. 

!!! caution

    The standard attribute `name_s` does not always contain the correct translation. 
    When `name_s` is used in `label_fields`, navigation may not be translated.
    To resolve this, configure the ID of the attribute directly e.g. `ses_category_ses_name_value_s`.

### Additional navigation node information

You can also add additional information about the navigation node with `additional_fields`.
The fields have to exist in Solr indexed data.

``` yaml
siso_core.default.navigation.catalog:
    additional_fields: ['ses_category_ses_code_value_s', 'ses_category_ses_name_value_s']
```

#### Displaying images instead of labels in navigation

You can use an additional field to display an image from the content model instead of the node label:

``` yaml
parameters:   
    siso_core.default.navigation.content:
        ...
        additional_fields: ['name', 'short_description', 'show_children', 'image']
```

You need to adapt the template to render the image instead of the label, for example:

``` html+twig
{% block label %}

  {% if(item.getExtra('image')) %}
    <img src="{{ item.getExtra('image') }}"/>
  {% else %}
    {{ item.label|raw }}
  {% endif %}

{% endblock %}
```

## Disabling the product catalog

To hide the whole catalog from the navigation, set the `product_catalog_enabled` parameter to `false`:

``` yaml
siso_core.default.product_catalog_enabled: false
```
