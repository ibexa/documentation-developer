---
target_version: '3.3'
latest_tag: '3.3.24'
---

# Update to latest version of v3.3

Before you start this procedure, make sure you have completed the previous step,
[Updating the app to v3.3](to_3.3.md).

Finally, bring your installation to the latest release of v3.3.

## 6. Update the database

[[% include 'snippets/update/db/update_db_2.5-3.3.md' %]]

## 7. Update to the latest patch version

### A. v3.3.2

#### Update entity managers

Version v3.3.2 introduces new entity managers.
To ensure that they work in multi-repository setups, you must update the Doctrine schema.
You do this manually by following this procedure:

1. Run the `php bin/console cache:clear` command to generate the service container.

1. Run the following command to discover the names of the new entity managers. 
    Take note of the names that you discover:

    `php bin/console debug:container --parameter=doctrine.entity_managers --format=json | grep ibexa_`

1. For every entity manager prefixed with `ibexa_`, run the following command:

    `php bin/console doctrine:schema:update --em=<ENTITY_MANAGER_NAME> --dump-sql`
  
1. Review the queries and ensure that there are no harmful changes that could affect your data.

1. For every entity manager prefixed with `ibexa_`, run the following command to run queries on the database:

    `php bin/console doctrine:schema:update --em=<ENTITY_MANAGER_NAME> --force`

#### VCL configuration for Fastly

[[% include 'snippets/update/vcl_configuration_for_fastly.md' %]]

#### Optimize workflow queries

Run the following SQL queries to optimize workflow performance:

``` sql
CREATE INDEX idx_workflow_co_id_ver ON ezeditorialworkflow_workflows(content_id, version_no);
CREATE INDEX idx_workflow_name ON ezeditorialworkflow_workflows(workflow_name);
```

#### Enable Commerce features

Commerce features in Experience and Content editions are disabled by default.
If you use these features, after the update enable Commerce features by going to `config\packages\ecommerce.yaml`
and setting the following:

``` yaml
ezplatform:
    system:
        default:
            commerce:
                enabled: true
```

Next, run the following command:

``` bash
php bin/console ibexa:upgrade --force
```

#### Database update

If you are using MySQL, run the following update script:

``` sql
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-3.3.1-to-3.3.2.sql
```

### B. v3.3.7

#### Commerce configuration

If you are using Commerce, run the following migration action to update the way Commerce configuration is stored:

``` bash
php bin/console ibexa:migrations:migrate --file=src/bundle/Resources/install/migrations/content/Components/move_configuration_to_settings.yaml
```

#### Database update

Run the following SQL commands:

=== "MySQL"

    ``` sql
    CREATE TABLE IF NOT EXISTS `ibexa_workflow_version_lock` (
        `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `content_id` INT(11) NOT NULL,
        `version` INT(11) NOT NULL,
        `user_id` INT(11) NOT NULL,
        `created` INT(11) NOT NULL DEFAULT 0,
        `modified` INT(11) NOT NULL DEFAULT 0,
        `is_locked` BOOLEAN NOT NULL DEFAULT true,
        KEY `ibexa_workflow_version_lock_content_id_index` (`content_id`) USING BTREE,
        KEY `ibexa_workflow_version_lock_user_id_index` (`user_id`) USING BTREE,
        UNIQUE KEY `ibexa_workflow_version_lock_content_id_version_uindex` (`content_id`,`version`) USING BTREE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```

=== "PostgreSQL"

    ``` sql
    CREATE TABLE IF NOT EXISTS ibexa_workflow_version_lock
    (
        "id" SERIAL,
        "content_id" INTEGER,
        "version" INTEGER,
        "user_id" INTEGER,
        "created" INTEGER DEFAULT 0 NOT NULL,
        "modified" INTEGER DEFAULT 0 NOT NULL,
        "is_locked" boolean DEFAULT TRUE NOT NULL,
        CONSTRAINT "ibexa_workflow_version_lock_pk" PRIMARY KEY ("id")
    );

    CREATE INDEX IF NOT EXISTS "ibexa_workflow_version_lock_content_id_index"
        ON "ibexa_workflow_version_lock" ("content_id");

    CREATE INDEX IF NOT EXISTS "ibexa_workflow_version_lock_user_id_index"
        ON "ibexa_workflow_version_lock" ("user_id");

    CREATE UNIQUE INDEX IF NOT EXISTS "ibexa_workflow_version_lock_content_id_version_uindex"
        ON "ibexa_workflow_version_lock" ("content_id", "version");
    ```

### C. v3.3.9

#### Database update

Run the following scripts:

=== "MySQL"

    ``` sql
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-3.3.8-to-3.3.9.sql
    ```

=== "PostgreSQL"

    ``` sql
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-3.3.8-to-3.3.9.sql
    ```

### D. v3.3.24

#### VCL configuration for Fastly

Ibexa DXP now supports Fastly shielding. If you are using Fastly and want to use shielding, you need to update your VCL files.

!!! tip

    Even if you do not plan to use Fastly shielding, it is recommended to update the VCL files for future compatibility.

1. Locate the `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/ez_main.vcl` file and update your VCL file with the recent changes.
2. Do the same with `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/ez_user_hash.vcl`.
3. Upload a new `snippet_re_enable_shielding.vcl` snippet file, based on `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/snippet_re_enable_shielding.vcl`.

## 8. Finish the update

[[% include 'snippets/update/finish_the_update.md' %]]

[[% include 'snippets/update/notify_support.md' %]]
