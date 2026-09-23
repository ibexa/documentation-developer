---
description: To authenticate REST API communication, use OAuth 2.0 access tokens issued by the authorization server.
month_change: false
---

# REST API authentication

This page refers to [REST API reference](rest_api_reference/rest_api_reference.html), where you can find detailed information about REST API resources and endpoints.

[[= product_name =]] authenticates REST API requests with [OAuth 2.0](https://oauth.net/2/) access tokens.
You get an access token from the authorization server, and send it with every request in the `Authorization` header:

``` http
Authorization: Bearer <access_token>
```

The same tokens also give access to the [MCP server](mcp_usage.md).

## Anonymous access

Requests without the `Authorization` header are performed as the anonymous user, and can only access what the `Anonymous` role allows.

For example, the REST root and publicly readable content are available without a token:

``` bash
curl https://example.cohesivo.app/api/ibexa/v2/ \
    --header 'Accept: application/vnd.ibexa.api.Root+json'
```

## OAuth

To get an access token, use the values received during [[= product_name =]] onboarding:

| Value | Description |
|---|---|
| `TOKEN_ENDPOINT` | Token endpoint of the authorization server. |
| `AUTHORIZATION_ENDPOINT` | Authorization endpoint of the authorization server, used by the [authorization code flow](#authorization-code-with-pkce). |
| `CLIENT_ID` | Identifier of the machine-to-machine client. |
| `CLIENT_SECRET` | Secret of the machine-to-machine client. |

Two flows are available:

- With [Client credentials](#client-credentials), the API runs as a [service account](users_admin_panel.md#service-account). Use it for server-to-server integrations.
- With [Authorization code with PKCE](#authorization-code-with-pkce), the API runs as the person who logged in, with their permissions.
Use it for applications that act on behalf of a user.

### Client credentials

Request a token from the token endpoint with the client identifier and secret:

``` bash
curl --request POST "$TOKEN_ENDPOINT" \
    --user "$CLIENT_ID:$CLIENT_SECRET" \
    --data 'grant_type=client_credentials'
```

The response contains the access token:

``` json
{
    "access_token": "eyJhbGciOiJSUzI1NiIsInR5cCI6...",
    "token_type": "Bearer"
}
```

Requests made with this token run as the [service account](users_admin_panel.md#service-account).

### Authorization code with PKCE

The authorization code flow with [PKCE](https://oauth.net/2/pkce/) requires a browser, because the user logs in on the authorization server.

Use a client that can perform the redirect.
You can follow the example below in Postman:

1. Fill in the request details:

    | Field | Value |
    |---|---|
    | Type | OAuth 2.0 |
    | Add auth data to | Request Headers |
    | Grant type | Authorization Code (With PKCE) |
    | Callback URL | Redirect URI registered for your client, with **Authorize using browser** selected |
    | Auth URL | `AUTHORIZATION_ENDPOINT` |
    | Access Token URL | `TOKEN_ENDPOINT` |
    | Client ID | Identifier of the client that's configured for the authorization code flow |
    | Client Secret | (empty) |
    | Code Challenge Method | SHA-256 |
    | Scope | `openid` |

2. Select **Get New Access Token**, log in with your user account
3. Select **Use Token**.

Requests made with this token run as the user who logged in, and are subject to that user's permissions.

## Use authentication token

Send the access token in the `Authorization` header:

``` bash
curl https://example.cohesivo.app/api/ibexa/v2/user/current \
    --location \
    --header 'Accept: application/vnd.ibexa.api.User+json' \
    --header "Authorization: Bearer $ACCESS_TOKEN"
```

The response describes the user that the request runs as, which is the quickest way to confirm
which identity a token carries.

Access tokens are valid for 15 minutes.

## Rate limits

To prevent abuse, REST API calls are rate limited as described below:

| Request type | Limit |
|---|---|
| Authenticated | 300 per minute |
| Unauthenticated | 30 per minute |

Every response carries the current state of the quota:

| Header | Description |
|---|---|
| `X-RateLimit-Limit` | Number of requests permitted in the window. |
| `X-RateLimit-Remaining` | Number of requests still available. |
| `X-RateLimit-Reset` | Unix timestamp at which the window resets. |

When you exceed the quota, the request responds with `429 Too Many Requests` and a `Retry-After` header
that tells you how many seconds to wait.
