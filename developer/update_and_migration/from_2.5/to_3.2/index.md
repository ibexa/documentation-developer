# Update the app to v3.2

> **Caution: Caution**
>
> Before you start updating to v3.3, make sure that you're currently using the latest version of v2.5 (v2.5.32). If not, refer to the [update guide for v2.5](../../from_1.x_2.x/update_db_to_2.5/index.md#d-update-to-v25).

To move from v2.5 to v3.3, first, you need to bring the app to version v3.2.

## 1. Check out a version

### A. Create branch

Create a new branch for handling update changes from the branch you're updating on:

```bash
git checkout -b update-3.2
```

This creates a new project branch (`update-3.2`) for the update based on your current project branch.

### B. Add `upstream` remote

If it's not added as a remote yet, add an `upstream` remote:

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

### C. Prepare for pulling changes

Adding `sort-packages` option when updating from \<=v1.13.4, v2.2.3, v2.3.2

Composer sorts packages listed in `composer.json`. If your packages aren't sorted yet, you should prepare for this update to make it clearer which changes you introduce.

Assuming you have installed packages on your installation (`composer install`), do the following steps:

1. Add [sort-packages](https://getcomposer.org/doc/06-config.md#sort-packages) to the `config` section in `composer.json`.

```json
"config": {
    "bin-dir": "bin",
    "sort-packages": true,
    "preferred-install": {
        "ezsystems/*": "dist"
    }
},
```

2. Use `composer require` to get Composer to sort your packages.

The following example updates a few requirements with what you can expect in the upcoming change:

```bash
composer require --no-scripts --no-update doctrine/doctrine-bundle:^1.9.1
composer require --dev --no-scripts --no-update behat/behat:^3.5.0
# The upcoming change also moves security-advisories to dev as advised by the package itself
composer require --dev --no-scripts --no-update roave/security-advisories:dev-master
```

3. Check that you can install/update packages.

```bash
composer update
```

If Composer says there were no updates, or if it updates packages without stopping with conflicts, your preparation was successful.

4. Save your work.

```bash
git commit -am "Sort my existing composer packages in anticipation of update with sorted merge"
```

### D. Pull the tag into your branch

Pull the latest v3.2 tag into the `update-3.2` branch with the following command:

```bash
git pull upstream v3.2.8
```

At this stage you may get conflicts, which are a normal part of the update procedure.

## 2. Resolve conflicts

### A. Resolve conflicts

If you get a lot of conflicts and you installed from the [support.ez.no / support.ibexa.co](https://support.ibexa.co) tarball or from ezplatform.com, you may have incomplete history.

To load the full history, run `git fetch upstream --unshallow` from the `update-3.2` branch, and run the merge again.

Ignore the conflicts in `composer.lock`, because this file is regenerated when you execute `composer update` later. It's easiest to check out the version of `composer.lock` from the tag and add it to the changes:

```bash
git checkout --theirs composer.lock && git add composer.lock
```

If you don't keep a copy of `composer.lock` in the branch, you may also remove it by running:

```bash
git rm composer.lock
```

### B. Resolve conflicts in `composer.json`

You need to fix conflicts in `composer.json` manually.

If you're not familiar with the diff output, you may check out the tag's version from the `update-3.2` branch and inspect the changes.

```bash
git checkout --theirs composer.json && git diff HEAD composer.json
```

This command shows the differences between the target `composer.json` and your own in the diff output.

Updating `composer.json` changes the requirements for all of the `ezsystems` / `ibexa` packages. Keep those changes. The other changes remove what you added for your own project. Use `git checkout -p` to selectively cancel those changes (and retain your additions):

```bash
git checkout -p composer.json
```

Answer `no` (don't discard) to the requirement changes of `ezsystems` / `ibexa` dependencies. Answer `yes` (discard) to removals of your changes.

After you're done, inspect the file (you can use an editor or run `git diff composer.json`). You may also test the file with `composer validate`, and test the dependencies by running `composer update --dry-run` (it outputs what it would do to the dependencies, without applying the changes).

When finished, run `git add composer.json` and commit.

### C. Fix other conflicts

Depending on the local changes you have done, you may get other conflicts, for example, on configuration files or kernel.

For each change, edit the file, identify the conflicting changes, and resolve the conflict. Run `git add <conflicting-file>` to add the changes.

## 3. Update the app

At this point, you should have a `composer.json` file with the correct requirements and you can update dependencies.

If you want to first test how the update proceeds without actually updating any packages, you can try the command with the `--dry-run` switch:

```bash
composer update --dry-run
```

Then, run `composer update` to update the dependencies.

```bash
composer update
```

## Next steps

Now, proceed to the next step, [updating the code to v3.0](../adapt_code_to_v3/index.md).
