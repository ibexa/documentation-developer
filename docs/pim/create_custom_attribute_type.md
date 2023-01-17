---
description: Enhance product catalog by creating a custom product attribute type to fit your specific needs.
---

# Create custom attribute type

Besides the [built-in attribute types](pim.md#product-attributes), you can also create custom ones.

The example below shows how to add a Percentage attribute type.

## Select attribute type class

First, you need to register the type class that the attribute uses:

``` yaml
[[= include_file('code_samples/catalog/custom_attribute_type/config/custom_services.yaml', 0, 8) =]]
```

Use the `ibexa.product_catalog.attribute_type` tag to indicate the use as a product attribute type.
The custom attribute type has the identifier `percent`.

## Create value form mapper

A form mapper maps the data entered in an editing form into an attribute value.

The form mapper must implement `Ibexa\Contracts\ProductCatalog\Local\Attribute\ValueFormMapperInterface`.

In this example, you can use the Symfony's built-in `PercentType` class (line 42).

``` php hl_lines="42"
[[= include_file('code_samples/catalog/custom_attribute_type/src/Attribute/Percent/Form/PercentValueFormMapper.php') =]]
```

The `options` array contains additional options for the form, including options resulting from the selected form type.

Register the form mapper as a service and tag it with `ibexa.product_catalog.attribute.form_mapper.value`:

``` yaml
[[= include_file('code_samples/catalog/custom_attribute_type/config/custom_services.yaml', 9, 13) =]]
```

## Create value formatter

A value formatter prepares the attribute value for rendering in the proper format.

In this example, you can use the `NumberFormatter` to ensure the number is rendered in the percentage form (line 22).

``` php hl_lines="22"
[[= include_file('code_samples/catalog/custom_attribute_type/src/Attribute/Percent/PercentValueFormatter.php') =]]
```

Register the value formatter as a service and tag it with `ibexa.product_catalog.attribute.formatter.value`:

``` yaml
[[= include_file('code_samples/catalog/custom_attribute_type/config/custom_services.yaml', 14, 18) =]]
```

## Add attribute options

You can also add options specific for the attribute type that the user selects when creating an attribute.

In this example, you can set the minimum and maximum allowed percentage.

### Options type

First, create `PercentAttributeOptionsType` that defines two options, `min` and `max`.
Both those options need to be of `PercentType`.

``` php hl_lines="16 22"
[[= include_file('code_samples/catalog/custom_attribute_type/src/Attribute/Percent/PercentAttributeOptionsType.php') =]]
```

### Options form mapper

Next, create a `PercentOptionsFormMapper` that maps the information that the user inputs in the form into attribute definition.

``` php
[[= include_file('code_samples/catalog/custom_attribute_type/src/Attribute/Percent/PercentOptionsFormMapper.php') =]]
```

Register the options form mapper as a service and tag it with `ibexa.product_catalog.attribute.form_mapper.options`:

``` yaml
[[= include_file('code_samples/catalog/custom_attribute_type/config/custom_services.yaml', 19, 24) =]]
```

### Options validator

Create a `PercentOptionsValidator` that implements `Ibexa\Contracts\ProductCatalog\Local\Attribute\OptionsValidatorInterface`.
It validates the options that the user sets while creating the attribute definition.

In this example, the validator verifies whether the minimum percentage is lower than the maximum.

``` php
[[= include_file('code_samples/catalog/custom_attribute_type/src/Attribute/Percent/PercentOptionsValidator.php') =]]
```

Register the options validator as a service and tag it with `ibexa.product_catalog.attribute.validator.options`:

``` yaml
[[= include_file('code_samples/catalog/custom_attribute_type/config/custom_services.yaml', 31, 36) =]]
```

### Value validator

Finally, make sure the data provided by the user is validated.
To do that, create `PercentValueValidator` that checks the values against `min` and `max` and dispatches an error when needed.

``` php hl_lines="23-27"
[[= include_file('code_samples/catalog/custom_attribute_type/src/Attribute/Percent/PercentValueValidator.php') =]]
```

Register the validator as a service and tag it with `ibexa.product_catalog.attribute.validator.value`:

``` yaml
[[= include_file('code_samples/catalog/custom_attribute_type/config/custom_services.yaml', 25, 30) =]]
```

## Storage

To ensure that values of the new attributes are stored correctly, you need to provide a storage converter and storage definition services.

### Storage converter

Start by creating a `PercentStorageConverter` class, which implements `Ibexa\Contracts\ProductCatalog\Local\Attribute\StorageConverterInterface`.
This converter is responsible for converting database results into an attribute type instance:

``` php
[[= include_file('code_samples/catalog/custom_attribute_type/src/Attribute/Percent/Storage/PercentStorageConverter.php') =]]
```

Register the converter as a service and tag it with `ibexa.product_catalog.attribute.storage_converter`:

``` yaml
[[= include_file('code_samples/catalog/custom_attribute_type/config/custom_services.yaml', 37, 40) =]]
```

### Storage definition

Next, prepare a `PercentStorageDefinition` class, which implements `Ibexa\Contracts\ProductCatalog\Local\Attribute\StorageDefinitionInterface`.

``` php
[[= include_file('code_samples/catalog/custom_attribute_type/src/Attribute/Percent/Storage/PercentStorageDefinition.php') =]]
```

Register the storage definition as a service and tag it with `ibexa.product_catalog.attribute.storage_definition`:

``` yaml
[[= include_file('code_samples/catalog/custom_attribute_type/config/custom_services.yaml', 41, 44) =]]
```

## Use new attribute type

In the Back Office you can now add a new Percent attribute to your product type and create a product with it.

![Creating a product with a custom Percent attribute](catalog_custom_attribute_type.png)
