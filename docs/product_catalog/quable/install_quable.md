---
description: Install and configure Quable PIM connector for Ibexa DXP
---

# Install Quable connector

To integrate [[= product_name =]] with Quable PIM, you need to install the Quable connector packages, configure the connection, and set up synchronization.

## Install packages

Before installing the Quable connector, ensure you have access to a [Quable PIM instance](https://quable.com).

Run the following commands to install the required packages:

``` bash
composer require ibexa/quable-client
composer require ibexa/connector-quable
```

These commands add the Quable connector code, including services that enable communication with the Quable PIM system.

## Get API credentials

To connect to Quable PIM, you need an API token:

1. Log in to your Quable instance (for example, `https:/example.quable.com`).
2. Navigate to the [API Tokens](https://docs.quable.com/v5-EN/docs/system-api-tokens) section
3. Copy the **Read Access Token** value for use in the configuration.

## Configure Quable connector

In the `config/packages` folder, create a configuration file for the Quable connector, for example, `ibexa_connector_quable.yaml`:

``` yaml
ibexa_connector_quable:
    instance_url: 'https://example.quable.com'
    api_token: '<your_api_token>'
    channel_code: '<channel_code>'
```

Replace `<your_api_token>` with the Read Access API token you obtained from Quable.

[Quable's channels](https://docs.quable.com/v5-EN/docs/content-channels) allow you to distribute your product information to defined recipients, for example e-commerce platforms.
Select the Quable channel you want to integrate with [[= product_name =]].

## Configure product catalog engine

To use Quable as the product data source, configure [[= product_name =]]'s product catalog to use the Quable engine.

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

In your repository configuration, typically in `config/packages/ibexa.yaml`, configure the Product Catalog to use the Quable engine as the product data source:

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

## Set up languages

When working with Quable products, 

## Synchronize taxonomy

After configuring the integration, synchronize [product classifications from Quable](https://docs.quable.com/v5-EN/docs/documents-classification-new-version) to [[= product_name =]]'s [taxonomies](taxonomy.md).

Run the following command to synchronize classifications:

``` bash
php bin/console ibexa:quable:classification:sync
```

This command imports the product classification structure from Quable PIM into [[= product_name =]], ensuring that product categories and taxonomies are aligned.

!!! note "Verbose output"

    Add the `-vv` flag to see detailed information about the requests sent to Quable:

    ``` bash
    php bin/console ibexa:quable:classification:sync -vv
    ```

## Set up real-time synchronization

Quable PIM can notify [[= product_name =]] about product data changes in real-time using webhooks. 
This ensures that product information stays synchronized automatically without manual intervention.

Webhook configuration requires setup in both Quable PIM and [[= product_name =]].

1. Create a new [webhook in Quable](https://docs.quable.com/v5-EN/docs/webhook).
2. Set the webhook's name and provide the URL to your [[= product_name =]] instance
3. Mark it as **Activated**
4. Enter a secret value for the **Authorization Header**
5. Choose the following scopes:
  - Products: created, updated, deleted
  - Classifications: created, updated, deleted

The **Authorization Header** value is a [secret that must be kept secure](security_checklist.md#app-secret-and-other-secrets).

!!! note

    For local development and testing, consider using one of the avalable [tunnel providers](https://github.com/anderspitman/awesome-tunneling) to make your instance accessible 



For information about working with products in the user interface, see [Product management]([[= user_doc =]]/persona_paths/manage_products/).
