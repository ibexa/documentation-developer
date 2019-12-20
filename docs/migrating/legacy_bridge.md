# Legacy Bridge

Legacy Bridge integrates eZ Publish Legacy into eZ Platform. It is an enhanced & optimized version of LegacyBundle that where part of eZ Publish 5.x,
providing some more features to simplify work on code migration to eZ Platform.

Legacy Bridge v1 is supported on eZ Platform 1.13LTS, and Legacy Bridge v2 is supported with 2.5LTS _(recommended)_.
_NOTE: Will not be supported on eZ Platform v3 due to future plans to enhance storage engine and other parts of the architecture._


### Installation

Installation is described in the bundle in [INSTALL.md](https://github.com/ezsystems/LegacyBridge/blob/1.5/INSTALL.md).

#### Upgrade to 2.x

When upgrading from eZ Publish 5.x, or from eZ Platform 1.x + legacy bridge, see [doc/upgrade/2.0.md](https://github.com/ezsystems/LegacyBridge/blob/master/doc/upgrade/2.0.md#from-1x-to-20) for smaller code adaptions.


### Features

Legacy bridge contains all [Legacy code and features](https://doc.ez.no/display/EZP/Legacy+code+and+features) known from eZ Publish Platform 5.x to help you in your migration needs.

In addition it contains the following features:
- Command `ezpublish:legacy:symlink` and corresponding composer script to maintain legacy settings/designs symlinks
  With this command you no longer need to checkin `ezpublish_legacy` folder to Git, but can optionally use and checkin the following instead:
  - `src/legacy_files/settings/override`
  - `src/legacy_files/settings/siteaccess`
  - `src/legacy_files/design`
  _Tip: For extensions Legacy Bridge continues to support [Legacy Bundles feature](https://doc.ez.no/display/EZP/Legacy+code+and+features#Legacycodeandfeatures-Legacybundles), i.e. place in `src/AppBundle/ezpublish_legacy` if they are project specific._
- Command `ezpublish:legacy:init` to configure clean eZ Platform install for legacy bridge usage
  _To setup a new clean legacy install for demo or testing, alternatively used to setup working install before migrating own data, config and code over for upgrade._
- Support injecting supported DFS Settings from Platform to Legacy

_Besides those is contains several bug fixes, smaller improvements, optimizations, and it also adds support for use with PHP 7.2- 7.3, and eZ Platform 1.x/2.x._


### Limitations

All requests and commands needs to go true eZ Platform in order for the bridge between the two systems to work, this involves everything from cache, user sessions and search index. The only thing not shared between the two systems is a database connection, even if the database itself is shared this means you need to close transactions in one system before you can expect to read it in the other system.

#### eZ product support limitations

Legacy is considered as a supported add-on to eZ Platform, with limitations.
Support is thus limited by what legacy supported to begin with, and what is [supported](../getting_started/requirements.md) in combination with eZ Platform, and further
limited if used in conjunction with [eZ Platform Cloud](../getting_started/requirements.md#ez-platform-cloud-requirements-and-setup).

For example S3 is not supported by eZ on legacy as the feature was never added to legacy officially, even if it is now supported in eZ Platform.
However it is possible to make it work by using unsupported community extensions if you are comfortable taking ownership over that, like any other customisation/integration.
