---
description: You can use the PHP API to run data migrations, add new migration files, or get information about available migrations.
---

# Data migration API

You can use the PHP API to manage and run [data migrations](../guide/data_migration/data_migration.md).

## Getting migration information

To list all migration files available in the directory defined in configuration (by default, `src/Migrations/Ibexa`),
use the `MigrationService:listMigrations()` method:

``` php
[[= include_file('code_samples/api/migration/src/Command/MigrationCommand.php', 25, 28) =]]
```

To get a single migration file by its name, use the `MigrationService:findOneByName()` method:

``` php
[[= include_file('code_samples/api/migration/src/Command/MigrationCommand.php', 30, 31) =]]
```

## Running migration files

To run migration file(s), use either `MigrationService:executeOne()` or `MigrationService:executeAll()`:

``` php
[[= include_file('code_samples/api/migration/src/Command/MigrationCommand.php', 32, 33) =]]
```

Both `executeOne()` and `executeAll()` can take an optional parameter: the login of the User that you want to execute the migrations as.

## Adding new migrations

To add a new migration file, use the `MigrationService:add()` method:

``` php
[[= include_file('code_samples/api/migration/src/Command/MigrationCommand.php', 18, 24) =]]
```
