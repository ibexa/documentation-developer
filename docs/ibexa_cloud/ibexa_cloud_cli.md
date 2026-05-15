---
description: Use the [[= product_name_cloud =]] CLI to manage your I[[= product_name_cloud =]] projects from the command line.
month_change: true
---

# [[= product_name_cloud =]] CLI

The [[= product_name_cloud =]] CLI (`ibexa_cloud`) is a command-line tool for managing your [[= product_name_cloud =]] projects.
It is based on the [Upsun CLI](https://docs.upsun.com/administration/cli.html) and shares the same commands.

## Installation

Follow the installation instructions at [cli.ibexa.cloud](https://cli.ibexa.cloud/).

After installation, authenticate with your [[= product_name_cloud =]] account:

```bash
ibexa_cloud auth:browser-login
```

## Command reference

For the full list of available commands, see the [Upsun CLI reference](https://developer.upsun.com/cli/reference).
Replace `upsun` with `ibexa_cloud` in all examples.

## Examples

### Run a SQL script

To execute a SQL upgrade script on a [[= product_name_cloud =]] environment, pass it to `ibexa_cloud sql`:

=== "MySQL"

    ```bash
    ibexa_cloud sql < vendor/ibexa/installer/upgrade/db/mysql/ibexa-x.x.x-to-x.x.y.sql
    ```

=== "PostgreSQL"

    ```bash
    ibexa_cloud sql < vendor/ibexa/installer/upgrade/db/postgresql/ibexa-x.x.x-to-x.x.y.sql
    ```

### Connect with a SQL client

To connect to the database using any SQL client, start a SSH tunnel by running the following command in the project directory:

```bash
ibexa_cloud tunnel:open
```

The command outputs connection details, for example:

``` shell-session
SSH tunnel opened to database at: mysql://user:<PASSWORD>@127.0.0.1:30000/main
```

Use the displayed host, port, database name, username, and password to configure your SQL client.

When you're done, close the tunnel:

```bash
ibexa_cloud tunnel:close
```
