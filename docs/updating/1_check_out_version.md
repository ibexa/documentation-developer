# 1. Check out a version

## 1.1. Create a branch

Create a new branch for handling update changes from the project's `master` branch, or from the branch you're updating on:

``` bash
git checkout -b <branch_name>
```

This creates a new project branch for the update based on your current project branch.
An example `<branch_name>` would be `update-1.4`.
In the following steps it will be referred to as *update branch*.

## 1.2. Add `upstream` remote

If it is not added as a remote yet, add `ezsystems/ezplatform` as an `upstream` remote
(on an Enterprise installation use `ezsystems/ezplatform-ee`, and on an eZ Commerce installation, `ezsystems/ezcommerce`):

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

## 1.3. Prepare for pulling changes

??? note "Adding `sort-packages` option when updating from <=v1.13.4, v2.2.3, v2.3.2"

    Composer sorts packages listed in `composer.json`.
    If your packages are not sorted yet, you should prepare for this update to make it clearer which changes you introduce.

    Assuming you have installed packages on your installation (`composer install`), do the following steps:

    1\. Add [sort-packages](https://getcomposer.org/doc/06-config.md#sort-packages) to the `config` section in `composer.json`.

    ``` json hl_lines="3"
    "config": {
        "bin-dir": "bin",
        "sort-packages": true,
        "preferred-install": {
            "ezsystems/*": "dist"
        }
    },
    ```

    2\. Use `composer require` to get Composer to sort your packages.

    The following example updates a few requirements with what you can expect in the upcoming change:

    ``` bash hl_lines="1 2 4"
    composer require --no-scripts --no-update doctrine/doctrine-bundle:^1.9.1
    composer require --dev --no-scripts --no-update behat/behat:^3.5.0
    # The upcoming change also moves security-advisories to dev as advised by the package itself
    composer require --dev --no-scripts --no-update roave/security-advisories:dev-master
    ```

    3\. Check that you can install/update packages.

    ``` bash
    composer update
    ```

    If Composer says there were no updates, or if it updates packages without stopping with conflicts,
    your preparation was successful.

    4\. Save your work.

    ``` bash
    git commit -am "Sort my existing composer packages in anticipation of update with sorted merge"
    ```

## 1.4. Pull the tag into your branch

Pull the selected tag into your update branch with the following command:

``` bash
git pull upstream <version>
```

!!! tip

    Always provide the version number with the `v` prefix, which indicates a tag, not a branch
    (for example, `v3.2.0` indicated a tag, while `3.2.0` or `3.2` indicate a development branch).

At this stage you may get conflicts, which are a normal part of the update procedure.
The most common ones will be on `composer.json` and `composer.lock`.
