# Multisite

## Introduction

With eZ Platform it is possible to serve multiple, completely different sites using one eZ Platform instance and database.

Each site will have its own content root, at a lower level than the default one (Location ID 2). One backoffice can be used for each site, but it is also possible to use a global one.

This feature is a reimplementation of the [PathPrefix](http://doc.ez.no/eZ-Publish/Technical-manual/4.x/Reference/Configuration-files/site.ini/SiteAccessSettings/PathPrefix) one that existed in eZ Publish Legacy.

## Configuration

The feature is configured in `ezplatform.yml`, either at siteaccess or siteaccess group level:

``` yaml
ezpublish:
    system:
        ezdemo_site_group:
            content:
                tree_root:
                    # Root locationId. Default is top locationId
                    location_id: 123
                    # Every URL aliases starting with those prefixes will be considered
                    # being outside of the subtree starting at root_location.
                    # Default value is an empty array.
                    # Prefixes are not case sensitive.
                    excluded_uri_prefixes: [ /media, /images ]
```

##### `content.tree_root.location_id`

This parameter sets the Location ID of the content root. The API is jailed within this root, and nothing above this level will be accessible by default. This parameter can be filtered using the `excluded_uri_prefixes` parameter described below.

##### `content.tree_root.excluded_uri_prefixes`

Use this parameter to exclude a list of URIs from the root jail defined using `location_id` described above. Add as many locations pathString as you like. In the example above, the Media and Images folders will be accessible using their own URI even though they're not below `tree_root.location_id`.

!!! note

    Leading slashes (`/`) are automatically trimmed internally by eZ Platform, so they can be ignored.

## Usage

### Multisite Design

eZ Platform does not apply a [Legacy template fallback](https://doc.ez.no/display/EZP/Legacy+template+fallback) like eZ Publish did. You can, however, have different designs in your multisite installation if you organize the view configuration with the use of siteaccesses.

You can see how this is done on the example of a multisite that contains two blogs with different designs, but sharing some templates. Let's assume you have a siteaccess called `second_site`. You can organize your templates in the following folder structure:

``` yaml
views
 |- pagelayout.html.twig
     |- full
         |- blog.html.twig
         |- blog_post.html.twig
     |- second_site
         |- pagelayout.html.twig
         |- full
             |- blog_post.html.twig
```

Now you can use this view configuration (stored e.g. in a `views.yml` file):

``` yaml
ezpublish:
    system:
        default:
            pagelayout: pagelayout.html.twig
            content_view:
                full:
                    blog:
                        template: "full/blog.html.twig"
                        match:
                            Identifier\ContentType: [blog]
                    blog_post:
                        template: "full/blog_post.html.twig"
                        match:
                            Identifier\ContentType: [blog_post]
        second_site:
            pagelayout: second_site/pagelayout.html.twig
            content_view:
                full:
                    blog_post:
                        template: "second_site/full/blog_post.html.twig"
                        match:
                            Identifier\ContentType: [blog_post]
```

This config defines views that will be used for the `second_site` siteaccess: a separate `second_site/pagelayout.html.twig` and a template to be used for blog posts. When no view is defined under `second_site`, such as in the case of the `blog` Content Type, the template defined under `default` will apply. `default` will also be used for all siteaccesses other than `second_site`.

To load the base layout in templates you now need to use `{% extends noLayout == true ? viewbaseLayout : pagelayout %}`.

### Setting the Index Page

The Index Page is the page shown when the root index / is accessed.
You can configure the Index Page separately for each siteaccess. Put the parameter `index_page` in your `ezplatform.yml` file, under the right siteaccess category.

``` yaml
# ezplatform.yml

ezpublish:
    system:
        mygreat_site:
            languages:
                - eng-US
            #The page to show when accessing IndexPage (/)
            index_page: /yourURIPage
```

If not specified, the `index_page` is the configured content root.
