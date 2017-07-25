# Making cross-origin HTTP requests

## Description

eZ Publish ships with [NelmioCorsBundle](https://github.com/nelmio/NelmioCorsBundle), a Symfony open-source bundle that provides support for [CORS (Cross Origin Resource Sharing)](http://www.w3.org/TR/cors/). The REST API is pre-configured to respond to such requests, as long as you customize the allowed origins as explained below.

### What is CORS

Supported by most modern browsers, this W3C specification defines a set of custom headers that, under specific circumstances, allow HTTP requests between different hosts. The main use-case is execution of AJAX code from one site towards another.

A couple links about it:

- [W3C specification](http://www.w3.org/TR/cors/)
- an excellent [tutorial about CORS on html5rocks.com](http://www.html5rocks.com/en/tutorials/cors/)
- [overview of CORS on developer.mozilla.org](https://developer.mozilla.org/en-US/docs/HTTP/Access_control_CORS)

## Solution

### Configuration

Since CORS support is provided by a 3rd party bundle, we re-use the semantical configuration it provides. You can read more about it on the [NelmiCorsBundle's README](https://github.com/nelmio/NelmioCorsBundle/blob/master/README.md) file.

The origin of a request is one of the main criteria for allowing or blocking a cross origin request. Such requests will come with an Origin HTTP header, automatically added by the browser, that gets approved/blocked by the server. By default, all cross origin requests will be blocked.

#### Granting an origin default access

To allow a specific host to execute cross-origin requests, you need to add this host to the `nelmio_cors.default.allow_origin` configuration array in `config.yml`. As an example, in order to allow requests from <http://example.com,> one would add those lines to `ezpublish/config/config.yml`:

``` yaml
nelmio_cors:
    defaults:
        allow_origin: [ 'http://example.com' ]
```

#### Granting CORS access to your own HTTP resources

The Cors bundle is of course perfectly safe to use for any non-eZ HTTP resource you would like to expose.
Follow the instructions in [NelmioCorsBundle's configuration chapter](https://github.com/nelmio/NelmioCorsBundle/blob/master/README.md#configuration).
