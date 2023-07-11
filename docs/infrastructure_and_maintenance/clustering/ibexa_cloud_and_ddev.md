---
description: Use DDEV to run an Ibexa Cloud project locally.
---

# Ibexa Cloud and DDEV

Two ways are available to run an Ibexa Cloud project locally with DDEV:

- [by using the `ddev-platformsh` add-on](#simulate-ibexa-cloud-with-the-ddev-platformsh-add-on)
- [like other existing project, without the add-on](#simulate-ibexa-cloud-without-the-platformsh-add-on).

## Simulate Ibexa Cloud with the `ddev-platformsh` add-on

To configure the [`ddev/ddev-platformsh` add-on](https://github.com/ddev/ddev-platformsh), you'll need a [Platform.sh API Token](https://docs.platform.sh/administration/cli/api-tokens.html).

`COMPOSER_AUTH` from Platform.sh can't be used, because JSON commas are incorrectly interpreted by `--web-environment-add`, which sees them as multiple variables' separators.
But the variable must exist for Platform.sh hooks' scripts to work. An `auth.json` file can be used, see [Using an auth.json](install_using_ddev.md#using-an-authjson) for more.

This example sequence:

- downloads the Ibexa Cloud Platform.sh project from the default environment "production" into a new directory (replace `<project-ID>` with the hash of your own project, see [`platform help get`](https://docs.platform.sh/administration/cli.html#3-use) for options like selecting another environment),
- configs a new DDEV project,
- ignores `.ddev/` directory from Git,
- sets Composer authentication using an already existing `auth.json` file,
- creates a `public/var` directory if it doesn't exist (to allow the creation of `public/var/.platform.installed` by Platform.sh hook script),
- installs the `ddev/ddev-platformsh` add-on which prompts for the Platform.sh API token, project ID and environment name,
- comments the NodeJS and NVM installations from the hooks copied in `.ddev/config.platformsh.yaml`,
- changes `maxmemory-policy` from default `allkeys-lfu` to a [value accepted by the `RedisTagAwareAdapter`](https://github.com/symfony/cache/blob/5.4/Adapter/RedisTagAwareAdapter.php#L95),
- starts the project
- gets the content from Platform.sh, both database and binary files using `ddev pull platform` feature from the add-on,
- restarts the project,
- displays information about the project services,
- opens the project into a browser.

```bash
platform project:get <project-ID> my-ddev-project && cd my-ddev-project
ddev config --project-type=php --php-version 8.1 \
  --docroot=public --create-docroot \
  --http-port=8080 --https-port=8443 \
  --web-environment-add DATABASE_URL=mysql://db:db@db:3306/db \
  --web-environment-add CACHE_POOL=cache.redis \
  --web-environment-add CACHE_DSN=redis \
  --web-environment-add COMPOSER_AUTH=''
echo '.ddev/' >> .gitignore
cp <path-to-an>/auth.json .ddev/homeadditions/
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

## Simulate Ibexa Cloud without the Platform.sh add-on

The following example adapts the [manual method to run an already existing project](install_using_ddev.md#run-an-already-existing-project) to the Platform.sh case:

This example sequence:

- downloads the Ibexa Cloud Platform.sh project from the default environment "production" into a new directory (replace `<project-ID>` with the hash of your own project, see [`platform help get`](https://docs.platform.sh/administration/cli.html#3-use) for options like selecting another environment),
- configs a new DDEV project,
- ignores `.ddev/` directory from Git,
- starts the DDEV project,
- sets Composer authentication,
- [gets the database content from Platform.sh](https://docs.platform.sh/add-services/mysql.html#exporting-data),
- [imports this database content into DDEV project's database](https://ddev.readthedocs.io/en/latest/users/usage/database-management/#database-imports),
- [downloads the Platform.sh public/var locally](https://docs.platform.sh/development/file-transfer.html#transfer-a-file-from-a-mount) to have the content binary files,
- and opens the DDEV project into a browser.

```bash
platform project:get <project-ID> my-ddev-project && cd my-ddev-project
ddev config --project-type=php --php-version 8.1 \
  --docroot=public \
  --web-environment-add DATABASE_URL=mysql://db:db@db:3306/db \
  --http-port=8080 --https-port=8443
echo '.ddev/' >> .gitignore
ddev start
ddev composer config --global http-basic.updates.ibexa.co <installation-key> <token-password>
platform db:dump --gzip --file=production.sql.gz
ddev import-db --src=production.sql.gz && rm production.sql.gz
platform mount:download --mount public/var --target public/var
ddev composer install
ddev launch
```

From there, services can be added to get closer to Ibexa Cloud Platform.sh architecture.
`.platform/services.yaml` indicates the services used.
Refer to [clustering with DDEV](clustering_using_ddev.md) for those additions.
