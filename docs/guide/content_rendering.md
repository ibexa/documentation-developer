# Content Rendering

## The ViewController

[[= product_name =]] comes with a native controller to display your content, known as the **`ViewController`**. It is called each time you try to reach a Content item from its **URL alias** (human-readable, translatable URI generated for any content based on URL patterns defined per Content Type). It is able to render any content created in the admin interface or via the [Public API Guide](../api/public_php_api.md).

It can also be called straight by its direct URI: 

`/view/content/<contentId>/full/true/<locationId>`

`/view/content/<contentId>`

A Content item can also have different **view types** (full page, abstract in a list, block in a Page, etc.). By default the view type is **full** (for full page), but it can be anything (*line*, *block, etc*.).

## Configuring views: the ViewProvider

The **ViewProvider** allows you to configure template selection when using the `ViewController`, either directly from a URL or via a sub-request.

#### Principle

The ViewProvider takes its configuration from your SiteAccess in the `content_view` section. This configuration is [necessary for views to be defined](templates.md#templating-basics) and is a hash built in the following way:

``` yaml
ezplatform:
    system:
        # Defines the scope: a valid SiteAccess, SiteAccess group or even "global"
        front_siteaccess:
            # Configuring the ViewProvider
            content_view:
                # The view type (full/line are standard, but you can use custom ones)
                full:
                    # A simple unique key for your matching ruleset
                    folderRuleset:
                        # The template identifier to load
                        template: full/small_folder.html.twig
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

    You can define your template selection rules, alongside other settings, in a different bundle.
    For details, see [Importing configuration from a bundle](organization.md#importing-configuration-from-a-bundle).

    You can also [use your own custom controller to render a Content/Location](controllers.md#custom-rendering-logic).

## View Matchers

To be able to select the right templates for the right conditions, the view provider uses matcher objects which implement the `eZ\Publish\Core\MVC\Symfony\View\ContentViewProvider\Configured\Matcher` interface.

##### Matcher identifier

The matcher identifier can comply to 3 different formats:

1. **Relative qualified class name** (e.g. `Identifier\ContentType`). This is the most common case, it is used for native matchers. It is relative to `eZ\Publish\Core\MVC\Symfony\Matcher\ContentBased`.
1. **Full qualified class name** (e.g. `\Foo\Bar\MyMatcher`). This is a way to specify a **custom matcher** that doesn't need specific dependency injection. Note that it **must** start with a backslash (`\`).
1. **Service identifier**, as defined in Symfony service container. This is the way to specify a **more complex custom matcher** that has dependencies.

!!! note "Injecting the Repository"

    If your matcher needs the repository, make it implement `eZ\Publish\Core\MVC\RepositoryAwareInterface` or extend the `eZ\Publish\Core\MVC\RepositoryAware` abstract class. The repository will then be correctly injected before matching.

##### Matcher value

The value associated with the matcher is passed to its `setMatchingConfig()` method. The value can be anything that is supported by the matcher.

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
|`Id\LocationRemote`|Matches the Remote ID number of a Location. *In the case of a Content item, matches against the main Location.*|
|`Id\ParentContentType`|Matches the ID number of the parent Content Type. *In the case of a Content item, matched against the main location.*|
|`Id\ParentLocation`|Matches the ID number of the parent Location. *In the case of a Content item, matched against the main location.*|
|`Id\Remote`|Matches the remoteId of either Content or Location, depending on the object matched.|
|`Id\Section`|	Matches the ID number of the Section that the Content item belongs to.|
|`Identifier\ContentType`|Matches the identifier of the Content Type that the Content item is an instance of.|
|`Identifier\ParentContentType`|Matches the identifier of the parent Content Type. *In the case of a Content item, matched against the main Location.*|
|`Identifier\Section`|Matches the identifier of the Section that the Content item belongs to.|
|`Depth`|Matches the depth of the Location. The depth of a top level Location is 1.|
|`UrlAlias`|Matches the virtual URL of the Location (i.e. `/My/Content-Uri`). **Important: Matches when the UrlAlias of the Location starts with the value passed.** *Not supported for Content (aka content_view).*|

### Custom matchers

Beside the built-in matchers, you can also use your own services to match views:

``` yaml
ezplatform:
    system:
        site:
            content_view:
                full:
                    folder:
                        template: folder.html.twig
                        match:
                            '@App\Matcher\MyMatcher': ~
```

The service must be tagged with `ezplatform.view.matcher`
and must implement `\eZ\Publish\Core\MVC\Symfony\Matcher\ContentBased\ViewMatcherInterface`. 

### Content view templates

#### Template variables

Every content view offers a set of variables you can use in templates and controllers.

You can view the whole list of variables by using the `dump()` Twig function in your template.
You can also dump a specific variable, for example `dump(location.id)`.

Main content-related variables include:

|Variable name|Type|Description|
|------|------|------|
|`content`|[eZ\Publish\Core\Repository\Values\Content\Content](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/Core/Repository/Values/Content/Content.php)|The Content item, containing all Fields and version information (VersionInfo)|
|`location`|[eZ\Publish\Core\Repository\Values\Content\Location](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Publish/Core/Repository/Values/Content/Location.php)|The Location object. Contains meta information on the Content (ContentInfo) (only when accessing a Location) |
|`no_layout`|Boolean|If true, indicates if the Content item/Location is to be displayed without any pagelayout (i.e. AJAX, sub-requests, etc.). It's generally `false` when displaying a Content item in view type **full**.|
|`view_base_layout`|String|The base layout template to use when the view is requested to be generated outside of the pagelayout (when `no_layout` is true).|

The `dump()` function also displays other variables, such as specific configuration including the SiteAccess
under the `ezplatform` key.

#### Template inheritance and sub-requests

Like any template, a content view template can use [template inheritance](http://symfony.com/doc/5.0/book/templating.html#template-inheritance-and-layouts). However keep in mind that your Content may be also requested via [sub-requests](https://symfony.com/doc/5.0/templates.html#embedding-controllers) (see below how to render [embedded Content items](templates.md#embedding-content-items)), in which case you probably don't want the global layout to be used.

If you use different templates for embedded content views, this should not be a problem. If you'd rather use the same template, you can use an extra `no_layout` view parameter for the sub-request, and conditionally extend an empty pagelayout:

``` html+twig
{% extends no_layout ? view_base_layout : "pagelayout.html.twig" %}

{% block content %}
...
{% endblock %}
```

#### Default view templates

Content view uses default templates to render content unless custom view rules are used.

Those templates can be customized by means of container- and SiteAccess-aware parameters.

##### Overriding the default template for common view types

Templates for the most common view types (content/full, line, embed, or block) can be customized by setting one the `ezplatform.default_view_templates` variables:

| Controller                                              | ViewType | Parameter                                         | Default value                                           |
|---------------------------------------------------------|----------|---------------------------------------------------|---------------------------------------------------------|
| `ez_content::viewAction`                                | `full`   | `ezplatform.default_view_templates.content.full`  | `'@@EzPublishCore/default/content/full.html.twig'`      |
| `ez_content::viewAction`                                | `line`   | `ezplatform.default_view_templates.content.line`  | `'@@EzPublishCore/default/content/line.html.twig'`      |
| `ez_content::viewAction`                                | `embed`  | `ezplatform.default_view_templates.content.embed` | `'@@EzPublishCore/default/content/embed.html.twig'`     |
| `ez_page::viewAction`                                   | `n/a`    | `ezplatform.default_view_templates.block`         | `'@@EzPublishCore/default/block/block.html.twig'`       |

###### Example

Add this configuration to `config/packages/ezplatform_admin_ui.yaml` to use `templates/content/view/full.html.twig` as the default template when viewing content with the `full` view type:

``` yaml
parameters:
    ezplatform.default_view_templates.content.full: "content/view/full.html.twig"
```

Alternatively, you can do it using the [design engine](design_engine.md). For example, if your theme is `site`,
create `themes/site/default/content/<viewType>.html.twig` to override the core template.


##### Customizing the default controller

The controller used to render content by default can also be changed. The `ezsettings.default.content_view_defaults` container parameter contains a hash that defines how content is rendered by default. It contains a set of [content view rules for the common view types](https://github.com/ezsystems/ezplatform-kernel/blob/v1.0.0/eZ/Bundle/EzPublishCoreBundle/Resources/config/default_settings.yml#L45-L73). This hash can be redefined to whatever suits your requirements, including custom controllers, or even matchers.

### View providers

The `ViewProvider` selects the right template (view type, correct parameters, etc.) for displaying a given Content item based on the configuration.

The ViewProviders are objects implementing the `eZ\Publish\Core\MVC\Symfony\View\ViewProvider` interface.

By default, the [Configured ViewProvider](#configuring-views-the-viewprovider) is used. It selects templates using the view configuration.

#### Custom ViewProvider

##### When to develop a custom `ViewProvider`

- You want a custom template selection based on a very specific state of your application
- You depend on external resources for view selection
- You want to override the default one view provider (based on configuration)

`ViewProvider` objects need to be properly registered in the service container with the `ezpublish.view_provider` service tag.

``` yaml
services:
    App\Content\MyViewProvider:
        tags:
            - {name: ezpublish.view_provider, type: eZ\Publish\Core\MVC\Symfony\View\ContentView, priority: 30}
```

`type` should point to a class implementing the `View\View` interface. It determines which type of View will be handled by the `ViewProvider`. Out of the box it's `eZ\Publish\Core\MVC\Symfony\View\ContentView`.

`priority` is an integer giving the priority to the `ViewProvider`. The priority range is from -255 to 255.

##### Example

``` php
// Custom ViewProvider
<?php
namespace App\Content;

use eZ\Publish\Core\MVC\Symfony\View\ContentView;
use eZ\Publish\Core\MVC\Symfony\View\View;
use eZ\Publish\Core\MVC\Symfony\View\ViewProvider;

class MyViewProvider implements ViewProvider
{
    const HOMEPAGE_ID = 2;
    const FOLDER_CONTENT_TYPE_ID = 1;

    /**
     * Returns a ContentView object, or null if not applicable
     *
     * @param \eZ\Publish\Core\MVC\Symfony\View\View $view
     *
     * @return \eZ\Publish\Core\MVC\Symfony\View\View|null
     */
    public function getView(View $view)
    {
        if (!$view instanceof ContentView) {
            return null;
        }

        $viewType = $view->getViewType();
        $location = $view->getLocation();
        // If you wish, you can also easily access Content object
        // $content = $view->getContent();

        // Let's check location Id
        if ($location->id === self::HOMEPAGE_ID) {
            // Special template for home page, passing "foo" variable to the template
            return new ContentView("$viewType/home.html.twig", ['foo' => 'bar']);
        }

        // And let's also check ContentType Id
        if ($location->contentInfo->contentTypeId === self::FOLDER_CONTENT_TYPE_ID) {
            // For view full, it will load full/small_folder.html.twig
            return new ContentView("$viewType/small_folder.html.twig");
        }

        return null;
    }
}
```

## Events

This section presents the events that are triggered by [[= product_name =]].

### Core

|Event name|Triggered when...|Usage|
|-------|------|------|
|`ezpublish.siteaccess`|After the SiteAccess matching has occurred.|Gives further control on the matched SiteAccess. The event listener method receives an `eZ\Publish\Core\MVC\Symfony\Event\PostSiteAccessMatchEvent` object.|
|`ezpublish.pre_content_view`|Right before a view is rendered for a Content item, via the content view controller.|This event is triggered by the view manager and allows you to inject additional parameters to the content view template. The event listener method receives an `eZ\Publish\Core\MVC\Symfony\Event\PreContentViewEvent` object.|
|`ezpublish.api.contentException`|The API throws an exception that could not be caught internally (missing field type, internal error...).|This event allows further programmatic handling (like rendering a custom view) for the exception thrown. The event listener method receives an `eZ\Publish\Core\MVC\Symfony\Event\APIContentExceptionEvent object`.|

## Reference

### Twig Helper

[[= product_name =]] comes with a Twig helper as a [global variable](http://symfony.com/doc/5.0/cookbook/templating/global_variables.html) named `ezplatform`.

This helper is accessible from all Twig templates and allows you to easily retrieve useful information.

|Property|Description|
|------|------|
|`ezplatform.siteaccess`|Returns the current SiteAccess.|
|`ezplatform.rootLocation`|Returns the root Location object.|
|`ezplatform.requestedUriString`|Returns the requested URI string (also known as semanticPathInfo).|
|`ezplatform.systemUriString`|	Returns the "system" URI string. System URI is the URI for internal content controller. If current route is not a URL alias, then the current Pathinfo is returned.|
|`ezplatform.viewParameters`|Returns the view parameters as a hash.|
|`ezplatform.viewParametersString`|Returns the view parameters as a string.|
|`ezplatform.translationSiteAccess`|Returns the translation SiteAccess for a given language, or null if it cannot be found.|
|`ezplatform.availableLanguages`|Returns the list of available languages.|
|`ezplatform.configResolver`|Returns the config resolver.|
