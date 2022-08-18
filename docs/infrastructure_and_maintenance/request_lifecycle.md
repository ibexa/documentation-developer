---
description: See the lifecycle of an HTTP request in Ibexa DXP, from request to response.
---

# Request lifecycle: from request to response


## Beginning of HTTP request

When entering the server infrastructure, the HTTP request can be handled by several component such as a firewall, a load balancer, or a reverse proxy before arriving on the web server itself.

For an overview of what happens on a reverse proxy like Varnish or Fastly, see [Context-aware HTTP cache / Request lifecycle](context_aware_cache.md#request-lifecycle).

When arriving at a web server, the request is filtered by Apache Virtual Host, Nginx Server Blocks or equivalent. There, requests of static resources are separated from requests to PHP interpreter.

As [[= product_name =]] is a Symfony application, the handling of requests starts like in Symfony (see [Symfony and HTTP Fundamentals](https://symfony.com/doc/current/introduction/http_fundamentals.html)).

If the HTTP request is to be treated by [[= product_name =]], it goes to the `public/index.php` of the [Symfony Front Controller](https://symfony.com/doc/current/configuration/front_controllers_and_kernel.html#the-front-controller).

The front controller transforms the HTTP request into a PHP [`Request` object](https://symfony.com/doc/current/introduction/http_fundamentals.html#symfony-request-object) and passes it to Symfony's Kernel to get a [`Response` object](https://symfony.com/doc/current/introduction/http_fundamentals.html#symfony-response-object) that is transformed and sent back as an HTTP response.

The schemas start with a regular `Request` object from a browser that enters Symfony and [[= product_name =]]. There is no ESI, no REST, and no GraphQL request performed.


## Lifecycle flowcharts

### Concept flowchart

The chart below introduces the logic of the request treatment.

![Simplified request lifecycle flowchart](request_lifecycle_concept.png)

### Kernel events flowchart

The following chart shows events, listeners and attributes added to the request or its wrapping event object.

![Detailed request lifecycle flowchart organised around kernel events](request_lifecycle_events.png){: width="741" height="2061" style="max-height: none;"}

This schema is described below event by event.

!!! tip

    To list all listeners that listen to an event, run `php bin/console debug:event-dispatcher <event.name>`, for example:
    
    ```bash
    php bin/console debug:event-dispatcher kernel.request
    ```
    
    To view details of a service (including class, arguments and tags), run `php bin/console debug:container --show-arguments <service.name>`, for example:
    
    ```bash
    php bin/console debug:container --show-arguments ibexa.siteaccess_match_listener`
    ```
    
    To list all services with a specific tag, run `php bin/console debug:container --tag=<tag>`, for example:
    
    ```bash
    php bin/console debug:container --tag=router
    ```


## Kernel's request event

When the request enters the Symfony's kernel (and goes underneath the [`HttpKernel`](https://symfony.com/doc/current/components/http_kernel.html), `http_kernel`), a `kernel.request` event (`KernelEvents::REQUEST`) is dispatched.
Several listeners are called in decreasing priority.

### SiteAccess matching

The [`FragmentListener`](https://github.com/symfony/http-kernel/blob/5.3/EventListener/FragmentListener.php) (priority 48) handles the request first, and then it passes to the `ibexa.siteaccess_match_listener` service (priority 45).
This service can be either:

- purely the `SiteAccessMatchListener` or
- its `UserContextSiteAccessMatchSubscriber` decoration when HTTP cache is used.

The `ibexa.siteaccess_match_listener` service:

- finds the current SiteAccess using the `SiteAccess\Router` (`Ibexa\Core\MVC\Symfony\SiteAccess\Router`) regarding the [SiteAccess Matching configurations](siteaccess_matching.md),
- adds the current SiteAccess to the `Request` object's **`siteaccess`** attribute,
- then dispatches the `Ibexa\Core\MVC\Symfony\SiteAccess` event (`MVCEvents::SITEACCESS`).

The `SiteAccessListener` (`Ibexa\Bundle\Core\EventListener\SiteAccessListener`) subscribes to this `Ibexa\Core\MVC\Symfony\SiteAccess` event with top priority (priority 255).
The `SiteAccessListener` adds the **`semanticPathinfo`** attribute, the path without SiteAccess indications ([`URIElement`](siteaccess_matching.md#urielement), [`URIText`](siteaccess_matching.md#uritext),
or [`Map\URI`](siteaccess_matching.md#mapuri) implementing the `URILexer` interface) to the request.

### Routing

Finally, the `Symfony\Component\HttpKernel\EventListener\RouterListener` (`router_listener`) (priority 32), which also listens to the `kernel.request` event,
calls `Ibexa\Core\MVC\Symfony\Routing\ChainRouter::matchRequest` and adds its returned parameters to the request.

#### `ChainRouter`

The [`ChainRouter`](https://symfony.com/doc/current/cmf/components/routing/chain.html) is a Symfony Content Management Framework (CMF) component. [[= product_name =]] makes it a service named `Ibexa\Core\MVC\Symfony\Routing\ChainRouter`.
It has a collection of prioritized routers where to find one matching the request.
The `ChainRouter` router collection is built by the `ChainRoutingPass`, collecting the services tagged `router`.
The `DefaultRouter` is always added to the collection with top priority (priority 255).

#### `DefaultRouter`

`DefaultRouter` (`router.default`):
The `DefaultRouter` tries to match the `semanticPathinfo` against routes, close to [the way pure Symfony does](https://symfony.com/doc/current/routing.html), by extending and using `Symfony\Component\Routing\Router`.
If a route matches, the controller associated with it is responsible for building a `View` or `Response` object.

### `UrlWildcardRouter`

`UrlWildcardRouter` (`ezpublish.urlwildcard_router`):
If [URL Wildcards](url_management.md#url-wildcards) have been enabled, then the `URLWildcardRouter` is the next router tried.
If a wildcard matches, the request's `semanticPathinfo` is updated and the router throws a `ResourceNotFoundException` to continue with the `ChainRouter` collection's next entry.

### `UrlAliasRouter`

`UrlAliasRouter` (`Ibexa\Bundle\Core\Routing\UrlAliasRouter`):
This router uses the `UrlAliasService` to associate the `semanticPathinfo` to a Location.
If it finds a Location, the request receives the attributes **`locationId`** and **`contentId`**, **`viewType`** is set to `full`, and the **`_controller`** is set to `ibexa_content:viewAction` for now.

The `locale_listener` (priority 16) sets the request's **`_locale`** attribute.

!!! note "Permission control"

    Another `kernel.request` event listener is the `Ibexa\AdminUi\EventListener\RequestListener` (priority 13).
    When a route gets a `siteaccess_group_whitelist` parameter, this listener checks that the current SiteAccess is in one of the listed groups.
    For example, the Back Office sets an early protection of its routes by passing them a `siteaccess_group_whitelist` containing only the `admin_group`.

Now, when the `Request` knows its controller, the `HttpKernel` dispatches the `kernel.controller` event.


## Kernel's controller event

### View building and matching

When HttpKernel dispatches the `kernel.controller` event, the following things happen.

Listening to `kernel.controller`, the `ViewControllerListener` (`Ibexa\Bundle\Core\EventListener\ViewControllerListener`) (priority 10) checks if the `_controller` request attribute is associated with a `ViewBuilder` (a service tagged `ibexa.view.builder`) in the `ViewBuilderRegistry` (`Ibexa\Core\MVC\Symfony\View\Builder\Registry\ControllerMatch`).
The `ContentViewBuilder` (`Ibexa\Core\MVC\Symfony\View\Builder\ContentViewBuildercontent`) matches on controller starting with `ibexa_content:` (see `Ibexa\Core\MVC\Symfony\View\Builder\ContentViewBuilder::matches`).
The `ContentViewBuilder` builds a `ContentView`.

First, the `ContentViewBuilder` loads the `Location` and the `Content`, and adds them to the `ContentView` object.

!!! caution "Permission control"

    `content/read` and/or `content/view_embed` permissions are controlled during this `ContentView` building.

Then, the `ContentViewBuilder` passes the `ContentView` to its `View\Configurator` (`Ibexa\Core\MVC\Symfony\View\Configurator\ViewProvider`).
It's implemented by the `View\Configurator\ViewProvider` and its `View\Provider\Registry`. This registry receives the services tagged `ibexa.view.provider` thanks to the `ViewProviderPass`.
Among the view providers, the services using the `Ibexa\Bundle\Core\View\Provider\Configured` have an implementation of the `MatcherFactoryInterface` (`ibexa.content_view.matcher_factory`).
Through service decoration and class inheritance, the `ClassNameMatcherFactory` is responsible for the [view matching](template_configuration.md#view-rules-and-matching).
The `View\Configurator\ViewProvider` uses the matched view rule to add possible **`templateIdentifier`** and **`controllerReference`** to the `ContentView` object.

The `ViewControllerListener` adds the ContentView to the `Request` as the **`view`** attribute.
The `ViewControllerListener` eventually updates the request's `_controller` attribute with the `ContentView`'s `controllerReference`.

The `HttpKernel` then dispatches a `kernel.controller_arguments` (`KernelEvents::CONTROLLER_ARGUMENTS`) but nothing from [[= product_name =]] is listening to it.


## Controller execution

The `HttpKernel` extracts from the request the controller and the arguments to pass to the controller. [Argument resolvers](https://symfony.com/doc/current/controller/argument_value_resolver.html) work in a way similar to autowiring.
The `HttpKernel` executes the controller with those arguments.

As a reminder, the controller and its argument can be:

- A controller set by the matched route and the request as its argument.
- The default `ibexa_content:viewAction` controller and a `ContentView` as its argument.
- A [custom controller](controllers.md) set by the matched view rule and a `View` or the request as its argument (most likely a `ContentView` but there is no restriction).

!!! caution "Permission control"

    See [Permissions for custom controller](permissions.md#permissions-for-custom-controllers).


## Kernel's view event and `ContentView` rendering

If the controller returns something other than `Response`, the `HttpKernel` dispatches a `kernel.view` event (`KernelEvents::VIEW`).
In the case of a URL Alias, the controller most likely returns a ContentView.
The `ViewRendererListener` (`Ibexa\Bundle\Core\EventListener\ViewRendererListener`) uses the `ContentView` and the `TemplateRenderer` (`Ibexa\Core\MVC\Symfony\View\Renderer\TemplateRenderer`) to get the content of the `Response` and attach this new `Response` to the event.
The `HttpKernel` retrieves the response attached to the event and continues.


## Kernel's response event and `Response` sending

The `HttpKernel` sends a `kernel.response` event (`KernelEvents::RESPONSE`). For example, if HTTP cache is used, response's headers may be enhanced.

The `HttpKernel` sends a `kernel.finish_request` event (`KernelEvents::FINISH_REQUEST`). The `VerifyUserPoliciesRequestListener` (`Ibexa\Bundle\Commerce\Eshop\EventListener\VerifyUserPoliciesRequestListener`) (priority 100) filters routes on its policy configuration.

!!! caution "Permission control"
 
     See [Permissions for routes](permissions.md#permissions-for-routes).

Finally, the `HttpKernel` send the response.

If an exception occurs during this chain of events, the `HttpKernel` sends a `kernel.exception` and tries to get a `Response` from its listeners.

The `HttpKernel` sends the last `kernel.terminate` event (`KernelEvents::TERMINATE`). For example, the `BackgroundIndexingTerminateListener` (`Ibexa\Bundle\Core\EventListener\BackgroundIndexingTerminateListener`) (priority 0) removes from the `SearchService` index possible content existing in the index but not in the database.


## Summary

### Summary of events and services

* event=`kernel.request`
    - 45:`ibexa.siteaccess_match_listener`
        - `Ibexa\Core\MVC\Symfony\SiteAccess\Router`
        - event=`Ibexa\Core\MVC\Symfony\SiteAccess`
            - 255:`Ibexa\Bundle\Core\EventListener\SiteAccessListener`
    - 32:`router_listener`
        - `Ibexa\Core\MVC\Symfony\Routing\ChainRouter`
            - tag=`router`
                - `router.default`
                - `ezpublish.urlwildcard_router`
                - `Ibexa\Bundle\Core\Routing\UrlAliasRouter`
    - 16:`locale_listener`
    - 13:`Ibexa\AdminUi\EventListener\RequestListener`
* event=`kernel.controller`
    - 10:`Ibexa\Bundle\Core\EventListener\ViewControllerListener`
        - `Ibexa\Core\MVC\Symfony\View\Builder\Registry\ControllerMatch`
            - tag=`ibexa.view.builder`
                - `Ibexa\Core\MVC\Symfony\View\Builder\ContentViewBuildercontent`
                    - `Ibexa\Core\MVC\Symfony\View\Configurator\ViewProvider`
* event=`kernel.controller_arguments`
* event=`kernel.view`
    - 0:`Ibexa\Bundle\Core\EventListener\ViewRendererListener`
        - `Ibexa\Core\MVC\Symfony\View\Renderer\TemplateRenderer`
* event=`kernel.response`
* event=`kernel.finish_request`
    - 100:`Ibexa\Bundle\Commerce\Eshop\EventListener\VerifyUserPoliciesRequestListener`
* event=`kernel.terminate`
    - 0:`Ibexa\Bundle\Core\EventListener\BackgroundIndexingTerminateListener`

### Examples request attributes timeline

|  Event                  |  Service                              |  Request attribute  |  Example      |
| ----------------------- | ------------------------------------- | ------------------- | ------------- |
|                         |  http_kernel                          |  pathInfo           |  /en/about    |
|  kernel.request         |  ibexa.siteaccess_match_listener  |  siteaccess         |  en           |
|  Ibexa\Core\MVC\Symfony\SiteAccess   |  Ibexa\Bundle\Core\EventListener\SiteAccessListener        |  semanticPathinfo   |  /about       |
|  kernel.request         |  router.default                       |  _route             |  N/A          |
|  kernel.request         |  router.default                       |  _controller        |  N/A          |
|  kernel.request         |  Ibexa\Bundle\Core\Routing\UrlAliasRouter            |  _route             |  ibexa.url.alias  |
|  kernel.request         |  Ibexa\Bundle\Core\Routing\UrlAliasRouter            |  _controller        |  <strong>ibexa_content:</strong>viewAction
|  kernel.request         |  Ibexa\Bundle\Core\Routing\UrlAliasRouter            |  viewType           |  full         |
|  kernel.request         |  Ibexa\Bundle\Core\Routing\UrlAliasRouter            |  contentId          |  1            |
|  kernel.request         |  Ibexa\Bundle\Core\Routing\UrlAliasRouter            |  locationId         |  42           |
|  kernel.request         |  locale_listener                      |  _locale            |  en_GB        |
|  kernel.controller      |  Ibexa\Core\MVC\Symfony\View\Builder\ContentViewBuildercontent       |  view.content       |  Content      |
|  kernel.controller      |  Ibexa\Core\MVC\Symfony\View\Builder\ContentViewBuildercontent       |  view.location      |  Location     |
|  kernel.controller      |  Ibexa\Core\MVC\Symfony\View\Configurator\ViewProvider          |  view.templateIdentifier   |  @IbexaCore/default/content/full.html.twig  |
|  kernel.controller      |  Ibexa\Core\MVC\Symfony\View\Configurator\ViewProvider          |  view.controllerReference  |  null  |
|  kernel.controller      |  Ibexa\Bundle\Core\EventListener\ViewControllerListener   |  view               |  ContentView  |
|  kernel.controller      |  Ibexa\Bundle\Core\EventListener\ViewControllerListener   |  _controller        |  ibexa_content:viewAction  |
| (controller execution)  |  http_kernel                          |                     |  ContentView  |
|  kernel.view            |  Ibexa\Bundle\Core\EventListener\ViewRendererListener     |  response           |  Response     |


## End of HTTP response

The web server outputs the HTTP response. Depending on the architecture, few things may still occur. For example, Varnish or Fastly can take specific headers into account when setting the cache or serving it.
