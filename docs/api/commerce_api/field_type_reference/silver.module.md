# silver.module

silver.module is a special Content Type that enables you to load specific controllers using a Content item.
silver.module defines a controller path and optionally parameters for this controller.
This provides a convenient opportunity to define custom, simple and translatable URLs using a silver.module name to any controller.

Following attributes are possible:

|Attribute name|Description|Example value|
|--- |--- |--- |
|Name|The name of the silver.module. It is shown on the frontend and is translatable.|"My test module", results in the URL: `/my-test-module`|
|Controller|The controller which should be loaded when clicking that module. Define the controller including the fully-qualified namespace and the controller method separated by two colons (`::`). The silver.module controller handler which loads the target controller automatically validates if the controller class and action method are available or throws an exception otherwise.|`\Silversolutions\Bundle\EshopBundle\Controller\CommonController::testAction`|
|Parameters|Optional parameters (list of hashes) which are directed to the target controller. Only string key-value pairs are possible. The key value pairs are separated by a semicolon (`;`)|Parameter key: `formTypeResolver`</br>Parameter value: `contact`|

## Functionality

`ezpublish.yml` contains a full view controller configuration for Content Type identifier `st_module`: `SilversolutionsEshopBundle:SilverModule:viewModuleLocation()`.

Within this controller the `loadControllerAction()` is called.
This method validates the controller value defined in the silver.module Content item
(is controller class available, is controller action available),
loads the target controller action and passes the current request and optional controller parameters to the target.

``` yaml
system:
    ezdemo_site_clean_group:
        location_view:
            full:
                silverModuleRuleset:
                    controller: SilversolutionsEshopBundle:SilverModule:viewModuleLocation
                    match:
                        Identifier\ContentType: [st_module]
```

!!! note

    The silver.module Content item is passed to the loaded controller together with the optional parameters.
