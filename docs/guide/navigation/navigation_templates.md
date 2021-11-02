# Navigation templates

## Template list

Navigation uses the following built-in templates.

### Main navigation

|Path|Description|
|--- |--- |
|`Eshop/Resources/views/Navigation/main_navigation.html.twig`|Renders the navigation subcontroller that builds the main navigation|
|`Eshop/Resources/views/Navigation/main_menu.html.twig`|Renders the main navigation list `<ul>` and includes `knp_menu.html.twig`|
|`Eshop/Resources/views/Navigation/knp_menu.html.twig`|Renders the main navigation nodes as `<li>` elements|

### Left navigation

|Path|Description|
|--- |--- |
|`Eshop/Resources/views/Navigation/left_navigation.html.twig`|Renders the navigation subcontroller that builds the left navigation|
|`Eshop/Resources/views/Navigation/left_menu.html.twig`|Renders the left navigation list `<ul>` and includes `left_menu.html.twig`|
|`Eshop/Resources/views/Navigation/knp_left_menu.html.twig`|Renders the left navigation nodes as `<li>` elements|

### Offcanvas

|Path|Description|
|--- |--- |
|`Eshop/Resources/views/Navigation/offcanvas_navigation.html.twig`|Renders the navigation subcontroller that builds the offcanvas navigation|
|`Eshop/Resources/views/Navigation/offcanvas_menu.html.twig`|Renders the offcanvas navigation list `<ul>` and includes `knp_offcanvas.html.twig`|
|`Eshop/Resources/views/Navigation/knp_offcanvas.html.twig`|Renders the offcanvas navigation nodes as `<li>` elements|

## Custom Twig functions

### `get_parent_product_catalog`

Fetches the parent product catalog Location ID from a `Ibexa\Bundle\Commerce\Eshop\Catalog\CatalogElement` parameter.

``` html+twig
{% set product_catalog_id = get_parent_product_catalog(catalogElement) %}
```

### `get_data_location_ids`

Returns a comma-separated string of `data_location-id` attributes of the given element.
All parent Locations including the element Location are returned.
These `data_location-id`s are used to highlight the active node in the navigation.

The function can take as parameters:

- `Ibexa\Contracts\Core\Repository\Values\Content\Location`
- `Ibexa\Bundle\Commerce\Eshop\Catalog\CatalogElement`

``` html+twig
{% set data_locations = get_data_location_ids(location) %}
{% set data_locations = get_data_location_ids(catalogElement) %}
```
