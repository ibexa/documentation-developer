---
description: Create a custom Policy to cover non-standard permission needs.
---

# Custom Policies

The content Repository uses [Roles and Policies](permissions.md) to give Users access to different functions of the system.

Any bundle can expose available Policies via a `PolicyProvider` which can be added to IbexaCoreBundle's [service container](php_api.md#service-container) extension.

## PolicyProvider

A `PolicyProvider` object provides a hash containing declared modules, functions and Limitations.

- Each Policy provider provides a collection of permission *modules*.
- Each module can provide *functions* (For example, in `content/read`, "content" is the module, and "read" is the function)
- Each function can provide a collection of Limitations.

First level key is the module name which is limited to characters within the set `A-Za-z0-9_`, value is a hash of
available functions, with function name as key. Function value is an array of available Limitations, identified
by the alias declared in `LimitationType` service tag. If no Limitation is provided, value can be `null` or an empty array.

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
Name provided in the hash for each Limitation is the same value set in the `alias` attribute in the service tag.

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

### Extending existing Policies

A `PolicyProvider` may provide new functions to a module, and additional Limitations to an existing function.
**It's however strongly encouraged to add functions to your own Policy modules.**

It's impossible to remove an existing module, function or limitation from a Policy.

## Integrating the `PolicyProvider` into IbexaCoreBundle

For a `PolicyProvider` to be active, you have to register it in the class `src/Kernel.php`:

``` php
[[= include_file('code_samples/back_office/limitation/src/Kernel.php') =]]
```

## Custom Limitation type

For a custom module function, existing limitation types can be used or custom ones can be created.

The base of a custom limitation is a class to store values for the usage of this limitation in roles, and a class to implement the limitation's logic.

The value class extends `Ibexa\Contracts\Core\Repository\Values\User\Limitation` and says for which limitation it's used:

``` php
[[= include_file('code_samples/back_office/limitation/src/Security/Limitation/CustomLimitationValue.php') =]]
```

The type class implements `Ibexa\Contracts\Core\Limitation\Type`.

- `accept`, `validate` and `buildValue` implement the value class usage logic.
- `evaluate` challenges a limitation value against the current user, the subject object and other context objects to return if the limitation is satisfied or not. `evaluate` is, among others, used by `PermissionResolver::canUser` (to check if a user having access to a function can use it in its limitations) and `PermissionResolver::lookupLimitations`.

```php
[[= include_file('code_samples/back_office/limitation/src/Security/Limitation/CustomLimitationType.php') =]]
```

The type class is set as a service tagged `ibexa.permissions.limitation_type` with an alias to identify it, and to link it to the value.

``` yaml
services:
    # …
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 1, 4) =]]
```

### Custom Limitation type form

#### Form mapper

To provide support for editing custom policies in the Back Office, you need to implement [`Ibexa\AdminUi\Limitation\LimitationFormMapperInterface`](https://github.com/ibexa/admin-ui/blob/4.5/src/lib/Limitation/LimitationFormMapperInterface.php).

- `mapLimitationForm` adds the limitation field as a child to a provided Symfony form.
- `getFormTemplate` returns the path to the template to use for rendering the limitation form. Here it use [`form_label`]([[= symfony_doc =]]/form/form_customization.html#reference-forms-twig-label) and [`form_widget`]([[= symfony_doc =]]/form/form_customization.html#reference-forms-twig-widget) to do so.
- `filterLimitationValues` is triggered when the form is submitted and can manipulate the limitation values, such as normalizing them.

``` php
[[= include_file('code_samples/back_office/limitation/src/Security/Limitation/Mapper/CustomLimitationFormMapper.php') =]]
```

And provide a template corresponding to `getFormTemplate`.

``` html+twig
[[= include_file('code_samples/back_office/limitation/templates/themes/admin/limitation/custom_limitation_form.html.twig') =]]
```

Next, register the service with the `ibexa.admin_ui.limitation.mapper.form` tag and set the `limitationType` attribute to the Limitation type's identifier:

``` yaml
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 5, 8) =]]
```

#### Notable form mappers to extend

Some abstract Limitation type form mapper classes are provided to help implementing common complex Limitations.

- `MultipleSelectionBasedMapper` is mapper to build form for Limitation based on checkbox list where multiple items can be chosen. For example, it's used to build forms for [Content Type Limitation](limitation_reference.md#content-type-limitation), [Language Limitation](limitation_reference.md#language-limitation) or [Section Limitation](limitation_reference.md#section-limitation).
- `UDWBasedMapper` is to build Limitation form where a Content/Location must be selected. For example, it's used by the [Subtree Limitation](limitation_reference.md#subtree-limitation) form.

#### Value mapper

By default, without a value mapper, the Limitation value is rendered using the block `ez_limitation_value_fallback` of the template [`vendor/ibexa/admin-ui/src/bundle/Resources/views/themes/admin/limitation/limitation_values.html.twig`](https://github.com/ibexa/admin-ui/blob/4.5/src/bundle/Resources/views/themes/admin/limitation/limitation_values.html.twig#L1-L6).

To customize the rendering, a value mapper eventually transforms the Limitation value and send it to a custom template.

The value mapper implements [`Ibexa\AdminUi\Limitation\LimitationValueMapperInterface`](https://github.com/ibexa/admin-ui/blob/4.5/src/lib/Limitation/LimitationValueMapperInterface.php).

Its `mapLimitationValue` function returns the Limitation value transformed for the needs of the template.

``` php
[[= include_file('code_samples/back_office/limitation/src/Security/Limitation/Mapper/CustomLimitationValueMapper.php') =]]
```

Then register the service with the `ibexa.admin_ui.limitation.mapper.value` tag and set the `limitationType` attribute to Limitation type's identifier:

``` yaml
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 9, 12) =]]
```

When a value mapper exists for a Limitation, the rendering uses a Twig block named `ez_limitation_<lower_case_identifier>_value` where `<lower_case_identifier>` is the Limitation identifier in lower case.
In this example, block name is `ez_limitation_customlimitation_value` as the identifier is `CustomLimitation`.

This template receive a `values` variable which is the return of the `mapLimitationValue` function from the corresponding value mapper.

``` html+twig
[[= include_file('code_samples/back_office/limitation/templates/themes/standard/limitation/custom_limitation_value.html.twig') =]]
```

To have your block found, you have to register its template. Add the template to the configuration under `ezplatform.system.<SCOPE>.limitation_value_templates`:

``` yaml
[[= include_file('code_samples/back_office/limitation/config/packages/ezplatform_security.yaml') =]]
```

Provide translations for your custom limitation form in the `ezplatform_content_forms_policies` domain. For example, `translations/ezplatform_content_forms_policies.en.yaml`:

``` yaml
[[= include_file('code_samples/back_office/limitation/translations/ezplatform_content_forms_policies.en.yaml') =]]
```
