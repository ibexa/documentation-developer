---
description: MCP servers expose tools, specialized prompts, and resources to AI agents.
month_change: false
---

# MCP Servers product guide

## What is MCP Servers

MCP ([Model Context Protocol](https://modelcontextprotocol.io/docs/2025-11-25/getting-started/intro)) is a protocol that standardizes how AI systems interact with external systems.

While [AI actions](ai_actions_guide.md) integrate AI with the back office,
[[= product_name =]]'s [MCP Servers](https://modelcontextprotocol.io/docs/2025-11-25/learn/server-concepts) offer an API that can be used by AI agents from the outside of the system.

Because MCP is a standard protocol, many agents are already trained to use it.

They can interact directly with the REST API if their users provide detailed instructions through prompts, skill files, etc.
However, when facing a specific REST API, an agent may misunderstand the purpose of endpoints, hallucinate paths, or send incorrectly structured parameters.

MCP servers make the discovery of available capabilities much easier.
They help AI agents translate natural language prompts into concrete actions on the system.

![MCP communication diagram showing AI agent client connecting to MCP server within [[= product_name =]].](img/mcp-com-diagram.png)

An MCP server allows the agent to discover available tools, inspect their parameters, learn how to use them, and select the correct action.

## Capabilities

With the MCP Servers feature, you can use the tools included in the package.

### Built-in tools

MCP Servers LTS Update comes with the following built-in tools:

- `Ibexa\Mcp\Tool\ContentType\ContentTypeTools`
    - `get_content_type` - gets a content type by its ID.
    - `get_content_type_by_identifier` - gets a content type by its identifier.
    - `get_content_type_list` - gets content types by their IDs.
    - `create_content_type` - creates a draft for a new content type.
    - `create_content_type_draft` - creates a draft for an existing content type.
    - `get_content_type_draft` - gets a content type draft by content type ID.
    - `publish_content_type_draft` - publishes a content type draft by content type ID.
- `Ibexa\Mcp\Tool\ContentType\FieldDefinitionTools`
    - `add_field_definition` - adds a field definition to a content type draft.
    - `update_field_definition` - updates a field definition in a content type draft.
    - `remove_field_definition` - removes a field definition from a content type draft.
- `Ibexa\Mcp\Tool\ContentType\ContentTypeGroupTools`
    - `get_content_type_groups` - gets all content type groups.
- `Ibexa\Mcp\Tool\TranslationTools`
    - `list_languages` - lists all languages in the current SiteAccess.
    - `list_content_languages` - lists languages which have translations for a given content item.
    - `list_non_translated_content_ids` - lists IDs of content which have missing translations for a given language code.
- `Ibexa\Mcp\Tool\SeoTools`
    - `get_non_seo_content_ids` - returns IDs of content items that are missing SEO optimization (no meta title tag). Useful for identifying content that needs SEO attention.
