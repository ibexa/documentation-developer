# Update the app to v3.3

Before you start this procedure, make sure you have completed the previous step, [Updating code to v3](../adapt_code_to_v3/index.md).

## 5. Update to v3.3

Ibexa DXP v3.3 uses [Symfony Flex](https://symfony.com/doc/7.4/quick_tour/flex_recipes.html). When updating from v3.2 to v3.3, you need to follow a special update procedure.

> **Note: Note**
>
> Ibexa DXP v3.3 requires Composer 2.0.13 or higher.

First, create an update branch `update-3.3` in git and commit your work.

If you haven't done it before, add the relevant meta-repository as an `upstream` remote:

**ezplatform**

```bash
git remote add upstream http://github.com/ezsystems/ezplatform.git
```

**ezplatform-ee**

```bash
git remote add upstream http://github.com/ezsystems/ezplatform-ee.git
```

**ezcommerce**

```bash
git remote add upstream http://github.com/ezsystems/ezcommerce.git
```

> **Tip: Tip**
>
> It's good practice to make git commits after every step of the update procedure.

### A. Merge project skeleton

Merge the current skeleton into your project:

**Ibexa Contentt**

```bash
git remote add content-skeleton https://github.com/ibexa/content-skeleton.git
git fetch content-skeleton --tags
git merge v3.3.43 --allow-unrelated-histories
```

**Ibexa Experience**

```bash
git remote add experience-skeleton https://github.com/ibexa/experience-skeleton.git
git fetch experience-skeleton --tags
git merge v3.3.43 --allow-unrelated-histories
```

**Ibexa Commerce**

```bash
git remote add commerce-skeleton https://github.com/ibexa/commerce-skeleton.git
git fetch commerce-skeleton --tags
git merge v3.3.43 --allow-unrelated-histories
```

This introduces changes from the relevant website skeleton and results in conflicts.

Resolve the conflicts in the following way:

- Make sure all automatically added `ezsystems/*` packages are removed. If you explicitly added any packages that aren't part of the standard installation, retain them.
- Review the rest of the packages. If your project requires a package, keep it.
- If a package is only used as a dependency of an `ezsystems` package, remove it. You can check how the package is used with `composer why <packageName>`.
- Keep the dependencies listed in the website skeleton.

> **Tip: Tip**
>
> You can also approach resolving conflicts differently: run `git checkout --theirs composer.json` to get a clean `composer.json` from the skeleton and then manually add any necessary changes from your project.

> **Caution: Caution**
>
> It's impossible to update an Enterprise edition (`ezsystems/ezplatform-ee`) to an Ibexa Content edition.
>
> Also, make sure that `composer.json` has the following `repositories` entry:
>
> ```json
> "ibexa": {
>     "type": "composer",
>     "url": "https://updates.ibexa.co"
> }
> ```

### B. Update the app

Update Symfony Flex, then update the dependencies:

```bash
composer update symfony/flex --no-plugins --no-scripts
composer update
```

> **Caution: Caution**
>
> Composer repository changes between 3.2 and 3.3 from `updates.ez.no` to `updates.ibexa.co`, therefore your credentials might be outdated.
>
> `username` and `password` don't change. The repository they're used on changes.
>
> See [Composer authentication documentation](https://getcomposer.org/doc/articles/authentication-for-private-packages.md) to find the precedure that suits the way you're passing credentials.
>
> In production, replace the old repository with the new one. But as a developer, you may need to go back to an earlier version, and should keep the old repository as well. For example, your `auth.json` may look like this:
>
> ```json
> {
>     "http-basic": {
>         "updates.ibexa.co": {
>             "username": "abcdefghijklmnopqrstuvwxyz012345",
>             "password": "6789abcdefghijklmnopqrstuvwxyz01"
>         },
>         "updates.ez.no": {
>             "username": "abcdefghijklmnopqrstuvwxyz012345",
>             "password": "6789abcdefghijklmnopqrstuvwxyz01"
>         }
>     }
> }
> ```

### C. Configure the web server

Add the following rewrite rule to your web server configuration:

**Apache**

```text
RewriteRule ^/build/ - [L]
```

**nginx**

```text
rewrite "^/build/(.*)" "/build/$1" break;
```

## 6. Update the database

Apply the following database update script:

```bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ezplatform-2.5-to-ibexa-3.3.0.sql
```

If you're updating from an installation based on the `ezsystems/ezplatform-ee` metarepository, run the following command to upgrade your database:

```bash
php bin/console ibexa:upgrade
```

> **Caution: Caution**
>
> You can only run this command once.

Check the location ID of the "Components" content item and set it as a value of the `content_tree_module.contextual_tree_root_location_ids` key in `config/ezplatform.yaml`:

```yaml
- 60 # Components
```

If you're upgrading between Ibexa Commerce versions, add the `content/read` policy with the Owner limitation set to `self` to the "Ecommerce registered users" role.

## 7. Update to the latest patch version

Now, proceed to the last step, [updating to the latest v3.3 patch version](../../from_3.3/update_from_3.3/index.md).
