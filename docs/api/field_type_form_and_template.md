---
description: Field Type FormMappers allow Field editing, while custom templates ensure the Field can be rendered both in the Back office and on site front.
---

# Field Type form and template

## FormMapper

The FormMapper maps Field definitions into Symfony forms, allowing Field editing.

It can implement two interfaces:

- `EzSystems\EzPlatformContentForms\FieldType\FieldValueFormMapperInterface` to provide editing support
- `EzSystems\EzPlatformAdminUi\FieldType\FieldDefinitionFormMapperInterface` to provide Field Type definition editing support,
when you require non-standard settings

### FieldValueFormMapperInterface

The `FieldValueFormMapperInterface::mapFieldValueForm` method accepts two arguments:

- `FormInterface` — form for the current Field
- `FieldData` — underlying data for current field form

You have to add your form type to the content editing form. The example shows how `ezboolean` injects the form:

``` php
use EzSystems\EzPlatformContentForms\Data\Content\FieldData;
use EzSystems\RepositoryForms\Form\Type\FieldType\CheckboxFieldType;
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

It's good practice to encapsulate Fields with custom types as it allows easier templating.
Type has to be compatible with your Field Type's `eZ\Publish\Core\FieldType\Value` implementation.
You can use a [`DataTransformer`]([[= symfony_doc =]]/form/data_transformers.html) to achieve that or just assure correct property and form field names.

### FieldDefinitionFormMapperInterface

Providing definition editing support is almost identical to creating content editing support. The only difference are field names:

``` php
use EzSystems\RepositoryForms\Data\FieldDefinitionData;
use EzSystems\RepositoryForms\Form\Type\FieldType\CountryFieldType;
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

Use names corresponding to the keys used in Field Type's `eZ\Publish\SPI\FieldType\FieldType::$settingsSchema` implementation.
The special `defaultValue` key allows you to specify a field for setting the default value assigned during content editing.

### Registering the service

The FormMapper must be registered as a service:

``` yaml
App\FieldType\Mapper\CustomFieldTypeMapper:
    tags:
        - { name: ezplatform.field_type.form_mapper.definition, fieldType: custom }
        - { name: ezplatform.field_type.form_mapper.value, fieldType: custom }
```

Tag the mapper according to the support you need to provide:

- Add the `ezplatform.field_type.form_mapper.value` tag when providing content editing support (`FieldValueFormMapperInterface` interface).
- Add the `ezplatform.field_type.form_mapper.definition` tag when providing Field Type definition editing support (`FieldDefinitionFormMapperInterface` interface).
The `fieldType` key has to correspond to the name of your Field Type.

## Content view templates

To render the Field in content view by using the [`ez_render_field()` Twig helper](../guide/content_rendering/twig_function_reference/field_twig_functions.md#ez_render_field),
you need to define a template containing a block for the Field.

``` html+twig
{% block customfieldtype_field %}
{# Your code here #}
{% endblock %}
```

By convention, your block must be named `<fieldTypeIdentifier>_field`.


!!! tip

    Template blocks for built-in Field Types are available in
    [`EzPublishCoreBundle/Resources/views/content_fields.html.twig`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig).

    This template is also exposed as a part of Standard Design, so you can override it with the [design engine](../guide/content_rendering/design_engine/design_engine.md).
    To do so, place the template `themes/standard/content_fields.html.twig` in your `Resources/views`
    (assuming `ez_platform_standard_design.override_kernel_templates` is set to true).

### Template variables

The block can receive the following variables:

| Name | Type | Description |
|------|------|-------------|
| `field` | `eZ\Publish\API\Repository\Values\Content\Field` | The field to display |
| `contentInfo` | `eZ\Publish\API\Repository\Values\Content\ContentInfo` | The ContentInfo of the Content item the Field belongs to |
| `versionInfo` | `eZ\Publish\API\Repository\Values\Content\VersionInfo` | The VersionInfo of the Content item the Field belongs to |
| `fieldSettings` | array | Settings of the Field (depends on the Field Type) |
| `parameters` | hash | Options passed to `ez_render_field()` under the `'parameters'` key |
| `attr` | hash | The attributes to add the generate the HTML markup, passed to ez_render_field()` under the `'attr'` key. <br> Contains at least a class entry, containing <fieldtypeidentifier>-field |

### Reusing blocks

For easier Field Type template development you can take advantage of all defined blocks by using the [`block()` function](http://twig.sensiolabs.org/doc/functions/block.html).

You can for example use `simple_block_field`, `simple_inline_field` or `field_attributes` blocks provided in [`content_fields.html.twig`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig#L477).

!!! caution

    To be able to reuse built-in blocks, your template must inherit from `@EzPublishCore/content_fields.html.twig`.

### Registering a template

If you don't use the [design engine](../guide/content_rendering/design_engine/design_engine.md) or you want to have separate templates per Field Type and/or SiteAccess,
you can register a template with the following configuration:

``` yaml
ezplatform:
    system:
        <siteaccess>:
            field_templates:
                -
                    template: 'fields/custom_field_template.html.twig'
                    # Priority is optional (default is 0). The higher it is, the higher your template gets in the list.
                    priority: 10
```

## Back Office templates

### Back Office view template

For templates for previewing the Field in the Back Office,
using eZ Design is recommended with `ez_platform_standard_design.override_kernel_templates` set to `true`.
With eZ Design you can apply a template (e.g. `Resources/views/themes/admin/content_fields.html.twig`) without any extra configuration.

If you do not use eZ Design, apply the following configuration:

``` yaml
ezplatform:
    systems:
        admin_group:
            field_templates:
                - { template: 'adminui/field/custom_field_view.html.twig', priority: 10 }
```

### Field edit template

To use a template for the Field edit form in the Back Office, you need to specify it in configuration
under the `twig.form_themes` key:

``` yaml
twig:
    form_themes:
        - 'adminui/field/custom_field_template.html.twig'
```

We encourage using custom form types for encapsulation as this makes templating easier by providing Twig block name.
All built-in Field Types are implemented with this approach. In that case overriding form theme can be done with:

``` html+twig
{% block custom_fieldtype_widget %}
    Hello world!
    {{ block('form_widget') }}
{% endblock %}
```

!!! tip

    For more information on creating and overriding form type templates, see [Symfony documentation]([[= symfony_doc =]]/form/create_custom_field_type.html#creating-the-form-type-template).
