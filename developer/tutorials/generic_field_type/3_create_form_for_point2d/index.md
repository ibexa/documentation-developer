# Step 3 - Create a form for editing field type

Learn how to create a form used for editing a custom field definition.

## Create a form

To edit your new field type, create a `Point2DType.php` form in the `src/Form/Type` directory. Next, add a `Point2DType` class that extends the `AbstractType` and implements the `buildForm()` method. This method adds fields for `x` and `y` coordinates.

```php
<?php
declare(strict_types=1);

namespace App\Form\Type;

use App\FieldType\Point2D\Value;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class Point2DType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('x', NumberType::class);
        $builder->add('y', NumberType::class);
    }
}
```

## Add a Form Mapper Interface

The FormMapper adds the field definitions into Symfony forms using the `add()` method. The `FieldValueFormMapperInterface` provides an edit form for your field type in the administration interface.

For more information about the FormMappers, see [field type form and template](../../../content_management/field_types/form_and_template/index.md).

First, implement a `FieldValueFormMapperInterface` interface (`Ibexa\Contracts\ContentForms\FieldType\FieldValueFormMapperInterface`) to field type definition in the `src/FieldType/Point2D/Type.php`.

Next, implement a `mapFieldValueForm()` method and invoke `FormInterface::add` method with the following arguments (highlighted lines):

- Name of the property the field value maps to: `value`
- Type of the field: `Point2DType::class`
- Custom options: `required` and `label`

Final version of the Type class should have the following statements and functions:

```php
<?php
declare(strict_types=1);

namespace App\FieldType\Point2D;

use App\Form\Type\Point2DType;
use Ibexa\Contracts\ContentForms\Data\Content\FieldData;
use Ibexa\Contracts\ContentForms\FieldType\FieldValueFormMapperInterface;
use Ibexa\Contracts\Core\FieldType\Generic\Type as GenericType;
use Symfony\Component\Form\FormInterface;

final class Type extends GenericType implements FieldValueFormMapperInterface
{
    public function getFieldTypeIdentifier(): string
    {
        return 'point2d';
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

Finally, add a `configureOptions` method and set default value of `data_class` to `Value::class` in `src/Form/Type/Point2DType.php`. It allows your form to work on this object.

```php
<?php
declare(strict_types=1);

namespace App\Form\Type;

use App\FieldType\Point2D\Value;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class Point2DType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('x', NumberType::class);
        $builder->add('y', NumberType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Value::class,
        ]);
    }
}
```

## Add a new tag

Next, add the `ibexa.admin_ui.field_type.form.mapper.value` tag to `config/services.yaml`:

```yaml
    App\FieldType\Point2D\Type:
        tags:
            - { name: ibexa.field_type, alias: point2d }
            - { name: ibexa.admin_ui.field_type.form.mapper.value, fieldType: point2d }
```
