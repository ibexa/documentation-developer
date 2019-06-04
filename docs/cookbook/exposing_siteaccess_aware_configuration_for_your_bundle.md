# Exposing SiteAccess-aware configuration for your bundle

Symfony Config component makes it possible to define *semantic configuration*, exposed to the end developer.
This configuration is validated by rules you define, e.g. validating type (string, array, integer, boolean, etc.).
Usually, once validated and processed, this semantic configuration is then mapped to internal *key/value* parameters stored in the `ServiceContainer`.

eZ Platform uses this for its core configuration, but adds another configuration level, the **SiteAccess**.
For each defined SiteAccess, you need to be able to use the same configuration tree in order to define SiteAccess-specific config.
These settings then need to be mapped to SiteAccess-aware internal parameters that you can retrieve via the `ConfigResolver`.
For this, internal keys need to follow the format `<namespace>.<scope>.<parameter_name>`.
`namespace`is specific to your app or bundle, `scope`is the SiteAccess, SiteAccess group, `default` or `global`,
and `parameter_name`is the actual setting *identifier*.

For more information on ConfigResolver, namespaces and scopes, see [eZ Platform configuration basics](../guide/configuration.md).

The goal of this feature is to make it easy to implement a SiteAccess-aware semantic configuration and its mapping to internal config for any eZ Platform bundle developer.

## Semantic configuration parsing

An abstract `Configuration` class has been added, simplifying the way to add a SiteAccess settings tree like the following in `ezplatform.yaml`:

``` yaml
acme_example:
    system:
        <siteaccess>:
            foo: bar
            setting_a:
                number: 456
                enabled: true

        <siteaccess_group>:
            foo: baz
            setting_a:
                string: foobar
                number: 123
                enabled: false
```

The class's fully qualified name is `eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration`.
All you have to do is to extend it and use `$this->generateScopeBaseNode()`:

``` php
namespace Acme\ExampleBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration as SiteAccessConfiguration;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration extends SiteAccessConfiguration
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root( 'acme_example' );

        // $systemNode will then be the root of SiteAccess-aware settings.
        $systemNode = $this->generateScopeBaseNode($rootNode);
        $systemNode
            ->scalarNode( 'foo' )->isRequired()->end()
            ->arrayNode( 'setting_a' )
                ->children()
                    ->scalarNode( "string" )->end()
                    ->integerNode( "number" )->end()
                    ->booleanNode( "enabled" )->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
```

!!! note

    Default name for the *SiteAccess root node* is `system`, but you can customize it.
    To do this, pass the name you want to use as a second argument of `$this->generateScopeBaseNode()`.

## Mapping to internal settings

Semantic configuration must always be mapped to internal key/value settings within the `ServiceContainer`.
This is usually done in the DIC extension.

For SiteAccess-aware settings, new `ConfigurationProcessor` and `Contextualizer` classes have been introduced to ease the process.

``` php
namespace Acme\ExampleBundle\DependencyInjection;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ConfigurationProcessor;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ContextualizerInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class AcmeExampleExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load( 'default_settings.yaml' );

        // "acme_example" will be the namespace as used in ConfigResolver format.
        $processor = new ConfigurationProcessor($container, 'acme_example');
        $processor->mapConfig(
            $config,
            // Any kind of callable can be used here.
            // It will be called for each declared scope/SiteAccess.
            function ($scopeSettings, $currentScope, ContextualizerInterface $contextualizer)
            {
                // Will map the "foo" setting to "acme_example.<$currentScope>.foo" container parameter
                // It will then be possible to retrieve this parameter through ConfigResolver in the application code:
                // $helloSetting = $configResolver->getParameter( 'foo', 'acme_example' );
                $contextualizer->setContextualParameter('foo', $currentScope, $scopeSettings['foo']);
            }
        );

        // Now map "setting_a" and ensure the key defined for "my_siteaccess" overrides the one for "my_siteaccess_group"
        // It is done outside the closure as it is needed only once.
        $processor->mapConfigArray('setting_a', $config);
    }
}
```

!!! tip

    You can map simple settings by calling `$processor->mapSetting()`, without having to call `$processor->mapConfig()` with a callable.

    ``` php
    $processor = new ConfigurationProcessor($container, 'acme_example');
    $processor->mapSetting('foo', $config);
    ```

!!! caution "Important"

    Always ensure you have defined and loaded default settings.

In `@AcmeExampleBundle/Resources/config/default_settings.yaml`:

``` yaml
parameters:
    acme_example.default.foo: bar
    acme_example.default.setting_a:
        string: ~
        os_types: [windows]
        number: 0
        enabled: false
        language: php
```

### Merging hash values between scopes

When you define a hash as semantic config, you sometimes don't want the SiteAccess settings to replace the default or group values,
but *enrich* them by appending new entries. This is made possible by using `$processor->mapConfigArray()`,
which needs to be called outside the closure (before or after), in order to be called only once.

Consider the following default config in `default_settings.yaml`:

``` yaml
parameters:
    acme_example.default.setting_a:
        string: ~
        os_types: [windows]
        number: 0
        enabled: false
        language: php
```

And then this semantic config in `ezplatform.yaml`:

``` yaml
acme_example:
    system:
        siteaccess_group:
            setting_a:
                string: foobar
                number: 123

        # Assuming "siteaccess1" is part of "siteaccess_group"
        siteaccess1:
            setting_a:
                number: 456
                enabled: true
                language: javascript
```

What you want here is that keys defined for `setting_a` are merged between default/group/SiteAccess, like this:

``` yaml
parameters:
    acme_example.siteaccess1.setting_a:
        string: foobar
        os_types: [windows]
        number: 456
        enabled: true
        language: javascript
```

#### Merge from second level

In the example above, entries were merged in respect to the scope order of precedence. However, if you define the `planets` key for`siteaccess1`, it will completely override the default value since the merge process is done at only 1 level.

You can add another level by passing `ContextualizerInterface::MERGE_FROM_SECOND_LEVEL` as an option (third argument) to`$contextualizer->mapConfigArray()`.

In `default_settings.yaml`:

``` yaml
parameters:
    acme_example.default.setting_a:
        string: ~
        os_types: [windows]
        number: 0
        enabled: false
        language: [php]
```

Semantic config (`ezplatform.yaml` / `config.yaml`):

``` yaml
acme_example:
    system:
        siteaccess_group:
            setting_a:
                string: foobar
                os_types: [macos, linux]
                number: 123

        # Assuming "siteaccess1" is part of "siteaccess_group"
        siteaccess1:
            setting_a:
                number: 456
                enabled: true
                language: [javascript, python]
```

Result of using `ContextualizerInterface::MERGE_FROM_SECOND_LEVEL` option:

``` yaml
parameters:
    acme_example.siteaccess1.setting_a:
        string: foobar
        os_types: [windows, macos, linux]
        number: 456
        enabled: true
        language: [php, javascript, python]
```

There is also another option, `ContextualizerInterface::UNIQUE`,
to be used when you want to ensure your array setting has unique values. It will only work on normal arrays though, not hashes.

#### Limitations

A few limitations exist with this scope hash merge:

- Semantic setting name and internal name will be the same (like `foo_setting` in the examples above).
- Applicable to first level semantic parameter only (i.e. settings right under the SiteAccess name).
- Merge is not recursive. Only second level merge is possible by using `ContextualizerInterface::MERGE_FROM_SECOND_LEVEL` option.

## Dedicated mapper object

Instead of passing a callable to `$processor->mapConfig()`, an instance of `eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ConfigurationMapperInterface` can be passed.

This can be useful if you have a lot of configuration to map and don't want to pollute your DIC extension class (better for maintenance).

### Merging hash values between scopes

As specified above, `$contextualizer->mapConfigArray()` is not to be used within the *scope loop*, like for simple values.
When using a closure/callable, you usually call it before or after `$processor->mapConfig()`.
For mapper objects, a dedicated interface can be used: `HookableConfigurationMapperInterface`,
which defines 2 methods: `preMap()` and `postMap()`.
