# eZ Platform v1.12.0

**The FAST TRACK v1.12.0 release of eZ Platform and eZ Platform Enterprise Edition is available as of October 31, 2017.**

If you are looking for the Long Term Support (LTS) release, see [https://ezplatform.com/Blog/Long-Term-Support-is-Here](https://ezplatform.com/Blog/Long-Term-Support-is-Here)

## Notable changes since v1.11.0

#### New Options in the Rich Text editor

The Rich Text editor now enables you to add both ordered and unordered lists.

You also have new options to format your text using subscript, superscript, quote and strikethrough.

![New text formatting options](oe-formatting-new-options.png)

See [EZP-28030](https://jira.ez.no/browse/EZP-28030) for more information.

#### Improved full text search capabilities

See [EZP-26806](https://jira.ez.no/browse/EZP-26806) for more information.

#### Deleting translations

You can now remove translations from Content item Versions through the PHP API.

See the section on [deleting translations](https://doc.ibexa.co/en/latest/api/public_php_api_creating_content/#deleting-a-translation) for more information.

You also have a new endpoint available for deleting a single Version, see [EZP-27864](https://jira.ez.no/browse/EZP-27864) for more information.

#### Improved Security for password storage

1.12 introduces and enables by default more secure user passwords hashing using bcrypt,
and is future-proofed for new hashing formats being added to PHP, like Argon2i coming with PHP 7.2.

This feature is added both in eZ Platform and the accompanying eZ Publish legacy 2017.10 release for projects looking to migrate to a newer version of Platform and take advantage of the new features.

#### Improved Varnish performance

This release switches default HTTPCache usage to use ezplatform-http-cache package, which uses Varnish xkey allowing: soft purge, better cache clearing logic and longer ttl.

For Varnish users be aware thus change implies new VCL and requriment for varnish-moduels package, see [below](#updating).

## Full list of new features, improvements and bug fixes since v1.11.0

| eZ Platform   | eZ Enterprise  |
|--------------|------------|
| [List of changes for final of eZ Platform v1.12.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.12.0) | [List of changes for final for eZ Platform Enterprise Edition v1.12.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.12.0) |
| [List of changes for rc1 of eZ Platform v1.12.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.12.0-rc1) | [List of changes for rc1 for eZ Platform Enterprise Edition v1.12.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.12.0-rc1) |
| [List of changes for beta2 of eZ Platform v1.12.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.12.0-beta2) | [List of changes for beta2 of eZ Platform Enterprise Edition v1.12.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.12.0-beta2) |

### Installation

[Installation Guide](https://doc.ibexa.co/en/latest/getting_started/install_ez_platform)

[Technical Requirements](https://doc.ibexa.co/en/latest/getting_started/requirements)

### Download

#### eZ Platform

- Download at eZPlatform.com

#### eZ Enterprise

- [Customers: eZ Enterprise subscription (BUL License)](https://support.ez.no/Downloads)
- Partners: Test & Trial software access (TTL License)

If you would like to become familiar with the products, [request a demo](https://www.ibexa.co/forms/request-a-demo).

### Updating

To update to this version, follow the [updating guide](https://doc.ibexa.co/en/latest/updating/updating/).

!!! caution "BC: Change for Varnish users"

    This release enables the [ezplatform-http-cache](https://github.com/ezsystems/ezplatform-http-cache) Bundle by default as it has a more future-proof approach for HttpCache:
    - Cache tagging is more reliable at clearing all affected cache on, for instance, subtree operations
    - More performant using [xkey](https://github.com/varnish/varnish-modules/blob/master/docs/vmod_xkey.rst) _("Surrogate Key")_ and soft purging, over BAN and growing ban list

    This means:
    - There is a new VCL
    - Requires Varnish 4.1+ with `varnish-modules` _(incl. xkey)_, or Varnish Plus where it is built in

    Further reading in [doc/varnish/varnish.md](https://github.com/ezsystems/ezplatform/blob/master/doc/varnish/varnish.md).

    #### How to still use the old VCL and the old X-Location-Id headers

    In all 1.x releases you will still be able to revert this and use the old deprecated system if you need to. To do that:
    - Keep using the VCL for BAN
    - Disable _(comment out)_ `EzSystemsPlatformHttpCacheBundle` in `app/AppKernel.php`
    - Change `app/AppCache.php` back to extend `eZ\Bundle\EzPublishCoreBundle\HttpCache`

    That's it, other changes added in 1.12 like increased cache ttl and `fos_http_cache` cache control rules for error pages should work also with BAN setup, and are thus optional.

!!! note "React"

    This release changes the way of loading React to avoid a case where it was loaded twice and caused errors.
    Take this into consideration if you user React in your own implementation.

    See [this PR](https://github.com/ezsystems/PlatformUIBundle/pull/906) for more information.
