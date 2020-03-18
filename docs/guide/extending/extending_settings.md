# Extending settings

## Default settings

Back Office provides a default set of `ezsettings` for `admin_group` SiteAccess.
Keep in mind that those settings might be easily overridden by global or SiteAccess `ezsettings`, as well as all bundles, including third party and yours.
For this reason, `ezsettings` values mentioned in the documentation might not work in your project.

## User settings

You can add new preferences to the User Settings menu in the Back Office.

To do so, create a setting class implementing two interfaces:
`ValueDefinitionInterface` and `FormMapperInterface`.

In this example the class is located in `src/Setting/Unit.php`
and enables the user to select their preference for metric or imperial unit systems.

``` php
<?php
declare(strict_types=1);

namespace App\Setting;

use EzSystems\EzPlatformUser\UserSetting\FormMapperInterface;
use EzSystems\EzPlatformUser\UserSetting\ValueDefinitionInterface;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use EzSystems\EzPlatformAdminUi\UserSetting as AdminUiUserSettings;

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
        switch($storageValue) {
            case self::METRIC_OPTION:
                return 'Metric';
            case self::IMPERIAL_OPTION:
                return 'Imperial';
            default:
                throw new InvalidArgumentException(
                    '$storageValue',
                    sprintf('There is no \'%s\' option', $storageValue)
                );
        }
    }

    public function getDefaultValue(): string
    {
        return 'metric';
    }

    public function mapFieldForm(FormBuilderInterface $formBuilder, AdminUiUserSettings\ValueDefinitionInterface $value): FormBuilderInterface
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

Add new service definitions:

``` yaml
App\Setting\Unit:
    tags:
        - { name: ezplatform.admin_ui.user_setting.value, identifier: unit, priority: 50 }
        - { name: ezplatform.admin_ui.user_setting.form_mapper, identifier: unit }
```

You can order the settings in the User menu by setting their `priority`.

The value of the setting is accessible with `ez_user_settings['unit']`.

## Templates settings

You can define a template to be used when editing the given setting in `config/packages/ezplatform.yaml`:

``` yaml
ezplatform:
    system:
        admin_group:
            user_settings_update_view:
                full:
                    unit:
                        template: AppBundle:user:settings/update_unit.html.twig
                        match:
                            Identifier: [ unit ]
```

The template must extend the `@ezdesign/user/settings/update.html.twig` template:

``` html+twig
{% extends '@ezdesign/user/settings/update.html.twig' %}

{% block form %}
    {{ parent() }}
    <div class="alert ez-alert--info mt-4" role="alert">
        Imperial units are: yard, mile, pound, etc.</br>
        Metric units are: meter, kilometer, kilogram, etc.
    </div>
{% endblock %}
```
