# Configuration

eZ Platform configuration is delivered using a number of dedicated configuration files.
It contains everything from selecting the content Repository to SiteAccesses to language settings.

### Configuration format

The recommended configuration format is YAML. It is used by default in the kernel (and in examples throughout the documentation).
However, you can also use XML or PHP formats for configuration.

### Configuration files

Main configuration files are located in the `app/config` folder.

- `parameters.yml` contains infrastructure-related configuration. It is created based on the default settings defined in `parameters.yml.dist`.
- `config.yml` contains configuration stemming from Symfony and covers settings such as search engine or cache configuration.
- `ezplatform.yml` contains general configuration that is specific for eZ Platform, like for example SiteAccess settings.
- `security.yml` is the place for security-related settings.
- `routing.yml` defines routes that will be used throughout the application.

Configuration can be made environment-specific using separate files for each environment.
These files contain additional settings and point to the general (not environment-specific) configuration that is applied in other cases.

!!! tip

    Read more about [how configuration is handled in Symfony](https://symfony.com/doc/3.4/best_practices/configuration.html).

### Configuration handling

!!! note

    Configuration is tightly related to the service container.
    To fully understand it, you need to be familiar with [Symfony's service container](service_container.md) and [its configuration](https://symfony.com/doc/3.4/service_container.html#service-parameters).

Basic configuration handling in eZ Platform is similar to what is commonly possible with Symfony.
You can define key/value pairs in your configuration files.

Internally and by convention, keys follow a **dot syntax**, where the different segments follow your configuration hierarchy.
Keys are usually prefixed by a *namespace* corresponding to your application. All kinds of values are accepted, including arrays and deep hashes.

For configuration that is meant to be exposed to an end-user (or end-developer),
it's usually a good idea to also [implement semantic configuration](https://symfony.com/doc/3.4/components/config/definition.html).

Note that you can also [implement SiteAccess-aware semantic configuration](../cookbook/exposing_siteaccess_aware_configuration_for_your_bundle.md).

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
- [Multi-file upload](file_management.md#multi-file-upload)
- [Logging and debug](devops.md#logging-and-debug-configuration)
- [Authentication](security.md#symfony-authentication)
- [Sessions](sessions.md#configuration)
- [Persistence cache](persistence_cache.md#configuration)
