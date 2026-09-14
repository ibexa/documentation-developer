---
description: Create custom capabilities for your MCP servers and test them.
month_change: true
saas_review:
    - siteaccess
    - links_removed
saas_review_note: >-
    An MCP server is declared for a repository and assigned to SiteAccesses in
    configuration. Confirm how the server-to-SiteAccess assignment is expressed once
    SiteAccess configuration moves to a UI.

    Links to the deleted editions.md and graphql.md pages and the generated PHP API
    reference were removed; check that the surrounding text still reads correctly.
---

# Work with MCP servers

The MCP Servers feature includes several built-in tools.

## MCP server capabilities

The [[= product_name =]] MCP server framework (`ibexa/mcp`) is built on top of the [official PHP SDK for MCP (`mcp/sdk`)](https://github.com/modelcontextprotocol/php-sdk).

A PHP class that implements MCP server capabilities such as tools, prompts, or resources must:

- implement `Ibexa\Contracts\Mcp\McpCapabilityInterface` so that it can be scanned for capabilities
- use attributes from the `Ibexa\Contracts\Mcp\Attribute` namespace to declare capabilities



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

For the sake of the agent test, in this example, you configure the MCP server in an `.mcp.json` file at the [[= product_name =]] project root.
This way, it is only available for a session opened from there.

You can handle the JWT token for this test in the following ways:

- [Hard-code the JWT token](#hard-coded-variant) into the configuration and update it at every expiration.
- [Wrap a JWT token request and an MCP server call into a script](#fully-scripted-variant).

##### Hard-coded variant

The hard-coded JWT token configuration in `.mcp.json` looks as follows:

``` json
[[= include_code('code_samples/mcp/http.mcp.json') =]]
```

The `.mcp.json` file must be edited to update the JWT token each time it expires.
You can request a token by using the GraphiQL web interface or a `curl` command, and then edit the file manually.
Alternatively, you can configure a shell script to request the JWT token, extract it from the response, and replace it in the file.

When Copilot or Claude Code complains that it can't communicate with the MCP server:

=== "Copilot CLI"

    - Update the JWT token in the `.mcp.json` file.
    - Reload the MCP servers in Copilot CLI with one of these methods:
        - Run `/mcp reload` command to reload all MCP servers.
        - Run `/mcp disable ibexa-example` and `/mcp enable ibexa-example` to only reload the `ibexa-example` server.

    !!! note "Reloading multiple MCP servers"

        If you have several MCP servers enabled globally, reloading all of them at the same time can be time-consuming.
        Consider reloading them one by one.

=== "Claude Code CLI"

    - Update the JWT token in the `.mcp.json` file.
    - Run `/mcp reconnect ibexa-example` command to reconnect the `ibexa-example` MCP server.

##### Fully scripted variant

The wrapping script configuration in `.mcp.json` looks as follows:

``` json
[[= include_code('code_samples/mcp/stdio.mcp.json') =]]
```

`mcp-ibexa-example-wrapper.sh` is a script that requests a JWT token and establishes a connection with the MCP server.

For example, thanks to [`npx`](https://www.npmjs.com/package/npx), you can do it with [Supergateway](https://www.npmjs.com/package/supergateway) without a local installation:

``` bash
[[= include_code('code_samples/mcp/mcp-ibexa-example-wrapper.sh') =]]
```

When the agent complains that it can't communicate with the MCP server, reload it:

=== "Copilot CLI"

    Reload the MCP servers in Copilot CLI with one of these methods:

    - Run `/mcp reload` command to reload all MCP servers.
    - Run `/mcp disable ibexa-example` and `/mcp enable ibexa-example` to only reload the `ibexa-example` server.

    !!! note "Reloading multiple MCP servers"

        If you have several MCP servers enabled globally, reloading all of them at the same time can be time-consuming.
        Consider reloading them one by one.

=== "Claude Code CLI"

    Run `/mcp reconnect ibexa-example` command to reconnect the `ibexa-example` MCP server.

#### Run MCP server test with Copilot CLI or Claude Code CLI

Launch the agent CLI at the project root, where the `.mcp.json` file is located:

=== "Copilot CLI"

    ```bash
    cd /path/to/project
    copilot
    ```

=== "Claude Code CLI"

    ```bash
    cd /path/to/project
    claude
    ```

If prompted, confirm that you trust the files in this folder.
You may choose to have your choice remembered for the future.

You can check the MCP server status and details with the `/mcp` command:

=== "Copilot CLI"

    Run the `/mcp show ibexa-example` command to check the MCP server status and details:

    ``` text
    MCP Server: ibexa-example

    Type:     stdio
    Command:  bash
    Status:   ✓ Connected
    Source:   /path/to/project/.mcp.json

    Tools (1/1 enabled):
     ✓ greet: Greet a user by name (70 tokens)
    ```

=== "Claude Code CLI"

    Run the `/mcp` command and select ibexa-example to check the MCP server status and details:

    ``` text
    Ibexa-example MCP Server                                                                                                                                                                                    

    Status:           ✔ connected                                                                                                                                                                               
    Command:          bash                                                                                                                                                                                      
    Args:             mcp-ibexa-example-wrapper.sh                                                                                                                                                              
    Config location:  /path/to/project/.mcp.json                                                                                                                                          
    Capabilities: tools                                                                                                                                                                                         
    Tools: 1 tool
    ```

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
