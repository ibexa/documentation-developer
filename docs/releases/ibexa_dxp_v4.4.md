---
description: Ibexa DXP v4.4 adds the improvements to the Welcome Page, All-new Ibexa Commerce packages and Fastly IO.
---

# Ibexa DXP v4.4

**Version number**: v4.4

**Release date**: February 2, 2023

**Release type**: [Fast Track](https://support.ibexa.co/Public/service-life)

**Update**: v4.3.x to v4.4

## Notable changes

### New welcome page

A new welcome page greets you when opening Ibexa Digital Experience Platform.

![New Welcome Page](4.4_welcome_page.png)

### All-new Ibexa Commerce packages

This release deprecates all Commerce packages that you've known from previous releases 
and brings a redesigned and reconstructed Commerce offering.

![The new cart view](img/4.4_new_cart.png "The new cart view")

As part of this effort, two all-new components have been created: Cart and Checkout, 
that you can use to build your own e-commerce presence. 

![The new checkout](img/4.4_new_checkout.png "The new checkout")

For more information, see [Commerce](https://doc.ibexa.co/en/4.4/commerce/commerce/).

#### Storefront

Another addition is the Storefront package that provides a starting kit 
for the developers.
It is a working set of components, which you can use to test the new capabilities, 
and then customize and extend to create your own implementation of a web store.

For more information, see [Storefront](https://doc.ibexa.co/en/4.4/commerce/storefront/storefront).

### Fastly Image Optimizer (Fastly IO)

You can now use Fastly IO to serve optimized versions of your images in real time and cache them.
Fastly can perform multiple transformations on your image,
for example, cropping, resizing and trimming before serving it to end user.
Fastly is an external service that requires a separate subscription,
to learn more see, [Fastly Image Optimizer website](https://docs.fastly.com/en/guides/about-fastly-image-optimizer).

If you already have Fastly IO subscription, you can move to [Fastly IO configuration in Ibexa DXP](https://doc.ibexa.co/en/4.4/content_management/images/fastly_io/).

#### Fastly VCL upload

With this release, you can manipulate your Fastly VCL configuration directly from the command line.
For example, you can define formats or source path for images.

### New page blocks

This release introduces new page blocks that rely on Personalization and PIM features 
to let editors visually organize products on a page: 

- [Catalog block](https://doc.ibexa.co/projects/userguide/en/4.4/content_management/block_reference/#catalog-block) displays products from a specific catalog to a selected customer group.
- [Last purchased](https://doc.ibexa.co/projects/userguide/en/4.4/content_management/block_reference/#last-purchased-block) displays a list of products that were recently purchased, either generally, or by a specific user.
- [Last viewed](https://doc.ibexa.co/projects/userguide/en/4.4/content_management/block_reference/#last-viewed-block) displays a list of products that were recently viewed.
- [Product collection](https://doc.ibexa.co/projects/userguide/en/4.4/content_management/block_reference/#product-collection-block) displays a collection of specifically selected products.
- [Recently added](https://doc.ibexa.co/projects/userguide/en/4.4/content_management/block_reference/#recently-added-block) displays a list of products that were recently added to PIM.

### Personalization improvements

#### Automated way of creating Personalization service account

The Personalization service has been enhanced to speed up the process of creating a new customer account.
Now, to create an account in the new, automated way, you have to fill out the form, select an account type, and send a request to the Personalization endpoint.
Shortly after, you receive the credentials.

For more information, see [Requesting access to the server](https://doc.ibexa.co/projects/userguide/en/4.4/personalization/enable_personalization/#request-access-to-the-server).

#### New models in Personalization engine

Personalization engine introduces two new recommendation models: [predictive](https://doc.ibexa.co/projects/userguide/en/4.4/personalization/recommendation_models/#predictive) and [recurring purchase](https://doc.ibexa.co/projects/userguide/en/4.4/personalization/recommendation_models/#recurring-purchase). These two new models, based on mathematical approach, help to predict clients behavior and
provide the best recommendations.

## Ibexa Connect

You can now take advantage of [Ibexa Connect](https://www.ibexa.co/products/ibexa-connect),
an iPaaS (integration platform-as-a-service) which allows you to connect Ibexa DXP with third-party applications.
Ibexa Connect features a low-code drag-and-drop interface and hundreds of connectors to different services
that help you automate business processes.

See [Ibexa Connect documentation](https://doc.ibexa.co/projects/connect/en/latest/).

![Example of an Ibexa Connect scenario](4.4_connect_scenario_example.png)

## Other changes

### Flysystem v2

The codebase has undergone significant upgrades to rely on Flysystem v2.
The Flysystem Adapter implementation now supports dynamic paths
described by complex settings resolvable for the SiteAccess context.
For more information, see [Configuring the DFS IO handler](https://doc.ibexa.co/en/4.4/infrastructure_and_maintenance/clustering/clustering/#configuring-the-dfs-io-handler).

If your custom project relies directly on a Flysystem features instead of using our IO abstraction,
it will require an upgrade as well,
using [these instructions](https://flysystem.thephpleague.com/docs/upgrade-from-1.x/).

### Dedicated migration type for Corporate Accounts

To simplify data migration, you can now create a corporate account with underlying objects such as members group and address book.
You can also extract those objects as references. 
For more information on data migration actions, see [Data migration actions](https://doc.ibexa.co/en/4.4/content_management/data_migration/data_migration_actions/#data-migration-actions).

### API improvements

### Item age in Recently added model

In a Recently added model (previously Random model), you can now manually [set the age of items](https://doc.ibexa.co/projects/userguide/en/4.4/personalization/recommendation_models/#recently-added) which are displayed in recommendations.

### Deprecations

#### Commerce packages

The following Commerce packages are deprecated as of this release and will be removed in v5:

- `ibexa/commerce-admin-ui`
- `ibexa/commerce-erp-admin`
- `ibexa/commerce-order-history`
- `ibexa/commerce-page-builder`
- `ibexa/commerce-rest`
- `ibexa/commerce-transaction`
- `ibexa/commerce-base-design`
- `ibexa/commerce-checkout`
- `ibexa/commerce-fieldtypes`
- `ibexa/commerce-price-engine`
- `ibexa/commerce-shop`
- `ibexa/commerce-shop-ui`

They will be maintained by Ibexa with fixes, including security fixes, but they won't be further developed.
Old packages are replaced by [the all-new Ibexa Commerce packages](#all-new-ibexa-commerce-packages) with more
to come in the upcoming releases.

#### Flysystem

- Support for overwriting existing files has been dropped (catch block of `\Ibexa\Core\IO\IOBinarydataHandler\Flysystem::create` and test). The new native Flysystem v2 Local Adapter performs this out of the box.
- Support for no last modified timestamp has been dropped (in the form of a test case). The new Flysystem v2 throws `UnableToRetrieveMetadata` exception in such case.

## Full changelog

| Ibexa Content          | Ibexa Experience          | Ibexa Commerce          |
|------------------------|---------------------------|-------------------------|
| [Ibexa Content v4.4](https://github.com/ibexa/content/releases/tag/v4.4.0) | [Ibexa Experience v4.4](https://github.com/ibexa/experience/releases/tag/v4.4.0) | [Ibexa Commerce v4.4](https://github.com/ibexa/commerce/releases/tag/v4.4.0) |
