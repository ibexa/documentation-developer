---
description: Ibexa DXP v4.4 adds the improvements to the Customer Portal, PIM and SEO.
---

# Ibexa DXP v4.4

**Version number**: v4.4

**Release date**: January 27, 2023

**Release type**: [Fast Track](https://support.ibexa.co/Public/service-life)

**Update**: [v4.3.x to v4.4](https://doc.ibexa.co/en/4.4/update_and_migration/from_4.3/update_from_4.3/)

## Notable changes

## Other changes

### Flysystem v2

We have made significant upgrades to the codebase to rely on Flysystem v2.
Our Flysystem Adapter implementation now supports dynamic paths
described by complex settings resolvable for the SiteAccess context.
For more information, see [Configuring the DFS IO handler](clustering.md#configuring-the-dfs-io-handler).

If your custom project relies directly on a Flysystem features instead of using our IO abstraction,
it will require an upgrade as well,
using [these instructions](https://flysystem.thephpleague.com/docs/upgrade-from-1.x/).

### Dedicated migration type for companies

To simplify data migration, you can now create a company with underling objects such as members group and address book.
You can also extract those objects as references. 
For more information on data migration actions, see [documentation](data_migration_actions.md).

### API improvements

### Deprecations

- Support for overwriting existing files has been dropped (catch block of `\Ibexa\Core\IO\IOBinarydataHandler\Flysystem::create` and test). The new native Flysystem v2 Local Adapter performs this out of the box.
- Support for no last modified timestamp has been dropped (in the form of a test case). The new Flysystem v2 throws `UnableToRetrieveMetadata` exception in such case.

## Full changelog

| Ibexa Content          | Ibexa Experience          | Ibexa Commerce          |
|------------------------|---------------------------|-------------------------|
| [Ibexa Content v4.4]() | [Ibexa Experience v4.4]() | [Ibexa Commerce v4.4]() |
