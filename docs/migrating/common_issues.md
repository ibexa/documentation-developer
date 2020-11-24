# Common issues

Below you will find cleanup commands from the EzPublishMigrationBundle for the most common
issues that can occur after migration to [[= product_name =]].

!!! note "Enabling EzPublishMigrationBundle bundle"

    To enable EzPublishMigrationBundle add the following to your `dev` environment bundles in `app/AppKernel.php`:

    ```
    $bundles[] = new \eZ\Bundle\EzPublishMigrationBundle\EzPublishMigrationBundle();
    ```

!!! caution

    Remember about [**proper backup**](../guide/backup.md) before running any of the commands below.

## Regenerating URL aliases

To regenerate URL aliases, use the `ezplatform:urls:regenerate-aliases` command.
See [Regenerating URL aliases](../guide/url_management.md#regenerating-url-aliases) for more information.

!!! note

    This command keeps history and replaces the old `ezplatform:regenerate:legacy_storage_url_aliases` command.
    `legacy_storage_url_aliases` is now deprecated.

## Unknown relation type 0

"Unknown relation type 0." error occurs only when using REST API. The issue does not occur
the first time article is published (upon creation). It only happens after the article is
edited and published.

If this error occurs use the console command below. It will clean up redundant Relations rows:

```
php bin/console ezpublish:update:legacy_storage_clean_up_relation_type_eq_zero
```
The command can be executed in two modes:

- list / dry-run - prints table with all corrupted Relations that will be deleted (to be executed first)
- fix - executes clean up

You can read more about this issue here: [EZP-27254](https://jira.ez.no/browse/EZP-27254)

## Always available flag set on all Fields

Always available flag is set on all Fields, instead of only on Fields in the main
language. This problem occurs when [[= product_name =]] is used to create content that is both
always available and has multiple translations. The cleanup script will correctly set
always available flag for prioritized language filtering in Legacy search engine.

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
