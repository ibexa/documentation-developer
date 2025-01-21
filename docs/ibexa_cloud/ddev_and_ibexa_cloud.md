---
description: Use DDEV to run an Ibexa Cloud project locally.
---

# DDEV and Ibexa Cloud

Two ways are available to run an [[= product_name_cloud =]] project locally with DDEV:

- [by using the Platform.sh's `ddev-ibexa-cloud` add-on](#with-the-ddev-ibexa-cloud-add-on)
- [like other existing project, without this add-on](#without-the-ibexa-cloud-add-on).

!!! note

    The following examples use [[[= product_name_cloud =]] CLI (`ibexa_cloud`)](https://cli.ibexa.co/).

## With the `ddev-ibexa-cloud` add-on

To configure the [`ddev/ddev-ibexa-cloud` add-on](https://github.com/ddev/ddev-ibexa-cloud), you need a [Platform.sh API Token](https://docs.platform.sh/administration/cli/api-tokens.html).

The `ddev/ddev-ibexa-cloud` add-on configures the document root, the PHP version, the database, and the cache pool according to the [[= product_name_cloud =]] configuration.
About the search engine, the add-on can configure Elasticsearch but can't configure Solr.
If you use Solr on [[= product_name_cloud =]] and want to add it to your DDEV stack, see [Clustering with DDEV and `ibexa/ddev-solr` add-on](clustering_with_ddev.md#solr).

`COMPOSER_AUTH` from Platform.sh can't be used, because JSON commas are incorrectly interpreted by `--web-environment-add`, which sees them as multiple variable separators.
But the variable must exist for Platform.sh `hooks` scripts to work.
To use an `auth.json` file for this purpose, see [Using `auth.json`](install_with_ddev.md#using-authjson).

You must remove Node.js and NVM installations as they're already included in DDEV.

The following sequence of commands:

1. Downloads the [[= product_name_cloud =]] Ibexa Cloud project from the default environment "production" into a new directory,
using the [`ibexa_cloud` command](https://cli.ibexa.co/).
(Replace `<project-ID>` with the hash of your own project.
See [`ibexa_cloud help get`](https://docs.platform.sh/administration/cli.html#3-use) for options like selecting another environment).
1. Configures a new DDEV project.
1. Configures the `ddev/ddev-ibexa-cloud` add-on.
1. Configures `ibexa_cloud` command token. See [Create an API token](https://docs.platform.sh/administration/cli/api-tokens.html#2-create-an-api-token) for more information.
1. Ignores `.ddev/` directory from Git.
(Some DDEV config could be committed like in [this documentation](https://ddev.readthedocs.io/en/latest/users/extend/customization-extendibility/#extending-configyaml-with-custom-configyaml-files).)
1. Sets Composer authentication by using an already existing `auth.json` file.
1. Installs the `ddev/ddev-ibexa-cloud` add-on.
(Check `.ddev/config.ibexa-cloud.yaml` and adapt if needed. For example, you may have to comment out New Relic.)
1. Starts the project.
1. Install dependencies.
1. Gets the content from Ibexa Cloud, both database and binary files by using `ddev pull ibexa-cloud` feature from the add-on.
1. Displays information about the project services.
1. Opens the project in a browser.

```bash
ibexa_cloud project:get <project-ID> my-ddev-project && cd my-ddev-project
ddev config --project-type=php --php-version 8.1 --web-environment-add COMPOSER_AUTH='',DATABASE_URL=mysql://db:db@db:3306/db
ddev config --web-environment-add IBEXA_PROJECT=$PROJECT,IBEXA_ENVIRONMENT=$ENVIRONMENT,IBEXA_APP=app
ddev config --web-environment-add IBEXA_CLI_TOKEN=$IBEXA_CLI_TOKEN
echo '.ddev/' >> .gitignore
mkdir -p .ddev/homeadditions/.composer && cp <path-to-an>/auth.json .ddev/homeadditions/.composer
ddev add-on get ddev/ddev-ibexa-cloud             
ddev start
ddev composer install
ddev pull ibexa-cloud -y
ddev describe
ddev launch
```

!!! note

    The Platform.sh API token is set at user profile level, therefore it's stored globally under current user root as `PLATFORMSH_CLI_TOKEN` in `~/.ddev/global_config.yaml`.

## Without the Ibexa Cloud add-on

The following example adapts the [manual method to run an already existing project](install_with_ddev.md#run-an-already-existing-project) to the Platform.sh case:

The following sequence of commands:

1. Downloads the [[= product_name_cloud =]] Platform.sh project from the default environment "production" into a new directory, based on the [Platform.sh CLI alias `ibexa_cloud` defined in introduction](#ibexa-cloud-and-ddev).
(Replace `<project-ID>` with the hash of your own project. See [`ibexa_cloud help get`](https://docs.platform.sh/administration/cli.html#3-use) for options like selecting another environment).
1. Configures a new DDEV project.
1. Ignores `.ddev/` directory from Git.
(Some DDEV config could be committed like in [this documentation](https://ddev.readthedocs.io/en/latest/users/extend/customization-extendibility/#extending-configyaml-with-custom-configyaml-files).)
1. Starts the DDEV project.
1. Sets Composer authentication.
1. [Gets the database content from Platform.sh](https://docs.platform.sh/add-services/mysql.html#exporting-data).
1. [Imports this database content into DDEV project's database](https://ddev.readthedocs.io/en/latest/users/usage/database-management/#database-imports).
1. [Downloads the Platform.sh public/var locally](https://docs.platform.sh/development/file-transfer.html#transfer-a-file-from-a-mount) to have the content binary files.
1. Install the dependencies and run post-install scripts.
1. Displays information about the project services.
1. Opens the DDEV project in a browser.

```bash
ibexa_cloud project:get <project-ID> my-ddev-project && cd my-ddev-project
ddev config --project-type=php --php-version 8.1 --docroot=public --web-environment-add DATABASE_URL=mysql://db:db@db:3306/db
echo '.ddev/' >> .gitignore
ddev start
ddev composer config --global http-basic.updates.ibexa.co <installation-key> <token-password>
ibexa_cloud db:dump --gzip --file=production.sql.gz
ddev import-db --file=production.sql.gz && rm production.sql.gz
ibexa_cloud mount:download --mount public/var --target public/var
ddev composer install
ddev describe
ddev launch
```

From there, services can be added to get closer to [[= product_name_cloud =]] Platform.sh architecture.
`.platform/services.yaml` indicates the services used.
For more information, see [Clustering with DDEV](clustering_with_ddev.md).
