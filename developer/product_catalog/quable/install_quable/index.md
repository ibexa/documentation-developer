# Install Quable connector

Install and configure Quable PIM connector for Ibexa DXP

To integrate Ibexa DXP with Quable PIM, you need to install the Quable connector packages, configure the connection, and set up synchronization.

## Create Quable instance

Before installing the Quable connector, ensure you have access to a [Quable PIM instance](https://www.quable.com).

## Install package

Run the following command to install the required package:

```bash
composer require ibexa/connector-quable
```

The command adds the Quable connector code, including services that enable communication with Quable PIM.

## Get API credentials

To connect to Quable PIM, you need an API token:

1. Log in to your Quable instance, for example, `https://example.quable.com`.
2. Navigate to the [API Tokens](https://docs.quable.com/v5-EN/docs/api-tokens) section.
3. Create a new **Read Access Token** for use in the configuration.

## Configure Quable connector

In `config/packages/ibexa_connector_quable.yaml`, specify the configuration for the Quable connector:

```yaml
ibexa_connector_quable:
    instance_url: 'https://example.quable.com'
    api_token: '<your_api_token>'
    channel_code: '<channel_code>'
```

Replace `<your_api_token>` with the Read Access API token you obtained from Quable in the previous step.

[Quable's channels](https://docs.quable.com/v5-EN/docs/content-channels) allow you to distribute your product information to defined recipients, for example e-commerce platforms. Select the Quable channel that you want to integrate within Ibexa DXP.

For all available configuration options, see [Configure Quable](../configure_quable_connector/index.md).

## Configure product catalog engine

To use Quable as a product data source, configure Ibexa DXP's [product catalog](../../product_catalog_guide/index.md) to use the Quable engine.

### Define Quable engine

In `config/packages/ibexa_product_catalog.yaml`, add a new engine configuration:

```yaml
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

This configuration defines two engines: the default `local` engine and the new `quable` engine, allowing you to work with products defined within Quable.

To learn more about product catalog configuration, see [Product catalog configuration](../../product_catalog_configuration/index.md).

The Quable integration add-on comes with a new [taxonomy](../../../content_management/taxonomy/taxonomy/index.md) called `quable`. By setting the `ibexa_product_catalog.engines.quable.options.taxonomy` key to `quable`, you configure the engine to use it for storing product categories.

### Set Quable as default engine

In your repository configuration, typically in `config/packages/ibexa.yaml`, configure the product catalog to use the Quable engine as the product data source:

```yaml
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

To use the products from Quable within Ibexa DXP content, make sure the [data languages](https://docs.quable.com/v5-EN/docs/data-languages) in Quable have corresponding [languages](../../../multisite/languages/languages/index.md) in Ibexa DXP.

To compare the language configuration in both systems, run the following command:

```bash
php bin/console ibexa:quable:languages:check
```

Based on the command output, configure the `language_map` in `config/packages/ibexa_connector_quable.yaml`, mapping each Ibexa DXP language code to its Quable locale code as in the following example:

```yaml
ibexa_connector_quable:
    # ...
    language_map:
        eng-GB: en_GB
        fre-FR: fr_FR
```

The system uses the language map to retrieve data in the correct language from Quable.

After configuring the map, rerun the `ibexa:quable:languages:check` command to confirm all languages are correctly mapped.

## Synchronize taxonomy

After configuring the integration, synchronize [product classifications from Quable](https://docs.quable.com/v5-EN/docs/documents-classification-new-version) to Ibexa DXP's [taxonomies](../../../content_management/taxonomy/taxonomy/index.md).

Run the following command to synchronize classifications:

```bash
php bin/console ibexa:quable:classification:sync
```

This command imports the product classification structure from Quable PIM into Ibexa DXP, ensuring that product categories are aligned.

> **Tip: Tip**
>
> To keep the classifications aligned, we recommend running the `ibexa:quable:classification:sync` command every night, even when using synchronization with webhooks.

## Set up real-time synchronization

Quable PIM can notify Ibexa DXP about product data and classification changes in real-time by using webhooks. This invalidates the cache kept in Ibexa DXP, ensuring that product information stays up to date.

Webhook configuration must be set up in both Quable PIM and Ibexa DXP.

### Create webhook in Quable

1. Create a new [webhook in Quable](https://docs.quable.com/v5-EN/docs/webhook).

2. Set the webhook code (used as the webhook name).

3. Provide the URL to your Ibexa DXP instance suffixed by `/webhook/quable`, for example: `https://example.com/webhook/quable`.

4. Mark it as **Activated**.

5. Enter a secret value for the **Authorization Header**.

6. Choose the following scopes:

   - Products: created, updated, deleted
   - Classifications: created, updated, deleted

The **Authorization Header** value is a [secret that must be kept secure](../../../infrastructure_and_maintenance/security/security_checklist/index.md#app_secret-and-other-secrets).

> **Note: Note**
>
> For local development and testing, you can consider using one of the available [tunnel providers](https://github.com/anderspitman/awesome-tunneling) to make your local instance accessible from the internet.

### Configure webhook in Ibexa DXP

In `config/packages/ibexa_connector_quable.yaml`, specify the configuration for the Quable connector:

```yaml
ibexa_connector_quable:

    # ...
    webhook_secret: '<webhook authorization header>'
```

> **Caution: Caution**
>
> [Quable uses dynamic IP addresses](https://faq.quable.com/en/articles/8250056-what-are-the-ip-addresses-of-quable-to-add-to-the-whitelist) to connect to Ibexa DXP. If your DXP instance is protected by a firewall, make sure your configuration allows connections from changing IP addresses.

### Configure background task

Ibexa DXP's webhook processes Quable's classification change events and queues them to be processed in the background.

To process them, [configure Ibexa Messenger](../../../infrastructure_and_maintenance/background_tasks/index.md) and make sure the `messenger:consume` command is run periodically.
