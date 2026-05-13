---
description: Configure an MCP server exposing built-in tools, or custom tools, prompts, and resources.
edition: lts-update
month_change: true
---

# MCP servers installation and configuration

[[= product_name =]]'s MCP Servers LTS Update package can provide [MCP servers](mcp_guide.md) to external AI agents.

## Installation

Install the LTS Update package with Composer:

```bash
composer require ibexa/mcp
```

MCP Servers feature comes with [built-in tools](#built-in-tools) but doesn't come with a default configuration.
You have to create your own MCP servers through [their configuration](#mcp-server-configuration)
and [enable JWT authentication for them](#jwt-mcp-firewall).

## Authentication configuration

### JWT MCP firewall

AI agents use JWT authentication against [[= product_name =]]'s  MCP servers.

In `config/packages/lexik_jwt_authentication.yaml`, [enable the `authorization_header` token extractor](development_security.md#jwt-authentication)
to allow the use of JWT token bearer in `Authorization` header.

In `config/packages/security.yaml`,

- uncomment the `ibexa_jwt_rest` firewall to allow the request of JWT tokens through REST or GraphQL
- uncomment the `ibexa_jwt_mcp` firewall to allow the use of JWT authentication against MCP servers

Notice that you don't need to activate JWT authentication for the REST API or the GraphQL API.

You can now request JWT tokens to use with your MCP servers.
See examples of JWT token requests
in [REST JWT authentication](rest_api_authentication.md#jwt-authentication),
in [GraphQL JWT authentication](graphql.md#jwt-authentication),
or in [cURL test of MCP server](mcp_usage.md#curl-test).

### Repository user

- The user can generate a JWT token with their own account, or a secondary dedicated account, and pass the token to the MCP client.
- A gateway can use a dedicated shared user to generate a JWT token and establish the connection.

## MCP server configuration

MCP servers are defined per repository and assigned per SiteAccess scope.

``` yaml
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 1, 8) =]]
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 12, 15) =]]
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 29, 33) =]]
```

Routes are built automatically from MCP server `path` configs.
Those routes are identified as `ibexa.mcp.<server_identifier>`.
List them by running `php bin/console debug:router --siteaccess=<within_scope_siteaccess> ibexa.mcp`.

### MCP server options

| Option                                                                                                          | Type    | Required | Default | Description                                                      |
|-----------------------------------------------------------------------------------------------------------------|---------|----------|---------|------------------------------------------------------------------|
| `path`                                                                                                          | string  | Yes      |         | MCP server endpoint path (appended to SiteAccess-aware base URL) |
| `enabled`                                                                                                       | boolean | No       | `false` | Whether the server is enabled                                    |
| `version`                                                                                                       | string  | No       | `1.0.0` | MCP server version                                               |
| [`description`](https://modelcontextprotocol.io/specification/2025-11-25/schema#implementation-description)     | string  | No       | `null`  | Server implementation description                                |
| [`instructions`](https://modelcontextprotocol.io/specification/2025-11-25/schema#initializeresult-instructions) | string  | No       | `null`  | Prompt-like instructions dedicated to the AI agent               |
| [`tools`](#tools-configuration)                                                                                 | string  | No       | `[]`    | List of tool classes                                             |
| <nobr>[`discovery_cache`](#discovery-cache)</nobr>                                                              | string  | Yes      |         | PSR-6 or PSR-16 cache pool service identifier                    |
| [`session`](#session-storage)                                                                                   | object  | Yes      |         | Session storage configuration                                    |

Notice that a server is disabled by default, it needs to be explicitly enabled.

### Tools configuration

[Tools](https://modelcontextprotocol.io/specification/latest/server/tools) are the main capabilities of an MCP server,
they are the actions that an AI can call on the system.

!!! note "MCP server design best practice"

    An MCP server with too many tools makes it harder for the AI agent to choose the right one.
    Create several servers with specific sets of tools for different contexts and purposes.
    Focus on the needs and tasks of the human user actually prompting the AI agent when designing your MCP servers and capabilities, not on the technical possibilities.

There is two ways to associate tools with a server:

- `tools` in server configuration lists PHP classes (FQCN) from which **all** the `McpTool` attributes are associated with the server (for example, for [built-in tools](#built-in-tools) or third parties)
- `servers` argument in [`McpTool` attribute](mcp_usage.md#tools) associates the **specified** tool to servers

#### Built-in tools

MCP Servers LTS Update comes with the following built-in tools:

- `Ibexa\Mcp\Tool\TranslationTools`
    - `list_languages`: Lists all languages in the current SiteAccess
    - `list_content_translations`: Lists languages in which given content item has translations
- `Ibexa\Mcp\Tool\SeoTools`
    - `get_non_seo_content_ids`: Returns IDs of content items that are missing SEO optimization (no meta title tag)

``` yaml hl_lines="5-7"
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 4, 7) =]]
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 9, 11) =]]
                    # …
```

### Discovery cache

Discovery is cached to avoid scanning for capabilities on every request.
A PSR-6 or PSR-16 cache pool must be provided for this caching.

For example, a dedicated Redis/Valkey could be set up:

``` yaml
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 17, 17) =]]
```

### Session storage

MCP servers store session data their own way.

#### Options

| Option      | Type    | Default  | Description                                       |
|-------------|---------|----------|---------------------------------------------------|
| `type`      | enum    | `memory` | Session store type: `psr16`, `file`, or `memory`  |
| `service`   | string  | `null`   | PSR-16 cache service ID for `psr16` session store |
| `prefix`    | string  | `mcp_`   | Key prefix for `psr16` session store              |
| `directory` | string  | `null`   | Directory path for `file` session store           |
| `ttl`       | integer | `3600`   | Session TTL in seconds                            |

In production, [`psr16`](#psr-16) with Redis/Valkey is recommended like for [regular sessions](clustering.md#shared-sessions).

#### PSR-16

Sessions are stored with a PSR-16 compatible cache implementation.
It requires `service` option pointing to a valid cache service ID.
And optionally a more specific `prefix` option than the default `mcp_` to avoid key collisions with other cache usages.

``` yaml
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 18, 21) =]]
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 34, 43) =]]
```

#### File

Sessions are persisted to the filesystem. it requires directory option to be set.

In this example, sessions are stored in `var/cache/<environment>/mcp/sessions/` directory
(for example, `var/cache/dev/mcp/session/` in `dev` environment and `var/cache/prod/mcp/sessions/` in `prod` environment):

``` yaml
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 23, 25) =]]
```

#### Memory

Sessions are stored in memory. Suitable for development and STDIO transport.
It might not work with containers like Docker/DDEV.

``` yaml
[[= include_code('code_samples/mcp/mcp.matrix.yaml', 27, 28) =]]
```
