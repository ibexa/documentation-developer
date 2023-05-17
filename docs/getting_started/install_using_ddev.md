# Install using DDEV

This guide provides a step-by-step walkthrough of installing [[= product_name =]] using [DDEV](https://ddev.com/).
DDEV is an open-source tool that simplifies the process of setting up local PHP development environments.

## System requirements

For a successful installation, ensure you have the following software installed:

- [Docker](https://docs.docker.com/get-docker/)
- [DDEV](https://ddev.readthedocs.io/en/latest/users/install/ddev-installation/)

## Installation steps

### 1. Create a DDEV project directory

Start by creating a directory for your DDEV project. Navigate to your desired location in the terminal, then use the following command to create a new directory:

```bash
mkdir my-ddev-project && cd my-ddev-project
```

Replace `my-ddev-project` with your desired directory name.

### 2. Configure DDEV

#### Configure PHP version and document root

Next, configure your DDEV environment using the command below:

```bash
ddev config --project-type=php --php-version 8.1 --docroot=public --create-docroot
```

This command sets the project type to PHP, the PHP version to 8.1, the document root to `public` directory, and creates the document root.

#### Optional: Switch to PostgreSQL Database

By default, DDEV uses MySQL (MariaDB). To use PostgreSQL instead, run the following command:

```bash
ddev config --database=postgres:15
```

#### Configure database connection

Now, configure the database connection for your Ibexa DXP project. Depending on your database of choice (MySQL or PostgreSQL), use the appropriate command below.

!!! note

    Those commands will set a `DATABASE_URL` environment variable inside the container which override [the .env's one](install_ibexa_dxp.md#change-installation-parameters).

#### MySQL

```bash
ddev config --web-environment-add DATABASE_URL=mysql://db:db@db:3306/db
```

#### PostgreSQL

```bash
ddev config --web-environment-add DATABASE_URL=postgresql://db:db@db:5432/db
```

#### Optional: Enable Mutagen

If you're using MacOS or Windows, you might wish to enable [Mutagen](https://ddev.readthedocs.io/en/latest/users/install/performance/#mutagen) for performance. You can do this by running the following command:

```bash
ddev config --mutagen-enabled
```

#### Optional: Change port mapping

By default, DDEV will use ports 80 and 443.
You can [set different ports](https://ddev.readthedocs.io/en/latest/users/usage/troubleshooting/#method-2-fix-port-conflicts-by-configuring-your-project-to-use-different-ports) with a command like the following:

```bash
ddev config --http-port=8080 --https-port=8443
```

### 3. Start DDEV

Proceed by starting your DDEV environment with the following command:

```bash
ddev start
```

!!! tip

    If you forgot a configuration, you can still use `ddev config` but you got to restart afterward using `ddev restart`.

### 4. Composer authentification

If you're installing the Commerce, Experience, or Content edition of Ibexa DXP, you'll need to [set up authentification tokens](install_ibexa_dxp.md#set-up-authentication-tokens) by modifying the Composer configuration.
It must be done **after** executing the `ddev start` command as it will be run inside the container.

```bash
ddev composer config --global http-basic.updates.ibexa.co <installation-key> <token-password>
```

Replace `<installation-key>` and `<token-password>` with your actual installation key and token password, respectively.

### 5. Create Ibexa DXP project

Once DDEV is running, use Composer to create a new Ibexa DXP project. Remember to replace `<edition>` and `<version>` with your desired edition and versions respectively.

```bash
ddev composer create ibexa/<edition>-skeleton:<version>
```

### 6. Install the DXP and its database

Once you've made this change, you can proceed to install Ibexa DXP.

```bash
ddev exec php bin/console ibexa:install
ddev exec php bin/console ibexa:graphql:generate-schema
```

### 7. Open browser

Once the above steps are completed, open your Ibexa DXP webpage by running the `ddev launch` command.

!!! Note

    The project's URL was also given in `ddev start` output.

### 8. Start using Ibexa DXP

You can now start using Ibexa DXP and implement your own website on the platform.
You can follow the [first usual steps](first_steps.md), the [Beginner tutorial](../tutorials/beginner_tutorial/beginner_tutorial.md) or partner agreements trainings.

The configuration and code in the DDEV project directory can be edited.
You can use the command you'll cross in the documentation by prefixing them with `ddev exec` or by opening a terminal inside the container using `ddev ssh`.
For example, if a guideline invites you to run `php bin/console cache:clear`, you can do it in the DDEV container by following one of those two ways:
- running `ddev exec php bin/console cache:clear`
- entering `ddev ssh` and run after the new prompt `php bin/console cache:clear`

## Going further

DDEV can be useful to locally simulate a production cluster.
See _[Clustering using DDEV](../infrastructure_and_maintenance/clustering/clustering_using_ddev.md)_ to add Elasticsearch, Redis, Memcached or Varnish to your DDEV installation.

TODO: See Ibexa Cloud with DDEV https://ddev.readthedocs.io/en/latest/users/providers/platform/

## Stop or remove the project

If you need to simply stop the project to start it again latter, use `ddev stop`. Afterward, a `ddev start` will run the project in the same state.

If you want to fully remove the project,
- stop the DDEV container with a removal of the data and without backup: `ddev stop --omit-snapshot --remove-data --unlist`;
- remove the project folder: `cd .. && rm -r my-ddev-project`
