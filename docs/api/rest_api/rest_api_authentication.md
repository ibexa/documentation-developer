---
description: To authenticate REST API communication you can use session (default), JWT, basic, OAuth and client certificate (SSL) authentication.
---

# REST API authentication

This page refers to [REST API reference](rest_api_reference/rest_api_reference.html), where you can find detailed information about
REST API resources and endpoints.

Five authentication methods are currently supported: session (default), JWT, basic, OAuth and client certificate (SSL).

You can only use one of those methods at the same time.

Using HTTPS for authenticated traffic is highly recommended.

For other security related subjects, see:

- [Cross-origin requests](rest_responses.md#cross-origin)
- [`access_control`]([[= symfony_doc =]]/security/access_control.html)

## Session-based authentication

This authentication method requires a session cookie to be sent with each request.

If you use this authentication method with a web browser, this session cookie is automatically available as soon as your visitor logs in.
Add it as a cookie to your REST requests, and the user will be authenticated.

Sessions are created to re-authenticate the user only (and perform authorization), not to hold session state in the service.
Because of that, you can use this method as supporting AJAX-based applications even if it violates the principles of RESTful services.

### Configuration

Session is the default method and is already enabled, so no configuration required.
Enabling any other method disables session.

### Usage examples

You can create a session for a visitor even if they are not logged in by sending the **`POST`** request to `/user/sessions`.
To log out, use the **`DELETE`** request on the same resource.

#### Establishing session

##### Creating session

To create a session, execute the following REST request:

=== "XML"

    ```
    POST /user/sessions HTTP/1.1
    Host: www.example.net
    Accept: application/vnd.ibexa.api.Session+xml
    Content-Type: application/vnd.ibexa.api.SessionInput+xml
    ```
    
    ```xml
    <?xml version="1.0" encoding="UTF-8"?>
    <SessionInput>
      <login>admin</login>
      <password>publish</password>
    </SessionInput>
    ```
    
    ```
    HTTP/1.1 201 Created
    Location: /user/sessions/go327ij2cirpo59pb6rrv2a4el2
    Set-Cookie: eZSESSID98defd6ee70dfb1dea416=go327ij2cirpo59pb6rrv2a4el2; domain=.example.net; path=/; expires=Wed, 13-Jan-2021 22:23:01 GMT; HttpOnly
    Content-Type: application/vnd.ibexa.api.Session+xml
    ```
    
    ```xml
    <?xml version="1.0" encoding="UTF-8"?>
    <Session href="/user/sessions/sessionID" media-type="application/vnd.ibexa.api.Session+xml">
      <name>eZSESSID98defd6ee70dfb1dea416</name>
      <identifier>go327ij2cirpo59pb6rrv2a4el2</identifier>
      <csrfToken>23lk.neri34ijajedfw39orj-3j93</csrfToken>
      <User href="/user/users/14" media-type="vnd.ibexa.api.User+xml"/>
    </Session>
    ```

=== "JSON"

    ```
    POST /user/sessions HTTP/1.1
    Host: www.example.net
    Accept: application/vnd.ibexa.api.Session+json
    Content-Type: application/vnd.ibexa.api.SessionInput+json
    ```
    
    ```json
    {
      "SessionInput": {
        "login": "admin",
        "password": "publish"
      }
    }
    ```
    
    ```
    HTTP/1.1 201 Created
    Location: /user/sessions/go327ij2cirpo59pb6rrv2a4el2
    Set-Cookie: eZSESSID98defd6ee70dfb1dea416=go327ij2cirpo59pb6rrv2a4el2; domain=.example.net; path=/; expires=Wed, 13-Jan-2021 22:23:01 GMT; HttpOnly
    Content-Type: application/vnd.ibexa.api.Session+xml
    ```
    
    ```json
    {
      "Session": {
        "_media-type": "application\/vnd.ibexa.api.Session+json",
        "_href": "\/api\/ibexa\/v2\/user\/sessions\/jg1nhinvepsb9ivd10hbjbdp4l",
        "name": "eZSESSID98defd6ee70dfb1dea416",
        "identifier": "go327ij2cirpo59pb6rrv2a4el2",
        "csrfToken": "23lk.neri34ijajedfw39orj-3j93",
        "User": {
          "_media-type": "application\/vnd.ibexa.api.User+json",
          "_href": "\/api\/ibexa\/v2\/user\/users\/14"
        }
      }
    }
    ```

##### Logging in with active session

Logging in is very similar to session creation, with one important detail:
the CSRF token obtained in the previous step is added to the new request through the `X-CSRF-Token` header.

=== "XML"

    ```
    POST /user/sessions HTTP/1.1
    Host: www.example.net
    Accept: application/vnd.ibexa.api.Session+xml
    Content-Type: application/vnd.ibexa.api.SessionInput+xml
    Cookie: eZSESSID98defd6ee70dfb1dea416=go327ij2cirpo59pb6rrv2a4el2
    X-CSRF-Token: 23lk.neri34ijajedfw39orj-3j93
    ```
    
    ```xml
    <?xml version="1.0" encoding="UTF-8"?>
    <SessionInput>
      <login>admin</login>
      <password>publish</password>
    </SessionInput>
    ```
    
    ```
    HTTP/1.1 200 OK
    Content-Type: application/vnd.ibexa.api.Session+xml
    ```
    
    ```xml
    <?xml version="1.0" encoding="UTF-8"?>
    <Session href="user/sessions/go327ij2cirpo59pb6rrv2a4el2/refresh" media-type="application/vnd.ibexa.api.Session+xml">
      <name>eZSESSID98defd6ee70dfb1dea416</name>
      <identifier>go327ij2cirpo59pb6rrv2a4el2</identifier>
      <csrfToken>23lk.neri34ijajedfw39orj-3j93</csrfToken>
      <User href="/user/users/14" media-type="vnd.ibexa.api.User+xml"/>
    </Session>
    ```

=== "JSON"

    ```
    POST /user/sessions HTTP/1.1
    Host: www.example.net
    Accept: application/vnd.ibexa.api.Session+json
    Content-Type: application/vnd.ibexa.api.SessionInput+json
    Cookie: eZSESSID98defd6ee70dfb1dea416=go327ij2cirpo59pb6rrv2a4el2
    X-CSRF-Token: 23lk.neri34ijajedfw39orj-3j93
    ```
    
    ```xml
    {
      "SessionInput": {
        "login": "admin",
        "password": "publish"
      }
    }
    ```
    
    ```
    HTTP/1.1 200 OK
    Content-Type: application/vnd.ibexa.api.Session+json
    ```
    
    ```xml
    {
      "Session": {
        "_media-type": "application\/vnd.ibexa.api.Session+json",
        "_href": "\/api\/ibexa\/v2\/user\/sessions\/jg1nhinvepsb9ivd10hbjbdp4l",
        "name": "eZSESSID98defd6ee70dfb1dea416",
        "identifier": "go327ij2cirpo59pb6rrv2a4el2",
        "csrfToken": "23lk.neri34ijajedfw39orj-3j93",
        "User": {
          "_media-type": "application\/vnd.ibexa.api.User+json",
          "_href": "\/api\/ibexa\/v2\/user\/users\/14"
        }
      }
    }
    ```

#### Using session

##### Session cookie

You can now add the previously set cookie to requests to be executed with the logged-in user.

```
GET /content/locations/1/5 HTTP/1.1
Host: www.example.net
Accept: Accept: application/vnd.ibexa.api.Location+xml
Cookie: eZSESSID98defd6ee70dfb1dea416=go327ij2cirpo59pb6rrv2a4el2
```

##### CSRF token

It can be important to keep the CSRF token (`csrfToken`) for the duration of the session,
because you must send this token in every request that uses [unsafe HTTP methods](rest_requests.md#request-method) (others than the safe GET or HEAD or OPTIONS) when a session has been established.
It should be sent with an `X-CSRF-Token` header.

Only three built-in routes can accept unsafe methods without CSRF, the sessions routes starting with `/user/sessions` to create, refresh or delete a session.

```
DELETE /content/types/32 HTTP/1.1
Host: www.example.net
Cookie: eZSESSID98defd6ee70dfb1dea416=go327ij2cirpo59pb6rrv2a4el2
X-CSRF-Token: 23lk.neri34ijajedfw39orj-3j93
```

If an unsafe request is missing the CSRF token, or the token has incorrect value, an error is returned: `401 Unauthorized`.

##### Rich client application security concerns

The purpose of CSRF protection is to prevent users from accidentally running harmful operations by being tricked into executing an HTTP(S) request against a web applications they are logged into.
In browsers this action will be blocked by lack of CSRF token.

However, if you develop a rich client application (JavaScript, JAVA, iOS, Android, etc.), that is:

- Registering itself as a protocol handler:
    - Exposes unsafe methods in any way
- Authenticates using either:
    - Session-based authentication
    - "Client side session" by remembering user login/password

Then, you have to make sure to confirm with the user if they want to perform an unsafe operation.

Example:

A rich JavaScript/web application is using `navigator.registerProtocolHandler()` to register "web+ez:" links to go against REST API.
It uses a session-based authentication, and it is in widespread use across the net, or/and it is used by everyone within a company.
A person with minimal insight into this application and the company can easily send out the following link to all employees in that company in email:
`<a href="web+ez:DELETE /content/locations/1/2">latest reports</a>`.

#### Logging out from session

To log out is to `DELETE` the session using its ID (like in the cookie). As this is an unsafe method, the CSRF token must be presented.

```
DELETE /user/sessions/go327ij2cirpo59pb6rrv2a4el2 HTTP/1.1
Host: www.example.net
Cookie: eZSESSID98defd6ee70dfb1dea416=go327ij2cirpo59pb6rrv2a4el2
X-CSRF-Token: 23lk.neri34ijajedfw39orj-3j93
```

## JWT authentication

### Configuration

See [JWT authentication](#jwt-authentication) or GraphQL.

### Usage example

After you [configure JWT authentication](development_security.md#jwt-authentication) at least for REST,
you can get the JWT token through the following request:

=== "XML"

    ```
    POST /user/token/jwt HTTP/1.1
    Host: <yourdomain>
    Accept: application/vnd.ibexa.api.JWT+xml
    Content-Type: application/vnd.ibexa.api.JWTInput+xml
    ```
    
    Provide the username and password in the request body:
    
    ```xml
    <JWTInput>
        <username>admin</username>
        <password>publish</password>
    </JWTInput>
    ```
    
    If credentials are valid, the server response contains a token:
    
    ```xml
    <JWT media-type="application/vnd.ibexa.api.JWT+xml" token="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9…-QBE4-6eKNjg"/>
    ```
    
    You can then use this token in your request instead of username and password.
    
    ```
    GET /content/locations/1/5/children
    Host: <yourdomain>
    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9…-QBE4-6eKNjg
    Accept: application/vnd.ibexa.api.LocationList+xml
    ```

=== "JSON"

    ```
    POST /user/token/jwt HTTP/1.1
    Host: <yourdomain>
    Accept: application/vnd.ibexa.api.JWT+json
    Content-Type: application/vnd.ibexa.api.JWTInput+json
    ```
    
    Provide the username and password in the request body:
    
    ```json
    {
        "JWTInput": {
            "username": "admin",
            "password": "publish"
        }
    }
    ```
    
    If credentials are valid, the server response contains a token:
    
    ```json
    {
        "JWT": {
            "_media-type": "application/vnd.ibexa.api.JWT+xml",
            "_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9…-QBE4-6eKNjg"
        }
    }
    ```
    
    You can then use this token in your request instead of username and password.
    
    ```
    GET /content/locations/1/5/children
    Host: <yourdomain>
    Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9…-QBE4-6eKNjg
    Accept: application/vnd.ibexa.api.LocationList+json
    ```

## HTTP basic authentication

For more information, see [HTTP Authentication: Basic and Digest Access Authentication](http://tools.ietf.org/html/rfc2617).

### Configuration

If the installation has a dedicated host for REST, you can enable HTTP basic authentication only on this host by setting a firewall like in the following example before the `ibexa_front` one:

```yaml
        ibexa_rest:
            host: ^api\.example\.com$
            http_basic:
                realm: Ibexa DXP REST API
```

!!! caution "Back Office uses REST API"

    Back Office uses the REST API too (for some parts like the Location tree or the Calendar) on its own domain.
    
    * If the Back Office SiteAccess matches `admin.example.com`, it will call the REST API under `//admin.example.com/api/ibexa/v2`;
    * If the Back Office SiteAccess matches localhost/admin, it will call the REST API under `//localhost/api/ibexa/v2`.
    
    If basic authentication is used only for REST API, it is better to have a dedicated domain even on a development environment.

### Usage example

Basic authentication requires the username and password to be sent *(username:password)*, base64 encoded, with each request.
For details, see [RFC 2617](http://tools.ietf.org/html/rfc2617).

Most HTTP client libraries as well as REST libraries support this method.
[Creating content with binary attachments](rest_requests.md#creating-content-with-binary-attachments) has an example using basic authentication with [cURL](https://www.php.net/manual/en/book.curl.php) and its `CURLOPT_USERPWD`. 

**Raw HTTP request with basic authentication**

```
GET / HTTP/1.1
Host: api.example.com
Accept: application/vnd.ibexa.api.Root+json
Authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==
```

## OAuth

For more information, see [OAuth 2.0 protocol for authorization.](https://oauth.net/2/)

## SSL client authentication

The REST API provides authentication of a user by a subject in a client certificate delivered by the web server configured as SSL endpoint.
