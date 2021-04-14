# Updating from <3.2
    
If you are updating from a version prior to 3.0, you have to implement all the changes from [Upgrading eZ Platform to v3](../upgrading/upgrading_to_v3.md) before following the steps below.

!!! note

    During database update, you have to go through all the changes between your current version and your final version
    **for example, when you update from v2.2 to v2.5, you have to perform all the steps from: <2.3, <2.4 and <2.5**.
    The database will work properly only if you apply all the required changes.

!!! caution "Updating a schema for entity managers"

    If you are updating to v3.2.6, after you complete the procedure,
    do the steps described in the [Update entity managers](#update-entity-managers) section
    to update the GraphQL schema that is generated from your Repository.
    
## Check out and update the app

1\. [Check out a tagged version](../updating/1_check_out_version.md)

2\. [Merge composer.json](../updating/2_merge_composer.md)

3\. [Update the app](../updating/3_update_app.md)

## Run the database update script

!!! dxp "Ibexa DXP or Ibexa Commerce"

    If you are using Ibexa DXP or Ibexa Commerce, apply one of the following database update scripts:
    
    - for MySQL:

    `mysql -u <username> -p <password> <database_name> < upgrade/db/mysql/ezplatform-3.1.0-to-3.2.0.sql`

    - for PostgreSQL:

    `psql <database_name> < upgrade/db/postgresql/ezplatform-3.1.0-to-3.2.0.sql`

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

## Continue with the update procedure

At this point you can continue with the standard update procedure:

5\. [Platform.sh changes](../updating/5_platform_sh_changes.md)

6\. [Dump assets](../updating/../updating/6_dump_assets.md)

7\. [Commit, test and merge](../updating/7_commit_test_merge.md)
