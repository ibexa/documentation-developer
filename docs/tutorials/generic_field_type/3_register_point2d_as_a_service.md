# Step 3 - Create form for editing Field Type

!!! tip

    You can find all files used and modified in this step on [GitHub]().

## Create a form

To edit your new Field Type, create a `Point2DType.php` form in the `src/Form/Type` directory.
Next, add a `Point2DType` class that extends the `AbstractType` and implements the `buildForm()` method.
This method adds fields for `x` and `y` coordinates.
It also enables you to skip implementation of Data Transformer.

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
You will add it to be able to edit the fields later on.
For more information about the FormMappers, see [Field Type form and template](../../api/field_type_form_and_template.md).

First, add a `FieldValueFormMapperInterface` interface (`EzSystems\RepositoryForms\FieldType\FieldValueFormMapperInterface`) to Field Type definition in the `src/FieldType/Point2D/Type.php`.

Next, add a `mapFieldValueForm()` with the following arguments:

- Name of the property the Field value will map to: `value`
- Type of the Field: `Point2DType::class`
- Custom options: `required` and `label`

Final version of the Type class should have the following statements and functions:

```php
<?php
namespace App\FieldType\Point2D;

use App\Form\Type\Point2DType;
use eZ\Publish\SPI\FieldType\Generic\Type as GenericType;
use EzSystems\RepositoryForms\Data\Content\FieldData;
use EzSystems\RepositoryForms\FieldType\FieldValueFormMapperInterface;
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

Finally, add a field that will enable you to add values to the Field Type in the content edition form in `src/Form/Type/Point2DType.php`:

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

## Add a new class

Next, add the `ezplatform.field_type.form_mapper.value` class to `config/services.yaml`:

```yaml
App\FieldType\Point2D\Type:
    tags:
        - { name: ezplatform.field_type, alias: point2d }
        - { name: ezplatform.field_type.form_mapper.value, fieldType: point2d }
```
