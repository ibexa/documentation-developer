---
description: Ibexa DXP v4.4 adds the improvements to the Welcome Page, PIM and Fastly.
---
# Ibexa DXP v4.4

**Version number**: v4.4

**Release date**: January 27, 2023

**Release type**: [Fast Track](https://support.ibexa.co/Public/service-life)

**Update**: [v4.3.x to v4.4](https://doc.ibexa.co/en/4.4/update_and_migration/from_4.3/update_from_4.3/)

## Notable changes

### New welcome page

You will be welcomed to the Ibexa Digital Experience Platform by a newly designed welcome page.

![New Welcome Page](4.4_welcome_page.png)

### Fastly Image Optimizer (Fastly IO)

You can now use Fastly IO to serve optimized versions of your images in real time and cache them.
Fastly can perform multiple transformations on your image,
for example, cropping, resizing and trimming before serving it to end user.
Fastly is an external service that requires a separate subscription,
to learn more see, [Fastly Image Optimizer website](https://docs.fastly.com/en/guides/about-fastly-image-optimizer).

If you already have Fastly IO subscription, you can move to Fastly IO configuration in Ibexa DXP.

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

### Personalization improvements

#### Automated way of creating Personalization service account

The Personalization service has been enhanced to speed up the process of creating new customer account.
Now, what you have to do to create an account in the new, automated way, is to fill out the form, select an account type, and send request to the Personalization endpoint. 
Shortly after, you receive the credentials.

For more information, see [documentation](https://doc.ibexa.co/projects/userguide/en/4.4/personalization/enable_personalization/#request-access-to-the-server).

#### New models in Personalization engine

Personalization engine introduces two new recommendation models: [predictive](https://doc.ibexa.co/projects/userguide/en/4.4/personalization/recommendation_models/#predictive) and [recurring purchase](https://doc.ibexa.co/projects/userguide/en/4.4/personalization/recommendation_models/#recurring-purchase). These two new models, based on mathematical approach, help to predict clients behavior and
provide the best recommendations. 

## Ibexa Connect

You can now take advantage of [Ibexa Connect](https://www.ibexa.co/products/ibexa-connect),
an iPaaS (integration platform-as-a-service) which allows you to connect Ibexa DXP with different third-party applications.
Ibexa Connect features a low-code drag-and-drop interface and hundreds of connectors to different services
that help you automate business processes.

See [Ibexa Connect documentation](https://doc.ibexa.co/projects/connect/en/latest/).

![Example of an Ibexa Connect scenario](4.4_connect_scenario_example.png)

## Other changes

### Flysystem v2
We have made significant upgrades to the codebase to rely on Flysystem v2.
Our Flysystem Adapter implementation now supports dynamic paths
described by complex settings resolvable for the SiteAccess context.
For more information, see [Configuring the DFS IO handler](https://doc.ibexa.co/en/4.4/infrastructure_and_maintenance/clustering/clustering/#configuring-the-dfs-io-handler).

If your custom project relies directly on a Flysystem features instead of using our IO abstraction,
it will require an upgrade as well, 
using [these instructions](https://flysystem.thephpleague.com/docs/upgrade-from-1.x/).

### Dedicated migration type for companies

To simplify data migration, you can now create a company with underling objects such as members group and address book.
You can also extract those objects as references. 
For more information on data migration actions,
see [documentation](https://doc.ibexa.co/en/4.4/content_management/data_migration/data_migration_actions/#data-migration-actions).

### API improvements

### Item age in random model

Now, in a Recently added model (previously Random model), you can manually [set the age of items](https://doc.ibexa.co/projects/userguide/en/4.4/personalization/recommendation_models/#recently-added) which are displayed in recommendations.

### Deprecations

- Support for overwriting existing files has been dropped (catch block of `\Ibexa\Core\IO\IOBinarydataHandler\Flysystem::create` and test). The new native Flysystem v2 Local Adapter performs this out of the box.
- Support for no last modified timestamp has been dropped (in the form of a test case). The new Flysystem v2 throws `UnableToRetrieveMetadata` exception in such case.

## Full changelog
| Ibexa Content          | Ibexa Experience          | Ibexa Commerce          |
|------------------------|---------------------------|-------------------------|
| [Ibexa Content v4.4]() | [Ibexa Experience v4.4]() | [Ibexa Commerce v4.4]() |
