---
description: Data migration enables you to import and export Repository data by using YAML files.
page_type: landing_page
---

# Data migration

Data migration allows exporting and importing selected data from an [[= product_name =]] installation.

[*Exporting*](exporting_data.md) data consists in saving selected Repository information in YAML format.
[*Importing*](importing_data.md) reads migration YAML files and creates or modifies Repository content based on them.
You can migrate your Repository data, that is Content items, as well as Content Types, languages, Object states, Sections, and so on,
between installations.

You can use migrations in projects that require the same data to be present across multiple instances.
They can be useful for project templates. Migrations are able to store shared data, so they can be applied for each new project you start,
or incrementally upgrade older projects to your new standard, if needed.
They are a developer-friendly tool that allows you to share data without writing code.

You can run data migrations either with a command, or with the [PHP API](data_migration_api.md).

[[= cards([
    "content_management/data_migration/importing_data",
    "content_management/data_migration/exporting_data",
    "content_management/data_migration/data_migration_actions",
    "content_management/data_migration/managing_migrations",
]) =]]
