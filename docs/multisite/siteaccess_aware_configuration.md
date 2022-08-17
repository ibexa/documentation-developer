---
description: Make sure your custom development's configuration can be used with SiteAccesses.
---

# SiteAccess-aware configuration

The [Symfony Config component]([[= symfony_doc =]]/components/config.html) makes it possible to define semantic configuration, exposed to the end developer.
This configuration is validated by rules you define, e.g. validating type (string, array, integer, boolean and so on).
Usually, after it is validated and processed, this semantic configuration is then mapped to internal *key/value* parameters stored in the service container.

[[= product_name =]] uses this for its core configuration, but adds another configuration level, the SiteAccess.
For each defined SiteAccess, you need to be able to use the same configuration tree to define SiteAccess-specific config.

These settings then need to be mapped to SiteAccess-aware internal parameters 
that you can retrieve with the [ConfigResolver](dynamic_configuration.md#configresolver).
For this, internal keys need to follow the format `<namespace>.<scope>.<parameter_name>`. where:

- `namespace` is specific to your app or bundle
- `scope` is the SiteAccess, SiteAccess group, `default` or `global`
- `parameter_name` is the actual setting *identifier*

For more information about the ConfigResolver, namespaces and scopes, see [configuration basics](configuration.md).

!!! tip "Repository-aware configuration"

    If you need to use different settings per Repository, not per SiteAccess,
    see [Repository-aware configuration](repository_configuration.md#repository-aware-configuration).

The example below assumes you are using an `Acme\ExampleBundle`.
Remember to register the bundle by adding it to `config/bundles.php`:

``` php
Acme\ExampleBundle\AcmeExampleBundle::class => ['all' => true],
```

### Parsing semantic configuration

To parse semantic configuration, create a `Configuration` class which extends
`Ibexa\Bundle\Core\DependencyInjection\Configuration\SiteAccessAware\Configuration`
and then extend its `generateScopeBaseNode()` method:

``` php hl_lines="17"
<?php

namespace Acme\ExampleBundle\DependencyInjection;

use Ibexa\Bundle\Core\DependencyInjection\Configuration\SiteAccessAware\Configuration as SiteAccessConfiguration;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration extends SiteAccessConfiguration
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('acme_example');
        $rootNode = $treeBuilder->getRootNode();

        // $systemNode is the root of SiteAccess-aware settings.
        $systemNode = $this->generateScopeBaseNode($rootNode);
        $systemNode
            ->scalarNode('name')->isRequired()->end()
            ->arrayNode('custom_setting')
                ->children()
                    ->scalarNode('string')->end()
                    ->integerNode('number')->end()
                    ->booleanNode('enabled')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
```

!!! note

    Default name for the *SiteAccess root node* is `system`, but you can customize it.
    To do this, pass the name you want to use as a second argument of `$this->generateScopeBaseNode()`.

This enables you to use the following SiteAccess-aware configuration:

``` yaml
acme_example:
    system:
        <siteaccess>:
            name: name_1
            custom_setting:
                number: 456
                enabled: true
        <siteaccess_group>:
            name: name_2
            custom_setting:
                string: value
                number: 123
                enabled: false
```

### Mapping to internal settings

Semantic configuration must always be mapped to internal key/value settings within the service container.
You usually do it in the [service container](php_api.md#service-container) extension.

``` php
<?php

namespace Acme\ExampleBundle\DependencyInjection;

use Ibexa\Bundle\Core\DependencyInjection\Configuration\SiteAccessAware\ConfigurationProcessor;
use Ibexa\Bundle\Core\DependencyInjection\Configuration\SiteAccessAware\ContextualizerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class AcmeExampleExtension extends Extension
{
    public const ACME_CONFIG_DIR = __DIR__ . '/../../../config/acme';

    /**
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(self::ACME_CONFIG_DIR));
        $loader->load('default_settings.yaml');

        $processor = new ConfigurationProcessor($container, 'acme_example');
        $processor->mapConfig(
            $config,
            // Any kind of callable can be used here.
            // It is called for each declared scope/SiteAccess.
            static function ($scopeSettings, $currentScope, ContextualizerInterface $contextualizer) {
                // Maps the "name" setting to "acme_example.<$currentScope>.name" container parameter
                // It is then possible to retrieve this parameter through ConfigResolver in the application code:
                // $helloSetting = $configResolver->getParameter( 'name', 'acme_example' );
                $contextualizer->setContextualParameter('name', $currentScope, $scopeSettings['name']);
            }
        );

        // Now map "custom_setting" and ensure the key defined for "my_siteaccess" overrides the one for "my_siteaccess_group"
        // It is done outside the closure as it is needed only once.
        $processor->mapConfigArray('custom_setting', $config);
    }
}
```

You can also map simple settings by calling `$processor->mapSetting()`, without having to call `$processor->mapConfig()` with a callable.

``` php
$processor = new ConfigurationProcessor($container, 'acme_example');
$processor->mapSetting('name', $config);
```

!!! caution "Important"

    Always ensure you have defined and loaded default settings.

In `@AcmeExampleBundle/Resources/config/default_settings.yaml`:

``` yaml
parameters:
    acme_example.default.name: name_1
    acme_example.default.custom_setting:
        string: ~
        number: 0
        enabled: false
```

#### Merging hash values between scopes

When you define a hash as semantic config, you sometimes do not want the SiteAccess settings to replace the default or group values,
but enrich them by appending new entries. This is possible by using `$processor->mapConfigArray()`,
which you must call outside the closure (before or after), so that it is called only once.

``` php
$processor->mapConfigArray('custom_setting', $config);
```

Consider the following default config in `default_settings.yaml`:

``` yaml
parameters:
    acme_example.default.custom_setting:
        string: ~
        os_types: [windows]
        number: 0
        enabled: false
        language: php
```

And then this semantic configuration in `config/packages/acme.yaml`:

``` yaml
acme_example:
    system:
        siteaccess_group:
            custom_setting:
                string: value
                number: 123

        # Assuming "siteaccess1" is part of "siteaccess_group"
        siteaccess1:
            custom_setting:
                os_types: [linux, macos]
                number: 456
                enabled: true
                language: javascript
```

By calling `mapConfigArray()` you can get the following end configuration, 
where keys defined for `custom_setting` in default/group/SiteAccess scopes are merged:

``` yaml
parameters:
    acme_example.siteaccess1.custom_setting:
        string: value
        os_types: [linux, macos]
        number: 456
        enabled: true
        language: javascript
```

##### Merging from second level

In the example above, entries were merged in respect to the scope order of precedence.
However, because you defined the `os_types` key for `siteaccess1`, it completely overrode the default value,
because the merge process is done only at the first level.

You can add another level by passing `ContextualizerInterface::MERGE_FROM_SECOND_LEVEL`
as the third argument to `$contextualizer->mapConfigArray()`:

``` php
$contextualizer->mapConfigArray('custom_setting', $config, ContextualizerInterface::MERGE_FROM_SECOND_LEVEL);
```

When you use `ContextualizerInterface::MERGE_FROM_SECOND_LEVEL` with the configuration above, you get the following result:

``` yaml
parameters:
    acme_example.siteaccess1.custom_setting:
        string: value
        os_types: [windows, linux, macos]
        number: 456
        enabled: true
        language: javascript
```

There is also another option, `ContextualizerInterface::UNIQUE`,
that ensures the array setting has unique values. It only works on normal arrays, not hashes.

!!! note

    Merge is not recursive. Only second level merge is possible by using `ContextualizerInterface::MERGE_FROM_SECOND_LEVEL` option.

### Dedicated mapper object

Instead of passing a callable to `$processor->mapConfig()`, you can pass an instance of
`Ibexa\Bundle\Core\DependencyInjection\Configuration\SiteAccessAware\ConfigurationMapperInterface`.

This can be useful if you have a lot of configuration to map and do not want to pollute 
your service container extension class (it is better for maintenance).

#### Merging hash values between scopes

You should not use `$contextualizer->mapConfigArray()` within the scope loop, like for simple values.
When using a closure/callable, you usually call it before or after `$processor->mapConfig()`.
For mapper objects, you can use a dedicated interface: `HookableConfigurationMapperInterface`,
which defines two methods: `preMap()` and `postMap()`.
