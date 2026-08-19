---
description: Install and configure Quable PIM connector for Ibexa DXP
month_change: false
---

# Install Quable connector

To integrate [[= product_name =]] with [[= pim_product_name =]] PIM, you need to install the [[= pim_product_name =]] connector packages, configure the connection, and set up synchronization.

## Create [[= pim_product_name =]] instance

Before installing the [[= pim_product_name =]] connector, ensure you have access to a [[[= pim_product_name =]] PIM instance](https://www.quable.com).

## Install package

Run the following command to install the required package:

``` bash
composer require ibexa/connector-quable
```

The command adds the [[= pim_product_name =]] connector code, including services that enable communication with [[= pim_product_name =]] PIM.

## Get API credentials

To connect to [[= pim_product_name =]] PIM, you need an API token:

1. Log in to your [[= pim_product_name =]] instance, for example, `https://example.quable.com`.
2. Navigate to the [API Tokens](https://docs.quable.com/v5-EN/docs/api-tokens) section.
3. Create a new **Read Access Token** for use in the configuration.

## Configure [[= pim_product_name =]] connector

In `config/packages/ibexa_connector_quable.yaml`, specify the configuration for the [[= pim_product_name =]] connector:

``` yaml
ibexa_connector_quable:
    instance_url: 'https://example.quable.com'
    api_token: '<your_api_token>'
    channel_code: '<channel_code>'
```

Replace `<your_api_token>` with the Read Access API token you obtained from [[= pim_product_name =]] in the previous step.

[[[= pim_product_name =]]'s channels](https://docs.quable.com/v5-EN/docs/content-channels) allow you to distribute your product information to defined recipients, for example e-commerce platforms.
Select the [[= pim_product_name =]] channel that you want to integrate within [[= product_name =]].

For all available configuration options, see [Configure [[= pim_product_name =]]](configure_quable_connector.md).

## Configure product catalog engine

To use [[= pim_product_name =]] as a product data source, configure [[= product_name =]]'s [product catalog](product_catalog_guide.md) to use the [[= pim_product_name =]] engine.

### Define [[= pim_product_name =]] engine

In `config/packages/ibexa_product_catalog.yaml`, add a new engine configuration:

``` yaml hl_lines="8-13"
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

This configuration defines two engines: the default `local` engine and the new `quable` engine, allowing you to work with products defined within [[= pim_product_name =]].

To learn more about product catalog configuration, see [Product catalog configuration](product_catalog_configuration.md).

The [[= pim_product_name =]] integration add-on comes with a new [taxonomy](taxonomy.md) called `quable`.
By setting the `ibexa_product_catalog.engines.quable.options.taxonomy` key to `quable`, you configure the engine to use it for storing product categories.

### Set [[= pim_product_name =]] as default engine

In your repository configuration, typically in `config/packages/ibexa.yaml`, configure the product catalog to use the [[= pim_product_name =]] engine as the product data source:

``` yaml hl_lines="9"
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

To use the products from [[= pim_product_name =]] within [[= product_name =]] content, make sure the [data languages](https://docs.quable.com/v5-EN/docs/data-languages) in [[= pim_product_name =]] have corresponding [languages](languages.md) in [[= product_name =]].

To compare the language configuration in both systems, run the following command:

``` bash
php bin/console ibexa:quable:languages:check
```

Based on the command output, configure the `language_map` in `config/packages/ibexa_connector_quable.yaml`, mapping each [[= product_name =]] language code to its [[= pim_product_name =]] locale code as in the following example:

``` yaml
ibexa_connector_quable:
    # ...
    language_map:
        eng-GB: en_GB
        fre-FR: fr_FR
```

The system uses the language map to retrieve data in the correct language from [[= pim_product_name =]].

After configuring the map, rerun the `ibexa:quable:languages:check` command to confirm all languages are correctly mapped.

## Synchronize taxonomy

After configuring the integration, synchronize [product classifications from [[= pim_product_name =]]](https://docs.quable.com/v5-EN/docs/documents-classification-new-version) to [[= product_name =]]'s [taxonomies](taxonomy.md).

Run the following command to synchronize classifications:

``` bash
php bin/console ibexa:quable:classification:sync
```

This command imports the product classification structure from [[= pim_product_name =]] PIM into [[= product_name =]], ensuring that product categories are aligned.

!!! tip

    To keep the classifications aligned, we recommend running the `ibexa:quable:classification:sync` command every night, even when using synchronization with webhooks.

## Set up real-time synchronization

[[= pim_product_name =]] PIM can notify [[= product_name =]] about product data and classification changes in real-time by using webhooks.
This invalidates the cache kept in [[= product_name =]], ensuring that product information stays up to date.

Webhook configuration must be set up in both Quable PIM and [[= product_name =]].

### Create webhook in [[= pim_product_name =]]

1. Create a new [webhook in Quable](https://docs.quable.com/v5-EN/docs/webhook).
2. Set the webhook code (used as the webhook name).
3. Provide the URL to your [[= product_name =]] instance suffixed by `/webhook/quable`, for example: `https://example.com/webhook/quable`.
4. Mark it as **Activated**.
5. Enter a secret value for the **Authorization Header**.
6. Choose the following scopes:

    - Products: created, updated, deleted
    - Classifications: created, updated, deleted

The **Authorization Header** value is a [secret that must be kept secure](security_checklist.md#app_secret-and-other-secrets).

!!! note

    For local development and testing, you can consider using one of the available [tunnel providers](https://github.com/anderspitman/awesome-tunneling) to make your local instance accessible from the internet.

### Configure webhook in [[= product_name =]]

In `config/packages/ibexa_connector_quable.yaml`, specify the configuration for the [[= pim_product_name =]] connector:

``` yaml
ibexa_connector_quable:

    # ...
    webhook_secret: '<webhook authorization header>'
```

!!! caution

    [Quable uses dynamic IP addresses](https://faq.quable.com/en/articles/8250056-what-are-the-ip-addresses-of-quable-to-add-to-the-whitelist) to connect to [[= product_name =]].
    If your DXP instance is protected by a firewall, make sure your configuration allows connections from changing IP addresses.

### Configure background task

[[= product_name =]]'s webhook processes Quable's classification change events and queues them to be processed in the background.

To process them, [configure Ibexa Messenger](background_tasks.md) and make sure the `messenger:consume` command is run periodically.
