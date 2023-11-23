---
description: Install and configure the Remote PIM example package.
---

# Add Remote PIM support

To implement [Remote PIM support](pim_guide.md#remote-pim-support) you can build upon a foundation provided by [[= product_name_base =]].
You can install the example package and modify it to connect to your external data source.

## Install Remote PIM example package

Before you can create a custom implementation of Remote PIM support, you must install the example package first and configure [[= product_name =]] to use an external source of product information.

In a real-life application, you replace its contents with custom code that connects to your remote product data source.

Install the `ibexa/example-in-memory-product-catalog` package:

``` bash
composer config repositories.remote-pim vcs https://github.com/ibexa/example-in-memory-product-catalog
composer require ibexa/example-in-memory-product-catalog:~4.6.0@dev
```

## Switch to the new product catalog engine

To let the application know that the local PIM engine has been replaced by an external one, in `config/packages/ibexa_product_catalog.yaml`, set the new product catalog engine, for example:

``` yaml
ibexa_product_catalog:
    engines:
        in_memory:
            type: in_memory
            options:
                root_location_remote_id: ibexa_product_catalog_root
```

Then configure the application to use the engine defined above as the default product data repository:

``` yaml
ibexa:
    repositories:
        default:
            # ...
            product_catalog:
                engine: in_memory
```

## Implement services

Replace the default services that process product data with services that check in the configuration, which product data engine should be used.
The example implementation provides the following services that replace the ones present in the local PIM package.
You can modify them to suit your needs.

- AssetService, used to get assets assigned to a product.
- AttributeDefinitionService, used to get information about product attributes.
- AttributeGroupService, used to get information about product attribute groups.
- ProductService, used to get product information.
- ProductTypeService, used to work with product types.

## Implement the data provider

Create a data provider library that sources product data from your remote system.
The example implementation uses the `DataProvider.php` library, which acts as a generator of faux products.
Each product has a product ID, name and description.

You must modify or replace the library with an interface with the data source of your choice.

The data set in the example is limited, for example, no product thumbnails are available, which results in displaying placeholders on the product list.
You could extend your implementation, by using the `ProductService` [service](product_api.md) to pull thumbnails from an external source, for example, a CDN like Fastly.