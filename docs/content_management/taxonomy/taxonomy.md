---
description: A taxonomy uses tags to categorize and organize content
---

# Taxonomy

Taxonomies (**Tags**) allow you to organize content to make it easy for your site users to browse and to deliver content appropriate for them. 
Taxonomies are classifications of logical relationships between content.
In [[= product_name =]] you can create many taxonomies, each with many tags. The platform mechanism enables creating any entities with a tree structure and assign them to a Content item.

Default tag configuration is available in `config/packages/ibexa_taxonomy.yaml`
The associated Content Type is `tag`.

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 0, 9 )=]]
```

## Configuration keys

* `ibexa_taxonomies` - section responsible for taxonomy structure where you can [configure other taxonomies](#customize-taxonomy-structure)
* `ibexa_taxonomies.tags.parent_location_remote_id` - Remote ID for Location where new Content items representing tags are created
* `ibexa_taxonomies.tags.content_type` - Content Type identifier which stands for the tags
* `ibexa_taxonomies.tags.field_mappings` - Field Types map of a Content Type which taxonomy receives information about the tag from. 

Three fields are available: `identifier`, `parent` and `name`.
The identifiers correspond to Field names defined in the Content Type. The `name` Field is used to automatically generate an identifier.

## Customize taxonomy structure

You can create other taxonomies than the one predefined in the system, for example a Content category.

To do it, first, create a new container to store the new taxonomy's items, for example a folder named "Content categories".

Next, under the `ibexa_taxonomy.taxonomies` [key](configuration.md#configuration-files) add the following configuration:

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 0, 2)=]]        # existing keys
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 9, 17)=]]
```

Replace `<content_categories_remote_id>` with the new container's Location remote ID.

Translate the configuration identifier in the `ibexa_taxonomy` domain by, for example, creating a `translations/ibexa_taxonomy.en.yaml` file containing the following:
```yaml
taxonomy.content_categories: 'Content categories'
```

Then, create a Content Type with `content_category` identifier and include the following Field definitions:

* `name` of `ezstring` type and required. Use this Field, as `<name>`, for content name pattern.
* `category_identifier` of `ezstring` type and required.
* `parent_category` of `ibexa_taxonomy_entry` type and not required. In its Taxonomy drop-down menu, select Content categories (or `taxonomy.content_categories` if no translation has been provided).

Finish taxonomy setup by creating a new Content category named Root with identifier `content_categories_root` under the previously created container folder named Content categories.

To use this new taxonomy, add an `ibexa_taxonomy_entry_assignement` Field to a Content Type and select Content categories (or `taxonomy.content_categories`) in its Taxonomy drop-down setting.

### Hide Content tab

The **Content** tab in taxonomy objects, for example, tags and categories, lists all Content assigned to the current taxonomy.
You can hide the **Content** tab in the **Categories** view.

In configuration add `assigned_content_tab` with the flag `false` (for other taxonomies this flag is by default set to `true`):

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 0, 2)=]]        # existing keys
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 9, 17)=]]
```

For more information about available functionalities of tags, see [User Documentation]([[= user_doc =]]/taxonomy).

## Hide delete button on large subtree

The **Delete** button can be hidden when a taxonomy entry has many children.
By default, the button is hidden when there are 100 children or more.

The `delete_subtree_size_limit` configuration is [SiteAccess-aware](siteaccess_aware_configuration.md), and can be set per SiteAccess, per SiteAccess group, or globally per default.
For example:

```yaml
ibexa:
    system:
        default: # or a SiteAccess, or a SiteAccess group
            taxonomy:
                admin_ui:
                    delete_subtree_size_limit: 20
```

## Remove orphaned Content items

In some rare case, especially in [[= product_name =]] v4.2 and older, when deleting parent of huge subtrees, some Taxonomy entries are not properly deleted, leaving Content items that point to a non-existing parent.
The command `ibexa:taxonomy:remove-orphaned-content` deletes those orphaned Content item.
It works on a taxonomy passed as an argument, and has two options that act as a protective measure against deleting data by mistake:

- `--dry-run` to list deletable Content items, without performing the deletion.
- `--force` to effectively delete the orphaned Content items.

The following example first lists the orphaned Content items for taxonomy `tags`, and then deletes them:

```bash
php bin/console ibexa:taxonomy:remove-orphaned-content tags --dry-run
php bin/console ibexa:taxonomy:remove-orphaned-content tags --force
```
