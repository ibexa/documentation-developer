---
description: In Ibexa DXP you store and manage configuration in project files, typically in YAML format.
---

# Configuration

[[= product_name =]] configuration is delivered using a number of dedicated configuration files.
It contains everything from selecting the content Repository to SiteAccesses to language settings.

### Configuration format

The recommended configuration format is YAML. It is used by default in the kernel (and in examples throughout the documentation).
However, you can also use XML or PHP formats for configuration.

### Configuration files

Configuration files are located in the `config` folder.
Configuration is provided per package in the `config/packages` folder,
and routes are defined per package in `config/routes`.

`config/packages/ibexa.yaml` contains basic configuration.
It stores, among others, [SiteAccess](multisite.md) information and content view config.

Other configuration is provided in respective files, e.g. `config/packages/ibexa_admin_ui.yaml`,
`config/packages/ibexa_http_cache.yaml`.

Configuration can be made environment-specific using separate folders for each environment.
These files contain additional settings and point to the general (not environment-specific) configuration that is applied in other cases.

!!! tip

    Read more about [how configuration is handled in Symfony]([[= symfony_doc =]]/best_practices/configuration.html).

### Configuration handling

!!! note

    Configuration is tightly related to the [service container](php_api.md#service-container).
    To fully understand it, you must be familiar with the service container and [its configuration]([[= symfony_doc =]]/service_container.html#service-parameters).

Basic configuration handling in [[= product_name =]] is similar to what is commonly possible with Symfony.
You can define key/value pairs in your configuration files.

Internally and by convention, keys follow a *dot syntax*, where the different segments follow your configuration hierarchy.
Keys are usually prefixed by a *namespace* corresponding to your application. All kinds of values are accepted, including arrays and deep hashes.

For configuration that is meant to be exposed to an end-user (or end-developer),
it's usually a good idea to also [implement semantic configuration.]([[= symfony_doc =]]/components/config/definition.html)

Note that you can also [implement SiteAccess-aware semantic configuration](siteaccess_aware_configuration.md).

For example:

``` yaml
parameters:
    myapp.parameter.name: someValue
    myapp.boolean.param: true
    myapp.some.hash:
        foo: bar
        an_array: [apple, banana, pear]
```

``` php
// Usage inside a controller
$myParameter = $this->container->getParameter( 'myapp.parameter.name' );
```

## Configuration settings

For specific configuration settings, see:

- [Back Office configuration](back_office_configuration.md)
- [Repository configuration](repository_configuration.md)
- [Content views](template_configuration.md)
- [Multisite configuration](multisite_configuration.md)
- [Image variations](images.md#configuring-image-variations)
- [Logging and debug](devops.md#logging-and-debug-configuration)
- [Authentication](development_security.md#symfony-authentication)
- [Sessions](sessions.md#configuration)
- [Persistence cache](persistence_cache.md#persistence-cache-configuration)
