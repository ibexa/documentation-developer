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

``` php {skip-validation}
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

``` php {skip-validation}
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
[[= include_code('code_samples/back_office/limitation/src/Security/MyPolicyProvider.php') =]]
```

In `src/Resources/config/policies.yaml`:

``` yaml
[[= include_file('code_samples/back_office/limitation/src/Resources/config/policies.yaml', 0, 3) =]]
```

### Translations

Provide translations for your custom policies in the `forms` domain.

For example, `translations/forms.en.yaml`:

``` yaml
[[= include_file('code_samples/back_office/limitation/translations/forms.en.yaml', 0, 4) =]]
```

You can also implement `TranslationContainerInterface` to provide those translations in your policy provider class:

``` php {skip-validation}
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
php bin/console jms:translation:extract en --domain=forms --dir=src --output-dir=translations
```

## `PolicyProvider` integration into `IbexaCoreBundle`

For a `PolicyProvider` to be active, you have to register it in the `src/Kernel.php`:

``` php hl_lines="20 23"
[[= include_file('code_samples/back_office/limitation/src/Kernel.php', 0, 6) =]][[= include_file('code_samples/back_office/limitation/src/Kernel.php', 7, 23) =]][[= include_file('code_samples/back_office/limitation/src/Kernel.php', 24, 28) =]]
```

## Custom limitation type

For a custom module function, you can use existing limitation types or create custom ones.

The base of a custom limitation is a class to store values for the usage of this limitation in roles, and a class to implement the limitation's logic.

The value class extends `Ibexa\Contracts\Core\Repository\Values\User\Limitation` and says for which limitation it's used:

``` php
[[= include_code('code_samples/back_office/limitation/src/Security/Limitation/CustomLimitationValue.php') =]]
```

The type class implements `Ibexa\Contracts\Core\Limitation\Type`.

- `accept`, `validate` and `buildValue` implement the value class usage logic.
- `evaluate` challenges a limitation value against the current user, the subject object and other context objects to return if the limitation is satisfied or not. `evaluate` is, among others, used by `PermissionResolver::canUser` (to check if a user that has access to a function can use it in its limitations) and `PermissionResolver::lookupLimitations`.

``` php
[[= include_code('code_samples/back_office/limitation/src/Security/Limitation/CustomLimitationType.php') =]]
```

The type class is set as a service tagged `ibexa.permissions.limitation_type` with an alias to identify it, and to link it to the value.

``` yaml
services:
    # …
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 1, 4) =]]
```

### Custom limitation type form

#### Form mapper

To provide support for editing custom policies in the back office, you need to implement [`Ibexa\AdminUi\Limitation\LimitationFormMapperInterface`](https://github.com/ibexa/admin-ui/blob/5.0/src/lib/Limitation/LimitationFormMapperInterface.php).

- `mapLimitationForm` adds the limitation field as a child to a provided Symfony form.
- `getFormTemplate` returns the path to the template to use for rendering the limitation form. Here it use [`form_label`]([[= symfony_doc =]]/form/form_customization.html#reference-forms-twig-label) and [`form_widget`]([[= symfony_doc =]]/form/form_customization.html#reference-forms-twig-widget) to do so.
- `filterLimitationValues` is triggered when the form is submitted and can manipulate the limitation values, such as normalizing them.

``` php
[[= include_code('code_samples/back_office/limitation/src/Security/Limitation/Mapper/CustomLimitationFormMapper.php') =]]
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

By default, without a value mapper, the limitation value is rendered by using the block `ibexa_limitation_value_fallback` of the template [`vendor/ibexa/admin-ui/src/bundle/Resources/views/themes/admin/limitation/limitation_values.html.twig`](https://github.com/ibexa/admin-ui/blob/v[[= latest_tag_5_0 =]]/src/bundle/Resources/views/themes/admin/limitation/limitation_values.html.twig).

To customize the rendering, a value mapper eventually transforms the limitation value and sends it to a custom template.

The value mapper implements [`Ibexa\AdminUi\Limitation\LimitationValueMapperInterface`](https://github.com/ibexa/admin-ui/blob/4.5/src/lib/Limitation/LimitationValueMapperInterface.php).

Its `mapLimitationValue` function returns the limitation value transformed for the needs of the template.

``` php
[[= include_code('code_samples/back_office/limitation/src/Security/Limitation/Mapper/CustomLimitationValueMapper.php') =]]
```

Then register the service with the `ibexa.admin_ui.limitation.mapper.value` tag and set the `limitationType` attribute to limitation type's identifier:

``` yaml
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 9, 12) =]]
```

When a value mapper exists for a limitation, the rendering uses a Twig block named `ibexa_limitation_<lower_case_identifier>_value` where `<lower_case_identifier>` is the limitation identifier in lower case.
In this example, block name is `ibexa_limitation_customlimitation_value` as the identifier is `CustomLimitation`.

This template receives a `values` variable which is the return value of the `mapLimitationValue` function from the corresponding value mapper.

``` html+twig
[[= include_file('code_samples/back_office/limitation/templates/themes/standard/limitation/custom_limitation_value.html.twig') =]]
```

To have your block found, you have to register its template.
Add the template to the configuration under `ibexa.system.<SCOPE>.limitation_value_templates`:

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

``` php
[[= include_code('code_samples/back_office/limitation/src/Controller/CustomController.php') =]]
```

## Restrict access to form submissions

By default, access to a [Form content item](form_builder_guide.md#forms-management) is controlled by the `content/read` policy.
As a result, all users who can view a form in the back office can also [access](form_builder_guide.md#view-results) its [**Submissions** tab](back_office_tabs.md).

However, form submissions may require stricter access control than the form itself, for example, to conform with GDPR regulations.
To tackle this, you must separate the permissions by introducing a dedicated policy that manages access to form submission:

- define a custom policy: `form/read_submissions`
- enforce the policy on the PHP API level
- enforce the policy in the back office

With this setup, users with `content/read` permission can view the form, but cannot see the **Submissions** tab, while users with `form/read_submissions` can access the submissions, export and manage submitted data (depending on other permissions).

!!! note "Implementation notes"
    - This implementation uses service decoration and extends internal classes.
    - Some internal methods are not publicly reusable, which may require additional calls, for example, `gateway->loadById($id)` or minor workarounds.
    - When upgrading, review these customizations to ensure compatibility with internal API changes.

### Define custom policy

First, create the `FormPolicyProvider.php` policy provider that registers the new `form` module and the `read_submissions` function by injecting the custom permission into the configuration tree:

``` php hl_lines="14-18 26"
[[= include_code('code_samples/back_office/limitation/src/Security/FormPolicyProvider.php') =]]
```

Next, extract the [translations](#translations) to the `translations/forms.en.xlf` file.

Then, register the provider in the Kernel by overriding the `build()` method.
Unlike standard Symfony runtime services, policy providers must be registered explicitly in the application kernel, because they are consumed during the container compilation phase.

``` php hl_lines="19 22"
[[= include_file('code_samples/back_office/limitation/src/Kernel.php', 0, 7) =]][[= include_file('code_samples/back_office/limitation/src/Kernel.php', 8, 18) =]][[= include_file('code_samples/back_office/limitation/src/Kernel.php', 19, 24) =]][[= include_file('code_samples/back_office/limitation/src/Kernel.php', 25, 28) =]]
```

Then, add a service definition to `config/services.yaml`:

``` yaml
services:
    # …
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 13, 16) =]]
```

Finally, add the policy definition  in `src/Resources/config/policies.yaml`:

``` yaml
[[= include_file('code_samples/back_office/limitation/src/Resources/config/policies.yaml', 3, 5) =]]
```

This way, after you clean the cache, the new policy becomes available when you [edit the policies assigned to a Role](https://doc.ibexa.co/projects/userguide/en/latest/permission_management/work_with_permissions/).

### Secure access on PHP API level

To enforce the policy on the PHP API level, decorate the form submission service to enforce permission checks.
In `src/Security`, create the `FormSubmissionServiceDecorator.php` file:

``` php hl_lines="19 33 40 41 44"
[[= include_code('code_samples/back_office/limitation/src/Security/Form/FormSubmissionServiceDecorator.php') =]]
```

!!! note "Duplicate method calls"

    To perform a permission check for `$content`, it is fetched by `gateway->loadById($id)`.
    After permission is checked, `loadById($id)` is called again to prevent having to copy private method implementations into the decorator.

Then, add a service definition to `config/services.yaml`:

``` yaml
services:
    # …
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 23, 27) =]]
```

This way, users can't access the submission data unless they have the `form/read_submissions` policy added to their role.

### Secure back office access

To enforce the policy in the back office, decorate the **Submissions** tab to hide it when the user lacks permission.
In `src/Security`, create the `FormSubmissionsTabDecorator.php` file:

``` php hl_lines="19 30 60-61"
[[= include_code('code_samples/back_office/limitation/src/Security/Form/FormSubmissionsTabDecorator.php') =]]
```

Then, add a service definition to `config/services.yaml`:

``` yaml
services:
    # …
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 17, 22) =]]
```

This way, users can't view the **Submissions** tab unless they have the `form/read_submissions` policy added to their role.
