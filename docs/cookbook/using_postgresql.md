# Using PostgreSQL

eZ Platform uses MySQL by default, but you can also choose to install it with PostgreSQL.

## Requirements

To use PostgreSQL, you need to have the `pdo_pgsql` PHP extension installed.

If it is not enabled yet, enable `EzSystems\DoctrineSchemaBundle\DoctrineSchemaBundle()` in `AppKernel.php`.

## Provide parameters

When you run `composer install`, you will be asked to [provide installation parameters](../getting_started/install_ez_platform.md#provide-installation-parameters).

If you use PostgreSQL, two parameters need to be set differently than when using MySQL:

- `env(DATABASE_DRIVER)` must be set to `pdo_pgsql` instead of the default `pdo_mysql`
- `env(DATABASE_CHARSET)` must be set to `utf8`, because PostgreSQL does not support the default value of `utf8mb4`.

The rest of the installation procedure is the same as when using MySQL.
