# Tags

Taxonomies (**Tags**) allow you to organize content to make it easy for your site users to browse and to deliver content appropriate for them. It also enhances content search.
Taxonomies are classifications of logical relationships between content.
In [[= product_name =]] you can create many taxonomies, not only tags. The platform mechanism enables to create any entities with a tree structure and assign them to a Content.

After the installation, by default Tags are available with the following configuration in
`config/packages/ibexa_taxonomy.yaml` with associated Content Type `tag`.

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 1, 9 )=]]
```

## Configuration keys

* `ibexa_taxonomies` - section responsible for taxonomy, you can use any alphanumeric identifier
* `ibexa_taxonomies.tags.parent_location_remote_id` - Remote ID for location where new Content items representing tags are created
* `ibexa_taxonomies.tags.content_type` - Content Type identifier which stands for the taxonomy
* `ibexa_taxonomies.tags.field_mappings` - Field types map of a Content Type which taxonomy receives information about the tag from. 

Three fields are available: `identifier`, `parent` and `name`.
The identifiers correspond to field names defined in the Content Type. The `name` field is used to generate automatically an identifier.

## Customize taxonony structure

You can create other taxonomy than predefined in the system, for example a Content category.
To do it, first, create a new Content Type with `content_category` identifier and include the following field types:

* `category_identifier` of `ezstring` type
* `parent` of `ibexa_taxonomy_entry` type

Next, in the `config/packages/ibexa_taxonomy.yaml` add the following configuration:

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml')=]]
```

For more information about available functionalities of Tags, see [User Documentation]([[= user_doc =]]/taxonomy).
