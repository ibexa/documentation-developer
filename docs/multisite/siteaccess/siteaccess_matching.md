---
description: Use SiteAccess matchers to control which site is served when and to which user.
---

# SiteAccess matching

To be usable, every SiteAccess must be matched by one of configured matchers.
By default, all SiteAccesses are matched using `URIElement: 1`.

You can configure SiteAccess matchers under the `ibexa.siteaccess.match` key:

``` yaml
ibexa:
    siteaccess:
        list: [site, event]
        groups:
            site_group: [site, event]
        default_siteaccess: site
        match:
            Map\URI:
                site: site
                campaign: event
```

`ibexa.siteaccess.match` can contain multiple matchers.

The first matcher succeeding always wins, so be careful when using catch-all matchers like `URIElement`.

If the matcher class does not start with a backslash (`\`), it is relative to `Ibexa\Core\MVC\Symfony\SiteAccess\Matcher`
(for example, `Map\URI` refers to `Ibexa\Core\MVC\Symfony\SiteAccess\Matcher\Map\URI`)

You can specify [custom matchers](#custom-matchers) by using a fully qualified class name (e.g. `\My\SiteAccess\Matcher`)
or a service identifier (e.g. `@my_matcher_service`).
In the case of a fully qualified class name, the matching configuration is passed in the constructor.
In the case of a service, it must implement `Ibexa\Bundle\Core\SiteAccess\Matcher`.
The matching configuration is passed to `setMatchingConfiguration()`.

## Available SiteAccess matchers

- [`URIElement`](#urielement)
- [`URIText`](#uritext)
- [`HostElement`](#hostelement)
- [`HostText`](#hosttext)
- [`Map\Host`](#maphost)
- [`Map\URI`](#mapuri)
- [`Map\Port`](#mapport)
- [`Ibexa\SiteFactory\SiteAccessMatcher`](#ibexasitefactorysiteaccessmatcher)

### `URIElement`

Maps a URI element to a SiteAccess.	

In configuration, provide the element number you want to match (starting from 1).

``` yaml
ibexa:
    siteaccess:
        match:
            URIElement: 2
```

!!! note

    When you use a value > 1, the matcher concatenates the elements with `_`.

Example URI `/my_site/company/pages` matches SiteAccess `my_site_company`.

### `URIText`

Matches URI using prefix and suffix sub-strings in the first URI segment.

In configuration, provide the prefix and/or suffix (neither is required).

``` yaml
ibexa:
    siteaccess:
        match:
            URIText:
                prefix: main-
                suffix: /company
```

Example URI `/main-event/company/page` matched SiteAccess `event`.

### `HostElement`

Maps an element in the host name to a SiteAccess.

In configuration, provide the element number you want to match (starting from 1).

``` yaml
ibexa:
    siteaccess:
        match:
            HostElement: 2
```

Example host name `www.example.com` matches SiteAccess `example`.

### `HostText`

Matches a SiteAccess in the host name, using pre and/or post sub-strings.

In configuration, provide the prefix and/or suffix (none are required).

``` yaml
ibexa:
    siteaccess:
        match:
            HostText:
                prefix: www.
                suffix: .com
```

Example host name `www.example.com` matches SiteAccess `example`.

### `Map\Host`

Maps a host name to a SiteAccess.

In configuration, provide a hash map of host/SiteAccess.

``` yaml
ibexa:
    siteaccess:
        match:
            Map\Host:
                www.page.com: event
                adm.another-page.fr: event_admin
```

Example host name `www.page.com` matches SiteAccess `event`.

!!! note

    If you encounter problems with the `Map\Host` matcher, make sure that your installation is
    [properly configured to use token-based authentication](ez_platform_v2.4.md#update-ez-enterprise-v24-to-v242).

### `Map\URI`

Maps a URI to a SiteAccess.

In configuration, provide a hash map of URI/SiteAccess.

```yaml
ibexa:
    siteaccess:
        match:
            Map\URI:
                campaign: event
                site: site
```

Example URI `/campaign/general/articles` matches SiteAccess `event`.

### `Map\Port`

Maps a port to a SiteAccess.

In configuration, provide a hash map of Port/SiteAccess.

``` yaml
ibexa:
    siteaccess:
        match:
            Map\Port:
                80: event
                8080: site
```

Example URL `http://my_site.com:8080/content` matches SiteAccess `site`.

### `Ibexa\SiteFactory\SiteAccessMatcher` [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

Enables the use of [Site Factory](site_factory.md).
Does not take any parameters in configuration:

``` yaml
ibexa:
    siteaccess:
        match:
            '@Ibexa\SiteFactory\SiteAccessMatcher': ~
```

## Custom matchers

Beside the built-in matchers, you can also use your own services to match SiteAcceses:

``` yaml
ibexa:
    siteaccess:
        list: [site]
        groups:
            site_group: [site]
        default_siteaccess: site
        match:
            '@App\Matcher\MySiteaccessMatcher': ~
```

The service must be tagged with `ibexa.siteaccess.matcher`
and must implement `Ibexa\Bundle\Core\SiteAccess\Matcher`
(and `Ibexa\Core\MVC\Symfony\SiteAccess\VersatileMatcher` if you want to use compound logical matchers).

## Combining SiteAccess matchers

You can combine more than one SiteAccess matcher to match more complex situations, for example:

- `http://example.com/en` matches `site_en` (match host example.com and the `en` URI element)
- `http://example.com/fr` matches `site_fr` (match host example.com and the `fr` URI element)
- `http://admin.example.com` matches `site_admin` (match host admin.example.com)

To combine matchers, use compound logical matchers:

- `Compound\LogicalAnd`
- `Compound\LogicalOr`

Each compound matcher specifies two or more sub-matchers.
A rule applies if all the matchers combined with the logical matcher are positive.

To get the result above, you need to combine `Map\Host` and `Map\Uri` using `LogicalAnd`.
When both the URI and host match, the SiteAccess configured with `match` is used.

``` yaml
ibexa:
    siteaccess:
        match:
            Compound\LogicalAnd:
                # You don't need to specify matching values (true is enough).
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

When using `Compound\LogicalAnd`, all inner matchers must match.
All matchers must implement `VersatileMatcher`.
When using `Compound\LogicalOr`, the first inner matcher succeeding wins.

## Matching by request header

You can define which SiteAccess to use by setting an `X-Siteaccess` header in your request.
This can be useful for REST requests.

In such a case, `X-Siteaccess` must be the SiteAccess name (for example, `site` or `en`).

## Matching by environment variable

You can also define which SiteAccess to use directly by using the `EZPUBLISH_SITEACCESS` environment variable.

This is recommended if you want to get performance gain since no matching logic is done in this case.

You can define this environment variable directly in web server configuration:

``` vcl
<!--Apache VirtualHost example-->
# This configuration assumes that mod_env is activated
<VirtualHost *:80>
    DocumentRoot "/path/to/ibexa/web/folder"
    ServerName example.com
    ServerAlias www.example.com
    SetEnv EZPUBLISH_SITEACCESS demo_site
</VirtualHost>
```

!!! tip

    You can configure the variable by using the PHP-FPM configuration file.
    See [PHP-FPM documentation](http://php.net/manual/en/install.fpm.configuration.php#example-60) for more information.

!!! note "Precedence"

    The precedence order for SiteAccess matching is the following (the first matched wins):

    1. Request header
    1. Environment variable
    1. Configured matchers
