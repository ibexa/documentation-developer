# Updating from <3.2
    
If you are updating from a version prior to 3.0, you have to implement all the changes from [Upgrading eZ Platform to v3](../upgrading/upgrading_to_v3.md) before following the steps below.

!!! note

    During database update, you have to go through all the changes between your current version and your final version
    **e.g. during update from v2.2 to v2.5 you have to perform all the steps from: <2.3, <2.4 and <2.5**.
    Only after applying all changes your database will work properly.
    
## Check out and update the app

1\. [Check out a tagged version](../updating/1_check_out_version.md)

2\. [Merge composer.json](../updating/2_merge_composer.md)

3\. [Update the app](../updating/3_update_app.md)

## Database update script

!!! dxp "Ibexa DXP or Ibexa Commerce"

    If you are using Ibexa DXP or Ibexa Commerce, apply the following database update script:

    `mysql -u <username> -p <password> <database_name> < upgrade/db/mysql/dbupdate-7.2.0-to-7.3.0.sql`

    or for PostgreSQL:

    `psql <database_name> < upgrade/db/postgresql/ezplatform-3.1.0-to-3.2.0.sql`

## Continue update procedure

At this point you can continue with the standard update procedure:

5\. [Platform.sh changes](../updating/5_platform_sh_changes.md)

6\. [Dump assets](../updating/../updating/6_dump_assets.md)

7\. [Commit, test and merge](../updating/7_commit_test_merge.md)
