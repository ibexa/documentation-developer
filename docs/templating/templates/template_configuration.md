---
description: Template configuration defines which templates are used for which content and in what cases.
---

# Template configuration

You configure how templates are used under the `content_view` key.

The following example configuration defines template usage for several cases:

``` yaml
[[= include_file('code_samples/front/render_content/config/packages/views.yaml', 4, 8) =]][[= include_file('code_samples/front/render_content/config/packages/views.yaml', 9, 29) =]]
```

## Scope

The content view configuration must be placed under `ibexa.system.<scope>`.

Scope defines the [SiteAccesses](multisite.md) for which the configuration is valid.
It may be a SiteAccess, a SiteAccess group, or one of the [generic configuration scopes](multisite_configuration.md#scope).

## Page layout

`pagelayout` defines the general layout of the whole site.
Other templates can [extend the page layout](#page-layout).

``` yaml
[[= include_file('code_samples/front/render_content/config/packages/views.yaml', 7, 8) =]]
```

## View types

`content_view` defines rules for rendering content.
Rules are grouped per *view type*.

``` yaml
[[= include_file('code_samples/front/render_content/config/packages/views.yaml', 4, 8) =]][[= include_file('code_samples/front/render_content/config/packages/views.yaml', 9, 11) =]]
```

The default, built-in views are:

- `full` - used when the Content item is displayed by itself, as a full page
- `line` - used when content is displayed as an item in a list, for example a list of the contents of a folder
- `text_linked` - used for a text section that is a link
- `embed` - used when one Content item is embedded in another, as a block
- `embed-inline` - used when a Content item is embedded inline in another
- `asset_image` - used when an image asset is embedded in another Content item

The built-in views have built-in default templates.
You can define any other custom views. For each custom view, you must define a custom template.

!!! tip "Direct path to previewing view types"

    You can preview content in a specific view type by using a direct path to the built-in view controller:

    `<yourdomain>/view/content/<contentId>/<viewType>/true/<locationId>`

    For example:

    `<yourdomain>/view/content/55/embed/true/57`

## View rules and matching

Each rule must have a name unique per view type.
For each rule you must define the matching conditions.
The `match` key can contain one or more [view matchers](view_matcher_reference.md), including [custom ones](create_custom_view_matcher.md).

``` yaml
[[= include_file('code_samples/front/render_content/config/packages/views.yaml', 15, 20) =]]
```

`template` indicates which template to use.

`controller` indicates which [controller](controllers.md) and which method to use when rendering the content.
You can use it together with the `template` key, or without it.

`params` can provide additional parameters to the content view.
Use them, for example, with [Query types](content_queries.md#query-types)
or to provide [custom Twig variables](templates.md#custom-template-variables) to the template.

### Combining matchers

When you use more than one matcher in one rule, both conditions must match for the rule to apply.

``` yaml
match:
    Identifier\ContentType: [article, blog_post]
    Identifier\Section: news
```

In the example above, content that is either an article or a blog post is matched,
but it must be in the "News" Section.
