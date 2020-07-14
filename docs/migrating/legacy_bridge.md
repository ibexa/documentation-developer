# Legacy Bridge

Legacy Bridge integrates eZ Publish Legacy into eZ Platform.
It is an enhanced and optimized version of the LegacyBundle which was part of eZ Publish 5.x,
and it provides more features to simplify work on code migration to eZ Platform.

Legacy Bridge v1 is supported on eZ Platform 1.13LTS, and Legacy Bridge v2 is supported with 2.5LTS (recommended).

!!! note

    Legacy Bridge will _not_ be supported on eZ Platform v3
    due to future plans to enhance the storage engine and other parts of the architecture.

### Installation

The installation of Legacy Bridge is described in the bundle in [INSTALL.md.](https://github.com/ezsystems/LegacyBridge/blob/master/INSTALL.md)

#### Upgrade to 2.x

To upgrade from eZ Publish 5.x, or from eZ Platform 1.x with Legacy Bridge, see [Legacy Bridge upgrade doc](https://github.com/ezsystems/LegacyBridge/blob/master/doc/upgrade/2.0.md#from-1x-to-20) for smaller code adaptations.

### Features

Legacy Bridge contains all [Legacy code and features](https://doc.ez.no/display/EZP/Legacy+code+and+features) known from eZ Publish Platform 5.x to help you with migration.

In addition, it contains some performance improvements, and the following _new_ features:

#### `ezpublish:legacy:symlink`

The command `ezpublish:legacy:symlink` and corresponding composer script
enable you to maintain legacy settings/designs symlinks.

With this command you no longer need to check in the `ezpublish_legacy` folder to git, but can optionally use and check in the following instead:

- `src/legacy_files/settings/override`
- `src/legacy_files/settings/siteaccess`
- `src/legacy_files/design`

!!! tip

    For extensions, Legacy Bridge continues to support the [Legacy Bundles feature](https://doc.ez.no/display/EZP/Legacy+code+and+features#Legacycodeandfeatures-Legacybundles),
    which should be placed in `src/AppBundle/ezpublish_legacy` if they are project specific.

#### `ezpublish:legacy:init`

The command `ezpublish:legacy:init` enables you to configure a clean eZ Platform installation for Legacy Bridge usage.

It serves to set up a new clean legacy installation for demo or testing,
alternatively used to set up a working installation before migrating own data,
config and code over for upgrade.

#### Injecting supported DFS settings

Legacy Bridge offers support for injecting supported DFS settings from Platform to Legacy.

#### Other features

Besides the above, Legacy Bridge contains several bug fixes, smaller improvements and optimizations.
It also adds support for use with PHP 7.2-7.3, and eZ Platform 1.x/2.x.

### Limitations

All requests and commands need to go through eZ Platform in order for the bridge between the two systems to work.
This involves everything from cache to user sessions and search index.
The only thing not shared between the two systems is a database connection,
even if the database itself is shared. This means you need to close transactions
in one system before you can expect to read them in another system.

#### eZ product support limitations

Legacy is considered a supported add-on to eZ Platform, with limitations.
Support is thus limited by what legacy supported to begin with, and what is [supported](../getting_started/requirements.md) in combination with eZ Platform, and further
limited if used in conjunction with [eZ Platform Cloud](../getting_started/requirements.md#ez-platform-cloud-requirements-and-setup).

For example, S3 is not supported by eZ on legacy as the feature was never officially added to legacy,
even if it is now supported in eZ Platform.
However, it is possible to make it work by using unsupported community extensions
if you are comfortable with taking ownership of that, like of any other customization / integration.
