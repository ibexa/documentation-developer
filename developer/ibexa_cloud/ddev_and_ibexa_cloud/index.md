# DDEV and Ibexa Cloud

Use DDEV to run an Ibexa Cloud project locally.

Two ways are available to run an Ibexa Cloud project locally with DDEV:

- [by using the `ddev-upsun` and `ddev-ibexa-cloud` add-ons](#with-ibexa-cloud-add-ons)
- [like other existing project, without these add-ons](#without-ibexa-cloud-add-ons).

> **Note: Note**
>
> The following examples use [Ibexa Cloud CLI (`ibexa_cloud`)](https://cli.ibexa.cloud/). For more information and examples, see [Ibexa Cloud CLI](../ibexa_cloud_cli/index.md).

## With Ibexa Cloud add-ons

To configure [`ddev/ddev-upsun` add-on](https://github.com/ddev/ddev-upsun) and [`ddev/ddev-ibexa-cloud` add-on](https://github.com/ddev/ddev-ibexa-cloud), you need a [Upsun API Token](https://fixed.docs.upsun.com/administration/cli/api-tokens.html).

The `ddev/ddev-upsun` add-on configures the document root, the PHP version, the database, and the cache pool according to the Ibexa Cloud configuration. About the search engine, the add-on can configure Elasticsearch but can't configure Solr. If you use Solr on Ibexa Cloud and want to add it to your DDEV stack, see [Clustering with DDEV and `ibexa/ddev-solr` add-on](../../infrastructure_and_maintenance/clustering/clustering_with_ddev/index.md#solr).

The `ddev/ddev-ibexa-cloud` add-on integrates the `ibexa_cloud` command inside the container, and eases the pull of cloud contents into the local installation.

`env:COMPOSER_AUTH` from Upsun can't be used, because JSON commas are incorrectly interpreted by `--web-environment-add`, which sees them as multiple variable separators. But the variable must exist for Upsun `hooks` scripts to work. To use an `auth.json` file for this purpose, see [Using `auth.json`](../../getting_started/install_with_ddev/index.md#using-authjson).

The following sequence of commands:

1. Downloads the Ibexa Cloud project from the default environment "production" into a new directory (for example `my-ddev-project`), using the [`ibexa_cloud` command](https://cli.ibexa.cloud/). (Replace `<project-ID>` with the hash of your own project. See [`ibexa_cloud help get`](https://fixed.docs.upsun.com/administration/cli.html#3-use) for options like selecting another environment).
2. Configures a new DDEV project.
3. Configures the `ddev/ddev-ibexa-cloud` add-on with `<project-ID>`, environment name (for example, `production`), and application name (for example, `app` from `name: app` line in `.platform.app.yaml` file).
4. Configures `ibexa_cloud` command token. See [Create an API token](https://fixed.docs.upsun.com/administration/cli/api-tokens.html#2-create-an-api-token) for more information.
5. Ignores `.ddev/` directory from Git. (Some DDEV config could be committed like in [this documentation](https://docs.ddev.com/en/stable/users/extend/customization-extendibility/#extending-configyaml-with-custom-configyaml-files).)
6. Sets Composer authentication by using an already existing `auth.json` file.
7. Installs the `ddev/ddev-upsun` add-on which prompts for the Upsun API token, project ID and environment name.
8. Changes `maxmemory-policy` from default `allkeys-lfu` to a [value accepted by the `RedisTagAwareAdapter`](https://github.com/symfony/cache/blob/5.4/Adapter/RedisTagAwareAdapter.php#L95). (Check `.ddev/config.upsun.yaml` and adapt if needed. For example, you may have to comment out New Relic.)
9. Installs the `ddev/ddev-ibexa-cloud` add-on.
10. Starts the project.
11. Gets the content from Ibexa Cloud, both database and binary files by using `ddev pull ibexa-cloud` feature from the add-on.
12. Displays information about the project services.
13. Opens the project in a browser.

```bash
ibexa_cloud project:get <project-ID> my-ddev-project && cd my-ddev-project
ddev config --project-type=php --php-version 8.3 --web-environment-add COMPOSER_AUTH='',DATABASE_URL=mysql://db:db@db:3306/db
ddev config --web-environment-add IBEXA_PROJECT=<project-ID>,IBEXA_ENVIRONMENT=production,IBEXA_APP=app
ddev config --web-environment-add IBEXA_CLI_TOKEN=<api-token>
echo '.ddev/' >> .gitignore
mkdir -p .ddev/homeadditions/.composer && cp <path-to-an>/auth.json .ddev/homeadditions/.composer
ddev add-on get ddev/ddev-upsun
sed -i 's/maxmemory-policy allkeys-lfu/maxmemory-policy volatile-lfu/' .ddev/redis/redis.conf
ddev add-on get ddev/ddev-ibexa-cloud
ddev start
ddev pull ibexa-cloud -y
ddev describe
ddev launch
```

> **Note: Note**
>
> The Upsun API token is set at user profile level, therefore it's stored globally under current user root as `PLATFORMSH_CLI_TOKEN` in `~/.ddev/global_config.yaml`.

## Without Ibexa Cloud add-ons

The following example adapts the [manual method to run an already existing project](../../getting_started/install_with_ddev/index.md#run-an-already-existing-project) to the Upsun case:

The following sequence of commands:

1. Downloads the Ibexa Cloud Upsun project from the default environment "production" into a new directory, using the [Ibexa Cloud CLI](https://cli.ibexa.cloud/). (Replace `<project-ID>` with the hash of your own project. See [`ibexa_cloud help get`](https://fixed.docs.upsun.com/administration/cli.html#3-use) for options like selecting another environment).
2. Configures a new DDEV project.
3. Ignores `.ddev/` directory from Git. (Some DDEV config could be committed like in [this documentation](https://docs.ddev.com/en/stable/users/extend/customization-extendibility/#extending-configyaml-with-custom-configyaml-files).)
4. Starts the DDEV project.
5. Sets Composer authentication.
6. [Gets the database content from Upsun](https://fixed.docs.upsun.com/add-services/mysql.html#exporting-data).
7. [Imports this database content into DDEV project's database](https://docs.ddev.com/en/stable/users/usage/database-management/#database-imports).
8. [Downloads the Upsun public/var locally](https://fixed.docs.upsun.com/development/file-transfer.html#transfer-a-file-from-a-mount) to have the content binary files.
9. Install the dependencies and run post-install scripts.
10. Displays information about the project services.
11. Opens the DDEV project in a browser.

```bash
ibexa_cloud project:get <project-ID> my-ddev-project && cd my-ddev-project
ddev config --project-type=php --php-version 8.3 --docroot=public --web-environment-add DATABASE_URL=mysql://db:db@db:3306/db
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

From there, services can be added to get closer to Ibexa Cloud architecture. `.platform/services.yaml` indicates the services used. For more information, see [Clustering with DDEV](../../infrastructure_and_maintenance/clustering/clustering_with_ddev/index.md).
