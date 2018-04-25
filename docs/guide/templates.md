# Templates

## Templating basics

To apply a template to any part of your webpage, you need three (optionally four) elements:

1. An entry in the configuration that defines which template should be used in what situation
1. The template file itself
1. Assets used by the template (for example, CSS or JS files, images, etc.)
1. (optional) A custom controller used when the template is read which allows you more detailed control over the page.

Each template must be mentioned in a configuration file together with a definition of the situation in which it is used. You can use the `ezplatform.yml` file located in the `app/config/` folder, or create your own separate configuration file in that folder that will list all your templates.

!!! note

    If you decide to create a new configuration file, you will need to import it by including an import statement in `ezplatform.yml`. Add the following code at the beginning of `ezplatform.yml`:

    ``` yaml
    imports:
        - { resource: <your_file_name>.yml }
    ```

!!! tip

    If you are using the recommended .yml files for configuration, here are the basic rules for this format:

    The configuration is based on pairs of a key and its value, separated by a colon, presented in the following form: key: value. The value of the key may contain further keys, with their values containing further keys, and so on. This hierarchy is marked using indentation – each level lower in the hierarchy must be indented in comparison with its parent.

A short configuration file can look like this:

``` yaml
# Sample configuration file
ezpublish:
    system:
        default:
            user:
                layout: pagelayout.html.twig
            content_view:
                full:
                    article:
                        template: full\article.html.twig
                        match:
                            Identifier\ContentType: [article]
                    blog_post:
                        controller: app.controller.blog:showBlogPostAction
                        template: full\blog_post.html.twig
                        match:
                            Identifier\ContentType: [blog_post]
                line:
                    article:
                        template: line\article.html.twig
                        match:
                            Identifier\ContentType: [article]
```

This is what individual keys in the configuration mean:

- `ezpublish` and `system` are obligatory at the start of any configuration file which defines views.
- `default` defines the SiteAccess for which the configuration will be used. "default", as the name suggests, determines what views are used when no other configuration is chosen. You can also have separate keys defining views for other SiteAccesses.
- `user` and `layout` point to the main template file that is used in any situation where no other template is defined. All other templates extend this one. See [below](#page-layout) for more information.
- `content_view` defines the view provider.

!!! note

    In earlier version `location_view` was used as the view provider. It has been deprecated since eZ Platform 1.x.

- `full` and `line` determine the kind of view to be used (see below).
- `article` and `blog_post` are the keys that start the configuration for one individual case of using a template. You can name these keys any way you want, and you can have as many of them as you need.
- `template` names the template to be used in this case, including the folder it is stored in (starting from `app/Resources/views`).
- `controller` defines the controller to be used in this case. Optional, if this key is absent, the default controller is used.
- `match` defines the situation in which the template will be used. There are different criteria which can be used to "match" a template to a situation, for example a Content Type, a specific Location ID, Section, etc. You can view the full list of matchers here: [View provider configuration](content_rendering#view-provider-configuration). You can specify more than one matcher for any template; the matchers will be linked with an AND operator.

In the example above, three different templates are mentioned, two to be used in full view, and one in line view. Notice that two separate templates are defined for the "article" Content Type. They use the same matcher, but will be used in different situations – one when an Article is displayed in full view, and one in line view. Their templates are located in different folders. The line template will also make use of a custom controller, while the remaining cases will employ the default one.

##### Full, line and other views

Each Content item can be rendered differently, using different templates, depending on the type of view it is displayed in. The default, built-in views are **full** (used when the Content item is displayed by itself, as a full page), **line** (used when it is displayed as an item in the list, for example a listing of contents of a folder), and **embed** (used when one Content item is embedded in another). Other, custom view types can be created, but only these three have built-in controllers in the system.

See [View provider configuration](content_rendering#view-provider-configuration) for more details.

### Template file

Templates in eZ Platform are written in the Twig templating language.

!!! note "Twig templates in short"

    At its core, a Twig template is an HTML frame of the page that will be displayed. Inside this frame you define places (and manners) in which different parts of your Content items will be displayed (rendered).

    Most of a Twig template file can look like an ordinary HTML file. This is also where you can define places where Content items or their fields will be embedded.

The configuration described above lets you select one template to be used in a given situation, but this does not mean you are limited to only one file per case. It is possible to include other templates in the main template file. For example, you can have a single template for the footer of a page and include it in many other templates. Such templates do not need to be mentioned in the configuration .yml file.

!!! tip

    See [Including Templates](http://symfony.com/doc/current/book/templating.html#including-templates) in Symfony documentation for more information on including templates.

The main template for your webpage (defined per SiteAccess) is placed in the `pagelayout.html.twig` file. This template will be used by default for those parts of the website where no other templates are defined.

A `pagelayout.html.twig` file exists already in Demo Bundles, but if you are using a clean installation, you need to create it from scratch. This file is typically located in a bundle, for example using the built-in AppBundle: `src/AppBundle/Resources/views`. The name of the bundle must the added whenever the file is called, like in the example below.

Any further templates will extend and modify this one, so they need to start with a line like this:

``` html
{% extends "AppBundle::pagelayout.html.twig" %}
```

!!! note

    Although using AppBundle is recommended, you could also place the template files directly in `<installation_folder>/app/Resources/views`. Then the files could be referenced in code without any prefix. See [Best Practices](best_practices.md) for more information.

!!! tip "Template paths"

    In short, the `Resources/views` part of the path is automatically added whenever a template file is referenced. What you need to provide is the bundle name, name of any subfolder within `/views/`, and file name, all three separated by colons (:)

    To find out more about the way of referencing template files placed in bundles, see [Referencing Templates in a Bundle](http://symfony.com/doc/current/book/templating.html#referencing-templates-in-a-bundle) in Symfony documentation.

Templates can be extended using a Twig [`block`](http://twig.sensiolabs.org/doc/functions/block.html) tag. This tag lets you define a named section in the template that will be filled in by the child template. For example, you can define a "title" block in the main template. Any child template that extends it can also contain a "title" block. In this case the contents of the block from the child template will be placed inside this block in the parent template (and override what was inside this block):

``` html
<!--pagelayout.html.twig-->
{# ... #}
    <body>
        {% block title %}
            <h1>Default title</h1>
        {% endblock %}
    </body>
{# ... #}
```

``` html
<!--child.html.twig-->
{% extends "AppBundle::pagelayout.html.twig" %}
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

There are several ways of placing Content items or their Fields inside a template. You can do it using one of the [Twig functions described in detail here](content_rendering.md#twig-functions-reference).

As an example, let's look at one of those functions: [ez\_render\_field](content_rendering.md#ez95render95field). It renders one selected Field of the Content item. In its simplest form this function can look like this:

``` html
{{ ez_render_field( content, 'description' ) }}
```

This renders the value of the Field with identifier "description" of the current Content item (signified by "content"). You can additionally choose a special template to be used for this particular Field:

``` html
{{ ez_render_field(
       content,
       'description',
       { 'template': 'AppBundle:fields:description.html.twig' }
   ) }}
```

!!! note

    As you can see in the case above, templates can be created not only for whole pages, but also for individual Fields.

Another way of embedding Content items is using the `render_esi` function (which is not an eZ-specific function, but a Symfony standard). This function lets you easily select a different Content item and embed it in the current page. This can be used, for instance, if you want to list the children of a Content item in its parent.

``` html
{{ render_esi(controller('ez_content:viewAction', {locationId: 33, viewType: 'line'} )) }}
```

This example renders the Content item with Location ID 33 using the line view. To do this, the function applies the `ez_content:viewAction` controller. This is the default controller for rendering content, but can be substituted here with any custom controller of your choice.

#### Assets

Asset files such as CSS stylesheets, JS scripts or image files can be defined in the templates and need to be included in the directory structure in the same way as with any other web project. Assets are placed in the `web/` folder in your installation.

Instead of linking to stylesheets or embedding images like usually, you can use the [`asset`](http://symfony.com/doc/current/book/templating.html#linking-to-assets) function.

#### Controller

While it is possible to template a whole website using only Twig, a custom PHP controller gives many more options of customizing the behavior of the pages.

See [Custom controllers](content_rendering.md#custom-controllers) for more information.

## Rendering Content items

### Content item Fields

A view template receives the requested Content item, holding all Fields.
In order to display the Fields' value the way you want, you can either manipulate the Field Value object itself, or use a custom template.

#### Getting raw Field value

As you have access to the Content item in the template, you can use [its public methods](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/Repository/Values/Content/Content.php) to access all the information you need. You can also use the `ez_field_value` helper to get the [Field's value only](#ez_field_value). It will return the correct language if there are several, based on language priorities.

``` html
{# With the following, myFieldValue will be in the Content item's main language, regardless of the current language #}
{% set myFieldValue = content.getFieldValue( 'some_field_identifier' ) %}

{# Here myTranslatedFieldValue will be in the current language if a translation is available (read from SiteAccess configuration). If not, the Content item's main language will be used #}
{% set myTranslatedFieldValue = ez_field_value( content, 'some_field_identifier' ) %}
```

#### Using the Field Type's template block

All built-in Field Types come with [their own Twig template](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig). You can render any Field using this default template using the `ez_render_field()` helper.

``` html
{{ ez_render_field( content, 'some_field_identifier' ) }}
```

Refer to [`ez_render_field`](#ez_render_field) for further information.

!!! tip

    As this makes use of reusable templates, **using `ez_render_field()` is the recommended way and is to be considered the best practice**.

### Content name

The **name** of a Content item is its generic "title", generated by the repository based on the Content Type's naming pattern. It often takes the form of a normalized value of the first field, but might be a concatenation of several fields. There are 2 different ways to access this special property:

- Through the name property of ContentInfo (not translated).
- Through VersionInfo with the TranslationHelper (translated).

#### Translated name

The *translated name* is held in a `VersionInfo` object, in the `names` property which consists of a hash indexed by locale. You can easily retrieve it in the right language via the `TranslationHelper` service.

``` html
<h2>Translated Content name: {{ ez_content_name( content ) }}</h2>
<h3>Also works from ContentInfo: {{ ez_content_name( content.contentInfo ) }}</h3>
```

The helper will by default follow the prioritized languages order. If there is no translation for your prioritized languages, the helper will always return the name in the main language.

You can also **force a locale** in a second argument:

``` html
{# Force fre-FR locale. #}
<h2>{{ ez_content_name( content, 'fre-FR' ) }}</h2>
```

!!! note "Name property in ContentInfo"

    This property is the actual Content name, but **in the main language only** (so it is not translated).

    ``` html
    <h2>Content name: {{ content.contentInfo.name }}</h2>
    ```

    In PHP that would be:

    ``` php
    $contentName = $content->getContentInfo->getName();
    ```

    So make sure to use `$content->getVersionInfo->getName()`, which takes translations into account.

#### Exposing additional variables

It is possible to expose additional variables in a content view template. See [parameters injection in content views](../cookbook/injecting_parameters_in_content_views.md).

### Embedding images

The Rich Text Field allows you to embed other Content items within the Field.

Content items that are identified as images will be rendered in the Rich Text Field using a dedicated template.

You can determine which Content Types will be treated as images and rendered using this template in the `ezplatform.content_view.image_embed_content_types_identifiers` parameter. By default it is set to cover the Image Content Type, but you can add other types that you want to be treated as images, for example:

``` yaml
parameters:
    ezplatform.content_view.image_embed_content_types_identifiers: ['image', 'photo', 'banner']
```

The template that is used when rendering embedded images can be set in the `ezplatform.default_view_templates.content.embed_image` container parameter:

``` yaml
parameters:
    ezplatform.default_view_templates.content.embed_image: 'content/view/embed/image.html.twig'
```

### Adding Links

#### Links to other Locations

Linking to other Locations is done with a [native `path()` Twig helper](http://symfony.com/doc/2.3/book/templating.html#linking-to-pages) (or `url()` if you want to generate absolute URLs). When you pass it the Location object, `path()` will generate the URLAlias.

``` html
{# Assuming "location" variable is a valid eZ\Publish\API\Repository\Values\Content\Location object #}
<a href="{{ path( location ) }}">Some link to a Location</a>
```

If you don't have the Location object, but only its ID, you can generate the URLAlias the following way:

``` html
<a href="{{ path( "ez_urlalias", {"locationId": 123} ) }}">Some link to a Location, with its ID only</a>
```

You can also use the Content ID. In that case the generated link will point to the Content item's main Location.

``` html
<a href="{{ path( "ez_urlalias", {"contentId": 456} ) }}">Some link from a contentId</a>
```

!!! note "Under the hood"

    In the back end, `path()` uses the Router to generate links.

    This makes it also easy to generate links from PHP, via the `router` service.

See also: [Cross-SiteAccess links](siteaccess.md#cross-siteaccess-links)

### Embedding Content items

To render an embedded Content from a Twig template you need to **do a subrequest with the `ez_content` controller**.

#### Using the `ez_content` controller

This controller is exactly the same as [the ViewController presented above](#the-viewcontroller). It has one main `viewAction` that renders a Content item.

You can use this controller from templates with the following syntax:

``` html
{{ render(controller("ez_content:viewAction", {"contentId": 123, "viewType": "line"})) }}
```

The example above renders the Content item whose ID is **123** with the view type **line**.

Referencing the `ez_content` controller follows the syntax of *controllers as a service*, [as explained in Symfony documentation](http://symfony.com/doc/current/cookbook/controller/service.html).

##### Available arguments

As with any controller, you can pass arguments to `ez_content:viewLocation` or `ez_content:viewContent` to fit your needs.

|Name|Description|Type|Default value|
|---|---|---|---|
|`contentId`|ID of the Content item you want to render. Only for `ez_content:viewContent`|integer|N/A|
|`locationId`|ID of the Location you want to render. Only for `ez_content:viewLocation`|integer|Content item's main location, if defined|
|`viewType`|The view type you want to render your Content item/Location in. Will be used by the ViewManager to select a corresponding template, according to defined rules. </br>Example: full, line, my_custom_view, etc.|string|full|
|`layout`|Indicates if the sub-view needs to use the main layout (see [available variables in a view template](#available-variables))|boolean|false|
|`params`|Hash of variables you want to inject to sub-template, key being the exposed variable name.|hash|empty hash|

For example:

``` html
{{ render(
      controller(
          "ez_content:viewAction",
          {
              "contentId": 123,
              "viewType": "line",
              "params": { "some_variable": "some_value" }
          }
      )
) }}
```

#### Rendering and cache

##### ESI

Just like for regular Symfony controllers, you can take advantage of [ESI](https://symfony.com/doc/current/http_cache/esi.html) and use different cache levels:

``` html
{{ render_esi(controller("ez_content:viewAction", {"contentId": 123, "viewType": "line"})) }}
```

Only scalar variables (not objects) can be sent via `render_esi`.

##### Asynchronous rendering using hinclude

Symfony also supports asynchronous content rendering with the help of the [hinclude.js](http://mnot.github.com/hinclude/) library.

``` html
<!--Asynchronous rendering-->
{{ render_hinclude(controller("ez_content:viewAction", {"contentId": 123, "viewType": "line"})) }}
```

Only scalar variables (not objects) can be sent via `render_hinclude`.

##### Display a default text

If you want to display a default text while a controller is loaded asynchronously, you have to pass a second parameter to your `render_hinclude` Twig function.

``` html
<!--Display a default text during asynchronous loading of a controller-->
{{ render_hinclude(controller('EzCorporateDesignBundle:Header:userLinks'), {'default': "<div style='color:red'>loading</div>"}) }}
```

See also: [Custom controllers](#custom-controllers).

[hinclude.js](http://mnot.github.com/hinclude/) needs to be properly included in your layout to work.

[Refer to Symfony documentation](http://symfony.com/doc/current/book/templating.html#asynchronous-content-with-hinclude-js) for all available options.

### Rendering in preview

When previewing content in the back office, the draft view is rendered using the [PreviewController](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/MVC/Symfony/Controller/Content/PreviewController.php).

The first draft of a yet unpublished Content item does not have a Location, because Locations are only assigned when content is published.
To enable rendering in such cases, the PreviewController [creates a temporary virtual Location](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/Helper/PreviewLocationProvider.php#L65).
This Location has some of the properties of the future Location, such as the parent Location ID.
However, it does not fully replace a normal Location.

If the rendering template refers directly to the Location ID of the content, an error will occur.
To avoid such situations, you can check if the Location is virtual using the `location.isDraft` flag in Twig templates, for example:

``` jinja
{% if not location.isDraft %}
    <a href="{{ path(location) }}">{{ ez_content_name(content) }}</a>
{% endif %}
```

!!! enterprise

    ## Landing Page

    ### Landing Page layouts

    A Landing Page has a customizable layout with multiple zones where you can place blocks with content.

    A clean installation has only one default layout. You can preview more layouts in the Demo bundle.

    A Landing Page layout is composed of zones.

    ##### Zone structure

    Each zone contains the following parameters:

    | Name             | Description                  |
    |------------------|------------------------------|
    | `zone_id` | Required. A unique zone ID |
    | `name`     | Required. Zone name        |

    #### Layout configuration

    The layout is configured in YAML files:

    ``` yaml
    ez_systems_landing_page_field_type:
        layouts:
            sidebar:
                identifier: sidebar
                name: Right sidebar
                description: Main section with sidebar on the right
                thumbnail: /assets/images/layouts/sidebar.png
                template: AppBundle:layouts:sidebar.html.twig
                zones:
                    first:
                        name: First zone
                    second:
                        name: Second zone
    ```

    The following parameters need to be included in the settings of the [configuration](../guide/best_practices.md#configuration_1):

    |Parameter|Type|Description|Required|
    |------|------|------|------|
    |layouts|string|Layout config root|Yes|
    |number|string|Unique key of the layout|Yes|
    |{ID}/identifier|string|ID of the layout|Yes|
    |{ID}/name|string|Name of the layout|Yes|
    |{ID}/description|string|Description of layout|Yes|
    |{ID}/thumbnail|string|<path> to thumbnail image|Yes|
    |{ID}/template|string|<path> to template View For example: `AppBundle:layouts:sidebar.html.twig`</br>`<bundle>:<directory>:<file name>`|Yes|
    |{ID}/zones|string|Collection of zones|Yes|
    |{ID}/{zone}/zone_id|string|ID of the zone|Yes|
    |{ID}/{zone}/name|string|Zone name|Yes|

    #### Layout template

    A layout template will include all zones the layout contains. The zone container must have a `data-studio-zones-container` attribute.

    A Zone is a container for blocks. Each zone must have a `data-studio-zone` attribute.
    The best way to display blocks in the zone is to iterate over a blocks array and render the blocks in a loop.

    ``` html
    <div data-studio-zones-container>
        <div data-studio-zone="{{ zones[0].id }}">
            {# If the first zone (with index [0]) contains any blocks #}
            {% if zones[0].blocks %}
                {# for each block #}
                {% for block in zones[0].blocks %}
                    {# create a new layer with appropriate id #}
                    {# the div's class takes the type of the block that is placed in it #}
                    <div class="landing-page__block block_{{ block.type }}">
                        {# render the block by using the "ez_block:renderBlockAction" controller #}
                        {{ render_esi(controller('ez_block:renderBlockAction', {
                                'contentId': contentInfo.id,
                                'blockId': block.id
                            }))
                        }}
                    </div>
                {% endfor %}
            {% endif %}
        </div>
        <div data-studio-zone="{{ zones[1].id }}">
            {# Repeat the same for the second zone, with index [1] #}
            {% if zones[1].blocks %}
                {% for block in zones[1].blocks %}
                    <div class="landing-page__block block_{{ block.type }}">
                        {{ render_esi(controller('ez_block:renderBlockAction', {
                                'contentId': contentInfo.id,
                                'blockId': block.id
                            }))
                        }}
                    </div>
                {% endfor %}
            {% endif %}
        </div>
    </div>
    ```

    ### Landing Page template
    Once published, a Landing Page will be displayed using the template according to the `content_view` setting, see [View Matchers](#view-matchers). If you want to see the Landing Page displayed using a particular template in the edit mode of Landing Page Editor before publish, you need to configure the following additional settings in `ezplatform.yml` configuration file.

    ``` yml
    ezstudioui:
        system:
            # Defines the scope: a valid SiteAccess, SiteAccess group or even "global"
            front_siteaccess:
                studio_template: AppBundle:studio:template.html.twig
    ```

    This is an example of a minimal template file:

    ``` html
    {% extends base_template() %}
    {% block content %}

        <!-- Custom template header code -->

        <!-- This part is required! -->
        {% if content is defined %}
            {{ ez_render_field(content, 'page') }}
        {% else %}
            <div data-area="static" style="min-height:300px;"></div>
        {% endif %}
        <!-- End required part -->

        <!-- Rest of the custom template code -->

    {% endblock %}
    ```

        !!! caution
        Custom template always needs to extend `base_template()`. Morevoer, you have to check whether the `content` variable is defined to correctly display a previously published Landing Page. Otherwise, you need to display `<div data-area="static"></div>` which is the place where you can put the new blocks.

    ### Landing Page blocks

    By default eZ Enterprise comes with a number of preset Landing Page blocks. You can, however, add custom blocks to your configuration. There are two ways to do this: the full way and an [easier, YAML-based method](#defining-landing-page-blocks-in-the-configuration-file).

    #### Block Class

    The class for the block must implement the `BlockType` interface:

    ``` php
    EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\BlockType
    ```

    Most methods are implemented in a universal way by using the `AbstractBlockType` abstract class:

    ``` php
    EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType
    ```

    If your block does not have specific attributes or a structure, you can extend the `AbstractBlockType` class, which contains simple generic converters designated for the block attributes.

    For example:

    ``` php
    <?php
    namespace AcmeBundle\Block;

    use EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType;

    class ExampleBlock extends AbstractBlockType
    {
       // Class body
    }
    ```

    ##### Class definition

    A block **must** have a definition set using two classes:

    ###### BlockDefinition

    The `BlockDefinition` class describes a block:

    |Attribute|Type|Definition|
    |------|------|------|
    |$type|string|block type|
    |$name|string|block name|
    |$category|string|block category|
    |$thumbnail|string|path to block thumbnail image|
    |$templates|array|array of available paths of templates</br>See [Block templates](#block-templates) below|
    |$attributes|array|array of block attributes (objects of `BlockAttributeDefinition` class)|

    ###### BlockAttributeDefinition

    The `BlockAttributeDefinition` class defines the attributes of a block:

    |Attribute|Type|Definition|
    |------|------|------|
    |`$id`|string|block attribute ID|
    |`$name`|string|block attribute name|
    |`$type`|string|block attribute type, available options are:</br>`integer`</br>`string`</br>`url`</br>`text`</br>`embed`</br>`select`</br>`multiple`</br>`radio`|
    |`$regex`|string|block attribute regex used for validation|
    |`$regexErrorMessage`|string|message displayed when regex does not match|
    |`$required`|bool|`TRUE` if attribute is required|
    |`$inline`|bool|indicates whether block attribute input should be rendered inline in a form|
    |`$values`|array|array of chosen values|
    |`$options`|array|array of available options|

    ##### Class methods

    When extending `AbstractBlockType` you **must** implement at least 3 methods:

    ###### `createBlockDefinition()`

    This method must return an `EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition` object.

    Example of the built-in Gallery block:

    ``` php
    public function createBlockDefinition()
    {
        return new BlockDefinition(
            'gallery',
            'Gallery Block',
            'default',
            'bundles/ezsystemslandingpagefieldtype/images/thumbnails/gallery.svg',
            [],
            [
                new BlockAttributeDefinition(
                    'contentId',
                    'Folder',
                    'embed',
                    '/^([a-zA-Z]:)?(\/[a-zA-Z0-9_\/-]+)+\/?/',
                    'Choose an image folder'
                ),
            ]
        );
    }
    ```

    ###### `getTemplateParameters(BlockValue $blockValue)`

    This method returns an array of parameters to be displayed in rendered view of block. You can access them directly in a block template (e. g. via twig `{{ title }}` ).

    When parameters are used in the template you call them directly without the `parameters` array name:

    | Correct | Not Correct |
    |---------|-------------|
    | `<h1>{{ title }}</h1>` | `<h1>{{ parameters.title }}</h1>` |

    `getTemplateParameters()` method implementation using the example of the built-in RSS block:

    ``` php
    public function getTemplateParameters(BlockValue $blockValue)
    {
        $attributes = $blockValue->getAttributes();
        $limit = (isset($attributes['limit'])) ? $attributes['limit'] : 10;
        $offset = (isset($attributes['offset'])) ? $attributes['offset'] : 0;
        $parameters = [
            'title' => $attributes['title'],
            'limit' => $limit,
            'offset' => $offset,
            'feeds' => $this->RssProvider->getFeeds($attributes['url']),
        ];

        return $parameters;
    }
    ```

    ###### `checkAttributesStructure(array $attributes)`

    This method validates the input fields for a block. You can specify your own conditions to throw the `InvalidBlockAttributeException` exception.

    This `InvalidBlockAttributeException` exception has the following parameters:

    | Name           | Description                                            |
    |----------------|--------------------------------------------------------|
    |  `blockType` |  name of a block                                       |
    |  `attribute` |  name of the block's attribute which failed validation |
    |  `message`   |  a short information about an error                    |
    |  `previous`  |  previous exception, null by default                   |

    For example to validate an RSS block:

    ``` php
    public function checkAttributesStructure(array $attributes)
    {
        if (!isset($attributes['url'])) {
            throw new InvalidBlockAttributeException('RSS', 'url', 'URL must be set.');
        }

        if (isset($attributes['limit']) && (($attributes['limit'] < 1) || (!is_numeric($attributes['limit'])))) {
            throw new InvalidBlockAttributeException('RSS', 'limit', 'Limit must be a number greater than 0.');
        }

        if (isset($attributes['offset']) && (($attributes['offset'] < 0) || (!is_numeric($attributes['limit'])))) {
            throw new InvalidBlockAttributeException('RSS', 'offset', 'Offset must be a number no less than 0.');
        }
    }
    ```

    #### Adding the class to the container

    The **services.yml** file must contain info about your block class.

    The description of your class must contain a tag which provides:

    - tag name: `landing_page_field_type.block_type`
    - tag alias: `<name of a block>`

    For example:

    ``` yaml
    # service id
    acme.block.example:
        # block's class with namespace
        class: AcmeBundle\Block\ExampleBlock
        tags:
            # service definition must contain tag with
            # "landing_page_field_type.block_type" name and block name as an alias
            - { name: landing_page_field_type.block_type, alias: example}
    ```

    #### Block templates

    The templates for the new blocks are configured in your YAML config.

    ``` yaml
    blocks:
        example:
            views:
                test:
                    template: AcmeBundle:blocks:example.html.twig
                    name: Example Block View
    ```

    #### Example

    For a full working example of creating a new Landing Page block, see [step 4 of the Enterprise tutorial](../tutorials/enterprise_beginner/4_creating_a_custom_block.md).

    !!! tip

        If you want to make sure that your block is only available in the Element menu in a specific situation, you can override the `isAvailable` method, which makes the block accessible by default:

        ``` php
        public function isAvailable()
            {
                return true;
            }
        ```

    #### Custom editing UI

    If you want to add a custom editing UI to your new block, you need to provide the code for the custom popup UI in Javascript (see the code for `ezs-scheduleblockview.js` or `ezs-tagblockview.js` in the StudioUIBundle in your installation for examples).

    Once it is ready, create a plugin for `eZS.LandingPageCreatorView` that makes a use of the `addBlock` public method from `eZS.LandingPageCreatorView`, see the example below:

    ``` php
    YUI.add('ezs-addcustomblockplugin', function (Y) {
        'use strict';

        var namespace = 'Any.Namespace.Of.Your.Choice',

        Y.namespace(namespace);
        NS = Y[namespace];

        NS.Plugin.AddCustomBlock = Y.Base.create('addCustomBlockPlugin', Y.Plugin.Base, [], {
            initializer: function () {
                this.get('host').addBlock('custom', NS.CustomBlockView);
            },
        }, {
            NS: 'dashboardPlugin'
        });

        Y.eZ.PluginRegistry.registerPlugin(
            NS.Plugin.AddCustomBlock, ['landingPageCreatorView']
        );
    });
    ```

    #### Defining Landing Page blocks in the configuration file

    There is a faster and simpler way to create Landing Page block types
    using only the YAML configuration in an application or a bundle, under the `ez_systems_landing_page_field_type` key.

    ``` yaml
    ez_systems_landing_page_field_type:
        blocks:
            example_block:
                initialize: true
                name: Example Block
                category: default
                thumbnail: bundles/ezsystemslandingpageblocktemplate/images/templateblock.svg
                views:
                    default:
                        template: blocks/template.html.twig
                        name: Default view
                    special:
                        template: blocks/special_template.html.twig
                        name: Special view
                attributes:
                    handle:
                        type: text
                        regex: /[\s]/
                        regexErrorMessage: Invalid text
                        required: true
                        inline: false
                        values: []
                        options: []
                    flavor:
                        type: multiple
                        required: true
                        inline: false
                        values: [value2]
                        options:
                            value1: vanilla
                            value2: chocolate
    ```

    !!! tip

        Configuration keys have to match `BlockDefinition` and `BlockAttributeDefinition` property names.

    Below you can find a few important notes:

    - You can omit the `name` attribute. Values are going to be generated automatically in the following fashion: `new_value` =&gt; `New Value`
    - `category` is not in use - it will be implemented in the future.
    - In most cases blocks have only a single view, therefore you can define it as: `views: EzSystemsLandingPageBlockTemplateBundle::template.html.twig`.
    - In case of multiple views you can omit `name` and simplify it as follows:

    ``` yaml
    views:
        default: blocks/template.html.twig
        special: blocks/special_template.html.twig
    ```

    - When defining attributes you can omit most keys as long as you use simple types:

    ``` yaml
    attributes:
        first_field: text
        second_field: string
        third_field: integer
    ```

    Keep in mind that other types such as `multiple`, `select`, `radio` have to use the `options` key.

    ###### Block type class and service

    If `intialize` is set to` true`, you no longer have to register a service associated with the new block.
    It will use a generic service which exposes all attribute values to the views.

    You can overwrite the `ez_systems.landing_page.block.{NEW_BLOCK_IDENTIFIER}` service with your own implementation.
    Just make sure your class extends the `ConfigurableBlockType` class.

    Some hints regarding custom service implementation:

    - do not override the `createBlockDefinition()` method unless you want to make further modifications to the `\EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Definition\BlockDefinition` object created from your YAML config. Do not forget to run `parent::createBlockDefinition()` to retrieve the original object.
    - implement other methods such as `checkAttributesStructure()` and `getTemplateParameters()` to provide more complex validation and implement the block functionality.

    ###### Overwriting existing blocks

    You can overwrite following properties in the existing blocks:

    - `thumbnail`
    - `name`
    - `category`
    - `views`

    !!! caution

        It is not possible to overwrite or add any attributes to existing blocks as there is no possibility to modify BlockType implementation, and therefore to use or display those new attributes.

    `\EzSystems\LandingPageFieldTypeBundle\FieldType\LandingPage\Model\AbstractBlockType::isFinal` indicates whether the block can be overwritten by the configuration. All blocks can be overwritten by default.

    ### Schedule block

    Schedule block is an Enterprise-only feature that enables you to plan content to be published at a predetermined time in the future.

    Schedule blocks are placed on a Landing Page and can be configured like any other block. This includes providing different templates for the editor to choose in the Studio UI.

    A Schedule block consists of a number of slots. Each slot can hold one Content item.

    The number of slots and their order is defined in the template. A template for a Schedule block must include the `data-studio-slots-container` and `data-studio-slot` attributes to enable placing Content in the slots.

    #### Behavior

    ![Schedule block slot with options](img/schedule_block_slot_options.png "Schedule block slot with options")

    You can preview the content added to a Schedule block in full, as it is viewed in PlatformUI, by activating the **Preview** button.

    When content is added to the block, it is initially assigned an airtime equal to the current time. The airtime can then be changed to a date and time in the future. Content items are ordered in the block according to the airtime. When you add more items to a block than there are slots, oldest content (i.e., with earliest airtime), is pushed off the block.

    A Schedule block tracks all content that is added, deleted and pushed off it. In the back office (both in View and Edit mode) you can see all activity (adding, deleting or overflow) in a block using the timeline at the top of the editor. Colored stripes on the timeline indicate when any change to the block happens. You can select the stripe to see the details of the changes.

    **Full list** in the timeline bar gives you access to all changes. When you view it in Edit mode, it displays all changes in the selected Schedule block; when you select the list in View mode, you will see all changes in all blocks on the page.

    Overflow enables you to combine multiple Schedule blocks in one flow. It is set up in the editor. Overflow defines what happens with content that is pushed off a full block.

    ![Schedule block with overflow options](img/schedule_with_overflow.png "Schedule block with overflow options")

    Each Schedule block that has overflow enabled can have one target block defined. When a Content item is pushed off the block, it will overflow to the designated block. In target block the items will be ordered according to the original airtime, not the order in which they were overflown.

    You can connect more than two Schedule blocks in this way, one after the other. It is also possible for multiple Schedule blocks to overflow into one. However, it is not possible to build a circular overflow (where a sequence of overflowing items eventually points to the original block). This is disabled in the UI.

    The **Remove item** action removes the item from the block (but does not delete the Content item itself. Deleting a Content item is possible from Content structure). When an item is removed, other content is pulled back to fill its place. This also happens to content that has already been pushed off the block – it will be pulled back even from a target overflow block.

    ##### Special Schedule block use cases

    - **Enabling and disabling overflow.** When you disable overflow, items which have already overflown to a target block will be removed from preview, but will stay in the history of the source block. If some items have already been pushed off a block and you enable overflow on it afterwards, the moved items will still overflow to the target block. When the target block of overflow is deleted, overflow will turn off automatically.

    - **Multi-block configuration.** You can have more than one block overflow to a single target block. Content items will remember their history. This means that if content is removed in the source blocks, items will be pulled back into their original blocks.

    - **Multiple copies of the same Content item.** You cannot add the same Content item multiple times to the same Schedule block. If two copies would end up in the same block, e.g. as a result of overflow, the older copy will be removed.

    ###### Example

    A typical example of using a Schedule block is a "Featured" articles block which overflows to a regular "List" of articles.

    A multi-block setup can be used to collect items from two blocks into one list. In the example below two featured blocks at the top, "Places" and "Tastes", both overflow to a single list, where content is ordered according to its airtime:

    ![Schedule block example with multiple blocks](img/schedule_block_example.png "Schedule block example with multiple blocks")

## Twig Functions Reference

!!! note "Symfony and Twig template functions/filters/tags"

    For the template functionality provided by Symfony Framework, see [Symfony Twig Extensions Reference page](http://symfony.com/doc/current/reference/twig_reference.html). For those provided by the underlying Twig template engine, see [Twig Reference page](http://twig.sensiolabs.org/documentation#reference)

In addition to the [native functions provided by Twig](http://twig.sensiolabs.org/doc/functions/index.html), eZ Platform offers the following:

- [`ez_content_name`](#ez_content_name) - displays a Content item's name in the current language
- [`ez_field_description`](#ez_field_description) - returns the description from the FieldDefinition of a Content item's Field in the current language
- [`ez_field_name`](#ez_field_name) - returns the name from the FieldDefinition of a Content item's Field in the current language
- [`ez_field_value`](#ez_field_value) - returns a Content item's Field value in the current language
- [`ez_field`](#ez_field) - returns a Field value in the current language
- [`ez_file_size`](#ez_file_size) - returns the size of a file as string
- [`ez_first_filled_image_field`](#ez_first_filled_image_field) - returns the identifier of the first image field that is not empty
- [`ez_image_alias`](#ez_image_alias) - displays a selected variation of an image
- [`ez_is_field_empty`](#ez_is_field_empty) - checks if a Content item's Field value is considered empty in the current language
- [`ez_render_field`](#ez_render_field) - displays a Content item's Field value, taking advantage of the template block exposed by the Field Type used
- [`ez_trans_prop`](#ez_trans_prop) - gets the translated value of a multi valued(translations) property
- [`ez_urlalias`](#ez_urlalias) - is a special route name for generating URLs for a Location from the given parameters

#### `ez_content_name`

##### Description

`ez_content_name()` is a Twig helper which displays a Content item's name in the current language.

If the Content item does not have a translation in the current language, the name in the main language is always returned. This behavior is identical when forcing a language.

##### Prototype and Arguments

`ez_content_name( eZ\Publish\API\Repository\Values\Content\Content content[, string forcedLanguage] )ez_content_name(contentInfo[, string forcedLanguage] )`

| Argument name | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` or `eZ\Publish\API\Repository\Values\Content\ContentInfo ` | Content or ContentInfo object the displayable field belongs to.|
| `forcedLanguage` | `string` | Locale you want the content name translation in (e.g. "fre-FR"). Null by default (takes current locale) |

##### Usage

``` html
<h2>Content name in current language: {{ ez_content_name( content ) }}</h2>
<h2>Content name in current language, from ContentInfo: {{ ez_content_name( content.contentInfo ) }}</h2>
<h2>Content name in French (forced): {{ ez_content_name( content, "fre-FR" ) }}</h2>
```

##### Equivalent PHP code

###### Getting the translated name for a Content item

``` php
// Assuming you're in a controller action
$translationHelper = $this->get( 'ezpublish.translation_helper' );

// From Content
$translatedContentName = $translationHelper->getTranslatedContentName( $content );
// From ContentInfo
$translatedContentName = $translationHelper->getTranslatedContentNameByContentInfo( $contentInfo );
```

###### Forcing a specific language

``` php
// Assuming you're in a controller action
$translatedContentName = $this->get( 'ezpublish.translation_helper' )->getTranslatedName( $content, 'fre-FR' );
```

#### `ez_field_description`

##### Description

`ez_field_description()` is a Twig helper which returns the description from the FieldDefinition of a Content item's Field in the current language.

This can be useful when you don't want to use a sub-request and custom controller to be able to display this information.

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

##### Prototype and Arguments

`ez_field_description( Content|ContentInfo content, string fieldDefIdentifier[, string forcedLanguage] )`

| Argument name | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` or `eZ\Publish\API\Repository\Values\Content\ContentInfo ` | Content/ContentInfo object the **fieldDefIdentifier** belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the Field you want to get the FieldDefinition description from. |
| `forcedLanguage` | `string` | Language you want to force (e.g. "eng-US"), otherwise takes prioritized languages from SiteAccess settings. |

##### Usage

``` html
<p id="ez-content-article-title-description">{{ ez_field_description( content, "title" ) }}</p>
```

#### `ez_field_name`

##### Description

`ez_field_name()` is a Twig helper which returns the name from the FieldDefinition of a Content item's Field in the current language.

This can be useful when you don't want to use a sub-request and custom controller to be able to display this information.

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

##### Prototype and Arguments

`ez_field_name( Content|ContentInfo content, string fieldDefIdentifier[, string forcedLanguage] )`

| Argument name | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` or `eZ\Publish\API\Repository\Values\Content\ContentInfo` | Content / ContentInfo object the **fieldDefIdentifier** belongs to. |
| `fieldDefIdentifier` | `string` | Identifier of the Field you want to get the FieldDefinition name from. |
| `forcedLanguage` | `string` | Language you want to force (e.g. "`jpn-JP`"), otherwise takes prioritized languages from SiteAccess settings. |

##### Usage

``` html
<label for="ez-content-article-title">{{ ez_field_name( content, "title" ) }}</label>
```

#### `ez_field_value`

##### Description

`ez_field_value()` is a Twig helper which returns a Content item's Field value in the current language.

This can be useful when you don't want to use [`ez_render_field`](#ez_render_field) and manage the rendering by yourself.

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

##### Prototype and Arguments

`ez_field_value( eZ\Publish\API\Repository\Values\Content\Content content, string fieldDefIdentifier[, string forcedLanguage] )`

| Argument name        | Type                                               | Description                                                                                            |
|----------------------|----------------------------------------------------|--------------------------------------------------------------------------------------------------------|
| `content`            | `eZ\Publish\API\Repository\Values\Content\Content` | Content object the field referred to with `fieldDefIdentifier` belongs to.                           |
| `fieldDefIdentifier` | `string`                                           | Identifier of the field you want to get the value from.                                                 |
| `forcedLanguage`     | `string`                                           | Locale you want the Content name translation in (e.g. "fre-FR"). Null by default (takes current locale) |

##### Usage

``` html
<h2>My title value: {{ ez_field_value( content, "title" ) }}</h2>
```

#### `ez_field`

##### Description

`ez_field()` is a Twig helper which returns a Field value in the current language.

!!! tip

    Other Twig helpers are available to display specific information of the Field; they all start with `ez_field_`.

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

##### Prototype and Arguments

`ez_field( eZ\Publish\API\Repository\Values\Content\Content content, string fieldDefIdentifier[, string forcedLanguage] )`

| Argument name        | Type                                               | Description                                                                                            |
|----------------------|----------------------------------------------------|--------------------------------------------------------------------------------------------------------|
| `content`            | `eZ\Publish\API\Repository\Values\Content\Content` | Content object the field referred to with `fieldDefIdentifier` belongs to.                           |
| `fieldDefIdentifier` | `string`                                           | Identifier of the field you want to get the value from.                                                 |
| `forcedLanguage`     | `string`                                           | Locale you want the Content name translation in (e.g. "fre-FR"). Null by default (takes current locale) |

##### Usage

``` html
<h2>My title's id: {{ ez_field( content, "title" ).id }}</h2>
```

#### `ez_file_size`

##### Description

`ez_file_size()` is a Twig helper (Twig filter) which is mostly a byte calculator. It will convert a number from byte to the correct suffix (from B to EB). The output pattern will also vary with the current language of the SiteAccess (e.g. choosing between coma or point pattern).

It returns a string.

!!! note

    The byte factor is 1000 instead of 1024 to be more familiar for users.

##### Prototype and Arguments

`integer number_of_bytes|ez_file_size( integer number_of_decimal )`

| Argument name       | Type      | Description                                      |
|---------------------|-----------|--------------------------------------------------|
| `number_of_bytes`   | `integer` | The number in byte you want to convert            |
| `number_of_decimal` | `integer` | The number of decimal you want the output to have |

##### Usage

``` html
{{ 42698273|ez_file_size( 3 ) }} //Output with French SiteAccess : 42,698 MB

{{ 42698273|ez_file_size( 4 ) }} //Output with English SiteAccess : 42.6983 MB
```

#### `ez_first_filled_image_field`

##### Description

`ez_first_filled_image_field` is a Twig helper which returns the identifier of the first image field that is not empty.

It can be used for example to identify the first image in an article to render it in an embed or line view.

##### Prototype and Arguments

`ez_first_filled_image_field ( eZ\Publish\API\Repository\Values\Content\Content content )`

| Argument name | Type                                               | Description                       |
|---------------|----------------------------------------------------|-----------------------------------|
| `content`     | `eZ\Publish\API\Repository\Values\Content\Content` | Content item the Fields belong to |

#### `ez_image_alias`

##### Description

`ez_image_alias()` is a Twig helper that displays a selected variation (alias) of an image.

##### Prototype and Arguments

`ez_image_alias( eZ\Publish\API\Repository\Values\Content\Field field, eZ\Publish\API\Repository\Values\Content\VersionInfo versionInfo, string variantName )`

| Argument name | Type                                                   | Description                               |
|---------------|--------------------------------------------------------|-------------------------------------------|
| `field`       | `eZ\Publish\API\Repository\Values\Content\Field`       | The image Field                           |
| `versionInfo` | `eZ\Publish\API\Repository\Values\Content\VersionInfo` | The VersionInfo that the Field belongs to |
| `variantName` | `string`                                               | Name of the image variation to be used        |

See [images](images.md) for more information about image variations.

#### `ez_is_field_empty`

##### Description

`ez_is_field_empty()` is a Twig helper which checks if a Content item's Field value is considered empty in the current language.

It returns a boolean value (`true` or `false`).

If the Content item does not have a translation in the current language, the main language will be used. This behavior is identical when forcing a language using **forcedLanguage**.

##### Prototype and Arguments

`ez_is_field_empty( eZ\Publish\API\Repository\Values\Content\Content content, eZ\Publish\API\Repository\Values\Content\Field|string fieldDefIdentifier[, string forcedLanguage] )`

| Argument name | Type | Description |
|---------------|------|-------------|
| `content` | `eZ\Publish\API\Repository\Values\Content\Content` | Content item the displayed Field belongs to. |
| `fieldDefIdentifier` | `eZ\Publish\API\Repository\Values\Content\Field or string` | The Field you want to check or its identifier. |
| `forcedLanguage` | `string` | Locale you want the Content name translation in (e.g. "fre-FR"). Null by default (takes current locale) |

##### Usage

###### Using the Field identifier as parameter

``` html
{# Display "description" field if not empty #}
{% if not ez_is_field_empty( content, "description" ) %}
    <div class="description">
        {{ ez_render_field( content, "description" ) }}
    </div>
{% endif %}
```

###### Using the Field as parameter

``` html
{# Display "description" field if not empty #}
{% if not ez_is_field_empty( content, field ) %}
    <div class="description">
        {{ ez_render_field( content, field.fieldDefIdentifier ) }}
    </div>
{% endif %}
```

###### Checking if Field exists before use

``` html
{# Display "description" field if it exists and is not empty #}
{% if content.fields.description is defined and not ez_is_field_empty( content, "description" ) %}
    <div class="description">
        {{ ez_render_field( content, "description" ) }}
    </div>
{% endif %}
```

#### `ez_render_field`

##### Description

`ez_render_field()` is a Twig helper that displays a Content item's Field value, taking advantage of the template block exposed by the Field Type used.

Template blocks for built-in Field Types [reside in EzPublishCoreBundle](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/views/content_fields.html.twig).

See section of [Using the Field Type's template block](#using-the-field-types-template-block) for more information.

##### Prototype and Arguments

`ez_render_field( eZ\Publish\API\Repository\Values\Content\Content content, string fieldDefinitionIdentifier[, hash params] )`

|Argument name|Type|Description|
|------|------|------|
|`content`|`eZ\Publish\API\Repository\Values\Content\Content`|Content item the displayable field belongs to.|
|`fieldDefinitionIdentifier`|`string`|The identifier the Field is referenced by.|
|`params`|`hash`|Hash of parameters that will be passed to the template block.</br>By default you can pass 2 entries:</br>`lang` (to override the current language, must be a valid locale with xxx-YY format)</br>`template` (to override the template to use, see below)</br>`attr` (hash of HTML attributes you want to add to the inner markup)</br>parameters (arbitrary parameters to pass to the template block)</br></br>Some Field Types might expect specific entries under the `parameters` key, like the [MapLocation Field Type](../api/field_type_reference.md#maplocation-field-type).

##### Override a Field template block

In some cases, you may not want to use the built-in field template block as it might not fit your markup needs. In this case, you can choose to override the template block by specifying your own template. You can do this inline when calling `ez_render_field()`, or globally by prepending a Field template to use by the helper.

Your template block must comply to a regular Field Type template block, [as explained in the Field Type documentation](../api/field_type_template.md).

###### Inline override

You can use the template you need by filling the `template` entry in the `params` argument.

``` html
{{ ez_render_field(
       content,
       'my_field_identifier',
       { 'template': 'AcmeTestBundle:fields:my_field_template.html.twig' }
   ) }}
```

The code above will load `my_field_template.html.twig` located in `AcmeTestBundle/Resources/views/fields/`.

``` html
{# AcmeTestBundle/Resources/views/fields/my_field_template.html.twig #}
{# Assuming "my_field_identifier" from the template above example is an ezkeyword field. #}
{% block ezkeyword_field %}
    {% spaceless %}
        {% if field.value.values|length() > 0 %}
        <ul>
            {% for keyword in field.value.values %}
            <li>{{ keyword }}</li>
            {% endfor %}
        </ul>
        {% endif %}
    {% endspaceless %}
{% endblock %}
```

!!! tip "Overriding a block and calling the parent"

    When overriding a field template block, it is possible to call its parent. For this, you need to import original template horizontally (without inheritance), using the [`use` Twig tag](http://twig.sensiolabs.org/doc/tags/use.html).

    ``` html
    {# AcmeTestBundle/Resources/views/fields/my_field_template.html.twig #}
    {# Assuming "my_field_identifier" from above template example is an ezkeyword field. #}

    {% use "EzPublishCoreBundle::content_fields.html.twig" with ezkeyword_field as base_ezkeyword_field %}

    {# Surround base block with a simple div #}
    {% block ezkeyword_field %}
        <div class="ezkeyword">
            {{ block("base_ezkeyword_field") }}
        </div>
    {% endblock %}
    ```

###### Inline override using current template

If you want to override a specific Field template only once (i.e. because your override would be only valid in your current template), you can specify the current template to be the source of the Field block.

``` html
<!--Inline override using current template-->
{% extends "MyBundle::pagelayout.html.twig" %}

{% block content %}
    {# Note that "tags" is a field using ezkeyword fieldType #}
    <div class="tags">{{ ez_render_field( content, "tags" , { "template": _self } ) }}</div>
{% endblock %}

{# Here begins the inline block for my ezkeyword field #}
{% block ezkeyword_field %}
    {% spaceless %}
        {% if field.value.values|length() > 0 %}
        <ul>
            {% for keyword in field.value.values %}
            <li>{{ keyword }}</li>
            {% endfor %}
        </ul>
        {% endif %}
    {% endspaceless %}
{% endblock %}
```

!!! caution "Limitation"

    **Using `_self` will only work if your current template is extending another one.**

    This is basically the same limitation as for [Symfony form themes](http://symfony.com/doc/current/book/forms.html#global-form-theming).

###### Global override

In the case where you want to systematically reuse your own Field template instead of the default one, you can append it to the Field templates list to use by `ez_render_field()`.

To make your template available, you must register it to the system.

``` yaml
# app/config/ezplatform.yml
ezpublish:
    system:
        my_siteaccess:
            field_templates:
                -
                    template: "AcmeTestBundle:fields:my_field_template.html.twig"
                    # Priority is optional (default is 0). The higher it is, the higher your template gets in the list.
                    priority: 10
```

!!! tip

    You can define these rules in a dedicated file instead of `app/config/ezplatform.yml`. Read the [cookbook recipe to learn more about it](../cookbook/importing_settings_from_a_bundle.md).

#### `ez_trans_prop`

##### Description

`ez_trans_prop()` is a generic, low level Twig helper which gets the translated value of a multi valued(translations) property.

If the Content item does not have a translation in the current language, the main language (see [further down for details](#main-language-use)) will be used if this is supported by the provided **object**. This behavior is identical when forcing a language using **forcedLanguage**.

##### Prototype and Arguments

`ez_trans_prop( ValueObject object, string property[, string forcedLanguage] )`

|Argument name|Type|Description|
|------|------|------|
|`object`|`eZ\Publish\API\Repository\Values\ValueObject`|ValueObject object **property** belongs to.|
|`property`|`string`|Property to get translated value from, logic is using one of the following (in this order):</br>object method `get{property}`</br>object property `{property}s`|
|`forcedLanguage`|`string`|Optional language we want to force (e.g. `"eng-US"``), otherwise takes prioritized languages from SiteAccess settings.|

###### Main language use

Main language is be applied in the following way for Value objects that support this:

- *When attribute is retrieved via object property*: Use **mainLanguageCode** property if it exists as fallback language, but only if either **alwaysAvailable** property does not exist, or is true.
- *When attribute is retrieved via object method*: Provide `$language = null` as the only argument to the method, the logic of the ValueObject decides if this gives a fallback value or not.

##### Usage

Example below shows how this function can be used to get the Content name with exact same result as using `ez_content_name(content)`:

``` html
{{ ez_trans_prop( versionInfo, "name" ) }}
```

Example for `ContentType->names`:

``` html
{{ ez_trans_prop( contentType, "name" ) }}
```

#### `ez_urlalias`

##### Description

`ez_urlalias` is a not a real Twig helper, but a special route name for generating URLs for a Location from the given parameters.

##### Prototype and Arguments

`path(  eZ\\Publish\\API\\Repository\\Values\\Content\\Location|string name\[, array parameters\]\[, bool absolute\] )`

|Argument name|Type|Description|
|------|------|------|
|`name`|`string | \eZ\Publish\API\Repository\Values\Content\Location`|The name of the route or a Location instance|
|`parameters`|`array`|A hash of parameters:</br>`locationId`</br>`contentId`|
|`absolute`|`boolean`|Whether to generate an absolute URL|

##### Working with Location

Linking to other Locations is fairly easy and is done with the [native `path()` Twig helper](http://symfony.com/doc/2.3/book/templating.html#linking-to-pages) (or `url()` if you want to generate absolute URLs). You just have to pass it the Location object and `path()` will generate the URLAlias for you.

``` html
{# Assuming "location" variable is a valid eZ\Publish\API\Repository\Values\Content\Location object #}
<a href="{{ path( location ) }}">Some link to a location</a>
```

##### I don't have the Location object

###### Generating a link from a Location ID

``` html
<a href="{{ path( "ez_urlalias", {"locationId": 123} ) }}">Some link to a location, with its Id only</a>
```

###### Generating a link from a Content ID

``` html
<a href="{{ path( "ez_urlalias", {"contentId": 456} ) }}">Some link from a contentId</a>
```

!!! note

    Links generated from a Content ID will point to its main location.

##### Error management

For a Location alias set up a 301 redirect to the Location's current URL when:

1. the alias is historical
1. the alias is a custom one with forward flag true
1. the requested URL does not match the one loaded (case-sensitively)

!!! note "Under the hood"

        In the back end, `path()` uses the Router to generate links.

        This makes it also easy to generate links from PHP, via the `router` service.
