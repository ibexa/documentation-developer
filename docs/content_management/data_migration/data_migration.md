---
description: Data migration enables you to import and export repository data by using YAML files.
page_type: landing_page
---

# Data migration

Data migration allows exporting and importing selected data from an [[= product_name =]] installation.

[*Exporting*](exporting_data.md) data consists in saving selected repository information in YAML format.
[*Importing*](importing_data.md) reads migration YAML files and creates or modifies repository content based on them.
Between installation, you can migrate your repository data, for example, content items, content types, languages, object states, or sections.

You can use migrations in projects that require the same data to be present across multiple instances.
You can use them for project templates.
Migrations are able to store shared data, so they can be applied for each new project you start, or incrementally upgrade older projects to your new standard, if needed.
They're a developer-friendly tool that allows you to share data without writing code.

You can run data migrations either with a command, or with the [PHP API](data_migration_api.md).

[[= cards([
    "content_management/data_migration/importing_data",
    "content_management/data_migration/exporting_data",
    "content_management/data_migration/data_migration_actions",
    "content_management/data_migration/managing_migrations"
]) =]]
