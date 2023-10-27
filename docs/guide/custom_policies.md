---
description: Create a custom Policy to cover non-standard permission needs.
---

# Custom Policies

The content Repository uses [Roles and Policies](permissions.md) to give Users access to different functions of the system.

Any bundle can expose available Policies via a `PolicyProvider` which can be added to EzPublishCoreBundle's [service container](../api/public_php_api.md#service-container) extension.

## PolicyProvider

A `PolicyProvider` object provides a hash containing declared modules, functions and Limitations.

- Each Policy provider provides a collection of permission *modules*.
- Each module can provide *functions* (e.g. in `content/read` "content" is the module, "read" is the function)
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

Limitations need to be implemented as *Limitation types* and declared as services identified with `ezpublish.limitationType` tag.
Name provided in the hash for each Limitation is the same value set in the `alias` attribute in the service tag.

For example:

``` php
<?php

namespace App\Security;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\ConfigBuilderInterface;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Security\PolicyProvider\PolicyProviderInterface;

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

An abstract class based on YAML is provided: `eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Security\PolicyProvider\YamlPolicyProvider`.
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
**It is however strongly encouraged to add functions to your own Policy modules.**

It is not possible to remove an existing module, function or limitation from a Policy.

## Integrating the `PolicyProvider` into EzPublishCoreBundle

For a `PolicyProvider` to be active, you have to register it in the class `src/Kernel.php`:

``` php
[[= include_file('code_samples/back_office/limitation/src/Kernel.php') =]]
```

## Custom Limitation type

For a custom module function, existing limitation types can be used or custom ones can be created.

The base of a custom limitation is a class to store values for the usage of this limitation in roles, and a class to implement the limitation's logic.

The value class extends `eZ\Publish\API\Repository\Values\User\Limitation` and says for which limitation it's used:

``` php
[[= include_file('code_samples/back_office/limitation/src/Security/Limitation/CustomLimitationValue.php') =]]
```

The type class implements `eZ\Publish\SPI\Limitation\Type`.
`accept`, `validate` and `buildValue` implement the value class usage logic.
`evaluate` challenge a limitation value against the current user, the subject object and other context objects to return is the limitation is satisfied or not. `evaluate` is, among others, used by `PermissionResolver::canUser` (to check if a user having access to a function can use it in its limitations) and `PermissionResolver::lookupLimitations`.

```php
[[= include_file('code_samples/back_office/limitation/src/Security/Limitation/CustomLimitationType.php') =]]
```

```yaml
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 1, 4) =]]
```

### Custom Limitation type form

TODO: Talk absolutely about MultipleSelectionBasedMapper and maybe about UDWBasedMapper

To provide support for editing custom policies in the Back Office, you need to implement [`EzSystems\EzPlatformAdminUi\Limitation\LimitationFormMapperInterface`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/lib/Limitation/LimitationFormMapperInterface.php).

``` php
[[= include_file('code_samples/back_office/limitation/src/Security/Limitation/Mapper/CustomLimitationFormMapper.php') =]]
```

And provide a template corresponding to `getFormTemplate`.

``` html+twig
[[= include_file('code_samples/back_office/limitation/templates/themes/admin/limitation/custom_limitation_form.html.twig') =]]
```

Next, register the service with the `ez.limitation.formMapper` tag and set the `limitationType` attribute to the Limitation type's identifier:

``` yaml
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 5, 8) =]]
```

To provide human-readable names for the custom Limitation values, you need to implement [`EzSystems\EzPlatformAdminUi\Limitation\LimitationValueMapperInterface`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/lib/Limitation/LimitationValueMapperInterface.php).

``` php
[[= include_file('code_samples/back_office/limitation/src/Security/Limitation/Mapper/CustomLimitationValueMapper.php') =]]
```

Then register the service with the `ez.limitation.valueMapper` tag and set the `limitationType` attribute to Limitation type's identifier:

``` yaml
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 9, 12) =]]
```

To render this custom limitation values in the role view,
create a Twig template containing block definition which follows the naming convention:
`ez_limitation_<LIMITATION TYPE>_value`. For example:

``` html+twig
[[= include_file('code_samples/back_office/limitation/templates/themes/standard/limitation/custom_limitation_value.html.twig') =]]
```

Add it to the configuration under `ezplatform.system.<SCOPE>.limitation_value_templates`:

```yaml
ezplatform:
    system:
        default:
            limitation_value_templates:
                - { template: '@ezdesign/limitation/custom_limitation_value.html.twig', priority: 0 }
```

Provide translations for your custom limitations in the `ezplatform_content_forms_policies` domain. For example, `translations/ezplatform_content_forms_policies.en.yaml`:

``` yaml
[[= include_file('code_samples/back_office/limitation/translations/ezplatform_content_forms_policies.en.yaml') =]]
```

### Checking user custom Limitation

To check if current user has this custom limitation set to true from a custom controller:
```php
<?php

namespace App\Controller;

use eZ\Publish\API\Repository\PermissionResolver;
use EzSystems\EzPlatformAdminUiBundle\Controller\Controller;
use EzSystems\EzPlatformAdminUi\Permission\PermissionCheckerInterface;
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

## Translations

`form` domain for policy creation and module display:
```yaml
# form.en.yaml
role.policy.custom_module: 'Custom Module'
role.policy.custom_module.all_functions: 'Custom Module / All functions'
role.policy.custom_module.custom_function_1: 'Custom Module / Custom function #1'
role.policy.custom_module.custom_function_2: 'Custom Module / Custom function #2'
```

`ezplatform_content_forms_role` domain for policy edition and limitation display:
```yaml
# ezplatform_content_forms_policies.en.yaml
policy.limitation.identifier.customlimitation: 'Custom Limitation'
```
