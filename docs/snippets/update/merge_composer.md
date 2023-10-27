### A. Resolve conflicts

If you get a lot of conflicts and you installed from the [support.ez.no / support.ibexa.co](https://support.ibexa.co) tarball
or from [ezplatform.com](https://ezplatform.com), you may have incomplete history.

To load the full history, run `git fetch upstream --unshallow` from the `update-[[= target_version =]]` branch, and run the merge again.

Ignore the conflicts in `composer.lock`, because this file is regenerated when you execute `composer update` later.
It is easiest to check out the version of `composer.lock` from the tag and add it to the changes:

``` bash
git checkout --theirs composer.lock && git add composer.lock
```

If you do not keep a copy of `composer.lock` in the branch, you may also remove it by running:

``` bash
git rm composer.lock
```

### B. Resolve conflicts in `composer.json`

You need to fix conflicts in `composer.json` manually.

If you're not familiar with the diff output, you may check out the tag's version from the `update-[[= target_version =]]` branch and inspect the changes.

``` bash
git checkout --theirs composer.json && git diff HEAD composer.json
```

This command shows the differences between the target `composer.json` and your own in the diff output.

Updating `composer.json` changes the requirements for all of the `ezsystems` / `ibexa`  packages. Keep those changes.
The other changes remove what you added for your own project.
Use `git checkout -p` to selectively cancel those changes (and retain your additions):

``` bash
git checkout -p composer.json
```

Answer `no` (do not discard) to the requirement changes of `ezsystems` / `ibexa`  dependencies.
Answer `yes` (discard) to removals of your changes.

After you are done, inspect the file (you can use an editor or run `git diff composer.json`).
You may also test the file with `composer validate`,
and test the dependencies by running `composer update --dry-run`
(it outputs what it would do to the dependencies, without applying the changes).

When finished, run `git add composer.json` and commit.

### C. Fix other conflicts

Depending on the local changes you have done, you may get other conflicts on configuration files, kernel, etc.

For each change, edit the file, identify the conflicting changes and resolve the conflict.
Run `git add <conflicting-file>` to add the changes.
