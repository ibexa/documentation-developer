# Common issues

Below you will find cleanup commands from the EzPublishMigrationBundle for the most common 
issues that can occur after migration to eZ Platform.

!!! note "Enabling EzPublishMigrationBundle bundle"

    To enable EzPublishMigrationBundle add the following to your `dev` environment bundles in `app/AppKernel.php`:

    ```
    $bundles[] = new \eZ\Bundle\EzPublishMigrationBundle\EzPublishMigrationBundle();
    ```

!!! caution

    Remember about **proper backup** before running any of the commands below.

## Regenerating URL Aliases

Basic `ezplatform:regenerate:` command implements the cleanup script that will check if 
Fields of given Field Type have correct sort key, and update it if needed. 

For this specific issue use:

```
php bin/console ezplatform:regenerate:legacy_storage_url_aliases
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

## Unknown relation type 0

"Unknown relation type 0." error occurs only when using REST API. The issue does not occur 
the first time article is published (upon creation). It only happens after the article is 
edited and published.

If this error occurs use the console command below. It will clean up redundant relations rows:

```
php bin/console ezpublish:update:legacy_storage_clean_up_relation_type_eq_zero
```
The command can be executed in two modes:

- list / dry-run - prints table with all corrupted relations that will be deleted (to be executed first)
- fix - executes clean up

You can read more about this issue here: [EZP-27254](https://jira.ez.no/browse/EZP-27254)

## Always available flag set on all Fields

Always available flag is set on all Fields, instead of only on Fields in the main 
language. This problem occurs when eZ Platform is used to create Content that is both 
always available and has multiple translations. The cleanup script will correctly set 
always available flag for prioritized language filtering in Legacy Search Engine.

```
php bin/console ezpublish:update:legacy_storage_fix_fields_always_available_flag
```

Only affected Fields will be processed by the cleanup command.

You can read more about this issue here: [EZP-24882](https://jira.ez.no/browse/EZP-24882)

## Trouble listing sub content

It is possible that after upgrade `sort_key_string` is left empty. This may cause problems 
in searches throughout the API. The cleanup script will check if Fields of given Field 
Type have correct sort key, and update it if needed.

Execute the following command from the installation root directory:

```
php bin/console ezpublish:update:legacy_storage_update_sort_keys
```

You can read more about this issue here: [EZP-23924](https://jira.ez.no/browse/EZP-23924)