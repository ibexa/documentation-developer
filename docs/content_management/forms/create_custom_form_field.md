---
description: Extend a Form with a custom Form field to fit your particular needs.
edition: experience
---

# Create custom Form field

You can extend the Form Builder by adding new Form fields or modifying existing ones.
Define new form fields in configuration.

## Configure Form field

For example, to create a Country Form field in the "Custom form fields" category,
provide the following configuration:

``` yaml
[[= include_file('code_samples/forms/custom_form_field/config/packages/form_builder.yaml') =]]
```

Available attribute types are:

|Type|Description|
|----|----|
|`string`|String|
|`text`|Text block|
|`integer`|Integer number|
|`url`|URL|
|`multiple`|Multiple choice|
|`select`|Dropdown|
|`checkbox`|Checkbox|
|`location`|Content Location|
|`radio`|Radio button|
|`action`|Button|
|`choices`|List of available options|

Each type of Form field can have validators of the following types:

- `required`
- `min_length`
- `max_length`
- `min_choices`
- `max_choices`
- `min_value`
- `max_value`
- `regex`
- `upload_size`
- `extensions`

## Create mapper

New types of fields require a mapper which implements the `Ibexa\Contracts\FormBuilder\FieldType\Field\FieldMapperInterface` interface.

To create a Country field type, implement the `FieldMapperInterface` interface in `src/FormBuilder/Field/Mapper/CountryFieldMapper.php`:

``` php
[[= include_file('code_samples/forms/custom_form_field/src/FormBuilder/Field/Mapper/CountryFieldMapper.php') =]]
```

Then, register the mapper as a service:

``` yaml
[[= include_file('code_samples/forms/custom_form_field/config/custom_services.yaml', 0, 7) =]]
```

Now you can go to Back Office and build a new form.
You should be able to see the new section in the list of available fields:

![Custom form fields](extending_form_builder_custom_form_fields.png)

And a new Country Form field:

![Country field](extending_form_builder_country_field.png)

## Modify existing Form fields

Field or field attribute definition can be modified by subscribing to one of the following events:

- `ibexa.form_builder.field.<FIELD_ID>`
- `ibexa.form_builder.field.<FIELD_ID>.<ATTRIBUTE_ID>`

The following example adds a `custom` string attribute to `single_line` field definition.

``` php
[[= include_file('code_samples/forms/custom_form_field/src/EventSubscriber/FormFieldDefinitionSubscriber.php') =]]
```

Register this subscriber as a service:

``` yaml
[[= include_file('code_samples/forms/custom_form_field/config/custom_services.yaml', 0, 1) =]][[= include_file('code_samples/forms/custom_form_field/config/custom_services.yaml', 7, 11) =]]
```

## Access Form field definitions

Field definitions are accessible through:

- `Ibexa\FormBuilder\Definition\FieldDefinitionFactory` in the back end
- global variable `ibexa.formBuilder.config.fieldsConfig` in the front end
