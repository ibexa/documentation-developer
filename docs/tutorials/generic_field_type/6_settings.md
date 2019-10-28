# Step 6 - Implement Point 2D settings

Implementing settings enables you to define in what format the Field is shown on the page.
To do so, you will create the `format` field where you will be able to change the way coordinates for Point 2D are displayed.

## Define Field Type format

In this step you will create the `format` field for Point 2D coordinates.
To do that, you need to define a `SettingsSchema` definition.
The coordinates should be displayed as strings with default names `x` and `y`.

Open `src/FieldType/Point2D/Type.php` and change it according to the following code block:

```php
<?php
namespace App\FieldType\Point2D;

use App\Form\Type\Point2DSettingsType;
use eZ\Publish\API\Repository\Values\ContentType\FieldDefinition;
use eZ\Publish\SPI\FieldType\Value;
use EzSystems\RepositoryForms\Data\FieldDefinitionData;


final class Type extends GenericType implements FieldValueFormMapperInterface
{
    public function getSettingsSchema(): array
    {
        return [
            'format' => [
                'type' => 'string',
                'default' => '(%x%, %y%)',
            ],
        ];
    }
}
```

## Add a format field

Define `Point2DSettingsType` class and add `format` field in `src/Form/Type/Point2DSettingsType.php`:

```php
<?php
declare(strict_types=1);
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

...

final class Point2DSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('format', TextType::class);
    }
}
```

## FieldDefinitionFormMapper Interface

Now, enable the user to add the coordinates which will be validated.
In `src/FieldType/Point2D/Type.php` you will:
 
- inject the `FieldDefinitionFormMapperInterface` extension implementing `EzSystems\RepositoryForms\FieldType\FieldDefinitionFormMapperInterface`
- add a `mapFieldDefinitionForm` at the end, it will define the field settings

```php
<?php
namespace App\FieldType\Point2D;

use EzSystems\RepositoryForms\FieldType\FieldDefinitionFormMapperInterface;

// ...

final class Type extends GenericType implements FieldValueFormMapperInterface, FieldDefinitionFormMapperInterface

// ...

    public function mapFieldDefinitionForm(FormInterface $fieldDefinitionForm, FieldDefinitionData $data)
    {
        $fieldDefinitionForm->add('fieldSettings', Point2DSettingsType::class, [
            'label' => false
        ]);
    }
```

## Add a new tag

Next, add `FieldDefinitionFormMapper` as an extra tag definition in `config/services.yaml`:

```yaml
tags:
    - { name: ezplatform.field_type.form_mapper.definition, fieldType: point2d }
```

## Field Type definition

To be able to display the new `format` field, you need to add a template for it.
Create `templates/field_type_definition.html.twig`:

```html+twig
{% block point2d_field_definition_edit %}
    <div class="{% if group_class is not empty %}{{ group_class }}{% endif %}">
        {{- form_label(form.fieldSettings.format) -}}
        {{- form_errors(form.fieldSettings.format) -}}
        {{- form_widget(form.fieldSettings.format) -}}
    </div>
{% endblock %}
```

### Add configuration for the format field

Next, provide the template mapping in `config/packages/ezplatform.yaml`:

```yaml
system:
    default:
        ...
        fielddefinition_edit_templates:
            - { template: 'field_type_definition.html.twig', priority: 0 }
```

## Redefine template

Finally redefine the Point 2D template so it accommodates the new `format` field.

In `templates/field_type.html.twig` replace the content with:

```html+twig
{% block point2d_field %}
    {{ fieldSettings.format|replace({
        '%x%': field.value.x,
        '%y%': field.value.y
    }) }}
{% endblock %}
```

## Add a new Content Type

Now, you can go to the Back-Office Admin Panel and see the results of your work by adding a new Content Type.

![Point 2D definition with format field](img/field_definition_format_field.png)
