---
description: Update your installation to the latest v4.3 version from v4.2.x.
---

# Update from v4.2.x to v4.3

This update procedure applies if you are using a v4.2 installation.

## Update from v4.2.x to v4.2.latest

Before you update to v4.3, you need to go through the following steps to update to the latest maintenance release of v4.2 (v[[= latest_tag_4_2 =]]).

### Update the application

Run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_2 =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_2 =]] --with-all-dependencies --no-scripts
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_2 =]] --with-all-dependencies --no-scripts
    ```

## Update from v4.2.latest to v4.3

When you have the latest version of v4.2, you can update to v4.3.

### Update the application

First, run:

=== "[[= product_name_content =]]"

    ``` bash
    composer require ibexa/content:[[= latest_tag_4_3 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/content --force -v
    ```

=== "[[= product_name_exp =]]"

    ``` bash
    composer require ibexa/experience:[[= latest_tag_4_3 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/experience --force -v
    ```

=== "[[= product_name_com =]]"

    ``` bash
    composer require ibexa/commerce:[[= latest_tag_4_3 =]] --with-all-dependencies --no-scripts
    composer recipes:install ibexa/commerce --force -v
    ```

The `recipes:install` command installs new YAML configuration files.
Review the old YAML files and move your custom configuration to the relevant new files.

### Run data migration

#### Customer Portal self-registration

If you are using [[= product_name_exp =]] or [[= product_name_com =]],
run data migration required by the Customer Portal self-registration feature:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/corporate-account/src/bundle/Resources/migrations/corporate_account_registration.yaml --name=012_corporate_account_registration.yaml
```

#### Migration to `customer` Content Type

This step is required if you have users in your installation that need to be transferred to a new User Content Type: `customer`.
This Content Type is dedicated to registered frontend customers.
This migration is intended for all product versions.
If there are no users that are customers in your platform, you can skip this step and move on to [executing migrations](#execute-migrations).

##### Basic migration

Use this option to define a user group that should be migrated to a new Content Type.

```bash
php bin/console ibexa:migrate:customers  --input-user-group=3a3beb3d09ae0dacebf1d324f61bbc34 --create-content-type
```

- `--input-user-group` - represents the remote ID of a User Group you want to migrate to a new Content Type.
After migration, this will also be the ID of a new Private Customer User Group.
- `--create-content-type` - if you add this parameter, the system creates the new Content Type based on the one defined in `--input-user-content-type`

##### Additional parameters

Use the parameters below if you need to change a Content Type name during migration, for example because you already have a `customer` Content Type,
or you want to define different source Content Type.
If you don't have custom User Content Types, use the basic migration.

- `--input-user-content-type` - defines input Content Type
- `--output-user-content-type` - defines output Content Type
- `--user` - defines the user that this command should be executed as, default is Admin
- `--batch-limit` - defines data limit for migration of one batch, default value is 25

!!! caution

    This improvement will prevent logged in backend users from making purchases in the frontend store.

#### Execute migrations

Run `php bin/console ibexa:migrations:migrate -v --dry-run` to ensure that all migrations are ready to be performed.
If the dry run is successful, run the following command to execute the above migrations:

``` bash
php bin/console ibexa:migrations:migrate
```

### Update the database

Next, update the database.

[[% include 'snippets/update/db/db_backup_warning.md' %]]

Apply the following database update scripts:

=== "MySQL"

    ``` bash
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.2.2-to-4.2.3.sql
    mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.2.latest-to-4.3.0.sql
    ```

=== "PostgreSQL"

    ``` bash
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.2.2-to-4.2.3.sql
    psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.2.latest-to-4.3.0.sql
    ```

#### Ibexa Open Source

If you have no access to [[= product_name =]]'s `ibexa/installer` package, database upgrade is not necessary.

### Clean-up taxonomy database

Run the following command for each of your taxonomies to ensure that there are no [Content items orphaned during deletion of subtrees](https://doc.ibexa.co/en/latest/content_management/taxonomy/taxonomy/#remove-orphaned-content-items):

`php bin/console ibexa:taxonomy:remove-orphaned-content <taxonomy> --force`

For example:

```bash
php bin/console ibexa:taxonomy:remove-orphaned-content tags --force
php bin/console ibexa:taxonomy:remove-orphaned-content product_categories --force
```

## Ensure password safety

Following [Security advisory: IBEXA-SA-2022-009](https://developers.ibexa.co/security-advisories/ibexa-sa-2022-009-critical-vulnerabilities-in-graphql-role-assignment-ct-editing-and-drafts-tooltips),
unless you can verify based on your log files that the vulnerability has not been exploited,
you should [revoke passwords](https://doc.ibexa.co/en/latest/users/passwords/#revoking-passwords) for all affected users.

## Finish update

Finish the update process:

``` bash
composer run post-install-cmd
```
