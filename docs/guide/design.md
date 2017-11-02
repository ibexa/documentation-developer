# Design

!!! tip

    This page covers design in eZ Platform in a general aspect. If you want to learn how to display content and build your content templates, check [Content Rendering](content_rendering.md).

## Design basics

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

## Creating a new design using Bundle Inheritance

Due to the fact that eZ Platform is built using the Symfony 2 framework, it is possible to benefit from most of its stock features such as Bundle Inheritance. To learn more about this concept in general, check out the [related Symfony documentation](http://symfony.com/doc/current/cookbook/bundles/override.html).

Bundle Inheritance allows you to customize a template from a parent bundle. This is very convenient when creating a custom design for an already existing piece of code.

The following example shows how to create a customized version of a template from the DemoBundle.

### Creating a bundle

Create a new bundle to host your design using the dedicated command (from your app installation):

``` bash
php app/console generate:bundle
```

### Configuring bundle to inherit from another

Following the related [Symfony documentation](http://symfony.com/doc/current/cookbook/bundles/inheritance.html), modify your bundle to make it inherit from the "eZDemoBundle". Then copy a template from the DemoBundle in the new bundle, following the same directory structure. Customize this template, clear application caches and reload the page. You custom design should be available.

### Known limitation

If you are experiencing problems with routes not working after adding your bundle, take a look at [this issue](https://jira.ez.no/browse/EZP-23575).

## Reference

### Twig Helper

eZ Platform comes with a Twig helper as a [global variable](http://symfony.com/doc/master/cookbook/templating/global_variables.html) named `ezpublish`.

This helper is accessible from all Twig templates and allows you to easily retrieve useful information.

|Property|Description|
|------|------|
|`ezpublish.siteaccess`|Returns the current SiteAccess.|
|`ezpublish.rootLocation`|Returns the root Location object.|
|`ezpublish.requestedUriString`|Returns the requested URI string (also known as semanticPathInfo).|
|`ezpublish.systemUriString`|	Returns the "system" URI string. System URI is the URI for internal content controller. If current route is not an URLAlias, then the current Pathinfo is returned.|
|`ezpublish.viewParameters`|Returns the view parameters as a hash.|
|`ezpublish.viewParametersString`|Returns the view parameters as a string.|
|`ezpublish.legacy`|Returns legacy information.|
|`ezpublish.translationSiteAccess`|Returns the translation SiteAccess for a given language, or null if it cannot be found.|
|`ezpublish.availableLanguages`|Returns the list of available languages.|
|`ezpublish.configResolver`|Returns the config resolver.|

#### Legacy property

The `ezpublish.legacy` property returns an object of type [ParameterBag](http://api.symfony.com/2.8/Symfony/Component/HttpFoundation/ParameterBag.html), which is a container for key/value pairs, and contains additional properties to retrieve/handle legacy information.

!!! note

    `ezpublish.legacy` is only available **when viewing content in legacy fallback** (e.g. no corresponding Twig templates).
    See [5.x documentation](https://doc.ez.no/display/EZP/Twig+Helper#TwigHelper-Legacy) for more information.

## Design engine

You can provide design themes for your eZ application, with an automatic fallback system
using the design engine from the [ezplatform-design-engine](https://github.com/ezsystems/ezplatform-design-engine) bundle.
It is very similar to the [eZ Publish legacy design fallback system](https://doc.ez.no/eZ-Publish/Technical-manual/5.x/Concepts-and-basics/Designs/Design-combinations).

When you call a given template or asset, the system will look for it in the first configured theme.
If it cannot be found, the system will fall back to all other configured themes for your current SiteAccess.

Under the hood, the theming system uses Twig namespaces. As such, Twig is the only supported template engine.
For assets, the system uses the Symfony Asset component with asset packages.

### Terminology

- **Theme**: A labeled collection of templates and assets.

  Typically a directory containing templates. For example, templates located under `app/Resources/views/themes/my_theme`
  or `src/AppBundle/Resources/views/themes/my_theme` are part of `my_theme` theme.

- **Design**: A collection of themes.

  The order of themes within a design is important as it defines the fallback order.
  A design is identified with a name. One design can be used per SiteAccess.

### Configuration

To define and use a design, you need to:

1. Declare it, with a name and a collection of themes to use
1. Use it for your SiteAccess

Here is a simple example:

```yaml
# ezplatform.yml
ezdesign:
    # You declare all available designs under "design_list".
    design_list:
        # my_design will be composed of "theme1" and "theme2"
        # "theme1" will be tried first. If a template cannot be found in "theme1", "theme2" will be tried out.
        my_design: [theme1, theme2]

ezpublish:
    # ...
    system:
        my_siteaccess:
            # my_siteaccess will use "my_design"
            design: my_design
```

!!! note

    Default design for a SiteAccess is `standard` which contains no themes.
    If you use the `@ezdesign` Twig namespace and/or the `ezdesign` asset package, the system will always fall back to
    application level and override directories for templates/assets lookup.

### Referencing current design

It is possible to reference current design in order to inject it into a service.
To do so, you just need to reference the `$design$` dynamic setting:

```yaml
services:
    my_service:
        class: Foo\Bar
        arguments: ["$design$"]
```

It is also possible to use the `ConfigResolver` service (`ezpublish.config.resolver`):

```php
// In a controller
$currentDesign = $this->getConfigResolver->getParameter('design');
```

### Design usage with assets

For assets, a special **`ezdesign` asset package** is available.

```jinja
<script src="{{ asset("js/foo.js", "ezdesign") }}"></script>

<link rel="stylesheet" href="{{ asset("js/foo.css", "ezdesign") }}" media="screen" />

<img src="{{ asset("images/foo.png", "ezdesign") }}" alt="foo"/>
```

Using the `ezdesign` package will resolve current design with theme fallback.

By convention, an asset theme directory can be located in:
- `<bundle_directory>/Resources/public/themes/`
- `web/assets/themes/`

Typical paths can be for example:
- `<bundle_directory>/Resources/public/themes/foo/` => Assets will be part of the `foo` theme.
- `<bundle_directory>/Resources/public/themes/bar/` => Assets will be part of the `bar` theme.
- `web/assets/themes/biz/` => Assets will be part of the `biz` theme.

It is also possible to use `web/assets` as a global override directory.
If called asset is present **directly under this directory**, it will always be considered first.

!!! caution

    You must have *installed* your assets with `assets:install` command, so that your public resources are
    *installed* into the `web/` directory.

#### Fallback order

The default fallback order is:
- Application assets directory: `web/assets/`
- Application theme directory: `web/assets/themes/<theme_name>/`
- Bundle theme directory: `web/bundles/<bundle_directory>/themes/<theme_name>/`

Calling `asset("js/foo.js", "ezdesign")` can for example be resolved to `web/bundles/app/themes/my_theme/js/foo.js`.

#### Performance and asset resolution

When using themes, paths for assets are resolved at runtime.
This is due to how the Symfony Asset component is integrated with Twig.
This can cause significant performance impact because of I/O calls when looping over all potential theme directories,
especially when using a lot of different designs and themes.

To work around this issue, assets resolution can be provisioned at compilation time.
Provisioning is the **default behavior in non-debug mode** (e.g. `prod` environment).
In debug mode (e.g. `dev` environment), assets are being resolved at runtime.

This behavior can, however, be controlled by the `disable_assets_pre_resolution` setting.

```yaml
# ezplatform_prod.yml
ezdesign:
    # Force runtime resolution
    # Default value is '%kernel.debug%'
    disable_assets_pre_resolution: true
```

### Design usage with templates

By convention, a theme directory must be located under `<bundle_directory>/Resources/views/themes/` or global
`app/Resources/views/themes/` directories.

Typical paths can be for example:
- `app/Resources/views/themes/foo/` => Templates will be part of the `foo` theme.
- `app/Resources/views/themes/bar/` => Templates will be part of the `bar` theme.
- `src/AppBundle/Resources/views/themes/foo/` => Templates will be part of the `foo`theme.
- `src/Acme/TestBundle/Resources/views/themes/the_best/` => Templates will be part of `the_best` theme.

In order to use the configured design with templates, you need to use the **`@ezdesign`** special **Twig namespace**.

```jinja
{# Will load 'some_template.html.twig' directly under one of the specified theme directories #}
{{ include("@ezdesign/some_template.html.twig") }}

{# Will load 'another_template.html.twig', located under 'full/' directory, which is located under one of the specified theme directories #}
{{ include("@ezdesign/full/another_template.html.twig") }}
```

You can also use `@ezdesign` notation in your eZ template selection rules:

```yaml
ezpublish:
    system:
        my_siteaccess:
            content_view:
                full:
                    home:
                        template: "@ezdesign/full/home.html.twig"
```

!!! tip

    You may also use this notation in controllers.

#### Fallback order

The default fallback order is:
- Application view directory: `app/Resources/views/`
- Application theme directory: `app/Resources/views/themes/<theme_name>/`
- Bundle theme directory: `src/<bundle_directory>/Resources/views/themes/<theme_name>/`

!!! note

    Bundle fallback order is the instantiation order in `AppKernel`.

##### Additional theme paths

In addition to the convention described above, it is also possible to add arbitrary Twig template directories
to a theme from configuration. This can be useful when you want to define templates from third-party bundles
as part of one of your themes, or when upgrading your application in order to use eZ Platform design engine,
when your existing templates are not yet following the convention.

```yaml
ezdesign:
    design_list:
        my_design: [my_theme, some_other_theme]
    templates_theme_paths:
        # FOSUserBundle templates will be part of "my_theme" theme
        my_theme:
            - '%kernel.root_dir%/../vendor/friendsofsymfony/user-bundle/Resources/views'
```

!!! note "Paths precedence"

    Directories following the convention will **always** have precedence over the ones defined
    in config. This ensures that it is always possible to override a template from the application.

##### Additional override paths

It is possible to add additional global override directories, similar to `app/Resources/views/`.

```yaml
ezdesign:
    templates_override_paths:
        - "%kernel.root_dir%/another_override_directory"
        - "/some/other/directory"
```

!!! note

    `app/Resources/views/` will **always** be the top level override directory.

#### PHPStorm support

`@ezdesign` Twig namespace is a *virtual* namespace, and as such is not automatically recognized by the PHPStorm Symfony plugin
for `goto` actions.

`EzPlatformDesignEngine` will generate a `ide-twig.json` file which will contain all detected theme paths for templates in your project.
It is activated by default in debug mode (`%kernel.debug%`).

By default, this config file will be stored at your project root (`%kernel.root_dir%/..`), but you can customize the path
if your PHPStorm project root doesn't match your Symfony project root.

!!! note

    `ide-twig.json` **must** be stored at your PHPStorm project root.

Default config:

```yaml
ezdesign:
    phpstorm:

        # Activates PHPStorm support
        enabled:              '%kernel.debug%'

        # Path where to store PHPStorm configuration file for additional Twig namespaces (ide-twig.json).
        twig_config_path:     '%kernel.root_dir%/..'
```
