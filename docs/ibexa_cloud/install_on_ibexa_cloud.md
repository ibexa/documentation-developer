---
description: Install and configure Ibexa DXP to run in cloud using Ibexa Cloud.
month_change: false
---

# Install on Ibexa Cloud

[[= product_name_cloud =]] enables you to host your application in the cloud by using the [Upsun](https://upsun.com/) service.

## 1. Prepare configuration files

If you didn't run the `composer ibexa:setup` command during installation, run it now:

``` bash
composer ibexa:setup --platformsh
```

This command adds to your project configuration files required for using [[= product_name_cloud =]].

You can adapt the configuration in the following places:

- `.platform.app.yaml` - main configuration
- `.platform/services.yml` - additional [services](https://fixed.docs.upsun.com/add-services.html) such as search engines or cache
- `.platform/routes.yml` - routes to define how [Upsun handles incoming web requests](https://fixed.docs.upsun.com/define-routes.html)

For details about available configuration settings, refer to [Upsun documentation](https://fixed.docs.upsun.com/create-apps.html).

### Disk space

The total disk space depends on your [[= product_name_cloud =]] subscription level.
You can assign disk space to the main app container under the `disk` key.
You can distribute the remaining space between other containers (for example, the database) or search engine in `.platform/services.yaml`, under the individual service definitions.

### Build and deploy process

Configuration under `hooks` defines the process of building and deploying your project.

!!! note

    During the build phase (defined in the `hooks.build` configuration), files in the project have read/write permissions (can be modified).

    During deployment (defined in the `hooks.deploy` configuration), all files in the project are read-only.

### Additional services

`.platform/services.yaml` contains preconfigured setting blocks that you can uncomment to enable services such as Solr or Elasticsearch, or persistent Redis session storage.

For information about available services, see [Upsun documentation](https://fixed.docs.upsun.com/add-services.html#available-services).

If you enable any of the services, you must uncomment the relevant relationship under the `relationship` key in `.platform.app.yaml` as well.

## 2. Create an account

Log in to https://console.ibexa.cloud or create an account if you don't have one yet.

Create a project and select its region.

!!! caution

    Don't use https://console.upsun.com/ (or former https://console.platform.sh/) which don't list [[= product_name_cloud =]] projects.
    Use https://console.ibexa.cloud to manage your [[= product_name_cloud =]] projects.

## 3. Prepare for hosting

After the project is created, the website walks you through preparing your project for hosting.
This includes adding an SSH key, and adding Upsun as a git remote.

Add your Composer authentication token to the project before pushing it to Upsun.
You can set this token as an environment variable.

When you do, make sure the **Visible during runtime** box in [[= product_name_cloud =]] configuration is unchecked.
This ensures that the token isn't exposed.

### Composer authentication using the web console

In **Settings** (top right gear icon) -> **Project Settings** -> **Variables** -> **+ Create variable**

![Setting token to be invisible during runtime](ibexa_cloud-composer_auth.png)

### Composer authentication using the CLI command

```bash
ibexa_cloud variable:create --level project --name env:COMPOSER_AUTH \
  --json true --visible-runtime false --sensitive true --visible-build true \
  --value '{"http-basic": {"updates.ibexa.co": {"username": "<installation-key>", "password": "<token-password>"}}}'
```

## 4. Push the project

When you're done with configuration, push your project to the Upsun remote:

``` bash
git push -u <upsun-remote> main
```

You can also use the [[[= product_name_cloud =]] CLI](https://cli.ibexa.cloud/) to push your code.

``` bash
ibexa_cloud push main
```

!!! note

    `main` is the Upsun name for the production branch.

!!! caution

    Don't use Upsun CLI (`upsun`), instead, use the [[[= product_name_cloud =]] CLI (`ibexa_cloud`)](https://cli.ibexa.cloud/).

    To install [[= product_name_cloud =]] CLI, follow https://cli.ibexa.cloud/ "Installation instructions".

    [[= product_name_cloud =]] CLI and Upsun CLI share the same commands and the [same documentation](https://fixed.docs.upsun.com/administration/cli.html#3-use), but you have to replace `upsun` with `ibexa_cloud`.

    If you have previously set up an alias to use Upsun CLI with [[= product_name_cloud =]], it's outdated.
    Remove the alias and install [[= product_name_cloud =]] CLI instead.
