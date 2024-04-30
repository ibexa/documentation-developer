---
description: Training page template
---

[[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

# The late training title: Requirements

This is what you need to know to set up your training environment.

## Previous trainings

You should have mastered the following training(s) before starting ''The late training title'':

- [An early training](../an_early_training/00_presentation.md)

## Ibexa DXP edition

[[= product_name_exp =]] [[= latest_tag_4_6 =]]

!!! note

    You can use [`experience-skeleton`'s DDEV feature](doc_about_website-skeleton_ddev_interactive_launcher.md#experience)

## Cluster elements

This training needs a reverse proxy for HTTP cache. For a local installation, Varnish is recommended. 

|       Service | Required | Value        |
|--------------:|:--------:|:-------------|
| Search engine |    No    | (Legacy)     |
|    Cache pool |    No    | (Filesystem) |
|    HTTP cache | **Yes**  | Varnish      |

## Starting state

To follow this training, you must install code, config and data on top of a fresh installation.

1. Download the [starting state archive](download/a_late_training.start.zip).
1. Execute the following commands:
   ```bash
   # Unzip
   # Copy
   # Append
   # Migrate
   ```
