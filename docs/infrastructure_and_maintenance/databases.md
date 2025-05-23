---
description: Ibexa DXP can use MySQL, PostgreSQL or MariaDB as its database.
---

# Databases

## Using PostgreSQL

[[= product_name =]] uses MySQL by default, but you can also choose to install it with PostgreSQL.

### Requirements

To use PostgreSQL, you need to have the `pdo_pgsql` PHP extension installed.

### Provide parameters

When you run `composer install`, you're asked to [provide installation parameters](install_ibexa_dxp.md#change-installation-parameters).

!!! tip

    It's recommended to store the database credentials in your `.env.local` file and not commit it to the Version Control System.

If you use PostgreSQL, the following parameters need to be set differently in the `.env.local` file than when using MySQL:

- `DATABASE_NAME`
- `DATABASE_HOST`
- `DATABASE_PORT`
- `DATABASE_PLATFORM` must be set to `pgsql` instead of `mysql`
- `DATABASE_DRIVER` must be set to `pdo_pgsql` instead of the default `pdo_mysql`
- `DATABASE_VERSION`
- `DATABASE_CHARSET` must be set to `utf8`, because the default value of `utf8mb4` is MySQL-specific.

The rest of the installation procedure is the same as when using MySQL.
