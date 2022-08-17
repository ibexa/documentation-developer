# Address Field Type

This Field represents and handles address fields.
It allows you to customize address Fields per country.

| Name      | Internal name   | Expected input              |
|-----------|-----------------|-----------------------------|
| `Address` | `ibexa_address` | `string`, `string`, `array` |

The Address Field Type is available via the Address Bundle
provided by the `ibexa/fieldtype-address` package.

## PHP API Field Type

### Inputs:

| Type     | Description                                   | Example           |
|----------|-----------------------------------------------|-------------------|
| `string` | Name of the address.                          | `My home address` |
| `string` | Country code in ISO 3166-1 alpha-2 format.    | `PL`              |
| `array`  | Additional fields, defined by address format. | see below         |

### Example input

```php
new FieldType\Value(
    'My home address',
    'PL',
    [
        'city' => 'Warsaw',
        'region' => 'Masovian',
        'postal_code' => '11-123',
    ]
);
```

### Validation

This Field Type validates whether `Country` and `Name` fields have been filled out.

### Value Object

#### Properties

| Property   | Type     | Description                                   |
|------------|----------|-----------------------------------------------|
| `$name`    | `string` | Name of the address.                          |
| `$country` | `string` | Country code in ISO 3166-1 alpha-2 format.    |
| `$fields`  | `array`  | Additional fields, defined by address format. |

#### Constructor

See above (Example input).

### Formats

The following default configuration defines default fields for `personal` address type:

```yaml
formats:
    personal:
        country:
            default:
                - region
                - locality
                - street
                - postal_code
```

#### Modifying Field configuration

```yaml
formats:
    billing_address:
        country:
            DE:
                - tax_number
                - city
                - address
                - postal_code
```

Adds (or alters) an address format for `DE` country of `billing_address` type.

### Field form types

By default, each field is a simple text input with a label made of field identifier.
To change the type of field, you need to listen to a specific event.
For each field below events are dispatched (in order):

```
ibexa.address.field.{FIELD_IDENTIFIER}
ibexa.address.field.{FIELD_IDENTIFIER}.{ADDRESS_TYPE}
ibexa.address.field.{FIELD_IDENTIFIER}.{ADDRESS_TYPE}.{COUNTRY_CODE}
```

#### Example

```
ibexa.address.field.tax_number
ibexa.address.field.tax_number.billing_address
ibexa.address.field.tax_number.billing_address.DE
```

#### Example event listener

```php
use Ibexa\Contracts\FieldTypeAddress\Event\MapFieldEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ExampleAddressSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'ibexa.address.field.tax_number.billing_address' => 'onBillingAddressTaxNumber',
        ];
    }
    
    public function onBillingAddressTaxNumber(MapFieldEvent $event): void
    {
        $event->setLabel('VAT');
        $event->setType(IntegerType::class);
        $event->setOptions([
            'attr' => ['class' => 'some-tax-number'],
        ]);
    }
}
```
