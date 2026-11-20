# Create custom catalog filter

Fine-tune product catalogs by adding a custom catalog filter for selecting products from the PIM.

Catalog filters let you narrow down the products from the PIM that are available in the given [catalog](../catalogs/index.md).

Besides the built-in catalog filters, you can also create custom ones. The following example shows how to create a filter that selects products with the entered name.

## Create filter class

To create a custom catalog filter, first you need to create a filter class in `App\CatalogFilter\ProductNameFilter`.

```php
<?php

declare(strict_types=1);

namespace App\CatalogFilter;

use Ibexa\Contracts\ProductCatalog\CatalogFilters\FilterDefinitionInterface;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductName;
use Ibexa\Contracts\ProductCatalog\Values\Product\Query\CriterionInterface;

final class ProductNameFilter implements FilterDefinitionInterface
{
    public function getIdentifier(): string
    {
        return 'product_name';
    }

    public function getName(): string
    {
        return 'Product name';
    }

    public function supports(CriterionInterface $criterion): bool
    {
        return $criterion instanceof ProductName;
    }

    public static function getTranslationMessages(): array
    {
        return [];
    }

    public function getGroupName(): string
    {
        return 'Custom filters';
    }
}
```

The filter must implement `Ibexa\Contracts\ProductCatalog\CatalogFilters\FilterDefinitionInterface`, provide the filter identifier and name, and the group in which it's displayed in the editing menu.

The example above uses the built-in `ProductName` Search Criterion.

## Create form mapper

Next, you need to add a form mapper: `ProductNameFilterFormMapper` that maps the input from the filter form to the data model:

```php
<?php

declare(strict_types=1);

namespace App\CatalogFilter;

use Ibexa\Bundle\ProductCatalog\Form\Type\TagifyType;
use Ibexa\Contracts\ProductCatalog\CatalogFilters\FilterDefinitionInterface;
use Ibexa\Contracts\ProductCatalog\CatalogFilters\FilterFormMapperInterface;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductNameFilterFormMapper implements FilterFormMapperInterface
{
    public function __construct()
    {
    }

    public function createFilterForm(
        FilterDefinitionInterface $filterDefinition,
        FormBuilderInterface $builder,
        array $context = []
    ): void {
        $builder->add(
            $filterDefinition->getIdentifier(),
            TagifyType::class,
            [
                'label' => 'Product name',
                'block_prefix' => 'catalog_criteria_product_name',
                'translation_domain' => 'product_catalog',
            ]
        );

        $builder->get($filterDefinition->getIdentifier())
            ->addModelTransformer(
                new DataTransformer\ProductNameCriterionTransformer()
            );
    }

    public function supports(FilterDefinitionInterface $filterDefinition): bool
    {
        return $filterDefinition instanceof ProductNameFilter;
    }
}
```

The filter can use the built-in `ProductName` Criterion, but you still need a data transformer for the data entered when editing the catalog (line 35).

Before you add a data transformer, register the required services.

## Register services

Register the filter and its mapper as services. Tag the filter with `ibexa.product_catalog.catalog_filter` and the form mapper with `ibexa.product_catalog.catalog_filter.form_mapper`:

```yaml
services:
    App\CatalogFilter\ProductNameFilter:
        tags:
            - name: ibexa.product_catalog.catalog_filter
              alias: product_name

    App\CatalogFilter\ProductNameFilterFormMapper:
        tags:
            -   name: ibexa.product_catalog.catalog_filter.form_mapper
```

## Create data transformer

Now, create `ProductNameCriterionTransformer` in `src/CatalogFilter/DataTransformer`:

```php
<?php

declare(strict_types=1);

namespace App\CatalogFilter\DataTransformer;

use Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductName;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * @implements \Symfony\Component\Form\DataTransformerInterface<
 *     \Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\ProductName,
 *     \Ibexa\Bundle\ProductCatalog\Form\Data\Catalog\CatalogFilterPriceData
 * >
 */
final class ProductNameCriterionTransformer implements DataTransformerInterface
{
    public function transform($value): ?string
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof ProductName) {
            throw new TransformationFailedException('Expected a ' . ProductName::class . ' object.');
        }

        return $value->getName();
    }

    public function reverseTransform($value): ?ProductName
    {
        if ($value === null) {
            return null;
        }

        if (!is_string($value)) {
            throw new TransformationFailedException('Invalid data, expected a string value');
        }

        return new ProductName($value);
    }
}
```

## Provide templates

Now, provide the templates for the catalog editing view in the back office.

You need two templates: one for the filter form, and one for the filter badge in the product list.

First, add a `form_field_override.html.twig` template to `templates/themes/admin/product_catalog`:

```html+twig
{% extends '@ibexadesign/product_catalog/form_fields.html.twig' %}

{%- block catalog_criteria_product_name_row -%}
    {{- block('catalog_taggify_panel') -}}
{%- endblock -%}
```

Here, you use the same built-in template that is used for example for the product code filter. It's placed in a template block corresponding to your custom filter, `catalog_criteria_product_name_values`.

To ensure the template is used as a back office form theme, add the following configuration:

```yaml
twig:
    form_themes:
        - '@ibexadesign/product_catalog/form_field_override.html.twig'
```

Next, add a template that handles the display of the filter badge on the list of the currently filtered products. Add `catalog_filters_blocks.html.twig` to `templates/themes/admin/product_catalog`:

```html+twig
{% block catalog_criteria_product_name_values %}
    {% include '@ibexadesign/product_catalog/catalog/edit/list_filter_taggify.html.twig' with { criteria } %}
{% endblock %}
```

To ensure this template is used to render the catalog filter form, add the following configuration:

```yaml
ibexa:
    system:
        default:
            product_catalog:
                catalogs:
                    filter_preview_templates:
                        - { template: "@ibexadesign/product_catalog/catalog_filters_blocks.html.twig", priority: 10 }
```

## Check results

Finally, you can check the results. Go to **Product catalog** -> **Catalogs** and create a new catalog. From the filter list, select **Product name**, type the name of an existing product and click **Save**.

![Custom Product Name catalog filter](https://doc.ibexa.co/en/5.0/product_catalog/img/custom_catalog_filter.png)
