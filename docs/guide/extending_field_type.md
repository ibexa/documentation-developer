# Creating custom Field Type

Generic Field Type can be used as a template for any Field Type you want to create.
It makes creation and customization process easier and faster.
Generic Field Type can be especially useful during customization of such fields as:
language, currency, birth date etc.

Generic Field Type comes with the implementation of basic methods,
reduces the number of classes which must be created and simplifies tagging process.
Base implementation uses Symfony serializer and Symfony validator component.

!!! tip

    Generic Field Type should not be used when a very specific implementation is needed or the way data is stored requires thorough control.

Simplified process of creating custom Field Type based on Generic Field Type:

- Define Value Object
- Define fields and configuration
- Define form for Value Object
- Render fields
- Final results

## Define Value Object

Create `Value.php` inside `src/FieldType/HelloWorld` directory.
The Value class of a Field Type is very simple.
It contains only basic logic, because the rest of the logic is handled by the `Type` class.
The `HelloWorld` Value class should contain:

- public properties that retrieve `name`
- an implementation of the `__toString()` method

```php
<?php
/* /src/FieldType/HelloWorld/Value.php */
//Properties of the class Value
{
    private $name;
  
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(?string $name): void
    {
        $this->name = $name;
    }
    
    public function __toString()
    {
        return "Hello {$this->name}!";
    }
}
```

## Define fields and configuration

In this step you will implement definition of a Field Type extending Generic Field Type in `src/FieldType/HelloWorld/Type.php` class.

```php
<?php
namespace App\FieldType\HelloWorld;

use eZ\Publish\SPI\FieldType\Generic\Type as GenericType;

final class Type extends GenericType implements FieldValueFormMapperInterface
{
    public function getFieldTypeIdentifier(): string
    {
        return 'hello_world';
    }
}
```

Next, add the `ezplatform.field_type` class to the `config/services.yaml`:

```yaml
App\FieldType\HelloWorld\Type:
    tags:
        - { name: ezplatform.field_type, alias: hello_world }
```

## Define form for Value Object

Create `src/Form/Type/HelloWorldType.php` form:

```php
<?php
declare(strict_types=1);
namespace App\Form\Type;
use App\FieldType\HelloWorld\Value;
use AppBundle\FieldType\HelloWorld\Value;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
final class HelloWorldType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('name', TextType::class);
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Value::class
        ]);
    }
}
```

Add `FieldValueFormMappperInterface` interface (`EzSystems\RepositoryForms\FieldType\FieldValueFormMapperInterface`) to Field Type definition in `src/FieldType/HellowWorld/Type.php`:

```php
<?php
namespace App\FieldType\HelloWorld;

use App\Form\Type\HelloWorldType;
use eZ\Publish\SPI\FieldType\Generic\Type as GenericType;
use EzSystems\RepositoryForms\Data\Content\FieldData;
use EzSystems\RepositoryForms\FieldType\FieldValueFormMapperInterface;
use Symfony\Component\Form\FormInterface;

final class Type extends GenericType implements FieldValueFormMapperInterface
{
    ...
    public function mapFieldValueForm(FormInterface $fieldForm, FieldData $data): void
    {
        $definition = $data->fieldDefinition;
        $fieldForm->add('value', HelloWorldType::class, [
            'required' => $definition->isRequired,
            'label' => $definition->getName()
        ]);
    }
}
```

Next, add the `ezplatform.field_type.form_mapper.value` class to `config/services.yml`:

```yaml
App\FieldType\HelloWorld\Type:
    tags:
        - { name: ezplatform.field_type.form_mapper.value, fieldType: hello_world }
```

## Render fields

### Create a template

Create the template for new Field Type. It will define the default display of `HelloWorld` field.
In `templates` directory create `field_type.html.twig` file.
Inside add a following code block:

```html+twig
{% block hello_world_field %}
    Hello <b>{{ field.value.getName() }}!</b>
{% endblock %}
```

### Template mapping

Provide the template mapping in `config/packages/ezplatform.yaml`:

```yaml
ezpublish:
    system:
        default: 
            # ...
            field_templates:
                - { template: 'field_type.html.twig', priority: 0 }
```

## Final results

Finally, you should be able to add a new Content Type in the Back Office interface.
