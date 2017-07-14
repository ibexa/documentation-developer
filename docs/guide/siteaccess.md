1.  [Developer](index.html)
2.  [Documentation](Documentation_31429504.html)
3.  [The Complete Guide to eZ Platform](The-Complete-Guide-to-eZ-Platform_31429526.html)

# SiteAccess 

Created by Dominika Kurek, last modified on Jun 07, 2017

# Introduction

eZ Platform allows you to maintain multiple sites in one installation using a feature called **siteaccesses**.

In short, a siteaccess is a set of configuration settings that is used when the site is reached through a specific address.

When the user accesses the site, the system analyzes the uri and compares it to rules specified in the configuration. If it finds a set of fitting rules, this siteaccess is used.

## What does a siteaccess do?

A siteaccess overrides the default configuration. This means that if the siteaccess does not specify some aspect of the configuration, the default values will be used. The default configuration is also used when no siteaccess can be matched to a situation. 

A siteaccess can decide many things about the website, for example the database, language or var directory that are used.

## How is a siteaccess selected?

A siteaccess is selected using one or more matchers – rules based on the uri or its parts. Example matching criteria are elements of the uri, host name (or its parts), port number, etc.

For detailed information on how siteaccess matchers work, see [Siteaccess Matching](https://doc.ez.no/display/DEVELOPER/SiteAccess#SiteAccess-SiteaccessMatching).

## What can you use siteaccesses for?

Typical uses of a siteaccess are:

-   different language versions of the same site identified by a uri part; one siteaccess for one language
-   two different versions of a website: one siteaccess with a public interface for visitors and one with a restricted interface for administrators

 

Both the rules for siteaccess matching and its effects are located in the main **app/config/ezplatform.yml** configuration file.

If you need to change between siteaccesses in Page mode, do not use any functions in the page itself (for example, a language switcher). This may cause unexpected errors. Instead, switch between siteaccesses using the siteaccess bar above the page.

## Use case: multilanguage sites

A site has content in two languages: English and Norwegian. It has one URI per language: http://example.com/eng and http://example.com/nor. Uri parts of each language (eng, nor) are mapped to a *siteaccess*, commonly named like the uri part: `eng`, `nor`. Using semantic configuration, each of these siteaccesses can be assigned a prioritized list of languages it should display:

-   The English site would display content in English and ignore Norwegian content;
-   The Norwegian site would display content in Norwegian but also in English *if it does not exist in Norwegian*.

Such configuration would look like this:

``` brush:
ezpublish:
    siteaccess:
        # There are two siteaccess
        list: [eng, nor]
 
        # eng is the default one if no prefix is specified
        default_siteaccess: eng

        # the first URI of the element is used to find a siteaccess with a similar name
        match:
            URIElement: 1


ezpublish:
    # root node for configuration per siteaccess 
    system:
        # Configuration for the 'eng' siteaccess
        eng:
            languages: [eng-GB]
        nor:
            languages: [nor-NO, eng-GB]
```

## The default scope

When no particular context is required, it is fine to use the \`default\` scope instead of specifying a siteaccess.

# Configuration

## Basics

Important

Configuration is tightly related to the service container.
To fully understand the following content, you need to be familiar with [Symfony's service container](Service-Container_31432100.html) and [its configuration](http://symfony.com/doc/current/book/service_container.html#service-parameters).

Basic configuration handling in eZ Platform is similar to what is commonly possible with Symfony. Regarding this, you can define key/value pairs in [your configuration files](http://symfony.com/doc/current/book/service_container.html#importing-other-container-configuration-resources), under the main **parameters** key (like in **[parameters.yml](https://github.com/ezsystems/ezpublish5/blob/master/app/config/parameters.yml.dist)**).

Internally and by convention, keys follow a **dot syntax** where the different segments follow your configuration hierarchy. Keys are usually prefixed by a *namespace* corresponding to your application. Values can be anything, **including arrays and deep hashes**.

eZ Platform core configuration is prefixed by **ezsettings** namespace, while *internal* configuration (not to be used directly) is prefixed by **ezpublish** namespace.

For configuration that is meant to be exposed to an end-user (or end-developer), it's usually a good idea to also [implement semantic configuration](http://symfony.com/doc/current/components/config/definition.html).

Note that it is also possible to [implement SiteAccess aware semantic configuration](Exposing-SiteAccess-aware-configuration-for-your-bundle_31429794.html).

### Example

**Configuration**

``` brush:
parameters:
    myapp.parameter.name: someValue
    myapp.boolean.param: true
    myapp.some.hash:
        foo: bar
        an_array: [apple, banana, pear]
```

**Usage from a controller**

``` brush:
// Inside a controller
$myParameter = $this->container->getParameter( 'myapp.parameter.name' );
```

## Dynamic configuration with the ConfigResolver

In eZ Platform it is fairly common to have different settings depending on the current siteaccess (e.g. languages, [view provider](Content-Rendering_31429679.html#ContentRendering-Viewproviderconfiguration) configuration).

### Scope

**Dynamic configuration **can be resolved depending on a *scope*. It gives the opportunity to define settings for a given siteaccess, for instance, like in the [legacy INI override system](http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Concepts-and-basics/Configuration).

Available scopes are:

1.  `global`
2.  SiteAccess
3.  SiteAccess group
4.  `default`

The scopes are applied in the order presented. This means that `global` overrides all other scopes. If `global` is not defined, the configuration will then try to match a SiteAccess, and then a SiteAccess group. Finally, if no other scope is matched, `default` will be applied.

In short: if you want a match that will always apply, regardless of SiteAccesses use `global`. To define a fallback, use `default`.

``` brush:
ezpublish:
    system:
        global:
            # If set, this value will be used regardless of any other var_dir configuration
            #var_dir: var/global 
        site:
            # This var_dir will be used for the 'site' SiteAccess
            var_dir: var/site
        site_group:
            # This will be overriten by the SiteAccess above, since the SiteAccess has precendence
            var_dir: var/group   
        default:
            # This value will only be used if there is no global, SiteAccess or SiteAccess group defined
            var_dir: var/site
```

Note that you should avoid defining a setting twice within the same scope, as this will cause a [silent failure](https://github.com/symfony/symfony/issues/11538).

This mechanism is not limited to eZ Platform internal settings (aka ***ezsettings* namespace**) and is applicable for specific needs (bundle-related, project-related, etc.).

Always prefer semantic configuration especially for internal eZ settings.
Manually editing internal eZ settings is possible, but at your own risk, as unexpected behavior can occur.

### ConfigResolver Usage

Dynamic configuration is handled by a **config resolver**. It consists in a service object mainly exposing `hasParameter()` and `getParameter()` methods. The idea is to check the different *scopes* available for a given *namespace* to find the appropriate parameter.

In order to work with the config resolver, your dynamic settings must comply internally with the following name format: `<namespace>.<scope>.parameter.name`.

The following configuration is **an example of internal usage** inside the code of eZ Platform.

**Namespace + scope example**

``` brush:
parameters:
    # Some internal configuration
    ezsettings.default.content.default_ttl: 60
    ezsettings.ezdemo_site.content.default_ttl: 3600
 
    # Here "myapp" is the namespace, followed by the siteaccess name as the parameter scope
    # Parameter "foo" will have a different value in ezdemo_site and ezdemo_site_admin
    myapp.ezdemo_site.foo: bar
    myapp.ezdemo_site_admin.foo: another value
    # Defining a default value, for other siteaccesses
    myapp.default.foo: Default value
 
    # Defining a global setting, used for all siteaccesses
    #myapp.global.some.setting: This is a global value
```

``` brush:
// Inside a controller, assuming siteaccess being "ezdemo_site"
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

1.  `$paramName` (i.e. the name of the parameter you need)
2.  `$namespace` (i.e. your application namespace, *myapp* in the previous example. If null, the default namespace will be used, which is **ezsettings** by default)
3.  `$scope` (i.e. a siteaccess name. If null, the current siteaccess will be used)

### Inject the ConfigResolver in your services

Instead of injecting the whole ConfigResolver service, you may directly [inject your SiteAccess-aware settings (aka dynamic settings) into your own services](https://doc.ez.no/display/DEVELOPER/SiteAccess#SiteAccess-DynamicSettingsInjection).

 

You can use the **ConfigResolver** in your own services whenever needed. To do this, just inject the `ezpublish.config.resolver service`:

``` brush:
parameters:
    my_service.class: My\Cool\Service
 
services:
    my_service:
        class: %my_service.class%
        arguments: [@ezpublish.config.resolver]
```

``` brush:
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

## Custom locale configuration

If you need to use a custom locale they can also be configurable in `ezplatform.yml`, adding them to the *conversion map*:

``` brush:
ezpublish:
    # Locale conversion map between eZ Publish format (i.e. fre-FR) to POSIX (i.e. fr_FR). 
    # The key is the eZ Publish locale. Check locale.yml in EzPublishCoreBundle to see natively supported locales.
    locale_conversion:
        eng-DE: en_DE
```

A locale *conversion map* example [can be found in the `core` bundle, on `locale.yml`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/config/locale.yml).

## Siteaccess Matching

Siteaccess matching is done through **eZ\\Publish\\MVC\\SiteAccess\\Matcher** objects. You can configure this matching and even develop custom matchers.

To be usable, every siteaccess must be provided a matcher.

You can configure siteaccess matching in your main **app/config/ezplatform.yml**:

**ezplatform.yml**

``` brush:
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

-   **ezpublish.siteaccess.default\_siteaccess**
-   **ezpublish.siteaccess.list**
-   *(optional)* **ezpublish.siteaccess.groups**
-   **ezpublish.siteaccess.match**

**ezpublish.siteaccess.default\_siteaccess** is the default siteaccess that will be used if matching was not successful. This ensures that a siteaccess is always defined.

**ezpublish.siteaccess.list** is the list of all available siteaccesses in your website.

*(optional)* **ezpublish.siteaccess.groups** defines which groups siteaccesses belong to. This is useful when you want to mutualize settings between several siteaccesses and avoid config duplication. Siteaccess groups are treated the same as regular siteaccesses as far as configuration is concerned.

A siteaccess can be part of several groups.

A siteaccess configuration has always precedence on the group configuration.

**ezpublish.siteaccess.match** holds the matching configuration. It consists in a hash where the key is the name of the matcher class. If the matcher class doesn't start with a **\\** , it will be considered relative to `eZ\Publish\MVC\SiteAccess\Matcher` (e.g. `Map\Host` will refer to  `eZ\Publish\MVC\SiteAccess\Matcher\Map\Host`)

Every **custom matcher** can be specified with a **fully qualified class name** (e.g. `\My\SiteAccess\Matcher`) or by a **service identifier prefixed by @** (e.g. `@my_matcher_service`).

-   In the case of a fully qualified class name, the matching configuration will be passed in the constructor.
-   In the case of a service, it must implement `eZ\Bundle\EzPublishCoreBundle\SiteAccess\Matcher`. The matching configuration will be passed to `setMatchingConfiguration()`.

Make sure to type the matcher in correct case. If it is in wrong case like "Uri" instead of "URI," it will happily work on systems like Mac OS X because of case insensitive file system, but will fail when you deploy it to a Linux server. This is a known artifact of [PSR-0 autoloading](http://www.php-fig.org/psr/psr-0/) of PHP classes.

### Available matchers

<table>
<colgroup>
<col width="25%" />
<col width="25%" />
<col width="25%" />
<col width="25%" />
</colgroup>
<thead>
<tr class="header">
<th>Name</th>
<th>Description</th>
<th>Configuration</th>
<th>Example</th>
</tr>
</thead>
<tbody>
<tr class="odd">
<td><code>URIElement</code></td>
<td>Maps a URI element to a siteaccess.<br />
This is the default matcher used when choosing<br />
URI matching in setup wizard. </td>
<td><p>The element number you want to match (starting from 1).</p>
<div class="code panel pdl" style="border-width: 1px;">
<div class="codeContent panelContent pdl">
<pre class="brush: php; gutter: false; theme: Eclipse" style="font-size:12px;"><code>ezpublish:
    siteaccess:
        match:
            URIElement: 1</code></pre>
</div>
</div>
<p><span> <strong>Important:</strong> When using a value &gt; 1, it will concatenate the elements with _</span></p></td>
<td><p><strong>URI:</strong> <code>/ezdemo_site/foo/bar</code></p>
<p>Element number: 1<br />
Matched siteaccess: ezdemo_site</p>
<p>Element number: 2<br />
Matched siteaccess: ezdemo_site_foo</p></td>
</tr>
<tr class="even">
<td><code>URIText</code></td>
<td>Matches URI using <em>pre</em> and/or <em>post</em> sub-strings<br />
in the first URI segment</td>
<td><p>The prefix and/or suffix (none are required)</p>
<div class="code panel pdl" style="border-width: 1px;">
<div class="codeContent panelContent pdl">
<pre class="brush: php; gutter: false; theme: Eclipse" style="font-size:12px;"><code>ezpublish:
    siteaccess:
        match:
            URIText:
                prefix: foo
                suffix: bar</code></pre>
</div>
</div></td>
<td><p><strong>URI:</strong> <code>/footestbar/my/content</code></p>
<p>Prefix: foo<br />
Suffix: bar<br />
Matched siteaccess: test </p></td>
</tr>
<tr class="odd">
<td><code>HostElement</code></td>
<td>Maps an element in the host name to a siteaccess.</td>
<td><p>The element number you want to match (starting from 1).</p>
<div class="code panel pdl" style="border-width: 1px;">
<div class="codeContent panelContent pdl">
<pre class="brush: php; gutter: false; theme: Eclipse" style="font-size:12px;"><code>ezpublish:
    siteaccess:
        match:
            HostElement: 2</code></pre>
</div>
</div></td>
<td><p><strong>Host name:</strong> <code>www.example.com</code></p>
<p>Element number: 2<br />
Matched siteaccess: example </p></td>
</tr>
<tr class="even">
<td><code>HostText</code></td>
<td>Matches a siteaccess in the host name,<br />
using <em>pre</em> and/or <em>post</em> sub-strings.</td>
<td><p>The prefix and/or suffix (none are required)</p>
<div class="code panel pdl" style="border-width: 1px;">
<div class="codeContent panelContent pdl">
<pre class="brush: php; gutter: false; theme: Eclipse" style="font-size:12px;"><code>ezpublish:
    siteaccess:
        match:
            HostText:
                prefix: www.
                suffix: .com</code></pre>
</div>
</div></td>
<td><p><strong>Host name</strong>: <code>www.foo.com</code></p>
<p>Prefix: www.<br />
Suffix: .com<br />
Matched siteaccess: foo </p></td>
</tr>
<tr class="odd">
<td><code>Map\Host</code></td>
<td>Maps a host name to a siteaccess.</td>
<td><p>A hash map of host/siteaccess</p>
<div class="code panel pdl" style="border-width: 1px;">
<div class="codeContent panelContent pdl">
<pre class="brush: php; gutter: false; theme: Eclipse" style="font-size:12px;"><code>ezpublish:
    siteaccess:
        match:
            Map\Host:
                www.foo.com: foo_front
                adm.foo.com: foo_admin
                www.bar-stuff.fr: bar_front
                adm.bar-stuff.fr: bar_admin</code></pre>
</div>
</div>
<div class="confluence-information-macro confluence-information-macro-warning">
<span class="aui-icon aui-icon-small aui-iconfont-error confluence-information-macro-icon"></span>
<div class="confluence-information-macro-body">
<p>In eZ Enterprise, when using the <code>Map\Host</code> matcher, you need to provide the following line in your Twig template (e.g. in the head of the main template file):</p>
<p><code>{{ multidomain_access() }}</code></p>
</div>
</div></td>
<td><strong>Map</strong>:
<ul>
<li><a href="http://www.foo.com" class="external-link">www.foo.com</a> =&gt; foo_front</li>
<li><a href="http://admin.foo.com" class="external-link">admin.foo.com</a> =&gt; foo_admin </li>
</ul>
<p><strong>Host name</strong>: <a href="http://www.example.com" class="external-link">www.example.com</a></p>
<p>Matched siteaccess: foo_front</p></td>
</tr>
<tr class="even">
<td><code>Map\URI</code></td>
<td>Maps a URI to a siteaccess</td>
<td><p>A hash map of URI/siteaccess</p>
<div class="code panel pdl" style="border-width: 1px;">
<div class="codeContent panelContent pdl">
<pre class="brush: php; gutter: false; theme: Eclipse" style="font-size:12px;"><code>ezpublish:
    siteaccess:
        match:
            Map\URI:
                something: ezdemo_site
                foobar: ezdemo_site_admin</code></pre>
</div>
</div>
<div class="confluence-information-macro confluence-information-macro-warning">
<span class="aui-icon aui-icon-small aui-iconfont-error confluence-information-macro-icon"></span>
<div class="confluence-information-macro-body">
<p>The name of the <code>Map\URI</code> matcher must be the same as the siteaccess name. This also means that only one URI can be addressed by the same matcher.</p>
</div>
</div></td>
<td><p><strong>URI:</strong> <code>/something/my/content</code></p>
<p>Map:</p>
<ul>
<li>something =&gt; ezdemo_site</li>
<li>foobar =&gt; ezdemo_site_admin</li>
</ul>
<p>Matched siteaccess: ezdemo_site</p></td>
</tr>
<tr class="odd">
<td><code>Map\Port</code></td>
<td>Maps a port to a siteaccess</td>
<td><p>A has map of Port/siteaccess</p>
<div class="code panel pdl" style="border-width: 1px;">
<div class="codeContent panelContent pdl">
<pre class="brush: php; gutter: false; theme: Eclipse" style="font-size:12px;"><code>ezpublish:
    siteaccess:
        match:
            Match\Port:
                80: foo
                8080: bar</code></pre>
</div>
</div></td>
<td><p><strong>URL:</strong> <code>             http://ezpublish.dev:8080/my/content           </code></p>
<p>Map:</p>
<ul>
<li>80: foo</li>
<li>8080: bar</li>
</ul>
<p>Matched siteaccess: bar</p></td>
</tr>
<tr class="even">
<td><code>Regex\Host</code></td>
<td>Matches against a regexp and extracts a portion of it</td>
<td><p>The regexp to match against<br />
and the captured element to use</p>
<div class="code panel pdl" style="border-width: 1px;">
<div class="codeContent panelContent pdl">
<pre class="brush: php; gutter: false; theme: Eclipse" style="font-size:12px;"><code>ezpublish:
    siteaccess:
        match:
            Regex\Host:
                regex: &quot;^(\\w+_sa)$&quot;
                # Default is 1
                itemNumber: 1</code></pre>
</div>
</div></td>
<td><p><strong>Host name:</strong> <code>example_sa</code></p>
<p>regex: <code>^(\\w+)_sa$</code><br />
itemNumber: 1</p>
<p>Matched siteaccess: example</p></td>
</tr>
<tr class="odd">
<td><code>Regex\URI</code></td>
<td>Matches against a regexp and extracts a portion of it</td>
<td><p><span>The regexp to match against<br />
and the captured element to use</span></p>
<div class="code panel pdl" style="border-width: 1px;">
<div class="codeContent panelContent pdl">
<pre class="brush: php; gutter: false; theme: Eclipse" style="font-size:12px;"><code>ezpublish:
    siteaccess:
        match:
            Regex\URI:
                regex: &quot;^/foo(\\w+)bar&quot;
                # Default is 1
                itemNumber: 1</code></pre>
</div>
</div>
<p><span><br />
</span></p></td>
<td><p><strong>URI:</strong> <code>/footestbar/something</code></p>
<p>regex: ^/foo(\\w+)bar<br />
itemNumber: 1</p>
<p>Matched siteaccess: test </p></td>
</tr>
</tbody>
</table>

### Compound siteaccess matcher

The Compound siteaccess matcher allows you to combine several matchers together:

-   <http://example.com/en> matches site\_en (match on host=[example.com](http://example.com) *and* URIElement(1)=en)
-   <http://example.com/fr> matches site\_fr (match on host=[example.com](http://example.com) *and* URIElement(1)=fr)
-   <http://admin.example.com> matches site\_admin (match on host=[admin.example.com](http://admin.example.com))

Compound matchers cover the legacy  ***host\_uri*** matching feature.

They are based on logical combinations, or/and, using logical compound matchers:

-   `Compound\LogicalAnd`
-   `Compound\LogicalOr`

Each compound matcher will specify two or more sub-matchers. A rule will match if all the matchers, combined with the logical matcher, are positive. The example above would have used `Map\Host` and `Map\Uri`., combined with a `LogicalAnd`. When both the URI and host match, the siteaccess configured with "match" is used.

**ezplatform.yml**

``` brush:
ezpublish:
    siteaccess:
        match:
            Compound\LogicalAnd:
                # Nested matchers, with their configuration.
                # No need to precise their matching values (true will suffice).
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

It is possible to define which siteaccess to use by setting an **X-Siteaccess** header in your request. This can be useful for REST requests.

In such case, **X-Siteaccess** must be the **siteaccess name** (e.g. *ezdemo\_site*).

### Matching by environment variable

It is also possible to define which siteaccess to use directly via an **EZPUBLISH\_SITEACCESS** environment variable.

This is recommended if you want to get **performance gain** since no matching logic is done in this case.

You can define this environment variable directly from your web server configuration:

**Apache VirtualHost example**

``` brush:
# This configuration assumes that mod_env is activated
<VirtualHost *:80>
    DocumentRoot "/path/to/ezpublish5/web/folder"
    ServerName example.com
    ServerAlias www.example.com
    SetEnv EZPUBLISH_SITEACCESS ezdemo_site
</VirtualHost>
```

This can also be done via PHP-FPM configuration file, if you use it. See  [PHP-FPM documentation](http://php.net/manual/en/install.fpm.configuration.php#example-60)  for more information.

Note about precedence

 The precedence order for siteaccess matching is the following (the first matched wins):

1.  Request header
2.  Environment variable
3.  Configured matchers

### URILexer and semanticPathinfo

In some cases, after matching a siteaccess, it is neecessary to modify the original request URI. This is for example needed with URI-based matchers since the siteaccess is contained in the original URI and it is not part of the route itself.

The problem is addressed by *analyzing* this URI and by modifying it when needed through the **URILexer** interface.

**URILexer interface**

``` brush:
/**
 * Interface for SiteAccess matchers that need to alter the URI after matching.
 * This is useful when you have the siteaccess in the URI like "/<siteaccessName>/my/awesome/uri"
 */
interface URILexer
{
    /**
     * Analyses $uri and removes the siteaccess part, if needed.
     *
     * @param string $uri The original URI
     * @return string The modified URI
     */
    public function analyseURI( $uri );
    /**
     * Analyses $linkUri when generating a link to a route, in order to have the siteaccess part back in the URI.
     *
     * @param string $linkUri
     * @return string The modified link URI
     */
    public function analyseLink( $linkUri );
}
```

Once modified, the URI is stored in the ***semanticPathinfo*** request attribute, and the original pathinfo is not modified.

# Usage

## Cross-siteacess links

When using the *multisite* feature, it is sometimes useful to be able to **generate cross-links** between the different sites.
This allows you to link different resources referenced in the same content repository, but configured independently with different tree roots.

**Twig example**

``` brush:
 {# Linking a location #} 
<a href="{{ url( 'ez_urlalias', {'locationId': 42, 'siteaccess': 'some_siteaccess_name'} ) }}">{{ ez_content_name( content ) }}</a>

{# Linking a regular route #} 
<a href="{{ url( "some_route_name", {"siteaccess": "some_siteaccess_name"} ) }}">Hello world!</a>
```

See [ez\_urlalias](ez_urlalias_32114047.html) documentation page, for more information about linking to a Location

**PHP example**

``` brush:
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

     

Important

As siteaccess matchers can involve hosts and ports, it is **highly recommended** to generate cross-siteaccess links in an absolute form (e.g. using `url()` Twig helper).

### Troubleshooting

-   The **first matcher succeeding always wins**, so be careful when using *catch-all* matchers like `URIElement`.
-   If passed siteaccess name is not a valid one, an `InvalidArgumentException` will be thrown.
-   If matcher used to match the provided siteaccess doesn't implement `VersatileMatcher`, the link will be generated for the current siteaccess.
-   When using `Compound\LogicalAnd`, all inner matchers **must match**. If at least one matcher doesn't implement `VersatileMatcher`, it will fail.
-   When using `Compound\LogicalOr`, the first inner matcher succeeding will win.

### Under the hood

To implement this feature, a new `VersatileMatcher` was added to allow siteaccess matchers to be able to *reverse-match*.
All existing matchers implement this new interface, except the Regexp based matchers which have been deprecated.

The siteaccess router has been added a `matchByName()` method to reflect this addition. Abstract URLGenerator and `DefaultRouter` have been updated as well.

Note

Siteaccess router public methods have also been extracted to a new interface, `SiteAccessRouterInterface`.

### Navigating between siteaccesses - limitations

There are two known limitations to moving between siteaccesses in eZ Enteprise's Landing Pages:

**1.** On a Landing Page you can encounter a 404 error when clicking a relative link which points to a different siteaccess (if the Content item being previewed does not exist in the previously used siteaccess). This is because detecting siteaccesses when navigating in preview is not functional yet. This is a known limitation that is awaiting resolution.

**2.** When navigating between siteaccesses in the back office using the top bar, you are always redirected to the main page, not to the Content item you started from.

## Dynamic Settings Injection

Before 5.4, if you wanted to implement a service needing siteaccess-aware settings (e.g. language settings), you needed to inject the whole `ConfigResolver` (`ezpublish.config.resolver`) and get the needed settings from it. This was neither very convenient nor explicit.

The goal of this feature is to allow developers to inject these dynamic settings explicitly from their service definition (yml, xml, annotation, etc.).

### Syntax

Static container parameters follow the `%<parameter_name>%` syntax in Symfony.

Dynamic parameters have the following: `$<parameter_name>[; <namespace>[; <scope>]]$`, default namespace being `ezsettings`, and default scope being the current siteaccess.

For more information, see [ConfigResolver documentation](https://doc.ez.no/display/DEVELOPER/SiteAccess#SiteAccess-Configuration).

### DynamicSettingParser

This feature also introduces a *DynamicSettingParser* service that can be used for adding support of the dynamic settings syntax.
This service has `ezpublish.config.dynamic_setting.parser` for ID and implements` eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\DynamicSettingParserInterface`.

### Limitations

A few limitations still remain:

-   It is not possible to use dynamic settings in your semantic configuration (e.g. `config.yml` or `ezplatform.yml`) as they are meant primarily for parameter injection in services.
-   It is not possible to define an array of options having dynamic settings. They will not be parsed. Workaround is to use separate arguments/setters.
-   Injecting dynamic settings in request listeners is **not recommended**, as it won't be resolved with the correct scope (request listeners are **instantiated before SiteAccess match**). Workaround is to inject the ConfigResolver instead, and resolving the setting in your `onKernelRequest` method (or equivalent).

### Examples

#### Injecting an eZ parameter

Defining a simple service needing `languages` parameter (i.e. prioritized languages).

Note

Internally, `languages` parameter is defined as `ezsettings.<siteaccess_name>.languages`, `ezsettings` being eZ internal *namespace*.

#### **Before 5.4
**

``` brush:
parameters:
    acme_test.my_service.class: Acme\TestBundle\MyServiceClass

services:
    acme_test.my_service:
        class: %acme_test.my_service.class%
        arguments: [@ezpublish.config.resolver]

namespace Acme\TestBundle;
```

**
**

``` brush:
use eZ\Publish\Core\MVC\ConfigResolverInterface;

class MyServiceClass
{
    /**
 * Prioritized languages
 *
 * @var array
 */
    private $languages;

    public function __construct( ConfigResolverInterface $configResolver )
    {
        $this->languages = $configResolver->getParameter( 'languages' );
    }
}
```

#### After, with setter injection (preferred)

``` brush:
parameters:
    acme_test.my_service.class: Acme\TestBundle\MyServiceClass

services:
    acme_test.my_service:
        class: %acme_test.my_service.class%
        calls:
            - [setLanguages, ["$languages$"]]
```

``` brush:
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

 

 

**Important**: Ensure you always add `null` as a default value, especially if the argument is type-hinted.

#### After, with constructor injection

``` brush:
parameters:
    acme_test.my_service.class: Acme\TestBundle\MyServiceClass

services:
    acme_test.my_service:
        class: %acme_test.my_service.class%
        arguments: ["$languages$"]
```

``` brush:
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

 

 

Tip

Setter injection for dynamic settings should always be preferred, as it makes it possible to update your services that depend on them when ConfigResolver is updating its scope (e.g. when previewing content in a given SiteAccess). **However, only one dynamic setting should be injected by setter** .

**Constructor injection will make your service be reset in that case.**

#### Injecting 3rd party parameters

 

``` brush:
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

``` brush:
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

#### In this topic:

-   [Introduction](#SiteAccess-Introduction)
    -   [What does a siteaccess do?](#SiteAccess-Whatdoesasiteaccessdo?)
    -   [How is a siteaccess selected?](#SiteAccess-Howisasiteaccessselected?)
    -   [What can you use siteaccesses for?](#SiteAccess-Whatcanyouusesiteaccessesfor?)
    -   [Use case: multilanguage sites](#SiteAccess-Usecase:multilanguagesites)
    -   [The default scope](#SiteAccess-Thedefaultscope)
-   [Configuration](#SiteAccess-Configuration)
    -   [Basics](#SiteAccess-Basics)
        -   [Example](#SiteAccess-Example)
    -   [Dynamic configuration with the ConfigResolver](#SiteAccess-DynamicconfigurationwiththeConfigResolver)
        -   [Scope](#SiteAccess-Scope)
        -   [ConfigResolver Usage](#SiteAccess-ConfigResolverUsage)
        -   [Inject the ConfigResolver in your services](#SiteAccess-InjecttheConfigResolverinyourservices)
    -   [Custom locale configuration](#SiteAccess-Customlocaleconfiguration)
    -   [Siteaccess Matching](#SiteAccess-SiteaccessMatching)
        -   [Available matchers](#SiteAccess-Availablematchers)
        -   [Compound siteaccess matcher](#SiteAccess-Compoundsiteaccessmatcher)
        -   [Matching by request header](#SiteAccess-Matchingbyrequestheader)
        -   [Matching by environment variable](#SiteAccess-Matchingbyenvironmentvariable)
        -   [URILexer and semanticPathinfo](#SiteAccess-URILexerandsemanticPathinfo)
-   [Usage](#SiteAccess-Usage)
    -   [Cross-siteacess links](#SiteAccess-Cross-siteacesslinks)
        -   [Troubleshooting](#SiteAccess-Troubleshooting)
        -   [Under the hood](#SiteAccess-Underthehood)
        -   [Navigating between siteaccesses - limitations](#SiteAccess-Navigatingbetweensiteaccesses-limitations)
    -   [Dynamic Settings Injection](#SiteAccess-DynamicSettingsInjection)
        -   [Syntax](#SiteAccess-Syntax)
        -   [DynamicSettingParser](#SiteAccess-DynamicSettingParser)
        -   [Limitations](#SiteAccess-Limitations)
        -   [Examples](#SiteAccess-Examples)

#### Related topics:

[Cross-siteaccess links](https://doc.ez.no/display/DEVELOPER/SiteAccess#SiteAccess-Cross-siteacesslinks)

[Setting the Index Page](Multisite_31430389.html#Multisite-SettingTheIndexPage)






