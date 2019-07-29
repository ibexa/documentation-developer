# Creating custom Field Type

Generic Field Type can be used as a template for any Field Type you would like to create.
It makes creation and customization process easier and faster.
Generic Field Type can be especially useful during customization of such fields as: language, currency, birth date etc.

Generic Field Type comes with the implementation of basic methods, reduces the number of classes which must be created and simplifies tagging process.
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

To begin, you need a clean installation of eZ Platform.

Create `Value.php` inside `src/FieldType/HelloWorld` directory.
The Value class of a Field Type is very simple.
It contains only basic logic, because the rest of the logic is handled by the `Type` class.
The `HelloWorld` Value class should contain:

- public properties that retrieve name
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

In this step you will implement definition of a Field Type extending Generic Field Type in `Value.php` `Type` class.

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

Add a new `App\Type` class in `config/services.yaml`

```yaml
App\FieldType\HelloWorld\Type:
    tags:
        - { name: ezplatform.field_type, alias: hello_world }
```

## Define form for Value Object

To define form for your Field Type create `src/Form/Type` directory.  

Formularz stworzyc w katalogu `src/Form/Type` tam dodac klase `Point2DType` (extends abstractType, zaimplementowac BuildForm)
Wazne: metoda BuildForm dodaje pola, w ktore bedzie sie wprowadzac wspolrzedne x i y
Pozwala uniknac implementacji Data Transformera, 
ustawic opcje data class na Value::class

- dodac do definicji FT, dodajemy interfejs `FieldValueFormMappperInterface` (`\EzSystems\RepositoryForms\FieldType\FieldValueFormMapperInterface`)

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
    public function getFieldTypeIdentifier(): string
    {
        return 'hello_world';
    }
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

- do formularza edycji tresci dodajemy pole pozwalajace wprowadzic wartosc dla naszego FT
`src/Form/Type/HelloWorld.php`

```php
<?php
/* /src/AppBundle/FieldType/HelloWorld/Type.php */
namespace AppBundle\FieldType\HelloWorld;
use AppBundle\Form\Type\HelloWorldType;
use eZ\Publish\Core\FieldType\Generic\Type as GenericType;
use EzSystems\RepositoryForms\Data\Content\FieldData;
use EzSystems\RepositoryForms\FieldType\FieldValueFormMapperInterface;
use Symfony\Component\Form\FormInterface;
final class Type extends GenericType implements FieldValueFormMapperInterface
{
    public function getFieldTypeIdentifier(): string
    {
        return 'hello_world';
    }
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

- dodac kolejny tag do definicji serwisu: ` - { name: ezplatform.field_type.form_mapper.value, fieldType: point2d }`

in `config/services.yaml`

```yaml
App\FieldType\HelloWorld\Type:
    tags:
        - { name: ezplatform.field_type.form_mapper.value, fieldType: hello_world }
```

## Render fields

### Create template

Next thing to create is the template. It will define the default display of `HelloWorld` field.
In templates directory create `field_type.html.twig` file.
Inside add a following block:

```twig
{% block hello_world_field %}
    Hello <b>{{ field.value.getName() }}!</b>
{% endblock %}
```

### Template mapping

Next, provide the template mapping in `config/packages/ezplatform.yaml`:

```yaml
ezpublish:
    system:
        default: 
            # ...
            field_templates:
                - { template: 'field_type.html.twig', priority: 0 }
```

## Final results

You can now select and use your new Field Type in the Back Office interface.