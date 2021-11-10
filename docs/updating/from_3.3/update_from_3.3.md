---
latest_tag: '3.3.12'
---

# Update from v3.3.x to v3.3.latest

This update procedure applies if you are using a v3.3 installation without the latest maintenance release.

Go through the following steps to update to the latest maintenance release of v3.3 (v[[= latest_tag =]]).

!!! note

    You can only update to the latest patch release of 3.3.x.

### v3.3.2

#### Update entity managers

Version v3.3.2 introduces new entity managers.
To ensure that they work in multi-repository setups, you must update the Doctrine schema.
You do this manually by following this procedure:

1. Update your project to v3.3.2 and run the `php bin/console cache:clear` command to generate the service container.

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

``` vcl
if (req.restarts == 0 && resp.status == 301 && req.http.x-fos-original-url) {
    set resp.http.location = regsub(resp.http.location, "/_fos_user_context_hash", req.http.x-fos-original-url);
}
```

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

### v3.3.4

#### Migration Bundle
    
Remove `Kaliop\eZMigrationBundle\eZMigrationBundle::class => ['all' => true],`
from `config/bundles.php` before running `composer require`.

Then, in `composer.json`, set minimum stability to `stable`:

``` json
"minimum-stability": "stable",
```

### v3.3.6

#### Symfony 5.3

To update to Symfony 5.3, update the following package versions in your `composer.json`,
including the Symfony version (line 9):

``` json hl_lines="9"
"symfony/flex": "^1.3.1"
"sensio/framework-extra-bundle": "^6.1",
"symfony/runtime": "*",
"doctrine/doctrine-bundle": "^2.4"
"symfony/maker-bundle": "^1.0",

"symfony": {
    "allow-contrib": true,
    "require": "5.3.*",
    "endpoint": "https://flex.ibexa.co"
},
```

See https://github.com/ibexa/website-skeleton/pull/5/files for details of the package version change.

Next, run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:3.3.9 --with-all-dependencies --no-scripts
    composer recipes:install ibexa/content --force -v
    composer run post-install-cmd
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:3.3.9 --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    composer run post-install-cmd
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:3.3.9 --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    composer run post-install-cmd
    ```
    
Review the changes to make sure your custom configuration was not affected.

Then, perform a database upgrade relevant to the version you are updating to.

!!! caution "Clear Redis cache"

    If you are using Redis as your persistence cache storage you should always clear it manually after an upgrade.
    You can do it by executing the following command:

    ```bash
    php bin/console cache:pool:clear cache.redis
    ```

### v3.3.7

#### Commerce configuration

If you are using Commerce, run the following migration action to update the way Commerce configuration is stored:

``` bash
php bin/console ibexa:migrations:migrate --file=src/bundle/Resources/install/migrations/content/Components/move_configuration_to_settings.yaml
```

#### Database update

Run the following scripts:

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

### v3.3.9

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
