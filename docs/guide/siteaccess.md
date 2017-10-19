# SiteAccess

TODO admin SiteAccess

## Introduction

eZ Platform enables you to maintain multiple sites in one installation using a feature called **SiteAccesses**.

In short, a SiteAccess is a set of configuration settings that is used when you reach the site through a specific address.
When the user visits the site, the system analyzes the URI and compares it to rules specified in the configuration. If it finds a set of fitting rules, this SiteAccess is used.

Settings defined per SiteAccess may include, among others, database, language or `var` directory.
When that SiteAccess is used, they override the default configuration.

### Selecting SiteAccesses

A SiteAccess is selected using one or more matchers – rules based on the uri or its parts. Example matching criteria are elements of the uri, host name (or its parts), port number, etc.

For detailed information on how SiteAccess matchers work, see [SiteAccess Matching](#siteaccess-matching).

### SiteAccesses use cases

Typical uses of a SiteAccess are:

- different language versions of the same site identified by a uri part; one SiteAccess for one language
- two different versions of a website: one SiteAccess with a public interface for visitors and one with a restricted interface for administrators

!!! enterprise

    If you need to change between SiteAccesses in Page mode, do not use any functions in the page itself (for example, a language switcher). This may cause unexpected errors. Instead, switch between SiteAccesses using the SiteAccess bar above the page.

## Configuring SiteAccesses

You configure SiteAccess in your config files (e.g. `ezplatform.yml`) under the `ezpublish.siteacess` keys.
The required elements of the configuration are:

#### `list`

Lists all SiteAccesses in the installation.

#### `default_siteaccess`

Identifies which SiteAccess will be used by default when no other is specified.

#### `groups` (optional)

Collects SiteAccesses into groups that can be used later for configuration.

#### `match`

The rule or set of rules by which SiteAccesses are matched. See [SiteAccess matching](#siteaccess-matching) for more information.

### Settings per SiteAccess

Various system settings can be set per SiteAccess or SiteAccess group under the `ezpublish.system` key. These settings include languages or the `var` directory.

### Example: multilanguage sites

A site has content in two languages: English and Norwegian. It has one URI per language: `http://example.com/eng` and `http://example.com/nor`. Uri parts of each language (eng, nor) are mapped to a *SiteAccess*, commonly named like the URI part: `eng`, `nor`. Using semantic configuration, each of these SiteAccesses can be assigned a prioritized list of languages it should display:

- The English site would display content in English and ignore Norwegian content;
- The Norwegian site would display content in Norwegian but also in English *if it does not exist in Norwegian*.

Such configuration would look like this:

``` yaml
ezpublish:
    siteaccess:
        # There are two SiteAccesses
        list: [eng, nor]
 
        # eng is the default one if no prefix is specified
        default_siteaccess: eng

        # the first URI of the element is used to find a SiteAccess with a similar name
        match:
            URIElement: 1


ezpublish:
    # root node for configuration per SiteAccess
    system:
        # Configuration for the 'eng' SiteAccess
        eng:
            languages: [eng-GB]
        nor:
            languages: [nor-NO, eng-GB]
```

!!! note

    A new SiteAccess is recognized by the system, but an Anonymous User will not have read access to it until it is [explicitly given via the Admin > Roles panel](repository.md#use-cases). Without read access the Anonymous User will simply be directed to the default login page.

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
ezpublish:
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

Note that you should avoid defining a setting twice within the same scope, as this will cause a [silent failure](https://github.com/symfony/symfony/issues/11538).

This mechanism is not limited to eZ Platform internal settings (the `ezsettings` namespace) and is applicable for specific needs (bundle-related, project-related, etc.).

Always prefer semantic configuration especially for internal eZ settings.
Manually editing internal eZ settings is possible, but at your own risk, as unexpected behavior can occur.

## SiteAccess Matching

SiteAccess matching is done through `eZ\Publish\MVC\SiteAccess\Matcher` objects. You can configure this matching and even develop custom matchers.

To be usable, every SiteAccess must be provided a matcher.

You can configure SiteAccess matching in your main `app/config/ezplatform.yml`:

``` yaml
# ezplatform.yml
ezpublish:
    siteaccess:
        default_siteaccess: ezdemo_site
        list:
            - ezdemo_site
            - eng
            - fre
            - fr_eng
            - ezdemo_site_admin
        groups:
            ezdemo_site_group:
                - ezdemo_site
                - eng
                - fre
                - fr_eng
                - ezdemo_site_admin
        match:
            Map\URI:
                ezdemo_site: ezdemo_site
                fre: fre
                ezdemo_site_admin: ezdemo_site_admin
```

You need to set several parameters:

- `ezpublish.siteaccess.default_siteaccess` is the default SiteAccess that will be used if matching was not successful. This ensures that a SiteAccess is always defined.
- `ezpublish.siteaccess.list` is the list of all available SiteAccesses in your website.
- `ezpublish.siteaccess.groups` *(optional)* defines which groups SiteAccesses belong to. This is useful when you want to mutualize settings between several SiteAccesses and avoid config duplication. Siteaccess groups are treated the same as regular SiteAccesses as far as configuration is concerned. A SiteAccess can be part of several groups. A SiteAccess configuration has always precedence on the group configuration.
- `ezpublish.siteaccess.match` holds the matching configuration. It consists in a hash where the key is the name of the matcher class. If the matcher class doesn't start with a **\\** , it will be considered relative to `eZ\Publish\MVC\SiteAccess\Matcher` (e.g. `Map\Host` will refer to  `eZ\Publish\MVC\SiteAccess\Matcher\Map\Host`)

Every custom matcher can be specified with a fully qualified class name (e.g. `\My\SiteAccess\Matcher`) or by a service identifier prefixed by @ (e.g. `@my_matcher_service`).

- In the case of a fully qualified class name, the matching configuration will be passed in the constructor.
- In the case of a service, it must implement `eZ\Bundle\EzPublishCoreBundle\SiteAccess\Matcher`. The matching configuration will be passed to `setMatchingConfiguration()`.

!!! note

    Make sure to type the matcher in correct case. If it is in wrong case like "Uri" instead of "URI," it will work well on systems like Mac OS X because of their case-insensitive file system, but will fail when you deploy it to a Linux server. This is a known artifact of [PSR-0 autoloading](http://www.php-fig.org/psr/psr-0/) of PHP classes.

### Available matchers

#### URIElement

Maps a URI element to a SiteAccess. This is the default matcher used when choosing URI matching in setup wizard. 	

**Configuration.** The element number you want to match (starting from 1)

``` yaml
ezpublish:
    siteaccess:
        match:
            URIElement: 1
```

*Important:* When using a value > 1, the matcher will concatenate the elements with `_`.

**Example.** URI: `/ezdemo_site/foo/bar`

Element number: 1; Matched SiteAccess: `ezdemo_site`

Element number: 2; Matched SiteAccess: `ezdemo_site_foo`

#### URIText

Matches URI using pre and/or post sub-strings in the first URI segment.

**Configuration.** The prefix and/or suffix (none are required)

``` yaml
ezpublish:
    siteaccess:
        match:
            URIText:
                prefix: foo
                suffix: bar
```

**Example.** URI: `/footestbar/my/content`

Prefix: `foo`; Suffix: `bar`; Matched SiteAccess: `test`

#### HostElement

Maps an element in the host name to a SiteAccess.

**Configuration.** The element number you want to match (starting from 1)

``` yaml
ezpublish:
    siteaccess:
        match:
            HostElement: 2
```

**Example.** Host name: `www.example.com`

Element number: 2; Matched SiteAccess: `example`

#### HostText

Matches a SiteAccess in the host name, using pre and/or post sub-strings.

**Configuration.** The prefix and/or suffix (none are required)

``` yaml
ezpublish:
    siteaccess:
        match:
            HostText:
                prefix: www.
                suffix: .com
```

**Example.** Host name: `www.foo.com`

Prefix: `www.`; Suffix: `.com`; Matched SiteAccess: `foo`

#### Map\\Host

Maps a host name to a SiteAccess.

**Configuration.** A hash map of host/siteaccess

``` yaml
ezpublish:
    siteaccess:
        match:
            Map\Host:
                www.foo.com: foo_front
                adm.foo.com: foo_admin
                www.bar-stuff.fr: bar_front
                adm.bar-stuff.fr: bar_admin
```

!!! enterprise

    In eZ Enterprise, when using the Map\Host matcher, you need to provide the following line in your Twig template (e.g. in the head of the main template file):

    `{{ multidomain_access() }}`

**Example.** Map:

- `www.foo.com` => `foo_front`
- `admin.foo.com` => `foo_admin`

Host name: `www.example.com`

Matched SiteAccess: `foo_front`

#### Map\\URI

Maps a URI to a SiteAccess.

**Configuration.** A hash map of URI/siteaccess

```yaml
ezpublish:
    siteaccess:
        match:
            Map\URI:
                something: ezdemo_site
                foobar: ezdemo_site_admin
```

!!! caution

    The name of the Map\URI matcher must be the same as the SiteAccess name. This also means that only one URI can be addressed by the same matcher.

**Example.** URI: `/something/my/content`

Map:

- `something` => `ezdemo_site`
- `foobar` => `ezdemo_site_admin`

Matched SiteAccess: `ezdemo_site`

#### Map\\Port

Maps a port to a SiteAccess.

**Configuration.** A hash map of Port/siteaccess

``` yaml
ezpublish:
    siteaccess:
        match:
            Match\Port:
                80: foo
                8080: bar
```

**Example.** URL: `http://ezpublish.dev:8080/my/content`

Map:

- `80`: `foo`
- `8080`: `bar`

Matched SiteAccess: `bar`

#### Regex\\Host

Matches against a regexp and extracts a portion of it.

**Configuration.** The regexp to match against and the captured element to use

``` yaml
ezpublish:
    siteaccess:
        match:
            Regex\Host:
                regex: "^(\\w+_sa)$"
                # Default is 1
                itemNumber: 1
```

**Example.** Host name: `example_sa`

regex: `^(\\w+)_sa$`

itemNumber: 1

Matched SiteAccess: `example`

#### Regex\\URI

Matches against a regexp and extracts a portion of it.

**Configuration.** The regexp to match against and the captured element to use

``` yaml
ezpublish:
    siteaccess:
        match:
            Regex\URI:
                regex: "^/foo(\\w+)bar"
                # Default is 1
                itemNumber: 1
```

**Example.** URI: `/footestbar/something`

regex: `^/foo(\\w+)bar`; itemNumber: 1

Matched SiteAccess: `test`

### Compound SiteAccess matcher

The Compound SiteAccess matcher enables you to combine several matchers together, for example:

- `http://example.com/en` matches site\_en (match on host=example.com *and* URIElement(1)=en)
- `http://example.com/fr` matches site\_fr (match on host=example.com *and* URIElement(1)=fr)
- `http://admin.example.com` matches site\_admin (match on host=admin.example.com)

Compound matchers correspond to the legacy **host\_uri** matching feature.

They are based on logical combinations, or/and, using logical compound matchers:

- `Compound\LogicalAnd`
- `Compound\LogicalOr`

Each compound matcher will specify two or more sub-matchers. A rule will match if all the matchers combined with the logical matcher are positive. The example above would have used `Map\Host` and `Map\Uri`, combined with a `LogicalAnd`. When both the URI and host match, the SiteAccess configured with "match" is used.

``` yaml
# ezplatform.yml
ezpublish:
    siteaccess:
        match:
            Compound\LogicalAnd:
                # Nested matchers, with their configuration.
                # No need to specify their matching values (true is enough).
                site_en:
                    matchers:
                        Map\URI:
                            en: true
                        Map\Host:
                            example.com: true
                    match: site_en
                site_fr:
                    matchers:
                        Map\URI:
                            fr: true
                        Map\Host:
                            example.com: true
                    match: site_fr
            Map\Host:
                admin.example.com: site_admin
```

### Matching by request header

It is possible to define which SiteAccess to use by setting an `X-Siteaccess` header in your request. This can be useful for REST requests.

In such a case, `X-Siteaccess` must be the *SiteAccess name* (e.g. `ezdemo_site`).

### Matching by environment variable

It is also possible to define which SiteAccess to use directly via an **EZPUBLISH\_SITEACCESS** environment variable.

This is recommended if you want to get performance gain since no matching logic is done in this case.

You can define this environment variable directly from your web server configuration:

``` xml
<!--Apache VirtualHost example-->
# This configuration assumes that mod_env is activated
<VirtualHost *:80>
    DocumentRoot "/path/to/ezpublish5/web/folder"
    ServerName example.com
    ServerAlias www.example.com
    SetEnv EZPUBLISH_SITEACCESS ezdemo_site
</VirtualHost>
```

!!! tip

    You can also do it via PHP-FPM configuration file, if you use it. See  [PHP-FPM documentation](http://php.net/manual/en/install.fpm.configuration.php#example-60) for more information.

!!! note "Precedence"

    The precedence order for SiteAccess matching is the following (the first matched wins):

    1.  Request header
    1.  Environment variable
    1.  Configured matchers

### URILexer and semanticPathinfo

In some cases, after matching a SiteAccess, it is necessary to modify the original request URI. This is for example needed with URI-based matchers since the SiteAccess is contained in the original URI and is not part of the route itself.

The problem is addressed by *analyzing* this URI and by modifying it when needed through the **URILexer** interface.

``` php
// URILexer interface

/**
 * Interface for SiteAccess matchers that need to alter the URI after matching.
 * This is useful when you have the SiteAccess in the URI like "/<siteaccessName>/my/awesome/uri"
 */
interface URILexer
{
    /**
     * Analyses $uri and removes the SiteAccess part, if needed.
     *
     * @param string $uri The original URI
     * @return string The modified URI
     */
    public function analyseURI( $uri );
    /**
     * Analyses $linkUri when generating a link to a route, in order to have the SiteAccess part back in the URI.
     *
     * @param string $linkUri
     * @return string The modified link URI
     */
    public function analyseLink( $linkUri );
}
```

Once modified, the URI is stored in the ***semanticPathinfo*** request attribute, and the original pathinfo is not modified.

## Cross-SiteAccess links

When using the [multisite](multisite.md) feature, it is sometimes useful to be able to generate cross-links between different sites within one installation.
This allows you to link different resources referenced in the same content repository, but configured independently with different tree roots.

``` html
<!--Twig example-->
{# Linking a location #}
<a href="{{ url( 'ez_urlalias', {'locationId': 42, 'siteaccess': 'some_siteaccess_name'} ) }}">{{ ez_content_name( content ) }}</a>

{# Linking a regular route #}
<a href="{{ url( "some_route_name", {"siteaccess": "some_siteaccess_name"} ) }}">Hello world!</a>
```

See [ez\_urlalias](content_rendering.md#ez95urlalias) for more information about linking to a Location.

``` php
namespace Acme\TestBundle\Controller;

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
            array( 'siteaccess' => 'some_siteaccess_name' ),
            UrlGeneratorInterface::ABSOLUTE_PATH
        );

        $regularRouteUrl = $this->generateUrl(
            'some_route_name',
            array( 'siteaccess' => 'some_siteaccess_name' ),
            UrlGeneratorInterface::ABSOLUTE_PATH
        );

        // ...
    }
}
```

!!! note "Important"

    As SiteAccess matchers can involve hosts and ports, it is **highly recommended** to generate cross-SiteAccess links in an absolute form (e.g. using `url()` Twig helper).

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

There are two known limitations to moving between SiteAccesses in eZ Enterprise's Landing Pages:

1. On a Landing Page you can encounter a 404 error when clicking a relative link which points to a different SiteAccess (if the Content item being previewed does not exist in the previously used SiteAccess). This is because detecting SiteAccesses when navigating in preview is not functional yet. This is a known limitation that is awaiting resolution.

1. When navigating between SiteAccesses in the back office using the top bar, you are always redirected to the main page, not to the Content item you started from.

## Dynamic configuration with the ConfigResolver

In eZ Platform it is fairly common to have different settings depending on the current SiteAccess (e.g. languages, [view provider](content_rendering.md#view-provider-configuration) configuration).

#### ConfigResolver Usage

Dynamic configuration is handled by a **config resolver**. It consists in a service object mainly exposing `hasParameter()` and `getParameter()` methods. The idea is to check the different *scopes* available for a given *namespace* to find the appropriate parameter.

In order to work with the config resolver, your dynamic settings must comply internally with the following name format: `<namespace>.<scope>.parameter.name`.

The following configuration is an example of internal usage inside the code of eZ Platform:

``` yaml
# Namespace + scope example
parameters:
    # Some internal configuration
    ezsettings.default.content.default_ttl: 60
    ezsettings.ezdemo_site.content.default_ttl: 3600
 
    # Here "myapp" is the namespace, followed by the SiteAccess name as the parameter scope
    # Parameter "foo" will have a different value in ezdemo_site and ezdemo_site_admin
    myapp.ezdemo_site.foo: bar
    myapp.ezdemo_site_admin.foo: another value
    # Defining a default value, for other SiteAccesses
    myapp.default.foo: Default value
 
    # Defining a global setting, used for all SiteAccesses
    #myapp.global.some.setting: This is a global value
```

``` php
// Inside a controller, assuming SiteAccess being "ezdemo_site"
/** @var $configResolver \eZ\Publish\Core\MVC\ConfigResolverInterface **/
$configResolver = $this->getConfigResolver();
 
// ezsettings is the default namespace, so no need to specify it
// The following will resolve ezsettings.<siteaccessName>.content.default_ttl
// In the case of ezdemo_site, will return 3600.
// Otherwise it will return the value for ezsettings.default.content.default_ttl (60)
$locationViewSetting = $configResolver->getParameter( 'content.default_ttl' );
 
$fooSetting = $configResolver->getParameter( 'foo', 'myapp' );
// $fooSetting's value will be 'bar'
 
// Force scope
$fooSettingAdmin = $configResolver->getParameter( 'foo', 'myapp', 'ezdemo_site_admin' );
// $fooSetting's value will be 'another value'
 
// Note that the same applies for hasParameter()
```

Both `getParameter()` and `hasParameter()` can take 3 different arguments:

1. `$paramName` (the name of the parameter you need)
2. `$namespace` (your application namespace, `myapp` in the previous example. If null, the default namespace will be used, which is `ezsettings` by default)
3. `$scope` (a SiteAccess name. If null, the current SiteAccess will be used)

#### Inject the ConfigResolver in your services

Instead of injecting the whole ConfigResolver service, you may directly [inject your SiteAccess-aware settings (aka dynamic settings) into your own services](#dynamic-settings-injection).

You can use the ConfigResolver in your own services whenever needed. To do this, just inject the `ezpublish.config.resolver service`:

``` yaml
parameters:
    my_service.class: My\Cool\Service
 
services:
    my_service:
        class: %my_service.class%
        arguments: [@ezpublish.config.resolver]
```

``` php
<?php
namespace My\Cool;
 
use eZ\Publish\Core\MVC\ConfigResolverInterface;
 
class Service
{
    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    private $configResolver;
 
    public function __construct( ConfigResolverInterface $configResolver )
    {
        $this->configResolver = $configResolver;
        $myParam = $this->configResolver->getParameter( 'foo', 'myapp' );
    }
 
    // ...
}
```

### Dynamic Settings Injection

When implementing a service needing SiteAccess-aware settings (e.g. language settings), you can inject these dynamic settings explicitly from their service definition (yml, xml, annotation, etc.).

#### Syntax

Static container parameters follow the `%<parameter_name>%` syntax in Symfony.

Dynamic parameters have the following: `$<parameter_name>[; <namespace>[; <scope>]]$`, default namespace being `ezsettings`, and default scope being the current SiteAccess.

For more information, see [ConfigResolver](#dynamic-configuration-with-the-configresolver).

#### DynamicSettingParser

The *DynamicSettingParser* service that can be used for adding support of the dynamic settings syntax.
This service has `ezpublish.config.dynamic_setting.parser` for ID and implements` eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\DynamicSettingParserInterface`.

#### Limitations

- It is not possible to use dynamic settings in your semantic configuration (e.g. `config.yml` or `ezplatform.yml`) as they are meant primarily for parameter injection in services.
- It is not possible to define an array of options having dynamic settings. They will not be parsed. Workaround is to use separate arguments/setters.
- Injecting dynamic settings in request listeners is **not recommended**, as it won't be resolved with the correct scope (request listeners are *instantiated before SiteAccess match*). Workaround is to inject the ConfigResolver instead, and resolve the setting in your `onKernelRequest` method (or equivalent).

#### Examples

##### Injecting an eZ parameter

Defining a simple service needing a `languages` parameter (that is, prioritized languages).

!!! note

    Internally, the `languages` parameter is defined as `ezsettings.<siteaccess_name>.languages`, `ezsettings` being eZ internal namespace.

##### Using setter injection (preferred)

``` yaml
parameters:
    acme_test.my_service.class: Acme\TestBundle\MyServiceClass

services:
    acme_test.my_service:
        class: %acme_test.my_service.class%
        calls:
            - [setLanguages, ["$languages$"]]
```

``` php
namespace Acme\TestBundle;

class MyServiceClass
{
    /**
 * Prioritized languages
 *
 * @var array
 */
    private $languages;

    public function setLanguages( array $languages = null )
    {
        $this->languages = $languages;
    }
}
```

!!! caution

    Ensure you always add `null` as a default value, especially if the argument is type-hinted.

##### Using constructor injection

``` yaml
parameters:
    acme_test.my_service.class: Acme\TestBundle\MyServiceClass

services:
    acme_test.my_service:
        class: %acme_test.my_service.class%
        arguments: ["$languages$"]
```

``` php
namespace Acme\TestBundle;

class MyServiceClass
{
    /**
 * Prioritized languages
 *
 * @var array
 */
    private $languages;

    public function __construct( array $languages )
    {
        $this->languages = $languages;
    }
}
```

!!! tip

    Setter injection for dynamic settings should always be preferred, as it makes it possible to update your services that depend on them when ConfigResolver is updating its scope (e.g. when previewing content in a given SiteAccess). **However, only one dynamic setting should be injected by setter**.

    **Constructor injection will make your service be reset in that case.**

##### Injecting 3rd party parameters

``` yaml
parameters:
    acme_test.my_service.class: Acme\TestBundle\MyServiceClass
    # "acme" is our parameter namespace.
    # Null is the default value.
    acme.default.some_parameter: ~
    acme.ezdemo_site.some_parameter: foo
    acme.ezdemo_site_admin.some_parameter: bar
 
services:
    acme_test.my_service:
        class: %acme_test.my_service.class%
        # The following argument will automatically resolve to the right value, depending on the current SiteAccess.
        # We specify "acme" as the namespace we want to use for parameter resolving.
        calls:
            - [setSomeParameter, ["$some_parameter;acme$"]]
```

``` php
namespace Acme\TestBundle;
class MyServiceClass
{
    private $myParameter;
    public function setSomeParameter( $myParameter = null )
    {
        // Will be "foo" for ezdemo_site, "bar" for ezdemo_site_admin, or null if another SiteAccess.
        $this->myParameter = $myParameter;
    }
}
```
