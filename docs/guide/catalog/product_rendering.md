# Product rendering [[% include 'snippets/commerce_badge.md' %]]

The `catalogElement` object represents the product in catalog templates.
Use it with the `ses_render_field` Twig function to render product Fields:

``` html+twig
{{ ses_render_field(catalogElement, 'name') }}
```

## Additional fields within the dataMap

A `dataMap` of the catalog element provides additional fields within some properties.
The `dataMap` provides an array of objects which implement the `FieldInterface`.
The `ses_render_field()` function can automatically use either a property of the catalog element, or a property from the `dataMap`.

If a property within the `dataMap` has the same name as another property of the `CatalogElement`,
you can enforce using the property from the `dataMap` by using the `enforce_datamap` parameter.

For example: `catalogElement` has property `price` (which has a `PriceField` with value `1.00`) and a `PriceField` `price` (value `2.00`) within its `dataMap`.

``` html+twig
{# "1.00" is output #}
{{ ses_render_field(catalogElement, 'price') }}
 
{# "2.00" is output #}
{{ ses_render_field(catalogElement, 'price', {"enforce_datamap": true}) }}
```

### Supported Field Types

The `dataMap` provides Fields of the following Field Types:

- TextLine
- RichText
- Image
- BinaryFile
- Checkbox
- RelationList
- SpecificationsType (for `specificationdata` only)
- VariantType (for `variants` only)

To add more Field Types do the `dataMap`, you need to [extend the catalog factory](catalog_api/extending_a_catalogfactory.md).

## Getting a product by SKU

If you need to fetch a product in a template (e.g. in a basket), use the `ses_product` Twig function.

``` html+twig
{% set product = ses_product({'sku': 999}) %}
Name: {{ product.name }}
```
In case of products with variants, you also need to provide the variant code:

``` html+twig
{% set product = ses_product({'sku': 999, 'variantCode': 9992 }) %}
Name: {{ product.name }}
```

Parameters:

|Parameter|Required|Description|
|--- |--- |--- |
|`sku`|yes|The SKU of the product node|
|`sub_tree_path`|no|An optional subtree path, to search product nodes (default: `/1/2` to search in the whole tree)|
|`variantCode`|no|An optional parameter if a given variant is returned|


### Product detail PDF

You can generate a PDF from the product detail page using a tool called `wkhtmltopdf`.
 
For security reasons, the PDF for product detail can only display general information
that would be also visible for anonymous users.
As a consequence, some details such as customer price cannot be displayed.
    
This is because `wkhtmltopdf` would need user data to generate user-specific PDFs.
The user data would have to be attached to the URL and would be visible to everyone.  

!!! note

    Use `wkhtmltopdf` in version 0.12.4 or higher to avoid issues with bugs present in earlier versions.
    For example, if your PDF output is too small, you may need to update `wkhtmltopdf` to a newer version. 

You can generate a PDF in the command line by providing a URL of the product detail page, for example:

``` bash
wkhtmltopdf --print-media-type <yourdomain>/Product/1234 <output_path>/product-detail.pdf
```
