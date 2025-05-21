---
description: Render content item from PHP and get the resulting HTML as a string.
---

# Render content in PHP

While in PHP, you may need to render the view of a content item (for example, for further treatment like PDF conversion, or because you're not in an HTML context).

!!! caution

    Avoid using PHP rendering in a controller as much as possible.
    You can access a view directly through the route `/view/content/{contentId}/{viewType}[/{location}]`.
    For example, on a fresh installation, you can access `/view/content/52/line` which returns a small piece of HTML with a link to the content that could be used in Ajax.
    If you need a controller to have additional information available in the template or to customize the `Response` object, define the controller in a [view configuration](template_configuration.md) as shown in [Controllers](controllers.md), enhance the View object and return it.

The following example is a command outputting the render of a content for a view type in the terminal.
It works only if the view doesn't refer to the HTTP request.
It's compatible with the default installation views such as `line` or `embed`.
To go further with this example, you could add some dedicated views not outputting HTML but, for example, plain text, [Symfony command styled text]([[= symfony_doc =]]/console/coloring.html) or Markdown.
It doesn't work with a `full` view when the [page layout](template_configuration.md#page-layout) uses `app.request`, such as the out-of-the-box template.

Create the command in `src/Command/ViewCommand.php`:

```php hl_lines="57-61"
[[= include_file('code_samples/front/render_content_in_php/src/Command/ViewCommand.php') =]]
```

!!! caution

    As `Ibexa\Core\MVC\Symfony\View\Builder\ContentViewBuilder` and `Ibexa\Core\MVC\Symfony\View\Renderer\TemplateRenderer` aren't part of the public PHP API's `Ibexa\Contracts` namespace, they might change without notice.

Use the command with some views:

```bash
php bin/console app:view --content-id=52
php bin/console app:view --location-id=2 --view-type=embed
```
