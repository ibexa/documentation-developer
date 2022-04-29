# REST API authentication

## Basic authentication

## OAuth

## Session-based authentication

### Rich client application security concerns

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

## SSL client authentication
