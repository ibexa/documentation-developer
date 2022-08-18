---
description: Ibexa DXP uses the Twig template engine to customize the rendering of content in the site.
---

# Templates

You can customize the layout and look of your website with templates.
Templates use the Twig template engine.

!!! tip

    Learn more about Twig templates from [Twig documentation](https://twig.symfony.com/doc/2.x/templates.html).

## Connecting templates

Templates can inherit from other templates.
Use this, for example, to inherit a general page layout including a [navigation menu](add_navigation_menu.md) in article templates.

To inherit from other templates, a template must extend the parent templates
using the [`extends()`](https://twig.symfony.com/doc/3.x/tags/extends.html) Twig function.
To extend a parent template, the child template must contain Twig blocks.
These blocks are inserted in the parent template in relevant places.

For example, to extend the [general layout of the page](template_configuration.md#view-rules-and-matching), which includes header, footer, navigation, and so on,
in the child template place the content in a `content` block:

``` html+twig
{% extends '@ibexadesign/pagelayout.html.twig' %}

{% block content %}
{% endblock %}
```

The parent template (in this case, `pagelayout.html.twig`) must leave a place for this block:

``` html+twig
{% block content %}
{% endblock %}
```

## Template variables

In templates, you can use variables related to the current Content item,
as well as general variables related to the current view and general application settings.

[[= include_file('docs/snippets/rendering_dump_variable.md') =]]

Main variables include:

|Variable |Description|
|------|------|
|`content`|Content item, containing all Fields and version information (VersionInfo). |
|`location`|Location object. Contains meta information on the Content (ContentInfo). |
|`ibexa.siteaccess`| Current [SiteAccess](multisite.md). |
|`ibexa.rootLocation`| Root Location object. |
|`ibexa.requestedUriString`| Requested URI string. |
|`ibexa.systemUriString`| System URI string. System URI is the URI for internal content controller. If the current route is not a URL alias, then the current PathInfo is returned. |
|`ibexa.viewParameters`| View parameters as a hash. |
|`ibexa.viewParametersString`| View parameters as a string. |
|`ibexa.translationSiteAccess`| Translation SiteAccess for a given language (null if the SiteAccess cannot be found). |
|`ibexa.availableLanguages`| List of available languages. |
|`ibexa.configResolver`| [Config resolver](dynamic_configuration.md#configresolver). |

### Custom template variables

You can create custom Twig variables for use in templates.
Set the variables per SiteAccess or SiteAccess group ([scope](multisite_configuration.md#scope)), or per content view.

To configure a custom template variable per scope, use the `twig_variables` key:

``` yaml
[[= include_file('code_samples/front/render_content/config/packages/views.yaml', 4, 7) =]][[= include_file('code_samples/front/render_content/config/packages/views.yaml', 31, 33) =]]
```

You can access this variable directly in all templates in that scope:

``` html+twig
{{ custom_variable }}
```

Variables set for a specific content view (under `params`) are only available when this view is matched:

``` yaml
[[= include_file('code_samples/front/render_content/config/packages/views.yaml', 24, 31) =]]
```

Custom variables can be nested:

``` yaml
twig_variables:
    custom_variable:
        nested_variable: 'variable_value'
```

``` html+twig
{{ custom_variable.nested_variable }}
```

You can use [Symfony Expression language]([[= symfony_doc =]]/components/expression_language.html)
to access other values, for example:

``` yaml
params:
    custom_variable: "@=content.contentType.identifier"
```

!!! note

    A custom variable can overwrite an existing variable,
    so it is good practice to avoid existing variable names such as `content` or `location`.
