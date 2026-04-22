---
description: MCP servers expose functionalities to AIs.
month_change: true
---

# Model Context Protocol and Ibexa MCP servers

[Model Context Protocol (MCP)](https://modelcontextprotocol.io/docs/getting-started/intro) is a protocol standardizing interactions between AIs and systems.

While [AI actions](ai_actions_guide.md) integrate AI to the back office,
[[= product_name =]]'s [MCP servers](https://modelcontextprotocol.io/docs/learn/server-concepts) offer a web interface usable by AIs outside the system.

`ibexa/mcp` package provides:

- MCP servers [creation by configuration](mcp_config.md#mcp-server-configuration)
- [buit-in tools](mcp_config.md#built-in-tools) to associate to MCP servers by configuration
- a PHP API to [create custom MCP server capabilities](mcp_config.md#create-tool-class)

TODO: keep uo-to-date about prompts or resources

MCP servers capabilities (tools, prompts, and resources) can be created and associated to MCP servers thanks to a PHP API mainly based on attributes.

MCP servers are configured per repository then enabled per SiteAccess scope, allowing for flexible configurations adapted to different contexts.

MCP servers have their own session storage mechanism, TODO: why, benefit,…
