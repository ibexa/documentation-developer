---
description: Create Form Builder form attribute 
edition: experience
---

# Create Form Builder Form attribute 

You can create Form attribute for the new Form fields or existing ones.
Define new Form attribute in configuration.

## Configure Form attribute

For example, to create a "richtext_description" attribute,
provide the following configuration, `config/packages/ezplatform.yaml`:

``` yaml
[[= include_file('code_samples/forms/custom_form_field/src/FormAttribute/FormAttributeConfig.yaml') =]]
```

You can edit Form attribute in the Form Builder's editor. 
Make sure that the value of the attribute is passed on the the Field once that is rendered.

## Create mapper

New Form attribute requires a FieldAttributeTypeMapper. Register the mapper as a service: in `config/services.yaml`:

``` yaml
[[= include_file('code_samples/forms/custom_form_field/src/FormAttribute/FormAttributeTypeMapper.yaml') =]]
```

## Ass symfony form type

Since the attribute needs to be editable for the form creator, it needs to have a symfony form type. 
You must provide your own file `AttributeRichtextDescriptioType.php` in the `src/FormBuilder/Form/Type/FieldAttribute/` directory:

``` php
[[= include_file('code_samples/forms/custom_form_field/src/FormAttribute/php/AttributeRichtextDescripion.php') =]]
```

## Customize Form templates

To customize the templates for this form, use a symfony feature.

The `template` key points to the template that is used to render the custom style. 
It is recommended that you use the [design engine](../guide/content_rendering/design_engine/design_engine.md).

The template files for the front end could look as follows:

- `templates/bundles/EzPlatformFormBuilderBundle/fields/config/form_fields.html.twig`:

``` html+twig
[[= include_file('code_samples/forms/custom_form_field/src/FormAttribute/twig/Form_fields.html.twig') =]]
```

- `templates/formtheme/formbuilder_checkbox_with_richtext_description.html.twig`:

``` html+twig
[[= include_file('code_samples/forms/custom_form_field/src/FormAttribute/Form_fields.html.twig') =]]
```

## Add scripts

The richtext editor needs to be enabled using a small .js snippet:

- `src/Resources/encore/ez.config.js`:

``` js
[[= include_file('code_samples/forms/custom_form_field/src/FormAttribute/twig/Form_fields.html.twig') =]]
```

- `src/Resources/public/js/formbuilder-richtext-checkbox.js`:

``` js
[[= include_file('code_samples/forms/custom_form_field/src/FormAttribute/twig/Form_fields.html.twig') =]]
```

## Implement Field

Now you have to implement the Field, and make sure the value from the richtext attribute is passed on to the field form.
Create a `src/FormBuilder/Form/Type/CheckboxWithRichtextDescriptionType.php` file.

```php
[[= include_file('code_samples/forms/custom_form_field/src/FormAttribute/php/CheckboxWithRichtextDescriptionType.php') =]]
```

New Field is based on checkbox, so for displaying the submissions of this field, you can use the BooleanFieldSubmissionConverter. 
Create a `src/FormBuilder/FormSubmission/Converter/RichtextDescriptionFieldSubmissionConverter.php` file.

```php
[[= include_file('code_samples/forms/custom_form_field/src/FormAttribute/php/RichtextDescriptionFieldSubmissionConverter.php`') =]]
```

Now you can go to Back Office and build a new form.
You should be able to see the new section in the list of available fields:

