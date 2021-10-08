Ibexa DXP v3.3 uses [Symfony Flex]([[= symfony_doc =]]/quick_tour/flex_recipes.html).
When updating from v3.2 to v3.3, you need to follow a special update procedure.

!!! note

    Ibexa DXP v3.3 requires Composer 2.0.13 or higher.

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

### A. Merge composer.json

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

Make sure `extra.symfony.endpoint` is set to `https://flex.ibexa.co`, and `extra.symfony.require` to `*`:

``` json
"require": "*",
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
    to an [[= product_name_content =]] edition.

### B. Update the app

Run `composer update` to update the dependencies:

``` bash
composer update
```

If Composer informs you that the `composer.lock` file is out of date, run `composer update` again.

### C. Update recipes for third party packages

Run `composer recipes` to get a list of all the available recipes.

For every recipe that needs updating, run:

``` bash
composer sync-recipes <package_name> --force -v
```

Review changes from each package and integrate them into your project.

### D. Install Ibexa recipes

Install recipes for Ibexa packages for your product edition, for example:

``` bash
composer recipes:install ibexa/experience --force -v
```

Review the changes and add them to your project.

Then, run the post-installation command:

``` bash
composer run post-install-cmd
```

### E. Configure the web server

Add the following rewrite rule to your web server configuration:

=== "Apache"

    ```
    RewriteRule ^/build/ - [L]
    ```

=== "nginx"

    ```
    rewrite "^/build/(.*)" "/build/$1" break;
    ```
