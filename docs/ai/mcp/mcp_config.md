---
description: Configure an MCP server that exposes built-in and custom tools, prompts, and resources.
edition: lts-update
month_change: true
---

# Install and configure MCP Servers

With [[= product_name =]]'s MCP Servers LTS Update package, you can expose [MCP servers](mcp_guide.md) to external AI agents.

## Installation

Run the following command to install the package:

```bash
composer require ibexa/mcp
```

MCP Servers feature comes with [built-in tools](#built-in-tools) but doesn't come with a default configuration.
You have to create your own MCP servers by providing [their configuration](#mcp-server-configuration) and [enable JWT authentication for them](#jwt-mcp-firewall).

## Configure authentication

### JWT MCP firewall

AI agents use JWT authentication against [[= product_name =]]'s  MCP servers.

In `config/packages/lexik_jwt_authentication.yaml`, [enable the `authorization_header` token extractor](development_security.md#jwt-authentication) to allow the use of JWT token bearer in `Authorization` header.

In `config/packages/security.yaml`, make the following changes:

- Uncomment the `ibexa_jwt_rest` firewall to enable requesting JWT tokens through REST or GraphQL API.
- Uncomment the `ibexa_jwt_mcp` firewall to allow the use of JWT authentication against MCP servers.

!!! note "Authentication for the APIs"

    You don't need to activate JWT authentication for the REST or GraphQL API.
    
    For sample JWT token requests, see [REST JWT authentication](rest_api_authentication.md#jwt-authentication), [GraphQL JWT authentication](graphql.md#jwt-authentication) and [cURL test of MCP server](mcp_usage.md#perform-curl-test).

### Repository user

The AI agent authenticate against the MCP server with a JWT token generated for a specific repository user account.

This repository user can be:

- an individual user account (for example, of an editor or administrator)
- a dedicated account created specifically for AI integrations

The repository user can generate a JWT token with their own account, or a secondary dedicated account, and pass the token to the MCP client.
A gateway could use a dedicated shared repository user to generate a JWT token and establish the connection.

## MCP server configuration

You define MCP servers within a repository configuration and then assign those servers to specific SiteAccess scopes.

``` yaml
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 1, 8) =]]
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 12, 15) =]]
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 29, 33) =]]
```

Routes are built automatically from MCP server `path` configs.
Those routes are identified as `ibexa.mcp.<server_identifier>`.
You can list them by running the following command:

`php bin/console debug:router --siteaccess=<within_scope_siteaccess> ibexa.mcp`

### MCP server options

| Option                                                                                                          | Type    | Required | Default | Description                                                      |
|-----------------------------------------------------------------------------------------------------------------|---------|----------|---------|------------------------------------------------------------------|
| `path`                                                                                                          | string  | Yes      |         | MCP server endpoint path (appended to SiteAccess-aware base URL) |
| `enabled`                                                                                                       | boolean | No       | `false` | Server state: decides whether it is enabled or disabled                                   |
| `version`                                                                                                       | string  | No       | `1.0.0` | MCP server version                                               |
| [`description`](https://modelcontextprotocol.io/specification/2025-11-25/schema#implementation-description)     | string  | No       | `null`  | Server implementation description                                |
| [`instructions`](https://modelcontextprotocol.io/specification/2025-11-25/schema#initializeresult-instructions) | string  | No       | `null`  | Prompt-like instructions provided to the AI agent               |
| [`tools`](#tool-configuration)                                                                                 | string  | No       | `[]`    | List of tool classes                                             |
| <nobr>[`discovery_cache`](#discovery-cache)</nobr>                                                              | string  | Yes      |         | PSR-6 or PSR-16 cache pool service identifier                    |
| [`session`](#session-storage)                                                                                   | object  | Yes      |         | Session storage configuration                                    |

!!! note "New servers are disabled by default"

    After you define a server, it remains disabled until you explicitly enable it.

### Tool configuration

[Tools](https://modelcontextprotocol.io/specification/latest/server/tools) are the main capabilities of an MCP server,
they are the actions that an AI can call on the system.

!!! note "MCP server design best practices"

    Avoid creating MCP servers with large tool sets.
    Too many tools make it more difficult for the AI agent to select the appropriate action.
    Instead, create multiple MCP servers with specific sets of tools dedicated to specific contexts or use cases.
    When designing MCP servers, focus on the needs and tasks of the human user who actually interacts with the AI agent rather than exploring every technical capability.

There are two ways to associate tools with a server:

- By listing PHP classes (FQCNs) in the server's configuration `tools`. All tools marked with the `McpTool` attribute in those classes are automatically associated with the server (for example, for [built-in](#built-in-tools) or third party tools).
- By using the `servers` argument in [`McpTool` attribute](mcp_usage.md#tools) to explicitly associate a specific tool with MCP servers.

#### Built-in tools

MCP Servers LTS Update comes with the following built-in tools:

- `Ibexa\Mcp\Tool\TranslationTools`
    - `list_languages` - lists all languages in the current SiteAccess
    - `list_content_translations` - lists languages in which given content item has translations
- `Ibexa\Mcp\Tool\SeoTools`
    - `get_non_seo_content_ids` - returns IDs of content items that are missing SEO optimization (no meta title tag)

``` yaml hl_lines="5-7"
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 4, 7) =]]
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 9, 11) =]]
                    # …
```

### Discovery cache

Discovery is cached to avoid scanning for capabilities on every request.
You must provide a PSR-6 or PSR-16 cache pool for this caching.

For example, you could set up a dedicated Redis/Valkey:

``` yaml
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 17, 17) =]]
```

For a production cluster, it is recommended to use a Redis/Valkey cache pool so the cache can be shared by all nodes.

Clear the cache pool after making changes:

```bash
php bin/console cache:pool:clear cache.redis.mcp
```

### Session storage

MCP servers store session data in their own way.

#### Options

| Option      | Type    | Default  | Description                                       |
|-------------|---------|----------|---------------------------------------------------|
| `type`      | enum    | `memory` | Session store type: `psr16`, `file`, or `memory`  |
| `service`   | string  | `null`   | PSR-16 cache service ID for the `psr16` session store |
| `prefix`    | string  | `mcp_`   | Key prefix for the `psr16` session store              |
| `directory` | string  | `null`   | Directory path for the `file` session store           |
| `ttl`       | integer | `3600`   | Session TTL in seconds                            |

In production, it’s recommended to use [`psr16`](#psr-16) with Redis/Valkey, just like with [regular sessions](clustering.md#shared-sessions).

#### PSR-16

Sessions are stored with a PSR-16 compatible cache implementation.
It requires that a `service` option points to a valid cache service ID.
Optionally, you could use a more specific `prefix` option than the default `mcp_` to avoid key collisions with other cache usages.
Such configuration is suitable for production environments.

``` yaml
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 18, 21) =]]
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 34, 43) =]]
```

#### File

Sessions are stored on the filesystem.
This requires that you configure a directory.
Such setup is suitable for development environments.

In this example, sessions are stored in the `var/cache/<environment>/mcp/sessions/` directory (for example, `var/cache/dev/mcp/session/` for the `dev` environment, and `var/cache/prod/mcp/sessions/` for the `prod` environment):

``` yaml
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 23, 25) =]]
```

#### Memory

Sessions are stored in memory.
Such setup is suitable for development environments.
It may fail to work with containers such as Docker or DDEV.

``` yaml
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 27, 28) =]]
```
