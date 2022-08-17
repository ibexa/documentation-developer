---
description: Use the ConfigResolver to inject dynamic configuration into your services.
---

# Dynamic configuration

## ConfigResolver

Dynamic configuration is handled by a ConfigResolver.

It exposes the `hasParameter()` and `getParameter()` methods.
You can use them to check the different *scopes* available for a given *namespace* to find the appropriate parameter.

In order to work with the ConfigResolver, your dynamic settings must have the following name format: `<namespace>.<scope>.parameter.name`.

``` yaml
parameters:
    # Internal configuration
    ibexa.site_access.config.default.content.default_ttl: 60
    ibexa.site_access.config.site_group.content.default_ttl: 3600
 
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
 
// ibexa.site_access.config is the default namespace, so no need to specify it
// The following will resolve ibexa.site_access.config.<siteaccessName>.content.default_ttl
// In the case of site_group, it will return 3600.
// Otherwise it will return the value for ibexa.site_access.config.default.content.default_ttl (60)
$locationViewSetting = $configResolver->getParameter( 'content.default_ttl' );

// For you own namespace, you need to specify it, here as "myapp"
$myParamSetting = $configResolver->getParameter( 'my_param', 'myapp' );
// $myParamSetting's value will be 'value'
 
// You can also force the scope by naming it explicitly (here as "admin_group")
$myParamSettingAdmin = $configResolver->getParameter( 'my_param', 'myapp', 'admin_group' );
// $myParamSetting's value will be 'another value'
```

!!! tip

    To learn more about scopes, see [SiteAccess documentation](multisite_configuration.md#scope).

Both `getParameter()` and `hasParameter()` can take three arguments:

1. `$paramName` - the name of the parameter
2. `$namespace` - your application namespace, `myapp` in the previous example. If null, the default namespace will be used, which is `ibexa.site_access.config` by default.
3. `$scope` - a SiteAccess name. If null, the current SiteAccess will be used.

## Inject ConfigResolver into services

You can use the ConfigResolver in your own services whenever needed.
To do this, inject the `ibexa.config.resolver` service:

``` yaml
services:
    App\Service:
        arguments: ['@ibexa.config.resolver']
```

You can also use the [autowire feature]([[= symfony_doc =]]/service_container/autowiring.html), by type hinting against ConfigResolverInterface.

!!! tip

    For more information about dependency injection, see [Service container](php_api.md#service-container).

!!! note

    Do not store the retrieved config value unless you know what you are doing. 
    SiteAccess can change during code execution, which means you might work on the wrong value.

``` php
namespace App;

use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
 
class Service
{
    /**
     * @var \Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface
     */
    private $configResolver;
 
    public function __construct( ConfigResolverInterface $configResolver )
    {
        $this->configResolver = $configResolver;
    }
    
    public function someMethodThatNeedConfig()
    {
        $configValue = $this->configResolver->getParameter('my_param', 'myapp');
    }
}
```
