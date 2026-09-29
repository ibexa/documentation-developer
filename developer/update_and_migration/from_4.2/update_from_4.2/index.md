# Update from v4.2.x to v4.3

Update your installation to the latest v4.3 version from v4.2.x.

This update procedure applies if you're using a v4.2 installation.

> **Caution: Temporary need of Composerconflict**
>
> To go through this update, [map the conflicting packages](https://getcomposer.org/doc/04-schema.md#conflict) in your `composer.json` file as following:
>
> ```json
> "conflict": {
>     "jms/serializer": ">=3.30.0",
>     "gedmo/doctrine-extensions": ">=3.12.0"
> },
> ```
>
> These entries can be removed after fully upgrading to v4.6 LTS.

## Update from v4.2.x to v4.2.latest

Before you update to v4.3, you need to go through the following steps to update to the latest maintenance release of v4.2 (v4.2.4).

### Update the application

Run:

**Ibexa Content**

```bash
composer require ibexa/content:4.2.4 --with-all-dependencies --no-scripts
```

**Ibexa Experience**

```bash
composer require ibexa/experience:4.2.4 --with-all-dependencies --no-scripts
```

**Ibexa Commerce**

```bash
composer require ibexa/commerce:4.2.4 --with-all-dependencies --no-scripts
```

## Update from v4.2.latest to v4.3

When you have the latest version of v4.2, you can update to v4.3.

### Update the application

First, run:

**Ibexa Content**

```bash
composer require ibexa/content:4.3.5 --with-all-dependencies --no-scripts
composer recipes:install ibexa/content --force -v
```

**Ibexa Experience**

```bash
composer require ibexa/experience:4.3.5 --with-all-dependencies --no-scripts
composer recipes:install ibexa/experience --force -v
```

**Ibexa Commerce**

```bash
composer require ibexa/commerce:4.3.5 --with-all-dependencies --no-scripts
composer recipes:install ibexa/commerce --force -v
```

The `recipes:install` command installs new YAML configuration files. Review the old YAML files and move your custom configuration to the relevant new files.

### Run data migration

#### Customer Portal self-registration

If you're using Ibexa Experience or Ibexa Commerce, run data migration required by the Customer Portal self-registration feature:

```bash
php bin/console ibexa:migrations:import vendor/ibexa/corporate-account/src/bundle/Resources/migrations/corporate_account_registration.yaml --name=012_corporate_account_registration.yaml
```

#### Migration to `customer` content type

This step is required if you have users in your installation that need to be transferred to a new User content type: `customer`. This content type is dedicated to registered frontend customers. This migration is intended for all product versions. If there are no users that are customers in your platform, you can skip this step and move on to [executing migrations](#execute-migrations).

##### Basic migration

Use this option to define a user group that should be migrated to a new content type.

```bash
php bin/console ibexa:migrate:customers  --input-user-group=3a3beb3d09ae0dacebf1d324f61bbc34 --create-content-type
```

- `--input-user-group` - represents the remote ID of a user group you want to migrate to a new content type. After migration, this is also the ID of a new Private Customer user group.
- `--create-content-type` - if you add this parameter, the system creates the new content type based on the one defined in `--input-user-content-type`

##### Additional parameters

Use the parameters below if you need to change a content type name during migration, for example because you already have a `customer` content type, or you want to define different source content type. If you don't have custom User content types, use the basic migration.

- `--input-user-content-type` - defines input content type
- `--output-user-content-type` - defines output content type
- `--user` - defines the user that this command should be executed as, default is Admin
- `--batch-limit` - defines data limit for migration of one batch, default value is 25

> **Caution: Caution**
>
> This improvement prevents logged in backend users from making purchases in the frontend store.

#### Execute migrations

Run `php bin/console ibexa:migrations:migrate -v --dry-run` to ensure that all migrations are ready to be performed. If the dry run is successful, run the following command to execute the above migrations:

```bash
php bin/console ibexa:migrations:migrate
```

### Update the database

Next, update the database.

> **Caution: Caution**
>
> Always back up your data before running any database update scripts.
>
> After updating the database, clear the cache.
>
> Don't use `--force` argument for `mysql` / `psql` commands when performing update queries. If there is any problem during the update, it's best if the query fails immediately, so you can fix the underlying problem before you execute the update again. If you leave this for later you risk ending up with an incompatible database, though the problems might not surface immediately.

Apply the following database update scripts:

**MySQL**

```bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ibexa-4.2.latest-to-4.3.0.sql
```

**PostgreSQL**

```bash
psql <database_name> < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-4.2.latest-to-4.3.0.sql
```

#### Ibexa Open Source

If you have no access to Ibexa DXP's `ibexa/installer` package, database upgrade isn't necessary.

### Clean-up taxonomy database

Run the following command for each of your taxonomies to ensure that there are no [content items orphaned during deletion of subtrees](https://doc.ibexa.co/en/4.6/content_management/taxonomy/taxonomy/#remove-orphaned-content-items):

`php bin/console ibexa:taxonomy:remove-orphaned-content <taxonomy> --force`

For example:

```bash
php bin/console ibexa:taxonomy:remove-orphaned-content tags --force
php bin/console ibexa:taxonomy:remove-orphaned-content product_categories --force
```

## Ensure password safety

Following [Security advisory: IBEXA-SA-2022-009](https://developers.ibexa.co/security-advisories/ibexa-sa-2022-009-critical-vulnerabilities-in-graphql-role-assignment-ct-editing-and-drafts-tooltips), unless you can verify based on your log files that the vulnerability has not been exploited, you should [revoke passwords](https://doc.ibexa.co/en/4.6/users/passwords/#revoking-passwords) for all affected users.

## Finish update

Finish the update process:

```bash
composer run post-install-cmd
```
