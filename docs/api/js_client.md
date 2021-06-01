# JavaScript client

This page will guide you on how to use the client, and view the [generated JavaScript API client reference](http://ezsystems.github.io/javascript-rest-client/).

## Using the JavaScript REST API client

The JavaScript REST API client is a JavaScript library meant to ease the use of the eZ Platform REST API. It can only be used in a web browser. It is also useful for working with eZ Platform as a [headless CMS](http://ez.no/Blog/Content-as-a-Service-CaaS-Decoupled-CMS-and-Headless-CMS-101).

## Installation

### In the PlatformUIAssetsBundle

Since the JavaScript REST client is one of the foundations of [the Platform Backend Interface](../guide/extending_ez_platform.md) in v1, the client is provided by the [PlatformUIAssetsBundle](https://github.com/ezsystems/PlatformUIAssetsBundle) which is installed by default. As a result, the client is directly available and can be embedded in any Platform-generated page with the following Twig code:

**Embedding the JavaScript REST client**

``` php
<script src="{{ asset('bundles/ezplatformuiassets/vendors/ez-js-rest-client/dist/CAPI.js') }}"></script>
<!-- or the minified version -->
<!-- <script src="{{ asset('bundles/ezplatformuiassets/vendors/ez-js-rest-client/dist/CAPI-min.js') }}"></script> -->
```

### Manual install

It is also possible to directly retrieve either `dist/CAPI.js` or `dist/CAPI-min.js` in [the Github repository of the project](https://github.com/ezsystems/ez-js-rest-client/).

## Usage examples

Once included, `CAPI.js` exports the `eZ` namespace which contains `eZ.CAPI`, the constructor function of the client. This constructor must receive the API end point and an authentication agent responsible for handling the authentication (session or basic auth). This is detailed in the [Instantiation and authentication](#instantiation-and-authentication) section below.

[The auto-generated API documentation](http://ezsystems.github.io/javascript-rest-client) of the JavaScript REST API client is available online. Like in the Public API, the code is organized around 3 main services:

-   [the Content Service](http://ezsystems.github.io/javascript-rest-client/classes/ContentService.html)
-   [the Content Type Service](http://ezsystems.github.io/javascript-rest-client/classes/ContentTypeService.html)
-   [the User Service](http://ezsystems.github.io/javascript-rest-client/classes/UserService.html)

In essence, the operations available through those services are asynchronous, so all the corresponding methods accept a callback function as its last argument. This callback function will be called when the operation has been done and it will receive two arguments:

|Argument|Description|
|--------|-----------|
|`error`|Depending on the success of the operation, this parameter is either `false` or a [`CAPIError`](http://ezsystems.github.io/javascript-rest-client/classes/CAPIError.html) instance representing the error|
|`response`|It's always a [`Response`](http://ezsystems.github.io/javascript-rest-client/classes/Response.html) instance that allows you to retrieve any information from the REST API response.|

### Instantiation and authentication

[The `eZ.CAPI` constructor function](http://ezsystems.github.io/javascript-rest-client/classes/CAPI.html) expects two parameters:

1.  the API endpoint URI
2.  an authentication agent instance to configure the client for [the authentication mechanism configuration in eZ Platform](general_rest_usage.md#rest-api-authentication).

The JavaScript REST client comes with two authentication agents for the Session and Basic Auth authentication mechanism.

#### Session Authentication

The `SessionAuthAgent` expects an object describing the existing Session or containing the credentials for the user to create the corresponding session. So if the user is not yet authenticated, the client can be instantiated with:

**Session Authentication (new session)**

``` php
var capi,
    credentials = {
        login: 'admin',
        password: 'publish',
    };

capi = new eZ.CAPI(
    'http://example.com',
    new eZ.SessionAuthAgent(credentials)
);
capi.logIn(function (error, response) {
    if ( error ) {
        console.log('Error!');
        return;
    }
    console.log("I'm logged in");
});
```

Instead of passing the `credentials` to the `eZ.SessionAuthAgent` constructor, it is also possible to pass this object as [the first parameter of the `logIn` method](http://ezsystems.github.io/javascript-rest-client/classes/CAPI.html#method_logIn).

If the user already has a session, the agent expects an object describing the session, something like:

**Session Authentication (existing session)**

```
var capi,
    sessionInfo = {
        name: 'eZSESSID', // name of the session, might also be something like eZSESSID98defd6ee70dfb1dea416cecdf391f58
        identifier: '6pp87ah63m44jdf53b35qlt2i7', // session id
        href: '/api/ezp/v2/user/sessions/6pp87ah63m44jdf53b35qlt2i7',
        csrfToken: 'memEneT7WvX9WmSlG2wDqUj0eeLRC7hXG--pLUx4dFE', // can be retrieved with @security.csrf.token_manager Symfony service
    };

capi = new eZ.CAPI(
    'http://example.com',
    new eZ.SessionAuthAgent(sessionInfo)
);
capi.isLoggedIn(function (error, response) {
    if ( error ) {
        console.log('Error!');
        return;
    }
    console.log("I'm logged in");
});
```

`csrfToken` is returned in the login response. It is important to keep CSRF Token for the duration of the session as it needs to be sent with requests other than GET/HEAD when auth is set to session (in most cases is).

#### Basic Authentication

When configured in the Basic Authentication, the `HttpBasicAuthAgent` just expects the user's credentials:

**Basic Authentication**

``` php
var capi,
    credentials = {
        login: 'admin',
        password: 'publish',
    };

capi = new eZ.CAPI(
    'http://example.com',
    new eZ.HttpBasicAuthAgent(credentials)
);
capi.logIn(function (error, response) {
    if ( error ) {
        console.log('Error!');
        return;
    }
    console.log("The credentials are valid");
});
```

### Loading a ContentInfo or a Content

To load a ContentInfo, you need [the Content Service](http://ezsystems.github.io/javascript-rest-client/classes/ContentService.html), it is returned by the `getContentService` method on the client instance:

**Loading a ContentInfo**

``` php
var capi, contentService,
    contentRestId = '/api/ezp/v2/content/objects/1',
    credentials = {
        login: 'admin',
        password: 'publish',
    };

capi = new eZ.CAPI(
    'http://example.com',
    new eZ.SessionAuthAgent(credentials)
);
contentService = capi.getContentService();
contentService.loadContentInfo(contentRestId, function (error, response) {
    if ( error ) {
        console.log('Error!');
        return;
    }
    // response.document contains the parsed JSON structure
    console.log('Content name: ' + response.document.Content.Name);
})
```

If you run this example, you should see in the browser network panel a GET HTTP request to <http://example.com/api/ezp/v2/content/objects/1> with the necessary headers to get a JSON representation of the ContentInfo. If you want to load the Content instead, you can use [the `loadContent` method](http://ezsystems.github.io/javascript-rest-client/classes/ContentService.html#method_loadContent).

### Moving a Location

To move a Location, [the Content Service](http://ezsystems.github.io/javascript-rest-client/classes/ContentService.html) is also needed, this operation will generate a MOVE HTTP request. If configured for the session authentication mechanism, the client will automatically add the CSRF Token.

**Moving a Location**

``` php
var capi, contentService,
    locationRestId = '/api/ezp/v2/content/locations/1/43/53', // Media/Multimedia in a default install
    newParentLocationRestId = '/api/ezp/v2/content/locations/1/43/52', // Media/Files in a default install
    credentials = {
        login: 'admin',
        password: 'publish',
    };

capi = new eZ.CAPI(
    'http://example.com',
    new eZ.SessionAuthAgent(credentials)
);
contentService = capi.getContentService();
contentService.moveSubtree(locationRestId, newParentLocationRestId, function (error, response) {
    if ( error ) {
        console.log('Error!');
        return;
    }
    console.log('Media/Multimedia is now Media/Files/Multimedia');
})
```

### Searching for Content or Location

Searching for Content or Location can be done with [REST views](https://github.com/ezsystems/ezpublish-kernel/blob/v6.13.6/doc/specifications/rest/REST-API-V2.rst#views). REST views can be configured with the [search engine criteria](../guide/search/search.md#search-criteria-reference) to match some Content items or Locations:

**REST views**

``` php
var capi, contentService, query,
    credentials = {
        login: 'admin',
        password: 'publish',
    };

capi = new eZ.CAPI(
    'http://example.com',
    new eZ.SessionAuthAgent(credentials)
);
contentService = capi.getContentService();
query = contentService.newViewCreateStruct('test-rest-view', 'LocationQuery'); // use 'ContentQuery' to retrieve a list of Content items
query.body.ViewInput.LocationQuery.Criteria = { // use 'ContentQuery' here as well
    FullTextCriterion: "ez",
};
query.body.ViewInput.LocationQuery.limit = 10;
// query.body.ViewInput.LocationQuery.offset = 0;
contentService.createView(query, function (error, response) {
    if ( error ) {
        console.log('Error!');
        return;
    }
    console.log("Search results", response.document.View.Result.searchHits.searchHit);
})
```

!!! note "REST views"

    REST views are designed to be persisted but this feature is not yet implemented. As a result, when calling `createView`, the POST request does not create the view but directly returns the results.
