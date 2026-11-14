# Data migration

Data migration enables you to import and export repository data by using YAML files.

Data migration allows exporting and importing selected data from an Ibexa DXP installation.

[*Exporting*](../exporting_data/index.md) data consists in saving selected repository information in YAML format. [*Importing*](../importing_data/index.md) reads migration YAML files and creates or modifies repository content based on them. Between installation, you can migrate your repository data, for example, content items, content types, languages, object states, or sections.

You can use migrations in projects that require the same data to be present across multiple instances. You can use them for project templates. Migrations are able to store shared data, so they can be applied for each new project you start, or incrementally upgrade older projects to your new standard, if needed. They're a developer-friendly tool that allows you to share data without writing code.

You can run data migrations either with a command, or with the [PHP API](../data_migration_api/index.md).

- [Importing data](../importing_data/index.md): Import data into your repository from prepared YAML files.
- [Exporting data](../exporting_data/index.md): Export repository data to use in future data migrations.
- [Data migration actions](../data_migration_actions/index.md): Data migration actions enable you to run special operations while executing data migrations, such as assigning roles, sections, Objects states, and more.
- [Managing migrations](../managing_migrations/index.md): Manage data migrations by adding files, converting from Kaliop migration bundle, checking migration status, and setting up configuration.
