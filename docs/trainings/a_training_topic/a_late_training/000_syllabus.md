---
description: Training page template
---

[[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]
# The late training title

## Syllabus

In this training, you learn to… …with HTTP cache…

| Section     | Estimated | Description                                              |
|:------------|----------:|:---------------------------------------------------------|
| Lorem ipsum | T minutes | Lorem ipsum dolor sit amet, consectetur adipiscing elit. |

## Requirements

This is what you need to know to set up your training environment.

### Previous trainings

You should have mastered the following training(s) before starting this *The late training title*:

- [An early training](../an_early_training/000_syllabus.md)

### Ibexa DXP edition

[[= product_name_exp =]] is the minimal edition required by this training.

- [[= product_name_exp =]] [[= latest_tag_4_6 =]]
- [[= product_name_com =]] [[= latest_tag_4_6 =]]

!!! note

    You can use [`experience-skeleton`'s DDEV feature](ddev_interactive_launcher.md#experience)

    For more suggestions about your training environment, see [Training environment](trainings.md#training-environment).

### Cluster elements

This training needs a reverse proxy for HTTP cache. For a local installation, Varnish is recommended.

|       Service | Required | Value        |
|--------------:|:--------:|:-------------|
| Search engine |    No    | (Legacy)     |
|    Cache pool |    No    | (Filesystem) |
|    HTTP cache | **Yes**  | Varnish      |

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
