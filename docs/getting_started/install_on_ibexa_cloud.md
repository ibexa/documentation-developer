# Install on Ibexa Cloud

Ibexa Cloud enables you to host your application in the cloud using the [Platform.sh](https://platform.sh/) service.

## 1. Prepare configuration files

If you hadn't run the `composer ibexa:setup` command during installation, run it now:

``` bash
composer ibexa:setup --platformsh
```

This command adds to your project configuration files required for using Ibexa Cloud.

You can adapt the configuration in two places:

- `.platform.app.yaml` - main configuration
- `.platform/services.yml` - additional services such as search engines or cache

### Disk space

The total disk space is defined by your Ibexa Cloud subscription level.
You can assign disk space to the main app container under the `disk` key.
You can distribute the remaining space between other containers (e.g. the database) or search engine
In `.platform/services.yaml` under the individual service definitions.

### Build and deploy process

Configuration under `hooks` defines the process of building and deploying your project.

!!! note

    During the build phase (defined in the `hooks.build` configuration), files in the project have read/write permissions (can be modified).
    
    During deployment (defined in the `hooks.deploy` configuration), all files in the project are read-only.

### Additional services

`.platform/services.yaml` contains prepared setting blocks that you can uncomment
to enable services such as Solr or Elasticsearch, or persistent Redis session storage.

If you enable any of the services, you need to uncomment the relevant relationship
under the `relationship` key in `.platform.app.yaml` as well.

## 2. Create an account

Log in to https://cloud.ibexa.co or create an account if you do not have one yet.

Create a project and select its region.

## 3. Prepare for hosting

After the project is created, the website walks you through preparing your project for hosting.
This includes adding an ssh key, and adding Platform.sh as a git remote.

Add your Composer authentication token to the project before pushing it to Platform.sh.
You can set this token as an environment variable.

When you do, make sure the **Visible during runtime** box in Platform.sh configuration is unchecked.
This ensures that the token is not exposed.

![Setting token to be invisible during runtime](img/psh_addvariable.png)

## 4. Push the project

When you are done with configuration, push your project to the Platform.sh remote:

``` bash
git push -u <platform.sh-remote> master
```

!!! note

    `master` is the Platform.sh name for the production branch.
