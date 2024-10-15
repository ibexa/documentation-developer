---
description: PIM training
page_type: training
---

# PIM (Product Information Management)

## Syllabus

In this training, you learn how to create complex products locally, and to organize them.

| Section                                     | Estimated | Description                                               |
|:--------------------------------------------|----------:|:----------------------------------------------------------|
| [Product modeling](011_product_modeling.md) | X minutes | Learn about product types, products and product variants. |
| [Product shelving](012_product_shelving.md) | Y minutes | Organize your products with categories and catalogs.      |
| [Product exchange](021_product_exchange.md) | Z minutes | Explore REST API, PHP API, and migrations.                |

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

TODO: Make sure that everything used is in Ibexa DXP Headless scope, so to speak, ibexa/product-catalog. It mustn't use features from ibexa/storefront.

### Cluster elements

This training can be run on the minimal stack.

|       Service | Required | Value        |
|--------------:|:--------:|:-------------|
| Search engine |    No    | (Legacy)     |
|    Cache pool |    No    | (Filesystem) |
|    HTTP cache |    No    |              |

### Starting state

To follow this training, you must install code, configuration, and data on top of a fresh installation.

TODO: Experience clean install, or previous bike ride design and content?
