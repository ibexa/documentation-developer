# Page block validators

Set up rules for validating Page block content.

Editions: Experience

Validators check values passed to Page block attributes. The following block validators are available:

- `required` - checks whether the attribute is provided
- `regexp` - validates attribute according to the provided regular expression
- `not_blank` - checks whether the attribute isn't left empty
- `not_blank_richtext` - checks whether a `richtext` attribute isn't left empty
- `content_type` - checks whether the selected content types match the provided values
- `content_container` - checks whether the selected content item is a container

> **Note: Note**
>
> Don't use the `required` and `not_blank` validators for `richtext` attributes. Instead, use `not_blank_richtext`.

For each validator you can provide a message that displays in the Page Builder when an attribute field doesn't fulfill the criteria.

Additionally, for some validators you can provide settings under the `ibexa_fieldtype_page.blocks.<block_name>.validators.regexp.options` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files), for example:

```yaml
email:
    type: string
    name: E-mail address
    validators:
        regexp:
            options:
                pattern: '/^\S+@\S+\.\S+$/'
            message: Provide a valid e-mail address
```

## Custom validators

You can create Page block attributes with custom validators.

The following example shows how to create a validator which requires that string attributes contain only alphanumeric characters.

First, create classes that support your intended method of validation. For example, in `src/Validator`, create an `AlphaOnly.php` file:

```php
<?php declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class AlphaOnly extends Constraint
{
    public string $message = 'The attribute can only contain letters or numbers.';
}
```

In `src/Validator`, create an `AlphaOnlyValidator.php` class that performs the validation.

```php
<?php declare(strict_types=1);

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class AlphaOnlyValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof AlphaOnly) {
            throw new UnexpectedTypeException($constraint, AlphaOnly::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        // Throw an exception if the validator cannot handle the passed type.
        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        if (!preg_match('/^[A-Za-z0-9]+$/', $value, $matches)) {
            // The argument must be a string or an object implementing __toString()
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}
```

Then, under `ibexa_fieldtype_page.block_validators`, enable the new validator in Page Builder:

```yaml
ibexa_fieldtype_page:
    block_validators:
        alpha_only: 'App\Validator\AlphaOnly'
```

Finally, add the validator to one of your block attributes, for example:

```yaml
ibexa_fieldtype_page:
    blocks:
        my_block:
            name: My Block
            category: default
            thumbnail: /bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#edit
            views:
                default:
                    name: Default block layout
                    template: '@ibexadesign/blocks/my_block.html.twig'
                    priority: -255
            attributes:
                my_text_attribute:
                    type: text
                    name: My text attribute
                    validators:
                        alpha_only:
                            message: The field can only contain letters or numbers.
```

### Custom required validator

By default, only `not_blank` and `not_blank_richtext` validators mark a block attribute as required.

If you create a custom validator `custom_not_blank` with attribute-specific logic, you can extend the `AttributeType` class with a Symfony form type extension to make sure that the attribute is also considered required:

```php
<?php declare(strict_types=1);

use Ibexa\PageBuilder\Form\Type\Attribute\AttributeType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class AttributeTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var \Ibexa\Contracts\FieldTypePage\FieldType\Page\Block\Definition\BlockAttributeDefinition $attributeDefinition */
        $attributeDefinition = $options['block_attribute_definition'];

        if (isset($attributeDefinition->getConstraints()['custom_not_blank'])) {
            $builder->setRequired(true);
        }
    }

    public static function getExtendedTypes(): iterable
    {
        return [
            AttributeType::class,
        ];
    }
}
```
