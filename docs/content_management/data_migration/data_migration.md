---
description: Data migration enables you to import and export Repository data by using YAML files.
---

# Data migration

You can use migrations in projects that require the same data to be present across multiple instances.
They can be useful for project templates. Migrations are able to store shared data, so they can be applied for each new project you start,
or incrementally upgrade older projects to your new standard, if needed.
They are a developer-friendly tool that allows you to share data without writing code.

You can migrate your Repository data, that is Content items, as well as Content Types, languages, Object states, Sections, and so on,
between installations by using the migration command.

!!! tip "Public PHP API"

    You can also manage data migrations with the PHP API, see [Managing migrations](data_migration_api.md).

!!! caution "Do not enable EzMigrationBundle2"

    If you are migrating your data either with [`kaliop-uk/ezmigrationbundle`](https://github.com/kaliop-uk/ezmigrationbundle) or [`ezsystems/ezmigrationbundle`](https://github.com/ezsystems/EzMigrationBundle), do not install the [`tanoconsulting/ezmigrationbundle2`](https://github.com/tanoconsulting/ezmigrationbundle2) package, or your application will stop working due to multiple duplicated classes.
    
    As of v3.3.3, the `ezmigrationbundle` package has been removed to mitigate this issue. 
    It is recommended that you use the default `ibexa/migrations` package to migrate your data. 

You can find examples of using migrations in [Migration examples](importing_data.md#migration-examples),
and in your project's `vendor/ibexa/migrations/tests/bundle/Command/MigrateCommand/migrate-command-fixtures` folder.
