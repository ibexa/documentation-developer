# Shop configuration

## Basket [[% include 'snippets/commerce_badge.md' %]]

### Additional data in the basket line

Each basket item can contain an additional line of data.

![](img/basket_additional_data_1.png)

You can enable this line in `config/packages/ezcommerce/ecommerce_parameters.yaml`:

``` yaml
ibexa.commerce.site_access.config.basket.default.additional_text_for_basket_line: true
ibexa.commerce.site_access.config.basket.default.additional_text_for_basket_line_input_limit: 25
```

### Basket storage time

The time for which a basket is stored depends on whether the basket belongs to an anonymous user or a logged-in user.

A basket for a logged-in customer is stored forever.

A basket for an anonymous user is stored for 120 hours by default.
You can configure a different value:

``` yaml
ibexa.commerce.site_access.config.basket.default.validHours: 120
```

You can use the `ibexa:commerce:clear-baskets` command to delete anonymous expired baskets:

``` bash
php bin/console ibexa:commerce:clear-baskets <validHours>
```

It deletes all anonymous baskets from the database that are older than `validHours`.

For example:

``` bash
php bin/console ibexa:commerce:clear-baskets 720
```

### Discontinued products

A listener can check if the product is still available, or discontinued.
You can disable this setting in configuration:

``` yaml
ibexa_commerce_basket.default.discontinued_products_listener_active: false
```

The listener checks if the current stock is greater than or equal to the quantity the customer wants to order.
In this case the order is allowed.

The optional setting `discontinued_products_listener_consider_packaging_unit` enables ignoring the packaging unit
in order to sell the remaining products, even if the remaining stock does not fit the packing unit rule
(for example, the packing unit is 10 pieces but 9 are left in stock).
The listener reduces the quantity in the order to the number of products that are in stock. 

``` yaml
ibexa_commerce_basket.default.discontinued_products_listener_consider_packaging_unit: true
```

### Product quantity validation

You can configure the minimum and maximum quantity that can be ordered per basket line:

``` yaml
ibexa.commerce.basket.basketline_quantity_max: 1000000
ibexa.commerce.basket.basketline_quantity_min: 1
```

If the quantity is more than the maximum or less than the minimum, it is set to either max or min.

### Shared baskets

A basket can be shared if a user logs in from a different browser (default), or it can be bound to the session.

If you do not want the basket to be shared between different sessions, change the following setting to `true`:

``` yaml
ibexa.commerce.site_access.config.basket.default.basketBySessionOnly: true
```

## Checkout [[% include 'snippets/commerce_badge.md' %]]

### Comment limit

In the summary, there is a comment field that the user can fill in.

By default, the comment box does not have a limit, but you can set a limit in configuration:

``` yaml
parameters:
    ibexa.commerce.site_access.config.checkout.default.checkout_form_summary_max_length: 30
```

The mapping of the request order should be modified to unlimit the number of characters
in `Eshop/Resources/mapping/wc3-nav/xsl/include/request.order.xsl`.

## Navigation

The `navigation_ez_location_root` parameter is the entry root Location point for the whole navigation in the Back Office.
This value is usually set to `2`, the Location of the content structure.

``` yaml
parameters:
    ibexa.commerce.site_access.config.core.default.navigation_ez_location_root: 2
    ibexa.commerce.site_access.config.core.default.navigation_ez_depth: 3
    ibexa.commerce.site_access.config.core.default.navigation_sort_order: 'asc'
```

The `navigation_ez_depth` parameter is responsible for the main navigation depth.
Content from the Back Office is fetched only up to this depth.
This does not include the product catalog, which has its own depth specified.

Use `navigation_sort_order` to set the order of sorting by priority.

### Fetching content

To define which Content Types should be included in the navigation, set the `types` parameter:

``` yaml
ibexa.commerce.site_access.config.core.default.navigation.catalog:
    types: ["st_module", "folder", "article", "landing_page", "ses_productcatalog", "blog"]
    sections: [1, 2]
    enable_priority_zero: true
```

To fetch content from different Sections, provide the Section IDs in configuration.

If you want to fetch all Content Types, even those with priority 0, use the `enable_priority_zero` parameter.
By default this is set to `false`.

### Navigation labels

To use a different field as the navigation node label, change the `label_fields` parameter.
The parameter takes Field Type identifier for `ibexa.commerce.site_access.config.core.default.navigation.content`
and Solr field name for `ibexa.commerce.site_access.config.core.default.navigation.catalog`.

The field has to exist in Solr indexed data.

``` yaml
ibexa.commerce.site_access.config.core.default.navigation.catalog:
    label_fields: ['name_s']
```

You can define the name used for navigation in configuration. The `label_fields` parameter contains a list of attribute names (Solr names) that are used as the name in the menu. 
The first available attribute is used. 

!!! caution

    The standard attribute `name_s` does not always contain the correct translation. 
    When `name_s` is used in `label_fields`, navigation may not be translated.
    To resolve this, configure the ID of the attribute directly e.g. `ses_category_ses_name_value_s`.

#### Additional navigation node information

You can also add additional information about the navigation node with `additional_fields`.
The fields have to exist in Solr indexed data.

``` yaml
ibexa.commerce.site_access.config.core.default.navigation.catalog:
    additional_fields: ['ses_category_ses_code_value_s', 'ses_category_ses_name_value_s']
```

##### Displaying images instead of labels in navigation

You can use an additional field to display an image from the content model instead of the node label:

``` yaml
parameters:   
    ibexa.commerce.site_access.config.core.default.navigation.content:
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

## Other

### Last viewed products

You can set the limit of products displayed in the Last viewed product block in:

``` yaml
parameters:
    ibexa.commerce.site_access.config.eshop.default.last_viewed_products_in_session_limit: 12
```

### Breadcrumbs

You can configure the Fields that are used as labels for breadcrumb nodes.
The first match wins.

``` yaml
parameters:
    ibexa.commerce.site_access.config.core.default.breadcrumb_content_label_fields: ['name', 'title']
```

