# Common errors

Below you will find cleanup commands from the EzPublishMigrationBundle for most common 
issues that can manifest itself after migration to v1 or v2.

!!! note "Enabling EzPublishMigrationBundle bundle"

    To enable it, add the following to your `dev` environment bundles in `app/AppKernel.php`:

    ```
    $bundles[] = new \eZ\Bundle\EzPublishMigrationBundle\EzPublishMigrationBundle();
    ```

## Unknown relation type 0

"Unknown relation type 0." error occurs only when using REST API. It is caused by 
inserting  different images into two or more XML block fields. The issue does not occur 
the first time article is published (upon creation). It only happens after the article is 
edited and published.

If this error occurs use below console command that will clean up redundant relations rows:

```
ezpublish:update:legacy_storage_clean_up_relation_type_eq_zero
```
The command can be executed in two modes:

- fix - executes clean up
- list / dry-run - prints table with all corrupted relations that will be deleted

## Regenerating URL Aliases

Basic `ezplatform:regenerate:` command implements the cleanup script that will check if 
fields of given field type have correct sort key, and update it if needed. 

For this specific issue use:

```
ezplatform:regenerate:legacy_storage_url_aliases
```

It will regenerate URL aliases for Locations and migrate existing custom Location and 
global URL aliases to a separate database table. The separate table must be named 
`__migration_ezurlalias_ml` and should be created manually to be identical (but empty) 
as the existing table `ezurlalias_ml` before the command is executed.

After the script finishes, to complete migration the table should be renamed to 
`ezurlalias_ml` manually. Using available options for `action` argument, you can back up 
custom Location and global URL aliases separately and inspect them before restoring them 
to the migration table. They will be stored in backup tables named 
`__migration_backup_custom_alias` and `__migration_backup_global_alias` (created 
automatically).

It is also possible to skip custom Location and global URL aliases altogether and 
regenerate only automatically created URL aliases for Locations (use the `autogenerate` 
action to achieve this). During the script execution the database should not be modified. 
Since this script can potentially run for a very long time, to avoid memory exhaustion run 
it in production environment using the `--env=prod` switch.

## Always available flag set on all fields

Always available flag is set on all fields, instead of only on fields in the main 
language. This problem occurs when a new stack is used for creating Content that is both 
always available and has multiple translations. 

Cleanup script will set correctly always available flag for prioritized language filtering in Legacy Search Engine.

```
ezpublish:update:legacy_storage_fix_fields_always_available_flag
```

In the cleanup command only affected fields will be processed.

## Trouble listing sub content

It is possible that after upgrade sort_key_string is left empty that may cause problems in 
searches throughout the API. The cleanup script will check if fields of given field type 
have correct sort key, and update it if needed.

Execute following command from the installation root directory:

```
php app/console ezpublish:update:legacy_storage_update_sort_keys
```