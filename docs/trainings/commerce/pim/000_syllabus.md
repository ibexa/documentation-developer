---
description: PIM training
---

[[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]
# PIM (Product Information Management)

## Syllabus

In this training, you learn how to create complex products, to quote their prices, and to organize them in catalogs, using the build-in features.

| Section                                         | Estimated | Description                                                                   |
|:------------------------------------------------|----------:|:------------------------------------------------------------------------------|
| [Product modeling](011_product_modeling.md)     | X minutes | Learn about product types, products and product variants.                     |
| [Product shelving](012_product_shelving.md)     | Y minutes | Organize your products with categories and catalogs.                          |
| [Product displaying](013_product_displaying.md) | Z minutes | Template the product page.                                                    |
| [Product pricing](021_product_pricing.md)       | N minutes | Manage currencies and VAT rates, compute prices. (TODO: discount needs users) |                               

## Requirements

### Previous knowledge

- [Content management](content_management.md)
  - [Content types](content_types.md) and [content items](content_model.md#content-items)
  - [Taxonomy](taxonomy.md)
- [Templating](templating.md)

### Ibexa DXP edition

[[= product_name_headless =]] is the minimal edition required for this training.

- [[= product_name_headless =]] [[= latest_tag_4_6 =]]
- [[= product_name_exp =]] [[= latest_tag_4_6 =]]
- [[= product_name_com =]] [[= latest_tag_4_6 =]]

TODO: Make sure that everything used is in Ibexa DXP Headless scope, so to speak, ibexa/product-catalog
TODO: Trainees working on Ibexa DXP Commerce could pick examples from ibexa/storefront but others mustn't be frustrated of having installed an inferior edition.

### Cluster elements

This training needs a reverse proxy for HTTP cache. For a local installation, Varnish is recommended.

|       Service | Required | Value        |
|--------------:|:--------:|:-------------|
| Search engine |    No    | (Legacy)     |
|    Cache pool |    No    | (Filesystem) |
|    HTTP cache |    No    |              |

### Starting state

To follow this training, you must install code, config and data on top of a fresh installation.

1. Download the [starting state archive](download/a_late_training.start.zip).
1. Put this archive at the root of your [[= product_name =]] training installation.
1. In a terminal, run the following commands at the root of your [[= product_name =]] training installation:
   ```bash
   unzip a_late_training.start.zip
   tail -n+2 config/append_to_services.yaml >> config/services.yaml
   rm config/append_to_services.yaml
   php bin/console ibexa:migrations:migrate --file=a_late_training_content_types.yml --siteaccess=admin
   php bin/console ibexa:migrations:migrate --file=a_late_training_contents.yml --siteaccess=admin
   ```
