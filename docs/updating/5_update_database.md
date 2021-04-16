# 5. Update the database

During database update, you have to go through all the changes between your current version and your final version.
For example, during update from v2.2 to v2.5, you have to perform all the steps from v2.3, v2.4 and v2.5.

- [Update database to v1.13](5_update_1.13.md)
- [Update database to v2.2](5_update_2.2.md)
- [Update database to v2.3](5_update_2.3.md)
- [Update database to v2.4](5_update_2.4.md)
- [Update database to v2.5](5_update_2.5.md)
- [Update database to v3.0](5_update_3.0.md)
- [Update database to v3.1](5_update_3.1.md)
- [Update database to v3.2](5_update_3.2.md)

!!! caution

    Always back up your data before running any database update scripts.

    After updating the database, clear the cache.
    
    Do not use `--force` argument for `mysql` / `psql` commands when performing update queries.
    If there is any problem during the update, it is best if the query fails immediately, so you can fix the underlying problem before you execute the update again.
    If you leave this for later you risk ending up with an incompatible database, though the problems might not surface immediately.
