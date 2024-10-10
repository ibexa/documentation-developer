---
description: "PIM training: Migration"
edition: experience
page_type: training
---

# Product model migration

After having modeled your catalog organization on your local developer instance,
you may want/need to [generate migration files](exporting_data.md) to install the model on a shared instance
(for example a staging instance or the production instance) where the creation of the products will be done.

Export attribute groups, attributes, and product types:

``` bash
php bin/console ibexa:migrations:generate \
  --type=attribute_group --mode=create \
  --match-property=identifier --value=bike --value=mtb-s4 --value=mtb-s5 \
  --siteaccess=admin;

# Where 2, 3, and 4 are the IDs of the attribute groups bike, mtb-s4, and mtb-s5
php bin/console ibexa:migrations:generate \
  --type=attribute --mode=create \
  --match-property=attribute_group_id --value=2 --value=3 --value=4 \
  --siteaccess=admin;

php bin/console ibexa:migrations:generate \
  --type=content_type --mode=create \
  --match-property=content_type_identifier --value=mtb-s4 --value=mtb-s5 \
  --siteaccess=admin;
```

Export product categories:

``` bash
# Where 63 is the "Product Root Tag" Location ID (Product catalog > Categories)
php bin/console ibexa:migrations:generate \
  --type=content --mode=create \
  --match-property=parent_location_id --value=63 \
  --siteaccess=admin;
```
