# 4. Update database

Some versions require updates to the database. Look through the list of database update scripts
[for MySQL](https://github.com/ezsystems/ezpublish-kernel/tree/v6.13.6/data/update/mysql)
and find a script for the database version you are updating to.

!!! tip "Database version number"

    Database version number corresponds to the `ezpublish-kernel` version.

    To find out which `ezpublish-kernel` version you have, after running `composer update` or `composer install`
    run `composer show ezsystems/ezpublish-kernel|grep versions`.

During database update, you have to go through all the changes between your current version and your final version
**e.g. during update from v2.2 to v2.5 you have to perform all the steps from: <2.3, <2.4 and <2.5**.

Start with the version closest to your current version:

- [Updating from <1.7](4_update_1.7.md)
- [Updating from <1.13](4_update_1.13.md)
- [Updating from <2.2](4_update_2.2.md)
- [Updating from <2.3](4_update_2.3.md)
- [Updating from <2.4](4_update_2.4.md)
- [Updating from <2.5](4_update_2.5.md)
- [Updating from <3.0](../upgrading/upgrading_to_v3.md)
- [Updating from <3.1](4_update_3.1.md)

Only after applying all changes your database will work properly.

!!! caution

    Always back up your data before running any database update scripts.

    After updating the database, clear the cache.
    
    Do not use `--force` argument for `mysql` / `psql` commands when performing update queries.
    If there is any problem during the update, it is best if the query fails immediately, so you can fix the underlying problem before you execute the update again.
    If you leave this for later you risk ending up with an incompatible database, though the problems might not surface immediately.
