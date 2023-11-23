---
description: Install and configure the Remote PIM example package.
---

# Add Remote PIM support

To implement Remote PIM support you can build upon a foundation provided by [[= product_name_base =]].
You can install the example package and modify it to connect to your external data source.

## Install Remote PIM

Before you can build upon the foundation provided by the Remote PIM package, you must install it first and configure [[= product_name =]] to use an external source of product information.

The package provides the `DataProvider.php` library, which acts as a generator of faux products, where each product has a product ID, name and description.
In a real-life application, you replace it with a connector to your remote product data source.

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
The example implementation provides the following services that replace the ones used in the local PIM.
You can modify them to suit your needs.

- AssetService, used to get assets assigned to a product.
- AttributeDefinitionService, used to get information about product attributes.
- AttributeGroupService, used to get information about product attribute groups.
- ProductService, used to get product information.
- ProductTypeService, used to work with product types.

## Implement the data provider

Create a data provider library that sources product data them your remote system.
The example implementation uses the `DataProvider.php` library that generates a series of faux products.
You must modify or replace it with an interface with the data source of your choice.

The data set in the example is limited, for example, no product thumbnails are available, which results in displaying placeholders on the product list.
In your implementation, you can the `ProductService` to pull thumbnails from an external source, for example, a CDN like Fastly.