# Request Lifecycle: From Request to Response

## Intro: HTTP Request entering the architecture

When entering the architecture, the HTTP request can be handled by several component like a firewall, a load balancer, a reverse-proxy, etc. before arriving on the web server itself.

For an overview of what happens on reverse proxy like Varnish or Fastly, see [Context-aware HTTP cache / Request lifecycle](cache/context_aware_cache/#request-lifecycle).

When arriving at a Web server, the request is filtered by Apache Virtual Host, Nginx Server Blocks or equivalent. This mainly (and shortly) separates requests of static resources from requests to the application.

As Ibexa DXP is a Symfony application, everything starts like in Symfony &mdash; see [Symfony and HTTP Fundamentals](https://symfony.com/doc/current/introduction/http_fundamentals.html).

If the HTTP request is to be treated by Ibexa DXP, it goes to the [Symfony Front Controller](https://symfony.com/doc/current/configuration/front_controllers_and_kernel.html#the-front-controller) public/index.php

The Front Controller transform the HTTP request into a PHP [Request object](https://symfony.com/doc/current/introduction/http_fundamentals.html#symfony-request-object) and pass it to Symfony's Kernel to obtain a [Response object](https://symfony.com/doc/current/introduction/http_fundamentals.html#symfony-response-object) that will be transform and sent back as an HTTP response.

The schemas start with a Request object entering Symfony and Ibexa DXP. No REST or GraphQL HTTP Request here, only regular request from a browser.



## From Request to Response: Flowcharts

### Concept Flowchart

![Simplified request lifecycle flowchart](img/request_lifecycle_concept.png)

### Kernel Events Flowchart

<img src="../img/request_lifecycle_events.png" width="521" height="1761" style="max-height: none;" alt="Detailed request lifecycle flowchart organised around kernel events" />



## Kernel's Request Event

When the Request enter the Symfony's Kernel (and underneath the [HttpKernel](https://symfony.com/doc/current/components/http_kernel.html)), a `kernel.request` event (a.k.a `KernelEvents::REQUEST`) is dispatched.
Several listeners are called by decreasing priority (see `bin/console debug:event-dispatcher kernel.request;`).

### SiteAccess Matching

After the FragmentListener (priority 48), this is the turn of the `ezpublish.siteaccess_match_listener` service (priority 45).
This service can be

- purely the SiteAccessMatchListener or
- its UserContextSiteAccessMatchSubscriber decoration when HTTP Cache is used.

This service will

- find the current siteaccess using the SiteAccess\Router regarding the [SiteAccess Matching configurations](multisite/siteaccess_matching/),
- add the current siteaccess to the Request object's attribute `siteaccess`,
- then dispatch the `ezpublish.siteaccess` event (a.k.a `MVCEvents::SITEACCESS`) (see `bin/console debug:event-dispatcher ezpublish.siteaccess;`).

The SiteAccessListener subscribes to this `ezpublish.siteaccess` event with top priority. The SiteAccessListener add the attribute `semanticPathinfo`, the path without siteaccess indications ([URIElement](multisite/siteaccess_matching/#urielement), [URIText](multisite/siteaccess_matching/#uritext) or [Map\URI](multisite/siteaccess_matching/#mapuri) implementing the URILexer interface), to the Request.


### Routing

Lately, also listening the `kernel.request` event, the Symfony\Component\HttpKernel\EventListener\RouterListener (priority 32) calls the eZ\Publish\Core\MVC\Symfony\Routing\ChainRouter::matchRequest and add its returned parameters to the Request.

ChainRouter:
The [ChainRouter](https://symfony.com/doc/current/cmf/components/routing/chain.html) is a Symfony Content Management Framework (CMF) component.
It has a collection of prioritized routers to crawl in until finding one matching the Request to define what to do next.
The ChainRouter router collection is build by the ChainRoutingPass collecting the services tagged `router` (see `bin/console debug:container --tag=router;`).
The DefaultRouter is always added to the collection with top priority.

DefaultRouter:
The DefaultRouter (see `bin/console debug:container router.default;`) is trying to match the `semanticPathinfo` against routes, close to [the way pure Symfony does](https://symfony.com/doc/current/routing.html) by using the Symfony\Component\Routing\Router.
If a route matches, the controller associated to it will have the responsibility to build a Response object.

UrlWildcardRouter (not on the schema):
If [URL Wildcards](url_management/#url-wildcards) have been enabled, then the URLWildcardRouter (see `bin/console debug:container ezpublish.urlwildcard_router;`) is the next tried router.
If a wildcard matches, the Request's `semanticPathinfo` is updated and the router pretend a ResourceNotFoundException to continue with the ChainRouter collection's next entry.

UrlAliasRouter:
This router will use the UrlAliasService to associate the `semanticPathinfo` to a location.
If a location is found, the Request will receive the attributes `locationId` and `contentId` as well as that `viewType` is `full` and that, for now, the `_controller` is `ez_content:viewAction` (see `bin/console debug:container ez_content;`).

**Notice about Permission Control**: Another `kernel.request` event listener is the EzSystems\EzPlatformAdminUi\EventListener\RequestListener (priority 13): When a route got a `siteaccess_group_whitelist` parameter, this listener check that the current siteaccess is in one of the listed groups. For example, the Admin UI set an early protection of its route by passing them a `siteaccess_group_whitelist` containing only the `admin_group`.
[TODO: https://doc.ibexa.co/en/latest/guide/permissions/#permissions-for-routes]

Now, the Request know its controller, the HttpKernel dispatch the `kernel.controller` event.



## Kernel's Controller Event

(see `bin/console debug:event-dispatcher kernel.controller;`)

### ContentView Building (Content Loading and View Matching)

The HttpKernel just dispatched the `kernel.controller` event.

Listening to `kernel.controller`, the ViewControllerListener (priority 10) checks if the `_controller` Request attribute is associated to a ViewBuilder in the ViewBuilderRegistry (see `bin/console debug:container ezpublish.view_builder.registry;`).
The ContentViewBuilder (see `bin/console debug:container ezpublish.view_builder.content --show-arguments;`) matches on controller starting with `ez_content:` (see \eZ\Publish\Core\MVC\Symfony\View\Builder\ContentViewBuilder::matches).
The ContentViewBuilder builds a ContentView.

First, the ContentViewBuilder will load the Location with sudo, check the content/read permission, load the Content (and let the repository check the permission), add the Location and Content to ContentView object.

Then, the ContentViewBuilder passes the ContentView to its View\Configurator (see `bin/console debug:container ezpublish.view.configurator --show-arguments;`)…
It's implemented by the View\Configurator\ViewProvider and its View\Provider\Registry, this registry receives the services tagged `ezpublish.view_provider` thanks to the ViewProviderPass (see `bin/console debug:container --tag=ezpublish.view_provider;`).
Among the view providers, the services using the eZ\Bundle\EzPublishCoreBundle\View\Provider\Configured have an implementation of the MatcherFactoryInterface (see `bin/console debug:container ezpublish.content_view.matcher_factory`).
Through service decoration and class inheritance, the ClassNameMatcherFactory will be responsible for the [View Matching](content_rendering/templates/template_configuration/#view-rules-and-matching).
The View\Configurator\ViewProvider will use the matched view rule to add possible templateIdentifier and controllerReference to the ContentView object.

The ViewControllerListener adds the ContentView to the Request as `view` attribute.
The ViewControllerListener eventually updates the Request `_controller` attribute with the ContentView's controllerReference.

The HttpKernel then dispatches a `kernel.controller_arguments` (a.k.a. `KernelEvents::CONTROLLER_ARGUMENTS`) but nothing from Ibexa DXP is listening to it (see `bin/console debug:event-dispatcher kernel.controller_arguments`;).



## Controller Execution

The HttpKernel extracts from the Request the controller and the arguments to pass to the controller. [TODO: According to https://symfony.com/doc/current/controller/argument_value_resolver.html and \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory::createArgumentMetadata, controller arguments extraction seems based on comparing PHP classes from controller function signature type hinting to Reguest attributes object classes, like autowiring. ]
The HttpKernel executes the controller with those arguments.

As a reminder, the controller and its argument can be:

- A controller set by a route matching and the Request as its argument.
- The default `ez_content:viewAction` controller and a ContentView as its argument.
- A [custom controller](content_rendering/queries_and_controllers/controllers/) set by the matched view rule and a ContentView or the Request as its argument (most likely a ContentView but there is no restriction).

[TODO, here or elsewhere:] *Notice about Permission Control*: https://doc.ibexa.co/en/latest/guide/permissions/#permissions-for-custom-controllers



## Kernel's View Event and ContentView Rendering

If the controller returns something else than a Response, the HttpKernel dispatches a `kernel.view` event (a.k.a `KernelEvents::VIEW`) (see `bin/console debug:event-dispatcher kernel.view;`).
In the case of a URL Alias, the controller most likely returns a ContentView.
The ViewRendererListener (see `bin/console debug:container ezpublish.view.renderer_listener --show-arguments;`) will use the ContentView and the TemplateRenderer (see `bin/console debug:container ezpublish.view.template_renderer;`) to get the content of the Response and attach this new Response to the event.
The HttpKernel retrieve the Response attached to the event and continue.



## Kernel's Response Event and Response Sending

The HttpKernel send a `kernel.response` event (a.k.a `KernelEvents::RESPONSE`) (see `bin/console debug:event-dispatcher kernel.response`). For example, if HTTP Cache is used, Response's headers may be enhanced.

The HttpKernel send a `kernel.finish_request` event (a.k.a `KernelEvents::FINISH_REQUEST`) (see `bin/console debug:event-dispatcher kernel.finish_request`). The VerifyUserPoliciesRequestListener is filtering route on its policy configuration (see [Permissions for routes](https://doc.ibexa.co/en/latest/guide/permissions/#permissions-for-routes)). [TODO: This is ridiculous to check this so lately, it should be done during kernel.request like the siteaccess_group_whitelist]

Finally, the HttpKernel send the Response.

The HttpKernel send a last `kernel.terminate` event (a.k.a `KernelEvents::TERMINATE`) (see `bin/console debug:event-dispatcher kernel.terminate`) [TODO: reindex listener]

If an exception occurs during this chain of events, the HttpKernel get out of it, send a `kernel.exception` and try to obtain a Response from its listeners (see `bin/console debug:event-dispatcher kernel.exception;`).



## Outro: HTTP Response leaving the architecture

[TODO]





