Apply the following database update script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ezplatform-2.5-to-ibexa-3.3.0.sql
```

If you're updating from an installation based on the `ezsystems/ezplatform-ee` metarepository, run the following command to upgrade your database:

``` bash
php bin/console ibexa:upgrade
```

!!! caution

    You can only run this command once.

Check the location ID of the "Components" content item and set it as a value of the `content_tree_module.contextual_tree_root_location_ids` key in `config/ezplatform.yaml`:

```
- 60 # Components
```

If you're upgrading between [[= product_name_com =]] versions, add the `content/read` policy with the Owner limitation set to `self` to the "Ecommerce registered users" role.
