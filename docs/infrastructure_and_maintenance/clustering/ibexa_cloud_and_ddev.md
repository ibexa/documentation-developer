---
description: When you want to run locally an Ibexa Cloud project using DDEV.
---

# Ibexa Cloud and DDEV

Two ways are available to run locally an Ibexa Cloud project using DDEV:

- [Using the `ddev-platformsh` add-on](#running-ibexa-cloud-using-the-ddev-platformsh-add-on).
- [Like other existing project, without the add-on](#running-ibexa-cloud-as-an-existing-project)

## Simulate Ibexa Cloud using the `ddev-platformsh` add-on

To configure the [`ddev/ddev-platformsh` add-on](https://github.com/ddev/ddev-platformsh), you'll need a [Platform.sh API Token](https://docs.platform.sh/administration/cli/api-tokens.html).

During add-on installation, Solr must be disabled from Platform.sh services (`.platform.app.yaml`) due to compatibility issues. NodeJS and NVM installations must be disabled from Platform.sh hooks as well, it can be done afterward from hooks copy in `.ddev/config.platformsh.yaml`.

`COMPOSER_AUTH` from PLatform.sh can't be properly used as JSON commas will be badly interpreted by `--web-environment-add` which would see them as multiple variables' separators. But, it must exist for Platform.sh hooks' scripts to work. An auth.json file can be used, see [Using an auth.json](../../getting_started/install_using_ddev.md#using-an-authjson) for more.

This example sequence will

- download the Ibexa Cloud Platform.sh project from the default environment "production" into a new directory (replace `<project-ID>` with the hash of your own project, see [`platform help get`](https://docs.platform.sh/administration/cli.html#3-use) for options like selecting another environment),
- config a new DDEV project,
- ignore `.ddev/` directory from Git,
- set Composer authentication using an already existing `auth.json` file,
- disable Solr service by commenting its line in `.platform.app.yaml` using `sed`,
- create a `public/var` directory if it doesn't exist (to allow the creation of `public/var/.platform.installed` by Platform.sh hook script),
- install the `ddev/ddev-platformsh` add-on which will prompt for the Platform.sh API token, project ID and environment name,
- re-enable Solr service by reverting `.platform.app.yaml`,
- comment the NodeJS and NVM installations from the hooks copied in `.ddev/config.platformsh.yaml`,
- change `maxmemory-policy` from default `allkeys-lfu` to a [value accepted by the `RedisTagAwareAdapter`](https://github.com/symfony/cache/blob/5.4/Adapter/RedisTagAwareAdapter.php#L95),
- start the project
- get the content from Platform.sh, both database and binary files using `ddev pull platform` feature from the add-on,
- restart the project,
- display information about the project services,
- open the project into a browser.

```bash
platform project:get <project-ID> my-ddev-project && cd my-ddev-project
ddev config --project-type=php --php-version 8.1 \
  --docroot=public --create-docroot \
  --mutagen-enabled \
  --http-port=8080 --https-port=8443 \
  --web-environment-add PLATFORMSH_CLI_TOKEN=dQQcoTa3vct6grif50dKKAXt4U16nI9RI_3F12CCzfM \
  --web-environment-add DATABASE_URL=mysql://db:db@db:3306/db \
  --web-environment-add CACHE_POOL=cache.redis \
  --web-environment-add CACHE_DSN=redis \
  --web-environment-add COMPOSER_AUTH=''
echo '.ddev/' >> .gitignore
cp <path-to-an>/auth.json .ddev/homeadditions/
sed -i "s/solr: 'solrsearch:collection1'/#solr: 'solrsearch:collection1'/" .platform.app.yaml
if [ ! -d public/var ]; then mkdir public/var; fi
ddev get ddev/ddev-platformsh
git checkout -- .platform.app.yaml
sed -i -E "s/( +)(.*nvm (install|use).*)/\1#\2/" .ddev/config.platformsh.yaml
sed -i 's/maxmemory-policy allkeys-lfu/maxmemory-policy volatile-lfu/' .ddev/redis/redis.conf
ddev start
ddev pull platform -y
ddev restart
ddev describe
ddev launch
```

## Simulate Ibexa Cloud without the Platform.sh add-on

TODO: Find a better title

The following example adapt the [manual method to run an already existing project](../../getting_started/install_using_ddev.md#run-an-already-existing-project) to the Platform.sh case:

This example sequence will

- download the Ibexa Cloud Platform.sh project from the default environment "production" into a new directory (replace `<project-ID> with the hash of your own project, see [`platform help get`](https://docs.platform.sh/administration/cli.html#3-use) for options like selecting another environment),
- config a new DDEV project,
- ignore `.ddev/` directory from Git,
- start the DDEV project,
- set Composer authentication,
- [get the database content from Platform.sh](https://docs.platform.sh/add-services/mysql.html#exporting-data),
- [import this database content into DDEV project's database](https://ddev.readthedocs.io/en/latest/users/usage/database-management/#database-imports),
- [download the Platform.sh public/var locally](https://docs.platform.sh/development/file-transfer.html#transfer-a-file-from-a-mount) to have the content binary files,
- and open the DDEV project into a browser.

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
`.platform/services.yaml` indicate the services used.
Refer to [Clustering using DDEV](clustering_using_ddev.md) for those additions.
