# REST API customization and extension
TODO: Or "Customizing and extending the REST API"

## Component Cascade / Timeline Summary / REST request lifecycle
TODO: Find the right section title

* A REST Route leads to a REST Controller action. A REST route is composed of the root prefix (`ibexa.rest.path_prefix: /api/ibexa/v2`) and a resource path (e.g. `/content/objects/{contentId}`).
* This Controller action returns an `Ibexa\Rest\Value` descendant.
  - This Controller action might use the `Request` to build its result according to, for example, GET parameters, the `Accept` HTTP header, or, the Request payload and its `Content-Type` HTTP header.
  - This Controller action might wrap its return into a `CachedValue` which contains caching information for the reverse proxies.
* The `Ibexa\Bundle\Rest\EventListener\ResponseListener` attached to the `kernel.view event` is triggered, and, passes the Request and the Controller action's result to the `AcceptHeaderVisitorDispatcher`.
* The `AcceptHeaderVisitorDispatcher` matches one of the `regexps` of an `ibexa.rest.output.visitor` service (an `Ibexa\Contracts\Rest\Output\Visitor`). The role of this `Output\Visitor` is to transform the Value returned by the Controller into XML or JSON. To do so, it combines an `Output\Generator` corresponding to the output format and a `ValueObjectVisitorDispatcher`.
* The matched `Output\Visitor` uses its `ValueObjectVisitorDispatcher` to select the right `ValueObjectVisitor` according to the fully qualified class name (FQCN) of the Controller result. A `ValueObjectVisitor` is a service tagged `ibexa.rest.output.value_object.visitor` and this tag has a property `type` pointing a FQCN.
* `ValueObjectVisitor`s will recursively help to transform the Controller result thanks to the abstraction layer of the `Generator`.
* The `Output\Visitor` returns the `Response` to send back to the client.

### vnd.ibexa.api.Content VS vnd.ibexa.api.ContentInfo example
TODO: Keep? It pictures well but line numbers can change over time while fixing to one version risks obsolescence. If kept, format.

https://github.com/ibexa/rest/blob/main/src/lib/Server/Controller/Content.php#L79: The controller associated to /content/objects/{contentId} returns a Ibexa\Rest\Server\Values\RestContent (wrapped in a CachedValue) with currentVersion property that depends on the Accept header: null if vnd.ibexa.api.ContentInfo, not null if vnd.ibexa.api.Content but an Ibexa\Contracts\Core\Repository\Values\Content\Content

https://github.com/ibexa/rest/blob/main/src/bundle/Resources/config/services.yml#L280: The tagging associate a regex to an Output\Visitor
* "(^application/vnd\.ibexa\.api\.[A-Za-z]+\+json$)" => Ibexa\Contracts\Rest\Output\Visitor
* "(^application/vnd\.ibexa\.api\.[A-Za-z]+\+xml$)" => Ibexa\Contracts\Rest\Output\Visitor

https://github.com/ibexa/rest/blob/main/src/lib/Server/View/AcceptHeaderVisitorDispatcher.php#L52: The AcceptHeaderVisitorDispatcher will match vnd.ibexa.api.Content or vnd.ibexa.api.ContentInfo with Ibexa\Contracts\Rest\Output\Visitor

https://github.com/ibexa/rest/blob/main/src/contracts/Output/Visitor.php#L138: This Output\Visitor uses its ValueObjectVisitorDispatcher to visit data returned by the controller

* https://github.com/ibexa/rest/blob/main/src/bundle/Resources/config/value_object_visitors.yml#L682: Ibexa\Rest\Server\Values\CachedValue is associated to Ibexa\Rest\Server\Output\ValueObjectVisitor\CachedValue
* https://github.com/ibexa/rest/blob/main/src/bundle/Resources/config/value_object_visitors.yml#L202: Ibexa\Rest\Server\Values\RestContent is associated to Ibexa\Rest\Server\Output\ValueObjectVisitor\RestContent
* https://github.com/ibexa/rest/blob/main/src/bundle/Resources/config/value_object_visitors.yml#L241: Ibexa\Rest\Server\Values\Version is associated to Ibexa\Rest\Server\Output\ValueObjectVisitor\Version

https://github.com/ibexa/rest/blob/main/src/contracts/Output/ValueObjectVisitorDispatcher.php#L73: The ValueObjectVisitorDispatcher use the data to select the right ValueObjectVisitor

https://github.com/ibexa/rest/blob/main/src/lib/Server/Output/ValueObjectVisitor/CachedValue.php#L37: ValueObjectVisitor can recursively call the ValueObjectVisitorDispatcher to visit properties with the right ValueObjectVisitor as, for example, the ValueObjectVisitor/CachedValue does.

https://github.com/ibexa/rest/blob/main/src/lib/Server/Output/ValueObjectVisitor/RestContent.php#L102: The Values\RestContent returned by the controller is visited by the ValueObjectVisitor\RestContent; if not null, its currentVersion property will be wrapped in a Ibexa\Rest\Server\Values\Version to be visited by the associated Ibexa\Rest\Server\Output\ValueObjectVisitor\Version

## Adding a custom media-type / Accept header to an existing route / resource
https://doc.ibexa.co/en/latest/api/creating_custom_rest_api_response/
TODO: Explain vocabulary usage in previous section. Fix this section title.

In this example case, a new media-type will be passed in the `Accept` header of a GET request to `/content/locations/{locationPath}` route and its Controller action (`Controller/Location::loadLocation`).

By default, this resource handle a `application/vnd.ibexa.api.Location+xml` (or `+json`) `Accept` header.
The following example will add the handling of a new media-type `application/app.api.Location+xml` (or `+json`) `Accept` header to obtain a different Response using the same controller.

TODO: Choose the chronology: Output\Visitor → ValueObjectVisitorDispatcher → ValueObjectVisitor
* To handle Request with an `Accept` header stating with `application/app.api`, a new `Output\Visitor` service is needed.
* This `Output\Visitor` will need a new `ValueObjectVisitorDispatcher` to handle the result of the default Controller action and treat it differently.
* The new `ValueObjectVisitorDispatcher` will use a new `ValueObjectVisitor` to visit the default Controller result.
TODO: This chronology is closer to the system

TODO: Choose the chronology: ValueObjectVisitor → ValueObjectVisitorDispatcher → Output\Visitor
* To create the new Response corresponding to this new media-type, a new `ValueObjectVisitor` is needed.
* To have this new `ValueObjectVisitor` used to visit the default Controller result, a new `ValueObjectVisitorDispatcher` is needed.
* To have this new `ValueObjectVisitorDispatcher` associated to the new media-type in an `Accept` header, a new `Output\Visitor` service is needed.
TODO: This chronology is closer to the development

### New `RestLocation` `ValueObjectVisitor`

The Controller action returns a `Values\RestLocation` wrapped in a `Values\CachedValue`.
The new `ValueObjectVisitor` has to visit `Values\RestLocation` to prepare the new `Response`.
TODO: For the example, this new `ValueObjectVisitor` extends the default visitor to have less code to write / this new `ValueObjectVisitor` needs to extend the default visitor to be accepted by…

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/ValueObjectVisitor/RestLocation.php') =]]
```

This new `ValueObjectVisitor` receives a new tag `app.rest.output.value_object.visitor` to be associated to the new `ValueObjectVisitorDispatcher` in the next step.
This tag has a `type` property to associate the new `ValueObjectVisitor` with the type of value is made for.
TODO: Expose the default `ibexa.rest.output.value_object.visitor` tagging earlier.
``` yaml
# config/services.yaml
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 28, 35) =]]
```

### New `ValueObjectVisitorDispatcher`

The new `ValueObjectVisitorDispatcher` receives the `ValueObjectVisitor`s tagged `app.rest.output.value_object.visitor`.
As not all value FQCNs are handled, the new `ValueObjectVisitorDispatcher` also receives the default one as a fallback.

``` yaml
# config/services.yaml
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 22, 27) =]]
```

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/Output/ValueObjectVisitorDispatcher.php') =]]
```

### New `Output\Visitor` service

The following new pair of `Ouput\Visitor` associate `Accept` headers starting with `application/app.api.` to the new `ValueObjectVisitorDispatcher` for both XML and JSON.

``` yaml
# config/services.yaml
parameters:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 1, 3) =]]
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 6, 21) =]]
```

## Creating a new REST resource
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/

### Requirements / Needs check list
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/#requirements

* The REST route leading to a controller action.
* The controller and its action.
* Optionally, one or several `InputParser` if the Controller needs to receive a payload to treat, one or several Value classes to represent this payload and eventually one or several new media-types to type this payload in the `Content-Type` header.
* Optionally, one or several new Value classes to represent the Controller action result, their `ValueObjectVisitor` to help the Generator to turn this into XML or JSON and eventually one or several new media-types to claim in the `Accept` header the desired Value.
* Optionally, the addition of this resources route to the REST root.

### Route
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/#route

Your REST routes should use the [REST URI prefix](rest_api_usage.md#uri-prefix) for consistency. To ensure that they do, in the config/routes.yaml file, while importing a REST routing file, use `ibexa.rest.path_prefix` parameter as a `prefix`.

```yaml
# config/routes.yaml
app.rest:
    resource: routes_rest.yaml
    prefix: '%ibexa.rest.path_prefix%'
```

```yaml
# config/routes_rest.yaml
app.rest.hello_world:
    path: '/hello/world'
    controller: App\Rest\Controller\DefaultController::helloWorld
    methods: [GET]
```

#### CSRF protection

If a REST route is designed to be used with [unsafe methods](rest_api_usage#http-methods), the CSRF protection is enabled by default like for built-in routes. It can be disabled by using the route parameter `csrf_protection`.

```yaml
# config/routes_rest.yaml
app.rest.hello_world:
    path: '/hello/world'
    controller: App\Rest\Controller\DefaultController::helloWorld
    defaults:
        csrf_protection: false
    methods: [GET,POST]
```

#### OPTIONS method support

TODO: Handle it at Controller level or using the OptionsLoader?
```yaml
# config/routes.yaml
app.rest:
    resource: routes_rest.yaml
    prefix: '%ibexa.rest.path_prefix%'

app.rest.options:
    #TODO: There is something wrong with resource, it only works with an absolute path on ibexa/rest v4.1.2 — see https://issues.ibexa.co/browse/IBX-2927
    resource: routes_rest.yaml
    prefix: '%ibexa.rest.path_prefix%'
    type: rest_options
```

### Controller
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/#controller

#### Controller service
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/#route

TODO: What happens when Controller are not services? Is it really mandatory? If yes, why?

``` yaml
# config/services.yaml
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 36, 42) =]]
```

#### Controller action
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/#controller-action

A REST controller should:
- return a Value object and have a Generator and ValueObjectVisitors producing the XML or JSON output;
- extend `Ibexa\Rest\Server\Controller` to inherit few utils methods and properties like the InputDispatcher or the RequestParser.
TODO: Better exposition of this inheritance advantages…

```php
<?php

namespace App\Rest\Controller;

use Ibexa\Rest\Server\Controller;
```

### InputParser

### Value and ValueObjectVisitor

```php
<?php

namespace App\Rest\Values;
```

```php
<?php

namespace App\Rest\ValueObjectVisitor;

use Ibexa\Contracts\Rest\Output\ValueObjectVisitor;
use Ibexa\Contracts\Rest\Output\Generator;
use Ibexa\Contracts\Rest\Output\Visitor;
```

### Registering resources in the REST root
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/#registering-resources-in-the-rest-root

TODO: Earlier, after or within route configuration?

The new resource can be added to the [root resource](rest_api_usage.md#rest-root) through a configuration with the following pattern:

```yaml
ibexa_rest:
    system:
        <siteaccess_scope>:
            rest_root_resources:
                <resourceName>:
                    mediaType: <MediaType>
                    href: 'router.generate("<resource_route_name>", {routeParameter: value})'
```

The `router.generate` renders a URI based on the name of the route and its parameters. The parameter values can be a real value or a placeholder. For example, `'router.generate("ibexa.rest.load_location", {locationPath: "1/2"})'` results in `/api/ibexa/v2/content/locations/1/2` while `'router.generate("ibexa.rest.load_location", {locationPath: "{locationPath}"})'` gives `/api/ibexa/v2/content/locations/{locationPath}`.
This syntax is based on the Symfony's [expression language]([[= symfony_doc =]]/components/expression_language/index.html), an extensible component that allows limited/readable scripting to be used outside the code context.

For the previous example `app.rest.hello_world` available in every SiteAccess (`default`):

```yaml
#TODO: Which file?
ibexa_rest:
    system:
        default:
            rest_root_resources:
                helloWorld:
                    mediaType: Hello
                    href: 'router.generate("app.rest.hello_world")'
```

The above example add the following entry to the root XML output:
```xml
<helloWorld media-type="application/vnd.ibexa.api.Hello+xml" href="/api/ibexa/v2/hello/world"/>
```
TODO: Is there a way to change the media-type vendor?
