# Create custom Form field

Extend a Form with a custom Form field to fit your particular needs.

Editions: Experience

You can extend the Form Builder by adding new Form fields or modifying existing ones. Define new form fields in configuration.

## Configure Form field

For example, to create a Country Form field in the "Custom form fields" category, provide the following configuration under the `ibexa_form_builder.fields` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa_form_builder:
    fields:
        country:
            name: country_field.name
            category: custom_category.name
            thumbnail: '/bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#pins-locations'
            attributes:
                label:
                    name: country_field.label.name
                    type: string
                    validators:
                        not_blank:
                            message: You must provide a label for the field
                help:
                    name: country_field.help.name
                    type: string
            validators:
                required: ~
```

and provide the translations for the labels in `translations/ibexa_form_builder.en.yaml`:

```yaml
country_field.name: Country
custom_category.name: Custom form fields

country_field.label.name: Display label
country_field.help.name: Help text
```

Available attribute types are:

| Type       | Description               |
| ---------- | ------------------------- |
| `string`   | String                    |
| `text`     | Text block                |
| `integer`  | Integer number            |
| `url`      | URL                       |
| `multiple` | Multiple choice           |
| `select`   | Dropdown                  |
| `checkbox` | Checkbox                  |
| `location` | Content location          |
| `radio`    | Radio button              |
| `action`   | Button                    |
| `choices`  | List of available options |

Each type of Form field can have validators of the following types:

- `required`
- `min_length`
- `max_length`
- `min_choices`
- `max_choices`
- `min_value`
- `max_value`
- `regex`
- `upload_size`
- `extensions`

## Create mapper

New types of fields require a mapper which implements the `Ibexa\Contracts\FormBuilder\FieldType\Field\FieldMapperInterface` interface.

To create a Country field type, implement the `FieldMapperInterface` interface in `src/FormBuilder/Field/Mapper/CountryFieldMapper.php`:

```php
<?php declare(strict_types=1);

namespace App\FormBuilder\Field\Mapper;

use Ibexa\Contracts\FormBuilder\FieldType\Model\Field;
use Ibexa\FormBuilder\FieldType\Field\Mapper\GenericFieldMapper;

class CountryFieldMapper extends GenericFieldMapper
{
    #[\Override]
    protected function mapFormOptions(Field $field, array $constraints): array
    {
        $options = parent::mapFormOptions($field, $constraints);
        $options['label'] = $field->getAttributeValue('label');
        $options['help'] = $field->getAttributeValue('help');

        return $options;
    }
}
```

Then, register the mapper as a service:

```yaml
services:
    App\FormBuilder\Field\Mapper\CountryFieldMapper:
        arguments:
            $fieldIdentifier: country
            $formType: Symfony\Component\Form\Extension\Core\Type\CountryType
        tags:
            - { name: ibexa.form_builder.field.mapper }
```

Now you can go to back office and build a new form. You should be able to see the new section in the list of available fields:

![Custom form fields](https://doc.ibexa.co/en/5.0/content_management/img/extending_form_builder_custom_form_fields.png)

And a new Country Form field:

![Country field](https://doc.ibexa.co/en/5.0/content_management/img/extending_form_builder_country_field.png)

## Modify existing Form fields

Field or field attribute definition can be modified by subscribing to one of the following events:

- `ibexa.form_builder.field.<FIELD_ID>`
- `ibexa.form_builder.field.<FIELD_ID>.<ATTRIBUTE_ID>`

The following example adds a `custom` string attribute to `single_line` field definition.

```php
<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\FormBuilder\Definition\FieldAttributeDefinitionBuilder;
use Ibexa\FormBuilder\Event\FieldDefinitionEvent;
use Ibexa\FormBuilder\Event\FormEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FormFieldDefinitionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::getFieldDefinitionEventName('single_line') => 'onSingleLineFieldDefinition',
        ];
    }

    public function onSingleLineFieldDefinition(FieldDefinitionEvent $event): void
    {
        $isReadOnlyAttribute = new FieldAttributeDefinitionBuilder();
        $isReadOnlyAttribute->setIdentifier('custom');
        $isReadOnlyAttribute->setName('Custom attribute');
        $isReadOnlyAttribute->setType('string');

        $definitionBuilder = $event->getDefinitionBuilder();
        $definitionBuilder->addAttribute($isReadOnlyAttribute->buildDefinition());
    }
}
```

Register this subscriber as a service:

```yaml
services:
    App\EventSubscriber\FormFieldDefinitionSubscriber:
        public: true
        tags:
            - kernel.event_subscriber
```

## Access Form field definitions

Field definitions are accessible through:

- `Ibexa\FormBuilder\Definition\FieldDefinitionFactory` in the back end
- global variable `ibexa.formBuilder.config.fieldsConfig` in the front end
