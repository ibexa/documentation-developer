# Catalog templates [[% include 'snippets/commerce_badge.md' %]]

## Template list

The following templates are used to render the catalog and its parts:

- `Catalog/catalog.html.twig` - whole catalog
- `Catalog/product.html.twig` - individual product
- `Catalog/productType.html.twig` - product type
- `Catalog/Subrequests/listChildren.html.twig` - product categories

The templates have access to the catalog node provided by the controller.
To show all the available attributes, use `getAttributeNames()`: `{{ catalogElement.attributeNames|json_encode }}`.

### Product categories

You can use different layouts to display a product category page:

``` yaml
siso_core.default.category_view: product_list
```

Available options: 

- `product_list`: display product list directly
- `both`: display subcategories and product list, including an option to display facets in the left sidebar instead of the navigation
- `categories`: display only subcategories. For the last category only, if there are no subcategories, display the product list

## Configuration for templates

The configuration for choosing templates is stored in `silver.eshop.yml`:

``` yaml
parameters:
    silver_eshop.default.catalog_template.CatalogNode: Catalog/catalog.html.twig
    silver_eshop.default.catalog_template.OrderableProductNode: Catalog/product.html.twig
    silver_eshop.default.catalog_template.VariantProductNode: Catalog/product_variants.html.twig
    silver_eshop.default.catalog_template.ProductType: Catalog/productType.html.twig
```

### Rendering configuration

You can define the number of products and other settings for catalog rendering in the configuration:

``` yaml
# number of elements do be displayed when pagination is used
silver_eshop.default.catalog_product_list_limit: 6
# number of elements on category overview pages
silver_eshop.default.catalog_category_limit: 100
# number of elements for ajax calls
silver_eshop.default.catalog_product_list_limit_ajax: 3

# max. number of products stored in the last viewed cache
silver_eshop.default.last_viewed_products_in_session_limit: 10
# number of chars used for product descriptions on overview page
silver_eshop.default.catalog_description_limit: 50

# Enable +/- (plus/minus) button for quantity instead of single input field.
siso_core.default.quantity_change_button: false
```

## Catalog URLs

URLs are provided by special methods:

- SEO URL: `{{ catalogElement.seoUrl }}`
- permanent URL: `{{ catalogElement.permanentUrl }}`

Since these URLs contain the prefix defined in the routing table as well, the `path()` function of Twig cannot be used.
