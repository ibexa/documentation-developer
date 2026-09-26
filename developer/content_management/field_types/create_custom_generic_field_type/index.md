# Create custom generic field type

Create a new field type based on the Generic field type.

The Generic field type is an abstract implementation of field types holding structured data for example, address. You can use it as a base for custom field types. The Generic field type comes with the implementation of basic methods, reduces the number of classes which must be created, and simplifies the tagging process.

A more in-depth, step-by-step tutorial can be viewed here: [Creating a Point 2D field type](../../../tutorials/generic_field_type/creating_a_point2d_field_type/index.md).

> **Tip: Tip**
>
> You should not use the Generic field type when you need a very specific implementation or complete control over the way data is stored.

> **Caution: Simple hash values**
>
> A simple hash value always means an array of scalar values and/or nested arrays of scalar values. To avoid issues with format conversion, don't use objects inside the simple hash values.

## Define value object

First, create `Value.php` in the `src/FieldType/HelloWorld` directory. The Value class of a field type contains only the basic logic of a field type, the rest of it's handled by the `Type` class. For more information about field type Value, see [Value handling](../type_and_value/index.md#value-handling).

The `HelloWorld` Value class should contain:

- public properties that retrieve `name`
- an implementation of the `__toString()` method

```php
<?php declare(strict_types=1);

namespace App\FieldType\HelloWorld;

use Ibexa\Contracts\Core\FieldType\Value as ValueInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class Value implements ValueInterface
{
    /**
     * @Assert\NotBlank()
     */
    private ?string $name = null;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function __toString(): string
    {
        return "Hello {$this->name}!";
    }
}
```

## Define fields and configuration

Next, implement a definition of a field type extending the Generic field type in the `src/FieldType/HelloWorld/Type.php` class. It provides settings for the field type and an implementation of the `Ibexa\Contracts\Core\FieldType\FieldType` abstract class.

```php
<?php declare(strict_types=1);

namespace App\FieldType\HelloWorld;

use Ibexa\Contracts\ContentForms\FieldType\FieldValueFormMapperInterface;
use Ibexa\Contracts\Core\FieldType\Generic\Type as GenericType;

final class Type extends GenericType implements FieldValueFormMapperInterface
{
    public function getFieldTypeIdentifier(): string
    {
        return 'hello_world';
    }
}
```

For more information about the Type class of a field type, see [Type class](../type_and_value/index.md#type-class).

Next, register the field type as a service and tag it with `ibexa.field_type`:

```yaml
services:
    App\FieldType\HelloWorld\Type:
        public: true
        tags:
            - { name: ibexa.field_type, alias: hello_world }
```

## Define form for value object

Create a `src/Form/Type/HelloWorldType.php` form. It enables you to edit the new field type.

```php
<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\FieldType\HelloWorld\Value;
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
            'data_class' => Value::class,
        ]);
    }
}
```

Now you can map field definitions into Symfony forms with FormMapper. Add the `mapFieldValueForm()` method required by `FieldValueFormMapperInterface` and the required `use` statements to `src/FieldType/HelloWorld/Type.php`:

```php
<?php declare(strict_types=1);

namespace App\FieldType\HelloWorld;

use App\Form\Type\HelloWorldType;
use Ibexa\Contracts\ContentForms\Data\Content\FieldData;
use Ibexa\Contracts\ContentForms\FieldType\FieldValueFormMapperInterface;
use Ibexa\Contracts\Core\FieldType\Generic\Type as GenericType;
use Symfony\Component\Form\FormInterface;

final class Type extends GenericType implements FieldValueFormMapperInterface
{
    public function getFieldTypeIdentifier(): string
    {
        return 'hello_world';
    }

    public function mapFieldValueForm(FormInterface $fieldForm, FieldData $data): void
    {
        $definition = $data->getFieldDefinition();

        $fieldForm->add('value', HelloWorldType::class, [
            'required' => $definition->isRequired,
            'label' => $definition->getName(),
        ]);
    }
}
```

For more information about the FormMappers, see [field type form and template](../form_and_template/index.md).

Next, add the `ibexa.admin_ui.field_type.form.mapper.value` tag to the service definition:

```yaml
services:
    App\FieldType\HelloWorld\Type:
        public: true
        tags:
            - { name: ibexa.field_type, alias: hello_world }
            - { name: ibexa.admin_ui.field_type.form.mapper.value, fieldType: hello_world }
```

## Render fields

### Create a template

Create a template for the new field type. It defines the default rendering of the `HelloWorld` field. In the `templates/themes/standard/field_types` directory create a `field_type.html.twig` file:

```html+twig
{% block hello_world_field %}
    Hello <b>{{ field.value.getName() }}!</b>
{% endblock %}
```

### Template mapping

Provide the template mapping under the `ibexa.system.<scope>.field_templates` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa:
    system:
        default:
            field_templates:
                - { template: '@ibexadesign/field_types/field_type.html.twig', priority: 0 }
```

## Final results

Finally, you should be able to add a new content type in the back office interface. Navigate to **Content types** tab and under **Content** category create a new content type:

![Creating new content type](https://doc.ibexa.co/en/5.0/content_management/img/extending_field_type_create.png)

Next, define a **Hello World** field:

![Defining Hello World](https://doc.ibexa.co/en/5.0/content_management/img/extending_field_type_definition.png)

After saving, your **Hello World** content type should be available under **Content** in the sidebar menu.

![Creating Hello World](https://doc.ibexa.co/en/5.0/content_management/img/extending_field_type_hello_world.png)
