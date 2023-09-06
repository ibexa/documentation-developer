---
description: Render Content item from PHP and get the resulting HTML as a string.
---

# Render content in PHP

While in PHP, you may need to render the view of a Content item (for further treatment like PDF conversion, because you're not in an HTML context, etc.).

!!! caution

    Avoid using this in a controller as much as possible.
    You can access a view directly via the route `/view/content/{contentId}/{viewType}[/{location}]`. For example, on a fresh installation, you can access `/view/content/52/line` which will return a small piece of HTML with a link to the content that could be used in Ajax.
    If you need a controller to have additional information available in the template or to manipulate the `Response` object before returning it, define the controller in a [view configuration](template_configuration.md) as shown in [Controllers](controllers.md).

The following example is a command outputting the render of a content for a view type in the terminal.
It works only if the view doesn't refer to the HTTP request.
It is compatibile with the default installation views such as `line` or `embed`.
To go further with this example, you could add some dedicated views not outputting HTML but plain text, [Symfony command styled text]([[= symfony_doc =]]/console/coloring.html), Markdown, etc.
It doesn't work with a `full` view when the [Page layout](template_configuration.md#page-layout) uses `app.request.locale`, as is the case in the out-of-the-box configuration..

Append to `config/services.yaml` the command as a service:

```yaml
services:
    #…
    App\Command\ViewCommand:
        tags:
            - { name: 'console.command', command: 'app:view' }
```

Create the command in `src/Command/ViewCommand.php`:

```php hl_lines="59-63"
[[= include_file('code_samples/front/render_content_in_php/src/Command/ViewCommand.php') =]]
```

!!! caution

    As `Ibexa\Core\MVC\Symfony\View\Builder\ContentViewBuilder` and `Ibexa\Core\MVC\Symfony\View\Renderer\TemplateRenderer` are not part of the public API's `Ibexa\Contracts` namespace, they might change without notice.

Use the command with some simple views:

```bash
php bin/console app:view --content-id=52
php bin/console app:view --location-id=2 --view-type=embed
```
