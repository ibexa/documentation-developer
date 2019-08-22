# Step 3 -  Create form for editing Field Type

!!! tip

    You can find all files used and modified in this step on [GitHub]().

## Create a form

Create `Point2DType.php` form in `src/Form/Type` directory. 
Add a `Point2DType` class that extends `abstractType` to it.
Next implement the `buildForm`. This method adds fields for `x` and `y` coordinates.
It allows you to skip implementation of Data Transformer.
Finally set `data_class` to `Value::class`.

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

## Add Form Mappper Interface

Add `FieldValueFormMappperInterface` interface (`EzSystems\RepositoryForms\FieldType\FieldValueFormMapperInterface`) to Field Type definition in ` src/FieldType/Point2D/Type.php`.

Final version of the Type class should have the following `use` statements:

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

To content edition form add a field that will allow you to add values to your Field Type `src/Form/Type/Point2DType.php`

TODO: check code

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

## Add new class

Next, add the `ezplatform.field_type.form_mapper.value` class to `config/services.yml`:

```yaml
App\FieldType\Point2D\Type:
    tags:
        - { name: ezplatform.field_type, alias: point2d }
        - { name: ezplatform.field_type.form_mapper.value, fieldType: point2d }
```
