# Managing migrations

You can use the PHP API to manage and run [data migrations](../guide/data_migration.md).

## Getting migration information

To list all migration files available in the  directory defined in configuration (by default, `src/Migrations/Ibexa`),
use the `MigrationService:listMigrations()` method:

``` php
[[= include_file('code_samples/api/migration/src/Command/MigrationCommand.php', 24, 27) =]]
```

To get a single migration file by its name, use the `MigrationService:findOneByName()` method:

``` php
[[= include_file('code_samples/api/migration/src/Command/MigrationCommand.php', 29, 30) =]]
```

## Running migration files

To run migration file(s), use either `MigrationService:executeOne()` or `MigrationService:executeAll()`:

``` php
[[= include_file('code_samples/api/migration/src/Command/MigrationCommand.php', 31, 33) =]]
```

Both `executeOne()` and `executeAll()` take as optional parameter the User login you want to execute the migrations as.

## Adding new migrations

To add a new migration file, use the `MigrationService:add()` method:

``` php
[[= include_file('code_samples/api/migration/src/Command/MigrationCommand.php', 19, 23) =]]
```
