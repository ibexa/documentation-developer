# Add new design

Add a new design for a special marketing campaign site.

To create different designs for different version of the website, you configure different sites based on the [SiteAccess](../../../multisite/multisite/index.md) content.

This example shows how to prepare a site for a "Summer Sale" marketing campaign and provide it with a distinct design.

## Configure a new SiteAccess

First, in the SiteAccess configuration, under the `ibexa.siteaccess` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files), add the `campaign` SiteAccess:

```yaml
ibexa:
    siteaccess:
        list:
            - import
            - site
            - admin
            - corporate
            - campaign
        groups:
            site_group: [import, site, campaign]
            storefront_group: [site]
            corporate_group: [corporate]
        default_siteaccess: site
```

Adding the `campaign` SiteAccess to [`site_group`](../../../multisite/multisite_configuration/index.md#siteaccess-groups) enables you to add common configuration for both SiteAccesses at the same time.

> **Tip: Tip**
>
> For details about configuring different site roots and matching SiteAccesses, see [Set up campaign SiteAccess](../../../multisite/set_up_campaign_siteaccess/index.md).

## Add themes

Next, configure a new `summersale` design for this theme, also named `summersale`:

```yaml
ibexa_design_engine:
    design_list:
        summersale: [summersale]
```

Notice that the `standard` theme is automatically added at the end of the `summersale` design's theme list.

Ensure that the `campaign` site uses this design (while the default `site` uses the default `standard` design).

```yaml
ibexa:
    system:
        campaign:
            languages: [eng-GB]
            design: summersale        
        site:
            languages: [eng-GB]
            design: standard
```

## Add templates

Now, create templates for the two sites. Templates for the main site should be placed in `templates/themes/standard`, and templates for the campaign site in `templates/themes/summersale`.

First, modify the built-in general [page layout](../../templates/template_configuration/index.md#page-layout) `templates/themes/standard/pagelayout.html.twig` by including a header and a footer section:

```html+twig
<body>

{% include '@ibexadesign/parts/header.html.twig' %}

{% block content %}
{% endblock %}

{% include '@ibexadesign/parts/footer.html.twig' %}

{% block javascripts %}
```

`@ibexadesign` in the template paths points to a template relevant for the current design. In case of `site`, the template used for the header is `templates/themes/standard/parts/header.html.twig`.

Create both the header and the footer template, for example:

```html+twig
<div class="page-header">{{ "My site"|trans }}</div>
```

```html+twig
<footer>Copyright Acme SA</footer>
```

Now, create templates for content, for example for an article, that [extend the page layout](../../templates/templates/index.md#connecting-templates):

```html+twig
{% extends '@ibexadesign/pagelayout.html.twig' %}

{% block content %}
{% endblock %}
```

Configure the content view so that both sites, the main one and the campaign, use this template. To do it, use the `site_group` that both sites belong to:

```yaml
ibexa:
    system:
        site_group:
            content_view:
                full:
                    article:
                        template: '@ibexadesign/full/article.html.twig'
                        match:
                            Identifier\ContentType: [ article ]
```

Now, create an Article content item and preview it on the front page. You should see the article with a header and footer that you defined for the main site.

## Override templates

Now, you need to override the header of the site to fit the campaign. Create a separate `templates/themes/summersale/parts/header.html.twig` file with different content, for example:

```html+twig
<div class="page-header">{{ "Welcome to the Summer Sale!"|trans }}</div>
```

Preview the Article through the `campaign` SiteAccess: `<yourdomain>/campaign/<article-name>`. You can see that the page uses the campaign header, while the rest of the layout, including the footer, is the same as in the main site. This is because you defined `standard` design as fallback for this SiteAccess:

```yaml
ibexa_design_engine:
    design_list:
        summersale: [summersale]
```

In this case, if the design engine cannot find a template for the current design, it uses the template from the next configured design. In the case above, the engine doesn't find the footer template for the `campaign` SiteAccess, so it uses the one from `standard`.

This way you don't need to provide all templates for a new design, but only those that you want to be different than the fallback one.
