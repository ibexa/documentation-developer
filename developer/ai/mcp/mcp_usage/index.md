# Work with MCP servers

Create custom capabilities for your MCP servers and test them.

Editions: LTS Update

The MCP Servers [LTS Update](../../../ibexa_products/editions/index.md#lts-updates) includes several [built-in tools](../mcp_config/index.md#built-in-tools). Additionally, you can create your own capabilities (tools, prompts, and resources) to expose custom features to AI agents through your MCP servers.

## MCP server capabilities

The Ibexa DXP MCP server framework (`ibexa/mcp`) is built on top of the [official PHP SDK for MCP (`mcp/sdk`)](https://github.com/modelcontextprotocol/php-sdk).

A PHP class that implements MCP server capabilities such as tools, prompts, or resources must:

- implement [`Ibexa\Contracts\Mcp\McpCapabilityInterface`](../../../../../../ibexa/mcp/src/contracts/McpCapabilityInterface.php) so that it can be scanned for capabilities
- use attributes from the [`Ibexa\Contracts\Mcp\Attribute` namespace](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-mcp-attribute.html) to declare capabilities

### Tools

The [`Ibexa\Contracts\Mcp\Attribute\McpTool` attribute](../../../../../../ibexa/mcp/src/contracts/Attribute/McpTool.php) declares a method as an MCP tool. It accepts the following optional arguments:

- `servers` - array of server identifiers the tool is assigned to

  For more information, see [tools configuration](../mcp_config/index.md#tool-configuration).

- `name` - tool codename - if not set, the function name is used

- `title` - tool title for user interfaces - if not set, the `name` is used

- `description` - tool description, used by AI agents to understand the tool's purpose

- `icons` - array of [`Mcp\Schema\Icon`](https://github.com/modelcontextprotocol/php-sdk/blob/main/src/Schema/Icon.php) instances

  For more information, see the [`icons` specification](https://modelcontextprotocol.io/specification/2025-11-25/basic/index#icons).

- `outputSchema` - associative array describing a JSON object response

- `annotations` - [`Mcp\Schema\ToolAnnotations`](https://github.com/modelcontextprotocol/php-sdk/blob/main/src/Schema/ToolAnnotations.php) instance

  For more information, see the [`ToolAnnotations` specification](https://modelcontextprotocol.io/specification/2025-11-25/schema#toolannotations).

- `meta` - free-form array for additional metadata

  For more information, see the [`_meta` specification](https://modelcontextprotocol.io/specification/2025-11-25/basic/index#_meta).

The framework automatically builds an `inputSchema` from the method arguments and their types. To customize or extend the generated schema, you can:

- add descriptions with DocBlock `@param` tags
- use the [`Schema` attribute](https://github.com/php-mcp/server#-schema-generation-and-validation)

If an argument is an [enum](https://www.php.net/manual/en/language.types.enumerations.php), its possible values are listed in the schema ([`UntitledSingleSelectEnumSchema`](https://modelcontextprotocol.io/specification/2025-11-25/schema#untitledsingleselectenumschema)).

### Prompts

MCP servers can also provide [prompt templates](https://modelcontextprotocol.io/specification/2025-11-25/server/prompts) to help users interact with AI agents connected to the server.

Methods that return a prompt are marked with the [`Ibexa\Contracts\Mcp\Attribute\McpPrompt` attribute](../../../../../../ibexa/mcp/src/contracts/Attribute/McpTool.php).

It accepts several arguments that describe how the prompt is used:

- `servers` - array of server identifiers exposing this prompt - required for prompts

- `name` (optional) - prompt codename - if not set, the method name is used

- `title` (optional) - prompt title - if not set, `name` is used

- `description` (optional) - human-readable prompt description

- `icons` (optional) - array of [`Mcp\Schema\Icon`](https://github.com/modelcontextprotocol/php-sdk/blob/main/src/Schema/Icon.php) instances

  For more information, see the [`icons` specification](https://modelcontextprotocol.io/specification/2025-11-25/basic/index#icons).

- `meta` (optional) - rarely used free-form array for additional metadata

  For more information, see the [`_meta` specification](https://modelcontextprotocol.io/specification/2025-11-25/basic/index#_meta).

The framework automatically builds the `arguments` array from the method arguments and their types. Prompt method arguments must be strings to comply with the [`GetPromptRequestParams` schema](https://modelcontextprotocol.io/specification/2025-11-25/schema#getpromptrequestparams). To add argument descriptions, use DocBlock `@param` tags, which are mapped to the `description` defined by the [`PromptArgument` schema](https://modelcontextprotocol.io/specification/2025-11-25/schema#promptargument).

## Example

To keep the example focused on MCP server configuration and capability creation, it doesn't interact with the Ibexa DXP repository.

### Create user account

In this example, the MCP server uses JWT tokens created with a dedicated user account.

In Ibexa DXP's back office, create a user in the **Guest accounts** user group, with login `ibexa-example` and password `Ibexa-3xample`.

### Configure MCP server

This example introduces an MCP server named `example`, with a single tool called `greet`. The server:

- is enabled on the default repository

- is available in all SiteAccesses

- is accessible with the path `/mcp/example`

  For example:

  - `http://localhost/mcp/example`
  - `http://localhost/admin/mcp/example`

- uses file storage for both discovery cache and sessions

> **Note: Storage choice recommendations**
>
> Filesystem storage is convenient for the sake of this example and for testing. For production, it is recommended that you use Redis or Valkey to share cache among the cluster and improve performance.
>
> For development, you can set `discovery_cache: ~` to avoid clearing the cache after each change. This example uses the filesystem storage to illustrate that you have to clear the cache pool to refresh the available capabilities, exactly as when deploying into production.

In a new `config/packages/mcp.yaml` file, define a new MCP server for the `default` repository and assign it to all SiteAccesses:

```yaml
ibexa:
    repositories:
        default:
            mcp:
                example:
                    path: /mcp/example
                    enabled: true
                    description: 'Example MCP Server'
                    instructions: 'Use this server to greet someone.'
                    discovery_cache: cache.tagaware.filesystem
                    session:
                        type: psr16
                        service: cache.tagaware.filesystem
                    allowed_hosts:
                        - '127.0.0.1'
    system:
        default:
            mcp:
                servers:
                    - example
```

Adapt the `allowed_hosts` to your case, for example, if you want to use the DDEV `.ddev.site` domain instead of the equivalent `127.0.0.1` address.

The server is automatically registered as a service with the ID `ibexa.mcp.server.default.example`:

```bash
php bin/console debug:container ibexa.mcp.server.default.example
```

An `ibexa.mcp.example` route is now available:

```bash
php bin/console debug:router ibexa.mcp.example
```

### Create capability class

Create an `ExampleCapabilities` class that implements `McpCapabilityInterface`.

The class contains:

- a method marked with an [`McpTool` attribute](../../../../../../ibexa/mcp/src/contracts/Attribute/McpTool.php) that associates it with the `example` server as the `greet` tool
- a method marked with an [`McpPrompt` attribute](../../../../../../ibexa/mcp/src/contracts/Attribute/McpPrompt.php) that provides a prompt template to users

```php
<?php declare(strict_types=1);

namespace App\Mcp;

use Ibexa\Contracts\Mcp\Attribute\McpPrompt;
use Ibexa\Contracts\Mcp\Attribute\McpTool;
use Ibexa\Contracts\Mcp\McpCapabilityInterface;
use Mcp\Schema\Icon;
use Mcp\Schema\ToolAnnotations;

final readonly class ExampleCapabilities implements McpCapabilityInterface
{
    /**
     * @param string $name The name of the person to greet
     *
     * @return array<string, string>
     */
    #[McpTool(
        servers: ['example'],
        name: 'greet',
        title: 'User greeting',
        description: 'Greet a user by name',
        annotations: new ToolAnnotations(
            readOnlyHint: true,
            destructiveHint: false,
            idempotentHint: true,
            openWorldHint: false,
        ),
        icons: [new Icon(
            src: 'https://openmoji.org/data/color/svg/1F44B.svg',
        )],
        outputSchema: [
            'type' => 'object',
            'properties' => [
                'general' => [
                    'type' => 'string',
                    'description' => 'the safe way to greet someone',
                ],
                'close' => [
                    'type' => 'string',
                    'description' => 'when you\'re close to the person, like friends or relatives',
                ],
                'morning' => [
                    'type' => 'string',
                    'description' => 'when it\'s in the morning',
                ],
                'afternoon' => [
                    'type' => 'string',
                    'description' => 'when it\'s the afternoon',
                ],
                'evening' => [
                    'type' => 'string',
                    'description' => 'when it\'s late in the day',
                ],
            ],
        ],
    )]
    public function greetByName(string $name): array
    {
        return [
            'general' => sprintf('Hello, %s!', $name),
            'close' => sprintf('Hey, %s!', $name),
            'morning' => sprintf('Good morning, %s!', $name),
            'afternoon' => sprintf('Good afternoon, %s!', $name),
            'evening' => sprintf('Good evening, %s!', $name),
        ];
    }

    /**
     * @param string $name The name you want to be greeted by
     *
     * @return array<string, mixed>
     */
    #[McpPrompt(
        servers: ['example'],
        name: 'greet',
        title: 'Be greeted',
        description: 'Prompt to invoke the `greet` tool',
        icons: [new Icon(
            src: 'https://openmoji.org/data/color/svg/1F91D.svg',
        )],
    )]
    public function getGreetPrompt(string $name): array
    {
        return [
            'role' => 'user',
            'content' => [
                'type' => 'text',
                'text' => "Hi. My name is $name. Please, greet me.",
            ],
        ];
    }
}
```

In this example, the `servers` attribute parameter associates only this tool with the `example` server. Alternatively, you can assign all tools from the class to a server by using the `tools` parameter in the server configuration. For more information, see [tools configuration](../mcp_config/index.md#tool-configuration).

For the prompt, the `servers` parameter is required. Therefore, the example prompt must use it to be associated with the `example` server.

During development and testing, you may need to clear the cache to ensure that new or modified capabilities are properly re-discovered. In this example, use the following command:

```bash
php bin/console cache:pool:clear cache.tagaware.filesystem
```

> **Tip: Cache clearing**
>
> During development, clear caches aggressively. The following commands clear all cache types, regardless of where they are stored:
>
> ```bash
> php bin/console cache:clear
> php bin/console cache:pool:clear --all
> ```

### Create MCP server list command

To check the MCP server configuration, create a small command that uses the MCP server configuration registry injected through [`Ibexa\Contracts\Mcp\McpServerConfigurationRegistryInterface`](../../../../../../ibexa/mcp/src/contracts/McpServerConfigurationRegistryInterface.php) and autowiring:

```php
<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Mcp\McpServerConfigurationRegistryInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:mcp:server_list', description: 'List MCP servers')]
class McpServerListCommand
{
    public function __construct(private readonly McpServerConfigurationRegistryInterface $configRegistry)
    {
    }

    public function __invoke(SymfonyStyle $io): int
    {
        foreach($this->configRegistry->getServerConfigurations() as $serverConfiguration) {
            $io->title($serverConfiguration->identifier);
            dump($serverConfiguration);
        }

        return Command::SUCCESS;
    }
}
```

### Perform `curl` test

To test the `example` MCP server, a sequence of `curl` commands is used to simulate the communication between an AI client and the MCP server.

- Ask for a [JWT token through REST](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/User-Token/operation/api_usertokenjwt_post).
- Initialize a connection to the MCP server.
- Validate the MCP Session ID.
- List the available tools.
- Call a tool.

`jq`, `grep`, and `sed` are also used to parse or display outputs.

First, use the shell script to set the Ibexa DXP's base URL, user credentials, and MCP server URL as variables for easier reuse:

```bash
baseUrl='http://localhost' # Adapt to your test case
username='ibexa-example'
password='Ibexa-3xample'
mcpServer="$baseUrl/mcp/example"
```

Before you can communicate with the MCP server, you must first request a JWT token through the REST API:

```bash
curl -s -X 'POST' \
  "$baseUrl/api/ibexa/v2/user/token/jwt" \
  -H 'Content-Type: application/vnd.ibexa.api.JWTInput+json' \
  -H 'Accept: application/vnd.ibexa.api.JWT+json' \
  -d "{
        \"JWTInput\": {
          \"_media-type\": \"application/vnd.ibexa.api.JWTInput+json\",
          \"username\": \"$username\",
          \"password\": \"$password\"
        }
      }" > response.tmp.txt

cat response.tmp.txt | jq
jwtToken=$(cat response.tmp.txt | jq -r .JWT.token)
rm response.tmp.txt
```

```json
{
  "JWT": {
    "_media-type": "application/vnd.ibexa.api.JWT+json",
    "_token": "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ.abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz1234567890ABCD.EFGHIJKL-MNOPQRSTUVWXYZ12345678901234567890",
    "token": "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ.abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz1234567890ABCD.EFGHIJKL-MNOPQRSTUVWXYZ12345678901234567890"
  }
}
```

Then, perform [initialization](https://modelcontextprotocol.io/specification/2025-11-25/basic/lifecycle#initialization) to get an MCP session ID:

```bash
cat response.tmp.txt | jq
jwtToken=$(cat response.tmp.txt | jq -r .JWT.token)
rm response.tmp.txt

curl -s -i -X 'POST' "$mcpServer" \
  -H "Authorization: Bearer $jwtToken" \
  -d '{
        "jsonrpc": "2.0",
        "id": 1,
        "method": "initialize",
        "params": {
          "protocolVersion": "2025-03-26",
          "capabilities": {},
          "clientInfo": {
            "name": "test-curl-client",
            "version": "1.0.0"
          }
        }
      }' > response.tmp.txt

sed '$d' response.tmp.txt
tail -n 1 response.tmp.txt | jq
mcpSessionId=$(cat response.tmp.txt | grep -i 'Mcp-Session-Id:' | sed 's/Mcp-Session-Id: \([0-9a-f-]*\).*/\1/i')
rm response.tmp.txt
```

```http
HTTP/1.1 200 OK
Access-Control-Allow-Headers: Content-Type, Mcp-Session-Id, Mcp-Protocol-Version, Last-Event-ID, Authorization, Accept
Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS
Access-Control-Allow-Origin: *
Access-Control-Expose-Headers: Mcp-Session-Id
Cache-Control: no-cache, private
Content-Type: application/json
Date: Tue, 28 Apr 2026 09:53:27 GMT
Mcp-Session-Id: 12345678-9abc-def0-1234-56789abcdef0
```

```json
{
  "jsonrpc": "2.0",
  "id": 1,
  "result": {
    "protocolVersion": "2025-06-18",
    "capabilities": {
      "logging": {},
      "completions": {},
      "prompts": {
        "listChanged": true
      },
      "resources": {
        "listChanged": true
      },
      "tools": {
        "listChanged": true
      }
    },
    "serverInfo": {
      "name": "example",
      "version": "1.0.0",
      "description": "Example MCP Server"
    },
    "instructions": "Use this server to greet someone."
  }
}
```

Validate the initialization:

```bash
curl -s -i -X 'POST' "$mcpServer" \
  -H "Authorization: Bearer $jwtToken" \
  -H "Mcp-Session-Id: $mcpSessionId" \
  -d '{
        "jsonrpc": "2.0",
        "method": "notifications/initialized"
      }'
```

```http
HTTP/1.1 202 Accepted
Access-Control-Allow-Headers: Content-Type, Mcp-Session-Id, Mcp-Protocol-Version, Last-Event-ID, Authorization, Accept
Access-Control-Allow-Methods: GET, POST, DELETE, OPTIONS
Access-Control-Allow-Origin: *
Access-Control-Expose-Headers: Mcp-Session-Id
```

Get the [list of tools](https://modelcontextprotocol.io/specification/2025-11-25/server/tools#listing-tools):

```bash
curl -s -X 'POST' "$mcpServer" \
  -H "Authorization: Bearer $jwtToken" \
  -H "Mcp-Session-Id: $mcpSessionId" \
  -d '{
        "jsonrpc": "2.0",
        "id": 2,
        "method": "tools/list"
      }' | jq
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
              "description": "The name of the person to greet"
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
        ],
        "outputSchema": {
          "type": "object",
          "properties": {
            "general": {
              "type": "string",
              "description": "the safe way to greet someone"
            },
            "close": {
              "type": "string",
              "description": "when you're close to the person, like friends or relatives"
            },
            "morning": {
              "type": "string",
              "description": "when it's in the morning"
            },
            "afternoon": {
              "type": "string",
              "description": "when it's the afternoon"
            },
            "evening": {
              "type": "string",
              "description": "when it's late in the day"
            }
          }
        }
      }
    ]
  }
}
```

[Call](https://modelcontextprotocol.io/specification/2025-11-25/server/tools#calling-tools) the `greet` tool:

```bash
curl -s -X 'POST' "$mcpServer" \
  -H "Authorization: Bearer $jwtToken" \
  -H "Mcp-Session-Id: $mcpSessionId" \
  -d '{
        "jsonrpc": "2.0",
        "id": 3,
        "method": "tools/call",
        "params": {
          "name": "greet",
          "arguments": {
            "name": "World"
          }
        }
      }' | jq
```

```json
{
  "jsonrpc": "2.0",
  "id": 3,
  "result": {
    "content": [
      {
        "type": "text",
        "text": "{\n    \"general\": \"Hello, World!\",\n    \"close\": \"Hey, World!\",\n    \"morning\": \"Good morning, World!\",\n    \"afternoon\": \"Good afternoon, World!\",\n    \"evening\": \"Good evening, World!\"\n}"
      }
    ],
    "isError": false,
    "structuredContent": {
      "general": "Hello, World!",
      "close": "Hey, World!",
      "morning": "Good morning, World!",
      "afternoon": "Good afternoon, World!",
      "evening": "Good evening, World!"
    }
  }
}
```

Get the [list of prompts](https://modelcontextprotocol.io/specification/2025-11-25/server/prompts#listing-prompts):

```bash
curl -s -X 'POST' "$mcpServer" \
  -H "Authorization: Bearer $jwtToken" \
  -H "Mcp-Session-Id: $mcpSessionId" \
  -d '{
        "jsonrpc": "2.0",
        "id": 4,
        "method": "prompts/list"
      }' | jq
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

[Get the prompt](https://modelcontextprotocol.io/specification/2025-11-25/server/prompts#getting-a-prompt) of the `greet` method:

```bash
curl -s -X 'POST' "$mcpServer" \
  -H "Authorization: Bearer $jwtToken" \
  -H "Mcp-Session-Id: $mcpSessionId" \
  -d '{
        "jsonrpc": "2.0",
        "id": 5,
        "method": "prompts/get",
        "params": {
          "name": "greet",
          "arguments": {
            "name": "Firstname Lastname"
          }
        }
      }' | jq
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
          "text": "Hi. My name is Firstname Lastname. Please, greet me."
        }
      }
    ]
  }
}
```

### Perform MCP Inspector test

You can test your server with the [MCP Inspector](https://modelcontextprotocol.io/docs/tools/inspector). You can even use the inspector as a DDEV add-on with [`michtio/ddev-mcp-inspector`](https://github.com/michtio/ddev-mcp-inspector). You still need to ask for a JWT token through REST or GraphQL APIs, and use it in the MCP Inspector configuration to connect to the server.

You can use a web interface to obtain the JWT token:

- [REST live documentation](../../../api/rest_api/rest_api_authentication/index.md#jwt-token-obtained-through-rest-documentation)
- [GraphiQL](../../../api/graphql/graphql/index.md#jwt-authentication)

#### MCP server settings

In this example, the settings needed to use the MCP Inspector are as follows:

- Transport Type: Streamable HTTP
- URL: actual domain and server `path`, for example `http://localhost/mcp/example`
- Connection Type: Via Proxy
- Authentication:
  - Custom Headers:
    - ☑ `Authorization`
    - `Bearer <JWT token>`
  - OAuth 2.0 Flow: left unedited

![Left panel of MCP Inspector with connection settings for MCP server](https://doc.ibexa.co/en/5.0/ai/mcp/img/mcp-inspector-config.png "MCP Inspector connection settings")

#### Test MCP server within MCP Inspector

In the right panel, in the **Tools** tab, click **List Tools** in the left column. The `greet` tool appears, preceded by its icon. You can select and test it in the right column.

![Right panel of MCP Inspector with a list of tools obtained from MCP server, and the test of the greet tool](https://doc.ibexa.co/en/5.0/ai/mcp/img/mcp-inspector-greet-tool.png "MCP Inspector greet tool test")

In the **Prompts** tab, in the left column, click **List Prompts**. The `greet` prompt appears, preceded by its icon. You can select and test it in the right column.

![Right panel of MCP Inspector with a list of prompts obtained from the MCP server, and the test of the greet prompt](https://doc.ibexa.co/en/5.0/ai/mcp/img/mcp-inspector-greet-prompt.png "MCP Inspector greet prompt test")

### Perform Copilot or Claude Code test

You can test your MCP server with [Copilot CLI](https://docs.github.com/en/copilot/concepts/agents/copilot-cli/about-copilot-cli) or [Claude Code CLI](https://code.claude.com/docs/en/overview), as illustrated here, or with any other agent or interface.

#### Add MCP server to agent CLI

For the sake of the agent test, in this example, you configure the MCP server in an `.mcp.json` file at the Ibexa DXP project root. This way, it is only available for a session opened from there.

You can handle the JWT token for this test in the following ways:

- [Hard-code the JWT token](#hard-coded-variant) into the configuration and update it at every expiration.
- [Wrap a JWT token request and an MCP server call into a script](#fully-scripted-variant).

##### Hard-coded variant

The hard-coded JWT token configuration in `.mcp.json` looks as follows:

```json
{
  "mcpServers": {
    "ibexa-example": {
      "type": "http",
      "url": "http://localhost/mcp/example",
      "headers": {
        "Authorization": "Bearer <JWT token>"
      },
      "tools": ["*"]
    }
  }
}
```

The `.mcp.json` file must be edited to update the JWT token each time it expires. You can request a token by using the GraphiQL web interface or a `curl` command, and then edit the file manually. Alternatively, you can configure a shell script to request the JWT token, extract it from the response, and replace it in the file.

When Copilot or Claude Code complains that it can't communicate with the MCP server:

**Copilot CLI**

- Update the JWT token in the `.mcp.json` file.
- Reload the MCP servers in Copilot CLI with one of these methods:
  - Run `/mcp reload` command to reload all MCP servers.
  - Run `/mcp disable ibexa-example` and `/mcp enable ibexa-example` to only reload the `ibexa-example` server.

> **Note: Reloading multiple MCP servers**
>
> If you have several MCP servers enabled globally, reloading all of them at the same time can be time-consuming. Consider reloading them one by one.

**Claude Code CLI**

- Update the JWT token in the `.mcp.json` file.
- Run `/mcp reconnect ibexa-example` command to reconnect the `ibexa-example` MCP server.

##### Fully scripted variant

The wrapping script configuration in `.mcp.json` looks as follows:

```json
{
  "mcpServers": {
    "ibexa-example": {
      "type": "stdio",
      "command": "bash",
      "args": ["mcp-ibexa-example-wrapper.sh"],
      "tools": ["*"]
    }
  }
}
```

`mcp-ibexa-example-wrapper.sh` is a script that requests a JWT token and establishes a connection with the MCP server.

For example, thanks to [`npx`](https://www.npmjs.com/package/npx), you can do it with [Supergateway](https://www.npmjs.com/package/supergateway) without a local installation:

```bash
#!/bin/bash
set -e

baseUrl='http://localhost' # Adapt to your test case
mcpServer="$baseUrl/mcp/example"

jwtToken=$(curl -s -X 'POST' \
  "$baseUrl/api/ibexa/v2/user/token/jwt" \
  -H 'Content-Type: application/vnd.ibexa.api.JWTInput+json' \
  -H 'Accept: application/vnd.ibexa.api.JWT+json' \
  -d '{
        "JWTInput": {
          "_media-type": "application/vnd.ibexa.api.JWTInput+json",
          "username": "ibexa-example",
          "password": "Ibexa-3xample"
        }
      }' | jq -r .JWT.token)

exec npx -y supergateway \
  --streamableHttp "$mcpServer" \
  --oauth2Bearer "$jwtToken" \
  --logLevel none
```

When the agent complains that it can't communicate with the MCP server, reload it:

**Copilot CLI**

Reload the MCP servers in Copilot CLI with one of these methods:

- Run `/mcp reload` command to reload all MCP servers.
- Run `/mcp disable ibexa-example` and `/mcp enable ibexa-example` to only reload the `ibexa-example` server.

> **Note: Reloading multiple MCP servers**
>
> If you have several MCP servers enabled globally, reloading all of them at the same time can be time-consuming. Consider reloading them one by one.

**Claude Code CLI**

Run `/mcp reconnect ibexa-example` command to reconnect the `ibexa-example` MCP server.

#### Run MCP server test with Copilot CLI or Claude Code CLI

Launch the agent CLI at the project root, where the `.mcp.json` file is located:

**Copilot CLI**

```bash
cd /path/to/project
copilot
```

**Claude Code CLI**

```bash
cd /path/to/project
claude
```

If prompted, confirm that you trust the files in this folder. You may choose to have your choice remembered for the future.

You can check the MCP server status and details with the `/mcp` command:

**Copilot CLI**

Run the `/mcp show ibexa-example` command to check the MCP server status and details:

```text
MCP Server: ibexa-example

Type:     stdio
Command:  bash
Status:   ✓ Connected
Source:   /path/to/project/.mcp.json

Tools (1/1 enabled):
 ✓ greet: Greet a user by name (70 tokens)
```

**Claude Code CLI**

Run the `/mcp` command and select ibexa-example to check the MCP server status and details:

```text
Ibexa-example MCP Server                                                                                                                                                                                    

Status:           ✔ connected                                                                                                                                                                               
Command:          bash                                                                                                                                                                                      
Args:             mcp-ibexa-example-wrapper.sh                                                                                                                                                              
Config location:  /path/to/project/.mcp.json                                                                                                                                          
Capabilities: tools                                                                                                                                                                                         
Tools: 1 tool
```

You can prompt the agent to greet you. It should use the `greet` tool to do so.

- You can ask it "Please, greet me." and it might respond with a request for your name if it doesn't already know it.
- You can also give it another name to greet, as shown in the prompt template.

During a morning session, the interaction could look like this:

**Copilot CLI**

```text
❯ Hi. Please, greet me.

◐ The user wants to be greeted. I'll use the ibexa-example-greet tool, but I don't know their name. Let me ask them first... actually, the tool requires a name. Let me ask the user for their name.

  Wait, actually I can just greet them without knowing their name using a general greeting, but the tool requires a name parameter. Let me ask for their name.

● Asked user What's your name?
  └ Pulley

● Greet a user (MCP: ibexa-example) · name: "Pulley"
  └ {"general":"Hello, Pulley!","close":"Hey, Pulley!","morning":"Good morning, P...

● Good morning, Pulley! ☀️

❯ Hi. Please, greet me. We're close friends.

◐ The user wants a close friend greeting. From the previous response, I can see the "close" greeting is "Hey, Pulley!"

● Greet a user (MCP: ibexa-example) · name: "Pulley"
  └ {"general":"Hello, Pulley!","close":"Hey, Pulley!","morning":"Good morning, P...

● Hey, Pulley! 😄

❯ Please, greet someone named "ElePHPant" in a general way (so I could reuse it at any time)

◐ The user wants a general greeting for someone named "ElePHPant".

● greet (MCP: ibexa-example) · name: "ElePHPant"
  └ {"general":"Hello, ElePHPant!","close":"Hey, ElePHPant!","morning":"Good morn...

● Hello, ElePHPant! 🐘

❯ Please, greet someone named "ElePHPant" like it's 22:30

◐ 22:30 is evening time, so I'll use the evening greeting.

● greet (MCP: ibexa-example) · name: "ElePHPant"
  └ {"general":"Hello, ElePHPant!","close":"Hey, ElePHPant!","morning":"Good morn...

● Good evening, ElePHPant! 🌙
```

**Claude Code CLI**

```text
❯ Hi. Please, greet me.

⏺ What's your name?

✻ Worked for 3s

❯ Pulley

  Called ibexa-example

⏺ Hello, Pulley! 👋

✻ Churned for 4s

❯ Hi. Please, greet me. We're close friends now.

  Called ibexa-example

⏺ Hey, Pulley! 👋

✻ Baked for 4s

❯ Please, greet someone named "ElePHPant" in a general way (so I could reuse it at any time)

  Called ibexa-example

⏺ Hello, ElePHPant!

✻ Brewed for 5s

❯ Please, greet someone named "ElePHPant" like it's 22:30

⏺ That falls under the "evening" variant: Good evening, ElePHPant!   

✻ Sautéed for 2s
```

The agent's reflections, reaction times, and final responses, including the improvised emojis, may differ from those examples. The key point is that the agent decides to use the `greet` tool, calls it with the right argument, and then uses the call result in its final output.

You can fine-tune the prompt, or remove unnecessary variants if needed. For example, you could instruct the agent to always use the time-of-day variants, or simply remove the `general` and `close` variants. Removing what's unnecessary is more efficient than extending the instructions.
