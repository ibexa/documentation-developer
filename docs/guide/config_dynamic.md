# Dynamic configuration

## ConfigResolver

Dynamic configuration is handled by a **ConfigResolver**.

It exposes the `hasParameter()` and `getParameter()` methods.
You can use them to check the different *scopes* available for a given *namespace* to find the appropriate parameter.

In order to work with the ConfigResolver, your dynamic settings must have the following name format: `<namespace>.<scope>.parameter.name`.

``` yaml
parameters:
    # Internal configuration
    ezsettings.default.content.default_ttl: 60
    ezsettings.site_group.content.default_ttl: 3600
 
    # Here "myapp" is the namespace, followed by the SiteAccess name as the parameter scope
    # Parameter "my_param" will have a different value in site_group and admin_group
    myapp.site_group.my_param: value
    myapp.admin_group.my_param: another value
    # Defining a default value, for other SiteAccesses
    myapp.default.my_param: Default value
```

Inside a controller, in `site_group` SiteAccess, you can use the parameters in the following way
(note that the same applies for `hasParameter()`):

``` php
$configResolver = $this->getConfigResolver();
 
// ezsettings is the default namespace, so no need to specify it
// The following will resolve ezsettings.<siteaccessName>.content.default_ttl
// In the case of site_group, it will return 3600.
// Otherwise it will return the value for ezsettings.default.content.default_ttl (60)
$locationViewSetting = $configResolver->getParameter( 'content.default_ttl' );

// For you own namespace, you need to specify it, here as "myapp"
$myParamSetting = $configResolver->getParameter( 'my_param', 'myapp' );
// $myParamSetting's value will be 'value'
 
// You can also force the scope by naming it explicitly (here as "admin_group")
$myParamSettingAdmin = $configResolver->getParameter( 'my_param', 'myapp', 'admin_group' );
// $myParamSetting's value will be 'another value'
```

!!! tip

    To learn more about scopes, see [SiteAccess documentation](siteaccess.md#scope).

Both `getParameter()` and `hasParameter()` can take three arguments:

1. `$paramName` - the name of the parameter
2. `$namespace` - your application namespace, `myapp` in the previous example. If null, the default namespace will be used, which is `ezsettings` by default.
3. `$scope` - a SiteAccess name. If null, the current SiteAccess will be used.


!!! note

    In debug mode, ConfigResolver detects if parameters were loaded prior to initialization of SiteAccess to warn about issues.
    It will log all instances of `getParameter()` that may be used unsafely.
    
    If a problem occurs, you will receive a warning that ConfigResolver had been used to load parameter `languages`
    before SiteAccess was loaded by services: `my.own.service` and `ez.service.used.too.early`.
       
    To avoid such issues:
    
    - Avoid eager usage of config resolver (e.g. in service factories).
    - Instead of using `ctor('$dynamic_param$')`, use `(setter('$dynamic_param$'))` as it allows the system to update your service with changes on scope changes.
    - Load the parameter lazily by injecting ConfigResolver, and get the parameter from it _when_ you need to instead of during construction.
    - Try using [lazy commands](https://symfony.com/doc/3.4/console/lazy_commands.html).
    - Try configuring [lazy services](https://symfony.com/doc/3.4/service_container/lazy_services.html).

## Inject the ConfigResolver in your services

Instead of injecting the whole ConfigResolver service, you may directly [inject your SiteAccess-aware (dynamic) settings into your own services](#dynamic-settings-injection).

You can use the ConfigResolver in your own services whenever needed.
To do this, inject the `ezpublish.config.resolver` service:

``` yaml
parameters:
    my_service.class: Acme\ExampleBundle\Service
 
services:
    my_service:
        class: '%my_service.class%'
        arguments: ['@ezpublish.config.resolver']
```

``` php
namespace Acme\ExampleBundle;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
 
class Service
{
    /**
     * @var \eZ\Publish\Core\MVC\ConfigResolverInterface
     */
    private $configResolver;
 
    public function __construct( ConfigResolverInterface $configResolver )
    {
        $this->configResolver = $configResolver;
        $myParam = $this->configResolver->getParameter( 'my_param', 'myapp' );
    }
}
```

## Dynamic settings injection

When implementing a service which needs SiteAccess-aware settings (e.g. language settings),
you can inject these dynamic settings explicitly from their service definition.

### Syntax

Static container parameters follow the `%<parameter_name>%` syntax in Symfony.

Dynamic parameters have the following: `$<parameter_name>[; <namespace>[; <scope>]]$`.
Default namespace is `ezsettings`, and default scope is the current SiteAccess.

For more information, see [ConfigResolver](#configresolver).

### DynamicSettingParser

The *DynamicSettingParser* service can be used for adding support of the dynamic settings syntax.
This service has `ezpublish.config.dynamic_setting.parser` for ID and implements `eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\DynamicSettingParserInterface`.

### Limitations

- It is not possible to use dynamic settings in your semantic configuration (e.g. `config.yml` or `ezplatform.yml`) as they are meant primarily for parameter injection in services.
- It is not possible to define an array of options having dynamic settings. They will not be parsed. Workaround is to use separate arguments/setters.
- Injecting dynamic settings in request listeners is **not recommended**, as it won't be resolved with the correct scope
(request listeners are instantiated before SiteAccess match).
Workaround is to inject the ConfigResolver instead, and resolve the setting in your `onKernelRequest` method (or equivalent).

### Examples

#### Injecting an eZ parameter

Defining a simple service needing a `languages` parameter (that is, prioritized languages).

!!! note

    Internally, the `languages` parameter is defined as `ezsettings.<siteaccess_name>.languages`.
    `ezsettings` is the internal eZ namespace.

#### Using setter injection (preferred)

``` yaml
parameters:
    acme_example.my_service.class: Acme\ExampleBundle\MyServiceClass

services:
    acme_example.my_service:
        class: '%acme_example.my_service.class%'
        calls:
            - [setLanguages, ['$languages$']]
```

``` php
namespace Acme\ExampleBundle;

class MyServiceClass
{
    /**
 * Prioritized languages
 *
 * @var array
 */
    private $languages;

    public function setLanguages( array $languages = null )
    {
        $this->languages = $languages;
    }
}
```

!!! caution

    Ensure you always add `null` as a default value, especially if the argument is type-hinted.

#### Using constructor injection

``` yaml
parameters:
    acme_example.my_service.class: Acme\ExampleBundle\MyServiceClass

services:
    acme_example.my_service:
        class: '%acme_example.my_service.class%'
        arguments: ['$languages$']
```

``` php
namespace Acme\ExampleBundle;

class MyServiceClass
{
    /**
 * Prioritized languages
 *
 * @var array
 */
    private $languages;

    public function __construct( array $languages )
    {
        $this->languages = $languages;
    }
}
```

!!! tip

    Setter injection for dynamic settings should always be the preferred method. It enables you to update your services that depend on it when ConfigResolver is updating its scope (e.g. when previewing content in a given SiteAccess). **However, only one dynamic setting should be injected by setter**.

    **Constructor injection will make your service be reset in that case.**

#### Injecting third party parameters

``` yaml
parameters:
    acme_example.my_service.class: Acme\ExampleBundle\MyServiceClass
    # "acme" is our parameter namespace.
    # Null is the default value.
    acme.default.some_parameter: ~
    acme.site_group.some_parameter: value
    acme.admin_group.some_parameter: another value
 
services:
    acme_example.my_service:
        class: '%acme_example.my_service.class%'
        # The following argument will automatically resolve to the right value, depending on the current SiteAccess.
        # We specify "acme" as the namespace we want to use for parameter resolving.
        calls:
            - [setSomeParameter, ['$some_parameter;acme$']]
```

``` php
namespace Acme\ExampleBundle;
class MyServiceClass
{
    private $myParameter;
    public function setSomeParameter( $myParameter = null )
    {
        // Will be "value" for site_group, "another value" for admin_group, or null if another SiteAccess.
        $this->myParameter = $myParameter;
    }
}
```
