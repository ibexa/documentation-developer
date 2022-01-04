# Tags

Taxonomies (Tags) allow you to organize content to make it easy for your site users to browse and to deliver content appropriate for them. It also enhances content search.
Taxonomies are classifications of logical relationships between content.
In [[= product_name =]]
You can create in the system many taxonomies, not necessary only tags. The mechanism enables to create any entities which have a tree structure and can be assigned to the content.
After the installation, out of the box, only Tags are available which are linked using the default configuration in:
`config/packages/ibexa_taxonomy.yaml` with Content Type `tag`:

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 1, 8 )=]]
```

## Configuration keys

* `ibexa_taxonomies` - this section is responsible for taxonomy, you can use any alphanumeric identifier
* `ibexa_taxonomies.tags.parent_location_remote_id` - remote ID for location where new Content items are created that represent these tags
* `ibexa_taxonomies.tags.content_type` - Content type identifier which represents given taxonomy
* `ibexa_taxonomies.tags.field_mappings` - map of content field types from which taxonomy gets info about the tag. Two fields `identifier` and `parent`, identifiers coresponds to field names defined in the the Content Type

## Customize taxonony structure


You can create other taxonomy than predefined in the system, for example a content category.
To do it, first, create a new Content Type with `content_category` identifier and include the following field types:

- `category_identifier` of `ezstring` type
- `parent` of `ibexa_taxonomy_entry` type

Next, in the `config/packages/ibexa_taxonomy.yaml` add the following configuration:

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml')=]]
```

