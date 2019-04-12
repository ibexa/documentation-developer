# Field Type form and template

## FormMapper

The FormMapper maps Field definitions into Symfony forms, allowing Field editing.

It has to implement two interfaces:

- `EzSystems\RepositoryForms\FieldType\Mapper\FieldValueFormMapperInterface` to provide editing support
- `EzSystems\RepositoryForms\FieldType\FieldDefinitionFormMapperInterface` to provide Field Type definition editing support

### FieldValueFormMapperInterface

The `FieldValueFormMapperInterface::mapFieldValueForm` method accepts two arguments:
`FormInterface $fieldForm` and `FieldData $data`.

You have to add your form type to the content editing form. The example shows how `ezboolean` injects the form:

``` php
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
You can use a `DataTransformer` to achieve that or just assure correct property and form field names.

### FieldDefinitionFormMapperInterface

Providing definition editing support is almost identical to creating content editing support. The only difference are field names:

``` php
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
            // Creating from FormBuilder as we need to add a DataTransformer.
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
Special key `defaultValue` allows you to specify a field for setting default value assigned during content editing.

### Registering the service

The FormMapper must be registered as a service:

``` yaml
Acme\ExampleBundle\FieldType\Mapper\CustomFieldTypeMapper:
    tags:
        - { name: ez.fieldFormMapper.definition, fieldType: custom }
        - { name: ez.fieldFormMapper.value, fieldType: custom }
```

Services must be tagged with `ez.fieldFormMapper.value` when providing content editing support (`FieldValueFormMapperInterface` interface)
and with `ez.fieldFormMapper.definition` when providing Field Type definition editing support (`FieldDefinitionFormMapperInterface` interface).
The `fieldType` key has to correspond to the name of your Field Type.

## Content view templates

To render the Field in content view using the [`ez_render_field()` Twig helper](../guide/twig_functions_reference.md#ez_render_field),
you need to define a template containing a block for the Field.

``` html+twig
{% block customfieldtype_field %}
{# Your code here #}
{% endblock %}
```

By convention, your block must be named `<fieldTypeIdentifier>_field`.


!!! tip

    Template blocks for built-in Field Types are available in
    [`EzPublishCoreBundle/Resources/views/content_fields.html.twig`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.0/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig)

### Template variables

The block can receive the following variables:

| Name | Type | Description |
|------|------|-------------|
| `field` | `eZ\Publish\API\Repository\Values\Content\Field` | The field to display |
| `contentInfo` | `eZ\Publish\API\Repository\Values\Content\ContentInfo` | The ContentInfo of the Content item the Field belongs to |
| `versionInfo` | `eZ\Publish\API\Repository\Values\Content\VersionInfo` | The VersionInfo of the Content item the Field belongs to |
| `fieldSettings` | mixed | Settings of the Field (depends on the Field Type) |
| `parameters` | hash | Options passed to `ez_render_field()` under the parameters key |
| `attr` | hash | The attributes to add the generate the HTML markup. Contains at least a class entry, containing <fieldtypeidentifier>-field |

### Reusing blocks

For easier Field Type template development you can take advantage of all defined blocks by using the [`block()` function](http://twig.sensiolabs.org/doc/functions/block.html).

You can for example use `simple_block_field`, `simple_inline_field` or `field_attributes` blocks provided in [`content_fields.html.twig`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.0/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig#L496).

!!! caution

    To be able to reuse built-in blocks, your template must inherit from `EzPublishCoreBundle::content_fields.html.twig`.

### Registering your template

To make your template available, you must register it in the system.

``` yaml
ezpublish:
    system:
        <siteaccess>:
            field_templates:
                -
                    template: 'AcmeExampleBundle:fields:custom_field_template.html.twig'
                    # Priority is optional (default is 0). The higher it is, the higher your template gets in the list.
                    priority: 10
```

## Back Office templates

### Back Office view template

You can use a separate template for previewing the Field in the Back Office by specifying:

``` yaml
ezpublish:
    systems:
        admin_group:
            field_templates:
                - { template: 'AcmeExampleBundle:adminui/field:custom_field_view.html.twig', priority: 10 }
```

### Field edit template

To use a template for the Field edit form in the Back Office, you need to specify it in configuration
under the `twig.form_themes` key:

``` yaml
twig:
    form_themes:
        - 'AcmeExampleBundle:adminui/field:custom_field_template.html.twig'
```

We encourage using custom form types for encapsulation as this makes templating easier by providing Twig block name.
All built-in Field Types are implemented with this approach. In that case overriding form theme can be done with:

``` html+twig
{% block custom_fieldtype_widget %}
    Hello world!
    {{ block('form_widget') }}
{% endblock %}
```
