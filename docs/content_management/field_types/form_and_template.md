---
description: Field type FormMappers allow field editing, while custom templates ensure the field can be rendered both in the back office and on site front.
---

# Form and template

## FormMapper

The FormMapper maps field definitions into Symfony forms, allowing field editing.

It can implement two interfaces:

- `Ibexa\Contracts\ContentForms\FieldType\FieldValueFormMapperInterface` to provide editing support
- `Ibexa\AdminUi\FieldType\FieldDefinitionFormMapperInterface` to provide field type definition editing support,
when you require non-standard settings

### FieldValueFormMapperInterface

The `FieldValueFormMapperInterface::mapFieldValueForm` method accepts two arguments:

- `FormInterface` — form for the current field
- `FieldData` — underlying data for current field form

You have to add your form type to the content editing form. The example shows how `ezboolean` injects the form:

``` php
use Ibexa\Contracts\ContentForms\Data\Content\FieldData;
use Ibexa\ContentForms\Form\Type\FieldType\CheckboxFieldType;
use Symfony\Component\Form\FormInterface;

public function mapFieldValueForm(FormInterface $fieldForm, FieldData $data)
{
    $fieldDefinition = $data->fieldDefinition;
    $formConfig = $fieldForm->getConfig();

    $fieldForm
        ->add(
            $formConfig->getFormFactory()->createBuilder()
                ->create(
                    'value',
                    CheckboxFieldType::class,
                    [
                        'required' => $fieldDefinition->isRequired,
                        'label' => $fieldDefinition->getName(
                            $formConfig->getOption('languageCode')
                        ),
                    ]
                )
                ->setAutoInitialize(false)
                ->getForm()
        );
}
```

Your type has to be called `value`.
In the example above, `CheckboxFieldType::class` is used, but you can use standard Symfony form type instead.

It's good practice to encapsulate fields with custom types as it allows easier templating.
Type has to be compatible with your field type's `Ibexa\Core\FieldType` implementation.
You can use a [`DataTransformer`]([[= symfony_doc =]]/form/data_transformers.html) to achieve that or assure correct property and form field names.

### FieldDefinitionFormMapperInterface

Providing definition editing support is almost identical to creating content editing support. The only difference are field names:

``` php
use Ibexa\AdminUi\Form\Data\FieldDefinitionData;
use Ibexa\ContentForms\Form\Type\FieldType\CountryFieldType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormInterface;

public function mapFieldDefinitionForm(FormInterface $fieldDefinitionForm, FieldDefinitionData $data)
{
    $fieldDefinitionForm
        ->add(
            'isMultiple',
            CheckboxType::class, [
                'required' => false,
                'property_path' => 'fieldSettings[isMultiple]',
                'label' => 'field_definition.ezcountry.is_multiple',
            ]
        )
        ->add(
            $fieldDefinitionForm->getConfig()->getFormFactory()->createBuilder()
                ->create(
                    'defaultValue',
                    CountryFieldType::class, [
                        'choices_as_values' => true,
                        'multiple' => true,
                        'expanded' => false,
                        'required' => false,
                        'label' => 'field_definition.ezcountry.default_value',
                    ]
                )
                // Deactivate auto-initialize as you're not on the root form.
                ->setAutoInitialize(false)->getForm()
        );
}
```

Use names corresponding to the keys used in field type's `Ibexa\Core\FieldType\FieldType::$settingsSchema` implementation.
The special `defaultValue` key allows you to specify a field for setting the default value assigned during content editing.

### Registering the service

The FormMapper must be registered as a service:

``` yaml
App\FieldType\Mapper\CustomFieldTypeMapper:
    tags:
        - { name: ibexa.admin_ui.field_type.form.mapper.definition, fieldType: custom }
        - { name: ibexa.admin_ui.field_type.form.mapper.value, fieldType: custom }
```

Tag the mapper according to the support you need to provide:

- Add the `ibexa.admin_ui.field_type.form.mapper.value` tag when providing content editing support (`FieldValueFormMapperInterface` interface).
- Add the `ibexa.admin_ui.field_type.form.mapper.definition` tag when providing field type definition editing support (`FieldDefinitionFormMapperInterface` interface).
The `fieldType` key has to correspond to the name of your field type.

## Content view templates

To render the field in content view by using the [`ibexa_render_field()` Twig helper](field_twig_functions.md#ibexa_render_field),
you need to define a template containing a block for the field.

``` html+twig
{% block customfieldtype_field %}
{# Your code here #}
{% endblock %}
```

By convention, your block must be named `<fieldTypeIdentifier>_field`.


!!! tip

    Template blocks for built-in field types are available in [`Core/Resources/views/content_fields.html.twig`](https://github.com/ibexa/core/blob/4.6/src/bundle/Core/Resources/views/content_fields.html.twig).

    This template is also exposed as a part of Standard Design, so you can override it with the [design engine](design_engine.md).
    To do so, place the template `themes/standard/content_fields.html.twig` in your `Resources/views` (assuming `ibexa_standard_design.override_kernel_templates` is set to true).

### Template variables

The block can receive the following variables:

| Name | Type | Description |
|------|------|-------------|
| `field` | `Ibexa\Contracts\Core\Repository\Values\Content\Field` | The field to display |
| `contentInfo` | `Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo` | The ContentInfo of the content item the field belongs to |
| `versionInfo` | `Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo` | The VersionInfo of the content item the field belongs to |
| `fieldSettings` | array | Settings of the field (depends on the field type) |
| `parameters` | hash | Options passed to `ibexa_render_field()` under the `'parameters'` key |
| `attr` | hash | The attributes to add the generate the HTML markup, passed to ibexa_render_field()` under the `'attr'` key. <br> Contains at least a class entry, containing <fieldtypeidentifier>-field |

### Reusing blocks

For easier field type template development you can take advantage of all defined blocks by using the [`block()` function](https://twig.symfony.com/doc/3.x/functions/block.html).

You can for example use `simple_block_field`, `simple_inline_field` or `field_attributes` blocks provided in [`content_fields.html.twig`](https://github.com/ibexa/core/blob/4.6/src/bundle/Core/Resources/views/content_fields.html.twig#L486).

!!! caution

    To be able to reuse built-in blocks, your template must inherit from `@IbexaCore/content_fields.html.twig`.

### Registering a template

If you don't use the [design engine](design_engine.md) or you want to have separate templates per field type and/or SiteAccess,
you can register a template under the `ibexa.system.<scope>.field_templates` [configuration key](configuration.md#configuration-files):

``` yaml
ibexa:
    system:
        <scope>:
            field_templates:
                -
                    template: 'fields/custom_field_template.html.twig'
                    # Priority is optional (default is 0). The higher it is, the higher your template gets in the list.
                    priority: 10
```

## Back office templates

### Back office view template

For templates for previewing the field in the back office,
using the design engine is recommended with `ibexa_standard_design.override_kernel_templates` set to `true`.
With the design engine you can apply a template (for example, `Resources/views/themes/admin/content_fields.html.twig`) without any extra configuration.

If you don't use the design engine, apply the following configuration:

``` yaml
ibexa:
    systems:
        admin_group:
            field_templates:
                - { template: 'adminui/field/custom_field_view.html.twig', priority: 10 }
```

### Field edit template

To use a template for the field edit form in the back office, you need to specify it in configuration
under the `twig.form_themes` [configuration key](configuration.md#configuration-files):

``` yaml
twig:
    form_themes:
        - 'adminui/field/custom_field_template.html.twig'
```

We encourage using custom form types for encapsulation as this makes templating easier by providing Twig block name.
All built-in field types are implemented with this approach. In that case overriding form theme can be done with:

``` html+twig
{% block custom_fieldtype_widget %}
    Hello world!
    {{ block('form_widget') }}
{% endblock %}
```

For more information on creating and overriding form type templates, see [Symfony documentation]([[= symfony_doc =]]/form/create_custom_field_type.html#creating-the-form-type-template).
