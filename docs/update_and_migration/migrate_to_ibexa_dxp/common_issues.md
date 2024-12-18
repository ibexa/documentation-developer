---
description: Check common issues that occur when updating from earlier version to Ibexa DXP and how to resolve them.
---

# Common migration issues

Below you can find cleanup commands from the EzPublishMigrationBundle for the most common issues that can occur after migration to [[= product_name =]].

!!! note "Enabling EzPublishMigrationBundle bundle"

    To enable EzPublishMigrationBundle add the following to your `dev` environment bundles in `app/AppKernel.php`:

    ```
    $bundles[] = new \eZ\Bundle\EzPublishMigrationBundle\EzPublishMigrationBundle();
    ```

!!! caution

    Remember about [**proper backup**](backup.md) before running any of the commands below.

## Regenerating URL aliases

To regenerate URL aliases, use the `ibexa:urls:regenerate-aliases` command.

For more information, see [Regenerating URL aliases](url_management.md#regenerating-url-aliases).

!!! note

    This command keeps history and replaces the old `ibexa:regenerate:legacy_storage_url_aliases` command.
    `legacy_storage_url_aliases` is now deprecated.

## Normalizing images

If you use image files with unprintable UTF-8 characters, you may come across a problem with images not displaying.
In that case, run the `ezplatform:images:normalize-path` command to normalize them:

``` bash
php bin/console ezplatform:images:normalize-path
```

!!! note "Special characters"

    If a corrupted path is detected, check the `var_dir` configuration for any special or Unicode characters.

## Unknown relation type 0

"Unknown relation type 0." error occurs only when using REST API.
The issue doesn't occur the first time article is published (upon creation).
It only happens after the article is edited and published.

If this error occurs use the console command below.
It cleans up redundant Relations rows:

```
php bin/console ezpublish:update:legacy_storage_clean_up_relation_type_eq_zero
```
The command can be executed in two modes:

- list / dry-run - prints table with all corrupted Relations that are deleted (to be executed first)
- fix - executes clean up

You can read more about this issue here: [EZP-27254](https://issues.ibexa.co/browse/EZP-27254)

## Always available flag set on all fields

Always available flag is set on all fields, instead of only on fields in the main language.
This problem occurs when [[= product_name =]] is used to create content that is both always available and has multiple translations.
The cleanup script correctly sets always available flag for prioritized language filtering in Legacy search engine.

```
php bin/console ezpublish:update:legacy_storage_fix_fields_always_available_flag
```

Only affected fields are processed by the cleanup command.

You can read more about this issue here: [EZP-24882](https://issues.ibexa.co/browse/EZP-24882)

## Listing sub-content

It's possible that after upgrade `sort_key_string` is left empty.
This may cause problems in searches throughout the API.
The cleanup script checks if fields of given field type have correct sort key, and update it if needed.

Execute the following command from the installation root directory:

```
php bin/console ezpublish:update:legacy_storage_update_sort_keys
```

You can read more about this issue here: [EZP-23924](https://issues.ibexa.co/browse/EZP-23924)
