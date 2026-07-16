---
description: TODO.
month_change: true
---

# DIL MCP server

The Data Intelligence Layer come with a built-in MCP server helpin AI agents to fetch metrics and use them to provide content improvement suggestions or take actions.

## MCP server configuration

You can check the service existence with the following command:

```bash
php bin/console debug:container ibexa.mcp.server.default.data_intelligence_layer
```

You can check the route existence with the following command:

```bash
php bin/console debug:router ibexa.mcp.data_intelligence_layer
```

This MCP server need to be associated to some SiteAccesses and allowed to be accessed from some hosts.
For details, see [Data Intelligence Layer configuration](dil_config.md#mcp-server-configuration).

## MCP server test 

You can use the MCP server from an agent CLI command.
Like in the [Work with MCP servers example](mcp_usage.md#fully-scripted-variant), you can use a wrapper script to ease JWT token acquisition.

```bash hl_lines="7 11 25"
[[= include_code('code_samples/mcp/mcp-data-intelligence-wrapper.sh') =]]
```

Notice:

- the `admin` in MCP server URL as default [`URIElement: 1` SiteAccess matching](siteaccess_matching.md#urielement) is used in this local test example
- the `X-Siteaccess: admin` header when requiring the JWT token TODO: mention this need in mcp_usage.md example instead.
- the `Accept-Language: en` header when establishing the gateway TODO: Why is it suddenly needed? Because it's the admin SiteAccess?
