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

**1.3.** Pull the tag into your branch.

If you are unsure which version to pull, run `git ls-remote --tags upstream` to list all possible tags.

**Pull the tag into your update branch**

``` bash
git pull upstream <version>
```

!!! tip

    Don't forget the `v` parameter here. You want to pull the tag `<version>` and not the branch `<version>` (i.e.: `v3.0.0`, and NOT `3.0.0` which is dev branch).

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
