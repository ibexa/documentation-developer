---
description: AI interactions with [[= product_name =]]
page_type: landing_page
month_change: true
---

# Artificial Intelligence

[[= product_name =]] includes built-in AI capabilities.
For example, it can provide recommendations to product customers and content readers with the [Raptor connector](raptor_connector_guide.md), and assist editors in the back office with [AI Actions](ai_actions_guide.md).
The platform is also open to external AI integrations through [MCP (Model Context Protocol) servers](mcp_guide.md), which allow AI agents to interact with the system in a standardized way.
AI solutions are extensible. You can create [custom AI actions](extend_ai_actions.md) or expose [new MCP server capabilities](mcp_usage.md).

AI integration goes even further:

- Some AI agents can learn how to use the [REST](rest_api_usage.md) or [GraphQL](graphql.md) APIs.
- Other, like those integrated into IDEs, can even learn how to use the [PHP API](php_api.md) and assist you in code development.

[[= cards([
    "ai/ai_actions/ai_actions",
    "ai/mcp/mcp",
], columns=2) =]]
