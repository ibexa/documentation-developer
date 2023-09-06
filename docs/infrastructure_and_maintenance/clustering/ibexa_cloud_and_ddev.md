---
description: Use DDEV to run an Ibexa Cloud project locally.
---

# Ibexa Cloud and DDEV

Two ways are available to run an Ibexa Cloud project locally with DDEV:

- [by using the Platform.sh's `ddev-platformsh` add-on](#with-the-ddev-platformsh-add-on)
- [like other existing project, without this add-on](#without-the-platformsh-add-on).

!!! note

    The following examples will use [Platform.sh CLI](https://docs.platform.sh/administration/cli.html) set up for Ibexa Cloud
    thanks to the following dedicated alias `ibexa_cloud`:
    ```bash
    alias ibexa_cloud="PLATFORMSH_CLI_SESSION_ID=ibexa_cloud \
        PLATFORMSH_CLI_API_URL=https://api.cloud.ibexa.co \
        platform"
    ```

## With the `ddev-platformsh` add-on

To configure the [`ddev/ddev-platformsh` add-on](https://github.com/ddev/ddev-platformsh), you need a [Platform.sh API Token](https://docs.platform.sh/administration/cli/api-tokens.html).

The `ddev/ddev-platformsh` add-on configures the document root, the PHP version, the database and the cache pool according to the Ibexa Cloud configuration. About the search engine, the add-on can configure Elasticsearch but can't configure Solr. If you use Solr on Ibexa Cloud and want to add it to your DDEV stack, see [clustering with DDEV and `ibexa/ddev-solr` add-on](clustering_with_ddev.md#solr).

`COMPOSER_AUTH` from Platform.sh can't be used, because JSON commas are incorrectly interpreted by `--web-environment-add`, which sees them as multiple variable separators.
But the variable must exist for Platform.sh `hooks` scripts to work. To use an `auth.json` file for this purpose, see [Using `auth.json`](install_with_ddev.md#using-authjson).

You must remove Node.js and NVM installations as they're already included in DDEV.

The following sequence of commands:

1. Downloads the Ibexa Cloud Platform.sh project from the default environment "production" into a new directory using [Platform.sh CLI alias `ibexa_cloud` defined in introduction](#ibexa-cloud-and-ddev). (Replace `<project-ID>` with the hash of your own project. See [`ibexa_cloud help get`](https://docs.platform.sh/administration/cli.html#3-use) for options like selecting another environment).
1. Configures a new DDEV project.
1. Ignores `.ddev/` directory from Git. (Some DDEV config could be committed like in [this documentation](https://ddev.readthedocs.io/en/latest/users/extend/customization-extendibility/#extending-configyaml-with-custom-configyaml-files).)
1. Sets Composer authentication by using an already existing `auth.json` file.
1. Creates a `public/var` directory if it doesn't exist, to allow the creation of `public/var/.platform.installed` by Platform.sh hook script.
1. Installs the `ddev/ddev-platformsh` add-on which prompts for the Platform.sh API token, project ID and environment name.
1. Comments out the Node.js and NVM installations from the hooks copied in `.ddev/config.platformsh.yaml`. (In this file, you may have to discard other specific features like New Relic.)
1. Changes `maxmemory-policy` from default `allkeys-lfu` to a [value accepted by the `RedisTagAwareAdapter`](https://github.com/symfony/cache/blob/5.4/Adapter/RedisTagAwareAdapter.php#L95).
1. Starts the project.
1. Gets the content from Platform.sh, both database and binary files by using `ddev pull platform` feature from the add-on.
1. Restarts the project.
1. Displays information about the project services.
1. Opens the project in a browser.

```bash
ibexa_cloud project:get <project-ID> my-ddev-project && cd my-ddev-project
ddev config --project-type=php --web-environment-add COMPOSER_AUTH=''
echo '.ddev/' >> .gitignore
mkdir -p .ddev/homeadditions/.composer && cp <path-to-an>/auth.json .ddev/homeadditions/.composer
if [ ! -d public/var ]; then mkdir public/var; fi
ddev get ddev/ddev-platformsh
sed -i -E "s/( +)(.*nvm (install|use).*)/\1#\2/" .ddev/config.platformsh.yaml
sed -i 's/maxmemory-policy allkeys-lfu/maxmemory-policy volatile-lfu/' .ddev/redis/redis.conf
ddev start
ddev pull platform -y
ddev restart
ddev describe
ddev launch
```

!!! note

    The Platform.sh API token is set at user profile level, therefore it is stored globally under current user root as `PLATFORMSH_CLI_TOKEN` in `~/.ddev/global_config.yaml`.

## Without the Platform.sh add-on

The following example adapts the [manual method to run an already existing project](install_with_ddev.md#run-an-already-existing-project) to the Platform.sh case:

The following sequence of commands:

1. Downloads the Ibexa Cloud Platform.sh project from the default environment "production" into a new directory using [Platform.sh CLI alias `ibexa_cloud` defined in introduction](#ibexa-cloud-and-ddev). (Replace `<project-ID>` with the hash of your own project. See [`ibexa_cloud help get`](https://docs.platform.sh/administration/cli.html#3-use) for options like selecting another environment).
1. Configures a new DDEV project.
1. Ignores `.ddev/` directory from Git. (Some DDEV config could be committed like in [this documentation](https://ddev.readthedocs.io/en/latest/users/extend/customization-extendibility/#extending-configyaml-with-custom-configyaml-files).)
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
ddev import-db --src=production.sql.gz && rm production.sql.gz
ibexa_cloud mount:download --mount public/var --target public/var
ddev composer install
ddev describe
ddev launch
```

From there, services can be added to get closer to Ibexa Cloud Platform.sh architecture.
`.platform/services.yaml` indicates the services used.
Refer to [clustering with DDEV](clustering_with_ddev.md) for those additions.
