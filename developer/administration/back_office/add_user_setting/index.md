# Add user setting

Add the option to select a custom preference in user menu.

## Create new user setting

You can add new preferences to the **User Settings** menu in the back office.

To do so, create a setting class implementing two interfaces: `ValueDefinitionInterface` and `FormMapperInterface`.

In this example the class is located in `src/Setting/Unit.php` and enables the user to select their preference for metric or imperial unit systems.

```php
<?php declare(strict_types=1);

namespace App\Setting;

use Ibexa\Contracts\User\UserSetting\FormMapperInterface;
use Ibexa\Contracts\User\UserSetting\ValueDefinitionInterface;
use Ibexa\Core\Base\Exceptions\InvalidArgumentException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class Unit implements ValueDefinitionInterface, FormMapperInterface
{
    public const METRIC_OPTION = 'metric';
    public const IMPERIAL_OPTION = 'imperial';

    public function getName(): string
    {
        return 'Unit';
    }

    public function getDescription(): string
    {
        return 'Choose between metric and imperial unit systems';
    }

    public function getDisplayValue(string $storageValue): string
    {
        return match ($storageValue) {
            self::METRIC_OPTION => 'Metric',
            self::IMPERIAL_OPTION => 'Imperial',
            default => throw new InvalidArgumentException(
                '$storageValue',
                sprintf('There is no \'%s\' option', $storageValue)
            ),
        };
    }

    public function getDefaultValue(): string
    {
        return 'metric';
    }

    public function mapFieldForm(FormBuilderInterface $formBuilder, ValueDefinitionInterface $value): FormBuilderInterface
    {
        $choices = [
            'Metric' => self::METRIC_OPTION,
            'Imperial' => self::IMPERIAL_OPTION,
        ];

        return $formBuilder->create(
            'value',
            ChoiceType::class,
            [
                'multiple' => false,
                'required' => true,
                'label' => $this->getDescription(),
                'choices' => $choices,
            ]
        );
    }
}
```

Register the setting as a service:

```yaml
services:
    App\Setting\Unit:
        tags:
            - { name: ibexa.user.setting.value, identifier: unit, group: my_group, priority: 50 }
            - { name: ibexa.user.setting.mapper.form, identifier: unit }
```

You can order the settings in the **User** menu by setting their `priority`.

`group` indicates the group that the setting is placed in. It can be one of the built-in groups, or a custom one.

To create a custom setting group, create an `App/Setting/Group/MyGroup.php` file:

```php
<?php declare(strict_types=1);

namespace App\Setting\Group;

use Ibexa\User\UserSetting\Group\AbstractGroup;

final class MyGroup extends AbstractGroup
{
    public function __construct(
        array $values = []
    ) {
        parent::__construct($values);
    }

    public function getName(): string
    {
        return 'My Group';
    }

    public function getDescription(): string
    {
        return 'My custom setting group';
    }
}
```

Register the setting group as a service:

```yaml
    App\Setting\Group\MyGroup:
        tags:
            - { name: ibexa.user.setting.group, identifier: my_group, priority: 30 }
```

The value of the setting is accessible with `ibexa_user_settings['unit']`.

## Create template for editing settings

You can override a template used when editing the new setting under the `ibexa.system.<scope>.user_settings_update_view` [configuration key](../../configuration/configuration/index.md#configuration-files):

```yaml
ibexa:
    system:
        admin_group:
            user_settings_update_view:
                full:
                    unit:
                        template: '@ibexadesign/user/setting/update_unit.html.twig'
                        match:
                            Identifier: [ unit ]
```

The `templates/themes/admin/user/setting/update_unit.html.twig` template must extend the `@ibexadesign/account/settings/update.html.twig` template:

```html+twig
{% extends '@ibexadesign/account/settings/update.html.twig' %}

{% block form %}
    {{ parent() }}
    <div class="alert ibexa-alert--info mt-4" role="alert">
        Imperial units are: yard, mile, pound, etc.</br>
        Metric units are: meter, kilometer, kilogram, etc.
    </div>
{% endblock %}
```
