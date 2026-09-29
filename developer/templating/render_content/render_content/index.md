# Render content

Customize rendering of content items on the site front end by using templates with proper content view configuration.

Content is rendered automatically by using default, basic templates. To render content with a custom template, you create a template file and inform the system, through configuration, when to use this template.

You do it by using the [content view configuration](../../templates/template_configuration/index.md).

For example, to apply a custom template to all articles, add the following [configuration](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa:
    system:
        site_group:
            content_view:
                full:
                    article:
                        template: '@ibexadesign/full/article.html.twig'
                        match:
                            Identifier\ContentType: article
```

This configuration defines a `full` view for all content items that fulfill the conditions in `match`. `match` indicates that all content items with the content type `article` should use this configuration. The indicated `template` is `@ibexadesign/full/article.html.twig`.

> **Tip: Designs**
>
> This configuration uses the [design engine](../../design_engine/design_engine/index.md), as indicated by the `@ibexadesign` in the template path. In this example, the theme used by the design is `my_theme`.
>
> Using the design engine is recommended, but you can also set direct paths to templates, for example:
>
> ```yaml
> template: 'full/article.html.twig'
> ```
>
> You must then ensure that the `templates/full` folder contains the template file.

The configuration requires that you add the `article.html.twig` template file to `templates/themes/<theme_name>/full`, in this example, `templates/themes/my_theme/full`.

```html+twig
<h1>{{ ibexa_content_name(content) }}</h1>

{{ content.contentInfo.publishedDate|ibexa_full_datetime }}

{{ ibexa_render_field(content, 'intro') }}

{{ ibexa_render_field(content, 'body', {
    'attr': {
        class: 'article-body'
    }
}) }}

{{ ibexa_render_field(content, 'author', {
    'template': '@ibexadesign/fields/author.html.twig'
}) }}
```

## Get content information

To render general content information, such as content name, use the [`ibexa_content_name()`](../../twig_function_reference/content_twig_functions/index.md#ibexa_content_name) Twig function.

Content name is based on the [content name pattern](../../../administration/content_organization/content_types/index.md#content-type-metadata) of the content type.

```html+twig
<h1>{{ ibexa_content_name(content) }}</h1>
```

You can get general information about the content, location and view parameters by using the [available variables](../../templates/templates/index.md#template-variables). For example, to get the publication date of the current content item, use:

```html+twig
{{ content.contentInfo.publishedDate|ibexa_full_datetime }}
```

> **Tip: Tip**
>
> For development purposes, you can list all available variables, or a single variable, and their values, by using the `dump()` Twig function:
>
> ```html+twig
> {{ dump() }}
> {{ dump(content) }}
> ```

## Render fields

You can render a single field of a content item by using the [`ibexa_render_field()`](../../twig_function_reference/field_twig_functions/index.md#ibexa_render_field) Twig function. It takes the content item and the identifier of the Field as arguments:

```html+twig
{{ ibexa_render_field(content, 'intro') }}
```

You can pass additional arguments to this function, for example, an HTML class:

```html+twig
{{ ibexa_render_field(content, 'body', {
    'attr': {
        class: 'article-body'
    }
}) }}
```

### Field templates

You can use a custom Field template by passing the template as an argument to [`ibexa_render_field()`](../../twig_function_reference/field_twig_functions/index.md#ibexa_render_field):

```html+twig
{{ ibexa_render_field(content, 'author', {
    'template': '@ibexadesign/fields/author.html.twig'
}) }}
```

In this case you must place the `author.html.twig` template in `templates/themes/<theme_name>/fields`, for example `templates/themes/my_theme/fields`.

```html+twig
{% block ibexa_author_field %}
{% if field.value.authors|length() > 0 %}
    {% for author in field.value.authors %}
        <span class="author">{{ author.name }}</span>
    {% endfor %}
{% endif %}
{% endblock %}
```

The field template must be placed in a block that corresponds to the field type identifier, in this case `{% block ezauthor_field %}`.

> **Tip: Template blocks**
>
> Twig blocks are used to include templates in one another. For more information about relationships between templates, see [Connecting templates](../../templates/templates/index.md#connecting-templates).
