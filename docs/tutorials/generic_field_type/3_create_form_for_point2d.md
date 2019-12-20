# Step 3 - Create form for editing Field Type

!!! tip

    You can find all files used and modified in this step on [GitHub](https://github.com/ezsystems/generic-field-type-tutorial/tree/Step_3).

## Create a form

To edit your new Field Type, create a `Point2DType.php` form in the `src/Form/Type` directory.
Next, add a `Point2DType` class that extends the `AbstractType` and implements the `buildForm()` method.
This method adds fields for `x` and `y` coordinates.

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

The FormMapper adds the Field definitions into Symfony forms using the `add()` method. 
The `FieldValueFormMapperInterface` provides an edit form for your Field Type in the administration interface.
For more information about the FormMappers, see [Field Type form and template](../../api/field_type_form_and_template.md).

First, implement a `FieldValueFormMapperInterface` interface (`EzSystems\EzPlatformContentForms\FieldType\FieldValueFormMapperInterface`) to Field Type definition in the `src/FieldType/Point2D/Type.php`.

Next, implement a `mapFieldValueForm()` method and invoke `FormInterface::add` method with the following arguments (highlighted lines):

- Name of the property the Field value will map to: `value`
- Type of the Field: `Point2DType::class`
- Custom options: `required` and `label`

Final version of the Type class should have the following statements and functions:

```php hl_lines="16 17 18 19 20 21 22 23"
<?php
namespace App\FieldType\Point2D;

use App\Form\Type\Point2DType;
use eZ\Publish\SPI\FieldType\Generic\Type as GenericType;
use EzSystems\EzPlatformContentForms\Data\Content\FieldData;
use EzSystems\EzPlatformContentForms\FieldType\FieldValueFormMapperInterface;
use Symfony\Component\Form\FormInterface;

final class Type extends GenericType implements FieldValueFormMapperInterface
{
    public function getFieldTypeIdentifier(): string
    {
        return 'point2d';
    }
    public function mapFieldValueForm(FormInterface $fieldForm, FieldData $data)
    {
        $definition = $data->fieldDefinition;
        $fieldForm->add('value', Point2DType::class, [
            'required' => $definition->isRequired,
            'label' => $definition->getName()
        ]);
    }
}
```

Finally, add a `configureOptions` method and set default value of `data_class` to `Value::class`. It will allow your form to work on this object.

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
            'data_class' => Value::class
        ]);
    }
}
```

## Add a new tag

Next, add the `ezplatform.field_type.form_mapper.value` tag to `config/services.yaml`:

```yaml hl_lines="4"
App\FieldType\Point2D\Type:
    tags:
        - { name: ezplatform.field_type, alias: point2d }
        - { name: ezplatform.field_type.form_mapper.value, fieldType: point2d }
```
