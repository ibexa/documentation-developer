---
description: Create a custom policy to cover non-standard permission needs.
---

# Custom policies

The content repository uses [roles and policies](permissions.md) to give users access to different functions of the system.

Any bundle can expose available policies via a `PolicyProvider` which can be added to IbexaCoreBundle's [service container](php_api.md#service-container) extension.

## PolicyProvider

A `PolicyProvider` object provides a hash containing declared modules, functions and limitations.

- Each policy provider provides a collection of permission *modules*.
- Each module can provide *functions* (for example, in `content/read`, "content" is the module, and "read" is the function)
- Each function can provide a collection of limitations.

First level key is the module name which is limited to characters within the set `A-Za-z0-9_`, value is a hash of available functions, with function name as key.
Function value is an array of available limitations, identified by the alias declared in `LimitationType` service tag.
If no limitation is provided, value can be `null` or an empty array.

``` php
[
    "content" => [
        "read" => ["Class", "ParentClass", "Node", "Language"],
        "edit" => ["Class", "ParentClass", "Language"]
    ],
    "custom_module" => [
        "custom_function_1" => null,
        "custom_function_2" => ["CustomLimitation"]
    ],
]
```

Limitations need to be implemented as *Limitation types* and declared as services identified with `ibexa.permissions.limitation_type` tag.
Name provided in the hash for each limitation is the same value set in the `alias` attribute in the service tag.

For example:

``` php
<?php declare(strict_types=1);

namespace App\Security;

use Ibexa\Bundle\Core\DependencyInjection\Configuration\ConfigBuilderInterface;
use Ibexa\Bundle\Core\DependencyInjection\Security\PolicyProvider\PolicyProviderInterface;

class MyPolicyProvider implements PolicyProviderInterface
{
    public function addPolicies(ConfigBuilderInterface $configBuilder)
    {
        $configBuilder->addConfig([
             "custom_module" => [
                 "custom_function_1" => null,
                 "custom_function_2" => ["CustomLimitation"],
             ],
         ]);
    }
}
```

!!! note "Extend existing policies"

    While a `PolicyProvider` may provide new functions to an existing policy module, or additional limitations to an existing function, it's however strongly recommended to create your own modules.

    It's impossible to remove an existing module, function or limitation from a policy.

### YamlPolicyProvider

An abstract class based on YAML is provided: `Ibexa\Bundle\Core\DependencyInjection\Security\PolicyProvider\YamlPolicyProvider`.
It defines an abstract `getFiles()` method.

Extend `YamlPolicyProvider` and implement `getFiles()` to return absolute paths to your YAML files.

``` php
[[= include_file('code_samples/back_office/limitation/src/Security/MyPolicyProvider.php') =]]
```

In `src/Resources/config/policies.yaml`:

``` yaml
[[= include_file('code_samples/back_office/limitation/src/Resources/config/policies.yaml') =]]
```

### Translations

Provide translations for your custom policies in the `forms` domain.

For example, `translations/forms.en.yaml`:

``` yaml
[[= include_file('code_samples/back_office/limitation/translations/forms.en.yaml') =]]
```

You can also implement `TranslationContainerInterface` to provide those translations in your policy provider class:

``` php
<?php declare(strict_types=1);

namespace App\Security;

use Ibexa\Bundle\Core\DependencyInjection\Configuration\ConfigBuilderInterface;
use Ibexa\Bundle\Core\DependencyInjection\Security\PolicyProvider\PolicyProviderInterface;

class MyPolicyProvider implements PolicyProviderInterface, TranslationContainerInterface
{
    public function addPolicies(ConfigBuilderInterface $configBuilder)
    {
        $configBuilder->addConfig([
             "custom_module" => [
                 "custom_function_1" => null,
                 "custom_function_2" => ["CustomLimitation"],
             ],
         ]);
    }

    public static function getTranslationMessages(): array
    {
        return [
            (new Message('role.policy.custom_module', 'forms'))->setDesc('Custom module'),
            (new Message('role.policy.custom_module.all_functions', 'forms'))->setDesc('Custom module / All functions'),
            (new Message('role.policy.custom_module.custom_function_1', 'forms'))->setDesc('Custom module / Function #1'),
            (new Message('role.policy.custom_module.custom_function_2', 'forms'))->setDesc('Custom module / Function #2'),
        ];
    }
}
```

Then, extract this translation to generate the English translation file `translations/forms.en.xlf`:

``` bash
php bin/console translation:extract en --domain=forms --dir=src --output-dir=translations
```

## `PolicyProvider` integration into `IbexaCoreBundle`

For a `PolicyProvider` to be active, you have to register it in the `src/Kernel.php`:

``` php
[[= include_file('code_samples/back_office/limitation/src/Kernel.php') =]]
```

## Custom limitation type

For a custom module function, you can use existing limitation types or create custom ones.

The base of a custom limitation is a class to store values for the usage of this limitation in roles, and a class to implement the limitation's logic.

The value class extends `Ibexa\Contracts\Core\Repository\Values\User\Limitation` and says for which limitation it's used:

``` php
[[= include_file('code_samples/back_office/limitation/src/Security/Limitation/CustomLimitationValue.php') =]]
```

The type class implements `Ibexa\Contracts\Core\Limitation\Type`.

- `accept`, `validate` and `buildValue` implement the value class usage logic.
- `evaluate` challenges a limitation value against the current user, the subject object and other context objects to return if the limitation is satisfied or not. `evaluate` is, among others, used by `PermissionResolver::canUser` (to check if a user that has access to a function can use it in its limitations) and `PermissionResolver::lookupLimitations`.

```php
[[= include_file('code_samples/back_office/limitation/src/Security/Limitation/CustomLimitationType.php') =]]
```

The type class is set as a service tagged `ibexa.permissions.limitation_type` with an alias to identify it, and to link it to the value.

``` yaml
services:
    # …
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 1, 4) =]]
```

### Custom limitation type form

#### Form mapper

To provide support for editing custom policies in the back office, you need to implement [`Ibexa\AdminUi\Limitation\LimitationFormMapperInterface`](https://github.com/ibexa/admin-ui/blob/4.5/src/lib/Limitation/LimitationFormMapperInterface.php).

- `mapLimitationForm` adds the limitation field as a child to a provided Symfony form.
- `getFormTemplate` returns the path to the template to use for rendering the limitation form. Here it use [`form_label`]([[= symfony_doc =]]/form/form_customization.html#reference-forms-twig-label) and [`form_widget`]([[= symfony_doc =]]/form/form_customization.html#reference-forms-twig-widget) to do so.
- `filterLimitationValues` is triggered when the form is submitted and can manipulate the limitation values, such as normalizing them.

``` php
[[= include_file('code_samples/back_office/limitation/src/Security/Limitation/Mapper/CustomLimitationFormMapper.php') =]]
```

Provide a template corresponding to `getFormTemplate`.

``` html+twig
[[= include_file('code_samples/back_office/limitation/templates/themes/admin/limitation/custom_limitation_form.html.twig') =]]
```

Next, register the service with the `ibexa.admin_ui.limitation.mapper.form` tag and set the `limitationType` attribute to the limitation type's identifier:

``` yaml
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 5, 8) =]]
```

#### Notable form mappers to extend

Some abstract limitation type form mapper classes are provided to help implementing common complex limitations.

- `MultipleSelectionBasedMapper` is a mapper used to build forms for limitations based on a checkbox list, where multiple items can be chosen. For example, it's used to build forms for [Content Type Limitation](limitation_reference.md#content-type-limitation), [Language Limitation](limitation_reference.md#language-limitation) or [Section Limitation](limitation_reference.md#section-limitation).
- `UDWBasedMapper` is used to build a limitation form where a content/location must be selected. For example, it's used by the [Subtree Limitation](limitation_reference.md#subtree-limitation) form.

#### Value mapper

By default, without a value mapper, the limitation value is rendered by using the block `ez_limitation_value_fallback` of the template [`vendor/ibexa/admin-ui/src/bundle/Resources/views/themes/admin/limitation/limitation_values.html.twig`](https://github.com/ibexa/admin-ui/blob/4.5/src/bundle/Resources/views/themes/admin/limitation/limitation_values.html.twig#L1-L6).

To customize the rendering, a value mapper eventually transforms the limitation value and sends it to a custom template.

The value mapper implements [`Ibexa\AdminUi\Limitation\LimitationValueMapperInterface`](https://github.com/ibexa/admin-ui/blob/4.5/src/lib/Limitation/LimitationValueMapperInterface.php).

Its `mapLimitationValue` function returns the limitation value transformed for the needs of the template.

``` php
[[= include_file('code_samples/back_office/limitation/src/Security/Limitation/Mapper/CustomLimitationValueMapper.php') =]]
```

Then register the service with the `ibexa.admin_ui.limitation.mapper.value` tag and set the `limitationType` attribute to limitation type's identifier:

``` yaml
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 9, 12) =]]
```

When a value mapper exists for a limitation, the rendering uses a Twig block named `ez_limitation_<lower_case_identifier>_value` where `<lower_case_identifier>` is the limitation identifier in lower case.
In this example, block name is `ez_limitation_customlimitation_value` as the identifier is `CustomLimitation`.

This template receives a `values` variable which is the return of the `mapLimitationValue` function from the corresponding value mapper.

``` html+twig
[[= include_file('code_samples/back_office/limitation/templates/themes/standard/limitation/custom_limitation_value.html.twig') =]]
```

To have your block found, you have to register its template.
Add the template to the configuration under `ezplatform.system.<SCOPE>.limitation_value_templates`:

``` yaml
[[= include_file('code_samples/back_office/limitation/config/packages/ibexa_security.yaml') =]]
```

Provide translations for your custom limitation form in the `ibexa_content_forms_policies` domain.
For example, `translations/ibexa_content_forms_policies.en.yaml`:

``` yaml
[[= include_file('code_samples/back_office/limitation/translations/ibexa_content_forms_policies.en.yaml') =]]
```

### Custom limitation check

Check if current user has this custom limitation set to true from a custom controller:

```php
<?php declare(strict_types=1);

namespace App\Controller;

use Ibexa\Contracts\AdminUi\Controller\Controller;
use Ibexa\Contracts\AdminUi\Permission\PermissionCheckerInterface;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomController extends Controller
{
    // ...
    /** @var PermissionResolver */
    private $permissionResolver;

    /** @var PermissionCheckerInterface */
    private $permissionChecker;

    public function __construct(
        // ...,
        PermissionResolver   $permissionResolver,
        PermissionCheckerInterface $permissionChecker
    )
    {
        // ...
        $this->permissionResolver = $permissionResolver;
        $this->permissionChecker = $permissionChecker;
    }

    // Controller actions...
    public function customAction(Request $request): Response {
        // ...
        if ($this->getCustomLimitationValue()) {
            // Action only for user having the custom limitation checked
        }
    }

    private function getCustomLimitationValue(): bool {
        $customLimitationValues = $this->permissionChecker->getRestrictions($this->permissionResolver->hasAccess('custom_module', 'custom_function_2'), CustomLimitationValue::class);

        return $customLimitationValues['value'] ?? false;
    }

    public function performAccessCheck()
    {
        parent::performAccessCheck();
        $this->denyAccessUnlessGranted(new Attribute('custom_module', 'custom_function_2'));
    }
}
```
