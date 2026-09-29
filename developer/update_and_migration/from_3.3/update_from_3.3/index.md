# Update from v3.3.x to v3.3.latest

Update your installation to the latest v3.3 version from an earlier v3.3 version.

This update procedure applies if you're using a v3.3 installation without the latest maintenance release. To update from an 3.2 to 3.3, see [Updating the app to v3.3](../../from_2.5/to_3.3/index.md). From older version, explore [this section](../../update_ibexa_dxp/index.md).

Go through the following steps to update to the latest maintenance release of v3.3 (v3.3.43).

> **Note: Note**
>
> You can only update to the latest patch release of 3.3.x.

## Update the application

> **Note: Note**
>
> If you're using v3.3.15 or earlier v3.3 version, or encounter an error related to flex.ibexa.co, you need to [update your Flex server](#update-flex-server) first.

Run:

**Ibexa Content**

```bash
composer require ibexa/content:3.3.43 --with-all-dependencies --no-scripts
```

**Ibexa Experience**

```bash
composer require ibexa/experience:3.3.43 --with-all-dependencies --no-scripts
```

**Ibexa Commerce**

```bash
composer require ibexa/commerce:3.3.43 --with-all-dependencies --no-scripts
```

To avoid deprecations when updating from an older PHP version to PHP 8.2 or 8.3, run the following commands:

```bash
composer config extra.runtime.error_handler "\\Ibexa\\Contracts\\Core\\MVC\\Symfony\\ErrorHandler\\Php82HideDeprecationsErrorHandler"
composer dump-autoload
```

### Update Flex server

The `flex.ibexa.co` Flex server has been disabled. If you're using v3.3.15 or earlier v3.3 version, you need to update your Flex server. In your `composer.json` check whether the `https://flex.ibexa.co` endpoint is still listed in `extra.symfony.endpoint`. If that's the case, you need to perform the following update procedure.

First, update the `symfony/flex` bundle to handle the new endpoint:

```bash
composer update symfony/flex --no-plugins --no-scripts;
```

Then, replace the `https://flex.ibexa.co` endpoint with the new [`https://api.github.com/repos/ibexa/recipes/contents/index.json?ref=flex/main`](https://github.com/ibexa/website-skeleton/blob/v3.3.20/composer.json#L98) endpoint in `composer.json` under `extra.symfony.endpoint`.

You can do it manually, or by running the following command:

```bash
composer config extra.symfony.endpoint "https://api.github.com/repos/ibexa/recipes/contents/index.json?ref=flex/main"
```

Next, continue with updating the app:

**Ibexa Content**

```bash
composer recipes:install ibexa/content --force -v
composer run post-install-cmd
```

**Ibexa Experience**

```bash
composer recipes:install ibexa/experience --force -v
composer run post-install-cmd
```

**Ibexa Commerce**

```bash
composer recipes:install ibexa/commerce --force -v
composer run post-install-cmd
```

Review the changes to make sure your custom configuration wasn't affected.

Remove the `vendor` folder to prevent issues related to the [new Flex server](#update-flex-server).

Then, perform a database upgrade and other steps relevant to the version you're updating to.

> **Caution: Clear Redis cache**
>
> If you're using Redis as your persistence cache storage you should always clear it manually after an upgrade. You can do it by executing the following command:
>
> ```bash
> php bin/console cache:pool:clear cache.redis
> ```

### v3.3.2

#### Update entity managers

Version v3.3.2 introduces new entity managers. To ensure that they work in multi-repository setups, you must update the Doctrine schema. You do this manually by following this procedure:

1. Update your project to v3.3.2 and run the `php bin/console cache:clear` command to generate the service container.

2. Run the following command to discover the names of the new entity managers. Take note of the names that you discover:

   `php bin/console debug:container --parameter=doctrine.entity_managers --format=json | grep ibexa_`

3. For every entity manager prefixed with `ibexa_`, run the following command:

   `php bin/console doctrine:schema:update --em=<ENTITY_MANAGER_NAME> --dump-sql`

4. Review the queries and ensure that there are no harmful changes that could affect your data.

5. For every entity manager prefixed with `ibexa_`, run the following command to run queries on the database:

   `php bin/console doctrine:schema:update --em=<ENTITY_MANAGER_NAME> --force`

#### VCL configuration for Fastly

If you use Fastly, deploy the most up-to-date VCL configuration.

Locate the `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/ez_main.vcl` file, make sure that it has been updated with the following changes, and upload it to your Fastly:

- Add the following lines:

```vcl
if (req.restarts == 0 && resp.status == 301 && req.http.x-fos-original-url) {
    set resp.http.location = regsub(resp.http.location, "/_fos_user_context_hash", req.http.x-fos-original-url);
}
```

- Move the `#FASTLY recv` macro call to a new location, right after the `Preserve X-Forwarded-For in all requests` section.

#### Optimize workflow queries

Run the following SQL queries to optimize workflow performance:

```sql
CREATE INDEX idx_workflow_co_id_ver ON ezeditorialworkflow_workflows(content_id, version_no);
CREATE INDEX idx_workflow_name ON ezeditorialworkflow_workflows(workflow_name);
```

#### Enable Commerce features

Commerce features in Experience and Content editions are disabled by default. If you use these features, after the update enable Commerce features by going to `config/packages/ecommerce.yaml` and setting the following:

```yaml
ezplatform:
    system:
        default:
            commerce:
                enabled: true
```

Next, run the following command:

```bash
php bin/console ibexa:upgrade --force
```

#### Database update

If you're using MySQL, run the following update script:

```sql
mysql -u<username> -p<password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-3.3.1-to-3.3.2.sql
```

### v3.3.4

#### Migration Bundle

Remove `Kaliop\eZMigrationBundle\eZMigrationBundle::class => ['all' => true],` from `config/bundles.php` before running `composer require`.

Then, in `composer.json`, set minimum stability to `stable`:

```json
"minimum-stability": "stable",
```

### v3.3.6

#### Symfony 5.3

To update to Symfony 5.3, update the following package versions in your `composer.json`, including the Symfony version (line 9):

```json
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

See <https://github.com/ibexa/website-skeleton/pull/5/files> for details of the package version change.

### v3.3.7

#### Commerce configuration

If you're using Commerce, run the following migration action to update the way Commerce configuration is stored:

```bash
mkdir --parent src/Migrations/Ibexa/migrations
cp vendor/ibexa/installer/src/bundle/Resources/install/migrations/content/Components/move_configuration_to_settings.yaml src/Migrations/Ibexa/migrations/
php bin/console ibexa:migrations:migrate --file=move_configuration_to_settings.yaml
```

#### Database update

Run the following scripts:

**MySQL**

```bash
mysql -u<username> -p<password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-3.3.6-to-3.3.7.sql
```

**PostgreSQL**

```bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-3.3.6-to-3.3.7.sql
```

### Ibexa Open Source

If you have no access to Ibexa DXP's `ibexa/installer` package, apply the following database upgrade script:

**MySQL**

```sql
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

**PostgreSQL**

```sql
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

**MySQL**

```bash
mysql -u<username> -p<password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-3.3.8-to-3.3.9.sql
```

**PostgreSQL**

```bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-3.3.8-to-3.3.9.sql
```

### v3.3.13

> **Note: Symfony 5.4**
>
> Prior to v3.3.13, Symfony 5.3 was used by default.
>
> If you're still using Symfony 5.3, you need to update your installation to Symfony 5.4. To do this, update your `composer.json` to refer to `5.4.*` instead or `5.3.*`.
>
> Refer to the relevant website skeleton: [content](https://github.com/ibexa/content-skeleton/blob/v3.3.13/composer.json), [experience](https://github.com/ibexa/experience-skeleton/blob/v3.3.13/composer.json), [commerce](https://github.com/ibexa/commerce-skeleton/blob/v3.3.13/composer.json).
>
> The following `sed` commands should update the relevant lines. Use them with caution and properly check the result:
>
> ```bash
> sed -i -E 's/"symfony\/(.+)": "5.3.*"/"symfony\/\1": "5.4.*"/' composer.json;
> sed -i -E 's/"require": "5.3.*"/"require": "5.4.*"/' composer.json;
> ```
>
> After this `composer.json` update, run `composer update "symfony/*"`.
>
> You may need to adapt configuration to fit the new minor version of Symfony. For example, you might have to remove `timeout` related config from `nelmio_solarium` bundle config:
>
> ```bash
> sed -i -E '/ *timeout: [0-9]+/d' ./config/packages/nelmio_solarium.yaml ./config/packages/ezcommerce/ezcommerce_advanced.yaml
> composer update "symfony/*"
> ```

#### Ibexa Cloud

Update Platform.sh configuration and scripts.

Generate new configuration with the following command:

```bash
composer ibexa:setup --platformsh
```

Review the changes applied to `.platform.app.yaml`, `.platform/` and `bin/platformsh_prestart_cacheclear.sh`, merge with your custom settings if needed, and commit them to Git.

### v3.3.14

#### VCL configuration

Update your Varnish VCL file to align with [`docs/varnish/vcl/varnish5.vcl`](https://github.com/ezsystems/ezplatform-http-cache/blob/2.3/docs/varnish/vcl/varnish5.vcl). Make sure it contains the highlighted additions.

```vcl
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

Adapt your `composer.json` file according to [`manifest.json`](https://github.com/ibexa/recipes/blob/master/ibexa/commerce/3.3/manifest.json#L167-L168), by adding and moving the following lines:

```diff
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

Ibexa DXP now supports Fastly shielding. If you're using Fastly and want to use shielding, you need to update your VCL files.

> **Tip: Tip**
>
> Even if you don't plan to use Fastly shielding, it's recommended to update the VCL files for future compatibility.

1. Locate the `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/ez_main.vcl` file and update your VCL file with the recent changes.
2. Do the same with `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/ez_user_hash.vcl`.
3. Upload a new `snippet_re_enable_shielding.vcl` snippet file, based on `vendor/ezsystems/ezplatform-http-cache-fastly/fastly/snippet_re_enable_shielding.vcl`.

### v3.3.25

#### Database update

On Experience or Commerce edition, run the following scripts:

**MySQL**

```bash
mysql -u<username> -p<password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-3.3.24-to-3.3.25.sql
```

**PostgreSQL**

```bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-3.3.24-to-3.3.25.sql
```

### v3.3.28

#### Ensure password safety

Following [Security advisory: IBEXA-SA-2022-009](https://developers.ibexa.co/security-advisories/ibexa-sa-2022-009-critical-vulnerabilities-in-graphql-role-assignment-ct-editing-and-drafts-tooltips), unless you can verify based on your log files that the vulnerability hasn't been exploited, you should revoke passwords for all affected users.

### v3.3.34

#### Database update

Run the following scripts:

**MySQL**

```sql
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-3.3.33-to-3.3.34.sql
```

**PostgreSQL**

```sql
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-3.3.33-to-3.3.34.sql
```

### v3.3.40

No additional steps needed.

### v3.3.41

#### Security

This release contains security fixes. For more information, see [the published security advisory](https://developers.ibexa.co/security-advisories/ibexa-sa-2024-006-vulnerabilities-in-content-name-pattern-commerce-shop-and-varnish-vhost-templates). For each of the following fixes, evaluate the vulnerability to determine whether you might have been affected. If so, take appropriate action, for example by revoking passwords for all affected users.

##### BREACH vulnerability

The [BREACH](https://www.breachattack.com/) attack is a security vulnerability against HTTPS when using HTTP compression.

If you're using Varnish, update the VCL configuration to stop compressing both the Ibexa DXP's REST API and JSON responses from your backend. Fastly users are not affected.

**Varnish on Ibexa Cloud**

Update the Varnish configuration.

Generate new configuration with the following command:

```bash
composer ibexa:setup --platformsh
```

Review the changes, merge with your custom settings if needed, and commit them to Git before deployment.

**Varnish 6**

Update your Varnish VCL file to align it with the [`vendor/ezsystems/ezplatform-http-cache/docs/varnish/vcl/varnish5.vcl`](https://github.com/ezsystems/ezplatform-http-cache/blob/2.3/docs/varnish/vcl/varnish5.vcl) file.

**Varnish 7**

Update your Varnish VCL file to align it with the [`vendor/ezsystems/ezplatform-http-cache/docs/varnish/vcl/varnish7.vcl`](https://github.com/ezsystems/ezplatform-http-cache/blob/2.3/docs/varnish/vcl/varnish7.vcl) file.

````

If you're not using a reverse proxy like Varnish or Fastly, adjust the compressed `Content-Type` in the web server configuration.
For more information, see the [updated Apache and nginx template configuration](https://github.com/ibexa/post-install/pull/86/files).

##### Outdated version of jQuery in ezsystems/ezcommerce-shop package

There are no additional update steps to execute.

#### Other changes

##### Remove duplicated entries in `ezcontentobject_attribute` table

This release comes with a command to clean up duplicated entries in the `ezcontentobject_attribute` table, which were created due to an issue related to previewing content in different languages.

If you're affected, remove the duplicated entries by running the following command:

```bash
php bin/console ibexa:content:remove-duplicate-fields
````

> **Caution: Caution**
>
> Remember about [**proper database backup**](../../../infrastructure_and_maintenance/backup/index.md) before running the command in the production environment.

You can customize the behavior of the command with the following options:

- `--batch-size` or `-b` - number of attributes affected per iteration. Default value = 10000.
- `--max-iterations` or `-i` - maximum iterations count. Default value = -1 (unlimited).
- `--sleep` or `-s` - wait time between iterations, in milliseconds. Default value = 0.

##### Update web server configuration

Adjust the web server configuration to prevent direct access to the `index.php` file when using URLs consisting of multiple path segments.

See [the updated Apache and nginx template files](https://github.com/ibexa/post-install/pull/70/files) for more information.

#### Removed `symfony/serializer-pack` dependency

This release no longer directly requires the `symfony/serializer-pack` Composer dependency, which can remove some dependencies from your project during the update process.

If you rely on them in your project, for example by using Symfony's `ObjectNormalizer` to create your own REST endpoints, run the following command before updating Ibexa packages:

```bash
composer require symfony/serializer-pack
```

Then, verify that Symfony Flex installed the versions you were using before.

### v3.3.42

#### Security

This release fixes a critical vulnerability in the [RichText field type](../../../content_management/field_types/field_type_reference/richtextfield/index.md). By entering a maliciously crafted input into the RichText field type's XML, the attacker could perform an attack using [XML external entity (XXE) injection](https://portswigger.net/web-security/xxe). To exploit this vulnerability, an attacker would need to have edit permission to content with RichText fields.

For more information, see the [published security advisory IBEXA-SA-2025-002](https://developers.ibexa.co/security-advisories/ibexa-sa-2025-002-xxe-vulnerability-in-richtext).

Evaluate the vulnerability to determine whether you might have been affected. If so, take appropriate action. There are no additional update steps to execute.

### v3.3.43

#### Security

This security advisory resolves XSS vulnerabilities in several parts of the back office of the DXP. Back office access and varying levels of editing and management permissions are required to exploit these vulnerabilities.

For more information, see the [security advisory IBEXA-SA-2025-003](https://developers.ibexa.co/security-advisories/ibexa-sa-2025-003-xss-vulnerabilities-in-back-office).

Evaluate the vulnerability to determine whether you might have been affected. If so, take appropriate action. There are no additional update steps to execute.

## Finish the update

### A. Platform.sh changes

If you're hosting your site on Ibexa Cloud be aware of the fact that Varnish is enabled by default as of v1.13.5, v2.4.3 and v2.5.0. If you're using Fastly, read about [how to disable Varnish](https://fixed.docs.upsun.com/guides/ibexa/fastly.html#remove-varnish-configuration).

### B. Dump assets

Dump web assets if you're using the `prod` environment. In `dev` this happens automatically:

```sh
yarn install
yarn encore prod
```

If you encounter problems, additionally clear the cache and install assets:

```sh
php bin/console cache:clear -e prod
php bin/console assets:install --symlink -e prod
yarn install
yarn encore prod
```

### C. Commit, test and merge

When you resolve all conflicts and update `composer.lock`, commit the merge.

You may or may not keep `composer.lock`, depending on your version management workflow. If you don't want to keep it, run `git reset HEAD composer.lock` to remove it from the changes. Run `git commit`, and adapt the message if necessary.

Go back to `master`, and merge the `update-{{ target_version }}` branch:

```sh
git checkout master
git merge update-{{ target_version }}
```

> **Note: Insecure password hashes**
>
> To ensure that no users have unsupported, insecure password hashes, run the following command:
>
> ```bash
> # In v1 and v2:
> php bin/console ezplatform:user:validate-password-hashes
> # In v3:
> php bin/console ibexa:user:validate-password-hashes
> ```
>
> This command checks if all user hashes are up-to-date and informs you if any of them need to be updated.

### D. Complete the update

Complete the update by running the following commands:

```bash
# In v2.5:
php bin/console ezplatform:graphql:generate-schema
# In v3:
php bin/console ibexa:graphql:generate-schema

composer run post-install-cmd
```

## Notify support

Inform the support team that you have updated your installation. They update your Service portal to match the new version. This ensures that you receive notifications about new maintenance releases and security advisories for the correct version. You can contact the support team at [support@ibexa.co](mailto:support@ibexa.co) or through your [Service portal](https://support.ibexa.co).
