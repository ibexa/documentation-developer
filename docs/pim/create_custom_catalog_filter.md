---
description: Fine-tune product catalogs by adding a custom catalog filter for selecting products from the PIM.
---

# Create custom catalog filter

Catalog filters let you narrow down the products from the PIM that are available in the given [catalog](pim.md#catalogs).

Besides the built-in catalog filters, you can also create custom ones.
The following example shows how to create a filter that selects products with the entered name.

## Create filter class

To create a custom catalog filter, first you need to create a filter class in `App\CatalogFilter\ProductNameFilter`.

``` php
[[= include_file('code_samples/catalog/custom_catalog_filter/src/CatalogFilter/ProductNameFilter.php') =]]
```

The filter must implement `Ibexa\Contracts\ProductCatalog\CatalogFilters\FilterDefinitionInterface`,
provide the filter identifier and name, and the group in which it is displayed in the editing menu.

The example above uses the built-in `ProductName` Search Criterion.

## Create form mapper

Next, you need to add a form mapper: `ProductNameFilterFormMapper` that maps the input from the filter form to the data model:

``` php hl_lines="35"
[[= include_file('code_samples/catalog/custom_catalog_filter/src/CatalogFilter/ProductNameFilterFormMapper.php') =]]
```

The filter can use the built-in `ProductName` Criterion, but you still need a data transformer for the data entered when editing the catalog (line 35).

Before you add a data transformer, register the required services.

## Register services

Register the filter and its mapper as services.
Tag the filter with `ibexa.product_catalog.catalog_filter`
and the form mapper with `ibexa.product_catalog.catalog_filter.form_mapper`:

``` yaml
[[= include_file('code_samples/catalog/custom_catalog_filter/config/custom_services.yaml') =]]
```

## Create data transformer

Now, create `ProductNameCriterionTransformer` in `src/CatalogFilter/DataTransformer`:

``` php
[[= include_file('code_samples/catalog/custom_catalog_filter/src/CatalogFilter/DataTransformer/ProductNameCriterionTransformer.php') =]]
```

## Provide templates

Now, provide the templates for the catalog editing view in the Back Office.

You need two templates: one for the filter form, and one for the filter badge in the product list.

First, add a `form_field_override.html.twig` template to `templates/themes/admin/product_catalog`:

``` html+twig
[[= include_file('code_samples/catalog/custom_catalog_filter/templates/themes/admin/product_catalog/form_field_override.html.twig') =]]
```

Here, you use the same built-in template that is used for example for the product code filter.
It is placed in a template block corresponding to your custom filter, `catalog_criteria_product_name_values`.

To ensure the template is used as a Back Office form theme, add the following configuration:

``` yaml
[[= include_file('code_samples/catalog/custom_catalog_filter/config/packages/catalog_filters.yaml', 8, 11) =]]
```

Next, add a template that handles the display of the filter badge on the list of the currently filtered products.
Add `catalog_filters_blocks.html.twig` to `templates/themes/admin/product_catalog`:

``` html+twig
[[= include_file('code_samples/catalog/custom_catalog_filter/templates/themes/admin/product_catalog/catalog_filters_blocks.html.twig') =]]
```

To ensure this template is used to render the catalog filter form, add the following configuration:

``` yaml
[[= include_file('code_samples/catalog/custom_catalog_filter/config/packages/catalog_filters.yaml', 0, 7) =]]
```

## Check results

Finally, you can check the results of our work.
Go to **Product catalog** -> **Catalogs** and create a new catalog.
From the filter list, select **Product name**, type the name of an existing product and click **Save**.

![Custom Product Name catalog filter](custom_catalog_filter.png)
