---
description: Connect an AI agent to the built-in MCP server, authenticate it with an OAuth access token, and use the built-in tools.
month_change: false
---

# Work with MCP servers

[[= product_name =]] comes with a built-in MCP server called `management`,
which exposes a set of [built-in tools](mcp_guide.md#built-in-tools) to AI agents.

The server is available under the `/mcp/management` path, for example:

``` text
https://example.cohesivo.app/mcp/management
```

The server uses the [Streamable HTTP transport](https://modelcontextprotocol.io/docs/2025-11-25/learn/architecture#transport-layer).

## Connect to the MCP server

The MCP server accepts the same OAuth 2.0 access tokens as the REST API.
Send the token in the `Authorization` header of every request:

``` http
Authorization: Bearer <access_token>
```

For information about how to get a token, see [REST API authentication](rest_api_authentication.md#oauth).

Unlike the REST API, the MCP server has no anonymous access.
Requests without a valid token respond with `401 Unauthorized`:

``` json
{
    "error": "MCP endpoints require authentication."
}
```

## Use the built-in tools

Once an agent connects, it discovers the available tools.
Based on the prompt you provide to the agent, the agent decides which tools to call.

The [built-in tools](mcp_guide.md#built-in-tools) let an agent work with content types,
field definitions, content type groups, translations, and SEO metadata.
For example, you can ask the agent to create a content type with a set of fields,
to list the content items that have no translation into a given language,
or to point out the content items that are missing a meta title.

Because the tools act through the API, everything the agent can do is limited by the permissions
of the user that the access token represents.
With the [client credentials](rest_api_authentication.md#client-credentials) flow, this is the service account.

## Test the MCP server with Copilot CLI or Claude Code

You can test your MCP server with [Copilot CLI](https://docs.github.com/en/copilot/concepts/agents/copilot-cli/about-copilot-cli) or [Claude Code](https://code.claude.com/docs/en/overview), as illustrated here, or with any other agent or interface.

### Add MCP server to agent CLI

To add an MCP server to your agent, you need to request a JWT token, then configure the MCP server in your agent as a [Streamable HTTP](https://modelcontextprotocol.io/specification/2025-11-25/basic/transports#streamable-http) with a `Authentication: Bearer <token>` header.

The following script uses `curl` to request a JWT token, then creates or updates the MCP server configuration.
It works with Copilot CLI and Claude Code CLI.

```bash
#!/bin/bash
set -e

# Adapt to your test case
baseUrl='http://localhost'
serverUrl="$baseUrl/mcp/example"
serverName='ibexa-example'
username='ibexa-example'
password='Ibexa-3xample'
agentCli='copilot'
#agentCli='claude'

jwtToken=$(curl -s -X 'POST' \
  "$baseUrl/api/ibexa/v2/user/token/jwt" \
  -H 'Content-Type: application/vnd.ibexa.api.JWTInput+json' \
  -H 'Accept: application/vnd.ibexa.api.JWT+json' \
  -d "{
        \"JWTInput\": {
          \"_media-type\": \"application/vnd.ibexa.api.JWTInput+json\",
          \"username\": \"$username\",
          \"password\": \"$password\"
        }
      }" | jq -r .JWT.token)

if [[ -n $($agentCli mcp list | grep -E "(^| )$serverName\W") ]]
then
  $agentCli mcp remove "$serverName"
fi

$agentCli mcp add --transport http \
  "$serverName" "$serverUrl" \
  --header "Authorization: Bearer $jwtToken"
```

When the agent can't connect to the MCP server, re-run the script.

## Rate limits

To prevent abuse, MCP server calls are rate limited.

Responses carry the current state of the quota:

| Header | Description |
|---|---|
| `X-RateLimit-Limit` | Number of requests permitted in the window. |
| `X-RateLimit-Remaining` | Number of requests still available. |
| `X-RateLimit-Reset` | Unix timestamp at which the window resets. |

When you exceed the quota, the request responds with `429 Too Many Requests` and a `Retry-After` header
that tells you how many seconds to wait.
