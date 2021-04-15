# Update database to v3.2

If you are updating from a version prior to v3.1, you have to implement all the changes [from v3.1](5_update_3.1.md) before following the steps below.

If you are using Ibexa DXP or Ibexa Commerce, apply one of the following database update scripts:

- for MySQL:

``` bash
mysql -u <username> -p <password> <database_name> < upgrade/db/mysql/ezplatform-3.1.0-to-3.2.0.sql
```

- for PostgreSQL:

``` bash
psql <database_name> < upgrade/db/postgresql/ezplatform-3.1.0-to-3.2.0.sql
```

## Update entity managers

Version v3.2.6 introduces new entity managers.
To ensure that they work in multi-repository setups, you must update the GraphQL schema.
You do this manually by following this procedure:

1. Update your project to v3.2.6 and run the `php bin/console cache:clear` command to generate the [service container](../guide/service_container.md).

1. Run the following command to discover the names of the new entity managers. 
    Take note of the names that you discover:

    `php bin/console debug:container --parameter=doctrine.entity_managers --format=json | grep ibexa_`

1. For every entity manager prefixed with `ibexa_`, run the following command:

    `php bin/console doctrine:schema:update --em=<ENTITY_MANAGER_NAME> --dump-sql`
  
1. Review the queries and ensure that there are no harmful changes that could affect your data.

1. For every entity manager prefixed with `ibexa_`, run the following command to run queries on the database:

    `php bin/console doctrine:schema:update --em=<ENTITY_MANAGER_NAME> --force`
