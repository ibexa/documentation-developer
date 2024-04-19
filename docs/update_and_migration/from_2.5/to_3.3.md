---
target_version: '3.3'
latest_tag: '3.3.24'
---

# Update the app to v3.3

Before you start this procedure, make sure you have completed the previous step,
[Updating code to v3](adapt_code_to_v3.md).

## 5. Update to v3.3

[[= product_name =]] v3.3 uses [Symfony Flex]([[= symfony_doc =]]/quick_tour/flex_recipes.html).
When updating from v3.2 to v3.3, you need to follow a special update procedure.

!!! note

    [[= product_name =]] v3.3 requires Composer 2.0.13 or higher.

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

### A. Merge project skeleton

Merge the current skeleton into your project:

=== "Ibexa Content"

    ``` bash
    git remote add content-skeleton https://github.com/ibexa/content-skeleton.git
    git fetch content-skeleton --tags
    git merge v[[= latest_tag =]] --allow-unrelated-histories
    ```

=== "Ibexa Experience"

    ``` bash
    git remote add experience-skeleton https://github.com/ibexa/experience-skeleton.git
    git fetch experience-skeleton --tags
    git merge v[[= latest_tag =]] --allow-unrelated-histories
    ```

=== "Ibexa Commerce"

    ``` bash
    git remote add commerce-skeleton https://github.com/ibexa/commerce-skeleton.git
    git fetch commerce-skeleton --tags
    git merge v[[= latest_tag =]] --allow-unrelated-histories
    ```

This introduces changes from the relevant website skeleton and results in conflicts.

Resolve the conflicts in the following way:

- Make sure all automatically added `ezsystems/*` packages are removed. If you explicitly added any packages that are not part of the standard installation, retain them.
- Review the rest of the packages. If your project requires a package, keep it.
- If a package is only used as a dependency of an `ezsystems` package, remove it. You can check how the package is used with `composer why <packageName>`.
- Keep the dependencies listed in the website skeleton.

!!! tip

    You can also approach resolving conflicts differently:
    run `git checkout --theirs composer.json` to get a clean `composer.json` from the skeleton
    and then manually add any necessary changes from your project.

!!! caution

    It is impossible to update an Enterprise edition (`ezsystems/ezplatform-ee`)
    to an [[= product_name_content =]] edition.

    Also, make sure that `composer.json` has the following `repositories` entry:

    ```json
    "ibexa": {
        "type": "composer",
        "url": "https://updates.ibexa.co"
    }
    ```

### B. Update the app

Run `composer update` to update the dependencies:

``` bash
composer update
```

!!! caution

    Composer repository changes between 3.2 and 3.3 from `updates.ez.no` to `updates.ibexa.co`, therefore your credentials might be outdated.

    `username` and `password` don't change.
    The repository they're used on changes.

    See [Composer authentication documentation](https://getcomposer.org/doc/articles/authentication-for-private-packages.md) to find the precedure that suits the way you're passing credentials.

    In production, replace the old repository with the new one.
    But as a developer, you may need to go back to an earlier version, and should keep the old repository as well.
    For example, your `auth.json` may look like this:

    ```json
    {
        "http-basic": {
            "updates.ibexa.co": {
                "username": "abcdefghijklmnopqrstuvwxyz012345",
                "password": "6789abcdefghijklmnopqrstuvwxyz01"
            },
            "updates.ez.no": {
                "username": "abcdefghijklmnopqrstuvwxyz012345",
                "password": "6789abcdefghijklmnopqrstuvwxyz01"
            }
        }
    }
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
