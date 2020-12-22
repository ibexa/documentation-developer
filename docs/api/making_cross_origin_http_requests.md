# Making cross-origin HTTP requests

[[= product_name =]] ships with [NelmioCorsBundle](https://github.com/nelmio/NelmioCorsBundle),
an open-source Symfony bundle that provides support for [CORS (Cross-Origin Resource Sharing)](http://www.w3.org/TR/cors/).
The REST API is pre-configured to respond to such requests, as long as you customize the allowed origins as explained below.

## What is CORS?

Supported by most modern browsers, this W3C specification defines a set of custom headers
that, under specific circumstances, allow HTTP requests between different hosts.
The main use-case is execution of AJAX code from one site towards another.

!!! tip "More information about CORS"

    - [W3C specification](http://www.w3.org/TR/cors/)
    - [Tutorial about CORS on html5rocks.com](http://www.html5rocks.com/en/tutorials/cors/)
    - [Overview of CORS on developer.mozilla.org](https://developer.mozilla.org/en-US/docs/HTTP/Access_control_CORS)

## Configuration

Since CORS support is provided by a third party bundle, we re-use the semantic configuration it provides.
You can read more about it in [NelmioCorsBundle's README](https://github.com/nelmio/NelmioCorsBundle/blob/master/README.md).

The origin of a request is one of the main criteria for allowing or blocking a cross-origin request.
Such requests will come with an Origin HTTP header, automatically added by the browser,
that gets approved/blocked by the server. By default, all cross-origin requests will be blocked.

#### Granting an origin default access

To allow a specific host to execute cross-origin requests, you need to add this host to the `nelmio_cors.default.allow_origin` configuration array in `config/packages/nelmio_cors.yaml`.
As an example, in order to allow requests from `http://example.com` you would add those lines to `nelmio_cors.yaml`:

``` yaml
nelmio_cors:
    defaults:
        allow_origin: [ 'http://example.com' ]
```

#### Changing configuration of NelmioCorsBundle for [[= product_name =]] REST

The default configuration of NelmioCorsBundle for [[= product_name =]] REST paths is set in the [nelmio_cors.yaml](https://github.com/ezsystems/ezplatform-rest/blob/master/src/bundle/Resources/config/nelmio_cors.yml) file.
To adapt these settings to your own needs you have to overwrite them in the `nelmio_cors.yaml` file under the same configuration path, for instance:

```yaml
nelmio_cors:
    paths:
        '^/api/ezp/v2/':
            max_age: 3600
            allow_credentials: false
            allow_origin: ['http://ez.no']
```

### Granting CORS access to your own HTTP resources

NelmioCorsBundle is perfectly safe to use for any non-eZ HTTP resource you would like to expose.
Follow the instructions in [NelmioCorsBundle's configuration chapter](https://github.com/nelmio/NelmioCorsBundle/blob/master/README.md#configuration).
