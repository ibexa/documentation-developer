# eZ Platform v1.13.0

**The Long Term Support v1.13.0 release of eZ Platform and eZ Platform Enterprise Edition is available as of December 22, 2017.**

!!! note "v2 release"

    Parallel to this v1.13.0 LTS version we are releasing a fast-track version in a new architecture:
    [v2.0.0](ez_platform_v2.0.0.md).

## Notable changes since v1.12.0

### Link manager

The new Link manager enables you to manage all links to external websites that are embedded in the whole site,
whether in Rich Text or in URL Field.
You can edit a link in the manager and it will be updated automatically in all Content items.

![Link Manager](img/link_manager.png)

### Copying subtrees in the back office

Following [EZP-27759](https://jira.ez.no/browse/EZP-27759) you can now copy a Content item with all of its sub-items in the back office.

The maximum number of Content items that can be copied this way can be set in configuration, see [Copy subtree limit](../guide/best_practices.md#copy-subtree-limit).

![Copy subtree option in the menu](img/copy_subtree_button.png)

### REST API improvements

- [EZP-27752](https://jira.ez.no/browse/EZP-27752) adds a REST endpoint for deleting a translation from all versions of a Content item.
- [EZP-28253](https://jira.ez.no/browse/EZP-28253) adds a `fieldTypeIdentifier` field to the REST response for Version, which provides the Field Type.

### ezplatform-http-cache extensibility

[EZEE-1780](https://jira.ez.no/browse/EZEE-1780) makes ezplatform-http-cache extensible in third party bundles.

### Fastly

Following [EZEE-1781](https://jira.ez.no/browse/EZEE-1781) you can [serve Varnish through Fastly](../guide/http_cache.md#serving-varnish-through-fastly).

## Full list of new features, improvements and bug fixes since v1.12.0

| eZ Platform   | eZ Enterprise  |
|--------------|------------|
| [List of changes for final of eZ Platform v1.13.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.13.0) | [List of changes for final for eZ Platform Enterprise Edition v1.13.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.13.0) |
| [List of changes for rc1 of eZ Platform v1.13.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.13.0-rc1) | [List of changes for rc1 for eZ Platform Enterprise Edition v1.13.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.13.0-rc1) |
| [List of changes for beta2 of eZ Platform v1.13.0 on Github](https://github.com/ezsystems/ezplatform/releases/tag/v1.13.0-beta2) | [List of changes for beta2 of eZ Platform Enterprise Edition v1.13.0 on Github](https://github.com/ezsystems/ezplatform-ee/releases/tag/v1.13.0-beta2) |

### Installation

[Installation Guide](../getting_started/install_ez_platform.md)

[Technical Requirements](../getting_started/requirements.md)

### Download

#### eZ Platform

- Download at [eZPlatform.com](http://ezplatform.com/#download)

#### eZ Enterprise

- [Customers: eZ Enterprise subscription (BUL License)](https://support.ez.no/Downloads)
- [Partners: Test & Trial software access (TTL License)](https://ez.no/Partner-Portal/Software-Downloads-Release-Info)

If you would like to request an eZ Enterprise Demo instance: <http://ez.no/Forms/Discover-eZ-Studio>

### Updating

To update to this version, follow the [Updating eZ Platform](../updating/updating_ez_platform.md) guide and use v1.13.0 as `<version>`.
