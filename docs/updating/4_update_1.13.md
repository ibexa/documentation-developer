# Updating from <1.13
    
If you are updating from a version prior to 1.7, you have to implement all the changes from [Updating from <1.7](4_update_1.7.md) before following the steps below.

!!! note

    During database update, you have to go through all the changes between your current version and your final version
    **e.g. during update from v2.2 to v2.5 you have to perform all the steps from: <2.3, <2.4 and <2.5**.
    Only after applying all changes your database will work properly.

## Updating from <1.8

### Changes to permissions

v1.8.0 introduced a new `content/publish` permission separated out of the `content/edit` permission.
`edit` now covers only editing content, without the right to publishing it.
For that you need the `publish` permission.
`edit` without `publish` can be used in conjunction with the content review workflow to ensure that a user cannot publish content themselves, but must pass it on for review.

To make sure existing users will be able to both edit and publish content, those with the `content/edit` permission will be given the `content/publish` permission by the following database update script:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.7.0-to-6.8.0.sql
```

### Changes to form-uploaded files

To complete this step you have to [dump assets](6_dump_assets.md) first.

Since v1.8.0 you can add a File field to the Form block on a Landing Page.
Files uploaded through such a form will be automatically placed in a specific folder in the repository.

If you are upgrading to v1.8+ you need to create this folder and assign it to a new specific Section.
Then, add them in the config (for example, in `app/config/default_parameters.yml`, depending on how your configuration is set up):

``` bash
#Location id of the root for form uploads
form_builder.upload_folder.location_id: <folder location id>

#Section identifier for form uploads
form_builder.upload_folder.section_identifier: <section identifier>
```

## Updating from <1.11
 
### `ezsearch_return_count` table removal

v1.11.0 removes the `ezsearch_return_count` table, which had been removed in eZ Publish legacy since 5.4/2014.11.
This avoids issues which would occur when you upgrade using legacy bridge.
Apply the following database update script if your installation has not had the table removed by an earlier eZ Publish upgrade:

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.10.0-to-6.11.0.sql
```

## Updating from <1.12

### Increased password hash length

v1.12.0 improves password security by introducing support for PHP's `PASSWORD_BCRYPT` and `PASSWORD_DEFAULT` hashing algorithms.
By default `PASSWORD_DEFAULT` is used.
This currently uses bcrypt, but this may change in the future as PHP adds support for new and stronger algorithms.
Apply the following database update script to change the schema and enable the storage of longer passwords.
Note that the script is available for PostgreSQL as well.

``` bash
mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.11.0-to-6.12.0.sql
```

These algorithms produce longer hashes, and so the length of the `password_hash` column of the `ezuser` table must be increased, like this:

**MySQL**

​``` sql
ALTER TABLE ezuser CHANGE password_hash password_hash VARCHAR(255) default NULL;
​```

**PostgreSQL**

​``` sql
ALTER TABLE ezuser ALTER COLUMN password_hash TYPE VARCHAR(255);
​```

## Run general database update script

Apply the following database update script:

`mysql -u <username> -p <password> <database_name> < vendor/ezsystems/ezpublish-kernel/data/update/mysql/dbupdate-6.13.3-to-6.13.4.sql`

You can now follow the steps from [Updating from <2.2](4_update_2.2.md).
