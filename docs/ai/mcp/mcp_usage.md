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
of the user associated with the authorization

## Perform Copilot or Claude Code test

You can test your MCP server with [Copilot CLI](https://docs.github.com/en/copilot/concepts/agents/copilot-cli/about-copilot-cli) or [Claude Code CLI](https://code.claude.com/docs/en/overview), as illustrated here, or with any other agent or interface.

### Add MCP server to agent CLI

You can handle the JWT token for this test in the following ways:

- [Hard-code the JWT token](#hard-coded-variant) into the configuration and update it at every expiration.
- [Wrap a JWT token request and an MCP server call into a script](#fully-scripted-variant).

#### Hard-coded variant

The hard-coded JWT token configuration in `.mcp.json` looks as follows:

```json
{
  "mcpServers": {
    "cohesivo-example": {
      "type": "http",
      "url": "https://example.cohesivo.app/mcp/management",
      "headers": {
        "Authorization": "Bearer <JWT token>"
      },
      "tools": ["*"]
    }
  }
}
```

In this approach, you must edit the `.mcp.json` file every time the JWT token expires.

When Copilot or Claude Code complains that it can't communicate with the MCP server:

=== Copilot CLI

    - Update the JWT token in the `.mcp.json` file.
    - Reload the MCP servers in Copilot CLI with one of these methods:
    - Run `/mcp reload` command to reload all MCP servers.
    - Run `/mcp disable cohesivo-example` and `/mcp enable cohesivo-example` to only reload the `cohesivo-example` server.

    > **Note: Reloading multiple MCP servers**
    >
    > If you have several MCP servers enabled globally, reloading all of them at the same time can be time-consuming. Consider reloading them one by one.

=== Claude Code CLI

    - Update the JWT token in the `.mcp.json` file.
    - Run `/mcp reconnect cohesivo-example` command to reconnect the `cohesivo-example` MCP server.

##### Fully scripted variant

The wrapping script configuration in `.mcp.json` looks as follows:

```json
{
  "mcpServers": {
    "cohesivo-example": {
      "type": "stdio",
      "command": "bash",
      "args": ["mcp-cohesivo-example-wrapper.sh"],
      "tools": ["*"]
    }
  }
}
```

`mcp-cohesivo-example-wrapper.sh` is a script that [requests an authorization token through REST](rest_api_authentication.md) and establishes a connection with the MCP server.

For example, thanks to [`npx`](https://www.npmjs.com/package/npx), you can do it with [Supergateway](https://www.npmjs.com/package/supergateway):

```bash
#!/bin/bash
set -e

mcpServer="https://example.cohesivo.app/mcp/management"
token=$(curl --request POST "$TOKEN_ENDPOINT" \
    --user "$CLIENT_ID:$CLIENT_SECRET" \
    --data 'grant_type=client_credentials' | jq -r .access_token)

exec npx -y supergateway \
  --streamableHttp "$mcpServer" \
  --oauth2Bearer "$token" \
  --logLevel none
```

When the agent complains that it can't communicate with the MCP server, reload it:

=== Copilot CLI

    Reload the MCP servers in Copilot CLI with one of these methods:

    - Run `/mcp reload` command to reload all MCP servers.
    - Run `/mcp disable cohesivo-example` and `/mcp enable cohesivo-example` to only reload the `cohesivo-example` server.

    > **Note: Reloading multiple MCP servers**
    >
    > If you have several MCP servers enabled globally, reloading all of them at the same time can be time-consuming. Consider reloading them one by one.

=== Claude Code CLI

    Run `/mcp reconnect cohesivo-example` command to reconnect the `cohesivo-example` MCP server.

## Rate limits

To prevent abuse, MCP server calls are rate limited to 300 requests per minute.

Every response carries the current state:

| Header | Description |
|---|---|
| `X-RateLimit-Limit` | Number of requests permitted in the window. |
| `X-RateLimit-Remaining` | Number of requests still available. |
| `X-RateLimit-Reset` | Unix timestamp at which the window resets. |

When you exceed the quota, the request responds with `429 Too Many Requests` and a `Retry-After` header
that tells you how many seconds to wait.
