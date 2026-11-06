# Template configuration

Template configuration defines which templates are used for which content and in what cases.

You configure how templates are used under the `ibexa.system.<scope>.content_view` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files).

The following example configuration defines template usage for several cases:

```yaml
ibexa:
    system:
        site_group:
            page_layout: '@ibexadesign/pagelayout.html.twig'
            content_view:
                full:
                    article:
                        template: '@ibexadesign/full/article.html.twig'
                        match:
                            Identifier\ContentType: article
                    blog_post:
                        template: '@ibexadesign/full/blog_post.html.twig'
                        controller: App\Controller\BlogController::showBlogPostAction
                        match:
                            Identifier\ContentType: [blog_post]
                    terms:
                        template: '@ibexadesign/full/terms_and_conditions.html.twig'
                        match:
                            Id\Content: 144
                line:
                    article:
                        template: '@ibexadesign/line/article.html.twig'
                        match:
                            Identifier\ContentType: [article]
```

## Scope

The content view configuration must be placed under `ibexa.system.<scope>`.

Scope defines the [SiteAccesses](../../../multisite/multisite/index.md) for which the configuration is valid. It may be a SiteAccess, a SiteAccess group, or one of the [generic configuration scopes](../../../multisite/multisite_configuration/index.md#scope).

## Page layout

`page_layout` defines the general layout of the whole site. Other templates can [extend the page layout](#page-layout).

```yaml
            page_layout: '@ibexadesign/pagelayout.html.twig'
```

## View types

The `ibexa.system.<scope>.content_view` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files) defines rules for rendering content. Rules are grouped per *view type*.

```yaml
ibexa:
    system:
        site_group:
            page_layout: '@ibexadesign/pagelayout.html.twig'
            content_view:
                full:
```

The default, built-in views are:

- `full` - used when the content item is displayed by itself, as a full page
- `line` - used when content is displayed as an item in a list, for example a list of the contents of a folder
- `text_linked` - used for a text section which is a link
- `embed` - used when one content item is embedded in another, as a block
- `embed-inline` - used when a content item is embedded inline in another
- `asset_image` - used when an image asset is embedded in another content item

The built-in views have built-in default templates. You can define any other custom views. For each custom view, you must define a custom template.

> **Tip: Direct path to previewing view types**
>
> You can preview content in a specific view type by using a direct path to the built-in view controller:
>
> `<yourdomain>/view/content/<contentId>/<viewType>/true/<locationId>`
>
> For example:
>
> `<yourdomain>/view/content/55/embed/true/57`

## View rules and matching

Each rule must have a name unique per view type. For each rule you must define the matching conditions. The `match` key can contain one or more [view matchers](../view_matcher_reference/index.md), including [custom ones](../create_custom_view_matcher/index.md).

```yaml
                    blog_post:
                        template: '@ibexadesign/full/blog_post.html.twig'
                        controller: App\Controller\BlogController::showBlogPostAction
                        match:
                            Identifier\ContentType: [blog_post]
```

`template` indicates which template to use.

`controller` indicates which [controller](../../queries_and_controllers/controllers/index.md) and which method to use when rendering the content. You can use it together with the `template` key, or without it.

`params` can provide additional parameters to the content view. Use them, for example, with [Query types](../../queries_and_controllers/content_queries/index.md#query-types) or to provide [custom Twig variables](../templates/index.md#custom-template-variables) to the template.

### Combining matchers

When you use more than one matcher in one rule, both conditions must match for the rule to apply.

```yaml
match:
    Identifier\ContentType: [article, blog_post]
    Identifier\Section: news
```

In the example above, content which is either an article or a blog post is matched, but it must be in the "News" Section.

### Matching every content item

When you use no matcher in a rule, this rule always match. Several values are available to declare no matcher:

```yaml
match: ~
match: true
match: []
```

Such rules can be found in the [default template configuration](https://github.com/ibexa/core/blob/4.5/src/bundle/Core/Resources/config/default_settings.yml#L47).

> **Tip: Tip**
>
> For example, you can ensure that any content item lacking a dedicated template isn't displayed in `full` view but is instead sent to a custom controller.
>
> ```yaml
> site_group:
>     content_view:
>         full:
>             # Rules for content types and specific content items meant to be displayed in full view:
>             # …
>             # Rule for other content items not meant to be displayed in full view:
>             no_full_view:
>                 controller: App\Controller\ViewController::noFullViewAction
>                 template: '@ibexadesign/full/no_full_view.html.twig'
>                 match: ~
> ```
>
> This custom controller can also set the response status code to 404 using the following code: `$view->setResponse((new Response())->setStatusCode(404));`, and fetch reverse relations to provide suggestions on the error page.
