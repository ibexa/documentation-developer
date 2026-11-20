# Install on Ibexa Cloud

Install and configure Ibexa DXP to run in cloud using Ibexa Cloud.

Ibexa Cloud enables you to host your application in the cloud by using the [Upsun](https://upsun.com/) service.

## 1. Prepare configuration files

If you didn't add cloud configuration during installation, run the following commands now:

```bash
composer require ibexa/cloud
php bin/console ibexa:cloud:setup --upsun
```

These commands add the necessary package and configuration files required for Ibexa Cloud.

You can adapt the configuration in the following places:

- `.platform.app.yaml` - main configuration
- `.platform/services.yml` - additional [services](https://fixed.docs.upsun.com/add-services.html) such as search engines or cache
- `.platform/routes.yml` - routes to define how [Upsun handles incoming web requests](https://fixed.docs.upsun.com/define-routes.html)

For details about available configuration settings, refer to [Upsun documentation](https://fixed.docs.upsun.com/create-apps.html).

### Disk space

The total disk space depends on your Ibexa Cloud subscription level. You can assign disk space to the main app container under the `disk` key. You can distribute the remaining space between other containers (for example, the database) or search engine in `.platform/services.yaml`, under the individual service definitions.

### Build and deploy process

Configuration under `hooks` defines the process of building and deploying your project.

> **Note: Note**
>
> During the build phase (defined in the `hooks.build` configuration), files in the project have read/write permissions (can be modified).
>
> During deployment (defined in the `hooks.deploy` configuration), all files in the project are read-only.

### Additional services

`.platform/services.yaml` contains preconfigured setting blocks that you can uncomment to enable services such as Solr or Elasticsearch, or persistent Redis session storage.

For information about available services, see [Upsun documentation](https://fixed.docs.upsun.com/add-services.html#available-services).

If you enable any of the services, you must uncomment the relevant relationship under the `relationship` key in `.platform.app.yaml` as well.

For information about environment variables automatically generated based on your service configuration, see [Environment variables on Ibexa Cloud](../environment_variables/index.md).

## 2. Create an account

Log in to <https://console.ibexa.cloud> or create an account if you don't have one yet.

Create a project and select its region.

> **Caution: Caution**
>
> Don't use <https://console.upsun.com/> (or former <https://console.platform.sh/>) which don't list Ibexa Cloud projects. Use <https://console.ibexa.cloud> to manage your Ibexa Cloud projects.

## 3. Prepare for hosting

After the project is created, the website walks you through preparing your project for hosting. This includes adding an SSH key, and adding Upsun as a git remote.

Add your Composer authentication token to the project before pushing it to Upsun. You can set this token as an environment variable.

When you do, make sure the **Visible during runtime** box in Ibexa Cloud configuration is unchecked. This ensures that the token isn't exposed.

### Composer authentication using the web console

In **Settings** (top right gear icon) -> **Project Settings** -> **Variables** -> **+ Create variable**

![Setting token to be invisible during runtime](https://doc.ibexa.co/en/5.0/getting_started/img/ibexa_cloud-composer_auth.png)

### Composer authentication using the CLI command

Use [Ibexa Cloud CLI](../ibexa_cloud_cli/index.md) to create the variable:

```bash
ibexa_cloud variable:create --level project --name env:COMPOSER_AUTH \
  --json true --visible-runtime false --sensitive true --visible-build true \
  --value '{"http-basic": {"updates.ibexa.co": {"username": "<installation-key>", "password": "<token-password>"}}}'
```

## 4. Push the project

When you're done with configuration, push your project to the Upsun remote:

```bash
git push -u <upsun-remote> main
```

You can also use the [Ibexa Cloud CLI](https://cli.ibexa.cloud/) to push your code.

```bash
ibexa_cloud push main
```

The [database installer](../../getting_started/install_ibexa_dxp/index.md#create-a-database) runs in non-interactive mode and keeps the default password for the `admin` user. Modify this password after the installation, for example, by using [data migrations](../../content_management/data_migration/importing_data/index.md#users) or the [user management command](../../users/update_basic_user_data/index.md#change-password).

> **Note: Note**
>
> `main` is the Upsun name for the production branch.

> **Caution: Caution**
>
> Don't use Upsun CLI (`upsun`), instead, use the [Ibexa Cloud CLI (`ibexa_cloud`)](https://cli.ibexa.cloud/) instead.
>
> For more information, see [Ibexa Cloud CLI](../ibexa_cloud_cli/index.md).
