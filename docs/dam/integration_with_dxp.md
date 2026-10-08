---
description: Integrate DAM with your Ibexa DXP project to use an effective tool for managing marketing assets.
---


# Integrate DAM with DXP

DAM integration with [[= product_name =]] is dedicated to [[= product_name_base =]] users who want to use [[= product_name_base =]] as a data storage. It enables using assets repository stored in the DXP and manage assets. 

## Enable Elasticsearch or Solr

To ensure proper indexing and search results, DAM requires one of
the following search engines on your server:

- [Elasticsearch](install_elastic_search.md)
- [Solr](install_solr.md)


## Enable OAuth Server

Next, enable OAuth Server authentication. To do it, follow steps up to the [Client section](oauth_server.md).

## Integration with Platform.sh

If you have your [[= product_name =]] project deplyed on Platform.sh, the following steps are required:

In the `.platform.app.yaml` file, set paths for private and public keys to OAuth Server.
Next, generate these keys and add them.

```bash
variables:
	env:
		# OAuth2 Server paths to certificates
		OAUTH2_PRIVATE_KEY_PATH: /app/oauth-server.key
		OAUTH2_PUBLIC_KEY_PATH: /app/oauth-server.pub


hooks:
	build: |
		# Generate OAuth2 Keys
		openssl genrsa -out private.key 2048
		openssl rsa -in private.key -pubout -out public.key

		# OAuth2 Server credentials
		export OAUTH2_PRIVATE_KEY="$(cat private.key | base64)"
		export OAUTH2_PUBLIC_KEY="$(cat public.key | base64)"

		echo "$OAUTH2_PRIVATE_KEY" | base64 -d > ~/oauth-server.key
		echo "$OAUTH2_PUBLIC_KEY" | base64 -d > ~/oauth-server.pub
```

## Install DAM package

Install dedicated DAM `ibexa/dam-user` package into your [[= product_name =]] instance.

To install, run the following command:

```bash
composer require ibexa/dam-user
```

Add the `ibexa_dam_oauth2_client_user` table to the database:

```bash
php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/dam-user/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <database_name>
```

Next, create technical users, required by DAM to your [[= product_name =]] instance:

- `image-picker-reader` - with read permission
- `imgage-picker-editor` - with edit/ delete permission

Both users have limited access to Media folder only.

To do it, first, import the migration file:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/dam-user/src/bundle/Resources/migrations/2024_07_11_09_10_dam_technical_users.yaml
```

Next, run migrations:

```bash
php bin/console ibexa:migrations:migrate
```

Two new user roles and users should be now visibile in the Back Office.

Create OAuth2 client for the DXP user:

```bash
php bin/console ibexa:dam:create-oauth2-client <client-name> <user-identifier>
```

For example:

```bash
php bin/console ibexa:dam:create-oauth2-client <acme> <image-picker-editor>
```

## Override admin-ui

Override parameters for `admin_group` and use `site_group` scope to make them available under REST API.

Add the following configuration in the `yaml` file, for example, `ibexa_admin_ui_settings.yaml`:

??? note "`ibexa_admin_ui_settings.yaml`"

    ```yaml
    parameters:
        # Content Tree Module
        ibexa.site_access.config.site_group.content_tree_module.load_more_limit: 30
        ibexa.site_access.config.site_group.content_tree_module.children_load_max_limit: 200
        ibexa.site_access.config.site_group.content_tree_module.tree_max_depth: 10
        ibexa.site_access.config.site_group.content_tree_module.allowed_content_types: []
        ibexa.site_access.config.site_group.content_tree_module.ignored_content_types: []
        ibexa.site_access.config.site_group.content_tree_module.tree_root_location_id: ~

        # Pagination limits
        ibexa.site_access.config.site_group.pagination.search_limit: 10
        ibexa.site_access.config.site_group.pagination.trash_limit: 10
        ibexa.site_access.config.site_group.pagination.section_limit: 10
        ibexa.site_access.config.site_group.pagination.language_limit: 10
        ibexa.site_access.config.site_group.pagination.role_limit: 10
        ibexa.site_access.config.site_group.pagination.content_type_group_limit: 10
        ibexa.site_access.config.site_group.pagination.content_type_limit: 10
        ibexa.site_access.config.site_group.pagination.role_assignment_limit: 10
        ibexa.site_access.config.site_group.pagination.policy_limit: 10
        ibexa.site_access.config.site_group.pagination.version_draft_limit: 5
        ibexa.site_access.config.site_group.pagination.reverse_relation_limit: 10
        ibexa.site_access.config.site_group.pagination.content_system_url_limit: 5
        ibexa.site_access.config.site_group.pagination.content_custom_url_limit: 5
        ibexa.site_access.config.site_group.pagination.content_role_limit: 5
        ibexa.site_access.config.site_group.pagination.content_policy_limit: 5
        ibexa.site_access.config.site_group.pagination.bookmark_limit: 10
        ibexa.site_access.config.site_group.pagination.notification_limit: 5
        ibexa.site_access.config.site_group.pagination.user_settings_limit: 10
        ibexa.site_access.config.site_group.pagination.content_draft_limit: 10
        ibexa.site_access.config.site_group.pagination.location_limit: 10
        ibexa.site_access.config.site_group.pagination.url_wildcards: 10

        # Security
        ibexa.site_access.config.site_group.security.token_interval_spec: PT1H

        # User identifier
        ibexa.site_access.config.site_group.user_content_type_identifier: ['user']

        # User Group identifier
        ibexa.site_access.config.site_group.user_group_content_type_identifier: ['user_group']

        # Subtree Operations
        ibexa.site_access.config.site_group.subtree_operations.copy_subtree.limit: 100

        # Notifications
        ibexa.site_access.config.site_group.notifications.error.timeout: 0
        ibexa.site_access.config.site_group.notifications.warning.timeout: 0
        ibexa.site_access.config.site_group.notifications.success.timeout: 5000
        ibexa.site_access.config.site_group.notifications.info.timeout: 0
    ```

## Add CROSS-ORIGIN config

To integrate DAM you need to add in the `config/packages/nelmio_cors.yaml` following configuration:

```yaml
nelmio_cors:
    defaults:
        origin_regex: true
        allow_origin: ['%env(CORS_ALLOW_ORIGIN)%']
        allow_methods: ['GET', 'OPTIONS', 'POST', 'PUT', 'PATCH', 'DELETE', 'PUBLISH', 'COPY']
        allow_headers: ['Content-Type', 'Authorization', 'X-HTTP-Method-Override']
        expose_headers: ['Link']
        max_age: 3600
    paths:
        '^/api/ibexa/v2/':
            allow_methods: ['GET', 'OPTIONS', 'POST', 'PUT', 'PATCH', 'DELETE', 'PUBLISH', 'COPY']
            allow_headers: ['Content-Type', 'Authorization', 'X-HTTP-Method-Override']
```

Next, in the `.env` file provide path with a regular expression and change the domain accroding to your needs:

`CORS_ALLOW_ORIGIN='^https?://(localhost|127\.0\.0\.1|(.+\.acme\.(com|eu)))?(:[0-9]+)?$'`


### Override `nelmio` settings

config/services.yaml

```yaml
nelmio_cors.options_provider.config:
    class: '%nelmio_cors.options_provider.config.class%'
    arguments:
        $paths: '%nelmio_cors.map%'
        $defaults: '%nelmio_cors.defaults%'
    tags:
        -
            name: nelmio_cors.options_provider
            priority: 255
```

Set the `location ID` to `51`.
```yaml
parameters:
    ibexa.dam_app.image.root_location_id: 51
```

Add DAM `ConfigProvider`:

```yaml
app.config.provider.dam_app:
    class: Ibexa\AdminUi\UI\Config\Provider\Value
    arguments:
        $value:
            imageRootLocationId: '%ibexa.dam_app.image.root_location_id%'
    tags:
        - { name: ibexa.admin_ui.config.provider, key: 'damApp' }
```

!!! caution
    
    Location ID must be set to 51, if you provide different location ID, your asset library won't be accessible from DAM.