---
description: "PIM training: Product displaying"
edition: experience
page_type: training
---

# Product displaying

How to display a price is kept for the next chapter.

The "add to cart" and other sale features are not part of this training which stay focused on what is available in the Ibexa DXP Headless.

## Routes

Like every content item, it is viewable through its friendly URL Alias, or at the route `/view/content/{contentId}/{viewType}/{layout}/{locationId}` (`ibexa.content.view`).

An alternative route is also available, dedicated for Back Office, `/product/{productCode}` (`ibexa.product_catalog.product.view`).

You may notice that the Back Office automatically redirect the `ibexa.content.view` route to the "`full`" view type to the `ibexa.product_catalog.product.view` route, while the front office don't.
On contrary, a front office will probably throw an error if accessed through a `ibexa.product_catalog.product.view` URL: "The route is not allowed in the current SiteAccess".

So, be aware, and don't mix up Back Office and front office URLs.

Product variants are not content items.
TODO: Introduce ways to access product variant

## Rights

To be able to view products, "Content / Read" policy isn't enough even if products are content items.

The policy "Product / View" give access to products. It is limited by product types.

Exercise: Add "Product / View" policy to "Anonymous" role, allow all your product type.

TODO: "Product Type / View" could be needed. I needed it for `isBaseProduct` `{{ dump((content|ibexa_get_product).isBaseProduct) }}`

## Templates

### Matchers

* All products

`Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\IsProduct`

https://doc.ibexa.co/en/latest/templating/templates/view_matcher_reference/#product

https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ViewMatcher-ProductBased-IsProduct.html

```yaml
ibexa:
    system:
        <siteaccess_scope>:
            content_view:
                product:
                    template: '@ibexadesign/full/product.html.twig'
                    match:
                        '@Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\IsProduct': ~
```

* Products of a given type

`Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\ProductType`

```yaml
                bike:
                    template: '@ibexadesign/full/bike.html.twig'
                    match:
                        '@Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\ProductType': ['bike', 'mountain_bike', 'racing_bike']
                electric_bike:
                    template: '@ibexadesign/full/electric_bike.html.twig'
                    match:
                        '@Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\ProductType': ['electric_bike']
```

* Products of a given code

`Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\ProductCode`

```yaml
                4_series:
                    template: '@ibexadesign/full/bike.html.twig'
                    match:
                        '@Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\ProductCode': ['MTBS4-4', 'MTBS4-5', 'MTBS4-6', 'MTBS4-7']
                5_series:
                    template: '@ibexadesign/full/bike.html.twig'
                    match:
                        '@Ibexa\Contracts\ProductCatalog\ViewMatcher\ProductBased\ProductCode': ['MTBS5-0', 'MTBS5-1', 'MTBS5-2', 'MTBS5-3', 'MTBS5-4']
```

* TODO: Availability

### Content fields and product attributes

Fields are displayed as usual.

For the particular case of `ibexa_product_specification` field type, you can take a look at
`vendor/ibexa/product-catalog/src/bundle/Resources/views/themes/standard/product_catalog/field_type/product.html.twig`

TODO: But variant aren't content items…

### Twig functions

[Product Twig functions](product_twig_functions.md)

`ibexa_get_product` returns a [`ProductInterface`](TODO/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-ProductInterface.html)

### Commerce's `storefront` theme

Ibexa DXP Commerce has a default design for displaying product: `storefront`

When using Commerce, you should prefer building on top of this design.

SiteAccess from group `storefront_group` has this design.

Template rules are defined in `vendor/ibexa/storefront/src/bundle/Resources/config/prepend.yaml`.
You can read there how the product `full` view is defined using the `IsProduct` matcher.

The product default template is
`vendor/ibexa/storefront/src/bundle/Resources/views/themes/storefront/storefront/product.html.twig`.
You can override it with a template located as `templates/themes/<your_theme>/storefront/product.html.twig`.

## TODO: Exercise

/product-catalog/TODO?code=TODO

```html+twig
{{ ibexa_render_field(content, 'product_specification') }}

{% set product = content|ibexa_get_product %}
{% set code = app.request.get('code')|default(product.code) %}
{% if code != product.code and product.isBaseProduct %}
    {% for variant in product.getVariantsList %}
         {% if code == variant.code %}
             {% set product = variant %}
         {% endif %}
    {% endfor %}
{% endif %}

<table>
    <tbody>
    {% for attribute in product.attributes %}
        {% set definition = attribute.getAttributeDefinition() %}
        <tr>
            <th>{{ definition.getName() }}</th>
            <td>{{ attribute|ibexa_format_product_attribute }}</td>
        </tr>
    {% endfor %}
    </tbody>
</table>
```
