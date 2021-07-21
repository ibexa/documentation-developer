# Update database to v2.5
    
!!! caution "Before you proceed"

    When you are updating from a version prior to v2.4, you must implement all the changes [from v2.4](5_update_2.4.md) before you proceed to the steps below.

!!! note

    During database update, you have to go through all the changes between your current version and your final version.
    For example, during update from v2.2 to v2.5, you have to perform all the steps from v2.3, v2.4 and v2.5.

## Database update script

Apply the following database update script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.4.0-to-7.5.0.sql
```

Next, ensure you have followed all steps corresponding to the [version you are updating from](5_update_database.md).

### v2.5.3

To update to v2.5.3, additionally run the following script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.5.2-to-7.5.3.sql
```

### v2.5.6

To update to v2.5.6, additionally run the following script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.5.4-to-7.5.5.sql
```

or for PostgreSQL:

``` bash
psql <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/postgres/dbupdate-7.5.4-to-7.5.5.sql
```

### v2.5.9

To update to v2.5.9, additionally run the following script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.5.6-to-7.5.7.sql
```

or for PostgreSQL:

``` bash
psql <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/postgres/dbupdate-7.5.6-to-7.5.7.sql
```

Additionally, reindex the content:

``` bash
php bin/console ezplatform:reindex
```

## Changes to database schema

The introduction of [support for PostgreSQL](https://doc.ibexa.co/en/latest/guide/databases.md#using-postgresql) includes a change in the way database schema is generated.

It is now created based on [YAML configuration](https://github.com/ezsystems/ezpublish-kernel/blob/7.5.3/eZ/Bundle/EzPublishCoreBundle/Resources/config/storage/legacy/schema.yaml), using the new [`DoctrineSchemaBundle`](https://github.com/ezsystems/doctrine-dbal-schema).

If you are updating your application according to the usual procedure, no additional actions are required.
However, if you do not update your meta-repository, you need to take two additional steps:

- enable `EzSystems\DoctrineSchemaBundle\DoctrineSchemaBundle()` in `AppKernel.php`
- add [`ez_doctrine_schema`](https://github.com/ezsystems/ezplatform/blob/2.5/app/config/config.yml#L33) configuration

## Changes to Matrix Field Type

To migrate your content from legacy XML format to a new `ezmatrix` value use the following command:

```bash
bin/console ezplatform:migrate:legacy_matrix
```

## Required manual cache clearing if using Redis

If you are using Redis as your persistence cache storage you should always clear it manually after an upgrade.
You can do it in two ways, by using `redis-cli` and executing the following command:

```bash
FLUSHALL
```

or by executing the following command:

```bash
bin/console cache:pool:clear cache.redis
```

## Updating to 2.5.3

### Page builder

This step is only required when updating an Enterprise installation from versions higher than v2.2 and lower than v2.5.3.
In case of versions lower than 2.2, skip this step or ignore the information that indexes from a script below already exist.

When updating to v2.5.3, you need to run the following script to add missing indexes:

``` bash
CREATE INDEX ezpage_map_zones_pages_zone_id ON ezpage_map_zones_pages(zone_id);
CREATE INDEX ezpage_map_zones_pages_page_id ON ezpage_map_zones_pages(page_id);
CREATE INDEX ezpage_map_blocks_zones_block_id ON ezpage_map_blocks_zones(block_id);
CREATE INDEX ezpage_map_blocks_zones_zone_id ON ezpage_map_blocks_zones(zone_id);
CREATE INDEX ezpage_map_attributes_blocks_attribute_id ON ezpage_map_attributes_blocks(attribute_id);
CREATE INDEX ezpage_map_attributes_blocks_block_id ON ezpage_map_attributes_blocks(block_id);
CREATE INDEX ezpage_blocks_design_block_id ON ezpage_blocks_design(block_id);
CREATE INDEX ezpage_blocks_visibility_block_id ON ezpage_blocks_visibility(block_id);
CREATE INDEX ezpage_pages_content_id_version_no ON ezpage_pages(content_id, version_no);
```

## Updating to 2.5.16

### Powered-By header

In order to promote use of eZ Platform, `ezsystems/ez-support-tools` v1.0.10, as of eZ Platform v2.5.16, sets the Powered-By header.
It is enabled by default and generates a header like `Powered-By: eZ Platform Enterprise v2`.

To omit the version number, use the following configuration:
``` yaml
ezplatform_support_tools:
    system_info:
        powered_by:
            release: "none"
```

To opt out of the whole feature, disable it with the following configuration:

``` yaml
ezplatform_support_tools:
    system_info:
        powered_by:
            enabled: false
```

## Updating to v2.5.18

To update to v2.5.18, if you are using MySQL, additionally run the following update script:

``` sql
ALTER TABLE ezpage_attributes MODIFY value LONGTEXT;
```

### Update entity managers

Version v2.5.18 introduces new entity managers.
To ensure that they work in multi-repository setups, you must update the GraphQL schema.
You do this manually by following this procedure:

1. Update your project to v2.5.18 and run the `php bin/console cache:clear` command to generate the [service container](../guide/service_container.md).

1. Run the following command to discover the names of the new entity managers. 
    Take note of the names that you discover:

    `php bin/console debug:container --parameter=doctrine.entity_managers --format=json | grep ibexa_`

1. For every entity manager prefixed with `ibexa_`, run the following command:

    `php bin/console doctrine:schema:update --em=<ENTITY_MANAGER_NAME> --dump-sql`
  
1. Review the queries and ensure that there are no harmful changes that could affect your data.

1. For every entity manager prefixed with `ibexa_`, run the following command to run queries on the database:

    `php bin/console doctrine:schema:update --em=<ENTITY_MANAGER_NAME> --force`

#### VCL configuration for Fastly

If you use Fastly, update your VCL configuration.

Locate the `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/ez_main.vcl` file and add the following lines to it:

```
if (req.restarts == 0 && resp.status == 301 && req.http.x-fos-original-url) {
    set resp.http.location = regsub(resp.http.location, "/_fos_user_context_hash", req.http.x-fos-original-url);
}
```

### Optimize workflow queries

Run the following SQL queries to optimize workflow performance:

``` sql
CREATE INDEX idx_workflow_co_id_ver ON ezeditorialworkflow_workflows(content_id, version_no);
CREATE INDEX idx_workflow_name ON ezeditorialworkflow_workflows(workflow_name);
```
