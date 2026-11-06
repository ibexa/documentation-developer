---
description: Create custom capabilities for your MCP servers and test them.
edition: lts-update
month_change: true
---

# Work with MCP servers

The MCP Servers [LTS Update](editions.md#lts-updates) includes several [built-in tools](mcp_config.md#built-in-tools).
Additionally, you can create your own capabilities (tools, prompts, and resources) to expose custom features to AI agents through your MCP servers.

## MCP server capabilities

The [[= product_name =]] MCP server framework (`ibexa/mcp`) is built on top of the [official PHP SDK for MCP (`mcp/sdk`)](https://github.com/modelcontextprotocol/php-sdk).

A PHP class that implements MCP server capabilities such as tools, prompts, or resources must:

- implement [`Ibexa\Contracts\Mcp\McpCapabilityInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-McpCapabilityInterface.html) so that it can be scanned for capabilities
- use attributes from the [`Ibexa\Contracts\Mcp\Attribute` namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-mcp-attribute.html) to declare capabilities

### Tools

The [`Ibexa\Contracts\Mcp\Attribute\McpTool` attribute](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-Attribute-McpTool.html) declares a method as an MCP tool.
It accepts the following optional arguments:

- `servers` - array of server identifiers the tool is assigned to
  <br>For more information, see [tools configuration](mcp_config.md#tool-configuration).
- `name` - tool codename - if not set, the function name is used
- `title` - tool title for user interfaces - if not set, the `name` is used
- `description` - tool description, used by AI agents to understand the tool's purpose
- `icons` - array of [`Mcp\Schema\Icon`](https://github.com/modelcontextprotocol/php-sdk/blob/main/src/Schema/Icon.php) instances
  <br>For more information, see the [`icons` specification](https://modelcontextprotocol.io/specification/2025-11-25/basic/index#icons).
- `outputSchema` - associative array describing a JSON object response
- `annotations` - [`Mcp\Schema\ToolAnnotations`](https://github.com/modelcontextprotocol/php-sdk/blob/main/src/Schema/ToolAnnotations.php) instance
  <br>For more information, see the [`ToolAnnotations` specification](https://modelcontextprotocol.io/specification/2025-11-25/schema#toolannotations).
- `meta` - free-form array for additional metadata
  <br>For more information, see the [`_meta` specification](https://modelcontextprotocol.io/specification/2025-11-25/basic/index#_meta).

The framework automatically builds an `inputSchema` from the method arguments and their types.
To customize or extend the generated schema, you can:

- add descriptions with DocBlock `@param` tags
- use the [`Schema` attribute](https://github.com/php-mcp/server#-schema-generation-and-validation)

If an argument is an [enum](https://www.php.net/manual/en/language.types.enumerations.php), its possible values are listed in the schema ([`UntitledSingleSelectEnumSchema`](https://modelcontextprotocol.io/specification/2025-11-25/schema#untitledsingleselectenumschema)).

### Prompts

MCP servers can also provide [prompt templates](https://modelcontextprotocol.io/specification/2025-11-25/server/prompts) to help users interact with AI agents connected to the server.

Methods that return a prompt are marked with the [`Ibexa\Contracts\Mcp\Attribute\McpPrompt` attribute](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-Attribute-McpTool.html).

It accepts several arguments that describe how the prompt is used:

- `servers` - array of server identifiers exposing this prompt - required for prompts
- `name` (optional) - prompt codename - if not set, the method name is used
- `title` (optional) - prompt title - if not set, `name` is used
- `description` (optional) - human-readable prompt description
- `icons` (optional) - array of [`Mcp\Schema\Icon`](https://github.com/modelcontextprotocol/php-sdk/blob/main/src/Schema/Icon.php) instances
  <br>For more information, see the [`icons` specification](https://modelcontextprotocol.io/specification/2025-11-25/basic/index#icons).
- `meta` (optional) - rarely used free-form array for additional metadata
  <br>For more information, see the [`_meta` specification](https://modelcontextprotocol.io/specification/2025-11-25/basic/index#_meta).

The framework automatically builds the `arguments` array from the method arguments and their types.
Prompt method arguments must be strings to comply with the [`GetPromptRequestParams` schema](https://modelcontextprotocol.io/specification/2025-11-25/schema#getpromptrequestparams).
To add argument descriptions, use DocBlock `@param` tags, which are mapped to the `description` defined by the [`PromptArgument` schema](https://modelcontextprotocol.io/specification/2025-11-25/schema#promptargument).

## Example

To keep the example focused on MCP server configuration and capability creation, it doesn't interact with the [[= product_name =]] repository.

### Create user account

In this example, the MCP server uses JWT tokens created with a dedicated user account.

In [[= product_name =]]'s back office, create a user in the **Guest accounts** user group, with login `ibexa-example` and password `Ibexa-3xample`.

### Configure MCP server

This example introduces an MCP server named `example`, with a single tool called `greet`.
The server:

- is enabled on the default repository
- is available in all SiteAccesses
- is accessible with the path `/mcp/example`
  <br>For example:
    - `http://localhost/mcp/example`
    - `http://localhost/admin/mcp/example`
- uses file storage for both discovery cache and sessions

!!! note "Storage choice recommendations"

    Filesystem storage is convenient for the sake of this example and for testing.
    For production, it is recommended that you use Redis or Valkey to share cache among the cluster and improve performance.

    For development, you can set `discovery_cache: ~` to avoid clearing the cache after each change.
    This example uses the filesystem storage to illustrate that you have to clear the cache pool to refresh the available capabilities, exactly as when deploying into production.

In a new `config/packages/mcp.yaml` file, define a new MCP server for the `default` repository and assign it to all SiteAccesses:

``` yaml
[[= include_code('code_samples/mcp/config/packages/mcp.yaml') =]]
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

- a method marked with an [`McpTool` attribute](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-Attribute-McpTool.html) that associates it with the `example` server as the `greet` tool
- a method marked with an [`McpPrompt` attribute](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-Attribute-McpPrompt.html) that provides a prompt template to users

``` php
[[= include_code('code_samples/mcp/src/Mcp/ExampleCapabilities.php') =]]
```

In this example, the `servers` attribute parameter associates only this tool with the `example` server.
Alternatively, you can assign all tools from the class to a server by using the `tools` parameter in the server configuration.
For more information, see [tools configuration](mcp_config.md#tool-configuration).

For the prompt, the `servers` parameter is required.
Therefore, the example prompt must use it to be associated with the `example` server.

During development and testing, you may need to clear the cache to ensure that new or modified capabilities are properly re-discovered.
In this example, use the following command:

```bash
php bin/console cache:pool:clear cache.tagaware.filesystem
```

!!! tip "Cache clearing"

    During development, clear caches aggressively.
    The following commands clear all cache types, regardless of where they are stored:
    ```bash
    php bin/console cache:clear
    php bin/console cache:pool:clear --all
    ```

### Create MCP server list command

To check the MCP server configuration, create a small command that uses the MCP server configuration registry injected through [`McpServerConfigurationRegistryInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-McpServerConfigurationRegistryInterface.html) and autowiring:

``` php
[[= include_code('code_samples/mcp/src/Command/McpServerListCommand.php') =]]
```

### Perform `curl` test

To test the `example` MCP server, a sequence of `curl` commands is used to simulate the communication between an AI client and the MCP server.

- Ask for a [JWT token through REST](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/User-Token/operation/api_usertokenjwt_post).
- Initialize a connection to the MCP server.
- Validate the MCP Session ID.
- List the available tools.
- Call a tool.

`jq`, `grep`, and `sed` are also used to parse or display outputs.

First, use the shell script to set the [[= product_name =]]'s base URL, user credentials, and MCP server URL as variables for easier reuse:

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 5, 8) =]]
```

Before you can communicate with the MCP server, you must first request a JWT token through the REST API:

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 10, 24) =]]
```

``` json
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 1, 7) =]]
```

Then, perform [initialization](https://modelcontextprotocol.io/specification/2025-11-25/basic/lifecycle#initialization) to get an MCP session ID:

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 22, 45) =]]
```

``` http
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 8, 16) =]]
```

``` json
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 26, 51) =]]
```

Validate the initialization:

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 47, 53) =]]
```

``` http
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 52, 56) =]]
```

Get the [list of tools](https://modelcontextprotocol.io/specification/2025-11-25/server/tools#listing-tools):

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 55, 62) =]]
```

``` json
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 69, 128) =]]
```

[Call](https://modelcontextprotocol.io/specification/2025-11-25/server/tools#calling-tools) the `greet` tool:

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 64, 77) =]]
```

``` json
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 129, 148) =]]
```

Get the [list of prompts](https://modelcontextprotocol.io/specification/2025-11-25/server/prompts#listing-prompts):

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 79, 86) =]]
```

``` json
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 149, 172) =]]
```

[Get the prompt](https://modelcontextprotocol.io/specification/2025-11-25/server/prompts#getting-a-prompt) of the `greet` method:

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 88, 101) =]]
```

``` json
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 173, 187) =]]
```

### Perform MCP Inspector test

You can test your server with the [MCP Inspector](https://modelcontextprotocol.io/docs/tools/inspector).
You can even use the inspector as a DDEV add-on with [`michtio/ddev-mcp-inspector`](https://github.com/michtio/ddev-mcp-inspector).
You still need to ask for a JWT token through REST or GraphQL APIs, and use it in the MCP Inspector configuration to connect to the server.

You can use a web interface to obtain the JWT token:

- [REST live documentation](rest_api_authentication.md#jwt-token-obtained-through-rest-documentation)
- [GraphiQL](graphql.md#jwt-authentication)

#### MCP server settings

In this example, the settings needed to use the MCP Inspector are as follows:

- Transport Type: Streamable HTTP
- URL: actual domain and server `path`, for example `http://localhost/mcp/example`
- Connection Type: Via Proxy
- Authentication:
    - Custom Headers:
        - <big>☑</big> `Authorization`
        - `Bearer <JWT token>`
    - OAuth 2.0 Flow: left unedited

![Left panel of MCP Inspector with connection settings for MCP server](img/mcp-inspector-config.png "MCP Inspector connection settings")

#### Test MCP server within MCP Inspector

In the right panel, in the **Tools** tab, click **List Tools** in the left column.
The `greet` tool appears, preceded by its icon.
You can select and test it in the right column.

![Right panel of MCP Inspector with a list of tools obtained from MCP server, and the test of the `greet` tool](img/mcp-inspector-greet-tool.png "MCP Inspector `greet` tool test")

In the **Prompts** tab, in the left column, click **List Prompts**.
The `greet` prompt appears, preceded by its icon.
You can select and test it in the right column.

![Right panel of MCP Inspector with a list of prompts obtained from the MCP server, and the test of the `greet` prompt](img/mcp-inspector-greet-prompt.png "MCP Inspector `greet` prompt test")

### Perform Copilot or Claude Code test

You can test your MCP server with [Copilot CLI](https://docs.github.com/en/copilot/concepts/agents/copilot-cli/about-copilot-cli) or [Claude Code CLI](https://code.claude.com/docs/en/overview), as illustrated here, or with any other agent or interface.

#### Add MCP server to agent CLI

To add an MCP server to your agent, you need to request a JWT token, then configure the MCP server in your agent as a [Streamable HTTP](https://modelcontextprotocol.io/specification/2025-11-25/basic/transports#streamable-http) with a `Authentication: Bearer <token>` header.

You can request a JWT token manually, as described in [Testing with MCP Inspector](#perform-mcp-inspector-test), or automate the process.

The following script uses `curl` to request a JWT token, then creates or updates the MCP server configuration.
It works with Copilot CLI and Claude Code CLI.

You can save the script in the project root, but do not commit it because it contains credentials.

```bash
[[= include_code('code_samples/mcp/mcp-ibexa-example-installer.sh') =]]
```

#### Run MCP server test with Copilot CLI or Claude Code CLI

Launch the agent CLI at the project root:

=== "Copilot CLI"

    ```bash
    cd /path/to/project
    bash mcp-ibexa-example-installer.sh
    copilot
    ```

=== "Claude Code CLI"

    ```bash
    cd /path/to/project
    bash mcp-ibexa-example-installer.sh
    claude
    ```

If prompted, confirm that you trust the files in this folder.
You may choose to have your choice remembered for the future.

You can check the MCP server status and details with the `/mcp` command:

=== "Copilot CLI"

    Run the `/mcp show ibexa-example` command to check the MCP server status and details:

    ``` text
    MCP · ibexa-example

    id: ibexa-example                                                                                                                                                                                                
    kind: mcp                                                                                                                                                                                                      
    name: ibexa-example                                                                                                                                                                                              
    scope: User                                                                                                                                                                                                    
    enabled: ✓ yes                                                                                                                                                                                                 
    trust: {                                                                                                                                                                                                       
      "origin": {                                                                                                                                                                                                  
      "kind": "user"                                                                                                                                                                                             
      },                                                                                                                                                                                                           
      "capabilities": {},                                                                                                                                                                                          
      "permissions": {}                                                                                                                                                                                            
    }

    tools (1)                                                                                                                                                                                                      
    greet: Greet a user by name

    data                                                                                                                                                                                                           
    {                                                                                                                                                                                                              
      "name": "ibexa-example",                                                                                                                                                                                       
      "status": "connected",                                                                                                                                                                                       
      "serverMetadata": {                                                                                                                                                                                          
        "instructions": "Use this server to greet someone."                                                                                                                                                        
      },                                                                                                                                                                                                           
      "url": "http://localhost/mcp/example",                                                                                                                                                   
      "source": "user"                                                                                                                                                                                             
    }
```

=== "Claude Code CLI"

    Run the `/mcp` command and select ibexa-example to check the MCP server status and details:

    ``` text
    Ibexa-example MCP Server                                                                                                                                                                                    

   Status:           ✔ connected
   Auth:             ✔ authenticated
   URL:              http
   Config location:  ~/.claude.json [project: /path/to/project]
   Capabilities: tools · prompts
   Tools: 1 tool
    ```

If a server appears as disconected, re-run the installer (`bash mcp-ibexa-example-installer.sh`) so a fresh JWT token is generated and set.

You can prompt the agent to greet you.
It should use the `greet` tool to do so.

- You can ask it "Please, greet me." and it might respond with a request for your name if it doesn't already know it.
- You can also give it another name to greet, as shown in the prompt template.

During a morning session, the interaction could look like this:

=== "Copilot CLI"

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

=== "Claude Code CLI"

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

The agent's reflections, reaction times, and final responses, including the improvised emojis, may differ from those examples.
The key point is that the agent decides to use the `greet` tool, calls it with the right argument, and then uses the call result in its final output.

You can fine-tune the prompt, or remove unnecessary variants if needed.
For example, you could instruct the agent to always use the time-of-day variants, or simply remove the `general` and `close` variants.
Removing what's unnecessary is more efficient than extending the instructions.
