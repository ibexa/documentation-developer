# SiteAccess Matching

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
            admin_group:    
                - ezdemo_site_admin
        match:
            Map\URI:
                ezdemo_site: ezdemo_site
                eng: eng
                fre: fre
                fr_eng: fr_eng
                ezdemo_site_admin: ezdemo_site_admin
```

You need to set several parameters:

- `ezpublish.siteaccess.default_siteaccess` is the default SiteAccess that will be used if matching was not successful. This ensures that a SiteAccess is always defined.
- `ezpublish.siteaccess.list` is the list of all available SiteAccesses in your website.
- `ezpublish.siteaccess.groups` defines which groups SiteAccesses belong to. This is useful when you want to mutualize settings between several SiteAccesses and avoid config duplication. Siteaccess groups are treated the same as regular SiteAccesses as far as configuration is concerned. A SiteAccess can be part of several groups. A SiteAccess configuration has always precedence on the group configuration.

!!! caution "admin_group"

    Do not remove or rename `admin_group` group. It is used to distinguish common SiteAccesses from admin ones. In case of multisite with multiple Admin Panels, remember to add any additional admin SiteAccesses to this group.

- `ezpublish.siteaccess.match` holds the matching configuration. It consists in a hash where the key is the name of the matcher class. If the matcher class doesn't start with a **\\** , it will be considered relative to `eZ\Publish\MVC\SiteAccess\Matcher` (e.g. `Map\Host` will refer to  `eZ\Publish\MVC\SiteAccess\Matcher\Map\Host`)

Every custom matcher can be specified with a fully qualified class name (e.g. `\My\SiteAccess\Matcher`) or by a service identifier prefixed by @ (e.g. `@my_matcher_service`).

- In the case of a fully qualified class name, the matching configuration will be passed in the constructor.
- In the case of a service, it must implement `eZ\Bundle\EzPublishCoreBundle\SiteAccess\Matcher`. The matching configuration will be passed to `setMatchingConfiguration()`.

!!! note

    Make sure to type the matcher in correct case. If it is in wrong case like "Uri" instead of "URI," it will work well on systems like macOS X because of their case-insensitive file system, but will fail when you deploy it to a Linux server. This is a known artifact of [PSR-0 autoloading](http://www.php-fig.org/psr/psr-0/) of PHP classes.

## Available matchers

- [URIElement](#urielement)
- [URIText](#uritext)
- [HostElement](#hostelement)
- [HostText](#hosttext)
- [Map\Host](#maphost)
- [Map\URI](#mapuri)
- [Map\Port](#mapport)
- [Regex\Host](#regexhost) (deprecated)
- [Regex\URI](#regexuri) (deprecated)

### URIElement

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

### URIText

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

### HostElement

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

### HostText

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

### Map\\Host

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

**Example.** Map:

- `www.foo.com` => `foo_front`
- `admin.foo.com` => `foo_admin`

Host name: `www.example.com`

Matched SiteAccess: `foo_front`

!!! note

    If you encounter problems with the `Map\Host` matcher, make sure that your installation is
    [properly configured to use token-based authentication](../release_notes/ez_platform_v2.4.md#update-ez-enterprise-v24-to-v242).

### Map\\URI

Maps a URI to a SiteAccess.

**Configuration.** A hash map of URI/siteaccess

```yaml
ezpublish:
    siteaccess:
        match:
            Map\URI:
                ezdemo: ezdemo_site
                ezadmin: ezdemo_site_admin
```

**Example.** URI: `/ezdemo/my/content`

Map:

- `ezdemo` => `ezdemo_site`
- `ezadmin` => `ezdemo_site_admin`

Matched SiteAccess: `ezdemo_site`

### Map\\Port

Maps a port to a SiteAccess.

**Configuration.** A hash map of Port/siteaccess

``` yaml
ezpublish:
    siteaccess:
        match:
            Map\Port:
                80: foo
                8080: bar
```

**Example.** URL: `http://ezpublish.dev:8080/my/content`

Map:

- `80`: `foo`
- `8080`: `bar`

Matched SiteAccess: `bar`

### Regex\\Host

!!! caution

    This matcher is deprecated.

Matches against a regexp and extracts a portion of it.

**Configuration.** The regexp to match against and the captured element to use

``` yaml
ezpublish:
    siteaccess:
        match:
            Regex\Host:
                regex: '^(\\w+_sa)$'
                # Default is 1
                itemNumber: 1
```

**Example.** Host name: `example_sa`

regex: `^(\\w+)_sa$`

itemNumber: 1

Matched SiteAccess: `example`

### Regex\\URI

!!! caution

    This matcher is deprecated.

Matches against a regexp and extracts a portion of it.

**Configuration.** The regexp to match against and the captured element to use

``` yaml
ezpublish:
    siteaccess:
        match:
            Regex\URI:
                regex: '^/foo(\\w+)bar'
                # Default is 1
                itemNumber: 1
```

**Example.** URI: `/footestbar/something`

regex: `^/foo(\\w+)bar`; itemNumber: 1

Matched SiteAccess: `test`

## Compound SiteAccess matcher

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

## Matching by request header

It is possible to define which SiteAccess to use by setting an `X-Siteaccess` header in your request. This can be useful for REST requests.

In such a case, `X-Siteaccess` must be the *SiteAccess name* (e.g. `ezdemo_site`).

## Matching by environment variable

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

## URILexer and semanticPathinfo

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