---
description: Make sure your custom development's configuration can be used with SiteAccesses.
---

# SiteAccess-aware configuration

The [Symfony Config component]([[= symfony_doc =]]/components/config.html) makes it possible to define semantic configuration, exposed to the end developer.
This configuration is validated by rules you define, for example, validating type (string, array, integer, boolean, and more).
Usually, after it's validated and processed, this semantic configuration is then mapped to internal *key/value* parameters stored in the service container.

[[= product_name =]] uses this for its core configuration, but adds another configuration level, the SiteAccess.
For each defined SiteAccess, you need to be able to use the same configuration tree to define SiteAccess-specific config.

These settings then need to be mapped to SiteAccess-aware internal parameters that you can retrieve with the [ConfigResolver](dynamic_configuration.md#configresolver).
For this, internal keys need to follow the format `<namespace>.<scope>.<parameter_name>`. where:

- `namespace` is specific to your app or bundle
- `scope` is the SiteAccess, SiteAccess group, `default` or `global`
- `parameter_name` is the actual setting *identifier*

For more information about the ConfigResolver, namespaces and scopes, see [configuration basics](configuration.md).
