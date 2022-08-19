---
description: A taxonomy uses tags to categorize and organize content
---

# Taxonomy

Taxonomies (**Tags**) allow you to organize content to make it easy for your site users to browse and to deliver content appropriate for them. It also enhances content search.
Taxonomies are classifications of logical relationships between content.
In [[= product_name =]] you can create many taxonomies, each with many tags. The platform mechanism enables creating any entities with a tree structure and assign them to a Content item.

Default tag configuration is available in `config/packages/ibexa_taxonomy.yaml`
The associated Content Type is `tag`.

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 1, 9 )=]]
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

To do it, first, create a new container to store the new taxonomy's items, for example a `folder` named Content categories.

Next, in `config/packages/ibexa_taxonomy.yaml` add the following configuration:

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml')=]]
```

Replace `<content_categories_remote_id>` with the new container's location remote ID.

Translate the configuration identifier in the `ibexa_taxonomy` domain by, for example, creating a `translations/ibexa_taxonomy.en.yaml` file containing the following:
```yaml
taxonomy.content_categories: 'Content categories'
```

Then, create a Content Type with `content_category` identifier and include the following Field Types:

* `name_field` of `ezstring` type and required
* `category_identifier` of `ezstring` type and required
* `parent_category` of `ibexa_taxonomy_entry` type and not required, in its Taxonomy drop-down menu, select Content categories (or `taxonomy.content_categories` if no translation has been provided).

Finish taxonomy set-up by creating a new Content category named Root with identifier `content_categories_root` under the previously created container folder named Content categories.

To use this new taxonomy, add an `ibexa_taxonomy_entry_assignement` field to a Content Type and select Content categories (or `taxonomy.content_categories`) in its Taxonomy drop-down setting.

For more information about available functionalities of tags, see [User Documentation]([[= user_doc =]]/taxonomy).
