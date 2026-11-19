---
description: Upgrade the edition/flavour of your Ibexa DXP installation.
---

# Upgrading Ibexa DXP Edition

## Recommendations

It is recommenced that 
- Patch is up-to-date
- Minor should also be up-to-date
- One edition/flavor upgrade at a time, move to the closest upper edition:
  - oss → content
  - content → experience
  - experience → commerce

## Get upper edition dependencies

```bash
departure=content;
arrival=experience;
composer show --no-ansi ibexa/$departure | grep versions; # To check the actual version of the current edition
version=v4.4.2;
composer require ibexa/$arrival:$version --with-all-dependencies; # There might be errors while running post-update-cmd scripts
sed -i '/"ibexa\/$departure"/d' composer.json; # Remove from composer.json the previous edition to ease future updates
```

## Update configurations before imports

Some `post-update-cmd` errors may occur. Their message can be useful to found out missing configurations.

### 4.4.2, from Content to Experience

Add to config/packages/ibexa.yaml, below `framework:`, the following configurations:
```yaml
    rate_limiter:
        corporate_account_application:
            policy: 'fixed_window'
            limit: 1
            interval: '5 minutes'
            lock_factory: 'lock.corporate_account_application.factory'
    lock:
        default: '%env(LOCK_DSN)%'
        corporate_account_application: '%env(IBEXA_LOCK_DSN)%'
```

Still in config/packages/ibexa.yaml, add the siteaccess `corporate` to the list and the following `site_group`: `corporate_group: [corporate]`

Re-run `post-update-cmd` script:

```bash
composer run-script post-update-cmd;
```

### 4.4.2, from Experience to Commerce

In config/packages/ibexa.yaml:
- add the following `site_group`: `storefront_group: [site]`
- under `ibexa.repositories.default.product_catalog`, add
  ```yaml
                  regions:
                    default: ~
  ```

## Update DB schema

The composer.json of an edition gives the dependency packages to add to the edition immediately below it.
This package list help to find the schemas to apply to the already existing database.

```bash
departure=content;
arrival=experience;
version=v4.4.2;
database=ibexa

packageList=$(curl -s https://raw.githubusercontent.com/ibexa/$arrival/$version/composer.json | jq .require | grep ibexa | grep -v ibexa/$departure | cut -d '"' -f 2 | xargs);

for package in $packageList; do
  schema="vendor/$package/src/bundle/Resources/config/schema.yaml";
  if [ -f $schema ]; then
    bin/console ibexa:doctrine:schema:dump-sql $schema | mysql $database;
  fi;
  schema="vendor/$package/src/bundle/Resources/config/storage/legacy/schema.yaml";
  if [ -f $schema ]; then
    bin/console ibexa:doctrine:schema:dump-sql $schema | mysql $database;
  fi;
done;
```

## Update Repository contents

During installation, some contents are installed by Provisioners.
Those Provisioners are using several [data migration](../content_management/data_migration/data_migration.md) files to do so.

The Provisioner services needed to upgrade can be obtained by comparison:

```bash
diff <(bin/console debug:container --tag=ibexa.installer.provisioner.$departure | grep Provision | sed 's/  */ /g') <(bin/console debug:container --tag=ibexa.installer.provisioner.$arrival | grep Provision | sed 's/  */ /g') | grep '^>' | cut -d ' ' -f 3;
```

TODO: Search for migration files in each Provisioner's code. Play those migration files:

```bash
bin/console ibexa:migrations:migrate --file=$migrationFile;
```

## Update configurations after imports

### Use Customer content type from ibexa/checkout's …/migrations/customer_content_type.yaml

Remove `user_content_type_identifier: ['user', 'customer']` from config/packages/ibexa.yaml;
And, still in config/packages/ibexa.yaml, for the `site` SiteAccess, add:
```yaml
            user_registration:
              user_type_identifier: 'customer'
```