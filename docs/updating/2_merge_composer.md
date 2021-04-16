# 2. Resolve conflicts

## 2.1. Resolve conflicts

Ignore the conflicts in `composer.lock`, because this file is regenerated when you execute `composer update` later.
It is easiest to check out the version of the file from the tag and add it to the changes.

If you get a lot of conflicts (for example, on the `doc` folder),
and eZ Platform was installed from the [ezplatform.com](https://ezplatform.com)
or [support.ez.no](https://support.ez.no) (for Enterprise and eZ Commerce) tarball,
it might be because of incomplete history.
Run `git fetch upstream --unshallow` from your update branch to load the full history, and run the merge again.

``` bash
git checkout --theirs composer.lock && git add composer.lock
```

If you do not keep a copy in the branch, you may also run:

``` bash
git rm composer.lock
```

## 2.2. Resolve conflicts in `composer.json`

You need to fix conflicts in `composer.json` manually.

If you're not familiar with the diff output, you may check out the tag's version from you update branch and inspect the changes.

``` bash
git checkout --theirs composer.json && git diff HEAD composer.json
```

This command shows what was changed, as compared to your own version, in the diff output.

The update changes the requirements for all of the `ezsystems/` packages. Keep those changes.
The other changes will remove what you added for your own project.
Use `git checkout -p` to selectively cancel those changes (and retain your additions):

``` bash
git checkout -p composer.json
```

Answer `no` (do not discard) to the requirement changes of `ezsystems` dependencies.
Answer `yes` (discard) to removals of your changes.

After you are done, inspect the file, by either using an editor or running `git diff composer.json`.
You may also test the file's sanity with `composer validate`,
and test the dependencies by running `composer update --dry-run`
(it will output what it would do to the dependencies, without applying the changes).

Once finished, run `git add composer.json` and commit.

## 2.3. Fix other conflicts

Depending on the local changes you have done, you may get other conflicts on configuration files, kernel, etc.

For each change, edit the file, identify the conflicting changes and resolve the conflict.
Run `git add <conflicting-file>` to add the changes.
