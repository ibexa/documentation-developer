# Extending REST API

To decide how to extend the REST API and to understand what the examples below are overriding, customizing or extending, it's important to picture the [REST request lifecycle](rest_api_usage.md#rest-communication-summary).

## Adding a custom media type

In this example case, you pass a new media type in the `Accept` header of a GET request to `/content/locations/{locationPath}` route and its controller action (`Controller/Location::loadLocation`).

By default, this resource takes an `application/vnd.ibexa.api.Location+xml` (or `+json`) `Accept` header.
The following example adds the handling of a new media type `application/app.api.Location+xml` (or `+json`) `Accept` header to obtain a different response using the same controller.

* To create the new response corresponding to this new media type, you need a new `ValueObjectVisitor`.
* To have this new `ValueObjectVisitor` used to visit the default controller result, you need a new `ValueObjectVisitorDispatcher`.
* To have this new `ValueObjectVisitorDispatcher` associated to the new media type in an `Accept` header, you need a new `Output\Visitor` service.

!!! note

    You can change the vendor name (from default `vnd.ibexa.api` to new `app.api` like in this example), or you can create a new media type in the default vendor (like `vnd.ibexa.api.Greeting` in the [Creating a new REST resource](#creating-a-new-rest-resource) example).
    To do so, tag your new ValueObjectVisitor with `ibexa.rest.output.value_object.visitor` to add it to the existing `ValueObjectVisitorDispatcher`, and a new one will not be needed.
    This way, the `media-type` attribute is also easier to create, because the default `Output\Generator` uses this default vendor.
    This example presents creating a new vendor as a good practice, to highlight that this is custom extensions that isn't available in a regular Ibexa DXP installation.

### New `RestLocation` `ValueObjectVisitor`

The controller action returns a `Values\RestLocation` object wrapped in `Values\CachedValue`.
The new `ValueObjectVisitor` has to visit `Values\RestLocation` to prepare the new `Response`.

To be accepted by the `ValueObjectVisitorDispatcher`, all new `ValueObjectVisitor` need to extend the abstract class `Output\ValueObjectVisitor`.
In this example, this new `ValueObjectVisitor` extends the built-in `RestLocation` visitor to reuse it.
This way, the abstract class is implicitly inherited.

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/ValueObjectVisitor/RestLocation.php') =]]
```

This new `ValueObjectVisitor` receives a new tag `app.rest.output.value_object.visitor` to be associated to the new `ValueObjectVisitorDispatcher` in the next step.
This tag has a `type` property to associate the new `ValueObjectVisitor` with the type of value is made for.

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

The following new pair of `Ouput\Visitor` entries associates `Accept` headers starting with `application/app.api.` to the new `ValueObjectVisitorDispatcher` for both XML and JSON.
A priority is set higher than other `ibexa.rest.output.visitor` tagged built-in services.

``` yaml
# config/services.yaml
parameters:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 1, 3) =]]
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 6, 21) =]]
```

### Testing the new media-type

In the following example, `curl` and `diff` commands are used to compare the default media type (`application/vnd.ibexa.api.Location+xml`) with the new `application/app.api.Location+xml`.

```shell
diff --ignore-space-change \
  <(curl --silent https://api.example.com/api/ibexa/v2/content/locations/1/2) \
  <(curl --silent https://api.example.com/api/ibexa/v2/content/locations/1/2 --header 'Accept: application/app.api.Location+xml');
```

``` diff
2c2,3
< <Location media-type="application/vnd.ibexa.api.Location+xml" href="/api/ibexa/v2/content/locations/1/2">
---
> <Location media-type="application/app.api.Location+xml" href="/api/ibexa/v2/content/locations/1/2">
>  <Location media-type="application/vnd.ibexa.api.Location+xml" href="/api/ibexa/v2/content/locations/1/2">
37a39,42
>  </Location>
>  <UrlAliasRefList media-type="application/vnd.ibexa.api.UrlAliasRefList+xml" href="/api/ibexa/v2/content/locations/1/2/urlaliases">
>   <UrlAlias media-type="application/vnd.ibexa.api.UrlAlias+xml" href="/api/ibexa/v2/content/urlaliases/0-d41d8cd98f00b204e9800998ecf8427e"/>
>  </UrlAliasRefList>
```

## Creating a new REST resource

To create a new REST resource, you need to prepare:

* The REST route leading to a controller action.
* The controller and its action.
* Optionally, one or several `InputParser` objects if the controller needs to receive a payload to treat, one or several value classes to represent this payload and potetially one or several new media types to type this payload in the `Content-Type` header.
* Optionally, one or several new value classes to represent the controller action result, their `ValueObjectVisitor` to help the generator to turn this into XML or JSON and potentially one or several new media types to claim in the `Accept` header the desired value.
* Optionally, the addition of this resource route to the REST root.

In the following example, you add a greeting resource to the REST API.
It is available through `GET` and `POST` methods. `GET` sets default values while `POST` allows inputting custom values.

### Route

New REST routes should use the [REST URI prefix](rest_api_usage.md#uri-prefix) for consistency.
To ensure that they do, in the `config/routes.yaml` file, while importing a REST routing file, use `ibexa.rest.path_prefix` parameter as a `prefix`.

``` yaml
# config/routes.yaml
[[= include_file('code_samples/api/rest_api/config/routes.yaml', 0, 3) =]]
```

``` yaml
# config/routes_rest.yaml
[[= include_file('code_samples/api/rest_api/config/routes_rest.yaml', 0, 3) =]]    methods: [GET]
```

#### CSRF protection

If a REST route is designed to be used with [unsafe methods](rest_api_usage#request-method), the CSRF protection is enabled by default like for built-in routes.
You can disable it by using the route parameter `csrf_protection`.

``` yaml
# config/routes_rest.yaml
[[= include_file('code_samples/api/rest_api/config/routes_rest.yaml') =]]
```

### Controller

#### Controller service

You can use the following configuration to have all controllers from the `App\Rest\Controller\` namespace (files in the `src/Rest/Controller/` folder) to be set as REST controller services.

``` yaml
# config/services.yaml
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 36, 42) =]]
```

Having the REST controllers set as services enables using features such as the `InputDispatcher` service in the [Controller action](#controller-action).

#### Controller action

A REST controller should:

- return a value object and have a `Generator` and `ValueObjectVisitor`s producing the XML or JSON output;
- extend `Ibexa\Rest\Server\Controller` to inherit utils methods and properties like `InputDispatcher` or `RequestParser`.

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/Controller/DefaultController.php') =]]
```

If the returned value was depending on a Location, it could have been wrapped in a `CachedValue` to be cached by the reverse proxy (like Varnish) for future calls.

`CachedValue` is used in the following way:

```php
return new CachedValue(
    new MyValue($args…),
    ['locationId'=> $locationId]
);
```

### Value and ValueObjectVisitor

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/Values/Greeting.php') =]]
```

A `ValueObjectVisitor` must implement the `visit` method.

| Argument     | Description                                                                                                                                            |
|--------------|--------------------------------------------------------------------------------------------------------------------------------------------------------|
| `$visitor`   | The output visitor.<br/>Can be used to set custom response headers (`setHeader`), HTTP status code ( `setStatus`)                                      |
| `$generator` | The actual response generator. It provides you with a DOM-like API.                                                                                    |
| `$data`      | The visited data. The exact object that you returned from the controller.<br/>It can't have a type declaration because the method signature is shared. |

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/ValueObjectVisitor/Greeting.php') =]]
```

The `Values/Greeting` class is linked to its `ValueObjectVisitor` through the service tag.

``` yaml
# config/services.yaml
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 43, 48) =]]
```

Here, the media type is `application/vnd.ibexa.api.Greeting` plus a format. To have a different vendor than the default, you could create a new `Output\Generator` or hard-code it in the `ValueObjectVisitor` like in the [`RestLocation` example](#new-restlocation-valueobjectvisitor).

### InputParser

A REST resource could use route parameters to handle input, but this example illustrates the usage of an input parser.

For this example, the structure is a `GreetingInput` root node with two leaf nodes, `Salutation` and `Recipient`.

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/InputParser/GreetingInput.php') =]]
```

Here, this `InputParser` directly returns the right value object.
In other cases, it could return whatever object is needed to represent the input for the controller to perform its action, like arguments to use with a Repository service.

``` yaml
# config/services.yaml
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 48, 53) =]]
```

### Testing the new resource

Now you can test both `GET` and `POST` methods, and both `XML` and `JSON` format for inputs and outputs.

```shell
curl https://api.example.com/api/ibexa/v2/greet --include;
curl https://api.example.com/api/ibexa/v2/greet --include --request POST \
    --header 'Content-Type: application/vnd.ibexa.api.GreetingInput+xml' \
    --data '<GreetingInput><Salutation>Good morning</Salutation></GreetingInput>';
curl https://api.example.com/api/ibexa/v2/greet --include --request POST \
    --header 'Content-Type: application/vnd.ibexa.api.GreetingInput+json' \
    --data '{"GreetingInput": {"Salutation": "Good day", "Recipient": "Earth"}}' \
    --header 'Accept: application/vnd.ibexa.api.Greeting+json';
```

```
HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.greeting+xml

<?xml version="1.0" encoding="UTF-8"?>
<Greeting media-type="application/vnd.ibexa.api.Greeting+xml" href="/api/ibexa/v2/greet">
 <Salutation>Hello</Salutation>
 <Recipient>World</Recipient>
 <Sentence>Hello World</Sentence>
</Greeting>

HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.greeting+xml

<?xml version="1.0" encoding="UTF-8"?>
<Greeting media-type="application/vnd.ibexa.api.Greeting+xml" href="/api/ibexa/v2/greet">
 <Salutation>Good morning</Salutation>
 <Recipient>World</Recipient>
 <Sentence>Good morning World</Sentence>
</Greeting>

HTTP/1.1 200 OK
Content-Type: application/vnd.ibexa.api.greeting+json

{
    "Greeting": {
        "_media-type": "application\/vnd.ibexa.api.Greeting+json",
        "_href": "\/api\/ibexa\/v2\/greet",
        "Salutation": "Good day",
        "Recipient": "Earth",
        "Sentence": "Good day Earth"
    }
}                              
```

### Registering resources in REST root

You can add the new resource to the [root resource](rest_api_usage.md#rest-root) through a configuration with the following pattern:

```yaml
ibexa_rest:
    system:
        <scope>:
            rest_root_resources:
                <resourceName>:
                    mediaType: <MediaType>
                    href: 'router.generate("<resource_route_name>", {routeParameter: value})'
```

The `router.generate` renders a URI based on the name of the route and its parameters. The parameter values can be a real value or a placeholder. For example, `'router.generate("ibexa.rest.load_location", {locationPath: "1/2"})'` results in `/api/ibexa/v2/content/locations/1/2` while `'router.generate("ibexa.rest.load_location", {locationPath: "{locationPath}"})'` gives `/api/ibexa/v2/content/locations/{locationPath}`.
This syntax is based on Symfony's [expression language]([[= symfony_doc =]]/components/expression_language/index.html), an extensible component that allows limited/readable scripting to be used outside the code context.

In this example, `app.rest.greeting` is available in every SiteAccess (`default`):

```yaml
ibexa_rest:
    system:
        default:
            rest_root_resources:
                greeting:
                    mediaType: Greeting
                    href: 'router.generate("app.rest.greeting")'
```

You can place this configuration in any regular config file, like the existing `config/packages/ibexa.yaml`, or a new `config/packages/ibexa_rest.yaml` file.

The above example adds the following entry to the root XML output:

```xml
<greeting media-type="application/vnd.ibexa.api.Greeting+xml" href="/api/ibexa/v2/greet"/>
```
