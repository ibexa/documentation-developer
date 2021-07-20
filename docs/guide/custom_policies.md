# Custom Policies

The content Repository uses [Roles and Policies](permissions.md) to give Users access to different functions of the system.

Any bundle can expose available Policies via a `PolicyProvider` which can be added to EzPublishCoreBundle's [service container](../api/service_container.md) extension.

## PolicyProvider

A `PolicyProvider` object provides a hash containing declared modules, functions and Limitations.

- Each Policy provider provides a collection of permission *modules*.
- Each module can provide *functions* (e.g. in `content/read` "content" is the module, "read" is the function)
- Each function can provide a collection of Limitations.

First level key is the module name, value is a hash of available functions, with function name as key.
Function value is an array of available Limitations, identified by the alias declared in `LimitationType` service tag.
If no Limitation is provided, value can be `null` or an empty array.

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
namespace Acme\FooBundle\AcmeFooBundle\Security;

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

``` php
namespace Acme\ExampleBundle\AcmeExampleBundle\Security;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Security\PolicyProvider\YamlPolicyProvider;

class MyPolicyProvider extends YamlPolicyProvider
{
    protected function getFiles()
    {
        return [
             __DIR__ . '/../Resources/config/policies.yml',
         ];
    }
}
```

In `AcmeExampleBundle/Resources/config/policies.yml`:

``` yaml
custom_module:
    custom_function_1: ~
    custom_function_2: [CustomLimitation]
```

### Extending existing policies

A `PolicyProvider` may provide new functions to a module, and additional Limitations to an existing function. 
**It is however strongly encouraged to add functions to your own Policy modules.**

It is not possible to remove an existing module, function or limitation from a Policy.

## Integrating the `PolicyProvider` into EzPublishCoreBundle

For a `PolicyProvider` to be active, it must be properly declared in EzPublishCoreBundle.
A bundle just has to retrieve CoreBundle's DIC extension and call `addPolicyProvider()`. This must be done in the bundle's `build()` method.

``` php
namespace Acme\ExampleBundle\AcmeExampleBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AcmeExampleBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        // ...
 
        // Retrieve "ezpublish" container extension
        $eZExtension = $container->getExtension('ezpublish');
        // Add the policy provider
        $eZExtension->addPolicyProvider(new MyPolicyProvider());
    }
}
```

## Integrating custom Limitation types with the UI

To provide support for editing custom policies in the Back Office you need to implement [`EzSystems\RepositoryForms\Limitation\LimitationFormMapperInterface`](https://github.com/ezsystems/repository-forms/blob/v2.5.4/lib/Limitation/LimitationFormMapperInterface.php).

Next, register the service in DIC (Dependency Injection Container) with the `ez.limitation.formMapper` tag and set the `limitationType` attribute to the Limitation type's identifier:

```yml
acme.security.limitation.custom_limitation.mapper:
    class: 'AppBundle\Security\Limitation\Mapper\CustomLimitationFormMapper'
    arguments:
        # ...
    tags:
        - { name: 'ez.limitation.formMapper', limitationType: 'Custom' }
```

If you want to provide human-readable names of the custom Limitation values, you need to implement [`\EzSystems\RepositoryForms\Limitation\LimitationValueMapperInterface`](https://github.com/ezsystems/repository-forms/blob/v2.5.4/lib/Limitation/LimitationValueMapperInterface.php).

Then register the service in DIC with the `ez.limitation.valueMapper` tag and set the `limitationType` attribute to Limitation type's identifier:

```yml
acme.security.limitation.custom_limitation.mapper:
    class: 'AppBundle\Security\Limitation\Mapper\CustomLimitationValueMapper'
    arguments:
        # ...
    tags:
        - { name: 'ez.limitation.valueMapper', limitationType: 'Custom' }
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

Add it to the configuration under `ezpublish.system.<SCOPE>.limitation_value_templates`:

```yml
ezpublish:
    system:
        default:
            limitation_value_templates:
                - { template: AppBundle:Limitation:custom_limitation_value.html.twig, priority: 0 }

```

!!! note

    If you skip this part, Limitation values will be rendered using an [`ez_limitation_value_fallback`](https://github.com/ezsystems/repository-forms/blob/v2.5.4/bundle/Resources/views/limitation_values.html.twig) block as comma-separated list.

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
