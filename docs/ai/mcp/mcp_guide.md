---
description: MCP servers expose tools, specialized prompts, and ressources to AI agents.
edition: lts-update
month_change: true
---

# Model Context Protocol and Ibexa MCP servers

[Model Context Protocol (MCP)](https://modelcontextprotocol.io/docs/getting-started/intro) is a protocol standardizing interactions between AIs and systems.

While [AI actions](ai_actions_guide.md) integrate AI to the back office,
[[= product_name =]]'s [MCP servers](https://modelcontextprotocol.io/docs/learn/server-concepts) offer an API usable by AI agents outside the system.

Some AI agents could use directly REST API or GraphQL API if their users explain to them how to do it in prompts, in skill files, etc.
But MCP servers ease the discovery of the functionalities by AI agents and help them to interpret natural language prompts into actions on the system.
As MCP is a standard protocol, agents are already trained to use it.
With a singular REST API or GraphQL API, an agent can misunderstand the purpose of endpoints, hallucinate paths, and misshape parameters.
With a standard MCP server, it can list the available tools and their parameters, learn how to use them, and pick the right one.

The MCP servers feature is an [LTS Update package](editions.md#lts-updates) available since v5.0.8 to all editions.

With the MCP servers feature, you can:

- create MCP servers [by using YAML configuration](mcp_config.md#mcp-server-configuration)
- assign different tools, prompts, and resources to different MCP servers, varying them for each site and purpose
- use [built-in tools](mcp_config.md#built-in-tools) included in the package
- [create custom server capabilities](mcp_usage.md#create-capability-class) with PHP API

MCP servers are configured per [repository](repository_configuration.md) and assigned to [SiteAccesses](siteaccess.md), allowing for flexible configurations adapted to different contexts.
