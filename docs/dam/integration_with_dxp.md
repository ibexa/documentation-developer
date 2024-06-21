---
description: Integrate DAM with your Ibexa DXP project to use an effective tool for managing media assets.
---


# Integrate DAM with DXP

## Enable Elasticsearch or Solr

A search engine is an important component of the DAM. To ensure proper indexing and search results, DAM requires one of
the following search engines on your server:

- Elasticsearch
- Solr

To install and configure search engine of your choice, go to [Elasticsearch documentation](search/search_engines/elastic_search/install_elastic_search.md)
or to [Solr documentation](search/search_engines/solr_search_engine/install_solr.md)


## Enable OAuth Servers

Next, enable 0Auth Server authentication. To do it, follow steps to the Client section.
https://doc.ibexa.co/en/latest/users/oauth_server/.

## Install DAM package

Install dedicated DAM `ibexa/dam-user` package into your [[= product_name =]] instance.

Run `composer require ibexa/dam-user`.

Add the `ibexa_dam_oauth2_client_user` table to the database:

`php bin/console ibexa:doctrine:schema:dump-sql vendor/ibexa/dam-user/src/bundle/Resources/config/schema.yaml | mysql -u <username> -p <database_name>`

Add technical users to your [[= product_name =]] instance.

Import migration file:
`php bin/console ibexa:migrations:import vendor/ibexa/dam-user/src/bundle/Resources/migrations/2024_07_11_09_10_dam_technical_users.yaml`

Run migrations:
`php bin/console ibexa:migrations:migrate`.

Two new user roles and users should be now in the Back Office.

Create OAuth2 client for the DXP user:

`php bin/console ibexa:dam:create-oauth2-client <client-name> <user-identifier>`.



<!-- Create database tables for `ibexa_0auth_server`:

```sql
CREATE TABLE `ibexa_dam_oauth2_client_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `expires_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ibexa_oauth2_client_id` (`client_id`),
  KEY `ibexa_user_id` (`user_id`),
  CONSTRAINT `FK_CDDB196119EB6921` FOREIGN KEY (`client_id`) REFERENCES `ibexa_oauth2_client` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_CDDB1961A76ED395` FOREIGN KEY (`user_id`) REFERENCES `ezuser` (`contentobject_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
```

run migration file (migracja po zainstalowaniu paczki powinna tu trafic)

### Create and map user

DAM requires two user roles, 
You need to have two new types of users: creator and reader users (editors)


### Install dedicated DAM support package

### Run migration -->

## Override admin-ui

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

Next, in the `.env` file provide path with a regular expression:

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

and set the location id to 51

```yaml
parameters:
    ibexa.dam_app.image.root_location_id: 51
```

Add DAM ConfigProvider:

```yaml
app.config.provider.dam_app:
    class: Ibexa\AdminUi\UI\Config\Provider\Value
    arguments:
        $value:
            imageRootLocationId: '%ibexa.dam_app.image.root_location_id%'
    tags:
        - { name: ibexa.admin_ui.config.provider, key: 'damApp' }
```

!!! important
    
    location 51