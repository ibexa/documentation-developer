# 4. Update database

Some versions require updates to the database. Look through [the list of database update scripts](https://github.com/ezsystems/ezpublish-kernel/tree/v7.5.5/data/update/mysql)
for a script for the version you are updating to (database version numbers correspond to the `ezpublish-kernel` version).

During database update, you have to go through all the changes between your current version and your final version
**e.g. during update from v2.2 to v2.5 you have to perform all the steps from: <2.3, <2.4 and <2.5**.

Start with the version closest to your current version:

- [Updating from <1.7](4_update_1.7.md)
- [Updating from <1.13](4_update_1.13.md)
- [Updating from <2.2](4_update_2.2.md)
- [Updating from <2.3](4_update_2.3.md)
- [Updating from <2.4](4_update_2.4.md)
- [Updating from <2.5](4_update_2.5.md)

Only after applying all changes your database will work properly.

!!! caution

    Always back up your data before running any database update scripts.

    After updating the database, clear the cache.
