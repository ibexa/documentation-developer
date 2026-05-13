---
description: Create custom capabilities for your MCP servers and test them.
edition: lts-update
month_change: true
---

# MCP server usage

MCP Servers LTS Update comes with few [built-in tools](mcp_config.md#built-in-tools).
You can create your own capabilities (tools, prompts, and resources) to expose custom features to AI agents through your MCP servers.

## MCP server capabilities

The [[= product_name =]] MCP server framework (`ibexa/mcp`) is built on top of [the official PHP SDK for MCP (`mcp/sdk`)](https://github.com/modelcontextprotocol/php-sdk)

A PHP class implementing MCP server capabilities like tools, prompts, or resources, must:

- implement [`Ibexa\Contracts\Mcp\McpCapabilityInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-McpCapabilityInterface.html) to be scanned for capabilities
- use attributes from the [`Ibexa\Contracts\Mcp\Attribute` namespace](/api/php_api/php_api_reference/namespaces/ibexa-contracts-mcp-attribute.html) to define capabilities.

### Tools

The [`Ibexa\Contracts\Mcp\Attribute\McpTool` attribute](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-Attribute-McpTool.html) declares a method as an MCP tool.
It has several arguments to describe the tool usage and output:

- `servers` (optional): an array of identifiers of servers this tool is assigned to - for more information, see [tools configuration](mcp_config.md#tools-configuration)
- `name` (optional): the name of the tool - if not set, the function name is used as the tool name
- `description` (optional): description of the tool, used by the AI agent to understand the tool's purpose
- `icons` (optional): an array of [`Mcp\Schema\Icon`](https://github.com/modelcontextprotocol/php-sdk/blob/main/src/Schema/Icon.php) instances - for more information, see [`icons` specification](https://modelcontextprotocol.io/specification/latest/basic/index#icons)
- `outputSchema` (optional): for JSON object output, an associative array describing this object
- `annotations` (optional): a [`Mcp\Schema\ToolAnnotations`](https://github.com/modelcontextprotocol/php-sdk/blob/main/src/Schema/ToolAnnotations.php) instance - for more information, see [`ToolAnnotations` specification](https://modelcontextprotocol.io/specification/2025-11-25/schema#toolannotations)
- `meta` (optional): a free-form array for any additional metadata - for more information, see [`_meta` specification](https://modelcontextprotocol.io/specification/latest/basic/index#_meta)

An `inputSchema` is automatically built from the function arguments and their types.
To override or complement the automatically generated input schema,
you can use a DocBlock comment with `@param` tags to add descriptions,
or use the [`Schema` attribute](https://github.com/php-mcp/server#-schema-generation-and-validation).
If an argument is an [enum](https://www.php.net/manual/en/language.types.enumerations.php), its possible values are listed in the schema ([`UntitledSingleSelectEnumSchema`](https://modelcontextprotocol.io/specification/latest/schema#untitledsingleselectenumschema)).

### Prompts

MCP servers can also provide [prompt templates](https://modelcontextprotocol.io/specification/latest/server/prompts) to guide the user interacting with the AI having this MCP server at its disposal.

The [`Ibexa\Contracts\Mcp\Attribute\McpPrompt` attribute](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-Attribute-McpTool.html) defines a method as returning a prompt.

It has several arguments to describe the prompt usage:

- `servers`: an array of identifiers of servers proposing this prompt - notice that this is required for prompts
- `name` (optional): the name of the prompt - if not set, the function name is used as the prompt name
- `description` (optional): a human-readable description of the prompt
- `icons` (optional): an array of [`Mcp\Schema\Icon`](https://github.com/modelcontextprotocol/php-sdk/blob/main/src/Schema/Icon.php) instances - for more information, see [`icons` specification](https://modelcontextprotocol.io/specification/latest/basic/index#icons)
- `meta` (optional): a rarely used free-form array for any additional metadata - for more information, see [`_meta` specification](https://modelcontextprotocol.io/specification/latest/basic/index#_meta)

An `arguments` array is automatically built from the function arguments and their types.
The prompt's function arguments must be strings (to respect the [`GetPromptRequestParams` schema](https://modelcontextprotocol.io/specification/latest/schema#getpromptrequestparams)).
To add descriptions (as in the [`PromptArgument` schema](https://modelcontextprotocol.io/specification/latest/schema#promptargument)), use a DocBlock comment with `@param` tags.

## Example

To focus on the MCP server configuration and capabilities creation, this example doesn't even interact with [[= product_name =]] repository.

### User account

In this example, the MCP server uses JWT tokens created with a dedicated account.

In [[= product_name =]]'s back office, create a user, for example, in **Guest accounts** user group, with login `ibexa-example`, and password `Ibexa-3xample`.

### Configure MCP server

This example introduce an `example` MCP server with a single `greet` tool.
It's enabled on the default repository and all SiteAccesses.
It's accessible with the path `/mcp/example` (for example, on `http://localhost/mcp/example` and `http://localhost/admin/mcp/example`).
It uses files for both discovery cache and session storage.
(Redis/Valkey would probably be better for session storage in production, but file storage is easier for this example and testing.)

In a new `config/packages/mcp.yaml` file, define a new MCP server for the `default` repository and assign it to all SiteAccesses:

``` yaml
[[= include_code('code_samples/mcp/config/packages/mcp.yaml') =]]
```

An `ibexa.mcp.example` route is now available:

```bash
php bin/console debug:router ibexa.mcp.example
```

### Create capability class

An `ExampleCapabilities` class implementing the `McpCapabilityInterface` is created.

It contains a function with an `McpTool` attribute associating it to the `example` server as `greet` tool for the AI.

It also contains a function with the `McpPrompt` attribute to provide a prompt template to the user.

``` php
[[= include_code('code_samples/mcp/src/Mcp/ExampleCapabilities.php') =]]
```

For the example, `servers` attribute parameter is used to associate only this tool to the `example` server.
All tools from this class could be added to a server by using the `tools` parameter in server configuration.
For more information, see [tools configuration](mcp_config.md#tools-configuration).

For prompt, the `servers` parameter is required.
So, the example prompt has to use it to be associated with the `example` server.

During development and testing, you may have to clear the cache to make sure new or modified capabilities are properly re-discovered.
In this example, regarding its configuration, `php bin/console cache:pool:clear cache.tagaware.filesystem` has to be used.

!!! tip "Cache clearing"

    Have no mercy for the cache during development. But use the right commands to be sure to delete it.
    The following pair of commands ensure all types of caches are cleared wherever stored:
    ```bash
    php bin/console cache:clear
    php bin/console cache:pool:clear --all
    ```

### Create MCP server list command

To check the server configuration, a short command using the MCP server configuration registry
(injected through [`McpServerConfigurationRegistryInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Mcp-McpServerConfigurationRegistryInterface.html) and autowiring):

``` php
[[= include_code('code_samples/mcp/src/Command/McpServerListCommand.php') =]]
```

### `curl` test

To test the `example` MCP server, a sequence of `curl` commands is used to simulate an AI client to MCP server communication.

- Ask for a [JWT token through REST](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/User-Token/operation/api_usertokenjwt_post)
- Initialize a connection to the MCP server
- Validate the MCP Session ID
- List the available tools
- Call a tool

`jq`, `grep`, and `sed` are also used to parse or display outputs.

First, the shell script set the [[= product_name =]] base URL and the user credentials into variables for easier reuse:

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 5, 7) =]]
```

Before communicating with the MCP server, the request of a JWT token through REST API:

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 9, 23) =]]
```

``` json
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 1, 7) =]]
```

The [initialization](https://modelcontextprotocol.io/specification/latest/basic/lifecycle#initialization) to get an MCP session ID:

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 21, 44) =]]
```

``` http
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 8, 16) =]]
```

``` json
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 26, 51) =]]
```

The validation of the initialization:

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 46, 52) =]]
```

``` http
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 52, 56) =]]
```

The [list of tools](https://modelcontextprotocol.io/specification/latest/server/tools#listing-tools):

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 54, 61) =]]
```

``` json
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 69, 128) =]]
```

The `greet` [tool call](https://modelcontextprotocol.io/specification/latest/server/tools#calling-tools):

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 63, 76) =]]
```

``` json
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 129, 148) =]]
```

The [list of prompts](https://modelcontextprotocol.io/specification/latest/server/prompts#listing-prompts):

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 78, 85) =]]
```

``` json
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 149, 172) =]]
```

The `greet` [prompt obtainment](https://modelcontextprotocol.io/specification/2025-11-25/server/prompts#getting-a-prompt):

``` bash
[[= include_code('code_samples/mcp/mcp.sh', 87, 100) =]]
```

``` json
[[= include_code('code_samples/mcp/mcp.sh.output.txt', 173, 187) =]]
```

### MCP Inspector test

To test your server, you can use the [MCP Inspector](https://modelcontextprotocol.io/docs/tools/inspector).
It's even possible to use it as a DDEV add-on with [`craftpulse/ddev-mcp-inspector`](https://github.com/craftpulse/ddev-mcp-inspector).
You still need to ask for a JWT token through REST or GraphQL, and use it in the MCP Inspector configuration to connect to your server.

You can use a Web interface to obtain a JWT token:

- [REST live documentation](rest_api_authentication.md#jwt-token-obtained-through-rest-documentation)
- [GraphiQL](graphql.md#jwt-authentication)

#### MCP server settings

To use the MCP Inspector for this example, the settings are:

- Transport Type: Streamable HTTP
- URL: actual domain and server `path`, for example `http://localhost/mcp/example`
- Connection Type: Via Proxy
- Authentication:
    - Custom Headers:
        - <big>☑</big> `Authorization`
        - `Bearer <JWT token>`
    - OAuth 2.0 Flow: left unedited

![Screenshot of the left pannel of the MCP Inspector with the connection settings for the example MCP server](img/mcp-inspector-config.png "MCP Inspector connection settings")

#### MCP server test within MCP Inspector

In the right panel, in the **Tools** tab, click **List Tools** button in the left column.
The `greet` tool appears preceded by its icon.
It can be selected and tested in the right column.

![Screenshot of the right pannel of the MCP Inspector with the list of tools obtained from the example MCP server, and the test of the `greet` tool](img/mcp-inspector-greet-tool.png "MCP Inspector `greet` tool test")

In the **Prompts** tab, click **List Prompts** button in the left column.
The `greet` prompt appears preceded by its icon.
It can be selected and tested in the right column.

![Screenshot of the right pannel of the MCP Inspector with the list of prompts obtained from the example MCP server, and the test of the `greet` prompt](img/mcp-inspector-greet-prompt.png "MCP Inspector `greet` prompt test")

### Copilot CLI test

#### MCP server addition to Copilot CLI

For this example test with [Copilot CLI](https://docs.github.com/en/copilot/concepts/agents/copilot-cli/about-copilot-cli),
the MCP server configuration is done in an `.mcp.json` file at the [[= product_name =]] project root
to make it only available for a session opened from there.

There is two ways of dealing with the JWT token for this test:

- to hard code the JWT token in the configuration and update it at every expiration
- to wrap JWT token request and MCP server call into a script

##### Hard coded

The hard coded JWT token configuration in `.mcp.json`:

``` json
[[= include_code('code_samples/mcp/http.mcp.json') =]]
```

The `.mcp.json` file must be edited to update the JWT token each time it expires.
You can ask a token using, for example, GraphiQL web interface or a `curl` command, then edit the file manually.
Or you can have a shell script doing the JWT token request, extracting it from the response, and replace it in the file.

When Copilot complains that it can't communicate with the MCP server:

- update the JWT token in the `.mcp.json` file
- reload the MCP servers in Copilot CLI with one of those methods:
    - run `/mcp reload` command which reload all MCP servers
    - run `/mcp disable ibexa-example` then `/mcp enable ibexa-example` to only reload the `ibexa-example` server

##### Fully scripted

The wrapping script configuration in `.mcp.json`:

``` json
[[= include_code('code_samples/mcp/stdio.mcp.json') =]]
```

The `mcp-ibexa-example-wrapper.sh` is a script asking for a JWT token then establishing a connection with the MCP server.

For example, this can be achieved with [Supergateway](https://www.npmjs.com/package/supergateway) without local installation thanks to [`npx`](https://www.npmjs.com/package/npx):

``` bash
[[= include_code('code_samples/mcp/mcp-ibexa-example-wrapper.sh') =]]
```

When Copilot complains that it can't communicate with the MCP server, reload the MCP servers in Copilot CLI with one of those methods:

- run `/mcp reload` command which reload all MCP servers (which can be annoying if you have several MCP servers globally enabled)
- run `/mcp disable ibexa-example` then `/mcp enable ibexa-example` to only reload the `ibexa-example` server

TODO: [`/mcp add` Copilot CLI MCP server addition](https://docs.github.com/en/copilot/how-tos/copilot-cli/customize-copilot/add-mcp-servers) is strangely asking for some OAuth ID even with a proper JWT/Bearer header.

#### MCP server test with Copilot CLI

Launch Copilot CLI at the project root (where the `.mcp.json` file is located):

```bash
cd /path/to/project
copilot
```

If needed, confirm that you trust the files in this folder when prompted (with or without remembering the answer for the future).

With the command `/mcp show ibexa-example`, you can check server status and details:

```text
 MCP Server: ibexa-example

 Type:     http
 URL:      http://localhost/mcp/example
 Status:   ✓ Connected
 Source:   /path/to/project/.mcp.json

 Tools (1/1 enabled):
  ✓ greet: Greet a user by name
```

You can prompt Copilot to greet you. It should take the initiative to use the `greet` tool to do so.

- You can ask it "Please, greet me." and it might ask you your name if it doesn't already know it.
- You can additionally give it a name to greet (like in the prompt template).

During a morning session, the interaction could look like this:

```
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

The Copilot reflexion and its final answer, like the improvised emoji, might differ from this session example.
The important part is that Copilot CLI thinks to use the `greet` tool, calls it with the right argument, displays the call result, and uses it.
