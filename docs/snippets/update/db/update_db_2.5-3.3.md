Apply the following database update script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ibexa/installer/upgrade/db/mysql/ezplatform-2.5-to-ibexa-3.3.0.sql
```

If you are updating from an installation based on the `ezsystems/ezplatform-ee` metarepository, 
run the following command to upgrade your database:

``` bash
php bin/console ibexa:upgrade
```

!!! caution

    You can only run this command once.

Check the Location ID of the "Components" Content item and set it as a value of the `content_tree_module.contextual_tree_root_location_ids` key in `config/ezplatform.yaml`:

```
- 60 # Components
```

If you are upgrading between [[= product_name_com =]] versions,
add the `content/read` Policy with the Owner Limitation set to `self` to the "Ecommerce registered users" Role.
