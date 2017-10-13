# eZ Platform v1.12.0

**The FAST TRACK v1.12.0 release of eZ Platform and eZ Platform Enterprise Edition is available as of October 31, 2017.**

If you are looking for the Long Term Support (LTS) release, see [https://ezplatform.com/Blog/Long-Term-Support-is-Here](https://ezplatform.com/Blog/Long-Term-Support-is-Here)

## Notable changes since v1.11.0

#### New Options in the Rich Text editor

The Rich Text editor now enables you to add both ordered and unordered lists.

You also have new options to format your text using subscript, superscript, quote and strikethrough.

![New text formatting options](img/oe-formatting-new-options.png)

See [EZP-28030](https://jira.ez.no/browse/EZP-28030) for more information.

#### Improved full text search capabilities

See [EZP-26806](https://jira.ez.no/browse/EZP-26806) for more information.

#### Deleting translations

You can now remove translations from Content item Versions through the PHP API.

See the [section on deleting translations](../api/public_php_api.md#delete-translations) for more information.

## Full list of new features, improvements and bug fixes since v1.11.0

| eZ Platform   | eZ Enterprise  |
|--------------|------------|
| [List of changes for final of eZ Platform v1.12.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.12.0) | [List of changes for final for eZ Platform Enterprise Edition v1.12.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.12.0) |
| [List of changes for rc1 of eZ Platform v1.12.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.12.0-rc1) | [List of changes for rc1 for eZ Platform Enterprise Edition v1.12.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.12.0-rc1) |
| [List of changes for beta2 of eZ Platform v1.12.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.12.0-beta2) | [List of changes for beta2 of eZ Platform Enterprise Edition v1.12.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.12.0-beta2) |

### Installation

[Installation Guide](../getting_started/install_ez_platform.md)

[Technical Requirements](../getting_started/requirements_and_system_configuration.md)

### Download

#### eZ Platform

- Download at [eZPlatform.com](http://ezplatform.com/#download)

#### eZ Enterprise

- [Customers: eZ Enterprise subscription (BUL License)](https://support.ez.no/Downloads)
- [Partners: Test & Trial software access (TTL License)](https://ez.no/Partner-Portal/Software-Downloads-Release-Info)

If you would like to request an eZ Enterprise Demo instance: <http://ez.no/Forms/Discover-eZ-Studio>

### Updating

To update to this version, follow the [Updating eZ Platform](updating_ez_platform.md) guide and use v1.12.0 as `<version>`.

!!! caution "BC: Change for Varnish users"

    This release enables ezplatform-http-cache Bundle by default as it has a more future proof approach for HttpCache.

    See https://github.com/ezsystems/ezplatform/releases/tag/v1.12.0-beta2 for more information.

!!! note "React"

    This release changes the way of loading React to avoid a case where it was loaded twice and caused errors.
    Take this into consideration if you user React in your own implementation.

    See [this PR](https://github.com/ezsystems/PlatformUIBundle/pull/906) for more information.
