---
description: Enable comparison of content Fields based on a custom Field Type.
---

# Create custom Field Type comparison

In the Back Office, you can compare the contents of Fields.
Comparing is possible only between two versions of the same Field that are in the same language.

You can add the possibility to compare custom and other unsupported Field Types.

!!! note

    The following task uses the [custom "Hello World" Field Type](create_custom_generic_field_type.md).
    The configuration is based on the comparison mechanism created for the `ezstring` Field Type.

## Create Comparable class

First, create a `Comparable.php` class in `src/FieldType/HelloWorld/Comparison`.

This class implements the `Ibexa\Contracts\VersionComparison\FieldType\Comparable` interface with the `getDataToCompare()` method:

``` php
[[= include_file('code_samples/field_types/generic_ft/src/FieldType/HelloWorld/Comparison/Comparable.php') =]]
```

The `getDataToCompare()` fetches the data to compare and determines which [comparison engines](#create-comparison-engine) should be used.

Register this class as a service:

``` yaml
[[= include_file('code_samples/field_types/generic_ft/config/custom_services.yaml', 0, 1) =]][[= include_file('code_samples/field_types/generic_ft/config/custom_services.yaml', 7, 10) =]]
```

## Create comparison value

Next, create a `src/FieldType/HelloWorld/Comparison/Value.php` file that holds the comparison value:

``` php
[[= include_file('code_samples/field_types/generic_ft/src/FieldType/HelloWorld/Comparison/Value.php') =]]
```

## Create comparison engine

The comparison engine handles the operations required for comparing the contents of Fields.
Each Field Type requires a separate comparison engine, which implements the `Ibexa\Contracts\VersionComparison\Engine\FieldTypeComparisonEngine` interface.

For the "Hello World" Field Type, create the following comparison engine based on the engine for the TextLine Field Type.
Place it in `src/FieldType/HelloWorld/Comparison/HelloWorldComparisonEngine.php`:

``` php
[[= include_file('code_samples/field_types/generic_ft/src/FieldType/HelloWorld/Comparison/HelloWorldComparisonEngine.php') =]]
```

Register the comparison engine as a service:

``` yaml
[[= include_file('code_samples/field_types/generic_ft/config/custom_services.yaml', 0, 1) =]][[= include_file('code_samples/field_types/generic_ft/config/custom_services.yaml', 11, 14) =]]
```

## Add comparison result

Next, create a comparison result class in `src/FieldType/HelloWorld/Comparison/HelloWorldComparisonResult.php`.

``` php
[[= include_file('code_samples/field_types/generic_ft/src/FieldType/HelloWorld/Comparison/HelloWorldComparisonResult.php') =]]
```

## Provide templates

Finally, create a template for the new comparison view in `templates/field_type_comparison.html.twig`:

``` html+twig
[[= include_file('code_samples/field_types/generic_ft/templates/field_type_comparison.html.twig') =]]
```

Add configuration for this template in `config/packages/ibexa.yaml`:

```yaml
[[= include_file('code_samples/field_types/generic_ft/config/packages/field_templates.yaml', 0, 3) =]][[= include_file('code_samples/field_types/generic_ft/config/packages/field_templates.yaml', 5, 7) =]]
```
