# Step 6 - Implement Point 2D settings

Learn how to add settings that format the field value.

Implementing settings enables you to define the format for displaying the field on the page. To do so, create the `format` field where you're able to change the way coordinates for Point 2D are displayed.

## Define field type format

In this step you create the `format` field for Point 2D coordinates. To do that, you need to define a `SettingsSchema` definition. You also specify coordinates as placeholder values `%x%` and `%y%`.

Open `src/FieldType/Point2D/Type.php` and add a `getSettingsSchema` method according to the following code block:

```php
<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;

use App\Form\Type\Point2DType;
use Ibexa\Contracts\ContentForms\Data\Content\FieldData;
use Ibexa\Contracts\Core\FieldType\Generic\Type as GenericType;
use Symfony\Component\Form\FormInterface;

final class Type extends GenericType
{
    public function getFieldTypeIdentifier(): string
    {
        return 'point2d';
    }

    #[\Override]
    public function getSettingsSchema(): array
    {
        return [
            'format' => [
                'type' => 'string',
                'default' => '(%x%, %y%)',
            ],
        ];
    }

    public function mapFieldValueForm(FormInterface $fieldForm, FieldData $data): void
    {
        $definition = $data->getFieldDefinition();
        $fieldForm->add('value', Point2DType::class, [
            'required' => $definition->isRequired,
            'label' => $definition->getName(),
        ]);
    }
}
```

## Add a format field

In this part you define and implement the edit form for your field type.

Define a `Point2DSettingsType` class and add a `format` field in `src/Form/Type/Point2DSettingsType.php`:

```php
<?php
declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class Point2DSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('format', TextType::class);
    }
}
```

## FieldDefinitionFormMapper Interface

Now, enable the user to add the coordinates which are validated. In `src/FieldType/Point2D/Type.php` you:

- implement the `FieldDefinitionFormMapperInterface` interface
- add a `mapFieldDefinitionForm` method at the end that defines the field settings

```php
<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;
// ...
use Ibexa\AdminUi\FieldType\FieldDefinitionFormMapperInterface;
use Ibexa\AdminUi\Form\Data\FieldDefinitionData;
use Ibexa\Contracts\ContentForms\FieldType\FieldValueFormMapperInterface;
use Ibexa\Contracts\Core\FieldType\Generic\Type as GenericType;
use Symfony\Component\Form\FormInterface;

final class Type extends GenericType implements FieldValueFormMapperInterface, FieldDefinitionFormMapperInterface
{
// ...  
    public function mapFieldDefinitionForm(FormInterface $fieldDefinitionForm, FieldDefinitionData $data): void
    {
        $fieldDefinitionForm->add('fieldSettings', Point2DSettingsType::class, [
            'label' => false,
        ]);
    }
}
```

Complete Type.php code

```php
<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;

use App\Form\Type\Point2DSettingsType;
use App\Form\Type\Point2DType;
use Ibexa\AdminUi\FieldType\FieldDefinitionFormMapperInterface;
use Ibexa\AdminUi\Form\Data\FieldDefinitionData;
use Ibexa\Contracts\ContentForms\Data\Content\FieldData;
use Ibexa\Contracts\ContentForms\FieldType\FieldValueFormMapperInterface;
use Ibexa\Contracts\Core\FieldType\Generic\Type as GenericType;
use Symfony\Component\Form\FormInterface;

final class Type extends GenericType implements FieldValueFormMapperInterface, FieldDefinitionFormMapperInterface
{
    public function getFieldTypeIdentifier(): string
    {
        return 'point2d';
    }

    #[\Override]
    public function getSettingsSchema(): array
    {
        return [
            'format' => [
                'type' => 'string',
                'default' => '(%x%, %y%)',
            ],
        ];
    }

    public function mapFieldValueForm(FormInterface $fieldForm, FieldData $data): void
    {
        $definition = $data->getFieldDefinition();
        $fieldForm->add('value', Point2DType::class, [
            'required' => $definition->isRequired,
            'label' => $definition->getName(),
        ]);
    }

    public function mapFieldDefinitionForm(FormInterface $fieldDefinitionForm, FieldDefinitionData $data): void
    {
        $fieldDefinitionForm->add('fieldSettings', Point2DSettingsType::class, [
            'label' => false,
        ]);
    }
}
```

## Add a new tag

Next, add `FieldDefinitionFormMapper` as an extra tag definition for `App\FieldType\Point2D\Type` in `config/services.yaml`:

```yaml
    App\FieldType\Point2D\Type:
        tags:
            - { name: ibexa.field_type, alias: point2d }
            - { name: ibexa.admin_ui.field_type.form.mapper.value, fieldType: point2d }
            - { name: ibexa.admin_ui.field_type.form.mapper.definition, fieldType: point2d }
```

## Field type definition

To be able to display the new `format` field, you need to add a template for it. Create `templates/point2d_field_type_definition.html.twig`:

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

Next, provide the template mapping in `config/packages/ibexa.yaml`:

```yaml
ibexa:
    system:
        default:
            field_templates:
                - { template: 'point2d_field.html.twig', priority: 0 }
            fielddefinition_edit_templates:
                - { template: 'point2d_field_type_definition.html.twig', priority: 0 }
```

## Redefine template

Finally, redefine the Point 2D template, so it accommodates the new `format` field.

In `templates/point2d_field.html.twig` replace the content with:

```html+twig
{% block point2d_field %}
    {{ fieldSettings.format|replace({
        '%x%': field.value.x,
        '%y%': field.value.y
    }) }}
{% endblock %}
```

## Edit the content type

Now, in the back office, you can go to **Content types** and see the results of your work by editing the Point 2D content type.

> **Tip: Tip**
>
> If you cannot see the results or encounter an error, clear the cache and reload the application.

Add new format `(%x%, %y%)` in the **Format** field as shown in the screen below.

![Point 2D definition with format field](https://doc.ibexa.co/en/5.0/tutorials/generic_field_type/img/field_definition_format_field.png)
