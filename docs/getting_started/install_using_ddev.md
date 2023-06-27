---
description: Install Ibexa DXP with Docker and DDEV to use it for development.
---

# Install using DDEV

This guide provides a step-by-step walkthrough of installing [[= product_name =]] using [DDEV](https://ddev.com/).
DDEV is an open-source tool that simplifies the process of setting up local PHP development environments.

## Requirements

Before you start the installation, ensure you have the following software installed:

- [Docker](https://docs.docker.com/get-docker/)
- [DDEV](https://ddev.readthedocs.io/en/latest/users/install/ddev-installation/)

## Installation

### 1. Create a DDEV project directory

Start by creating a directory for your DDEV project by using the following command to create a new directory:

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

#### Switch to Apache (optional)

By default, DDEV uses Nginx.

To use Apache instead, run the following command:

```bash
ddev config --webserver-type=apache-fpm
```

#### Use another database type (optional)

By default, DDEV uses MariaDB.

To use PostgreSQL instead, run the following command:

```bash
ddev config --database=postgres:15
```

To use MySQL instead, run the following command:

```bash
ddev config --database=mysql:8.0
```

Other version of MariaDB, Mysql or PostgreSQL can be used. See [DDEV database types documentation](https://ddev.readthedocs.io/en/latest/users/extend/database-types/) for available version ranges.

#### Configure database connection

Now, configure the database connection for your Ibexa DXP project. Depending on your database of choice (MySQL or PostgreSQL), use the appropriate command below.

!!! note

    Those commands will set a `DATABASE_URL` environment variable inside the container which overrides [the variable from `.env`](install_ibexa_dxp.md#change-installation-parameters).

=== "MariaDB / MySQL"

    ```bash
    ddev config --web-environment-add DATABASE_URL=mysql://db:db@db:3306/db
    ```

=== "PostgreSQL"

    ```bash
    ddev config --web-environment-add DATABASE_URL=postgresql://db:db@db:5432/db
    ```

#### Enable Mutagen (optional)

If you're using macOS or Windows, you might wish to enable [Mutagen](https://ddev.readthedocs.io/en/latest/users/install/performance/#mutagen) for performance. You can do this by running the following command:

```bash
ddev config --mutagen-enabled
```

See [DDEV performance documentation](https://ddev.readthedocs.io/en/latest/users/install/performance/) for more.

#### Change port mapping (optional)

By default, DDEV uses ports 80 and 443.
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

    If you forgot some part of configuration, you can set it by using `ddev config` later, but afterwards you have to restart DDEV using `ddev restart`.

### 4. Composer authentication

Next, you need to [set up authentication tokens](install_ibexa_dxp.md#set-up-authentication-tokens) by modifying the Composer configuration.
You must run the following command **after** executing  `ddev start`, because the command will run inside the container.

```bash
ddev composer config --global http-basic.updates.ibexa.co <installation-key> <token-password>
```

Replace `<installation-key>` and `<token-password>` with your actual installation key and token password, respectively.

If you want to reuse an existing `auth.json`file, see [Using an auth.json](#using-an-authjson).

### 5. Create Ibexa DXP project

Once DDEV is running, use Composer to create a new Ibexa DXP project. Remember to replace `<edition>` and `<version>` with your desired edition and versions respectively.

```bash
ddev composer create ibexa/<edition>-skeleton:<version>
```

### 6. Install the DXP and its database

Once you've made this change, you can proceed to install Ibexa DXP.

```bash
ddev php bin/console ibexa:install ibexa-<edition>
ddev php bin/console ibexa:graphql:generate-schema
```

### 7. Open browser

Once the above steps are completed, open your Ibexa DXP webpage by running the `ddev launch` command.

!!! tip

    You can also see the project URL in the `ddev start` output.

### 8. Start using Ibexa DXP

You can now start using Ibexa DXP and implement your own website on the platform.

You can edit the configuration and code in the DDEV project directory.
You can use commands listed in the documentation by prefixing them with `ddev exec` or by opening a terminal inside the container using `ddev ssh`.
For example, if a guideline invites you to run `php bin/console cache:clear`, you can do it in the DDEV container in one of the following ways:

- run `ddev php bin/console cache:clear`
- enter `ddev ssh` and run `php bin/console cache:clear` after the new prompt

## Other options for configuration

DDEV offers several ways to achieve a same thing, offering different levels of flexibility or adaptability to your development environment.

!!! tip

    Learn more about the [DDEV commands](https://ddev.readthedocs.io/en/latest/users/usage/commands/):
    
    - by running [`ddev list`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#list) to list them all,
    - by running [`ddev help <command>`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#help) to get usage details about a given command.
    
    Learn more about DDEV configuration at [`ddev config` command documentation](https://ddev.readthedocs.io/en/latest/users/usage/commands/#config) and [advanced configuration files documentation](https://ddev.readthedocs.io/en/latest/users/configuration/config/).


### Using `auth.json`

An `auth.json` file can be used for one project, or globally for all projects, with the [DDEV `homeaddition` feature](https://ddev.readthedocs.io/en/latest/users/extend/in-container-configuration/).

For example, you can copy an `auth.json` file to a DDEV project:
`cp <path-to-an>/auth.json .ddev/homeadditions/.composer`

Alternatively, the Composer global `auth.json` can be the DDEV global `auth.json` with the help of symbolic link:
`mkdir -p ~/.ddev/homeadditions/.composer && ln -s ~/.composer/auth.json ~/.ddev/homeadditions/.composer/auth.json`

If the DDEV project has already been started, you need to run `ddev restart`.

To use an `auth.json` file replaces the step [4. Composer authentication](#4-composer-authentication).

### Using Dotenv

Instead of using environment variables inside the container, a [`.env.local`](https://symfony.com/doc/5.4/configuration.html#overriding-environment-values-via-env-local) file can be added to the project.

The following shows `.env.local` configuration on the example of the database:

- Skip step [2. Configure DDEV / Configure database connection](#configure-database-connection).
- Modify step [5. Create Ibexa DXP project](#5-create-ibexa-dxp-project) to insert the database setting (Commerce and MariaDB are used in this example):
  ```bash
  ddev composer create ibexa/commerce-skeleton --no-install;
  echo "DATABASE_URL=mysql://db:db@db:3306/db" >> .env.local;
  ddev composer install;
  ```

!!! note "Precedence"

    For the same variable, its server level environment value overrides its application level dotenv value.
    To switch a variable from `ddev config --web-environment-add` command to `.env.local` file, you have

    - to remove it from under the `web_environment:` key in `.ddev/config.yaml` file then restart the project,
    - or rebuild the project from scratch.

### Webserver configuration

Set up the webserver as recommended for production requires the following steps.

<!--
Those configurations are required if you plan to also simulate the [binary files sharing needed by clusters](../infrastructure_and_maintenance/clustering/clustering_using_ddev.md#share-binary-files).
-->

#### Nginx Server Blocks

Copy the Server Blocks template as a new Nginx configuration:

```bash
cp vendor/ibexa/post-install/resources/templates/nginx/vhost.template .ddev/nginx_full/ibexa.conf
cp -r vendor/ibexa/post-install/resources/templates/nginx/ibexa_params.d .ddev/nginx_full/
```

Then, replace the placeholders with the appropriate values in `.ddev/nginx_full/ibexa.conf`:

| Placeholder             | Value                          |
|-------------------------|--------------------------------|
| `%PORT%`                | `80`                           |
| `%HOST_LIST%`           | `*.ddev.site`                  |
| `%BASEDIR%`             | `/var/www/html`                |
| `%BODY_SIZE_LIMIT_M%`   | `0`                            |
| `%TIMEOUT_S%`           | `0`                            |
| `%FASTCGI_PASS%`        | `unix:/var/run/php-fpm.sock`   |
| `%BINARY_DATA_HANDLER%` | empty string <!-- or `dfs` --> |

Because of path resolution inside DDEV's Nginx, you must replace one more thing: `ibexa_params.d` with `sites-enabled/ibexa_params.d`.

You can, for example, do it with `sed`:

```bash
sed -i 's/%PORT%/80/' .ddev/nginx_full/ibexa.conf;
sed -i 's/%HOST_LIST%/*.ddev.site/' .ddev/nginx_full/ibexa.conf;
sed -i 's/%BASEDIR%/\/var\/www\/html/' .ddev/nginx_full/ibexa.conf;
sed -i 's/%BODY_SIZE_LIMIT_M%/0/' .ddev/nginx_full/ibexa.conf;
sed -i 's/%TIMEOUT_S%/60s/' .ddev/nginx_full/ibexa.conf;
sed -i 's/%FASTCGI_PASS%/unix:\/var\/run\/php-fpm.sock/' .ddev/nginx_full/ibexa.conf;
sed -i 's/%BINARY_DATA_HANDLER%//' .ddev/nginx_full/ibexa.conf;
sed -i 's/ibexa_params.d/sites-enabled\/ibexa_params.d/' .ddev/nginx_full/ibexa.conf;
```

<!--
!!! note

    To replace `%BINARY_DATA_HANDLER%` with `dfs` is only needed if you plan to [share binary files](../infrastructure_and_maintenance/clustering/clustering_using_ddev.md) like a multi-frontend cluster does.
-->

#### Apache Virtual Host

To set the Apache Virtual Host, `.ddev/apache/apache-site.conf` will be override with Ibexa DXP's config. You can do it manually or using a script.

##### Manual

Copy the Virtual Host template as the new Apache configuration:

```bash
cp vendor/ibexa/post-install/resources/templates/apache2/vhost.template .ddev/apache/apache-site.conf
```

Then, replace the placeholders with the appropriate values in this `.ddev/apache/apache-site.conf`:

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

Finally, restart the project:

```bash
ddev restart
```

##### Scripted

Generate the Virtual Host using https://github.com/ibexa/docker/blob/main/scripts/vhost.sh:

```bash
curl -O https://raw.githubusercontent.com/ibexa/docker/main/scripts/vhost.sh
bash vhost.sh --template-file=vendor/ibexa/post-install/resources/templates/apache2/vhost.template \
  --ip='*' \
  --host-name='my-ddev-project.ddev.site' \
  --host-alias='*.ddev.site' \
  --basedir='/var/www/html' \
  --sf-env=dev \
  > .ddev/apache/apache-site.conf
rm vhost.sh
```

Then, restart the project:

```bash
ddev restart
```

### Run an already existing project

To run an existing project, you'll need to

1. configure the DDEV project
1. start the DDEV project
1. add Composer authentication
1. install dependencies packages using Composer
1. populate the contents, which could be
    - getting a clean database using ddev `php bin/console ibexa:install ibexa-<edition>` then adding some data using [Ibexa data migration](../content_management/data_migration/importing_data.md)
    - injecting a dump using [`ddev import-db`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#import-db) and copying related binary files into `public/var`

The following example will run an already [version-controlled project](install_ibexa_dxp.md#add-project-to-version-control) and have the right content structure (but no content):

```bash
# Clone the version-controlled project and enter its local directory
git clone <repository> my-ddev-project && cd my-ddev-project
# Exclude the whole `.ddev/` directory from version control
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
ddev php bin/console ibexa:install ibexa-<edition>
# Add some content types using a migration file (previously created on another installation) and update the GraphQL schema
ddev php bin/console ibexa:migrations:migrate --file=project_content_types.yaml
ddev php bin/console ibexa:graphql:generate-schema
# Open the project in the default brother which should display the default SiteAccess frontpage
ddev launch
```

Notice that the example adds the whole `.ddev/` directory to `.gitignore`, but you can also version parts of it.
Some DDEV configs can be shared among developers. For example, a common `.ddev/config.yaml` can be committed for everyone and [locally extended or overridden](https://ddev.readthedocs.io/en/latest/users/extend/customization-extendibility/#extending-configyaml-with-custom-configyaml-files).

Compared to running a clean install like described in [Installation steps](#installation-steps):

- Instead of creating an empty directory like in [1. Create a DDEV project directory](#1-create-a-ddev-project-directory), you can use an existing directory containing an Ibexa DXP project.
- In [2. Configure DDEV / Configure PHP version and document root](#configure-php-version-and-document-root), don't create the Document root, remove the `--create-docroot` option.
- Instead of `ddev composer create`, in [5. Create Ibexa DXP project](#5-create-ibexa-dxp-project) use only `ddev composer install`.
- [Ibexa data migration](../content_management/data_migration/importing_data.md) or [`ddev import-db`](https://ddev.readthedocs.io/en/latest/users/usage/commands/#import-db) can be used to populate the database.

### Hostnames and domains

If the local project needs to answer to real production domains (for example, to use the existing [hostname to SiteAccess](../multisite/siteaccess/siteaccess_matching.md#maphost) or [hostname element to SiteAccess](../multisite/siteaccess/siteaccess_matching.md#hostelement) mappings), you can use [additional hostnames](https://ddev.readthedocs.io/en/latest/users/extend/additional-hostnames/).

!!! warning

    As this feature will modify domain resolution, the real website may be unreachable until the `hosts` file is manually cleaned.

### Cluster or Ibexa Cloud

DDEV can be useful to locally simulate a production cluster.

- See [Clustering using DDEV](clustering_using_ddev.md) to add Elasticsearch, Solr, Redis or Memcached to your DDEV installation.
- See [Ibexa Cloud and DDEV](ibexa_cloud_and_ddev.md) to locally run an Ibexa DXP project using DDEV.

## Stop or remove the project

If you need to stop the project to start it again latter, use `ddev stop`. Afterwards, a `ddev start` will run the project in the same state.

If you want to fully remove the project:

- delete the DDEV elements without backup: `ddev delete --omit-snapshot && rm -rf ./ddev`;
- remove the project folder: `cd .. && rm -r my-ddev-project`

If [additional hostnames](#hostnames-and-domains) have been used, you must clean the hosts file.

To learn more, to remove all projects at once or to remove DDEV itself, see [Uninstalling DDEV](https://ddev.readthedocs.io/en/latest/users/usage/uninstall/).
