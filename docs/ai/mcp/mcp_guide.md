---
description: MCP servers expose tools, specialized prompts, and ressources to AI agents.
month_change: true
---

# Model Context Protocol and Ibexa MCP servers

[Model Context Protocol (MCP)](https://modelcontextprotocol.io/docs/getting-started/intro) is a protocol standardizing interactions between AIs and systems.

While [AI actions](ai_actions_guide.md) integrate AI to the back office,
[[= product_name =]]'s [MCP servers](https://modelcontextprotocol.io/docs/learn/server-concepts) offer an API usable by AI agents outside the system.

Some AI agents can use directly REST API or GraphQL API if their users explain to them how to do it in prompts, in skill files, etc.
MCP servers ease the discovery of the functionalities by AIs and help them to interpret natural language prompts into actions on the system.

With the MCP servers feature, you can:

- create MCP servers [by using YAML configuration](mcp_config.md#mcp-server-configuration)
- assign different [tools](mcp_config.md#built-in-tools), prompts, and resources to different MCP servers, varying them for each site
- [create custom server capabilities](mcp_config.md#create-capability-class) with PHP API

MCP servers are configured per [repository](repository_configuration.md) and assigned to [SiteAccesses](siteaccess.md), allowing for flexible configurations adapted to different contexts.
