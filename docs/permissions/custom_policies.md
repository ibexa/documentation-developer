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

### Extending existing Policies

A `PolicyProvider` may provide new functions to a module, and additional Limitations to an existing function.
**It's however strongly encouraged to add functions to your own Policy modules.**

It's impossible to remove an existing module, function or limitation from a Policy.

## Integrating the `PolicyProvider` into IbexaCoreBundle

For a `PolicyProvider` to be active, you have to register it in the class `src/Kernel.php`:

``` php
[[= include_file('code_samples/back_office/limitation/src/Kernel.php') =]]
```

## Integrating custom Limitation types with the UI

To provide support for editing custom policies in the Back Office, you need to implement [`Ibexa\AdminUi\Limitation\LimitationFormMapperInterface`](https://github.com/ibexa/admin-ui/blob/main/src/lib/Limitation/LimitationFormMapperInterface.php).

Next, register the service with the `ibexa.admin_ui.limitation.mapper.form` tag and set the `limitationType` attribute to the Limitation type's identifier:

``` yaml
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 5, 8) =]]
```

If you want to provide human-readable names of the custom Limitation values, you need to implement [`Ibexa\AdminUi\Limitation\LimitationValueMapperInterface`](https://github.com/ibexa/admin-ui/blob/main/src/lib/Limitation/LimitationValueMapperInterface.php).

Then register the service with the `ibexa.admin_ui.limitation.mapper.form` tag and set the `limitationType` attribute to Limitation type's identifier:

``` yaml
[[= include_file('code_samples/back_office/limitation/config/append_to_services.yaml', 9, 12) =]]
```

If you want to completely override the way of rendering custom Limitation values in the role view,
create a Twig template containing block definition which follows the naming convention:
`ez_limitation_<LIMITATION TYPE>_value`. For example:

``` html+twig
{# This file contains block definition which is used to render custom Limitation values #}
{% block ez_limitation_custom_value %}
    <span style="color: red">{{ values }}</span>
{% endblock %}
```

Add it to the configuration under `ibexa.system.<SCOPE>.limitation_value_templates`:

``` yaml
[[= include_file('code_samples/back_office/limitation/config/packages/ibexa_security.yaml') =]]
```

!!! note

    If you skip this part, Limitation values will be rendered using an [`ez_limitation_value_fallback`](https://github.com/ibexa/admin-ui/blob/main/src/bundle/Resources/views/themes/admin/limitation/limitation_values.html.twig#L1-L6) block as comma-separated list.

You can also provide translation of the Limitation type identifier by adding an entry to the translation file under the `ezrepoforms_policies` domain.
The key must follow the naming convention: `policy.limitation.identifier.<LIMITATION TYPE>`.
For example:

```xml
<trans-unit id="76adf2a27f1ae0ab14b623729cd3f281a6e2c285" resname="policy.limitation.identifier.group">
  <source>Content Type Group</source>
  <target>Content Type Group</target>
  <note>key: policy.limitation.identifier.group</note>
</trans-unit>
```
