# Troubleshooting

This page lists potential problems that you may encounter while installing, configuring, and running eZ Platform. If you stumble upon an obstacle, take a look here to see if your case isn't covered.

Want to add to this page? Check out our instructions for [contributing to our documentation](../community_resources/documentation.md).

## Enable Swap on Systems with Limited RAM

If you're having difficulty completing installation on a system with limited RAM (1GB or 2GB, for example), check that you've enabled swap. This allows your Operating System to use the hard disk to supplement RAM when it runs out. Running `php -d memory_limit=-1 app/console ezplatform:install --env prod clean` on a system with swap enabled should yield success. When a system runs out of RAM, you may see `Killed` when trying to clear the cache (e.g., `php app/console --env=prod cache:clear` from your project's root directory).

## Upload Size Limit

To make use of PlatformUI, you need to define the maximum upload size to be consistent with the maximum file size defined in the Content Type using a File, Media or Image Field Definition.

This is done by setting `LimitRequestBody` for Apache or `client_max_body_size` for Nginx.

For instance, if one of those Field definitions is configured to accept files up to 10MB, then `client_max_body_size` (in case of Nginx) should be set above 10MB, with a safe margin, for example to 15MB.

## Initial Install Options

If you accepted all the defaults when doing a `composer install`, but realize you need to go back and change some of those options, look in `app/config/parameters.yml` – that's where they are stored.

## Cloning failed using an ssh key

When dealing with [updates.ez.no](http://updates.ez.no) packages, you may get a "Cloning failed using an ssh key" error
if you tell Composer to download dev packages or to download from source.
[updates.ez.no](http://updates.ez.no) currently supports only distribution packages in alpha stability or higher.

To avoid the error, check the stability of packages and avoid using `--prefer-source`.

## Conflict with roave/security-advisories

When you use `composer update` or `composer require`, a package may conflict with `roave/security-advisories`:

``` bash
Your requirements could not be resolved to an installable set of packages.
  Problem 1
    - ezsystems/ezpublish-legacy v5.4.10 conflicts with roave/security-advisories[dev-master].
    (...)
```

This means there is a known security bug in the specific version of the package, `ezsystems/ezpublish-legacy`.
In most cases this means that a fix is available in a newer version.
If you increase your requirement to that version, the conflict is resolved.

In the rare case when there is no fixed version, you can revert your requirement to an older version which does not have the bug.
If you have to use the version with the bug (not recommended) you can use `composer remove roave/security-advisories`.
In such case, require it again when the bug is fixed and the package is updated: `composer require roave/security-advisories:dev-master` 
