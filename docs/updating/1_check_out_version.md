# 1. Check out a tagged version

**1.1.** From the project's root, create a new branch from the project's *master*, or from the branch you're updating on:

**From your master branch, create a branch for handling update changes**

``` bash
git checkout -b <branch_name>
```

This creates a new project branch for the update based on your current project branch, typically `master`. An example `<branch_name>` would be `update-1.4`.
In the following steps it will be referred to as **update branch**.

**1.2.** If it's not there, add `ezsystems/ezplatform` as an *upstream* remote
(on an Enterprise installation use `ezsystems/ezplatform-ee`, and on an eZ Commerce installation, `ezsystems/ezcommerce`):

**From your update branch add upstream remote**

``` bash
git remote add upstream http://github.com/ezsystems/ezplatform.git
or
git remote add upstream http://github.com/ezsystems/ezplatform-ee.git
or
git remote add upstream http://github.com/ezsystems/ezcommerce.git
```

**1.3.** Prepare for pulling changes

??? note "Adding `sort-packages` option when updating from <=1.7.8, 1.13.4, 2.2.3, 2.3.2"

    To reduce the number of conflicts in the future, [EZP-29835](https://jira.ez.no/browse/EZP-29835) adds a setting to
    Composer to make it sort packages listed in `composer.json`. If you don't already do this, you should prepare for
    this update to make it clearer which changes you introduce.

    Assuming you have installed packages on your installation (`composer install`), do the following steps:

    1\. Add [sort-packages](https://getcomposer.org/doc/06-config.md#sort-packages) to the `config` section in `composer.json` as shown in the highlighted line:

    ``` json hl_lines="3"
    "config": {
        "bin-dir": "bin",
        "sort-packages": true,
        "preferred-install": {
            "ezsystems/*": "dist"
        }
    },
    ```

    2\. Use `composer require` to get Composer to sort your packages:

    With this new option you should ideally always use `composer require` to add or adjust packages to make sure they
    are sorted. The following code example updates a few requirements with what you can also expect in the upcoming
    change:

    ``` bash hl_lines="1 2 4"
    composer require --no-scripts --no-update doctrine/doctrine-bundle:^1.9.1
    composer require --dev --no-scripts --no-update  behat/behat:^3.5.0
    # The upcoming change also moves security-advisories to dev as advised by the package itself
    composer require --dev --no-scripts --no-update roave/security-advisories:dev-master
    ```

    3\. Check that you can install/update packages:

    ``` bash
    composer update
    ```

    You can consider the result a success if Composer says there were no updates, or if it updated packages without stopping with conflicts.

    4\. Now that packages are sorted, save your work.

    With packages sorted you are ready to pull in changes
    As they will also be sorted, it will be easier to see which changes are relevant to your `composer.json`.

    ``` bash
    git commit -am "Sort my existing composer packages in anticipation of update with sorted merge"
    ```

**1.4.** Then pull the tag into your branch.

If you are unsure which version to pull, run `git ls-remote --tags` to list all possible tags.

**Pull the tag into your update branch**

``` bash
git pull upstream <version>
```

!!! tip

    Don't forget the `v` parameter here. You want to pull the tag `<version>` and not the branch `<version>` (i.e.: `v1.11.0`, and NOT `1.11.0` or `1.10` which is dev branch).

At this stage you may get conflicts, which are a normal part of the procedure and no reason to worry.
The most common ones will be on `composer.json` and `composer.lock`.

The latter can be ignored, as it will be regenerated when we execute `composer update` later.
The easiest is to checkout the version from the tag and add it to the changes:

If you get a **lot** of conflicts (on the `doc` folder for instance), and eZ Platform was installed from the [ezplatform.com](https://ezplatform.com) or [support.ez.no](https://support.ez.no) (for Enterprise and eZ Commerce) tarball, it might be because of incomplete history.
You will have to run `git fetch upstream --unshallow` to load the full history, and run the merge again.

**From your update branch**

``` bash
git checkout --theirs composer.lock && git add composer.lock
```

If you do not keep a copy in the branch, you may also run:

**From your update branch**

``` bash
git rm composer.lock
```
