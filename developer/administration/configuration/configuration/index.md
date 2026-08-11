# Configuration

In Ibexa DXP you store and manage configuration in project files, typically in YAML format.

Ibexa DXP configuration is delivered by means of a number of dedicated configuration files. It contains everything from selecting the content repository to SiteAccesses to language settings.

## Configuration format

The recommended configuration format is YAML. It's used by default in the kernel (and in examples throughout the documentation). However, you can also use XML or PHP formats for configuration.

## Configuration files

Configuration files are located in the `config` folder. Configuration is provided per package in the `config/packages` folder, and routes are defined per package in `config/routes`.

`config/packages/ibexa.yaml` contains basic configuration. It stores, among others, [SiteAccess](../../../multisite/multisite/index.md) information and content view config.

Other configuration is provided in respective files, for example, `config/packages/ibexa_admin_ui.yaml`, `config/packages/ibexa_http_cache.yaml`.

You can make configuration environment-specific by using separate folders for each environment. These files contain additional settings and point to the general (not environment-specific) configuration that is applied in other cases.

> **Note: New configuration files**
>
> It's good practice to provide your own configuration in separate files. Any YAML files placed in the `config/packages` folder is automatically included in the system configuration.

> **Tip: Tip**
>
> Read more about [how configuration is handled in Symfony](https://symfony.com/doc/7.4/best_practices.html#configuration).

> **Caution: Special characters**
>
> Avoid using special characters in your configuration files. More specifically, don't use Unicode characters from the ["Other" (`C`) categories](https://en.wikipedia.org/wiki/Unicode#General_Category_property), such as control or format characters.
>
> Make sure your IDE displays them.
>
> Be careful when copy-pasting text from a word processing software or a PDF, because it might contain hidden characters like the [soft hyphen](https://en.wikipedia.org/wiki/Soft_hyphen).

## Configuration handling

> **Note: Note**
>
> Configuration is tightly related to the [service container](../../../api/php_api/php_api/index.md#service-container). To fully understand it, you must be familiar with the service container and [its configuration](https://symfony.com/doc/7.4/service_container.html#service-parameters).

Basic configuration handling in Ibexa DXP is similar to what is commonly possible with Symfony. You can define key/value pairs in your configuration files.

Internally and by convention, keys follow a *dot syntax*, where the different segments follow your configuration hierarchy. Keys are usually prefixed by a *namespace* corresponding to your application. All kinds of values are accepted, including arrays and deep hashes.

For configuration that is meant to be exposed to an end-user (or end-developer), it's usually a good idea to also [implement semantic configuration](https://symfony.com/doc/7.4/components/config/definition.html).

You can also [implement SiteAccess-aware semantic configuration](../../../multisite/siteaccess/siteaccess_aware_configuration/index.md).

For example:

```yaml
parameters:
    myapp.parameter.name: someValue
    myapp.boolean.param: true
    myapp.some.hash:
        foo: bar
        an_array: [apple, banana, pear]
```

```php
// Usage inside a controller
/** @var \Symfony\Component\DependencyInjection\ContainerInterface $container */
$myParameter = $container->getParameter('myapp.parameter.name');
```

## Configuration settings

For specific configuration settings, see:

- [Back office configuration](../../back_office/back_office_configuration/index.md)
- [Repository configuration](../repository_configuration/index.md)
- [Content views](../../../templating/templates/template_configuration/index.md)
- [Multisite configuration](../../../multisite/multisite_configuration/index.md)
- [Image variations](../../../content_management/images/images/index.md#configuring-image-variations)
- [Logging and debug](../../../infrastructure_and_maintenance/devops/index.md#logging-and-debug-configuration)
- [Authentication](../../../infrastructure_and_maintenance/security/development_security/index.md#symfony-authentication)
- [Sessions](../../../infrastructure_and_maintenance/sessions/index.md#configuration)
- [Persistence cache](../../../infrastructure_and_maintenance/cache/persistence_cache/index.md#persistence-cache-configuration)
