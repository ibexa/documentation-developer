# Multisite configuration

You can configure the available SiteAccesses under the `ibexa.siteaccess` key.

## SiteAccess configuration

``` yaml
ibexa:
    siteaccess:
        list: [site, event]
        groups:
            site_group: [site]
            event_group: [event]
        default_siteaccess: site
        match:
            URIElement: 1
```

### SiteAccess groups

`ibexa.siteaccess.groups` defines which groups SiteAccesses belong to.

``` yaml
ibexa:
    siteaccess:
        groups:
            site_group: [site]
            event_group: [event]
```

Groups are useful when you want to use common settings for several SiteAccesses and avoid duplicating configuration.
SiteAccess groups act like regular SiteAccesses as far as configuration is concerned.
A SiteAccess can be part of several groups. SiteAccess configuration has always precedence over group configuration.

#### `admin` SiteAccess

The predefined `admin` SiteAccess in `admin_group` (configured in `config/packages/ibexa_admin_ui.yaml`) serves the Back Office.
Do not remove this group.
If you need a multisite setup with multiple Back Offices, add any additional administration SiteAccesses to `admin_group`.

In cases where the sites are on separate databases, each needs its own [repository](../configuration.md#configuration-examples)
(including their own storage and search connection), var dir, [cache pool](../persistence_cache.md#persistence-cache-configuration),
and ideally also separate Varnish/Fastly configuration.

!!! caution

    Different SiteAccesses can only have different `var_dir` if they also have different repositories.

### Default SiteAccess

The `default_siteaccess` setting identifies which SiteAccess is used by default when no other SiteAccess matches.

``` yaml
ibexa:
    siteaccess:
        default_siteaccess: site
```

### SiteAccess matching

The `match` setting defines the rule or set of rules by which SiteAccesses are matched.
See [SiteAccess matching](siteaccess_matching.md) for more information.

``` yaml
ibexa:
    siteaccess:
        match:
            URIElement: 1
```

### SiteAccess name

To create a better editorial experience, you can replace the SiteAccess code in the Back Office
with a human-readable name of the website, for example `Company site` or `Summer Sale`.

You can also translate SiteAccess names. Displayed names depend on the current Back Office language.

To define translations or SiteAccess names, place them in YAML file with correct language code,
for example `translations/ibexa_siteaccess.en.yaml`:

``` yaml
en: Company site
fr: Company site France
```

## Scope

All SiteAccess-aware configuration is resolved depending on scope.

The available scopes are:

1. `global`
2. SiteAccess
3. SiteAccess group
4. `default`

`global` overrides all other scopes.
If `global` is not defined, the configuration then tries to match a SiteAccess, and then a SiteAccess group.
Finally, if no other scope is matched, `default` is applied.

In short: if you want a match that always applies, regardless of SiteAccesses, use `global`.
To define a fallback, use `default`.

``` yaml
ibexa:
    system:
        global:
            # If set, this value is used regardless of any other configuration
        site:
            # This is used for the 'site' SiteAccess
        site_group:
            # This is overwritten by the SiteAccess above, since the SiteAccess has precedence
        default:
            # This value is only used if there is no setting for global scope, SiteAccess or SiteAccess group
```

`global` and `default` scopes include the `admin` SiteAccess, which is responsible for the Back Office.
For example, the following configuration defines both the front template for articles
and the template used in the Back Office, unless you configure other templates for a specific SiteAccess or SiteAccess group:

``` yaml
ibexa:
    system:
        default:
            content_view:
                full:
                    article:
                        template: full/article.html.twig
                        match:
                            Identifier\ContentType: [article]
```

### SiteAccesses and Page Builder [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

To define which SiteAccesses are available in the submenu in Page Builder, use the following configuration:

``` yaml
ibexa:
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
ibexa:
    system:
        admin:
            page_builder:
                siteaccess_list: [site, de, fr, no]
                siteaccess_hosts:
                    - my_domain.com
                    - another_domain.org
```

!!! caution "SiteAccess with separate admin domain"

    If an admin SiteAccess in your installation uses a different domain than the front SiteAccesses,
    be sure to use SSL (https protocol).
    Otherwise, you cannot preview content in Page Builder from the Back Office.

#### SiteAccess switching in Page Builder [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

If you need to change between SiteAccesses in Site mode, do not use any functions in the page itself (for example, a language switcher).
This may cause unexpected errors. Instead, switch between SiteAccesses using the SiteAccess bar above the page.

## Location tree

You can restrict SiteAccesses to different parts of the content tree.
When you do it, only the selected Location and its descendants are reachable from this SiteAccess.

Configure this under `ibexa.systems.<scope>.content.tree_root`, for example:

``` yaml
ibexa:
    system:
        <scope>:
            content:
                tree_root:
                    location_id: 42
                    excluded_uri_prefixes: [/media, /images]
            index_page: /EventFrontPage
```

- `location_id` defines the Location ID of the content root for the SiteAccess.
- `excluded_uri_prefixes` defines which URIs ignore the root limit set using `location_id`.
In the example above, the Media and Images folders are accessible using their own URI,
even though they are outside the Location provided in `content.tree_root.location_id`.
- `index_page` is the page shown when you access the root index `/`.

!!! note
    
    Prefixes are not case sensitive.
    Leading slashes (`/`) are automatically trimmed internally, so they can be ignored.

!!! tip

    For an example of a multisite configuration, see [Set up campaign SiteAccess](set_up_campaign_siteaccess.md).
