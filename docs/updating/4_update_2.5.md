# Updating from <2.5
    
If you are updating from a version prior to 2.4, you have implement all the changes from [Updating from <2.4](4_update_2.4.md) before following the steps below.

!!! note

    During database update, you have to go through all the changes between your current version and your final version
    **e.g. during update from v2.2 to v2.5 you have to perform all the steps from: <2.3, <2.4 and <2.5**.
    Only after applying all changes your database will work properly.


## Database update script

Apply the following database update script:

`mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-7.4.0-to-7.5.0.sql`

## Changes to database schema

The introduction of [support for PostgreSQL](../guide/databases.md#using-postgresql) includes a change in the way database schema is generated.

It is now created based on [YAML configuration](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Bundle/EzPublishCoreBundle/Resources/config/storage/legacy/schema.yaml), using the new [`DoctrineSchemaBundle`](https://github.com/ezsystems/doctrine-dbal-schema).

If you are updating your application according to the usual procedure, no additional actions are required.
However, if you do not update your meta-repository, you need to take two additional steps:

- enable `EzSystems\DoctrineSchemaBundle\DoctrineSchemaBundle()` in `AppKernel.php`
- add [`ez_doctrine_schema`](https://github.com/ezsystems/ezplatform/blob/master/app/config/config.yml#L33) configuration

## Changes to Matrix Field Type

To migrate your content from legacy XML format to a new `ezmatrix` value use the following command:

```bash
bin/console ezplatform:migrate:legacy_matrix
```

## Required manual cache clearing if using Redis

If you are using Redis as your persistence cache storage you should always clear it manually after an upgrade.
You can do it in two ways, by using `redis-cli` and executing the following command:

```bash
FLUSHALL
```

or by executing the following command:

```bash
bin/console cache:pool:clear cache.redis
```
