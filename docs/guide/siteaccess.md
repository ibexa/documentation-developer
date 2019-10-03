# SiteAccess

## Introduction

eZ Platform enables you to maintain multiple sites in one installation using a feature called **SiteAccesses**.

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

!!! enterprise

    If you need to change between SiteAccesses in Page mode, do not use any functions in the page itself (for example, a language switcher). This may cause unexpected errors. Instead, switch between SiteAccesses using the SiteAccess bar above the page.

## Configuring SiteAccesses

You configure SiteAccess in your config files (e.g. `ezplatform.yml`) under the `ezpublish.siteacess` keys.

!!! tip
    
    If you encounter issues when configuring SiteAccess or want to check that system uses the correct value, use the following command:
    
    `bin/console [—-siteaccess=<SA>] ezplatform:debug:config-resolver <param.name>`
    
    For advanced users, the command can be used to test how different parameters work when configuring [scopes](#scope). 

The required elements of the configuration are:

#### `list`

Lists all SiteAccesses in the installation.

#### `default_siteaccess`

Identifies which SiteAccess will be used by default when no other is specified.

#### `groups` (optional)

Collects SiteAccesses into groups that can be used later for configuration.

#### `match`

The rule or set of rules by which SiteAccesses are matched. See [SiteAccess matching](siteaccess_matching.md) for more information.

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

    A new SiteAccess is recognized by the system, but an Anonymous User will not have read access to it until it is [explicitly given via the Admin > Roles panel](permissions.md#use-cases). Without read access the Anonymous User will simply be directed to the default login page.

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

## Injecting SiteAccess

SiteAccess is exposed in the Dependency Injection Container as the `@ezpublish.siteaccess` service, so it can be injected into any custom service.

The `@ezpublish.siteaccess` service, if needed, must be injected using setter injection. It comes from the fact that SiteAccess matching
is done in a `kernel.request` event listener, so when injected into a constructor, it might not be initialized properly.

To ensure proper contract, the `eZ\Publish\Core\MVC\Symfony\SiteAccess\SiteAccessAware` interface can be implemented on a custom service.

**Example**

Let's define a simple service which depends on the Repository's ContentService and the current SiteAccess.

```yaml
services:
    acme.test.my_service:
        class: Acme\AcmeTestBundle\MyService
        arguments: ['@ezpublish.api.service.content']
        calls:
            - [setSiteAccess, ['@ezpublish.siteaccess']]
```

```php
<?php
namespace Acme\AcmeTestBundle;

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
