# Install and configure MCP Servers

Configure an MCP server that exposes built-in and custom tools, prompts, and resources.

Editions: LTS Update

With Ibexa DXP's MCP Servers LTS Update package, you can expose [MCP servers](../mcp_guide/index.md) to external AI agents.

## Installation

Run the following command to install the package:

```bash
composer require ibexa/mcp
```

MCP Servers feature comes with [built-in tools](#built-in-tools) but doesn't come with a default configuration. You have to create your own MCP servers by providing [their configuration](#mcp-server-configuration) and [enable JWT authentication for them](#jwt-mcp-firewall).

## Configure authentication

### JWT MCP firewall

AI agents use JWT authentication against Ibexa DXP's MCP servers.

In `config/packages/lexik_jwt_authentication.yaml`, [enable the `authorization_header` token extractor](../../../infrastructure_and_maintenance/security/development_security/index.md#jwt-authentication) to allow the use of JWT token bearer in `Authorization` header.

In `config/packages/security.yaml`, make the following changes:

- Uncomment the `ibexa_jwt_rest` firewall to enable requesting JWT tokens through REST or GraphQL API.
- Add the `ibexa_jwt_mcp` firewall to allow the use of JWT authentication against MCP servers.

```yaml
security:
    firewalls:
        # …
        ibexa_jwt_mcp:
            request_matcher: Ibexa\Mcp\Security\McpRequestMatcher
            user_checker: Ibexa\Core\MVC\Symfony\Security\UserChecker
            provider: ibexa
            stateless: true
            jwt: ~
```

> **Note: Authentication for the APIs**
>
> You don't need to activate JWT authentication for the REST or GraphQL API.
>
> For sample JWT token requests, see [REST JWT authentication](../../../api/rest_api/rest_api_authentication/index.md#jwt-authentication), [GraphQL JWT authentication](../../../api/graphql/graphql/index.md#jwt-authentication) and [cURL test of MCP server](../mcp_usage/index.md#perform-curl-test).

### Repository user

The AI agents authenticate against the MCP server with a JWT token generated for a specific repository user account.

This repository user can be:

- an individual user account (for example, of an editor or administrator)
- a dedicated account created specifically for AI integrations

The repository user can generate a JWT token with their own account, or a secondary dedicated account, and pass the token to the MCP client. A gateway could use a dedicated shared repository user to generate a JWT token and establish the connection.

## MCP server configuration

You define MCP servers within a repository configuration and then assign those servers to specific SiteAccess scopes.

```yaml
ibexa:
    repositories:
        <repository_identifier>:
            mcp:
                <server_identifier>:
                    path: <server_route_path>
                    enabled: true
                    # Server options…
                    discovery_cache: <cache_pool_service>
                    session:
                        type: <psr16|file>
                        # Session options…
                    allowed_hosts:
                        - '<domain_name>'
    system:
        <siteaccess_scope>:
            mcp:
                servers:
                    - <server_identifier>
```

Servers are automatically registered as services with an ID following the pattern `ibexa.mcp.server.<repository_identifier>.<server_identifier>`. You can list all defined servers by running the following command:

```bash
php bin/console debug:container ibexa.mcp.server
```

Routes are built automatically from MCP server `path` configs. Those routes are identified as `ibexa.mcp.<server_identifier>`. You can list them by running the following command:

```bash
php bin/console debug:router --siteaccess=<siteaccess> ibexa.mcp`
```

### MCP server options

| Option                                                                                                          | Type    | Required | Default                                         | Description                                                      |
| --------------------------------------------------------------------------------------------------------------- | ------- | -------- | ----------------------------------------------- | ---------------------------------------------------------------- |
| `path`                                                                                                          | string  | Yes      |                                                 | MCP server endpoint path (appended to SiteAccess-aware base URL) |
| `enabled`                                                                                                       | boolean | No       | `false`                                         | Server state: decides whether it is enabled or disabled          |
| `version`                                                                                                       | string  | No       | `1.0.0`                                         | MCP server version                                               |
| [`description`](https://modelcontextprotocol.io/specification/2025-11-25/schema#implementation-description)     | string  | No       | `null`                                          | Server implementation description                                |
| [`instructions`](https://modelcontextprotocol.io/specification/2025-11-25/schema#initializeresult-instructions) | string  | No       | `null`                                          | Prompt-like instructions provided to the AI agent                |
| [`tools`](#tool-configuration)                                                                                  | array   | No       | `[]`                                            | List of tool classes                                             |
| [`discovery_cache`](#discovery-cache)                                                                           | string  | Yes      |                                                 | PSR-6 or PSR-16 cache pool service identifier                    |
| [`session`](#session-storage)                                                                                   | object  | Yes      |                                                 | Session storage configuration                                    |
| [`allowed_hosts`](#allowed-hosts)                                                                               | array   | No       | `[` `'localhost',` `'127.0.0.1',` `'[::1]'` `]` | Accepted `Host` headers                                          |

> **Note: New servers are disabled by default**
>
> After you define a server, it remains disabled until you explicitly enable it.

### Tool configuration

The main capabilities of an MCP server are called [tools](https://modelcontextprotocol.io/specification/2025-11-25/server/tools). They are the actions that an AI agent can invoke on the system.

> **Note: MCP server design best practices**
>
> Avoid creating MCP servers with large tool sets. Too many tools make it more difficult for the AI agent to select the appropriate action. Instead, create multiple MCP servers with specific sets of tools dedicated to specific contexts or use cases. When designing MCP servers, focus on the needs and tasks of the human user who actually interacts with the AI agent rather than exploring every technical capability.

There are two ways to associate tools with a server:

- By listing PHP classes (FQCNs) in the server's configuration `tools`. All tools marked with the `McpTool` attribute in those classes are automatically associated with the server (for example, for [built-in](#built-in-tools) or third party tools).
- By using the `servers` argument in [`McpTool` attribute](../mcp_usage/index.md#tools) to explicitly associate a specific tool with MCP servers.

#### Built-in tools

MCP Servers LTS Update comes with the following **experimental** built-in tools:

- `Ibexa\Mcp\Tool\ContentType\ContentTypeTools`
  - `get_content_type` - gets a content type by its ID.
  - `get_content_type_by_identifier` - gets a content type by its identifier.
  - `get_content_type_list` - gets content types by their IDs.
  - `create_content_type` - creates a content type draft.
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

```yaml
            mcp:
                <server_identifier>:
                    path: <server_route_path>
                    enabled: true
                    tools:
                        - Ibexa\Mcp\Tool\TranslationTools
                        - Ibexa\Mcp\Tool\SeoTools
                    # …
```

> **Caution: Experimental tools**
>
> The built-in tools are experimental and may change in future releases. They are provided as examples of how to implement tools and how to configure them in an MCP server. As-is, they may not cover all your needs or may not be practical to all AI agents. If you use them, be prepared to update your MCP server configuration and tool usage when upgrading to a new version of Ibexa DXP.
>
> See how to build your own tools in [Work with MCP servers](../mcp_usage/index.md).

### Discovery cache

Discovery is cached to avoid scanning for capabilities on every request. You must provide a PSR-6 or PSR-16 cache pool for this caching.

For example, you could set up a dedicated Redis/Valkey:

```yaml
                    discovery_cache: cache.redis.mcp
```

For a production cluster, it's recommended to use a Redis/Valkey cache pool so the cache can be shared by all nodes.

Clear the cache pool after making changes:

```bash
php bin/console cache:pool:clear cache.redis.mcp
```

> **Tip: Tip**
>
> Use `ibexa.cache_pool` as service identifier to have the default [cache service](../../../infrastructure_and_maintenance/cache/persistence_cache/index.md#cache-service).

It can be set to `null` to disable caching to ease development, which isn't recommended for production environment.

See another example of configuration in [Work with MCP servers](../mcp_usage/index.md#configure-mcp-server).

### Session storage

MCP servers store session data in their own way.

#### Options

| Option      | Type    | Default    | Description                                               |
| ----------- | ------- | ---------- | --------------------------------------------------------- |
| `type`      | enum    | (required) | Session store type: [`psr16`](#psr-16) or [`file`](#file) |
| `service`   | string  | `null`     | PSR-16 cache service ID for the `psr16` session store     |
| `prefix`    | string  | `mcp_`     | Key prefix for the `psr16` session store                  |
| `directory` | string  | `null`     | Directory path for the `file` session store               |
| `ttl`       | integer | `3600`     | Session TTL in seconds                                    |

In production, it’s recommended to use [`psr16`](#psr-16) with Redis/Valkey, like with [regular sessions](../../../infrastructure_and_maintenance/clustering/clustering/index.md#shared-sessions).

#### PSR-16

Sessions are stored with a PSR-16 compatible cache implementation. It requires that a `service` option points to a valid cache service ID. Optionally, you could use a more specific `prefix` option than the default `mcp_` to avoid key collisions with other cache usages. Such setup is suitable for production environments.

```yaml
                    session:
                        type: psr16
                        service: cache.redis.mcp
                        prefix: 'mcp_<server_identifier>_'
services:
    cache.redis.mcp:
        public: true
        class: Symfony\Component\Cache\Adapter\RedisTagAwareAdapter
        parent: cache.adapter.redis
        tags:
            -   name: cache.pool
                clearer: cache.app_clearer
                provider: 'redis://mcp.redis:6379'
                namespace: 'mcp'
```

#### File

Sessions are stored on the filesystem. This requires that you configure a directory. Such setup is suitable for development environments.

In this example, sessions are stored in the `var/cache/<environment>/mcp/sessions/` directory (for example, `var/cache/dev/mcp/session/` for the `dev` environment, and `var/cache/prod/mcp/sessions/` for the `prod` environment):

```yaml
                    session:
                        type: file
                        directory: '%kernel.cache_dir%/mcp/sessions'
```

### Allowed hosts

This parameter lists the domains, the `Host` headers, accepted by the MCP server. The port is not part of the matching. There is no wildcard character, all cases must be listed. As item, you can use a hostname, an IP, or an IPv6. IPv6 addresses must be bracketed, for example `[::1]`.

In this example, only requests from `admin.example.com` domain, `my-ddev-project.ddev.site` domain, or from 127.0.0.1 IP are accepted:

```yaml
                    allowed_hosts:
                        - 'www.example.com'
                        - 'my-ddev-project.ddev.site'
                        - '127.0.0.1'
```
