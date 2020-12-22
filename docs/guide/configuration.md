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

`config/packages/ezplatform.yaml` contains basic configuration (coming from [ezplatform-kernel](https://github.com/ezsystems/ezplatform-kernel)).
It stores, among others, [SiteAccess](siteaccess.md) information and content view config.

Other configuration is provided in respective files, e.g. `config/packages/ezplatform_admin_ui.yaml`,
`config/packages/ezplatform_http_cache.yaml`.

Configuration can be made environment-specific using separate folders for each environment.
These files contain additional settings and point to the general (not environment-specific) configuration that is applied in other cases.

!!! tip

    Read more about [how configuration is handled in Symfony](https://symfony.com/doc/5.0/best_practices/configuration.html).

### Configuration handling

!!! note

    Configuration is tightly related to the service container.
    To fully understand it, you need to be familiar with [Symfony's service container](service_container.md) and [its configuration](https://symfony.com/doc/5.0/service_container.html#service-parameters).

Basic configuration handling in [[= product_name =]] is similar to what is commonly possible with Symfony.
You can define key/value pairs in your configuration files.

Internally and by convention, keys follow a **dot syntax**, where the different segments follow your configuration hierarchy.
Keys are usually prefixed by a *namespace* corresponding to your application. All kinds of values are accepted, including arrays and deep hashes.

For configuration that is meant to be exposed to an end-user (or end-developer),
it's usually a good idea to also [implement semantic configuration.](https://symfony.com/doc/5.0/components/config/definition.html)

Note that you can also [implement SiteAccess-aware semantic configuration](siteaccess.md#exposing-siteaccess-aware-configuration-for-your-bundle).

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

- [Back Office configuration](config_back_office.md)
- [Repository configuration](config_repository.md)
- [Content views](content_rendering.md#configuring-views-the-viewprovider)
- [Multisite](multisite.md#configuring-multisite)
- [SiteAccess](siteaccess.md#configuring-siteaccesses)
- [Image variations](images.md#configuring-image-variations)
- [Logging and debug](devops.md#logging-and-debug-configuration)
- [Authentication](security.md#symfony-authentication)
- [Sessions](sessions.md#configuration)
- [Persistence cache](persistence_cache.md#configuration)
