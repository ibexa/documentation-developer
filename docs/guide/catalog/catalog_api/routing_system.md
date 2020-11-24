# Routing system [[% include 'snippets/commerce_badge.md' %]]

[[= product_name_com =]] uses its own routing/URL matching solution to avoid conflicting with the [[= product_name =]] routing system
and to enable using Platform API in commerce routes.

!!! note

    If a product URL is not routed correctly (e.g. because of complex matching rules)
    it is possible to set up a direct routing for products.
    The first part of the URL (here `products`) could be translated, and in this case, the following routing rules have to be set up for each translation.

    ``` yaml
    product_route:
        path: /products/{url}
        defaults:
            _controller: SilversolutionsEshopBundle:Catalog:show
            url: /
        requirements:
            url: ".+"
    ```

## Default router

The default router (`Silversolutions\Bundle\EshopBundle\Routing\StandardRouter`) checks each requested URL.

If the URL belongs to a [catalog element](catalog_element.md) or a [silver module](../../../api/commerce_api/field_type_reference/silver.module.md),
the router becomes active and redirects the user to the appropriate controller.

This router is a derived class from a chained router implementation. It attempts to match the URL to its own specifications.
If it cannot find a matching route, it passes the request back to the router chain in order to leave matching to another instance.

Route matching priority:

1. If the request is in legacy mode, return and leave route matching to another instance.
2. Assume the request of a catalog object and try to find a responsible route using the catalog data provider.
3. Assume the request of a catalog object and try to find a route using the navigation service.
4. Assume the request of a `silver.module` object and try to find a route using the navigation service.
5. Assume the request of a PIM object and try to find a route using the catalog data provider.
6. Assume the request of a PIM object and try to find a route using the navigation service.
7. If no route can be found at all, the route matching is left to another instance.

### Priority

The router is defined with the priority of 280, so you can still add your own chain router that is executed before it.

``` xml
<parameter key="ses_routers.standard_router.class">Silversolutions\Bundle\EshopBundle\Routing\StandardRouter</parameter>

<!-- routers -->
<service id="ses_routers.standard_router" class="%ses_routers.standard_router.class%">
    <argument type="service" id="ezpublish.api.service.location"/>
    <argument type="service" id="ezpublish.api.service.url_alias"/>
    <argument type="service" id="ezpublish.api.service.content"/>
    <argument type="service" id="ezpublish.urlalias_generator"/>
    <argument type="service" id="router.request_context" />
    <argument type="service" id="logger" />
    <call method="setConfigResolver">
        <argument type="service" id="ezpublish.config.resolver.chain"/>
    </call>
    <call method="setServices">
        <argument type="service" id="siso_core.catalog_helper" />
    </call>
    <tag name="router" priority="280" />
</service>
```

## Usage of the navigation service

In order to determine whether a URL belongs to the catalog or [silver module](../../../api/commerce_api/field_type_reference/silver.module.md),
the navigation service or the [catalog data provider](../../data_providers/access_dataprovider_via_php.md) is used.

Additionally, the router uses the navigation service in order to set the [URL Mapping](../../data_providers/access_dataprovider_via_php.md) and set the proper URL.
