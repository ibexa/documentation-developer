# Authentication

Note: Use of HTTPS for authenticated (REST) traffic is highly recommended!

## Basic Authentication

For more information, see [HTTP Authentication: Basic and Digest Access Authentication.](http://tools.ietf.org/html/rfc2617)

## OAuth

For more information, see [OAuth 2.0 protocol for authorization.](https://oauth.net/2/)

## Session based Authentication

This approach violates generally the principles of RESTful services.
However, the sessions are only created to re-authenticate the user (and perform authorization,
which has do be done anyway) and not to hold session state in the service.
So we consider this method to support AJAX based applications.

### Session cookie

If activated, the user must log in to use this and the client must send the session cookie in every request, using a standard Cookie header.
The name (sessionName) and value (sessionID) of the header is defined  in response when doing a POST /user/sessions.

Example request header: `Cookie: <SessionName> : <sessionID>`

### CSRF

A CSRF token needs to be sent in every request using "unsafe" methods (as in: not GET or HEAD) when a session has been established.
It should be sent with header X-CSRF-Token.
The token (csrfToken) is defined in response when login through POST `/user/sessions`.

Example request headers:

```
DELETE /content/types/32 HTTP/1.1
X-CSRF-Token: <csrfToken>
```

```
DELETE /user/sessions/<sessionID>
X-CSRF-Token: <csrfToken>
```

If an unsafe request is missing the CSRF token, or it has the wrong value, a response error must be given: `401 Unauthorized`.

### Rich client application security concerns

The whole point of CSRF protection is to prevent users accidentally running harmful operations by being tricked into executing a http(s) request against a web applications they are logged into, in case of browsers this will then be blocked by lack of CSRF token.
However, if you develop a rich client application (javascript, java, flash, silverlight, iOS, android, etc.) that is:

- Registering itself as a protocol handler
    - In a way that exposes unsafe methods
- Authenticates using either:
    - Session based authentication
    - "Client side session" by remembering user login/password

Then you have to make sure to ask the user if he really want to perform an unsafe operation when this is asked by over such a protocol handler.

Example: 

A rich javascript/web application is using `navigator.registerProtocolHandler()` to register "web+ez:" links to go against REST api, it uses some sort of session based authentication and it is in widespread use across the net, or/and it is used by everyone within a company.
A person with minimal insight into this application and the company can easily send out the following link to all employees in that company using mail: 
`<a href="web+ez:DELETE /content/locations/1/2">latest reports</a>`.

## SSL Client Authentication

The REST API provides authenticating a user by a subject in a client certificate delivered by the web server configured as SSL endpoint.
