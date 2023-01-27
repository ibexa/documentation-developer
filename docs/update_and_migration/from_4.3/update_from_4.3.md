---
description: Update your installation to the latest v4.4 version from v4.3.x.
---

# Update from v4.3.x to v4.4

This update procedure applies if you are using a v4.2 installation.

## Update from v4.3.x to v4.3.latest

Before you update to v4.4, you need to go through the following steps to update to the latest maintenance release of v4.3 (v[[= latest_tag_4_3 =]]).

### Update the application to v4.3.latest

Run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_3 =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_3 =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_3 =]] --with-all-dependencies --no-scripts
    ```

## Update from v4.3.latest to v4.4

When you have the latest version of v4.3, you can update to v4.4.

### Update the application to v4.4

First, run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_4 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/content --force -v
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_4 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_4 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    ```

The `recipes:install` command installs new YAML configuration files.
Review the old YAML files and move your custom configuration to the relevant new files.

### Run data migration

#### Customer Portal self-registration

If you are using [[= product_name_exp =]] or [[= product_name_com =]],
run data migration required by the Customer Portal applications feature:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/corporate-account/src/bundle/Resources/migrations/application_internal_fields.yaml --name=2022_11_07_22_46_application_internal_fields.yaml
```

#### Flysystem v2

Local adapters' `directory` key changed to `location`.
It is defined in `config/packages/oneup_flysystem.yaml`:

```yaml
oneup_flysystem:
    adapters:
        default_adapter:
            local:
                location: '%kernel.cache_dir%/flysystem'
```

If you haven't applied custom changes to that file,
you can simply reset third party `oneup/flysystem-bundle` recipe by executing:

```bash
composer recipe:install --force --reset -- oneup/flysystem-bundle
```

### Update the database

Next, update the database.

[[% include 'snippets/update/db/db_backup_warning.md' %]]

Apply the following database update scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.2.latest-to-4.3.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.2.latest-to-4.3.0.sql
    ```

#### Ibexa Open Source

If you have no access to Ibexa DXP's `ibexa/installer` package, database upgrade is not necessary.

## Ensure password safety

Following [Security advisory: IBEXA-SA-2022-009](https://developers.ibexa.co/security-advisories/ibexa-sa-2022-009-critical-vulnerabilities-in-graphql-role-assignment-ct-editing-and-drafts-tooltips),
unless you can verify based on your log files that the vulnerability has not been exploited,
you should [revoke passwords](https://doc.ibexa.co/en/latest/users/user_management/#revoking-passwords) for all affected users.

## Finish update

Finish the update process:

``` bash
composer run post-install-cmd
```
