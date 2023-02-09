---
description: Add a new design for a special marketing campaign site.
---

# Add new design

To create different designs for different version of the website,
you configure different sites based on the [SiteAccess](multisite.md) content.

This example shows how to prepare a site for a "Summer Sale" marketing campaign
and provide it with a distinct design.

## Configure a new SiteAccess

First, in the SiteAccess configuration in `config/packages/ibexa.yaml`,
add the `campaign` SiteAccess to the list under `ibexa.siteaccess`:

``` yaml
ibexa:
    siteaccess:
        list: 
            - import
            - site
            - admin
            - campaign
        groups:
            site_group: [import, site, campaign]
        default_siteaccess: site
```

Adding the `campaign` SiteAccess to [`site_group`](multisite_configuration.md#siteaccess-groups) enables you to add common configuration for both SiteAccesses at the same time.

!!! tip

    For details about configuring different site roots and matching SiteAccesses, see [Set up campaign SiteAccess](set_up_campaign_siteaccess.md).

## Add themes

Next, configure a new `summersale` design for this theme, also named `summersale`:

``` yaml
[[= include_file('code_samples/front/add_design/config/packages/views.yaml', 0, 3) =]]
```

Notice that the `standard` theme will be automatically added at the end of the `summersale` design's theme list.

Ensure that the `campaign` site uses this design (while the default `site` uses the default `standard` design)

``` yaml
[[= include_file('code_samples/front/add_design/config/packages/views.yaml', 4, 6) =]][[= include_file('code_samples/front/add_design/config/packages/views.yaml', 13, 19) =]]
```

## Add templates

Now, create templates for the two sites.
Templates for the main site should be placed in `templates/themes/standard`,
and templates for the campaign site in `templates/themes/summersale`.

First, modify the built-in general [page layout](template_configuration.md#page-layout) `templates/themes/standard/pagelayout.html.twig`
by including a header and a footer section:

``` html+twig hl_lines="3 8"
[[= include_file('code_samples/front/add_design/templates/themes/standard/pagelayout.html.twig', 18, 28) =]]
```

`@ibexadesign` in the template paths points to a template relevant for the current design.
In case of `site`, the template used for the header is `templates/themes/standard/parts/header.html.twig`.

Create both the header and the footer template, for example:

``` html+twig
[[= include_file('code_samples/front/add_design/templates/themes/standard/parts/header.html.twig') =]]
```

``` html+twig
[[= include_file('code_samples/front/add_design/templates/themes/standard/parts/footer.html.twig') =]]
```

Now, create templates for content, for example for an article, that [extend the page layout](templates.md#connecting-templates):

```html+twig
[[= include_file('code_samples/front/add_design/templates/themes/standard/full/article.html.twig') =]]
```

Configure the content view so that both sites, the main one and the campaign, use this template.
To do it, use the `site_group` that both sites belong to:

``` yaml hl_lines="3 7"
[[= include_file('code_samples/front/add_design/config/packages/views.yaml', 4, 13) =]]
```

Now, create an Article Content item and preview it on the front page.
You should see the article with a header and footer that you defined for the main site.

## Override templates

Now, you need to override the header of the site to fit the campaign.
Create a separate `templates/themes/summersale/parts/header.html.twig` file with different content, for example:

``` html+twig
[[= include_file('code_samples/front/add_design/templates/themes/summersale/parts/header.html.twig') =]]
```

Preview the Article through the `campaign` SiteAccess: `<yourdomain>/campaign/<article-name>`.
You can see that the page uses the campaign header, while the rest of the layout, including the footer,
is the same as in the main site.
This is because you defined `standard` design as fallback for this SiteAccess:

``` yaml
[[= include_file('code_samples/front/add_design/config/packages/views.yaml', 0, 3) =]]
```

In this case, if the design engine cannot find a template for the current design,
it uses the template from the next configured design.
In the case above, the engine does not find the footer template for the `campaign` SiteAccess,
so it uses the one from `standard`.

This way you do not need to provide all templates for a new design, but only those that you want to be different than the fallback one.
