# Data migration API

You can use the PHP API to run data migrations, add new migration files, or get information about available migrations.

You can use the PHP API to manage and run [data migrations](../data_migration/index.md).

## Getting migration information

To list all migration files available in the directory defined in configuration (by default, `src/Migrations/Ibexa`), use the `MigrationService:listMigrations()` method:

```php
foreach ($this->migrationService->listMigrations() as $migration) {
    $output->writeln($migration->getName());
}
```

To get a single migration file by its name, use the `MigrationService:findOneByName()` method:

```php
$my_migration = $this->migrationService->findOneByName($migration_name);
```

## Running migration files

To run migration file(s), use either `MigrationService:executeOne()` or `MigrationService:executeAll()`:

```php
$this->migrationService->executeOne($my_migration);
$this->migrationService->executeAll('admin');
```

Both `executeOne()` and `executeAll()` can take an optional parameter: the login of the User that you want to execute the migrations as.

## Adding new migrations

To add a new migration file, use the `MigrationService:add()` method:

```php
$this->migrationService->add(
    new Migration(
        'new_migration.yaml',
        $string_with_migration_content
    )
);
```
