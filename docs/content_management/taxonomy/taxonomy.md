---
description: A taxonomy uses tags to categorize and organize content
---

# Taxonomy

Taxonomies (**Tags**) allow you to organize content to make it easy for your site users to browse and to deliver content appropriate for them.
Taxonomies are classifications of logical relationships between content.
In [[= product_name =]] you can create many taxonomies, each with many tags. The platform mechanism enables creating any entities with a tree structure and assign them to a content item.

Default tag configuration is available in `config/packages/ibexa_taxonomy.yaml`
The associated content type is `tag`.

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 0, 9) =]]
```

## Configuration keys

* `ibexa_taxonomies` - section responsible for taxonomy structure where you can [configure other taxonomies](#customize-taxonomy-structure)
* `ibexa_taxonomies.tags.parent_location_remote_id` - Remote ID for location where new content items representing tags are created
* `ibexa_taxonomies.tags.content_type` - Content type identifier which stands for the tags
* `ibexa_taxonomies.tags.field_mappings` - field types map of a content type which taxonomy receives information about the tag from.

Three fields are available: `identifier`, `parent` and `name`.
The identifiers correspond to field names defined in the content type. The `name` field is used to automatically generate an identifier.

## Customize taxonomy structure

You can create other taxonomies than the one predefined in the system, for example a Content category.

To do it, first, create a new container to store the new taxonomy's items, for example a folder named "Content categories".

Next, under the `ibexa_taxonomy.taxonomies` [key](configuration.md#configuration-files) add the following configuration:

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 0, 2) =]]        # existing keys
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 9, 17) =]]
```

Replace `<content_categories_remote_id>` with the new container's location remote ID.

Translate the configuration identifier in the `ibexa_taxonomy` domain by, for example, creating a `translations/ibexa_taxonomy.en.yaml` file containing the following:
```yaml
taxonomy.content_categories: 'Content categories'
```

Then, create a content type with `content_category` identifier and include the following field definitions:

* `name` of `ibexa_string` type and required. Use this field, as `<name>`, for content name pattern.
* `category_identifier` of `ibexa_string` type and required.
* `parent_category` of `ibexa_taxonomy_entry` type and not required. In its Taxonomy drop-down menu, select Content categories (or `taxonomy.content_categories` if no translation has been provided).

Finish taxonomy setup by creating a new Content category named Root with identifier `content_categories_root` under the previously created container folder named Content categories.

To use this new taxonomy, add an `ibexa_taxonomy_entry_assignement` field to a content type and select Content categories (or `taxonomy.content_categories`) in its Taxonomy drop-down setting.

### Hide Content tab

The **Content** tab in taxonomy objects, for example, tags and categories, lists all Content assigned to the current taxonomy.
You can hide the **Content** tab in the **Categories** view.

In configuration add `assigned_content_tab` with the flag `false` (for other taxonomies this flag is by default set to `true`):

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 0, 2) =]]        # existing keys
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 9, 17) =]]
```

### Hide menu item

By default, for each taxonomy, a menu item is added to the main menu.
You can hide this menu item by setting a value of the `register_main_menu` configuration key:

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 0, 2) =]]        # existing keys
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 9, 10) =]]            # existing keys
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 17, 18) =]]
```

For more information about available functionalities of tags, see [User Documentation]([[= user_doc =]]/content_management/taxonomy/taxonomy/).

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

## Remove orphaned content items

In some rare case, especially in [[= product_name =]] v4.2 and older, when deleting parent of huge subtrees, some Taxonomy entries aren't properly deleted, leaving content items that point to a non-existing parent.
The command `ibexa:taxonomy:remove-orphaned-content` deletes those orphaned content item.
It works on a taxonomy passed as an argument, and has two options that act as a protective measure against deleting data by mistake:

- `--dry-run` to list deletable content items, without performing the deletion.
- `--force` to effectively delete the orphaned content items.

The following example first lists the orphaned content items for taxonomy `tags`, and then deletes them:

```bash
php bin/console ibexa:taxonomy:remove-orphaned-content tags --dry-run
php bin/console ibexa:taxonomy:remove-orphaned-content tags --force
```

## Taxonomy suggestions

Once the feature is enabled, with taxonomy suggestions, editors can pick from suggestions generated by an AI service based on selected fields like the product's or content item's name and description instead of having to manually browse through taxonomy trees and selecting [product categories]([[= user_doc =]]pim/work_with_product_categories/#assign-product-categories-by-editing-product-details) or [tags]([[= user_doc =]]/content_management/create_edit_content_items/#add-taxonomy-entries).

Taxonomy suggestions build on existing [AI Actions](ai_actions_guide.md) functionality.
The `TaxonomyEmbeddingFieldProvider` uses an existing taxonomy tree as reference, generating an embedding for each path in the taxonomy tree, a multi-dimensional vector aka. embedding is generated and stored in the search index.

When the editor creates or edits a content item or a product, they can request that the application suggests tags or product categories to be associated with the item.
When it happens, the `TextToTaxonomyActionHandler` requests that an embedding is generated based on selected fields such as name and description.
The text fields, whose values are used as source for the embedding generation, are defined when you create an [AI action](https://doc.ibexa.co/projects/userguide/en/latest/ai_actions/work_with_ai_actions/#create-ai-actions-that-use-ibexa-connect) that uses the `openai-text-to-taxonomy-entries handler`.

The search engine then compares the generated embedding with the taxonomy path embeddings stored in its index.
It selects the three best-matching taxonomy paths and presents them to the editor as suggestions.
The user can accept the suggestions, reject them, or request a new set of suggestions directly from the user interface.
