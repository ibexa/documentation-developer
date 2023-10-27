---
description: Create a custom Policy to cover non-standard permission needs.
---

# Custom Policies

The content Repository uses [Roles and Policies](permissions.md) to give Users access to different functions of the system.

Any bundle can expose available Policies via a `PolicyProvider` which can be added to EzPublishCoreBundle's [service container](../api/public_php_api.md#service-container) extension.

## PolicyProvider

A `PolicyProvider` object provides a hash containing declared modules, functions and Limitations.

- Each Policy provider provides a collection of permission *modules*.
- Each module can provide *functions* (e.g. in `content/read` "content" is the module, "read" is the function)
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

Limitations need to be implemented as *Limitation types* and declared as services identified with `ezpublish.limitationType` tag.
Name provided in the hash for each Limitation is the same value set in the `alias` attribute in the service tag.

For example:

``` php
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

## YamlPolicyProvider

An abstract class based on YAML is provided: `eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Security\PolicyProvider\YamlPolicyProvider`.
It defines an abstract `getFiles()` method.

Extend `YamlPolicyProvider` and implement `getFiles()` to return absolute paths to your YAML files.

```php
namespace App\Security;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Security\PolicyProvider\YamlPolicyProvider;

class MyPolicyProvider extends YamlPolicyProvider
{
    protected function getFiles()
    {
        return [
             __DIR__ . '/../Resources/config/policies.yaml',
         ];
    }
}
```

In `config/packages/policies.yaml`:

```yaml
custom_module:
    custom_function_1: ~
    custom_function_2: [CustomLimitation]
```

### Extending existing Policies

A `PolicyProvider` may provide new functions to a module, and additional Limitations to an existing function. 
**It is however strongly encouraged to add functions to your own Policy modules.**

It is not possible to remove an existing module, function or limitation from a Policy.

## Integrating the `PolicyProvider` into EzPublishCoreBundle

For a `PolicyProvider` to be active, you have to register it in the class `src/Kernel.php`:

```php
namespace App;

use App\Security\MyPolicyProvider;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        // ...
        
        // Retrieve "ezpublish" container extension
        $eZExtension = $container->getExtension('ezpublish');
        // Add the policy provider
        $eZExtension->addPolicyProvider(new MyPolicyProvider());
    }
}
```

## Custom Limitation Type

For a custom module function, existing limitation types can be used or custom ones can be created.

```php
<?php

namespace App\Security\Limitation;

use eZ\Publish\API\Repository\Values\User\Limitation;

class CustomLimitationValue extends Limitation
{
    public function getIdentifier(): string
    {
        return 'CustomLimitation';
    }
}
```

```php
<?php

namespace App\Security\Limitation;

use eZ\Publish\API\Repository\Values\User\Limitation;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;
use eZ\Publish\SPI\Limitation\Type;

class CustomLimitationType extends Type
{
    public function acceptValue(Limitation $limitationValue)
    {
        if (!$limitationValue instanceof CustomLimitationValue) {
            throw new InvalidArgumentType(
                '$limitationValue',
                FieldGroupLimitation::class,
                $limitationValue
            );
        }
    }
    
    public function validate(Limitation $limitationValue)
    {
        return [];
    }
    
    public function buildValue(array $limitationValues)
    {
        $value = false;
        if (array_key_exists('value', $limitationValues)) {
            $value = $limitationValues['value'];
        } elseif (count($limitationValues)) {
            $value = (bool)$limitationValues[0];
        }
        return new CustomLimitationValue(['limitationValues' => ['value' => $value]]);
    }

    //TODO: evaluate(APILimitationValue $value, APIUserReference $currentUser, APIValueObject $object, array $targets = null)
}
```

```yaml
services:
    # ...
    App\Security\Limitation\CustomLimitationType:
        # ...
        tags:
            - { name: 'ezpublish.limitationType', alias: 'CustomLimitation' }
```

TODO: Talk absolutely about MultipleSelectionBasedMapper and maybe about UDWBasedMapper

## Integrating custom Limitation types with the UI

To provide support for editing custom policies in the Back Office, you need to implement [`EzSystems\EzPlatformAdminUi\Limitation\LimitationFormMapperInterface`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/lib/Limitation/LimitationFormMapperInterface.php).

```php
<?php

namespace App\Security\Limitation\Mapper;

use eZ\Publish\API\Repository\Values\User\Limitation;
use EzSystems\EzPlatformAdminUi\Translation\Extractor\LimitationTranslationExtractor;
use EzSystems\RepositoryForms\Limitation\LimitationFormMapperInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CustomLimitationFormMapper implements LimitationFormMapperInterface
{
    public function mapLimitationForm(FormInterface $form, Limitation $data)
    {
        $form->add('limitationValues', CheckboxType::class, [
            'label' => LimitationTranslationExtractor::identifierToLabel($data->getIdentifier()),
            'required' => false,
            'data' => $data->limitationValues['value'],
            'property_path' => 'limitationValues[value]'
        ]);
    }

    public function getFormTemplate()
    {
        return '@ezdesign/limitation/custom_limitation_form.html.twig';
    }

    //TODO: public function filterLimitationValues(Limitation $limitation)
}
```

```html+twig
{# templates/themes/standard/limitation/custom_limitation_form.html.twig #}
{{ form_label(form.limitationValues) }}
{{ form_widget(form.limitationValues) }}
```

Next, register the service with the `ez.limitation.formMapper` tag and set the `limitationType` attribute to the Limitation type's identifier:

```yaml
App\Security\Limitation\Mapper\CustomLimitationFormMapper:
    arguments:
        # ...
    tags:
        - { name: 'ez.limitation.formMapper', limitationType: 'CustomLimitation' }
```

If you want to provide human-readable names of the custom Limitation values, you need to implement [`EzSystems\EzPlatformAdminUi\Limitation\LimitationValueMapperInterface`](https://github.com/ezsystems/ezplatform-admin-ui/blob/master/src/lib/Limitation/LimitationValueMapperInterface.php).

```php
<?php

namespace App\Security\Limitation\Mapper;

use eZ\Publish\API\Repository\Values\User\Limitation;
use EzSystems\EzPlatformAdminUi\Limitation\LimitationValueMapperInterface;

class CustomLimitationValueMapper implements LimitationValueMapperInterface
{
    public function mapLimitationValue(Limitation $limitation)
    {
        return $limitation->limitationValues['value'];
    }
}
```

Then register the service with the `ez.limitation.valueMapper` tag and set the `limitationType` attribute to Limitation type's identifier:

```yaml
App\Security\Limitation\Mapper\CustomLimitationValueMapper:
    arguments:
        # ...
    tags:
        - { name: 'ez.limitation.valueMapper', limitationType: 'CustomLimitation' }
```

To render this custom limitation values in the role view,
create a Twig template containing block definition which follows the naming convention:
`ez_limitation_<LIMITATION TYPE>_value`. For example:

``` html+twig
{# templates/themes/standard/limitation/custom_limitation_value.html.twig #}
{% block ez_limitation_customlimitation_value %}
    <span style="color: {{ values ? 'green' : 'red' }};">{{ values ? 'Yes' : 'No' }}</span>
{% endblock %}
```

Add it to the configuration under `ezplatform.system.<SCOPE>.limitation_value_templates`:

```yaml
ezplatform:
    system:
        default:
            limitation_value_templates:
                - { template: '@ezdesign/limitation/custom_limitation_value.html.twig', priority: 0 }
```

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
