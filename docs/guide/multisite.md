# Multisite

## Introduction

You can serve multiple different sites using one eZ Platform instance and database.

Each site will have its own content root, at a lower level than the default one (Location ID 2).
You can use one global back office for all sites, or a separate back office for each site.

This feature is a reimplementation of the [PathPrefix](http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Configuration-files/site.ini/SiteAccessSettings/PathPrefix) that existed in eZ Publish Legacy.

## Configuring multisite

Multisite is configured in `ezplatform.yml`, either at [SiteAccess](siteaccess.md) or SiteAccess group level:

``` yaml
ezpublish:
    system:
        site_group:
            content:
                tree_root:
                    # Root locationId. Default is top locationId
                    location_id: 123
                    # All URL aliases starting with those prefixes will be considered
                    # being outside of the subtree starting at root_location.
                    # Default value is an empty array.
                    # Prefixes are not case sensitive.
                    excluded_uri_prefixes: [ /media, /images ]
```

### Configuration parameters

The two configuration parameters, `location_id` and `excluded_uri_prefixes` are taken into account in several places,
for example in URL alias lookups for incoming web requests, and URL alias path generation in Twig templates.
In addition you need to consider them when generating site paths in your layout, or other places rendering site/tree structure.

#### `location_id`

`content.tree_root.location_id` sets the Location ID of the content root of your site
and nothing above this level will be accessible by default.
This parameter can be filtered using the `excluded_uri_prefixes` parameter.

#### `excluded_uri_prefixes`

`content.tree_root.excluded_uri_prefixes` defines which URIs ignore the root limit set using `location_id`.
Add as many Location pathStrings as you like.
In the example above, the Media and Images folders will be accessible using their own URI even though they are not below `content.tree_root.location_id`.

!!! note

    Leading slashes (`/`) are automatically trimmed internally, so they can be ignored.

## Configuration example

To see how multisite can be used, let's look at an example of two sites using the same eZ Platform instance: a general site and a children's site.
Separate SiteAccess groups are set up for the two sites:

``` yaml
ezpublish:
    siteaccess:
        list: [site, kids]
        groups:
            site_group: [site]
            kids_group: [kids]
        default_siteaccess: site
        match:
            URIElement: 1
```

This is your content structure:

```
├── Content
│   ├── General
│   │   └── Articles
│   │       └── Mammals
│   └── Children
│       └── Articles
│           └── Lions
└── Media
    └── Images
        └── Animal-photos
```

You can now set the root level for `kids_group` to only access the "Children" Location and its sub-items:

``` yaml
ezpublish:
    system:
        kids_group:
            content:
                tree_root:
                    # LocationId of "Children"
                    location_id: 57
```

Thanks to this config, you can access `<your site>/kids/Articles/Lions`, but not `<your site>/kids/General/Articles/Mammals`.

In the next step, you need to reuse some content between sites, for example "Animal-photos" from "Media".
You can allow the children's site to access them, even though they are in a different part of the tree, via `excluded_uri_prefixes`:

``` yaml
        kids_group:
            content:
                tree_root:
                    location_id: 57
                    excluded_uri_prefixes: [ /media/images/animal-photos ]
```

At this point, using the `kids` SiteAccess, you gain access to `<your site>/kids/Media/Images/Animal-photos`,
despite the fact that it is not a sub-item of the "Children" Location.

### Setting the Index Page

The Index Page is the page shown when the root index `/` is accessed.
You can configure the Index Page separately for each SiteAccess. Place the parameter `index_page` in your `ezplatform.yml` file, under the correct SiteAccess:

``` yaml
# ezplatform.yml

ezpublish:
    system:
        kids_group:
            # The page to show when accessing IndexPage (/)
            index_page: /KidsFrontPage
```

If not specified, the `index_page` is the configured content root.

### Limitations when using with multisite URI matching with multi-repository setup

!!! caution

    Only one repository (database) can be used per domain.
    This does not prohibit using [different repositories](repository.md#multi-repository-setup) on different subdomains.
    However, when using URI matching for multisite setup, all SiteAccesses sharing domain also need to share repository.
    For example:

    - `ez.no` domain can use `ez_repo`
    - `doc.ez.no` domain can use `doc_repo`

    But the following configuration would be invalid:

    - `ez.no` domain can use `ez_repo`
    - `ez.no/doc` **cannot** use `doc_repo`, as it is under the same domain.

    Invalid configuration will cause problems for different parts of the system,
    for example back-end UI, REST interface and other non-SiteAccess-aware Symfony routes
    such as `/_fos_user_context_hash` used by [HTTP cache](http_cache.md).

## Different designs for multiple sites

eZ Platform does not apply a [Legacy template fallback](https://doc.ez.no/display/EZP/Legacy+template+fallback) like eZ Publish did.
You can, however, have different designs in your multisite installation if you organize the view configuration with the use of SiteAccesses.

Looking back at the [previous example](#configuration-example), you can apply different designs to the two sites, but use some common templates.
To do this, organize your templates in the following folder structure:

```
views
├── pagelayout.html.twig
│   └── full
│       └── article.html.twig
│   └── kids
│       ├── pagelayout.html.twig
│       └── full
│           └── article.html.twig
```

Now you can use this view configuration (stored e.g. in a `views.yml` file):

``` yaml
ezpublish:
    system:
        default:
            pagelayout: pagelayout.html.twig
            content_view:
                full:
                    article:
                        template: "full/article.html.twig"
                        match:
                            Identifier\ContentType: [article]
                    news:
                        template: "full/news.html.twig"
                        match:
                            Identifier\ContentType: [news]
        kids:
            pagelayout: kids/pagelayout.html.twig
            content_view:
                full:
                    article:
                        template: "kids/full/article.html.twig"
                        match:
                            Identifier\ContentType: [article]
```

This config defines views that will be used for the `kids` SiteAccess:
a separate `kids/pagelayout.html.twig` and a template to be used for articles.
When no view is defined under `kids`, such as in the case of the `news` Content Type,
the template defined under `default` will apply. `default` will also be used for all SiteAccesses other than `kids`.

To load the base (default) layout in templates you now need to use `{% extends noLayout == true ? viewbaseLayout : pagelayout %}`.
(See [Template inheritance and sub-requests](content_rendering.md#template-inheritance-and-sub-requests) for more information).
