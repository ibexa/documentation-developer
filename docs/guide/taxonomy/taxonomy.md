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
To do it, first, create a new Content Type with `content_category` identifier and include the following Field Types:

* `category_identifier` of `ezstring` type
* `parent` of `ibexa_taxonomy_entry` type
* `name` of `string` type

Next, in `config/packages/ibexa_taxonomy.yaml` add the following configuration:

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml')=]]
```

For more information about available functionalities of tags, see [User Documentation]([[= user_doc =]]/taxonomy).
