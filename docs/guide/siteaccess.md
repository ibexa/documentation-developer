# SiteAccess

## Introduction

[[= product_name =]] enables you to maintain multiple sites in one installation using a feature called **SiteAccesses**.

In short, a SiteAccess is a set of configuration settings that is used when you reach the site through a specific address.
When the user visits the site, the system analyzes the URI and compares it to rules specified in the configuration. If it finds a set of fitting rules, this SiteAccess is used.

Settings defined per SiteAccess may include, among others, database, language or `var` directory.
When that SiteAccess is used, they override the default configuration.

### Selecting SiteAccesses

A SiteAccess is selected using one or more matchers – rules based on the uri or its parts. Example matching criteria are elements of the uri, host name (or its parts), port number, etc.

For detailed information on how SiteAccess matchers work, see [SiteAccess Matching](siteaccess_matching.md).

### SiteAccesses use cases

Typical uses of a SiteAccess are:

- different language versions of the same site identified by a uri part; one SiteAccess for one language
- two different versions of a website: one SiteAccess with a public interface for visitors and one with a restricted interface for administrators

!!! note "SiteAccess switching [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]"

    If you need to change between SiteAccesses in Site mode, do not use any functions in the page itself (for example, a language switcher). This may cause unexpected errors. Instead, switch between SiteAccesses using the SiteAccess bar above the page.

#### `admin` SiteAccess

The back-office UI of [[= product_name =]] is housed in a predefined `admin` SiteAccess in `admin_group`.

If you have a multisite setup with a separate back-office interface for each site,
you need to create your own admin SiteAccesses and add them to this group. In cases where the sites are on separate databases they will need their own [repository](configuration.md#configuration-examples) (including their own storage and search connection), var dir, [cache pool](persistence_cache.md#persistence-cache-configuration), and ideally also separate Varnish/Fastly config for each site individually.

## Configuring SiteAccesses

You configure SiteAccess in your config files (e.g. `ezplatform.yaml`) under the `ezplatform.siteacess` keys.
The required elements of the configuration are:

#### `list`

Lists all SiteAccesses in the installation.

#### `default_siteaccess`

Identifies which SiteAccess will be used by default when no other is specified.

#### `groups` (optional)

Collects SiteAccesses into groups that can be used later for configuration.

#### `match`

The rule or set of rules by which SiteAccesses are matched. See [SiteAccess matching](siteaccess_matching.md) for more information.

### SiteAccess selection in Page Builder [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

To define which SiteAccesses are available in the submenu in Page Builder, use the following configuration.
`siteaccess_list` is an array of SiteAccess identifiers:

``` yaml
ezplatform:
    system:
        admin:
            page_builder:
                siteaccess_list: [site, de, fr, no]
        de:
            page_builder:
                siteaccess_list: [site, de]
```

If you are using multiple domains, list all domains for an admin SiteAccess under `siteaccess_hosts`:

``` yaml
ezpublish:
    system:
        admin:
            page_builder:
                siteaccess_list: [site, de, fr, no]
                siteaccess_hosts:
                    - my_domain.com
                    - another_domain.org
```

### Settings per SiteAccess

Various system settings can be set per SiteAccess or SiteAccess group under the `ezplatform.system` key. These settings include languages or the `var` directory.

### Multilanguage sites

A site has content in two languages: English and Norwegian. It has one URI per language: `http://example.com/eng` and `http://example.com/nor`. Uri parts of each language (eng, nor) are mapped to a *SiteAccess*, commonly named like the URI part: `eng`, `nor`. Using semantic configuration, each of these SiteAccesses can be assigned a prioritized list of languages it should display:

- The English site would display content in English and ignore Norwegian content;
- The Norwegian site would display content in Norwegian but also in English *if it does not exist in Norwegian*.

Such configuration would look like this:

``` yaml
ezplatform:
    siteaccess:
        # There are two SiteAccesses
        list: [eng, nor]
 
        # eng is the default one if no prefix is specified
        default_siteaccess: eng

        # the first URI of the element is used to find a SiteAccess with a similar name
        match:
            URIElement: 1


ezplatform:
    # root node for configuration per SiteAccess
    system:
        # Configuration for the 'eng' SiteAccess
        eng:
            languages: [eng-GB]
        nor:
            languages: [nor-NO, eng-GB]
```

!!! note

    A new SiteAccess is recognized by the system, but an Anonymous User will not have read access to it until it is [explicitly given via the Admin > Roles panel](permissions.md#use-cases). Without read access the Anonymous User will simply be directed to the default login page.

### Defining SiteAccess name

In order to simplify the interface and create a better editorial experience, you can "hide"
 the SiteAccess code and substitute it with a human-readable name of the website e.g. `Tasteful Planet`, `Page EN`.

List of interfaces where you can apply SiteAccess names:

- Page Builder (SiteAccess switcher in the top navigation)

- [Content Preview](https://doc.ezplatform.com/projects/userguide/en/latest/creating_content_basic/#previewing-content) (SiteAccess switcher in the dropdown menu)

- Page creation modal window (when coming from Content Structure)

You can also translate SiteAccess names. Displayed names depend on the selected language of the administration interface.

To define translation you need to put them in YAML file with correct language code e.g. `translations/ezplatform_siteaccess.en.yaml`:

```yaml
en: Tasteful Planet
fr: Tasteful Planet France
```

## Scope

Configuration is resolved depending on scope. It gives the opportunity to define settings for a given SiteAccess, for instance like in the [legacy INI override system](http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Concepts-and-basics/Configuration).

The available scopes are:

1. `global`
2. SiteAccess
3. SiteAccess group
4. `default`

The scopes are applied in the order presented. This means that `global` overrides all other scopes.
If `global` is not defined, the configuration will then try to match a SiteAccess, and then a SiteAccess group.
Finally, if no other scope is matched, `default` will be applied.

In short: if you want a match that will always apply, regardless of SiteAccesses use `global`.
To define a fallback, use `default`.

``` yaml
ezplatform:
    system:
        global:
            # If set, this value will be used regardless of any other var_dir configuration
            #var_dir: var/global
        site:
            # This var_dir will be used for the 'site' SiteAccess
            var_dir: var/site
        site_group:
            # This will be overwritten by the SiteAccess above, since the SiteAccess has precedence
            var_dir: var/group   
        default:
            # This value will only be used if there is no global, SiteAccess or SiteAccess group defined
            var_dir: var/site
```

Be aware that the `default` scope concerns both back and front views.
For example, the following configuration defines both the front template for articles
and the template used in the Back Office, unless other templates are configured for specific a SiteAccess or SiteAccess group:

``` yaml
ezpublish:
    system:
        default:
            content_view:
                full:
                    article:
                        template: full/article.html.twig
                        match:
                            Identifier\ContentType: [article]
```                          

Note that you should avoid defining a setting twice within the same scope, as this will cause a [silent failure](https://github.com/symfony/symfony/issues/11538).

This mechanism is not limited to [[= product_name =]] internal settings (the `ezsettings` namespace) and is applicable for specific needs (bundle-related, project-related, etc.).

Always prefer semantic configuration especially for internal eZ settings.
Manually editing internal eZ settings is possible, but at your own risk, as unexpected behavior can occur.

## Cross-SiteAccess links

When using the [multisite](multisite.md) feature, it is sometimes useful to be able to generate cross-links between different sites within one installation.
This allows you to link different resources referenced in the same content repository, but configured independently with different tree roots.

``` html+twig
<!--Twig example-->
{# Linking a location #}
<a href="{{ url( 'ez_urlalias', {'locationId': 42, 'siteaccess': 'some_siteaccess_name'} ) }}">{{ ez_content_name( content ) }}</a>

{# Linking a regular route #}
<a href="{{ url( "some_route_name", {"siteaccess": "some_siteaccess_name"} ) }}">Hello world!</a>
```

See [ez\_urlalias](twig_functions_reference.md#ez_urlalias) for more information about linking to a Location.

``` php
namespace App\Controller;

use eZ\Bundle\EzPublishCoreBundle\Controller as BaseController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MyController extends BaseController
{
    public function fooAction()
    {
        // ...

        $location = $this->getRepository()->getLocationService()->loadLocation( 123 );
        $locationUrl = $this->generateUrl(
            $location,
            [ 'siteaccess' => 'some_siteaccess_name' ],
            UrlGeneratorInterface::ABSOLUTE_PATH
        );

        $regularRouteUrl = $this->generateUrl(
            'some_route_name',
            [ 'siteaccess' => 'some_siteaccess_name' ],
            UrlGeneratorInterface::ABSOLUTE_PATH
        );

        // ...
    }
}
```

!!! note "Important"

    As SiteAccess matchers can involve hosts and ports, it is **highly recommended** to generate cross-SiteAccess links in an absolute form (e.g. using `ez_url()` Twig helper).

#### Troubleshooting

- The **first matcher succeeding always wins**, so be careful when using *catch-all* matchers like `URIElement`.
- If the passed SiteAccess name is not valid, an `InvalidArgumentException` will be thrown.
- If the matcher used to match the provided SiteAccess doesn't implement `VersatileMatcher`, the link will be generated for the current SiteAccess.
- When using `Compound\LogicalAnd`, all inner matchers **must match**. If at least one matcher doesn't implement `VersatileMatcher`, it will fail.
- When using `Compound\LogicalOr`, the first inner matcher succeeding will win.

#### Under the hood

To implement this feature, a new `VersatileMatcher` was added to allow SiteAccess matchers to be able to *reverse-match*.
All existing matchers implement this new interface, except the regexp-based matchers which have been deprecated.

The SiteAccess router has been added a `matchByName()` method to reflect this addition. Abstract URLGenerator and `DefaultRouter` have been updated as well.

!!! note

    SiteAccess router public methods have also been extracted to a new interface, `SiteAccessRouterInterface`.

#### Navigating between SiteAccesses - limitations

There are two known limitations to moving between SiteAccesses in [[= product_name_exp =]]'s Pages:

1. On a Page you can encounter a 404 error when clicking a relative link which points to a different SiteAccess (if the Content item being previewed does not exist in the previously used SiteAccess). This is because detecting SiteAccesses when navigating in preview is not functional yet. This is a known limitation that is awaiting resolution.

1. When navigating between SiteAccesses in the back office using the top bar, you are always redirected to the main page, not to the Content item you started from.

## Injecting SiteAccess

SiteAccess is exposed in the Dependency Injection Container as the `@ezpublish.siteaccess` service, so it can be injected into any custom service.

The `@ezpublish.siteaccess` service, if needed, must be injected using setter injection. It comes from the fact that SiteAccess matching
is done in a `kernel.request` event listener, so when injected into a constructor, it might not be initialized properly.

To ensure proper contract, the `eZ\Publish\Core\MVC\Symfony\SiteAccess\SiteAccessAware` interface can be implemented on a custom service.

**Example**

Let's define a simple service which depends on the Repository's ContentService and the current SiteAccess.

```yaml
services:
    App\MyService:
        arguments: ['@ezpublish.api.service.content']
        calls:
            - [setSiteAccess, ['@ezpublish.siteaccess']]
```

```php
<?php

namespace App;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\Core\MVC\Symfony\SiteAccess;
use eZ\Publish\Core\MVC\Symfony\SiteAccess\SiteAccessAware;

class MyService implements SiteAccessAware
{
    /**
     * @var \eZ\Publish\API\Repository\ContentService
     */
    private $contentService;

    /**
     * @var \eZ\Publish\Core\MVC\Symfony\SiteAccess
     */
    private $siteAccess;

    public function __construct(ContentService $contentService )
    {
        $this->contentService = $contentService;
    }

    public function setSiteAccess(SiteAccess $siteAccess = null)
    {
        $this->siteAccess = $siteAccess;
    }
}
```

## Exposing SiteAccess-aware configuration for your bundle

The [Symfony Config component](https://symfony.com/doc/5.0/components/config.html) makes it possible to define *semantic configuration*, exposed to the end developer.
This configuration is validated by rules you define, e.g. validating type (string, array, integer, boolean, etc.).
Usually, once validated and processed, this semantic configuration is then mapped to internal *key/value* parameters stored in the `ServiceContainer`.

[[= product_name =]] uses this for its core configuration, but adds another configuration level, the **SiteAccess**.
For each defined SiteAccess, you need to be able to use the same configuration tree in order to define SiteAccess-specific config.

These settings then need to be mapped to SiteAccess-aware internal parameters that you can retrieve via the `ConfigResolver`.
For this, internal keys need to follow the format `<namespace>.<scope>.<parameter_name>`. where:

- `namespace`is specific to your app or bundle
- `scope` is the SiteAccess, SiteAccess group, `default` or `global`
- `parameter_name` is the actual setting *identifier*

For more information on ConfigResolver, namespaces and scopes, see [[[= product_name =]] configuration basics](../guide/configuration.md).

The goal of this feature is to make it easy to implement a SiteAccess-aware semantic configuration and its mapping to internal config for any [[= product_name =]] bundle developer.

### Semantic configuration parsing

An abstract `Configuration` class has been added, simplifying the way to add a SiteAccess settings tree like the following in `config/packages/ezplatform.yaml`:

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

The fully qualified name of the class is `eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\Configuration`.
All you have to do is to extend it and use `$this->generateScopeBaseNode()`:

``` php hl_lines="17"
<?php

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

### Mapping to internal settings

Semantic configuration must always be mapped to internal key/value settings within the `ServiceContainer`.
This is usually done in the DIC extension.

For SiteAccess-aware settings, new `ConfigurationProcessor` and `Contextualizer` classes have been introduced to ease the process.

``` php
<?php

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
 * To learn more see {@link http://symfony.com/doc/5.0/cookbook/bundles/extension.html}
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

#### Merging hash values between scopes

When you define a hash as semantic config, you sometimes don't want the SiteAccess settings to replace the default or group values,
but *enrich* them by appending new entries. This is possible by using `$processor->mapConfigArray()`,
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

##### Merge from second level

In the example above, entries were merged in respect to the scope order of precedence. However, if you define the `planets` key for `siteaccess1`, it will completely override the default value since the merge process is done at only 1 level.

You can add another level by passing `ContextualizerInterface::MERGE_FROM_SECOND_LEVEL` as an option (third argument) to `$contextualizer->mapConfigArray()`.

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

##### Limitations

A few limitations exist with this scope hash merge:

- Semantic setting name and internal name will be the same (like `foo_setting` in the examples above).
- Applicable to first level semantic parameter only (i.e. settings right under the SiteAccess name).
- Merge is not recursive. Only second level merge is possible by using `ContextualizerInterface::MERGE_FROM_SECOND_LEVEL` option.

### Dedicated mapper object

Instead of passing a callable to `$processor->mapConfig()`, an instance of `eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ConfigurationMapperInterface` can be passed.

This can be useful if you have a lot of configuration to map and don't want to pollute your DIC extension class (better for maintenance).

#### Merging hash values between scopes

As specified above, `$contextualizer->mapConfigArray()` is not to be used within the *scope loop*, like for simple values.
When using a closure/callable, you usually call it before or after `$processor->mapConfig()`.
For mapper objects, a dedicated interface can be used: `HookableConfigurationMapperInterface`,
which defines 2 methods: `preMap()` and `postMap()`.
