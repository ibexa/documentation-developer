# Updating [[= product_name =]] to v3.3

[[= product_name =]] v3.3 uses [Symfony Flex](https://symfony.com/doc/current/quick_tour/flex_recipes.html).
When updating from v3.2 to v3.3, you need to follow a special update procedure.

If you are updating from an earlier version, start with updating your installation to v3.2.

First, create an upgrade branch in git and commit your work.

!!! tip

    It is good practice to make git commits after every step of the update procedure.

## Merge composer.json

Merge the special update branch into your project:

```
git merge origin/v3.2-to-v3.3-upgrade
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

Add your [[= product_name =]] edition to `composer.json`, for example:

```
composer require ibexa/content:^3.3 --no-update
```

!!! caution

    It is impossible to update an Enterprise edition (`ezsystems/ezplatform-ee`)
    to an [[= product_name_content =]] edition.

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
composer recipes:install ibexa/content --force -v
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

Apply the following database update script:

=== "Mysql"

    `mysql -u <username> -p <password> <database_name> < upgrade/db/mysql/ezplatform-3.2.0-to-3.3.0.sql`

=== "PostgreSQL"

    `psql <database_name> < upgrade/db/postgresql/ezplatform-3.2.0-to-3.3.0.sql`

Check the Location ID of the "Components" Content item and set it as a value of the `content_tree_module.contextual_tree_root_location_ids` key in `config/ezplatform.yaml`:

```
- 60 # Components
```

If you are upgrading between [[= product_name_com =]] versions,
add the `content/read` Policy with the Owner Limitation set to `self` to the "Ecommerce registered users" Role.

## Finish the update

Finish the update by running the following commands:

``` bash
php bin/console ibexa:graphql:generate-schema
composer run post-install-cmd
```
