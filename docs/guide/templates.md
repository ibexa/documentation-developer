# Templates

## Templating basics

To apply a template to any part of your webpage, you need three (optionally four) elements:

1. An entry in the configuration that defines which template should be used in what situation
1. The template file itself
1. Assets used by the template (for example, CSS or JS files, images, etc.)
1. *Optionally:* A custom controller used when the template is read which allows you more detailed control over the page.

Each template must be mentioned in a configuration file together with a definition of the situation in which it is used. You can use the `ezplatform.yaml` file located in the `config/packages` folder, or create your own separate configuration file in that folder that will list all your templates.

!!! note

    If you create a new configuration file outside the `packages` folder, you will need to import it by including an import statement in `ezplatform.yaml`. Add the following code at the beginning of `ezplatform.yaml`:

    ``` yaml
    imports:
        - { resource: ../<your_file_name>.yaml }
    ```

!!! tip

    If you are using the recommended .yaml files for configuration, here are the basic rules for this format:

    - The configuration is based on pairs of a key and its value, separated by a colon, presented in the following form: `key: value`. 
    - The value of the key may contain further keys, with their values containing further keys, and so on.
    - This hierarchy is marked using indentation – each level lower in the hierarchy must be indented in comparison with its parent.

### Template configuration

A short configuration file can look like this:

``` yaml
# Sample configuration file
ezplatform:
    system:
        site_group:
            user:
                layout: pagelayout.html.twig
            content_view:
                full:
                    article:
                        template: full/article.html.twig
                        match:
                            Identifier\ContentType: [article]
                    blog_post:
                        controller: App\Controller\BlogController::showBlogPostAction
                        template: full/blog_post.html.twig
                        match:
                            Identifier\ContentType: [blog_post]
                line:
                    article:
                        template: line/article.html.twig
                        match:
                            Identifier\ContentType: [article]
```

This is what individual keys in the configuration mean:

- `ezplatform` and `system` are obligatory at the start of any configuration file which defines views.
- `site_group` defines the scope for which the configuration will be used. `site_group` is a SiteAccess group used out of the box for all front-end SiteAccesses.
See [Scope](siteaccess.md#scope) for other available keys.            
- `user` and `layout` point to the main template file that is used in any situation where no other template is defined. All other templates extend this one.
- `content_view` defines the view provider.

!!! note

    In earlier version `location_view` was used as the view provider. It has been deprecated since eZ Platform 1.x.

- `full` and `line` determine the kind of view to be used (see below).
- `article` and `blog_post` are the keys that start the configuration for one individual case of using a template. You can name these keys any way you want, and you can have as many of them as you need.
- `template` names the template to be used in this case, including the folder it is stored in (starting from `app/Resources/views`).
- `controller` defines the controller to be used in this case. Optional, if this key is absent, the default controller is used.
- `match` defines the situation in which the template will be used. There are different criteria which can be used to "match" a template to a situation, for example a Content Type, a specific Location ID, Section, etc. You can view the full list of matchers here: [View provider configuration](content_rendering.md#configuring-views-the-viewprovider). You can specify more than one matcher for any template; the matchers will be linked with an AND operator.

In the example above, three different templates are mentioned, two to be used in the full view, and one in the line view. 
Notice that two separate templates are defined for the `article` Content Type. 
They use the same matcher, but will be used in different situations – one when an Article is displayed in the full view, and one in the line view. 
Templates for each of the view types are located in different folders. 
The line template will also make use of a custom controller, while the remaining cases will employ the default one.

##### Full, line and other views

Each Content item can be rendered differently, using different templates, depending on the type of view it is displayed in.
The default, built-in views are:
 
- **full** – used when the Content item is displayed by itself, as a full page
- **line** – used when it is displayed as an item in the list, for example a listing of contents of a folder
- **embed** – used when one Content item is embedded in another, as a block
- **embed-inline** – used when a Content item is embedded inline in another block 

Other, custom view types can be created, used for example for [embedding one Content item in another](#embedding-content-items), but only these four have built-in controllers in the system.
For more details, see [View provider configuration](content_rendering.md#configuring-views-the-viewprovider).

### Template file

Templates in [[= product_name =]] are written in the Twig templating language.

!!! note "Twig templates in short"

    At its core, a Twig template is an HTML frame of the page that will be displayed. Inside this frame you define places (and manners) in which different parts of your Content items will be displayed (rendered).

    Most of a Twig template file can look like an ordinary HTML file. This is also where you can define places where Content items or their Fields will be embedded.

The configuration described above lets you select one template to be used in a given situation, but this does not mean you are limited to only one template file per case. It is possible to include other templates in the main template file. For example, you can have a single template for the footer of a page and include it in many other templates. Such templates do not need to be mentioned in the configuration .yaml file.

!!! tip

    See [Including Templates](http://symfony.com/doc/5.0/book/templating.html#including-templates) in Symfony documentation for more information on including templates.

The main template for your webpage is placed in a pagelayout.
You can define the pagelayout per SiteAccess using the `ezplatform.system.<SiteAccess>.pagelayout` setting.
This template will be used by default for those parts of the website where no other templates are defined.

A `pagelayout.html.twig` file exists already in Demo Bundles, but if you are using a clean installation, you need to create it from scratch. This file is typically located in the `templates` folder.

Any further templates will extend and modify this one, so they need to start with a line like this:

``` html+twig
{% extends "pagelayout.html.twig" %}
```

Templates can be extended using a Twig [`block`](http://twig.sensiolabs.org/doc/functions/block.html) tag. This tag lets you define a named section in the template that will be filled in by the child template. For example, you can define a "title" block in the main template. Any child template that extends it can also contain a "title" block. In this case the contents of the block from the child template will be placed inside this block in the parent template (and override what was inside this block):

``` html+twig
<!--pagelayout.html.twig-->
{# ... #}
    <body>
        {% block title %}
            <h1>Default title</h1>
        {% endblock %}
    </body>
{# ... #}
```

``` html+twig
<!--child.html.twig-->
{% extends "pagelayout.html.twig" %}
{% block title %}
    <h1>Specific title</h1>
{% endblock %}
```

In the simplified example above, when the `child.html.twig` template is used, the "title" block from it will be placed in and will override the "title" block from the main template – so "Specific title" will be displayed instead of "Default title."

!!! tip

    Alternatively, you can place templates inside one another using the [`include`](http://twig.sensiolabs.org/doc/functions/include.html)function.

    See [http://twig.sensiolabs.org/doc/templates.html\#](http://twig.sensiolabs.org/doc/templates.html) for detailed documentation on how to use Twig.

##### Embed content in templates

Now that you know how to create a general layout with Twig templates, let's take a look at the ways in which you can render content inside them.

There are several ways of placing Content items or their Fields inside a template. You can do it using one of the [Twig functions described in detail here](twig_functions_reference.md).

As an example, let's look at one of those functions: [ez\_render\_field](twig_functions_reference.md#ez_render_field). It renders one selected Field of the Content item. In its simplest form this function can look like this:

``` html+twig
{{ ez_render_field( content, 'description' ) }}
```

This renders the value of the Field with identifier "description" of the current Content item (signified by "content"). You can additionally choose a special template to be used for this particular Field:

``` html+twig
{{ ez_render_field(
       content,
       'description',
       { 'template': 'fields/description.html.twig' }
   ) }}
```

!!! note

    As you can see in the case above, templates can be created not only for whole pages, but also for individual Fields.

Another way of embedding Content items is using the `render_esi` function (which is not an eZ-specific function, but a Symfony standard). This function lets you easily select a different Content item and embed it in the current page. This can be used, for instance, if you want to list the children of a Content item in its parent.

``` html+twig
{{ render_esi(controller('ez_content::viewAction', {locationId: 33, viewType: 'line'} )) }}
```

This example renders the Content item with Location ID 33 using the line view. To do this, the function applies the `ez_content::viewAction` controller. This is the default controller for rendering content, but can be substituted here with any custom controller of your choice.

#### Assets

Asset files such as CSS stylesheets, JS scripts or image files can be defined in the templates and need to be included in the directory structure in the same way as with any other web project. Assets are placed in the `public/` folder in your installation.

Instead of linking to stylesheets or embedding images like usually, you can use the [`asset`](http://symfony.com/doc/5.0/book/templating.html#linking-to-assets) function.

#### Controller

While it is possible to template a whole website using only Twig, a custom PHP controller gives many more options of customizing the behavior of the pages.

See [Custom rendering logic](controllers.md#custom-rendering-logic) for more information.

## Rendering Rich Text

### Alignment of images

Images that have been added to Rich Text with alignment set have one of following classes: `align-left`, `align-right`, or `align-center`.

By default, these classes have no specific styling, so for the alignment to work properly, you need to add them to your styles, for example:

``` css
.align-left {
    float: left;
    padding-right: 20px;
}

.align-right {
    float: right;
    padding-left: 20px;
}

.align-center {
    text-align: center;
    padding-bottom: 10px;
}
```

## Rendering Content items

By default (without any configuration), a Content item is rendered without any template. 
By creating multiple templates and configuring them properly, you can configure the platform to render Content items differently depending on the scenario. 

### Content item Fields

A view template receives the requested Content item, holding all Fields.
In order to display the Fields' value the way you want, you can either manipulate the Field value object itself, or use a custom template.

#### Getting raw Field value

As you have access to the Content item in the template, you can use [its public methods](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/Core/Repository/Values/Content/Content.php) to access all the information you need. You can also use the `ez_field_value` helper to get the [Field's value only](twig_functions_reference.md#ez_field_value). It will return the correct language if there are several, based on language priorities.

``` html+twig
{# With the following, myFieldValue will be in the Content item's main language #}
{# It will also takes languages you provided to API on retrieval into account #}
{% set myFieldValue = content.getFieldValue( 'some_field_identifier' ) %}

{# Here myTranslatedFieldValue will be in the current language if a translation is available (read from SiteAccess configuration). If not, the Content item's main language will be used #}
{% set myTranslatedFieldValue = ez_field_value( content, 'some_field_identifier' ) %}
```

#### Rendering Content items on full page

To render a Content item on a full page, first you need to create a `templates/full/article.html.twig` template:

``` html+twig
<div>
    {# 'ez_render_field' is one of the available Twig functions.
    It will render the 'body' Field of the current 'content' #}
    {{ ez_render_field(content, 'body') }}
</div>
```

Next, you need to provide the [template configuration](#template-configuration).
You can place the config in the `config/packages/` folder in either of two places: a new configuration file or the pre-existing `ezplatform.yaml` file.
In this case you'll use the latter.

In `ezplatform.yaml`, under the `ezpublish` and `system` keys, add the following config:

``` yaml
# 'default' is the SiteAccess.
default:
    # 'content_view' indicates that you will be defining view configuration.
    content_view:
        # 'full' is the type of view to use. Defining other view types is described below.
        full:
            # Here starts the entry for our view. You can give it any name you want, as long as it is unique.
            article:
                # This is the path to the template file, relative to the 'templates' folder.
                template: full/article.html.twig
                # This identifies the situations when the template will be used.
                match:
                    # The template will be used when the Content Type of the content is 'article'.
                    Identifier\ContentType: [article]
```
Pay attention to indentation – `default` should be indented relative to `system`.
Use `match` to identify not only the Content Type, but also the scenario for using the template.
For details, see [Matchers](content_rendering.md#view-matchers).

At this point all Content items that are articles should render using the new template.
If you do not see changes, clear the cache by running: `php bin/console cache:clear`.
 
#### Using the Field Type's template block

All built-in Field Types come with [their own Twig template.](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig)
You can render any Field using this default template using the `ez_render_field()` helper.

``` html+twig
{{ ez_render_field( content, 'some_field_identifier' ) }}
```

You can use this helper to render various Content item Fields.
This, paired with the fact that each Content item can have multiple Fields and you can render them differently, offers more rendering options.

To see it in practice, extend the `templates/full/article.html.twig` template:

``` html+twig
{# This renders the content name of the article #}
<h1>{{ ez_content_name(content) }}</h1>
<div>
    {# Here you add a rendering of a different Field, 'intro' #}
    <b>{{ ez_render_field(content, 'intro') }}</b>
</div>    
<div>
    {{ ez_render_field(content, 'body') }}
</div>
```

For more details on the `ez_render_field()` helper, see [Twig functions reference guide](twig_functions_reference.md#ez_render_field).

You can also use other [Twig functions](twig_functions_reference.md), for example [`ez_field_value`](twig_functions_reference.md#ez_field_value), which renders the value of the Field without a template.

!!! tip

    As this makes use of reusable templates, **using `ez_render_field()` is the recommended way and is to be considered the best practice**.

### Content name

The **name** of a Content item is its generic "title", generated by the repository based on the Content Type's naming pattern. It often takes the form of a normalized value of the first field, but might be a concatenation of several fields. There are 2 different ways to access this special property:

- Through the name property of ContentInfo (not translated).
- Through VersionInfo with the TranslationHelper (translated).

#### Translated name

The *translated name* is held in a `VersionInfo` object, in the `names` property which consists of a hash indexed by locale. You can easily retrieve it in the right language via the `TranslationHelper` service.

``` html+twig
{# Languages provided to API will be taken into account so you can do this: #}
<h2>Translated Content name: {{ content.name }}</h2>

{# In earlier versions the same is available using Twig translation helper ez_content_name() #}
<h2>Translated Content name: {{ ez_content_name( content ) }}</h2>
<h3>Also works from ContentInfo: {{ ez_content_name( content.contentInfo ) }}</h3>
```

The helper will by default follow the prioritized languages order. If there is no translation for your prioritized languages, the helper will always return the name in the main language.

You can also **force a locale** in a second argument:

``` html+twig
{# Force fre-FR locale. #}
<h2>{{ ez_content_name( content, 'fre-FR' ) }}</h2>
```

!!! note "Name property in ContentInfo"

    This property is the actual content name, but **in the main language only** (so it is not translated).

    ``` html+twig
    <h2>Content name: {{ content.contentInfo.name }}</h2>
    ```

    In PHP that would be:

    ``` php
    $contentName = $content->getContentInfo->getName();
    ```

    So make sure to use `$content->getName() or $versionInfo->getName()`, which takes translations into account.

### Embedding images

The Rich Text Field allows you to embed other Content items within the Field.

Content items that are identified as images will be rendered in the Rich Text Field using a dedicated template.

You can determine which Content Types will be treated as images and rendered using this template in the `ezplatform.content_view.image_embed_content_types_identifiers` parameter. By default it is set to cover the Image Content Type, but you can add other types that you want to be treated as images, for example:

``` yaml
parameters:
    ezplatform.content_view.image_embed_content_types_identifiers: [image, photo, banner]
```

The template that is used when rendering embedded images can be set in the `ezplatform.default_view_templates.content.embed_image` container parameter:

``` yaml
parameters:
    ezplatform.default_view_templates.content.embed_image: content/view/embed/image.html.twig
```

### Adding Links

#### Links to other Locations

Linking to other Locations is done with the `ez_path()` Twig helper (or `ez_url()` if you want to generate absolute URLs). When you pass it the Location object, `ez_path()` will generate the URL alias.

``` html+twig
{# Assuming "location" variable is a valid eZ\Publish\API\Repository\Values\Content\Location object #}
<a href="{{ ez_path( location ) }}">Some link to a Location</a>
```

If you don't have the Location object, but only its ID, you can generate the URL alias the following way:

``` html+twig
<a href="{{ path( "ez_urlalias", {"locationId": 123} ) }}">Some link to a Location, with its ID only</a>
```

!!! tip

    Instead of pointing to a specific Content item by its Location ID, you can also use here a variable.
    For more details, see [this example in the Demo Bundle.](https://github.com/ezsystems/ezplatform-demo/blob/e15b93ade4b8c1f9084c5adac51239d239f9f7d8/app/Resources/views/full/blog.html.twig#L25)


You can also use the Content item's ID. In that case the generated link will point to the Content item's main Location.

``` html+twig
<a href="{{ path( "ez_urlalias", {"contentId": 456} ) }}">Some link from a contentId</a>
```

!!! note "Under the hood"

    In the back end, `ez_path()` uses the Router to generate links.

    This makes it also easy to generate links from PHP, via the `router` service.

See also: [Cross-SiteAccess links](siteaccess.md#cross-siteaccess-links)

### Embedding Content items

To render an embedded Content from a Twig template, you can do one of the following things:

- use [`ez_render` Twig helper](#using-ez_render-twig-helpers) 
- do a [subrequest with the `ez_content` controller](#using-the-ez_content-controller)

#### Using `ez_render` Twig helpers

You can use the `ez_render()`, `ez_render_content()`, and `ez_render_location()` functions
to render the provided Content item.
It is rendered by default with the `embed` view.

`ez_render_content()` and `ez_render_location()` take the Content object and the Location object
as parameters, respectively.

You can also use `ez_render()`, which automatically selects and uses either of those functions depending on the provided parameter.

``` html+twig
{{ ez_render(content) }}
{{ ez_render(location) }}

{{ ez_render_content(content) }}
{{ ez_render_location(location) }}
```

You can also specify one of the available [rendering methods](twig_functions_reference.md#rendering-methods):

``` html+twig
{{ ez_render(location, {method: "esi"}) }}
```

To change the [view type](#full-line-and-other-views), provide it in an optional parameter:

``` html+twig
{{ ez_render(location, {method: "esi", viewType: "line"}) }}
```

#### Using the `ez_content` controller

This controller is exactly the same as [the ViewController presented above](content_rendering.md#the-viewcontroller). It has one main `viewAction` that renders a Content item.

You can use this controller from templates with the following syntax:

``` html+twig
{{ render(controller("ez_content::viewAction", {"contentId": 123, "viewType": "line"})) }}
```

The example above renders the Content item whose ID is **123** with the view type **line**.

Referencing the `ez_content` controller follows the syntax of *controllers as a service*, [as explained in Symfony documentation](http://symfony.com/doc/5.0/cookbook/controller/service.html).

##### Available arguments

As with any controller, you can pass arguments to `ez_content::viewAction` to fit your needs.
You must provide `contentId` (and, optionally, `locationId`) for the action to work.

|Name|Description|Type|Default value|
|---|---|---|---|
|`contentId`|ID of the Content item you want to render. Can be used together with `locationId`, if the Location belongs to that Content item.|integer|Location's Content item, if defined|
|`locationId`|ID of the Location you want to render. Can be used together with `contentId`, if the Location belongs to that Content item.|integer|Content item's main location, if defined|
|`viewType`|The view type you want to render your Content item/Location in. Will be used by the ViewManager to select a corresponding template, according to defined rules. </br>Example: full, line, my_custom_view, etc.|string|full|
|`layout`|Indicates if the sub-view needs to use the main layout (see [available variables in a view template](content_rendering.md#available-variables))|boolean|false|
|`params`|Hash of variables you want to inject to sub-template, key being the exposed variable name.|hash|empty hash|

For example:

``` html+twig
{{ render(
      controller(
          "ez_content::viewAction",
          {
              "contentId": 123,
              "viewType": "line",
              "params": { "some_variable": "some_value" }
          }
      )
) }}
```

### Listing Content item children

For details on listing children of a Content item, for example all content contained in a folder, see [Displaying children of a Content item](displaying_children_of_a_content_item.md).

### Non-content related Query Types

If you use [Query Types](controllers.md#query-controller) that do not make use of the current content or Location
(e.g. rendering a list of latest blog posts, or a menu),
you can render them in your templates using `ez_render_<type>_query` (e.g. `ez_render_content_query`) Twig functions
or their ESI equivalents: `ez_render_content_query_esi`.

``` html+twig
{{ ez_render_content_query({
    'query': {
        'query_type': 'LatestContent',
        'assign_results_to': 'latest_articles'
    },
    'template': 'latest/latest.html.twig',
}) }}
```

You can also set pagination using the Twig function:

``` html+twig
{{ ez_render_location_query({
    'query': {
        'query_type': 'LatestContent',
        'assign_results_to': 'latest_articles'
    },
    'pagination': {
        'enabled': true,
        'limit': 5,
        'page_param': 'page'
    },
    'template': 'latest/latest.html.twig',
}) }}
```

Using this function does not require adding anything to your content view configuration.

#### Rendering and cache

##### ESI

Just like for regular Symfony controllers, you can take advantage of [ESI](https://symfony.com/doc/5.0/http_cache/esi.html) and use different cache levels:

``` html+twig
{{ render_esi(controller("ez_content::viewAction", {"contentId": 123, "viewType": "line"})) }}
```

Only scalar variables (not objects) can be sent via `render_esi`.

## Rendering search results

You can set a template to be used for search results under the `search_view` key
and set the pagination limit under `search.pagination`:

``` yaml
system:
    <siteaccess>:
        search_view:
            full:
                search:
                    template: 'custom_search_template.html.twig'
                    match: true
        search:
            pagination:
                limit: 12
```

## Rendering in preview

When previewing content in the back office, the draft view is rendered using the [PreviewController](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/Core/MVC/Symfony/Controller/Content/PreviewController.php).

The first draft of a yet unpublished Content item does not have a Location, because Locations are only assigned when content is published.
To enable rendering in such cases, the PreviewController [creates a temporary virtual Location](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/Core/Helper/PreviewLocationProvider.php#L65).
This Location has some of the properties of the future Location, such as the parent Location ID.
However, it does not fully replace a normal Location.

If the rendering template refers directly to the Location ID of the content, an error will occur.
To avoid such situations, you can check if the Location is virtual using the `location.isDraft` flag in Twig templates, for example:

``` html+twig
{% if not location.isDraft %}
    <a href="{{ ez_path(location) }}">{{ ez_content_name(content) }}</a>
{% endif %}
```

## Exposing additional variables

### Contextual Twig variables

You can create custom Twig variables for use in templates.

The variables can be set per SiteAccess, or per content view.

``` yaml
ezplatform:
    system:
        <siteaccess>:
            twig_variables:
                my_custom_variable: variable_value
```

You can access this variable directly in all templates in that SiteAccess:

``` html+twig
{{ my_custom_variable }}
```

Variables set per content view will only be available when this view is matched:

``` yaml
ezplatform:
    system:
        <siteaccess>:
            full:
                article:
                    template: 'full/article.html.twig'
                    params:
                        my_custom_variable: variable_value
                    match:
                        Identifier\ContentType: article
```

Custom variables can be nested.
You can use Expression language to access values such as:

``` yaml
article:
    template: 'full/article.html.twig'
    params:
        my_custom_variable:
            content_type_name: "@=content.contentType.identifier"
```

``` html+twig
{{ my_custom_variable.content_type_name }}
```

!!! caution

    It is possible to overwrite an existing parameter, so it is good practice to avoid existing
    parameter names such as `content` or `location`.

    Use `{{ dump() }}` to view the list of all parameters available in the given template.

### Dynamic variable injection

#### Custom variable providers

In your templates you can use Twig variables coming from custom variable providers.

``` php
<?php
declare(strict_types=1);

namespace App\Provider;

use \eZ\Publish\Core\MVC\Symfony\View\View;
use eZ\Publish\SPI\MVC\View\VariableProvider;

class MyVariableProvider implements VariableProvider
{
    public function getTwigVariables(View $view, array $options = []): object
    {
        return (object)[
            'my_variable' => 'Value of ' . $this->getIdentifier(),
        ];
    }

    public function getIdentifier(): string
    {
        return 'my_variable_provider';
    }
}
```

Register the provider as a service:

``` yaml
App\Provider\MyVariableProvider:
    autoconfigure: true
```

``` yaml
article:
    template: 'full/article.html.twig'
    params:
        provided_variable: "@=twig_variable_provider('my_variable_provider').my_variable"
```

#### Injecting variables through event

You can dynamically inject variables in content view templates by listening to the `ezpublish.pre_content_view` event.

The event listener method receives an [`eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent`](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/Core/MVC/Symfony/Event/PreContentViewEvent.php) object.

The following example injects `my_variable` and `my_array` variables in all content view templates.

``` php
<?php
namespace App\EventListener;

use eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent;

class PreContentViewListener
{
    public function onPreContentView(PreContentViewEvent $event)
    {
        // Get content view object and inject whatever you need.
        // You may also add custom business logic here.
        $contentView = $event->getContentView();
        $contentView->addParameters(
            [
                 'my_variable'  => 'my_value',
                 'my_array'     => [ 'value1', 'value2', 'value3' ]
            ]
        );
    }
}
```

Service configuration:

``` yaml
services:
    App\EventListener\PreContentViewListener:
        tags:
            - {name: kernel.event_listener, event: ezpublish.pre_content_view, method: onPreContentView}
```
