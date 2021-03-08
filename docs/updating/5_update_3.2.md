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
