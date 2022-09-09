---
description: List all products contained in a predefined catalog.
---

# List products in catalog

To list products from a specific [catalog](pim.md#catalogs), you can either use the Content query Field,
or a custom controller.

## List products with Content query Field

To list products from a catalog in a [Content query Field](contentqueryfield.md),
add this Field to a Content Type definition.

Select the ["Catalog" Query type](built-in_query_types.md#catalog).
In parameters, provide the identifier of the catalog.

![Configuration of Content query Type for catalog](catalog_query_type_field.png)

Save the Content Type definition and create a Content item based on it.
The contents of the catalog are rendered automatically in the Field.

See [Content query Field](content_queries.md#pagination) for more information.

## List products with custom controller

You can also customize the rendering of products from a selected catalog with a custom controller and render it in a custom route.

In this example, create a custom controller for a promo catalog in `src/Controllers/PromoController.php`:

``` php hl_lines="26 27 29"
[[= include_file('code_samples/front/shop/list_products_in_catalog/src/Controller/PromoController.php') =]]
```

The controller uses `CatalogService` to get the selected catalog by its identifier, `desk_promo` (line 26).

The catalog provides a query, based on the filters you configured.
You can get the query with `$catalog->getQuery()` and use it as criteria in product query (lines 27-29).

Next, add a route for rendering the promo content which points to the controller:

``` yaml
[[= include_file('code_samples/front/shop/list_products_in_catalog/config/custom_routes.yaml') =]]
```

Finally, add a template to render a table with the products covered by the promo:

``` html+twig
[[= include_file('code_samples/front/shop/list_products_in_catalog/templates/themes/standard/full/promo.html.twig') =]]
```

You can now preview the `<youdomain>/promo` page and view the products
in the catalog.

!!! note

    The anonymous user does not have permission to view products and catalogs.
    To view the catalog and its products, you need to either log in,
    or give the anonymous user the [`product/view` and `catalog/view` Policies](permissions.md#available-policies).
