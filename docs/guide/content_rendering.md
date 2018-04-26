# Content rendering

## The ViewController

eZ Platform comes with a native controller to display your content, known as the **`ViewController`**. It is called each time you try to reach a Content item from its **Url Alias** (human-readable, translatable URI generated for any content based on URL patterns defined per Content Type). It is able to render any content created in the admin interface or via the [Public API Guide](../api/public_php_api.md#public-api-guide).

It can also be called straight by its direct URI:

`/view/content/<contentId>/full/true/<locationId>`

`/view/content/<contentId>`

A Content item can also have different **view types** (full page, abstract in a list, block in a landing page, etc.). By default the view type is **full** (for full page), but it can be anything (*line*, *block, etc*.).

## Configuring views: the ViewProvider

The **ViewProvider** allows you to configure template selection when using the `ViewController`, either directly from a URL or via a sub-request.

### Principle

The ViewProvider takes its configuration from your SiteAccess in the `content_view` section. This configuration is [necessary for views to be defined](templates.md#templating-basics) and is a hash built in the following way:

``` yaml
#app/config/ezplatform.yml
ezpublish:
    system:
        # Defines the scope: a valid SiteAccess, SiteAccess group or even "global"
        front_siteaccess:
            # Configuring the ViewProvider
            content_view:
                # The view type (full/line are standard, but you can use custom ones)
                full:
                    # A simple unique key for your matching ruleset
                    folderRuleset:
                        # The template identifier to load, following the Symfony bundle notation for templates
                        # See http://symfony.com/doc/current/book/controller.html#rendering-templates
                        template: eZDemoBundle:full:small_folder.html.twig
                        # Hash of matchers to use, with their corresponding values to match against
                        match:
                            # The key defines the matcher rule (class name or service identifier)
                            # The value will be passed to the matcher's setMatchingConfig() method.
                            Identifier\ContentType: [small_folder, folder]
```

!!! caution "Template matching and non-existent Field Types"

    **Template matching will NOT work if your content contains a Field Type that is not supported by the repository**. It can happen when you are in the process of migrating from eZ Publish 4.x, where custom datatypes have been developed.

    In this case the repository will throw an exception, which is caught in the `ViewController`, and *if* you are using Legacy Bridge it will end up doing a [fallback to legacy kernel](https://doc.ez.no/display/EZP/Legacy+template+fallback).

    The list of Field Types supported out of the box [is available here](../api/field_type_reference.md).

!!! tip

    You can define your template selection rules, alongside other settings, in a different bundle. [Read the cookbook recipe to learn more about it](../cookbook/importing_settings_from_a_bundle.md).

    You can also [use your own custom controller to render a Content/Location](controllers.md#custom-controllers).

## View Matchers

To be able to select the right templates for the right conditions, the view provider uses matcher objects which implement the `eZ\Publish\Core\MVC\Symfony\View\ContentViewProvider\Configured\Matcher` interface.

##### Matcher identifier

The matcher identifier can comply to 3 different formats:

1. **Relative qualified class name** (e.g. `Identifier\ContentType`). This is the most common case, it is used for native matchers. It is relative to `eZ\Publish\Core\MVC\Symfony\Matcher\ContentBased`.
1. **Full qualified class name** (e.g. `\Foo\Bar\MyMatcher`). This is a way to specify a **custom matcher** that doesn't need specific dependency injection. Note that it **must** start with a backslash (`\`).
1. **Service identifier**, as defined in Symfony service container. This is the way to specify a **more complex custom matcher** that has dependencies.

!!! note "Injecting the Repository"

    If your matcher needs the repository, make it implement `eZ\Publish\Core\MVC\RepositoryAwareInterface` or extend the `eZ\Publish\Core\MVC\RepositoryAware` abstract class. The repository will then be correctly injected before matching.

##### Matcher value

The value associated with the matcher is passed to its `setMatchingConfig()` method. The value can be anything that is supported by the matcher.

!!! note

    Native matchers support both **scalar values** or **arrays of scalar values**. Passing an array amounts to applying a logical OR.

##### Combining matchers

It is possible to combine multiple matchers:

``` yaml
# ...
match:
    Identifier\ContentType: [small_folder, folder]
    Identifier\ParentContentType: frontpage
```

The example above can be translated as "Match any content whose **ContentType** identifier is `small_folder` OR `folder` , **AND** having `frontpage` as **ParentContentType** identifier".

#### Available matchers

The following table presents all native matchers.

|Identifier|Description|
|------|------|
|`Id\Content`|Matches the ID number of the Content item.|
|`Id\ContentType`|Matches the ID number of the Content Type that the Content item is an instance of.|
|`Id\ContentTypeGroup`|Matches the ID number of the group containing the Content Type that the Content item is an instance of.|
|`Id\Location`|Matches the ID number of a Location. *In the case of a Content item, matched against the main location.*|
|`Id\ParentContentType`|Matches the ID number of the parent Content Type. *In the case of a Content item, matched against the main location.*|
|`Id\ParentLocation`|Matches the ID number of the parent Location. *In the case of a Content item, matched against the main location.*|
|`Id\Remote`|Matches the remoteId of either Content or Location, depending on the object matched.|
|`Id\Section`|	Matches the ID number of the Section that the Content item belongs to.|
|`Identifier\ContentType`|Matches the identifier of the Content Type that the Content item is an instance of.|
|`Identifier\ParentContentType`|Matches the identifier of the parent Content Type. *In the case of a Content item, matched against the main Location.*|
|`Identifier\Section`|Matches the identifier of the Section that the Content item belongs to.|
|`Depth`|Matches the depth of the Location. The depth of a top level Location is 1.|
|`UrlAlias`|Matches the virtual URL of the Location (i.e. `/My/Content-Uri`). **Important: Matches when the UrlAlias of the Location starts with the value passed.** *Not supported for Content (aka content_view).*|

### Content view templates

#### Available variables

|Variable name|Type|Description|
|------|------|------|
|`location`|[eZ\Publish\Core\Repository\Values\Content\Location](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/Repository/Values/Content/Location.php)|The Location object. Contains meta information on the Content (ContentInfo) (only when accessing a Location) |
|`content`|[eZ\Publish\Core\Repository\Values\Content\Content](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/Core/Repository/Values/Content/Content.php)|The Content item, containing all Fields and version information (VersionInfo)|
|`noLayout`|Boolean|If true, indicates if the Content item/Location is to be displayed without any pagelayout (i.e. AJAX, sub-requests, etc.). It's generally `false` when displaying a Content item in view type **full**.|
|`viewBaseLayout`|String|The base layout template to use when the view is requested to be generated outside of the pagelayout (when `noLayout` is true).|

#### Template inheritance and sub-requests

Like any template, a content view template can use [template inheritance](http://symfony.com/doc/current/book/templating.html#template-inheritance-and-layouts). However keep in mind that your Content may be also requested via [sub-requests](http://symfony.com/doc/current/book/templating.html#embedding-controllers) (see below how to render [embedded Content items](templates.md#embedding-content-items)), in which case you probably don't want the global layout to be used.

If you use different templates for embedded content views, this should not be a problem. If you'd rather use the same template, you can use an extra `noLayout` view parameter for the sub-request, and conditionally extend an empty pagelayout:

``` html
{% extends noLayout ? viewbaseLayout : "AcmeDemoBundle::pagelayout.html.twig" %}

{% block content %}
...
{% endblock %}
```

#### Default view templates

Content view uses default templates to render content unless custom view rules are used.

Those templates can be customized by means of container- and SiteAccess-aware parameters.

##### Overriding the default template for common view types

Templates for the most common view types (content/full, line, embed, or block) can be customized by setting one the `ezplatform.default.content_view_templates` variables:

| Controller                                              | ViewType | Parameter                                         | Default value                                           |
|---------------------------------------------------------|----------|---------------------------------------------------|---------------------------------------------------------|
| `ez_content:viewAction`                                 | `full`   | `ezplatform.default_view_templates.content.full`  | `"EzPublishCoreBundle:default:content/full.html.twig"`  |
| `ez_content:viewAction`                                 | `line`   | `ezplatform.default_view_templates.content.line`  | `"EzPublishCoreBundle:default:content/line.html.twig"`  |
| `ez_content:viewAction`                                 | `embed`  | `ezplatform.default_view_templates.content.embed` | `"EzPublishCoreBundle:default:content/embed.html.twig"` |
| `ez_page:viewAction`                                    | `n/a`    | `ezplatform.default_view_templates.block`         | `"EzPublishCoreBundle:default:block/block.html.twig"`   |

###### Example

Add this configuration to `app/config/config.yml` to use `app/Resources/content/view/full.html.twig` as the default template when viewing Content with the `full` view type:

``` yaml
parameters:
    ezplatform.default_view_templates.content.full: "content/view/full.html.twig"
```

##### Customizing the default controller

The controller used to render content by default can also be changed. The `ezsettings.default.content_view_defaults` container parameter contains a hash that defines how content is rendered by default. It contains a set of [content view rules for the common view types](https://github.com/ezsystems/ezpublish-kernel/blob/v6.0.0/eZ/Bundle/EzPublishCoreBundle/Resources/config/default_settings.yml#L21-L33). This hash can be redefined to whatever suits your requirements, including custom controllers, or even matchers.

### Content and Location view providers

#### View\\Manager & View\\Provider

The role of the `(eZ\Publish\Core\MVC\Symfony\)View\Manager` is to select the right template for displaying a given Content item or Location. It aggregates objects called *Content and Location view providers* which respectively implement the `eZ\Publish\Core\MVC\Symfony\View\Provider\Content` and `eZ\Publish\Core\MVC\Symfony\View\Provider\Location` interfaces.

Each time a Content item is to be displayed through the `Content\ViewController`, the `View\Manager` iterates over the registered Content or Location `View\Provider` objects and calls `getView()`.

##### Provided View\\Provider implementations

|Name|Usage|
|------|------|
|[View provider configuration](#configuring-views-the-viewprovider)|Based on application configuration. Formerly known as *Template override system*.|
|`eZ\Publish\Core\MVC\Legacy\View\Provider\Content`, `eZ\Publish\Core\MVC\Legacy\View\Provider\Location`|Forwards view selection to the legacy kernel by running the old content/view module. Pagelayout used is the one configured in `ezpublish_legacy.<scope>.view_default_layout`. For more details about the `<scope>` please refer to the [scope configuration documentation](siteaccess.md#scope).|

#### Custom View\\Provider

##### Difference between `View\Provider\Location` and `View\Provider\Content`

- A `View\Provider\Location` only deals with `Location` objects and implements the `eZ\Publish\Core\MVC\Symfony\View\Provider\Location` interface.
- A `View\Provider\Content` only deals with `ContentInfo` objects and implements the `eZ\Publish\Core\MVC\Symfony\View\Provider\Content` interface.

##### When to develop a custom `View\Provider\(Location|Content)`

- You want a custom template selection based on a very specific state of your application
- You depend on external resources for view selection
- You want to override the default one view provider (based on configuration)

`View\Provider` objects need to be properly registered in the service container with the `ezpublish.location_view_provider` or `ezpublish.content_view_provider` service tag.

``` yaml
parameters:
    acme.location_view_provider.class: Acme\DemoBundle\Content\MyLocationViewProvider

services:
    acme.location_view_provider:
        class: %ezdemo.location_view_provider.class%
        tags:
            - {name: ezpublish.location_view_provider, priority: 30}
```

`priority` is an integer giving the priority to the `View\Provider\(Content|Location)` in the `View\Manager`. The priority range is from -255 to 255.

##### Example

``` php
// Custom View\Provider\Location
<?php
namespace Acme\DemoBundle\Content;

use eZ\Publish\Core\MVC\Symfony\View\ContentView;
use eZ\Publish\Core\MVC\Symfony\View\Provider\Location as LocationViewProvider;
use eZ\Publish\API\Repository\Values\Content\Location;

class MyLocationViewProvider implements LocationViewProvider
{
    /**
     * Returns a ContentView object corresponding to $location, or void if not applicable
     *
     * @param \eZ\Publish\API\Repository\Values\Content\Location $location
     * @param string $viewType
     * @return \eZ\Publish\Core\MVC\Symfony\View\ContentView|null
     */
    public function getView( Location $location, $viewType )
    {
        // Let's check location Id
        switch ( $location->id )
        {
            // Special template for home page, passing "foo" variable to the template
            case 2:
                return new ContentView( "AcmeDemoBundle:$viewType:home.html.twig", [ 'foo' => 'bar' ] );
        }

        // ContentType identifier (formerly "class identifier")
        switch ( $location->contentInfo->contentType->identifier )
        {
            // For view full, it will load AcmeDemoBundle:full:small_folder.html.twig
            case 'folder':
                return new ContentView( "AcmeDemoBundle:$viewType:small_folder.html.twig" );
        }
    }
}
```

## Events

This section presents the events that are triggered by eZ Platform.

### eZ Publish Core

|Event name|Triggered when...|Usage|
|-------|------|------|
|`ezpublish.siteaccess`|After the SiteAccess matching has occurred.|Gives further control on the matched SiteAccess. The event listener method receives an `eZ\Publish\Core\MVC\Symfony\Event\PostSiteAccessMatchEvent` object.|
|`ezpublish.pre_content_view`|Right before a view is rendered for a Content item, via the content view controller.|This event is triggered by the view manager and allows you to inject additional parameters to the content view template. The event listener method receives an `eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent` object.|
|`ezpublish.api.contentException`|The API throws an exception that could not be caught internally (missing field type, internal error...).|This event allows further programmatic handling (like rendering a custom view) for the exception thrown. The event listener method receives an `eZ\Publish\Core\MVC\Symfony\Event\APIContentExceptionEvent object`.|

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
