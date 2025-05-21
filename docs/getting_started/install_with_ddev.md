---
description: Install Ibexa DXP with Docker and DDEV to use it for development.
---

# Install with DDEV

This guide provides a step-by-step walkthrough of installing [[= product_name =]] by using [DDEV](https://ddev.com/).
DDEV is an open-source tool that simplifies the process of setting up local PHP development environments.

## Requirements

Before you start the installation, ensure that you have the following software installed:

- [Docker](https://docs.docker.com/get-started/get-docker/)
- [DDEV](https://ddev.readthedocs.io/en/latest/users/install/ddev-installation/)

## Installation

### 1. Create a DDEV project directory

Start by creating a new directory for your DDEV project by using the following command, where `<my-ddev-project>` stands for your desired directory name:

```bash
mkdir my-ddev-project && cd my-ddev-project
```

### 2. Configure DDEV

#### Configure PHP version and document root

Next, configure your DDEV environment with the following command:

```bash
ddev config --project-type=php --php-version 8.3 --nodejs-version 20 --docroot=public
```

This command sets the project type to PHP, the PHP version to 8.3, the document root to `public` directory, and creates the document root if it doesn't exist.

#### Use another database type (optional)

By default, DDEV uses MariaDB.

To use PostgreSQL instead, run the following command:

```bash
ddev config --database=postgres:14
```

To use MySQL instead, run the following command:

```bash
ddev config --database=mysql:8.0
```

You can also use other versions of MariaDB, Mysql or PostgreSQL.
See [DDEV database types documentation](https://ddev.readthedocs.io/en/latest/users/extend/database-types/) for available version ranges.

#### Configure database connection

Now, configure the database connection for your [[= product_name =]] project.
Depending on your database of choice (MySQL or PostgreSQL), use the appropriate command below.

!!! note

    Those commands set a `DATABASE_URL` environment variable inside the container which overrides [the variable from `.env`](install_ibexa_dxp.md#change-installation-parameters).

    To use `.env.local` file instead of server-level environment variables, see [Using dotenv](#using-dotenv).

=== "MariaDB / MySQL"

    ```bash
    ddev config --web-environment-add DATABASE_URL=mysql://db:db@db:3306/db
    ```

    To ensure consistent character set when performing operations both in Symfony context and with the `ddev mysql` client add the following database server configuration.

    Create the file `.ddev/mysql/utf8mb4.cnf` with the following content:

    ```cfg
    [mysqld]
    character-set-server = utf8mb4
    collation-server = utf8mb4_unicode_520_ci
    ```

=== "PostgreSQL"

    ```bash
    ddev config --web-environment-add DATABASE_URL=postgresql://db:db@db:5432/db
    ```

#### Enable Mutagen (optional)

If you're using macOS or Windows, you might want to enable [Mutagen](https://ddev.readthedocs.io/en/latest/users/install/performance/#mutagen) to improve performance.
You can do this by running the following command:

```bash
ddev config --performance-mode=mutagen
```

See [DDEV performance documentation](https://ddev.readthedocs.io/en/latest/users/install/performance/) for more.

#### Change port mapping (optional)

By default, DDEV uses ports 80 and 443.
You can [set different ports](https://ddev.readthedocs.io/en/latest/users/usage/troubleshooting/#method-2-fix-port-conflicts-by-configuring-your-project-to-use-different-ports) with a command like the following:

```bash
ddev config --router-http-port=8080 --router-https-port=8443
```

### 3. Start DDEV

Proceed by starting your DDEV environment with the following command:

```bash
ddev start
```

!!! tip

    If you forgot some part of configuration, you can set it by using `ddev config` later, but afterwards you have to restart DDEV with `ddev restart`.

### 4. Composer authentication

Next, you need to [set up authentication tokens](install_ibexa_dxp.md#set-up-authentication-tokens) by modifying the Composer configuration.
You must run the following command **after** executing `ddev start`, because the command runs inside the container.
Replace `<installation-key>` and `<token-password>` with your actual installation key and token password.

```bash
ddev composer config --global http-basic.updates.ibexa.co <installation-key> <token-password>
```

This authentication doesn't persist if the project is restarted (by `ddev restart` or `ddev composer create`).
You can back up the authentication file (`auth.json`) by using the following command:

```bash
ddev exec "mkdir -p .ddev/homeadditions/.composer; cp ~/.composer/auth.json .ddev/homeadditions/.composer"
```

If you want to reuse an existing `auth.json` file, see [Using `auth.json`](#using-authjson).

### 5. Create project

Once DDEV is running, use Composer to create a new [[= product_name =]] project.
Remember to replace `<edition>` and `<version>` with your desired edition and version.

```bash
ddev composer create ibexa/<edition>-skeleton:<version>
```

!!! tip

    Consider adding the Symfony Debug bundle which fixes memory outage when dumping objects with circular references.
    `ddev composer require --dev symfony/debug-bundle`

### 6. Install the platform and its database

Once you've made this change, you can proceed to install [[= product_name =]].

```bash
ddev php bin/console ibexa:install
ddev php bin/console ibexa:graphql:generate-schema
```

### 7. Open browser

Once the above steps are completed, open the [[= product_name =]]'s webpage by running the `ddev launch` command.

!!! tip

    You can also see the project URL in the `ddev start` output.

### 8. Start using [[= product_name =]]

You can now start using [[= product_name =]] and implement your own website on the platform.

You can edit the configuration and code in the DDEV project directory.
You can use commands listed in the documentation by prefixing them with `ddev exec` or by opening a terminal inside the container by using `ddev ssh`.
For example, if a guideline invites you to run `php bin/console cache:clear`, you can do it in the DDEV container in one of the following ways:

- run `ddev php bin/console cache:clear`
- enter `ddev ssh` and run `php bin/console cache:clear` after the new prompt

## Other options for configuration

DDEV offers several ways to get the same result, offering different levels of flexibility or adaptability to your development environment.

!!! tip

    Learn more about the [DDEV commands](https://ddev.readthedocs.io/en/latest/users/usage/commands/):

    - run [`ddev --help`](https://ddev.readthedocs.io/en/latest/users/usage/cli/#using-the-ddev-command) to list all commands
    - run [`ddev help <command>`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#help) to get usage details about a specific command

    Learn more about DDEV configuration from [`ddev config` command documentation](https://ddev.readthedocs.io/en/latest/users/usage/commands/#config) and [advanced configuration files documentation](https://ddev.readthedocs.io/en/latest/users/configuration/config/).


### Using `auth.json`

An `auth.json` file can be used for one project, or globally for all projects, with the [DDEV `homeaddition` feature](https://ddev.readthedocs.io/en/latest/users/extend/in-container-configuration/).

For example, you can copy an `auth.json` file to a DDEV project: `cp <path-to-an>/auth.json .ddev/homeadditions/.composer`

Alternatively, the Composer global `auth.json` can be the DDEV global `auth.json` with the help of a symbolic link: `mkdir -p ~/.ddev/homeadditions/.composer && ln -s ~/.composer/auth.json ~/.ddev/homeadditions/.composer/auth.json`

If the DDEV project has already been started, you need to run `ddev restart`.

The use of an `auth.json` file replaces step [4. Composer authentication](#4-composer-authentication).

### Using Dotenv

Instead of using environment variables inside the container, a [`.env.local`]([[= symfony_doc =]]/configuration.html#overriding-environment-values-via-env-local) file can be added to the project.

The following example shows the use of `.env.local` with database configuration:

- Skip step [2. Configure DDEV / Configure database connection](#configure-database-connection).
- Modify step [5. Create [[= product_name =]] project](#5-create-project) to insert the database setting:
  ```bash
  ddev composer create ibexa/commerce-skeleton --no-install;
  echo "DATABASE_URL=mysql://db:db@db:3306/db" >> .env.local;
  ddev composer install;
  ```

!!! note "Precedence"

    For the same variable, its server level environment value overrides its application level `.env` value.
    To switch a variable from `ddev config --web-environment-add` command to `.env.local` file, you have to do either of the following:

    - remove it from under the `web_environment:` key in `.ddev/config.yaml` file then restart the project
    - rebuild the project from scratch

### Nginx Server Blocks

Even if [[= product_name =]] works with the default Nginx configuration that comes with DDEV, it's recommended to use a dedicated one.

Copy the Server Blocks template as a new Nginx configuration:

```bash
cp vendor/ibexa/post-install/resources/templates/nginx/vhost.template .ddev/nginx_full/ibexa.conf
cp -r vendor/ibexa/post-install/resources/templates/nginx/ibexa_params.d .ddev/nginx_full/
```

Then, replace the placeholders with the appropriate values in `.ddev/nginx_full/ibexa.conf`:

| Placeholder             | Value                        |
|-------------------------|------------------------------|
| `%PORT%`                | `80`                         |
| `%HOST_LIST%`           | `*.ddev.site`                |
| `%BASEDIR%`             | `/var/www/html`              |
| `%BODY_SIZE_LIMIT_M%`   | `0`                          |
| `%TIMEOUT_S%`           | `90s`                        |
| `%FASTCGI_PASS%`        | `unix:/var/run/php-fpm.sock` |
| `%BINARY_DATA_HANDLER%` | empty string                 |

Because of path resolution inside DDEV's Nginx, you must replace one more thing: `ibexa_params.d` with `sites-enabled/ibexa_params.d`.

You can, for example, do it with `sed`:

```bash
sed -i 's/%PORT%/80/' .ddev/nginx_full/ibexa.conf;
sed -i 's/%HOST_LIST%/*.ddev.site/' .ddev/nginx_full/ibexa.conf;
sed -i 's/%BASEDIR%/\/var\/www\/html/' .ddev/nginx_full/ibexa.conf;
sed -i 's/%BODY_SIZE_LIMIT_M%/0/' .ddev/nginx_full/ibexa.conf;
sed -i 's/%TIMEOUT_S%/90s/' .ddev/nginx_full/ibexa.conf;
sed -i 's/%FASTCGI_PASS%/unix:\/var\/run\/php-fpm.sock/' .ddev/nginx_full/ibexa.conf;
sed -i 's/%BINARY_DATA_HANDLER%//' .ddev/nginx_full/ibexa.conf;
sed -i 's/ibexa_params.d/sites-enabled\/ibexa_params.d/' .ddev/nginx_full/ibexa.conf;
```

If you want to use HTTPS, you must add the following rule to avoid mixed content (HTTPS pages linking to HTTP resources): `fastcgi_param HTTPS $fcgi_https;`

For example, you can append it to [[= product_name_base =]]'s FastCGI config:

```bash
echo 'fastcgi_param HTTPS $fcgi_https;' >> .ddev/nginx_full/ibexa_params.d/ibexa_fastcgi_params
```

### Switch to Apache and its virtual host

To use Apache instead of the default Nginx, run the following command:

```bash
ddev config --webserver-type=apache-fpm
```

[[= product_name =]] can't run on Apache without a dedicated virtual host.

To set the Apache virtual host, override `.ddev/apache/apache-site.conf` with [[= product_name =]]'s config.
You can do it manually or by using a script.

#### Manual procedure

Copy the virtual host template as the new Apache configuration:

```bash
cp vendor/ibexa/post-install/resources/templates/apache2/vhost.template .ddev/apache/apache-site.conf
```

Then, replace the placeholders with the appropriate values in `.ddev/apache/apache-site.conf`:

| Placeholder         | Value                        |
|---------------------|------------------------------|
| `%IP_ADDRESS%`      | `*`                          |
| `%PORT%`            | `80`                         |
| `%HOST_NAME%`       | `my-ddev-project.ddev.site`  |
| `%HOST_ALIAS%`      | `*.ddev.site`                |
| `%BASEDIR%`         | `/var/www/html`              |
| `%BODY_SIZE_LIMIT%` | `0`                          |
| `%TIMEOUT%`         | `0`                          |
| `%FASTCGI_PASS%`    | `unix:/var/run/php-fpm.sock` |

You can, for example, do it with `sed`:

```bash
sed -i 's/%IP_ADDRESS%/*/' .ddev/apache/apache-site.conf
sed -i 's/%PORT%/80/' .ddev/apache/apache-site.conf
sed -i 's/%BASEDIR%/\/var\/www\/html/' .ddev/apache/apache-site.conf
sed -i 's/%BODY_SIZE_LIMIT%/0/' .ddev/apache/apache-site.conf
sed -i 's/%TIMEOUT%/0/' .ddev/apache/apache-site.conf
sed -i 's/%FASTCGI_PASS%/unix:\/var\/run\/php-fpm.sock/' .ddev/apache/apache-site.conf
```

If you want to use HTTPS, you must add the following rule to avoid mixed content (HTTPS pages linking to HTTP resources): `SetEnvIf X-Forwarded-Proto "https" HTTPS=on`

You can, for example, do it with `sed`:

```bash
sed -i 's/DirectoryIndex index.php/DirectoryIndex index.php\n\n    SetEnvIf X-Forwarded-Proto "https" HTTPS=on/' .ddev/apache/apache-site.conf
```

Finally, restart the project:

```bash
ddev restart
```

#### Scripted procedure

Generate the virtual host with [`vhost.sh`](https://github.com/ibexa/docker/blob/4.6/scripts/vhost.sh):

```bash
curl -O https://raw.githubusercontent.com/ibexa/docker/4.6/scripts/vhost.sh
bash vhost.sh --template-file=vendor/ibexa/post-install/resources/templates/apache2/vhost.template \
  --ip='*' \
  --host-name='my-ddev-project.ddev.site' \
  --host-alias='*.ddev.site' \
  --basedir='/var/www/html' \
  --sf-env=dev \
  > .ddev/apache/apache-site.conf
sed -i 's/php5-fpm.sock/php-fpm.sock/' .ddev/apache/apache-site.conf
sed -i 's/DirectoryIndex index.php/DirectoryIndex index.php\n    SetEnvIf X-Forwarded-Proto "https" HTTPS=on/' .ddev/apache/apache-site.conf
rm vhost.sh
```

Then, restart the project:

```bash
ddev restart
```

### Run an already existing project

To run an existing project, you need to:

1. Configure the DDEV project.
1. Start the DDEV project.
1. Add Composer authentication.
1. Install dependencies packages with Composer.
1. Populate the contents, which could mean:
    - getting a clean database with ddev `php bin/console ibexa:install` and adding some data with [Ibexa data migration](importing_data.md), or
    - injecting a dump with [`ddev import-db`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#import-db) and copying related binary files into `public/var`.

The following examples run an already [version-controlled project](install_ibexa_dxp.md#add-project-to-version-control) and have the right content structure (but no content):

```bash
# Clone the version-controlled project and enter its local directory
git clone <repository> my-ddev-project && cd my-ddev-project
# Exclude the whole `.ddev/` directory from version control (some DDEV config could have been committed and shared, see notice below)
.ddev/ >> .gitignore
# Configure the DDEV project then start it
ddev config --project-type=php --php-version 8.1 \
  --docroot=public \
  --web-environment-add DATABASE_URL=mysql://db:db@db:3306/db \
  --http-port=8080 --https-port=8443
ddev start
# Configure Composer authentication
ddev composer config --global http-basic.updates.ibexa.co <installation-key> <token-password>
# Install the dependencies packages
ddev composer install
# Populate the database with a clean install
ddev php bin/console ibexa:install
# Add some content types using a migration file (previously created on another installation) and update the GraphQL schema
ddev php bin/console ibexa:migrations:migrate --file=project_content_types.yaml
ddev php bin/console ibexa:graphql:generate-schema
# Open the project in the default browser which should display the default SiteAccess frontpage
ddev launch
```

Notice that the example adds the whole `.ddev/` directory to `.gitignore`, but you can also version parts of it.
Some DDEV configs can be shared among developers. For example, a common `.ddev/config.yaml` can be committed for everyone and [locally extended or overridden](https://ddev.readthedocs.io/en/latest/users/extend/customization-extendibility/#extending-configyaml-with-custom-configyaml-files).

Compared to running a clean install like described in [Installation steps](#installation), you can proceed as follows:

- In [1. Create a DDEV project directory](#1-create-a-ddev-project-directory), you can use an existing directory that contains an [[= product_name =]] project instead of creating an empty directory.
- In [5. Create [[= product_name =]] project](#5-create-project), use only `ddev composer install` instead of `ddev composer create`.
- Populate the database with [Ibexa data migration](importing_data.md) or [`ddev import-db`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#import-db).

### Hostnames and domains

If the local project needs to answer to real production domains (for example, to use the existing [hostname to SiteAccess](siteaccess_matching.md#maphost) or [hostname element to SiteAccess](../multisite/siteaccess/siteaccess_matching.md#hostelement) mappings), you can use [additional hostnames](https://ddev.readthedocs.io/en/latest/users/extend/additional-hostnames/).

!!! caution

    As this feature modifies domain resolution, the real website may be unreachable until the `hosts` file is manually cleaned.

### Cluster or [[= product_name_cloud =]]

You can use DDEV to locally simulate a production cluster.

- See [Clustering with DDEV](clustering_with_ddev.md) to add Elasticsearch, Solr, Redis, or Memcached to your DDEV installation.
- See [DDEV and Ibexa Cloud](ddev_and_ibexa_cloud.md) to locally run an [[= product_name =]] project by using DDEV.

## Stop or remove the project

If you need to stop the project to start it again later, use `ddev stop`.
Then, use `ddev start` to run the project in the same state.

If you want to fully remove the project:

- delete the DDEV elements without backup: `ddev delete --omit-snapshot && rm -rf ./ddev`
- remove the project folder: `cd .. && rm -r my-ddev-project`

If [additional hostnames](#hostnames-and-domains) have been used, you must clean the hosts file.

To learn more about removing all projects at once or DDEV itself, see [Uninstalling DDEV](https://ddev.readthedocs.io/en/latest/users/usage/uninstall/).
