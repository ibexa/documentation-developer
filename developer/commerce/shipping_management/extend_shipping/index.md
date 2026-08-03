# Extend shipping

Extend Shipping with custom shipping method type and other extra features.

Editions: Commerce

You can extend or customize your Shipping module implementation in different ways.

Here, you can learn about the following ideas to make your Commerce solution more powerful:

- create a custom shipping method type
- toggle shipping method availability in checkout based on a condition
- display shipping method parameters on the shipping method details page

You can also [customize the shipment processing workflow](../configure_shipment/index.md#custom-shipment-workflows).

## Create custom shipping method type

If your application needs shipping methods of other type than the default ones, you can create custom shipping method types. See the code samples below to learn how to do it.

### Define custom shipping method type class

Create a definition of the shipping method type. Use a built-in type factory to define the class in `config/services.yaml`:

```yaml
services:
    app.shipping.shipping_method_type.custom:
        class: Ibexa\Shipping\ShippingMethod\ShippingMethodType
        arguments:
            $identifier: 'custom'
        tags:
            - name: ibexa.shipping.shipping_method_type
              alias: custom
```

At this point a custom shipping method type should be visible on the **Create shipping method** modal, the **Method type** list.

![Selecting a shipping method type](https://doc.ibexa.co/en/5.0/commerce/shipping_management/img/shipping_method_type_selection.png "Selecting a shipping method type")

### Create options form

To let users create shipping methods of a custom type within the user interface, you need a Symfony form type. Create a `src/ShippingMethodType/Form/Type/CustomShippingMethodOptionsType.php` file with a form type.

Next, define a name of the custom shipping method type in the file, by using the `getTranslationMessages` method.

```php
<?php

declare(strict_types=1);

namespace App\ShippingMethodType\Form\Type;

use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CustomShippingMethodOptionsType extends AbstractType implements TranslationContainerInterface
{
    #[\Override]
    public function getBlockPrefix(): string
    {
        return 'ibexa_shipping_method_custom';
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('customer_identifier', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['translation_mode' => false]);
        $resolver->setAllowedTypes('translation_mode', 'bool');
    }

    public static function getTranslationMessages(): array
    {
        return [
            Message::create('ibexa.shipping_types.custom.name', 'ibexa_shipping')->setDesc('Custom'),
        ];
    }
}
```

Create a translations file `translations/ibexa_shipping.en.yaml` that stores a name value for the custom shipping method type:

```yaml
ibexa.shipping_types.custom.name: 'Custom Type'
```

Next, use the type factory to define an options form mapper class in `config/services.yaml`:

```yaml
services:
    app.shipping.shipping_method.custom.form_mapper.options:
        class: Ibexa\Bundle\Shipping\Form\ShippingMethod\OptionsFormMapper
        arguments:
            $formType: 'App\ShippingMethodType\Form\Type\CustomShippingMethodOptionsType'
        tags:
            - name: ibexa.shipping.shipping_method.form_mapper.options
              type: custom
```

At this point you should be able to create a shipping method based on a custom shipping method type.

![Creating a shipping method of custom type](https://doc.ibexa.co/en/5.0/commerce/shipping_management/img/custom_shipping_method_type.png "Creating a shipping method of custom type")

> **Note: Note**
>
> To use this example, you must have regions. If you don't have regions, refer to [Enable purchasing products](../../../product_catalog/enable_purchasing_products/index.md) for instructions on how to add them.

### Create options validator

You might want to validate the data provided by the user against certain constraints. Here, you create an options validator class that checks whether the user provided the `customer_identifier` value and dispatches an error when needed.

Use the type factory to define a compound validator class in `config/services.yaml`:

```yaml
services:
    app.shipping.shipping_method.options.custom_compound_validator:
        class: Ibexa\Shipping\Validation\Validator\CompoundValidator
        arguments:
            $validators: !tagged_iterator { tag: 'ibexa.shipping.shipping_method.options.validator.custom' }
        tags:
            - name: ibexa.shipping.shipping_method.options.validator
              type: custom
```

Then, create a `src/ShippingMethodType/CustomerNotNullValidator.php` file with a validator class:

```php
<?php

declare(strict_types=1);

namespace App\ShippingMethodType;

use Ibexa\Contracts\Core\Options\OptionsBag;
use Ibexa\Contracts\Shipping\ShippingMethod\Type\OptionsValidatorError;
use Ibexa\Contracts\Shipping\ShippingMethod\Type\OptionsValidatorInterface;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;

final class CustomerNotNullValidator implements OptionsValidatorInterface, TranslationContainerInterface
{
    public const string MESSAGE = 'Customer identifier value cannot be null';

    public function validateOptions(OptionsBag $options): array
    {
        $customerIdentifier = $options->get('customer_identifier');

        if ($customerIdentifier === null) {
            return [
                new OptionsValidatorError('[customer_identifier]', self::MESSAGE),
            ];
        }

        return [];
    }

    public static function getTranslationMessages(): array
    {
        return [
            Message::create(self::MESSAGE, 'validators')->setDesc('Customer identifier value cannot be null'),
        ];
    }
}
```

Finally, register the validator as a service:

```yaml
services:
    App\ShippingMethodType\CustomerNotNullValidator:
        tags:
            - name: ibexa.shipping.shipping_method.options.validator.custom
```

Now, when you create a new shipping method and leave the **Customer identifier** field empty, you should see a warning.

![Option validator in action](https://doc.ibexa.co/en/5.0/commerce/shipping_management/img/custom_shipping_type_validator.png "Option validator in action")

### Create storage converter

Before form data can be stored in database tables, field values must be converted to a storage-specific format. Here, the storage converter converts the `customer_identifier` string value into the `customer_id` numerical value.

Create a `src/ShippingMethodType/Storage/StorageConverter.php` file with a storage converter class:

```php
<?php

declare(strict_types=1);

namespace App\ShippingMethodType\Storage;

use Ibexa\Contracts\Shipping\Local\ShippingMethod\StorageConverterInterface;

final class StorageConverter implements StorageConverterInterface
{
    public function fromPersistence(array $data)
    {
        $value['customer_identifier'] = $data['customer_id'];

        return $value;
    }

    public function toPersistence($value): array
    {
        return [
            StorageSchema::COLUMN_CUSTOMER_ID => $value['customer_identifier'],
        ];
    }
}
```

Then, register the storage converter as a service:

```yaml
services:
    App\ShippingMethodType\Storage\StorageConverter:
        tags:
            - { name: 'ibexa.shipping.shipping_method.storage_converter', type: 'custom' }
```

#### Storage definition

Now, create a storage definition class and a corresponding schema. The table stores information specific for the custom shipping method type.

> **Note: Create table**
>
> Before you can proceed, in your database, create a table that has columns present in the storage definition, for example:
>
> `CREATE TABLE ibexa_shipping_method_region_custom(id int auto_increment primary key, customer_id text, shipping_method_region_id int);`

Create a `src/ShippingMethodType/Storage/StorageDefinition.php` file with a storage definition:

```php
<?php declare(strict_types=1);

namespace App\ShippingMethodType\Storage;

use Doctrine\DBAL\Types\Types;
use Ibexa\Contracts\Shipping\Local\ShippingMethod\StorageDefinitionInterface;
use Ibexa\Shipping\Persistence\Legacy\ShippingMethod\AbstractOptionsStorageSchema;

final class StorageDefinition implements StorageDefinitionInterface
{
    public function getColumns(): array
    {
        return [
            AbstractOptionsStorageSchema::COLUMN_SHIPPING_METHOD_REGION_ID => Types::INTEGER,
            StorageSchema::COLUMN_CUSTOMER_ID => Types::STRING,
        ];
    }

    public function getTableName(): string
    {
        return StorageSchema::TABLE_NAME;
    }
}
```

Then, create a `src/ShippingMethodType/Storage/StorageSchema.php` file with a storage schema:

```php
<?php

declare(strict_types=1);

namespace App\ShippingMethodType\Storage;

use Ibexa\Shipping\Persistence\Legacy\ShippingMethod\AbstractOptionsStorageSchema;

final class StorageSchema extends AbstractOptionsStorageSchema
{
    public const string TABLE_NAME = 'ibexa_shipping_method_region_custom';
    public const string COLUMN_ID = 'id';
    public const string COLUMN_CUSTOMER_ID = 'customer_id';
}
```

Then, register the storage definition as a service:

```yaml
services:
    App\ShippingMethodType\Storage\StorageDefinition:
        tags:
            - { name: 'ibexa.shipping.shipping_method.storage_definition', type: 'custom' }
```

## Toggle shipping method type availability

When you implement a web store, you can choose if a certain shipping method is available for selection during checkout. Here, you limit shipping method availability to customers who meet a specific condition. In this case, they must belong to the Acme company. Create a `src/ShippingMethodType/Vote/CustomVoter.php` file with a voter class:

```php
<?php

declare(strict_types=1);

namespace App\ShippingMethodType\Voter;

use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Shipping\ShippingMethod\Voter\AbstractVoter;
use Ibexa\Contracts\Shipping\Value\ShippingMethod\ShippingMethodInterface;

final class CustomVoter extends AbstractVoter
{
    protected function getVote(ShippingMethodInterface $method, CartInterface $cart): bool
    {
        return $method->getOptions()->get('customer_identifier') === 'Acme';
    }
}
```

Register the voter as a service:

```yaml
services:
    App\ShippingMethodType\Voter\CustomVoter:
        tags:
            - { name: ibexa.shipping.shipping.voter, method: custom }
```

## Display shipping method parameters in details view

You can extend the default shipping method details view by making shipping method visible on the **Cost** tab. To do this, create a `src/ShippingMethodType/Cost/CustomCostFormatter.php` file with a formatter class:

```php
<?php

declare(strict_types=1);

namespace App\ShippingMethodType\Cost;

use Ibexa\Contracts\Shipping\ShippingMethod\CostFormatterInterface;
use Ibexa\Contracts\Shipping\Value\ShippingMethod\ShippingMethodInterface;

final class CustomCostFormatter implements CostFormatterInterface
{
    public function formatCost(ShippingMethodInterface $shippingMethod, array $parameters = []): ?string
    {
        return $shippingMethod->getOptions()->get('customer_identifier');
    }
}
```

Then register the formatter as a service:

```yaml
services:
    App\ShippingMethodType\Cost\CustomCostFormatter:
        tags:
            - name: ibexa.shipping.shipping_method.formatter.cost
              type: custom
```

You should now see the parameter, in this case it's a customer identifier, displayed on the **Cost** tab of the shipping method's details view.

![Shipping method parameters in the Cost tab](https://doc.ibexa.co/en/5.0/commerce/shipping_management/img/shipping_method_cost_tab.png "Shipping method parameters in the Cost tab")

> **Note: Non-matching label**
>
> This section doesn't discuss overriding the default form, therefore the alphanumerical customer identifier is shown under the **Cost value** label. For more information about working with forms, see [Page and Form tutorial](../../../tutorials/page_and_form_tutorial/5_create_newsletter_form/index.md).
