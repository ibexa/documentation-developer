# Extending REST API

To imagine what could be added to the REST API and to understand what the examples below are overriding, customizing or extending, it's important to picture the [REST request lifecycle](rest_api_usage.md#rest-communication-summary).

## Adding a custom media-type
https://doc.ibexa.co/en/latest/api/creating_custom_rest_api_response/

In this example case, a new media-type will be passed in the `Accept` header of a GET request to `/content/locations/{locationPath}` route and its Controller action (`Controller/Location::loadLocation`).

By default, this resource handle a `application/vnd.ibexa.api.Location+xml` (or `+json`) `Accept` header.
The following example will add the handling of a new media-type `application/app.api.Location+xml` (or `+json`) `Accept` header to obtain a different Response using the same controller.

* To create the new Response corresponding to this new media-type, a new `ValueObjectVisitor` is needed.
* To have this new `ValueObjectVisitor` used to visit the default Controller result, a new `ValueObjectVisitorDispatcher` is needed.
* To have this new `ValueObjectVisitorDispatcher` associated to the new media-type in an `Accept` header, a new `Output\Visitor` service is needed.

!!! note

    You may not change the vendor from default `vnd.ibexa.api` to new `app.api` like in this example but create a new type in the default vendor instead.
    To do so, your new ValueObjectVisitor will be tagged with `ibexa.rest.output.value_object.visitor` to be added to the existing `ValueObjectVisitorDispatcher` and no new one will be needed.
    The `media-type` attribute would also be easier to create as the default `Output\Generator` will use this default vendor.
    In this example, to create a new vendor has been chosen as a good practice to highlight that this is custom and won't be available on a regular Ibexa DXP.

### New `RestLocation` `ValueObjectVisitor`
https://doc.ibexa.co/en/latest/api/creating_custom_rest_api_response/#implementation-of-dedicated-visitor
https://doc.ibexa.co/en/latest/api/creating_custom_rest_api_response/#configuration

The Controller action returns a `Values\RestLocation` wrapped in a `Values\CachedValue`.
The new `ValueObjectVisitor` has to visit `Values\RestLocation` to prepare the new `Response`.

All new `ValueObjectVisitor` needs to extend the abstract class `Output\ValueObjectVisitor` to be accepted by the `ValueObjectVisitorDispatcher`.
In this example, this new `ValueObjectVisitor` extends the built-in `RestLocation` visitor to reuse it; So, the abstract class is implicitly inherited.

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
https://doc.ibexa.co/en/latest/api/creating_custom_rest_api_response/#overriding-response-type
https://doc.ibexa.co/en/latest/api/creating_custom_rest_api_response/#configuration

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
https://doc.ibexa.co/en/latest/api/creating_custom_rest_api_response/#configuration

The following new pair of `Ouput\Visitor` associate `Accept` headers starting with `application/app.api.` to the new `ValueObjectVisitorDispatcher` for both XML and JSON. A priority is set higher than other `ibexa.rest.output.visitor` tagged built-in services.

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
https://doc.ibexa.co/en/master/api/creating_custom_rest_api_response/#fetching-the-modified-response

In the following example, `curl` and `diff` command-lines are used to compare the default media-type (`application/vnd.ibexa.api.Location+xml`) with the new `application/app.api.Location+xml`.

```shell
diff --ignore-space-change \
  <(curl --silent https://api.example.com/api/ibexa/v2/content/locations/1/2) \
  <(curl --silent https://api.example.com/api/ibexa/v2/content/locations/1/2 --header 'Accept: application/app.api.Location+xml');
```

```
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
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/

### Requirements / Needs check list
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/#requirements

* The REST route leading to a controller action.
* The controller and its action.
* Optionally, one or several `InputParser` if the Controller needs to receive a payload to treat, one or several Value classes to represent this payload and eventually one or several new media-types to type this payload in the `Content-Type` header.
* Optionally, one or several new Value classes to represent the Controller action result, their `ValueObjectVisitor` to help the Generator to turn this into XML or JSON and eventually one or several new media-types to claim in the `Accept` header the desired Value.
* Optionally, the addition of this resources route to the REST root.

In the following example, a greeting resource will be added to the REST API. It will be available through `GET` and `POST` methods. `GET` will set default values while `POST` will allow to input custom values.

### Route
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/#route

Your REST routes should use the [REST URI prefix](rest_api_usage.md#uri-prefix) for consistency. To ensure that they do, in the config/routes.yaml file, while importing a REST routing file, use `ibexa.rest.path_prefix` parameter as a `prefix`.

``` yaml
# config/routes.yaml
[[= include_file('code_samples/api/rest_api/config/routes.yaml', 0, 3) =]]
```

``` yaml
# config/routes_rest.yaml
[[= include_file('code_samples/api/rest_api/config/routes_rest.yaml', 0, 3) =]]    methods: [GET]
```

#### CSRF protection

If a REST route is designed to be used with [unsafe methods](rest_api_usage#http-methods), the CSRF protection is enabled by default like for built-in routes. It can be disabled by using the route parameter `csrf_protection`.

``` yaml
# config/routes_rest.yaml
[[= include_file('code_samples/api/rest_api/config/routes_rest.yaml') =]]
```

#### OPTIONS method support

TODO: Handle it at Controller level or using the buggy OptionsLoader?
``` yaml
# config/routes.yaml
[[= include_file('code_samples/api/rest_api/config/routes.yaml') =]]
```

### Controller
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/#controller

#### Controller service
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/#route

The following configuration can be used to have all controllers from the `App\Rest\Controller\` namespace (files under `src/Rest/Controller/` folder) to be set as REST Controller services.

``` yaml
# config/services.yaml
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 36, 42) =]]
```

Having the REST controllers set as services allow to use features like the InputDispatcher service in the [Controller action](#controller-action) below.

#### Controller action
https://doc.ibexa.co/en/latest/api/extending_the_rest_api/#controller-action

A REST controller should:
- return a Value object and have a `Generator` and `ValueObjectVisitors` producing the XML or JSON output;
- extend `Ibexa\Rest\Server\Controller` to inherit utils methods and properties like the `InputDispatcher` or the `RequestParser`.

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/Controller/DefaultController.php') =]]
```

If the returned value was depending on a Location, it could have been wrapped in a `CachedValue` to be cached by the reverse proxy (like Varnish) for future calls.

The use of `CachedValue` looks like this:
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

Here, the media-type will be `application/vnd.ibexa.api.Greeting` plus a format. To have another vendor than the default, a new `Output\Generator` could be created or the `ValueObjectVisitor` could hard-code it like the [`RestLocation`'s one from previous example](#new-restlocation-valueobjectvisitor).

### InputParser

It could use route parameters, but this example's goal is to illustrate the usage of an input parser.

For this example, the structure will be a `GreetingInput` root node with two leaf nodes, `Salutation` and `Recipient`.

``` php
[[= include_file('code_samples/api/rest_api/src/Rest/InputParser/GreetingInput.php') =]]
```

Here, this InputParser directly return the right Value object but this could be whatever object needed to represent the input for the controller to perform its action, like arguments to use with a repository service.

``` yaml
# config/services.yaml
services:
    #…
[[= include_file('code_samples/api/rest_api/config/services.yaml', 48, 53) =]]
```

### Testing the new resource

Let's test both `GET` and `POST` methods, and, both `XML` and `JSON` format for inputs and outputs.

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

For the previous example `app.rest.greeting` available in every SiteAccess (`default`):

```yaml
#TODO: Which file?
ibexa_rest:
    system:
        default:
            rest_root_resources:
                greeting:
                    mediaType: Greeting
                    href: 'router.generate("app.rest.greeting")'
```

The above example add the following entry to the root XML output:
```xml
<greeting media-type="application/vnd.ibexa.api.Greeting+xml" href="/api/ibexa/v2/greet"/>
```
TODO: Is there a way to change the media-type vendor?
