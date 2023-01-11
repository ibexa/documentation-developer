---
description: Create Form Builder form attribute 
edition: experience
---

# Create Form Builder Form attribute 

You can create Form attribute for the new Form fields or existing ones.
To do it, you have to define new Form attribute in the configuration.

## Configure Form attribute

For example, to create a "richtext_description" attribute,
provide the following configuration in `config/packages/ezplatform.yaml`:

``` yaml
[[= include_file('code_samples/forms/custom_form_attribute/config/packages/FormAttributeConfig.yaml') =]]
```

You can edit Form attribute at any time in the Form Builder's editor.

## Create mapper

New Form attribute requires a FieldAttributeTypeMapper. Register the mapper as a service: in `config/services.yaml`:

``` yaml
[[= include_file('code_samples/forms/custom_form_attribute/config/FieldAttributeTypeMapper.yaml') =]]
```

## Add symfony form type

The attribute needs to be editable for the form creator, so it needs to have a symfony form type. 
You must provide your own file `AttributeRichtextDescriptionType.php` in the `src/FormBuilder/Form/Type/FieldAttribute/` directory:

``` php
[[= include_file('code_samples/forms/custom_form_attribute/src/FormBuilder/Form/Type/FieldAttribute/AttributeRichtextDescriptionType.php') =]]
```

## Customize Form templates

To customize the templates for the form, use a symfony feature.

The template files for the front end must look as follows:

- `templates/bundles/EzPlatformFormBuilderBundle/fields/config/form_fields.html.twig`:

``` html+twig
[[= include_file('code_samples/templates/bundles/EzPlatformFormBuilderBundle/fields/config/form_fields.html.twig') =]]
```

- `templates/formtheme/formbuilder_checkbox_with_richtext_description.html.twig`:

``` html+twig
[[= include_file('code_samples/templates/formtheme/formbuilder_checkbox_with_richtext_description.html.twig') =]]
```

## Add scripts

The richtext editor needs to be enabled using scripts snippets. Provide your own files:

- `src/Resources/encore/ez.config.js`:

``` js
[[= include_file('code_samples/forms/custom_form_attribute/src/Resources/encore/ez.config.js') =]]
```

- `src/Resources/public/js/formbuilder-richtext-checkbox.js`:

``` js
[[= include_file('code_samples/forms/custom_form_attribute/src/Resources/public/formbuilder-richtext-checkbox.js') =]]
```

Then, paste the following code into `webpack.config.js` file:

``` js hl_lines="38 41"
[[= include_file('code_samples/app/webpack.config.js') =]]
```

## Implement Field

Now you have to implement the Field, and make sure the value from the richtext attribute is passed on to the field form.

Create a `src/FormBuilder/Form/Type/CheckboxWithRichtextDescriptionType.php` file.

```php
[[= include_file('code_samples/forms/custom_form_attribute/src/FormBuilder/Form/Type/CheckboxWithRichtextDescriptionType.php') =]]
```

New Field is based on checkbox, so to display the submissions of this field, you can use the BooleanFieldSubmissionConverter. 

Create a `src/FormBuilder/FormSubmission/Converter/RichtextDescriptionFieldSubmissionConverter.php` file.

```php
[[= include_file('code_samples/forms/custom_form_attribute/src/FormBuilder/FormSubmission/Converter/RichtextDescriptionFieldSubmissionConverter.php`') =]]
```

Now you can go to Back Office and build a new form.

You should be able to see the new section in the list of available fields:

![New form](img/new_form.png)