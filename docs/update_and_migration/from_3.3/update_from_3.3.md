---
description: Update your installation to the latest v3.3 version from an earlier v3.3 version.
---

# Update from v3.3.x to v3.3.latest

This update procedure applies if you are using a v3.3 installation without the latest maintenance release.

Go through the following steps to update to the latest maintenance release of v3.3 (v[[= latest_tag_3_3 =]]).

!!! note

    You can only update to the latest patch release of 3.3.x.

## Update the application

!!! note

    If you are using v3.3.15 or earlier v3.3 version, or encounter an error related to flex.ibexa.co, you need to [update your Flex server](#update-flex-server) first.

Run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_3_3 =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_3_3 =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_3_3 =]] --with-all-dependencies --no-scripts
    ```

### Update Flex server

The `flex.ibexa.co` Flex server has been disabled.
If you are using v3.3.15 or earlier v3.3 version, you need to update your Flex server.
In your `composer.json` check whether the `https://flex.ibexa.co` endpoint is still listed in `extra.symfony.endpoint`.
If that's the case, you need to perform the following update procedure.

First, update the `symfony/flex` bundle to handle the new endpoint properly:

```bash
composer update symfony/flex --no-plugins --no-scripts;
```

Then, replace the `https://flex.ibexa.co` endpoint with the new [`https://api.github.com/repos/ibexa/recipes/contents/index.json?ref=flex/main`](https://github.com/ibexa/website-skeleton/blob/v3.3.20/composer.json#L98) endpoint in `composer.json` under `extra.symfony.endpoint`.

You can do it manually, or by running the following command:

```bash
composer config extra.symfony.endpoint "https://api.github.com/repos/ibexa/recipes/contents/index.json?ref=flex/main"
```

Next, continue with updating the app:

=== "[[= product_name_content =]]"

    ``` bash
    composer recipes:install ibexa/content --force -v
    composer run post-install-cmd
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer recipes:install ibexa/experience --force -v
    composer run post-install-cmd
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer recipes:install ibexa/commerce --force -v
    composer run post-install-cmd
    ```
    
Review the changes to make sure your custom configuration was not affected.

Remove the `vendor` folder to prevent issues related to the [new Flex server](#update-flex-server).

Then, perform a database upgrade and other steps relevant to the version you are updating to.

!!! caution "Clear Redis cache"

    If you are using Redis as your persistence cache storage you should always clear it manually after an upgrade.
    You can do it by executing the following command:

    ```bash
    php bin/console cache:pool:clear cache.redis
    ```

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

[[% include 'snippets/update/vcl_configuration_for_fastly_v3.md' %]]

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
mysql -u<username> -p<password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-3.3.1-to-3.3.2.sql
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

### v3.3.7

#### Commerce configuration

If you are using Commerce, run the following migration action to update the way Commerce configuration is stored:

``` bash
mkdir --parent src/Migrations/Ibexa/migrations
cp vendor/ibexa/installer/src/bundle/Resources/install/migrations/content/Components/move_configuration_to_settings.yaml src/Migrations/Ibexa/migrations/
php bin/console ibexa:migrations:migrate --file=move_configuration_to_settings.yaml
```

#### Database update

Run the following scripts:

=== "MySQL"

    ``` shell
    mysql -u<username> -p<password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-3.3.6-to-3.3.7.sql
    ```

=== "PostgreSQL"

    ``` shell
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-3.3.6-to-3.3.7.sql
    ```

### Ibexa Open Source

If you have no access to Ibexa DXP's `ibexa/installer` package, apply the following database upgrade script:

=== "MySQL"

    ``` sql
    DROP TABLE IF EXISTS `ibexa_setting`;
    CREATE TABLE `ibexa_setting` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `group` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
      `identifier` varchar(128) COLLATE utf8mb4_unicode_520_ci NOT NULL,
      `value` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `ibexa_setting_group_identifier` (`group`, `identifier`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
    ```

=== "PostgreSQL"

    ``` sql
    DROP TABLE IF EXISTS ibexa_setting;
    CREATE TABLE ibexa_setting (
      id SERIAL NOT NULL,
      "group" varchar(128) NOT NULL,
      identifier varchar(128) NOT NULL,
      value json NOT NULL,
      PRIMARY KEY (id),
      CONSTRAINT ibexa_setting_group_identifier UNIQUE ("group", identifier)
    );
    ```

### v3.3.9

#### Database update

Run the following scripts:

=== "MySQL"

    ``` shell
    mysql -u<username> -p<password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-3.3.8-to-3.3.9.sql
    ```

=== "PostgreSQL"

    ``` shell
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-3.3.8-to-3.3.9.sql
    ```

### v3.3.13

!!! note "Symfony 5.4"

    Prior to v3.3.13, Symfony 5.3 was used by default.

    If you are still using Symfony 5.3, you need to update your installation to Symfony 5.4.
    To do this, update your `composer.json` to refer to `5.4.*` instead or `5.3.*`.

    Refer to the relevant website skeleton: [content](https://github.com/ibexa/content-skeleton/blob/v3.3.13/composer.json), [experience](https://github.com/ibexa/experience-skeleton/blob/v3.3.13/composer.json), [commerce](https://github.com/ibexa/commerce-skeleton/blob/v3.3.13/composer.json).

    The following `sed` commands should update the relevant lines.
    Use them with caution and properly check the result:

    ```shell
    sed -i -E 's/"symfony\/(.+)": "5.3.*"/"symfony\/\1": "5.4.*"/' composer.json;
    sed -i -E 's/"require": "5.3.*"/"require": "5.4.*"/' composer.json;
    ```

    After this `composer.json` update, run `composer update "symfony/*"`.

    You may need to adapt configuration to fit the new minor version of Symfony.
    For example, you might have to remove `timeout` related config from `nelmio_solarium` bundle config:
    
    ```shell
    sed -i -E '/ *timeout: [0-9]+/d' ./config/packages/nelmio_solarium.yaml ./config/packages/ezcommerce/ezcommerce_advanced.yaml
    composer update "symfony/*"
    ```

### v3.3.14

#### VCL configuration

Update your Varnish VCL file to align with [`docs/varnish/vcl/varnish5.vcl`](https://github.com/ezsystems/ezplatform-http-cache/blob/2.3/docs/varnish/vcl/varnish5.vcl).
Make sure it contains the highlighted additions.

``` vcl hl_lines="4-7 16"
// Compressing the content
// ...

// Modify xkey header to add translation suffix
if (beresp.http.xkey && beresp.http.x-lang) {
    set beresp.http.xkey = beresp.http.xkey + " " + regsuball(beresp.http.xkey, "(\S+)", "\1" + beresp.http.x-lang);
}

// ...

if (client.ip ~ debuggers) {
/// ...
} else {
    // Remove tag headers when delivering to non debug client
    unset resp.http.xkey;
    unset resp.http.x-lang;
    // Sanity check to prevent ever exposing the hash to a non debug client.
    unset resp.http.x-user-context-hash;
}
```

### v3.3.15

Adapt your `composer.json` file according to [`manifest.json`](https://github.com/ibexa/recipes/blob/master/ibexa/commerce/3.3.x-dev/manifest.json#L167-L168), by adding and moving the following lines:

``` diff
  "composer-scripts": {
    "cache:clear": "symfony-cmd",
    "assets:install %PUBLIC_DIR%": "symfony-cmd",
-    "bazinga:js-translation:dump %PUBLIC_DIR%/assets --merge-domains": "symfony-cmd",
    "yarn install": "script",
+    "ibexa:encore:compile --config-name app": "symfony-cmd",
+    "bazinga:js-translation:dump %PUBLIC_DIR%/assets --merge-domains": "symfony-cmd",
    "ibexa:encore:compile": "symfony-cmd"
  }
```

### v3.3.16

See [Update Flex server](#update-flex-server).

### v3.3.24

#### VCL configuration for Fastly

Ibexa DXP now supports Fastly shielding. If you are using Fastly and want to use shielding, you need to update your VCL files.

!!! tip

    Even if you do not plan to use Fastly shielding, it is recommended to update the VCL files for future compatibility.

1. Locate the `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/ez_main.vcl` file and update your VCL file with the recent changes.
2. Do the same with `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/ez_user_hash.vcl`.
3. Upload a new `snippet_re_enable_shielding.vcl` snippet file, based on `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/snippet_re_enable_shielding.vcl`.

### v3.3.25

#### Database update

On Experience or Commerce edition, run the following scripts:

=== "MySQL"

    ``` shell
    mysql -u<username> -p<password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-3.3.24-to-3.3.25.sql
    ```

=== "PostgreSQL"

    ``` shell
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-3.3.24-to-3.3.25.sql
    ```

### v3.3.28

#### Ensure password safety

Following [Security advisory: IBEXA-SA-2022-009](https://developers.ibexa.co/security-advisories/ibexa-sa-2022-009-critical-vulnerabilities-in-graphql-role-assignment-ct-editing-and-drafts-tooltips),
unless you can verify based on your log files that the vulnerability has not been exploited,
you should [revoke passwords](https://doc.ibexa.co/en/latest/users/user_management/#revoking-passwords) for all affected users.
