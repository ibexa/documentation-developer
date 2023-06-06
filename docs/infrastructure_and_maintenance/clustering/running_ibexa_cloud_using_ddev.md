---
description: When you want to run locally an Ibexa Cloud project using DDEV.
---

# Running Ibexa Cloud using DDEV

Two ways are available to run locally a Ibexa Cloud project using DDEV:
- [Using the `ddev-platformsh` add-on](#running-ibexa-cloud-using-the-ddev-platformsh-add-on).
- [Like other existing project, without the add-on](#running-ibexa-cloud-as-an-existing-project)

## Running Ibexa Cloud using the `ddev-platformsh` add-on

TODO: https://docs.platform.sh/development/local/ddev.html

## Running Ibexa Cloud as an existing project

TODO: Find a better title

The following example adapt the [manual method to run an already existing project](../../getting_started/install_using_ddev.md#run-an-already-existing-project) to the Platform.sh case:

This example sequence

- download the Ibexa Cloud Platform.sh project from the default environment "production" (replace <project-ID> with the hash of your own project, see [`platform help get`](https://docs.platform.sh/administration/cli.html#3-use) for options like selecting another environment) into a new directory
- config a new DDEV project
- ignore `.ddev/` directory from Git
- start the DDEV project
- set Composer authentication
- [Get the database content from Platform.sh](https://docs.platform.sh/add-services/mysql.html#exporting-data)
- [Import this database content into DDEV project's database](https://ddev.readthedocs.io/en/latest/users/usage/database-management/#database-imports)
- [Download the Platform.sh public/var locally](https://docs.platform.sh/development/file-transfer.html#transfer-a-file-from-a-mount) to have the content binary files
- Open the DDEV project into a browser

```bash
platform project:get <project-ID> my-ddev-project && cd my-ddev-project
ddev config --project-type=php --php-version 8.1 \
  --docroot=public \
  --web-environment-add DATABASE_URL=mysql://db:db@db:3306/db \
  --http-port=8080 --https-port=8443
.ddev/ >> .gitignore
ddev start
ddev composer config --global http-basic.updates.ibexa.co <installation-key> <token-password>
platform db:dump --gzip --file=production.sql.gz
ddev import-db --src=production.sql.gz
platform mount:download --mount public/var --target public/var
ddev composer install
ddev lauch
```
