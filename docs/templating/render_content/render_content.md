---
description: Customize rendering of Content items on the site front end by using templates with proper content view configuration.
---

# Render content

Content is rendered automatically by using default, basic templates.
To render content with a custom template, you create a template file
and inform the system, through configuration, when to use this template.

You do it by using the [content view configuration](template_configuration.md).

For example, to apply a custom template to all articles, use the following configuration:

``` yaml
[[= include_file('code_samples/front/render_content/config/packages/views.yaml', 4, 7) =]][[= include_file('code_samples/front/render_content/config/packages/views.yaml', 9, 15) =]]
```

This configuration defines a `full` view for all Content items that fulfill the conditions in `match`.
`match` indicates that all Content items with the Content Type `article` should use this configuration.
The indicated `template` is `@ibexadesign/full/article.html.twig`.

!!! tip "Designs"

    This configuration uses the [design engine](design_engine.md), as indicated by the `@ibexadesign` in the template path.
    In this example, the theme used by the design is `my_theme`.
    
    Using the design engine is recommended, but you can also set direct paths to templates, for example:
    
    ``` yaml
    template: 'full/article.html.twig'
    ```
    
    You must then ensure that the `templates/full` folder contains the template file.

The configuration requires that you add the `article.html.twig` template file to `templates/themes/<theme_name>/full`,
in this example, `templates/themes/my_theme/full`.

``` html+twig
[[= include_file('code_samples/front/render_content/templates/themes/my_theme/full/article.html.twig', 3, 18) =]]
```

## Get content information

To render general content information, such as content name,
use the [`ibexa_content_name()`](content_twig_functions.md#ibexa_content_name) Twig function.

Content name is based on the [content name pattern](content_model.md#content-name-pattern) of the Content Type.

``` html+twig
[[= include_file('code_samples/front/render_content/templates/themes/my_theme/full/article.html.twig', 3, 4) =]]
```

You can get general information about the content, Location and view parameters by using the [available variables](templates.md#template-variables).
For example, to get the publication date of the current Content item, use:

``` html+twig
[[= include_file('code_samples/front/render_content/templates/themes/my_theme/full/article.html.twig', 5, 6) =]]
```

[[= include_file('docs/snippets/rendering_dump_variable.md') =]]

## Render Fields

You can render a single Field of a Content item by using the [`ibexa_render_field()`](field_twig_functions.md#ibexa_render_field) Twig function.
It takes the Content item and the identifier of the Field as arguments:

``` html+twig
[[= include_file('code_samples/front/render_content/templates/themes/my_theme/full/article.html.twig', 7, 8) =]]
```

You can pass additional arguments to this function, for example, an HTML class:

``` html+twig
[[= include_file('code_samples/front/render_content/templates/themes/my_theme/full/article.html.twig', 9, 14) =]]
```

### Field templates

You can use a custom Field template by passing the template as an argument to [`ibexa_render_field()`](field_twig_functions.md#ibexa_render_field):

``` html+twig
[[= include_file('code_samples/front/render_content/templates/themes/my_theme/full/article.html.twig', 15, 18) =]]
```

In this case you must place the `author.html.twig` template in `templates/themes/<theme_name>/fields`,
for example `templates/themes/my_theme/fields`.

``` html+twig
[[= include_file('code_samples/front/render_content/templates/themes/my_theme/fields/author.html.twig') =]]
```

The Field template must be placed in a block that corresponds to the Field Type identifier,
in this case `{% block ezauthor_field %}`.

!!! tip "Template blocks"

    Twig blocks are used to include templates in one another.
    For more information about relationships between templates, see [Connecting templates](templates.md#connecting-templates).
