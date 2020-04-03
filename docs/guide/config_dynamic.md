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

## Inject the ConfigResolver in your services

Instead of injecting the whole ConfigResolver service, you may directly [inject your SiteAccess-aware (dynamic) settings into your own services](#dynamic-settings-injection).

You can use the ConfigResolver in your own services whenever needed.
To do this, inject the `ezpublish.config.resolver` service:

``` yaml
parameters:
    my_service.class: App\Service
 
services:
    my_service:
        class: '%my_service.class%'
        arguments: ['@ezpublish.config.resolver']
```

``` php
namespace App;

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
