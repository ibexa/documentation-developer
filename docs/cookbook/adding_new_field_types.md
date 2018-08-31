# Adding new Field Types

!!! tip

    This page describes the changes to creating new Field Types introduced in the v2.0.0 version.

    For a full description of the Field Type API see [Field Type API and best practices](../api/field_type_api.md).

## 1. Create FormMapper

Your mapper has to implement two interfaces:

- `EzSystems\RepositoryForms\FieldType\Mapper\FieldValueFormMapperInterface` to provide editing support
- `EzSystems\RepositoryForms\FieldType\FieldDefinitionFormMapperInterface` to provide Field Type definition editing support

### 1.1. FieldValueFormMapperInterface

`FieldValueFormMapperInterface::mapFieldValueForm` method accepts 2 arguments:
`FormInterface $fieldForm` and `FieldData $data`.
You have to add your form type to the content editing form. Refer to the listing below showing how `ezboolean` injects the form:

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

It's a good practice to encapsulate Fields with custom types as it allows easier templating.
Type has to be compatible with your Field Type's `eZ\Publish\Core\FieldType\Value` implementation.
You can use a `DataTransformer` to achieve that or just assure correct property and form field names.

### 1.2. FieldDefinitionFormMapperInterface

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
                // Deactivate auto-initialize as we're not on the root form.
                ->setAutoInitialize(false)->getForm()
        );
}
```

Use names corresponding to the keys used in Field Type's `eZ\Publish\SPI\FieldType\FieldType::$settingsSchema` implementation.
Special key `defaultValue` allows you to specify a field for setting default value assigned during content editing.

## 2. Service definition

The next step is to provide a service definition for the previously created FormMapper:

``` yaml
EzSystems\RepositoryForms\FieldType\Mapper\CheckboxFormMapper:
    tags:
        - { name: ez.fieldFormMapper.definition, fieldType: ezboolean }
        - { name: ez.fieldFormMapper.value, fieldType: ezboolean }
```

As you can see in the example above it's necessary to tag services using `ez.fieldFormMapper.value` when providing content editing support (`FieldValueFormMapperInterface` interface) and  `ez.fieldFormMapper.definition` when providing Field Type definition editing support (`FieldDefinitionFormMapperInterface` interface). The `fieldType` key has to correspond to the name of your Field Type.

## 3. Templating

At this point you are able to edit Field Type value but in some cases you might be interested in providing customized form theme. The procedure is the same as described in [Symfony's documentation](https://symfony.com/doc/current/form/form_customization.html).

We encourage using custom form types for encapsulation as this makes templating easier by providing Twig block name. All eZ Platform Field Types are implemented with this approach. In that case overriding form theme can be done with:

```html
{% block my_fieldtype_widget %}
    Hello world!
    {{ block('form_widget') }}
{% endblock %}
```

## 4. More examples

For best practices refer directly to the codebase:

* FormMappers: https://github.com/ezsystems/repository-forms/tree/master/lib/FieldType/Mapper
* Form theming: https://github.com/ezsystems/ezplatform-admin-ui/tree/master/src/bundle/Resources/views/fieldtypes
