---
description: Use the ConfigResolver to inject dynamic configuration into your services.
saas_review:
    - siteaccess
    - links_removed
saas_review_note: >-
    Defines the ConfigResolver scope and namespace semantics that every SiteAccess-aware
    setting depends on. Confirm that the scope fallback order and the parameter naming
    stay accurate once SiteAccess configuration moves to a UI.

    Links to the deleted php_api.md page were removed; check that the surrounding text
    still reads correctly.
---

# Dynamic configuration

## ConfigResolver

Dynamic configuration is handled by the `ConfigResolverInterface`.

It exposes the `hasParameter()` and `getParameter()` methods.
You can use them to check the different *scopes* available for a given *namespace* to find the appropriate parameter.

To work with the ConfigResolver, your dynamic settings must have the following name format: `<namespace>.<scope>.parameter.name`.

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

Inside a controller extending the `Ibexa\Core\MVC\Symfony\Controller\Controller` class, in `site_group` SiteAccess, you can use the parameters in the following way (the same applies for `hasParameter()`):

!!! tip

    To learn more about scopes, see [SiteAccess documentation](multisite_configuration.md#scope).

Both `getParameter()` and `hasParameter()` can take three arguments:

1. `$paramName` - the name of the parameter
2. `$namespace` - your application namespace, `myapp` in the previous example. If null, the default namespace is used, which is `ibexa.site_access.config` by default.
3. `$scope` - a SiteAccess name. If null, the current SiteAccess is used.
