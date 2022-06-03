# REST API authentication
https://doc.ibexa.co/en/latest/api/rest_api_authentication/

This page refers to [REST API reference](rest_api_reference/rest_api_reference.html), where you can find detailed information about
REST API resources and endpoints.

Five authentication methods are currently supported: session (default), JWT, basic, OAuth and client certificate (SSL).

Those methods can't be used at the same time.

Using HTTPS for authenticated traffic is highly recommended.

Other security related subjects can be consulted:

- [Cross-origin requests](rest_api_usage.md#cross-origin-requests)
- [`access_control`]([[= symfony_doc =]]/security/access_control.html)

## Session-based authentication
https://doc.ibexa.co/en/latest/api/rest_api_authentication/#session-based-authentication

This authentication method requires a Session cookie to be sent with each request.

If this authentication method is used with a web browser, this session cookie is automatically available as soon as your visitor logs in.
Add it as a cookie to your REST requests, and the user will be authenticated.

Sessions are created to re-authenticate the user only (and perform authorization), not to hold session state in the service.
Because of that, we regard this method as supporting AJAX-based applications even if it violates the principles of RESTful services.

### Configuration

Session is the default method and is already enabled; no configuration required. Notice that enabling whatever other method will disable session.

### Usage examples
https://doc.ibexa.co/en/latest/api/general_rest_usage/#session-based-authentication

You can create a session for a visitor even if they are not logged in by sending the **`POST`** request to `/user/sessions`.
For logging out, use the **`DELETE`** request on the same resource.

#### Establishing a session

##### Creating session

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

It's almost the same exchange as for the session creation, but, this time, important detail, the CSRF token obtained in the previous step is added to the new request through the `X-CSRF-Token` header.

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

#### Using the session

##### Session cookie

The cookie previously set can now be joined to request to be executed with this user.

```
GET /content/locations/1/5 HTTP/1.1
Host: www.example.net
Accept: Accept: application/vnd.ibexa.api.Location+xml
Cookie: eZSESSID98defd6ee70dfb1dea416=go327ij2cirpo59pb6rrv2a4el2
```

##### CSRF token

It can be important to keep the CSRF Token (`csrfToken`) for the duration of the session as this CSRF token must be sent in every request that uses [unsafe HTTP methods](rest_api_usage.md#http-methods) (others than the safe GET or HEAD or OPTIONS) when a session has been established.
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
https://doc.ibexa.co/en/latest/api/rest_api_authentication/#rich-client-application-security-concerns

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

#### Logging out from the session

To log out is to `DELETE` the session using its ID (like in the cookie). As this is an unsafe method, the CSRF token must be presented.

```
DELETE /user/sessions/go327ij2cirpo59pb6rrv2a4el2 HTTP/1.1
Host: www.example.net
Cookie: eZSESSID98defd6ee70dfb1dea416=go327ij2cirpo59pb6rrv2a4el2
X-CSRF-Token: 23lk.neri34ijajedfw39orj-3j93
```

## JWT authentication

### Configuration
https://doc.ibexa.co/en/latest/guide/security/#jwt-authentication

See [JWT authentication](../guide/security/#jwt-authentication) to lear how to enable JWT for REST and/or GraphQL.

### Usage example
https://doc.ibexa.co/en/latest/api/general_rest_usage/#jwt-authentication

After you [configure JWT authentication](../guide/security.md#jwt-authentication) at least for REST,
you can get the JWT token through the following request:

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

If credentials are valid, the server response will contain a token:

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

## HTTP basic authentication
https://doc.ibexa.co/en/latest/api/rest_api_authentication/#basic-authentication

For more information, see [HTTP Authentication: Basic and Digest Access Authentication](http://tools.ietf.org/html/rfc2617).

### Configuration

If the installation has a dedicated host for REST, you can enable HTTP basic authentication only on this host by setting a firewall like the following before the `ibexa_front` one:

```yaml
        ibexa_rest:
            host: ^api\.example\.com$
            http_basic:
                realm: Ibexa DXP REST API
```

!!! caution "Back Office uses REST API"

    Notice that the Back Office uses the REST API too (for some parts like the Location tree or the Calendar) on its own domain.
    
    * If the Back Office SiteAccess matches admin.example.com, it will call the REST API under //admin.example.com/api/ibexa/v2;
    * If the Back Office SiteAccess matches localhost/admin, it will call the REST API under //localhost/api/ibexa/v2.
    
    If Basic authentication is aimed only for REST API, it is better to have a dedicated domain even on a developpement environement.

### Usage example
https://doc.ibexa.co/en/latest/api/general_rest_usage/#http-basic-authentication

Basic authentication requires the username and password to be sent *(username:password)*, based 64 encoded, with each request.
For details, see [RFC 2617](http://tools.ietf.org/html/rfc2617).

Most HTTP client libraries as well as REST libraries support this method. [Creating content with binary attachments](rest_api_usage.md#creating-content-with-binary-attachments) has an example using Basic authentication with [cURL](https://www.php.net/manual/en/book.curl.php) and its `CURLOPT_USERPWD`. 

**Raw HTTP request with basic authentication**

```
GET / HTTP/1.1
Host: api.example.com
Accept: application/vnd.ibexa.api.Root+json
Authorization: Basic QWxhZGRpbjpvcGVuIHNlc2FtZQ==
```

## OAuth
https://doc.ibexa.co/en/latest/api/rest_api_authentication/#oauth

For more information, see [OAuth 2.0 protocol for authorization.](https://oauth.net/2/)

## SSL client authentication
https://doc.ibexa.co/en/latest/api/rest_api_authentication/#ssl-client-authentication

The REST API provides authentication of a user by a subject in a client certificate delivered by the web server configured as SSL endpoint.
