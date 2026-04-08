---
description: TODO.
month_change: true
---

# Model Context Protocol and Ibexa MCP Servers

[Model Context Protocol (MCP)](https://en.wikipedia.org/wiki/Model_Context_Protocol) is a protocol standardizing interactions between AIs and systems.

While [AI actions](ai_actions_guide.md) integrate AI to the back office,
[[= product_name =]]'s MCP servers offer a web interface usable by AIs outside the system.

`ibexa/mcp` package provides built-in MCP servers and a PHP API to create custom ones.

TODO: About built-in MCP servers (translations agents, SEO optimization agents,…)

MCP servers capabilities (tools, prompts, and resources) can be created and associated to MCP servers thanks to a PHP API mainly based on attributes.

MCP servers are configured per repository then enabled per SiteAccess scope, allowing for flexible configurations adapted to different contexts.

MCP servers have their own session storage mechanism, TODO: why, benefit,…
