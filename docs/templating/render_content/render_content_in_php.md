---
description: Render the content from PHP and get the HTML as a string.
---

# Render content in PHP

While in PHP, you may need to render the view of a Content item for further treatment.

The following example is a command outputting the render of a content for a view type in the terminal.
It works only if the view doesn't refer to the HTTP request.
It works with views like the `line` or `embed` ones from default installation.
For this example, there could be some dedicated views not outputting HTML but plain text, [Symfony command styled text](https://symfony.com/doc/5.4/console/coloring.html), Markdown, etc.
It doesn't work with a `full` view if the pagelayout is using `app.request.locale`.

Append to `config/services.yaml` the command as a service:

```yaml
services:
    #…
    App\Command\ViewCommand:
        tags:
            - { name: 'console.command', command: 'app:view' }
```

Create the command in `src/Command/ViewCommand.php`:

```php hl_lines="57-61"
[[= include_file('code_samples/front/render_content_in_php/src/Command/ViewCommand.php') =]]
```

Use the command with some simple views:

```bash
php bin/console app:view --content-id=52
php bin/console app:view --location-id=2 --view-type=embed
```

!!! caution

    Avoid using this in a controller as much as possible.
    You can access directly to a view via the route /view/content/{contentId}/{viewType}[/{location}]. For example, on a fresh installation, you can access `/view/content/52/line which will return a small piece of HTML with a link to the content that could be used in Ajax.
    If you need a controller (to have additional information available in the template, or to manipulate the `Response` object before returning it), a controller defined in a [view configuration](template_configuration.md) as shown in [Controllers](controllers.md) is a better practice.
