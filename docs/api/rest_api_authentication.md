# REST API reference authentication basics

This page refers to [REST API reference](https://doc.ezplatform.com/rest-api-reference), where you can get detailed information about
REST API resources and endpoints.

Use of HTTPS for authenticated (REST) traffic is highly recommended.

## Basic Authentication

For more information, see [HTTP Authentication: Basic and Digest Access Authentication.](http://tools.ietf.org/html/rfc2617)

## OAuth

For more information, see [OAuth 2.0 protocol for authorization.](https://oauth.net/2/)

## Session based Authentication

The sessions are only created to re-authenticate the user (and perform authorization) and not to hold session state in the service.
Because of that, we consider this method supports AJAX based applications even if it violates the principles of RESTful services.

For more information, see [REST API authentication introduction](general_rest_usage.md#rest-api-authentication).

### Session cookie

If activated, the user must log in, and the client must send the session cookie in every request, using a standard Cookie header.
The name (`sessionName`) and value (`sessionID`) of the header are defined  in a `/user/sessions` POST response.

Example request header: `Cookie: <SessionName> : <sessionID>`.

### CSRF token

A CSRF token needs to be sent in every request using "unsafe" methods (not GET or HEAD) when a session has been established.
It should be sent with `X-CSRF-Token` header.
The token (`csrfToken`) is defined in a response during logging in through the POST `/user/sessions`.

Example request headers:

```
DELETE /content/types/32 HTTP/1.1
X-CSRF-Token: <csrfToken>
```

```
DELETE /user/sessions/<sessionID>
X-CSRF-Token: <csrfToken>
```

If an unsafe request is missing the CSRF token, or the token has incorrect value, an error is returned: `401 Unauthorized`.

### Rich client application security concerns

The purpose of CSRF protection is to prevent users accidentally running harmful operations by being tricked into executing a http(s) request against a web applications they are logged into.
In browsers this action will be blocked by lack of CSRF token.

However, if you develop a rich client application (JavaScript, JAVA, Flash, Silverlight, iOS, Android, etc.) that is:

- Registering itself as a protocol handler
    - In a way that exposes unsafe methods
- Authenticates using either:
    - Session based authentication
    - "Client side session" by remembering user login/password

Then, you have to make sure to confirm with the user if they want to perform an unsafe operation.

Example: 

A rich javascript/web application is using `navigator.registerProtocolHandler()` to register "web+ez:" links to go against REST API.
It uses a session based authentication, and it is in widespread use across the net, or/and it is used by everyone within a company.
A person with minimal insight into this application and the company can easily send out the following link to all employees in that company using mail: 
`<a href="web+ez:DELETE /content/locations/1/2">latest reports</a>`.

## SSL Client Authentication

The REST API provides authenticating a user by a subject in a client certificate delivered by the web server configured as SSL endpoint.
