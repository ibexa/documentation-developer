---
description: TODO.
month_change: true
---

TODO: built-in MCP servers VS custom MCP servers

# Set up an MCP server

## JWT

MCP servers use JWT for authentication.

TODO: [Enable authorization header in `config/packages/lexik_jwt_authentication.yaml`](development_security.md#jwt-authentication).

In `config/packages/security.yaml`, uncomment the `ibexa_jwt_mcp` firewall.

TODO: Config to get a JWT token in the first place. Through [REST](rest_api_authentication.md#jwt-authentication), GraphQL or something else?

## MCP Server configuration

MCP servers are configured per repository then enabled per SiteAccess scope.

```yaml
ibexa:
    repositories:
        <repository_identifier>:
            mcp:
                <server_identifier>:
                    path: <server_route_path>
                    enabled: true
                    # Server options…
                    discovery_cache: <cache_pool_service>
                    session:
                        type: <psr16|file|memory>
                        # Session options…
    system:
        <siteaccess_scope>:
            mcp:
                servers:
                    - <server_identifier>
```

TODO: `ddev php bin/console debug:router --siteaccess=<within_scope_siteaccess>` should list some `ibexa.mcp.<server_identifier> GET|POST|DELETE|OPTIONS <server_route_path>`

TODO: Maybe explain that routes are built automatically from MCP server `path` configs thank to `config/routes/ibexa_mcp.yaml` and `\Ibexa\Bundle\Mcp\Routing\McpRouteLoader`

### MCP server options

| Option            | Type    | Required | Default | Description                                   |
|-------------------|---------|----------|---------|-----------------------------------------------|
| `path`            | string  | Yes      |         | MCP server endpoint path                      |
| `enabled`         | boolean | No       | `false` | Whether the server is enabled                 |
| `version`         | string  | No       | `1.0.0` | MCP server version                            |
| `description`     | string  | No       | `null`  | Human-readable server description             |
| `instructions`    | string  | No       | `null`  | Instructions dedicated for LLM interaction    |
| `tools`           | string  | No       | `[]`    | List of tool classes                          |
| `discovery_cache` | string  | Yes      |         | PSR-6 ou PSR-16 cache pool service identifier |
| `session`         | object  | Yes      |         | Session storage configuration                 |

Notice that a server is disabled by default, it needs to be explicitly enabled.

### Tools configuration

TODO: Tools are… (VS Prompt templates are… VS Resources are…)

You can create your own tools, see [MCP server capabilities](#mcp-server-capabilities).

Ibexa DXP come with several built-in tool classes:

- `Ibexa\Mcp\Tool\TranslationTools`
    - `list_languages`: TODO
    - `list_content_translations`: TODO
- `Ibexa\Mcp\Tool\SeoTools`
    - `get_non_seo_content_ids`: TODO

```yaml
                    tools:
                        - Ibexa\Mcp\Tool\TranslationTools
                        - Ibexa\Mcp\Tool\SeoTools
```

### MCP server discovery cache

TODO

### MCP server session storage

#### Options

| Option      | Type    | Default  | Description                                       |
|-------------|---------|----------|---------------------------------------------------|
| `type`      | enum    | `memory` | Session store type: `psr16`, `file`, or `memory`  |
| `service`   | string  | `null`   | PSR-16 cache service ID for `psr16` session store |
| `prefix`    | string  | `mcp_`   | Key prefix for `psr16` session store              |
| `directory` | string  | `null`   | Directory path for `file` session store           |
| `ttl`       | integer | `3600`   | Session TTL in seconds                            |

#### PSR-16

Sessions are stored using a PSR-16 compatible cache implementation. Requires service option pointing to a valid cache service ID.

```yaml
                    session:
                        type: psr16
                        service: cache.redis.mcp
                        prefix: 'mcp_<server_identifier>_'
services:
    cache.redis.mcp:
        public: true
        class: Symfony\Component\Cache\Adapter\RedisTagAwareAdapter
        parent: cache.adapter.redis
        tags:
            -   name: cache.pool
                clearer: cache.app_clearer
                provider: 'redis://mcp.redis:6379'
                namespace: 'mcp'
```

#### File

Sessions are persisted to the filesystem. Requires directory option to be set.

```yaml
                    session:
                        type: file
                        directory: '%kernel.cache_dir%/mcp/sessions'
```

#### Memory

Sessions are stored in memory. Suitable for development and STDIO transport.

TODO: Might not work with DDEV or Docker

```yaml
                    session:
                        type: memory
```

## MCP server capabilities

The Ibexa DXP MCP server framework (`ibexa/mcp`) is built on top of [the official PHP SDK for MCP (`mcp/sdk`)](https://github.com/modelcontextprotocol/php-sdk)

A PHP class implementing MCP server capabilities like tools, prompts, or resources, must:

- implements [`Ibexa\Contracts\Mcp\McpCapabilityInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-McpCapabilityInterface.html) to be scanned for capabilities
- uses attributes from the [`Ibexa\Contracts\Mcp\Attribute` namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-mcp-attribute.html) to define capabilities.
- TODO: be added to an MCP server configuration

### Tools

The [`Ibexa\Contracts\Mcp\Attribute\McpTool` attribute](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-Attribute-McpTool.html) declared a method as an MCP tool.
It has several arguments to describe the tool usage and output:

- `name` (optional): the name of the tool - if not set, the function name is used as the tool name
- `description` (optional): a human-readable description of the tool, useful for the LLM to understand the tool purpose and eventually choose it when it matches the prompt intent
- `inputSchema` (optional): for JSON object output, an associative array describing this object
- `annotations` (optional): a [`Mcp\Schema\ToolAnnotations`](https://github.com/modelcontextprotocol/php-sdk/blob/main/src/Schema/ToolAnnotations.php) instance 

## Example

### Configure MCP server

This example introduce an `example` MCP server with a single `greet` tool.
It's enabled on all SiteAccesses.
It's accessible with the path `/mcp/example` (for example, on `http://localhost/mcp/example` and `http://localhost/admin/mcp/example`).
It uses files for both discovery cache and session storage.

In a new `config/packages/mcp.yaml` file, the configuration of the MCP server:

``` yaml
[[= include_file('code_samples/mcp/config/packages/mcp.yaml') =]]
```

### Create tool class

Then, a `McpCapabilityInterface` containing a `greetByName` function with a `McpTool` attribute,
the `App\Mcp\ExampleTools` class listed in the server's `tools`:

``` php
[[= include_file('code_samples/mcp/src/Mcp/ExampleTools.php') =]]
```

### Create MCP server list command

To check the server configuration, a short command using the MCP server configuration registry (injected through `McpServerConfigurationRegistryInterface` and autowiring):

``` php
[[= include_file('code_samples/mcp/src/Command/McpServerListCommand.php') =]]
```

### cURL test

To test the `example` MCP server, a sequence of `curl` commands is used to simulate an AI to MCP server communication.

- Ask for a [JWT token through REST](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/User-Token/operation/api_usertokenjwt_post)
- Initialize a connection to the MCP server
- Validate the MCP Session ID
- List the available tools
- Call a tool

`jq`, `grep`, and `sed` are also used to parse or display outputs.

The [initialization](https://modelcontextprotocol.io/specification/draft/basic/lifecycle#initialization):

``` bash
[[= include_file('code_samples/mcp/mcp.sh', 0, 36) =]]
```

```
HTTP/1.1 202 Accepted
Access-Control-Allow-Headers: Content-Type, Mcp-Session-Id, Mcp-Protocol-Version, Last-Event-ID, Authorization, Accept
Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS
Access-Control-Expose-Headers: Mcp-Session-Id
```

The [list of tools](https://modelcontextprotocol.io/specification/draft/server/tools#listing-tools):

``` bash
[[= include_file('code_samples/mcp/mcp.sh', 37, 45) =]]
```

```json
{
  "jsonrpc": "2.0",
  "id": 2,
  "result": {
    "tools": [
      {
        "name": "greet",
        "inputSchema": {
          "type": "object",
          "properties": {
            "name": {
              "type": "string"
            }
          },
          "required": [
            "name"
          ]
        },
        "description": "Greet a user by name"
      }
    ]
  }
}
```

The `greet` [tool usage](https://modelcontextprotocol.io/specification/draft/server/tools#calling-tools):

``` bash
[[= include_file('code_samples/mcp/mcp.sh', 46) =]]
```

```json
{
  "jsonrpc": "2.0",
  "id": 3,
  "result": {
    "content": [
      {
        "type": "text",
        "text": "Hello, World!"
      }
    ],
    "isError": false
  }
}
```

### MCP Inspector test

To test your server, you can use the [MCP Inspector](https://modelcontextprotocol.io/docs/tools/inspector).
It's even possible to use it as a DDEV add-on with [`craftpulse/ddev-mcp-inspector`](https://github.com/craftpulse/ddev-mcp-inspector).
You still need to ask for a JWT token through REST and use it in the MCP Inspector configuration to connect to your server.

To use the MCP Inspector for this example, the settings are:

- Transport Type: Streamable HTTP
- URL: addition of the actual domain and the server `path`, for example `http://localhost/mcp/example`
- Connection Type: Via Proxy
- Authentication:
    - Custom Headers:
        - ✓ Authorization
        - Bearer <JWT token obtained through REST>
    - OAuth 2.0 Flow: leave unedited

![Screenshot of the left pannel of the MCP Inspector with the connection settings for the example MCP server](img/mcp-inspector-config.png "MCP Inspector connection settings")

In the right panel, in the **Tools** tab, click **List Tools** button in the left column.
The `greet` tool appears preceded by its icon.
It can be selected and tested in the right column.

![Screenshot of the right pannel of the MCP Inspector with the list of tools obtained from the example MCP server, and the test of the `greet` tool](img/mcp-inspector-greet.png "MCP Inspector `greet` tool test")

### TODO: Copilot CLI test

TODO: Test the server with [Copilot CLI](https://docs.github.com/en/copilot/concepts/agents/copilot-cli/about-copilot-cli).

TODO: Create an .mcp.json file at the project root so the MCP server will only exist for a session of Copilot CLI opened from project root (for example, in a terminal tab of your IDE).

TODO: [Copilot CLI MCP server addition](https://docs.github.com/en/copilot/how-tos/copilot-cli/customize-copilot/add-mcp-servers) is strangely asking for some OAuth ID even with a proper JWT/Bearer header.

### TODO: Other clients?

TODO: Connect AI clients to the MCP server.
