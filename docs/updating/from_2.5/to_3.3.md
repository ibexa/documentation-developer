---
target_version: '3.3'
latest_tag: '3.3.10'
---

# Update the app to v3.3

Before you start this procedure, make sure you have completed the previous step,
[Updating code to v3](update_code_to_v3.md).

## 5. Update to v3.3

Ibexa DXP v3.3 uses [Symfony Flex]([[= symfony_doc =]]/quick_tour/flex_recipes.html).
When updating from v3.2 to v3.3, you need to follow a special update procedure.

!!! note

    Ibexa DXP v3.3 requires Composer 2.0.13 or higher.

First, create an update branch `update-[[=target_version=]]` in git and commit your work.

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

Merge the current skeleton into your project. For example, for Ibexa Content run:

``` bash
git remote add content-skeleton https://github.com/ibexa/content-skeleton.git
git fetch content-skeleton --tags
git merge v[[= latest_tag =]] --allow-unrelated-histories
```

This introduces changes from the relevant website skeleton and results in conflicts.

Resolve the conflicts in the following way:

- Make sure all automatically added `ezsystems/*` packages are removed. If you explicitly added any packages that are not part of the standard installation, retain them.
- Review the rest of the packages. If your project requires a package, keep it.
- If a package is only used as a dependency of an `ezsystems` package, remove it. You can check how the package is used with `composer why <packageName>`.
- Keep the dependencies listed in the website skeleton.

!!! caution

    It is impossible to update an Enterprise edition (`ezsystems/ezplatform-ee`)
    to an [[= product_name_content =]] edition.

### B. Update the app

Run `composer update` to update the dependencies:

``` bash
composer update
```

### C. Configure the web server

Add the following rewrite rule to your web server configuration:

=== "Apache"

    ```
    RewriteRule ^/build/ - [L]
    ```

=== "nginx"

    ```
    rewrite "^/build/(.*)" "/build/$1" break;
    ```

## Next steps

Now, proceed to the last step, [updating to the latest v3.3 patch version](to_3.3.latest.md).
