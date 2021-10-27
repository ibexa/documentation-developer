!!! caution

    Always back up your data before running any database update scripts.

    After updating the database, clear the cache.
    
    Do not use `--force` argument for `mysql` / `psql` commands when performing update queries.
    If there is any problem during the update, it is best if the query fails immediately, so you can fix the underlying problem before you execute the update again.
    If you leave this for later you risk ending up with an incompatible database, though the problems might not surface immediately.
