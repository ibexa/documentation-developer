---
description: Configure a custom Remote PIM integration for the product catalog.
---

# Add Remote PIM support

[[= product_name =]] provides flexible product catalog infrastructure that works with external Product Information Management (PIM) systems.
For advanced product data management without custom development, you can use the readily available [[[= pim_product_name =]] integration](quable/quable.md) with [[= product_name =]].

To implement [Remote PIM support](product_catalog_guide.md#remote-pim-support) for a custom integration, you can build upon a foundation provided by [[= product_name_base =]].

While doing so, you must implement services that process data coming from the remote PIM.

Before you create your own solution, you can use the `ibexa/example-in-memory-product-catalog` example implementation and modify it to connect to your external data source.

## Implement services

To connect to your remote PIM, provide your implementation of the following services that process product data:

- AssetService, used to get assets assigned to a product.
- AttributeDefinitionService, used to get information about product attributes.
- AttributeGroupService, used to get information about product attribute groups.
- ProductService, used to get product information.
- ProductTypeService, used to work with product types.

## Switch to the new product catalog engine

To inform the application that the product catalog engine has been replaced by an external one, set the new product catalog engine, for example:

``` yaml
ibexa_product_catalog:
    engines:
        <custom_PIM_name>:
            type: <custom_PIM_name>
            options:
                root_location_remote_id: ibexa_product_catalog_root
```

Then configure the application to use the engine defined above as the default product data repository:

``` yaml
ibexa:
    repositories:
        <repository_name>:
            # ...
            product_catalog:
                engine: <custom_PIM_name>
```

!!! note "Enabling the remote PIM support"

    By default, the `ibexa.repositories.<repository_name>.product_catalog.engine.type` key is set to `local`, which informs [[= product_name =]] that the built-in product catalog capabilities are used.
    By changing this setting and the `ibexa.repositories.<repository_name>.product_catalog.engine` setting from `default` to your custom value, you inform [[= product_name =]] that you're using a remote PIM.
