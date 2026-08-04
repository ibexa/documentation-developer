# MCP Servers product guide

MCP servers expose tools, specialized prompts, and resources to AI agents.

Editions: LTS Update

## What is MCP Servers

MCP ([Model Context Protocol](https://modelcontextprotocol.io/docs/2025-11-25/getting-started/intro)) is a protocol that standardizes how AI systems interact with external systems.

While [AI actions](../../ai_actions/ai_actions_guide/index.md) integrate AI with the back office, Ibexa DXP's [MCP Servers](https://modelcontextprotocol.io/docs/2025-11-25/learn/server-concepts) offer an API that can be used by AI agents from the outside of the system.

Because MCP is a standard protocol, many agents are already trained to use it.

They can interact directly with REST or GraphQL APIs if their users provide detailed instructions through prompts, skill files, etc. However, when facing a specific REST or GraphQL API, an agent may misunderstand the purpose of endpoints, hallucinate paths, or send incorrectly structured parameters.

MCP servers make the discovery of available capabilities much easier. They help AI agents translate natural language prompts into concrete actions on the system.

![MCP communication diagram showing AI agent client connecting to MCP Server within Ibexa DXP.](https://doc.ibexa.co/en/5.0/ai/mcp/img/mcp-com-diagram.png)

An MCP server allows the agent to discover available tools, inspect their parameters, learn how to use them, and select the correct action.

## Availability

MCP Servers feature is an [LTS Update package](../../../ibexa_products/editions/index.md#lts-updates) available starting with the v5.0.8 in all Ibexa DXP editions.

## Capabilities

With the MCP Servers feature, you can:

- create MCP servers [by using YAML configuration](../mcp_config/index.md#mcp-server-configuration)
- assign different tools, prompts, and resources to different MCP servers, varying them for each site and purpose
- use [built-in tools](../mcp_config/index.md#built-in-tools) included in the package
- [create custom server capabilities](../mcp_usage/index.md#create-capability-class) with PHP API

MCP servers are defined specifically for each [repository](../../../administration/configuration/repository_configuration/index.md) and assigned to individual [SiteAccesses](../../../multisite/siteaccess/siteaccess/index.md) scopes. This way you can build flexible configurations that match different contexts.
