# Troubleshooting

This page lists potential problems that you may encounter while installing, configuring, and running eZ Platform.

## Initial installation options

If you accepted default options during `composer install`, but need to change some of them later,
you can do it in `app/config/parameters.yml`.

## Enable swap on systems with limited RAM

If you have problems installing eZ Platform on a system with limited RAM (for example 1GB or 2GB), enable swap.
It allows your operating system to use the hard disk to supplement RAM when it runs out.

With swap enables you will be able to successfully run `php -d memory_limit=-1 bin/console ezplatform:install --env prod ezplatform-clean`.

When a system runs out of RAM, you may see `Killed` when trying to clear the cache (e.g. `php bin/console --env=prod cache:clear` from your project's root directory).

## Upload size limit

To make use of the Back Office, the defined maximum upload size must be consistent with the maximum file size defined in the Content Type using a File, Media or Image Field.

This is done by setting `LimitRequestBody` for Apache or `client_max_body_size` for nginx.

For instance, if one of those Fields is configured to accept files up to 10MB, then `client_max_body_size` (in case of nginx) should be set above 10MB, with a safe margin, for example to 15MB.

You also need to define settings for uploading files in `php.ini`: `upload_max_filesize` and `post_max_size`.

## Cloning failed using an ssh key

When dealing with Composer packages from [updates.ez.no](http://updates.ez.no), you may get a "Cloning failed using an ssh key" error
if you tell Composer to download dev packages or to download from source.
[updates.ez.no](http://updates.ez.no) currently supports only distribution packages in alpha stability or higher.

To avoid the error, check the stability of packages and avoid using `--prefer-source`.

## Redis: Cache / Session data inconsistent across web servers

See [Redis Cluster info in persistence cache doc](../guide/persistence_cache.md#redis-clustering), and make sure you only read/write to
one active master instance at a time.

## Redis: Sessions are removed or new sessions are refused

See info on [Redis in session doc](../guide/sessions.md#cluster-setup).
Ideally, use a separated instance of Redis for sessions,
that either never runs out of memory or uses an eviction policy that suits your needs.

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
