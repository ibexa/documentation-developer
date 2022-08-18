---
description: See what issues you can encounter when installing Ibexa DXP and how to resolve them.
---

# Troubleshooting

This page lists potential problems that you may encounter while installing, configuring, and running [[= product_name =]].

## Encoding database password

The password entered in `DATABASE_URL` during installation must either be URL encoded,
or not contain any special characters that would require URL encoding.

### URL encoding

Using URL encoding involves two steps. First, the password must be URL encoded. This can for instance be done with PHP's `urlencode()` function.
For example, this function converts a password like `(/!=#Æ¤*;%?[` to `%28%2F%21%3D%23%C3%86%C2%A4%2A%3B%25%3F%5B`.

Second, you must remove `resolve:` from `doctrine.dbal.url` in `config/packages/doctrine.yaml`.
That means changing `%env(resolve:DATABASE_URL)%` to `%env(DATABASE_URL)%`.

### Avoid special characters

If your password only contains letters a-z, A-Z, and numbers 0-9, you don't need to do any encoding.
You can either create your password that way, in which case it is a good idea to make it longer to maintain entropy,
keeping the password hard to guess for an attacker.
Or, you can for instance convert your password with `bin2hex()`, so that e.g. `(/!=#Æ¤*;%?[` becomes `282f213d23c386c2a42a3b253f5b`.
The output from `bin2hex` is limited to 0-9 and a-f. This more than doubles the length of the password, keeping entropy similar.

## Enabling swap with limited RAM

If you have problems installing [[= product_name =]] on a system with limited RAM (for example 1GB or 2GB), enable swap.
It allows your operating system to use the hard disk to supplement RAM when it runs out.

With swap enables you will be able to successfully run `php -d memory_limit=-1 bin/console ibexa:install --env prod ezplatform-clean`.

When a system runs out of RAM, you may see `Killed` when trying to clear the cache (e.g. `php bin/console --env=prod cache:clear` from your project's root directory).

## Upload size limit

To make use of the Back Office, the defined maximum upload size must be consistent with the maximum file size defined in the Content Type using a File, Media or Image Field.

This is done by setting `LimitRequestBody` for Apache or `client_max_body_size` for nginx.

For instance, if one of those Fields is configured to accept files up to 10MB, then `client_max_body_size` (in case of nginx) should be set above 10MB, with a safe margin, for example to 15MB.

You also need to define settings for uploading files in `php.ini`: `upload_max_filesize` and `post_max_size`.

## Cloning failed using an ssh key

When dealing with Composer packages from [updates.ibexa.co](http://updates.ibexa.co), you may get a "Cloning failed using an ssh key" error
if you tell Composer to download dev packages or to download from source.
[updates.ibexa.co](http://updates.ibexa.co) currently supports only distribution packages in alpha stability or higher.

To avoid the error, check the stability of packages and avoid using `--prefer-source`.

## Redis sessions issues

### Inconsistent cache/session data

If cache or session data inconsistent across web servers in Redis,
see [Redis clustering](persistence_cache.md#redis-clustering), and make sure you only read/write to
one active master instance at a time.

### Removed or refused sessions

If Redis sessions are removed or new sessions are refused.
see info on [Cluster setup](sessions.md#cluster-setup).
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

## Platform.sh HTTP access credentials with Varnish

If you are using Platform.sh with Varnish for HTTP cache
and you have [HTTP access control by login/password](https://docs.platform.sh/administration/web/configure-environment.html#http-access-control) enabled,
configure the following variables in your Platform.sh environment:

- `HTTPCACHE_USERNAME`
- `HTTPCACHE_PASSWORD`

## Unconverted images in shop

Make sure that you have set up correct rights for the image folder:

``` bash
sudo chmod -R g+w web/var/ecommerce/storage/
```

## `BadFormatException` after installation

If you see the following error after installation:

`[Defuse\Crypto\Exception\BadFormatException] Encoding::hexToBin() input is not a hex string`

Generate a secret using `./vendor/defuse/php-encryption/bin/generate-defuse-key` and
configure it in `parameters.yml`:

```
env(JMS_PAYMENT_SECRET): 'def000004cb9c9f5edb77182df64b3d572162a47ec971a9a8beb00459b49fd9a1f9df6991ffc817c8585f59b8c5a032b796ab520eae126c77d8a304b36af0c9acdbfa9b9'
```
