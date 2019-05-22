# Displaying content with simple templates

This page describes basic steps needed to render content on a page.

## Rendering a full page

By default (without any configuration), a Content item will be rendered without any template. In your config you can tell the app to render it using different templates depending on the situation. Templates are written in the Twig templating language.

Let's create a very simple template, called `article.html.twig`, that you will use to render an article:

``` html+twig
<div>
    {# 'ez_render_field' is one of the available Twig functions.
    It will render the 'body' Field of the current 'content' #}
    {{ ez_render_field(content, 'body') }}
</div>
```

Place this file in the `templates` folder.

Now you need a config that will decide when this template is used.

You can place the config in the `config` folder in either of two places: a separate file or the preexisting `ezplatform.yaml`. In this case you'll use the latter.

In `ezplatform.yml` under the `ezpublish` and `system` keys add the following config (pay attention to indentation. `default` should be indented relative to `system`):

``` yaml
# 'default' is the SiteAccess.
default:
    # 'content_view' indicates that you will be defining view configuration.
    content_view:
        # 'full' is the type of view to use. Defining other view types is described below.
        full:
            # Here starts the entry for our view. You can give it any name you want, as long as it is unique.
            article:
                # This is the path to the template file, relative to the 'app/Resources/views' folder.
                template: full/article.html.twig
                # This identifies the situations when the template will be used.
                match:
                    # The template will be used when the Content Type of the content is 'article'.
                    Identifier\ContentType: [article]
```

In the `match` section you can use different ways to identify the situation where the template will be used, not only the Content Type, see [Matchers](../guide/content_rendering.md#view-matchers).

At this point all Articles should render using the new template. If you do not see changes, clear the cache (`php bin/console cache:clear`).

## Rendering page elements

In the example above you used the `ez_render_field` Twig function to render the 'body' Field of the content item. Each Content item can have multiple fields and you can render them in different ways in the template. Other Twig functions let you access different properties of your content. To see an example, let's extend the template a bit:

``` html+twig
{# This renders the Content name of the article #}
<h1>{{ ez_content_name(content) }}</h1>
<div>
    {# Here you add a rendering of a different Field, 'intro' #}
    <b>{{ ez_render_field(content, 'intro') }}</b>
</div>    
<div>
    {{ ez_render_field(content, 'body') }}
</div>
```

You can also make use of other [Twig functions](../guide/twig_functions_reference.md), for example [`ez_field_value`](../guide/twig_functions_reference.md#ez_field_value), which renders the value of the Field without a template.

## Different views

Besides the `full` view type you can create many other view types. They can be used for example when rendering children of a folder or when embedding one Content item in another. See [Embedding Content items](../guide/templates.md#embedding-content-items).

## Listing children

To see how to list children of a Content item, for example all content contained in a folder, see [Displaying children of a Content item](displaying_children_of_a_content_item.md)

## Adding links

To add links to your templates you use the `ez_urlalias` path. To see how it works, let's add one more line to the `article.html.twig` template:

``` html+twig
<h1>{{ ez_content_name(content) }}</h1>
{# The link points to the content in Location ID 2, which is the Home Content item #}
<a href="{{ path('ez_urlalias', {locationId: 2}) }}">Back</a>
<div>
{# ... #}
```

Instead of pointing to a specific Content item by its Location ID you can also use here a variable, see [this example in the Demo Bundle](https://github.com/ezsystems/ezplatform-demo/blob/e15b93ade4b8c1f9084c5adac51239d239f9f7d8/app/Resources/views/full/blog.html.twig#L25).
