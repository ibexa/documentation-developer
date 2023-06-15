---
description: Create Form Builder Form attribute. 
edition: experience
---

# Create Form Builder Form attribute 

You can create a Form attribute for new Form fields or existing ones.
To do it, you have to define a new Form attribute in the configuration.

In the following example you will learn how to create the new Form with `richtext_description` attribute that allows you to add formatted
description to the Form.

## Configure Form attribute

To create a `richtext_description` attribute,
add the following configuration under the `ibexa_form_builder_fields` [configuration key](configuration.md#configuration-files):

``` yaml
[[= include_file('code_samples/forms/custom_form_attribute/config/packages/form_attribute_config.yaml') =]]
```

## Create mapper

The new Form attribute requires a `FieldAttributeTypeMapper`. Register the mapper as a service in `config/services.yaml`:

``` yaml
[[= include_file('code_samples/forms/custom_form_attribute/config/custom_services.yaml') =]]
```

## Add Symfony form type

The attribute needs to be editable for the form creator, so it needs to have a Symfony form type. 
Add an `AttributeRichtextDescriptionType.php` file with the form type in the `src/FormBuilder/Form/Type/FieldAttribute` directory:

``` php
[[= include_file('code_samples/forms/custom_form_attribute/src/FormBuilder/Form/Type/FieldAttribute/AttributeRichtextDescriptionType.php') =]]
```

## Customize Form templates

The templates for the forms should look as follows:

- `templates/bundles/IbexaFormBuilderBundle/fields/config/form_fields.html.twig`:

``` html+twig
[[= include_file('code_samples/forms/custom_form_attribute/templates/bundles/IbexaFormBuilderBundle/fields/config/form_fields.html.twig') =]]
```

- `templates/themes/<your-theme>/formtheme/formbuilder_checkbox_with_richtext_description.html.twig`:

``` html+twig
[[= include_file('code_samples/forms/custom_form_attribute/templates/themes/standard/formtheme/formbuilder_checkbox_with_richtext_description.html.twig') =]]
```

## Add scripts

Now you need to enable the RichText editor. Provide the required script in a new `public/js/formbuilder-richtext-checkbox.js` file:

``` js
[[= include_file('code_samples/forms/custom_form_attribute/public/js/formbuilder-richtext-checkbox.js') =]]
```

Then, paste the highlighted part of the code into the `webpack.config.js` file:

``` js hl_lines="49-51"
[[= include_file('code_samples/forms/custom_form_attribute/webpack.config.js') =]]
```

Clear the cache and regenerate the assets by running the following commands:

``` bash
php bin/console cache:clear
php bin/console assets:install
yarn encore dev
```

## Implement Field

Now you have to implement the Field, and make sure the value from the RichText attribute is passed on to the field form.

Create a `src/FormBuilder/Form/Type/CheckboxWithRichtextDescriptionType.php` file.

```php
[[= include_file('code_samples/forms/custom_form_attribute/src/FormBuilder/Form/Type/CheckboxWithRichtextDescriptionType.php') =]]
```

## Implement field mapper

To implement a field mapper, create a `src/FormBuilder/FieldType/Field/Mapper/CheckboxWithRichtextDescriptionFieldMapper.php` file.

```php
[[= include_file('code_samples/forms/custom_form_attribute/src/FormBuilder/FieldType/Field/Mapper/CheckboxWithRichtextDescriptionFieldMapper.php') =]]
```

Now, the attribute value can be stored in the new Form.

## Create submission converter

The new Field is based on a checkbox, so to display the submissions of this field, you can use the `BooleanFieldSubmissionConverter`. 

Create a `src/FormBuilder/FormSubmission/Converter/RichtextDescriptionFieldSubmissionConverter.php` file.

```php
[[= include_file('code_samples/forms/custom_form_attribute/src/FormBuilder/FormSubmission/Converter/RichtextDescriptionFieldSubmissionConverter.php') =]]
```

Now you can go to Back Office and build a new form.
In the left menu select **Forms**, click **Create content** and select **Form**.

You should be able to see the new section in the list of available fields:

![New form](new_form.png)
