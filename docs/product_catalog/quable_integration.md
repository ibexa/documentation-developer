---
description: Integrate Quable PIM with Ibexa DXP 
---

# Quable PIM Integration

[[= product_name =]] integrates with **Quable PIM** to provide enterprise-grade product information management capabilities.

Quable is Ibexa's recommended PIM solution, offering advanced features for managing complex product catalogs, digital assets, and multi-channel product experiences.

## Why Quable?

Quable PIM is a leading Product Information Management solution that seamlessly integrates with [[= product_name =]]'s product catalog capabilities. This partnership enables you to:

- **Centralize product data** - Manage all product information in one place
- **Streamline workflows** - Coordinate product data across teams and systems
- **Accelerate time-to-market** - Publish product information faster across all channels
- **Ensure data quality** - Maintain consistent, accurate product information
- **Scale globally** - Support multi-language, multi-region product catalogs

## Integration Approach

[[= product_name =]] provides robust [product catalog capabilities](product_catalog.md) that work with any PIM system, including:

- Product types and variants
- Attributes and specifications
- Pricing and availability management
- Catalog organization and filtering
- Product search and discovery

These capabilities form the foundation that enables seamless integration with Quable PIM through the [remote PIM support](add_remote_pim_support.md) framework.

## Install Quable connector

To integrate [[= product_name =]] with Quable PIM, you need to install the Quable connector packages and configure the connection.

### Install packages

Run the following commands to install the required packages:

``` bash
composer require ibexa/quable-client
composer require ibexa/connector-quable
```

These commands add the Quable connector code, including services that enable communication with the Quable PIM system.

### Get API credentials

To connect to Quable PIM, you need an API token:

1. Log in to your Quable instance (for example, `https://sandbox-ibexa-connector.quable.com`).

2. Navigate to the **Tokens** section at `https://sandbox-ibexa-connector.quable.com/#tokens`.

3. Locate or create a **Read Access Token**.

4. Copy the token value for use in the configuration.

!!! note "Instance URL"

    If you're using a different Quable instance, replace the sandbox URL with your organization's Quable instance URL.

### Configure Quable connector

In the `config/packages` folder, create a configuration file for the Quable connector, for example, `ibexa_connector_quable.yaml`:

``` yaml
ibexa_connector_quable:
    instance_url: 'https://sandbox-ibexa-connector.quable.com'
    api_token: '<your_api_token>'
    # Cache is enabled by default to improve performance
    cache:
        enabled: true
```

Replace `<your_api_token>` with the API token you obtained from Quable.

## Configure product catalog engine

To use Quable as the product data source, configure [[= product_name =]]'s Product Catalog to use the Quable engine.

### Define Quable engine

In `config/packages/ibexa_product_catalog.yaml`, add a new engine configuration:

``` yaml
ibexa_product_catalog:
    engines:
        local:
            type: local
            options:
                root_location_remote_id: ibexa_product_catalog_root
                product_type_group_identifier: product
        quable:
            type: quable
            options:
                taxonomy: quable
                root_location_remote_id: ibexa_product_catalog_root
                product_type_group_identifier: product
```

This configuration defines two engines: the default `local` engine and the new `quable` engine.

### Set Quable as default engine

In your repository configuration, typically in `config/packages/ibexa.yaml`, configure the Product Catalog to use the Quable engine:

``` yaml
ibexa:
    repositories:
        default:
            storage: ~
            search:
                engine: '%search_engine%'
                connection: default
            product_catalog:
                engine: quable
                regions:
                    default: ~
```

By setting `engine: quable`, you inform [[= product_name =]] to use Quable PIM as the product data source instead of the local product catalog.

## Synchronize taxonomy

After configuring the connection, synchronize the product classifications (taxonomy) from Quable to [[= product_name =]].

Run the following command to synchronize classifications:

``` bash
php bin/console ibexa:quable:classification:sync
```

This command imports the product classification structure from Quable PIM into [[= product_name =]], ensuring that product categories and taxonomies are aligned.

!!! tip "Verbose output"

    Add the `-vv` flag to see detailed information about the requests sent to Quable:

    ``` bash
    php bin/console ibexa:quable:classification:sync -vv
    ```

## Next steps

Once the Quable connector is configured and taxonomy is synchronized, you can:

- Create and manage products in Quable PIM
- View and present product data in [[= product_name =]]
- Use product catalog features with Quable as the data source
- Build product catalogs and filter products
- Manage product pricing and availability

For information about working with products in the user interface, see [Product management]([[= user_doc =]]/persona_paths/manage_products/).
