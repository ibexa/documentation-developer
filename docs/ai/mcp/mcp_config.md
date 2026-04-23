---
description: Configure an MCP server exposing built-in or custom tools TODO and prompts/resources.
month_change: true
---

# Set up an MCP server

[[= product_name =]] can provide [MCP servers](mcp_guide.md) to external AIs.

## JWT

MCP servers use JWT for authentication.

In `config/packages/lexik_jwt_authentication.yaml`, [enable the `authorization_header` token extractor](development_security.md#jwt-authentication) to allow the use of JWT in `Authorization` header.

In `config/packages/security.yaml`,

- uncomment the `ibexa_jwt_rest` firewall to allow the request of JWT tokens through REST API
- uncomment the `ibexa_jwt_mcp` firewall to allow the use of JWT for authentication against MCP servers

Notice that you don't need to activate JWT authentication for the REST API or GraphQL.

You can now request JWT tokens to use with your MCP servers.
See examples of JWT token requests in [REST JWT authentication](rest_api_authentication.md#jwt-authentication), in [cURL test of MCP Server](#curl-test), or [GraphQL JWT authentication](graphql.md#jwt-authentication).

## MCP server configuration

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

Tools are the main capabilities of an MCP server, they are the actions that an AI can call on the system.

There is two ways to associate tools with a server:

- `tools` in server configuration lists classes from which **all** the `McpTool` attributes are associated with the server
- `servers` argument in `McpTool` attribute associated the **specified** tool to servers 

#### Built-in tools

Ibexa DXP come with several built-in tool classes:

- `Ibexa\Mcp\Tool\TranslationTools`
    - `list_languages`: Lists all languages in the current SiteAccess
    - `list_content_translations`: Lists languages which have translations for a given content item
- `Ibexa\Mcp\Tool\SeoTools`
    - `get_non_seo_content_ids`: Returns IDs of content items that are missing SEO optimization (no meta title tag). Useful for identifying content that needs SEO attention.

```yaml
                    tools:
                        - Ibexa\Mcp\Tool\TranslationTools
                        - Ibexa\Mcp\Tool\SeoTools
```

### Discovery cache

Discovery is cached to avoid scanning for capabilities on every request.
A PSR-6 or PSR-16 cache pool must be provided for this caching.

For example, a dedicated Redis/Valkey could be set up:

```yaml
                    discovery_cache: cache.redis.mcp
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

Sessions are persisted to the filesystem. it requires directory option to be set.

In this example, sessions are stored in `var/cache/<environment>/mcp/sessions/` directory
(for example, `var/cache/dev/mcp/session/` in `dev` environment and `var/cache/prod/mcp/sessions/` in `prod` environment):

```yaml
                    session:
                        type: file
                        directory: '%kernel.cache_dir%/mcp/sessions'
```

#### Memory

Sessions are stored in memory. Suitable for development and STDIO transport.
It might not work with containers like Docker/DDEV.

```yaml
                    session:
                        type: memory
```

## MCP server capabilities

The Ibexa DXP MCP server framework (`ibexa/mcp`) is built on top of [the official PHP SDK for MCP (`mcp/sdk`)](https://github.com/modelcontextprotocol/php-sdk)

A PHP class implementing MCP server capabilities like tools, prompts, or resources, must:

- implements [`Ibexa\Contracts\Mcp\McpCapabilityInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-McpCapabilityInterface.html) to be scanned for capabilities
- uses attributes from the [`Ibexa\Contracts\Mcp\Attribute` namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-mcp-attribute.html) to define capabilities.

### Tools

TODO: https://modelcontextprotocol.io/specification/latest/server/tools

The [`Ibexa\Contracts\Mcp\Attribute\McpTool` attribute](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-Attribute-McpTool.html) declares a method as an MCP tool.
It has several arguments to describe the tool usage and output:

- `servers` (optional): an array of identifiers of servers proposing this tool - for more information, see [tools configuration](#tools-configuration)
- `name` (optional): the name of the tool - if not set, the function name is used as the tool name
- `description` (optional): a human-readable description of the tool, useful for the LLM to understand the tool purpose and eventually choose it when it matches the prompt intent
- `icons` (optional): an array of [`Mcp\Schema\Icon`](https://github.com/modelcontextprotocol/php-sdk/blob/main/src/Schema/Icon.php) instances
- `outputSchema` (optional): for JSON object output, an associative array describing this object
- `annotations` (optional): a [`Mcp\Schema\ToolAnnotations`](https://github.com/modelcontextprotocol/php-sdk/blob/main/src/Schema/ToolAnnotations.php) instance 
- `meta` (optional): TODO

An `inputSchema` is automatically built from the function arguments and their types.
To override or complement the automatically generated input schema,
use the [`Schema` attribute](https://github.com/php-mcp/server#-schema-generation-and-validation).

### Prompts

MCP servers can also provide prompt templates to guide the user in the interactions with the AI using the MCP server.

TODO: https://modelcontextprotocol.io/specification/latest/server/prompts

The [`Ibexa\Contracts\Mcp\Attribute\McpPrompt` attribute](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-Attribute-McpTool.html) declared a method as returning a prompt.

It has several arguments to describe the prompt usage:

- `servers`: an array of identifiers of servers proposing this prompt - notice that this is required for prompts
- `name` (optional): the name of the prompt - if not set, the function name is used as the prompt name
- `description` (optional): a human-readable description of the prompt
- `icons` (optional): an array of [`Mcp\Schema\Icon`](https://github.com/modelcontextprotocol/php-sdk/blob/main/src/Schema/Icon.php) instances
- `meta` (optional): TODO

An `arguments` array is automatically built from the function arguments and their types.
To add descriptions, use a docblock comment with `@param` tags.

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

An `ibexa.mcp.example` route is now available:
```bash
php bin/console debug:router ibexa.mcp.example
```

### Create capability class

An `McpCapabilityInterface` is created.

It contains a function with an `McpTool` attribute associating it to the `example` server as `greet` tool for the AI.

It also contains a function with the `McpPrompt` attribute to provide a prompt template to the user.

``` php
[[= include_file('code_samples/mcp/src/Mcp/ExampleTools.php') =]]
```

For the example, `servers` attribute parameter is used to associate only this tool to the `example` server.
All tools from this class could be added to a server by using the `tools` parameter in server configuration.
For more information, see [tools configuration](#tools-configuration).

For prompt, the `servers` parameter is required.
So, the example prompt has to use it to be associated with the `example` server.

During development and testing, you may have to clear the cache to make sure new or modified capabilities are properly re-discovered.
In this example, regarding its configuration, `php bin/console cache:pool:clear cache.tagaware.filesystem` has to be used.

### Create MCP server list command

To check the server configuration, a short command using the MCP server configuration registry
(injected through [`McpServerConfigurationRegistryInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-McpServerConfigurationRegistryInterface.html) and autowiring):

``` php
[[= include_file('code_samples/mcp/src/Command/McpServerListCommand.php') =]]
```

### cURL test

To test the `example` MCP server, a sequence of `curl` commands is used to simulate an AI client to MCP server communication.

- Ask for a [JWT token through REST](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/User-Token/operation/api_usertokenjwt_post)
- Initialize a connection to the MCP server
- Validate the MCP Session ID
- List the available tools
- Call a tool

`jq`, `grep`, and `sed` are also used to parse or display outputs.

First, the shell script set the Ibexa DXP base URL into a variable for easier reuse:

``` bash
[[= include_file('code_samples/mcp/mcp.sh', 0, 1) =]]
```

Before communicating with the MCP server, the request of a JWT token through REST API:

``` bash
[[= include_file('code_samples/mcp/mcp.sh', 0, 12) =]]
```

The [initialization](https://modelcontextprotocol.io/specification/latest/basic/lifecycle#initialization) to get an MCP session ID:

``` bash
[[= include_file('code_samples/mcp/mcp.sh', 13, 28) =]]
```

The validation of the initialization:

``` bash
[[= include_file('code_samples/mcp/mcp.sh', 29, 36) =]]
```

```
HTTP/1.1 202 Accepted
Access-Control-Allow-Headers: Content-Type, Mcp-Session-Id, Mcp-Protocol-Version, Last-Event-ID, Authorization, Accept
Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS
Access-Control-Expose-Headers: Mcp-Session-Id
```

The [list of tools](https://modelcontextprotocol.io/specification/latest/server/tools#listing-tools):

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
              "type": "string",
              "description": "the name of the person to greet"
            }
          },
          "required": [
            "name"
          ]
        },
        "description": "Greet a user by name",
        "annotations": {
          "readOnlyHint": true,
          "destructiveHint": false,
          "idempotentHint": true,
          "openWorldHint": false
        },
        "icons": [
          {
            "src": "https://openmoji.org/data/color/svg/1F44B.svg"
          }
        ]
      }
    ]
  }
}
```

The `greet` [tool call](https://modelcontextprotocol.io/specification/latest/server/tools#calling-tools):

``` bash
[[= include_file('code_samples/mcp/mcp.sh', 46, 60) =]]
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

The [list of prompts](https://modelcontextprotocol.io/specification/latest/server/prompts#listing-prompts):

``` bash
[[= include_file('code_samples/mcp/mcp.sh', 61, 69) =]]
```

```json
{
  "jsonrpc": "2.0",
  "id": 4,
  "result": {
    "prompts": [
      {
        "name": "greet",
        "description": "Prompt to be greeted by the `greet` tool",
        "arguments": [
          {
            "name": "name",
            "description": "The name you want to be greeted by",
            "required": true
          }
        ],
        "icons": [
          {
            "src": "https://openmoji.org/data/color/svg/1F91D.svg"
          }
        ]
      }
    ]
  }
}
```

The `greet` [prompt obtainment](https://modelcontextprotocol.io/specification/2025-11-25/server/prompts#getting-a-prompt):

``` bash
[[= include_file('code_samples/mcp/mcp.sh', 70, 84) =]]
```

```json
{
  "jsonrpc": "2.0",
  "id": 5,
  "result": {
    "messages": [
      {
        "role": "user",
        "content": {
          "type": "text",
          "text": "Hi. Please, greet me. My name is Firstname Lastname."
        }
      }
    ]
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

![Screenshot of the right pannel of the MCP Inspector with the list of tools obtained from the example MCP server, and the test of the `greet` tool](img/mcp-inspector-greet-tool.png "MCP Inspector `greet` tool test")

In the **Prompts** tab, click **List Prompts** button in the left column.
The `greet` prompt appears preceded by its icon.
It can be selected and tested in the right column.

![Screenshot of the right pannel of the MCP Inspector with the list of prompts obtained from the example MCP server, and the test of the `greet` prompt](img/mcp-inspector-greet-prompt.png "MCP Inspector `greet` prompt test")

### TODO: Copilot CLI test

TODO: Test the server with [Copilot CLI](https://docs.github.com/en/copilot/concepts/agents/copilot-cli/about-copilot-cli).

TODO: Create an .mcp.json file at the project root so the MCP server will only exist for a session of Copilot CLI opened from project root (for example, in a terminal tab of your IDE).

TODO: [Copilot CLI MCP server addition](https://docs.github.com/en/copilot/how-tos/copilot-cli/customize-copilot/add-mcp-servers) is strangely asking for some OAuth ID even with a proper JWT/Bearer header.

### TODO: Other clients?

TODO: Connect AI clients to the MCP server.
