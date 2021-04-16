# Updating Ibexa DXP to v3.3

Ibexa DXP v3.3 uses [Symfony Flex](https://symfony.com/doc/current/quick_tour/flex_recipes.html).
When updating from v3.2 to v3.3, you need to follow a special update procedure.

If you are updating from an earlier version, start with [updating your installation to v3.2](updating.md).

First, create an update branch in git and commit your work.

If you have not done it before, add the relevant meta-repository as an `upstream` remote:

=== "ezplatform"

    ``` bash
    git remote add upstream http://github.com/ezsystems/ezplatform.git
    ```

=== "ezplatform-ee"

    ``` bash
    git remote add upstream http://github.com/ezsystems/ezplatform-ee.git
    ```

=== "ezcommerce"

    ``` bash
    git remote add upstream http://github.com/ezsystems/ezcommerce.git
    ```

!!! tip

    It is good practice to make git commits after every step of the update procedure.

## Merge composer.json

Merge the special `v3.2-to-v3.3-upgrade` update branch into your project:

```
git pull upstream v3.2-to-v3.3-upgrade
```

This will introduce changes from the [website skeleton](https://github.com/ibexa/website-skeleton/blob/main/composer.json)
and result in conflicts in `composer.json`.

Resolve the conflicts in the following way:

- Make sure all automatically added `ezsystems/*` packages are removed. If you explicitly added any packages that are not part of the standard installation, retain them.
- Review the rest of the packages. If your project requires a package, keep it.
- If a package is only used as a dependency of an `ezsystems` package, remove it. You can check how the package is used with `composer why <packageName>`.
- Keep the dependencies listed in the website skeleton.

Make sure `extra.symfony.endpoint` is set to `https://flex.ibexa.co`, and `extra.symfony.require` to `5.2.*`:

``` json
"require": "5.2.*",
"endpoint": "https://flex.ibexa.co"
```

For all dependencies that you removed from `composer.json`, check if the `bin` folder contains files that will not be used and remove them, for example:

``` bash
rm bin/{ezbehat,ezreport,phpunit,behat,fastest}
```

Add your Ibexa DXP edition to `composer.json`, for example:

```
composer require ibexa/experience:^3.3 --no-update
```

!!! caution

    It is impossible to update an Enterprise edition (`ezsystems/ezplatform-ee`)
    to an Ibexa Commerce edition.

## Update the app

Run `composer update` to update the dependencies:

``` bash
composer update
```

If Composer informs you that the `composer.lock` file is out of date, run `composer update` again.

## Update recipes for third party packages

Run `composer recipes` to get a list of all the available recipes.

For every recipe that needs updating, run:

``` bash
composer sync-recipes <package_name> --force -v
```

Review changes from each package and integrate them into your project.

## Install Ibexa recipes

Install recipes for Ibexa packages for your product edition, for example:

``` bash
composer recipes:install ibexa/experience --force -v
```

Review the changes and add them to your project.

Then, run the post-installation command:

``` bash
composer run post-install-cmd
```

## Configure the web server

Add the following rewrite rule to your web server configuration:

=== "Apache"

    ```
    RewriteRule ^/build/ - [L]
    ```

=== "nginx"

    ```
    rewrite "^/build/(.*)" "/build/$1" break;
    ```

## Update the database

!!! caution

    Before starting this step, back up your database.

Apply the following database update script:

=== "Mysql"

    ```
    mysql -u <username> -p <password> <database_name> < upgrade/db/mysql/ezplatform-3.2.0-to-3.3.0.sql
    ```

=== "PostgreSQL"

    ```
    psql <database_name> < upgrade/db/postgresql/ezplatform-3.2.0-to-3.3.0.sql
    ```

If you are updating from an installation based on the `ezsystems/ezplatform-ee` metarepository, 
run the following command to upgrade your database:

``` bash
php bin/console ibexa:upgrade
```

!!! caution

    You can only run this command once.

Check the Location ID of the "Components" Content item and set it as a value of the `content_tree_module.contextual_tree_root_location_ids` key in `config/ezplatform.yaml`:

```
- 60 # Components
```

If you are upgrading between Ibexa Commerce versions,
add the `content/read` Policy with the Owner Limitation set to `self` to the "Ecommerce registered users" Role.

## Finish the update

Finish the update by running the following commands:

``` bash
php bin/console ibexa:graphql:generate-schema
composer run post-install-cmd
```
