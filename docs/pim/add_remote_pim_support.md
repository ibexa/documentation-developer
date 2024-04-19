---
description: Install and configure the Remote PIM example package.
---

# Add Remote PIM support

To implement [Remote PIM support](pim_guide.md#remote-pim-support) you can build upon a foundation provided by [[= product_name_base =]].

While doing so, you must implement services that process data coming from the remote PIM.

Before you create your own solution, you can [install an example package](#install-remote-pim-example-package) and modify it to connect to your external data source.

## Implement services

To connect to your remote PIM, provide your implementation of the following services that process product data:

- AssetService, used to get assets assigned to a product.
- AttributeDefinitionService, used to get information about product attributes.
- AttributeGroupService, used to get information about product attribute groups.
- ProductService, used to get product information.
- ProductTypeService, used to work with product types.

## Switch to the new product catalog engine

To inform the application that the local PIM engine has been replaced by an external one, in `config/packages/ibexa_product_catalog.yaml`, set the new product catalog engine, for example:

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

    By default, the `ibexa.repositories.<repository_name>.product_catalog.engine.type` key is set to `local`, which informs [[= product_name =]] that the built-in PIM solution is used.
    By changing this setting, as well as changing the `ibexa.repositories.<repository_name>.product_catalog.engine` setting from `default` to your custom value, you inform [[= product_name =]] that you are using a remote PIM.

## Install Remote PIM example package

The example implementation provides services that take over the role of services provided by the local PIM package.
You can modify them to suit your needs.

Install the `ibexa/example-in-memory-product-catalog` package:

``` bash
composer config repositories.remote-pim vcs https://github.com/ibexa/example-in-memory-product-catalog
composer require ibexa/example-in-memory-product-catalog:
```

