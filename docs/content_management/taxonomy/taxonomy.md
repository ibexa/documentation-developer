---
description: A taxonomy uses tags to categorize and organize content
month_change: false
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

- `ibexa_taxonomies` - section responsible for taxonomy structure where you can [configure other taxonomies](#customize-taxonomy-structure)
- `ibexa_taxonomies.tags.parent_location_remote_id` - Remote ID for location where new content items representing tags are created
- `ibexa_taxonomies.tags.content_type` - Content type identifier which stands for the tags
- `ibexa_taxonomies.tags.field_mappings` - field types map of a content type which taxonomy receives information about the tag from.

Three fields are available: `identifier`, `parent` and `name`.
The identifiers correspond to field names defined in the content type. The `name` field is used to automatically generate an identifier.

## Customize taxonomy structure

You can create other taxonomies than the one predefined in the system, for example a Content category.

To do it, first, create a new container to store the new taxonomy's items, for example a folder named "Content categories".

Next, under the `ibexa_taxonomy.taxonomies` [key](configuration.md#configuration-files) add the following configuration:

``` yaml
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 0, 2) =]]        # existing keys
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 9, 16) =]]
```

Replace `<content_categories_remote_id>` with the new container's location remote ID.

Translate the configuration identifier in the `ibexa_taxonomy` domain by, for example, creating a `translations/ibexa_taxonomy.en.yaml` file containing the following:

```yaml
taxonomy.content_categories: 'Content categories'
```

Then, create a content type with `content_category` identifier and include the following field definitions:

- `name` of `ibexa_string` type and required. Use this field, as `<name>`, for content name pattern.
- `category_identifier` of `ibexa_string` type and required.
- `parent_category` of `ibexa_taxonomy_entry` type and not required. In its Taxonomy drop-down menu, select Content categories (or `taxonomy.content_categories` if no translation has been provided).

Finish taxonomy setup by creating a new Content category named Root with identifier `content_categories_root` under the previously created container folder named Content categories.

To use this new taxonomy, add an `ibexa_taxonomy_entry_assignement` field to a content type and select Content categories (or `taxonomy.content_categories`) in its Taxonomy drop-down setting.

### Hide Content tab

The **Content** tab in taxonomy objects, for example, tags and categories, lists all Content assigned to the current taxonomy.
You can hide the **Content** tab in the **Categories** view.

In configuration add `assigned_content_tab` with the flag `false` (for other taxonomies this flag is by default set to `true`):

``` yaml hl_lines="11"
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 0, 2) =]]        # existing keys
[[= include_file('code_samples/taxonomy/config/packages/ibexa_taxonomy.yaml', 9, 17) =]]
```

### Hide menu item

By default, for each taxonomy, a menu item is added to the main menu.
You can hide this menu item by setting a value of the `register_main_menu` configuration key:

``` yaml hl_lines="6"
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

In some rare case, especially in [[= product_name =]] v4.2 and older, when deleting parent of huge subtrees, some taxonomy entries aren't properly deleted, leaving content items that point to a non-existing parent.
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

Once the feature is [enabled](#enable-taxonomy-suggestions), with taxonomy suggestions, editors can pick from suggestions generated by an AI service based on selected fields like the product's or content item's name and description instead of having to manually browse through taxonomy trees and selecting [product categories]([[= user_doc =]]/product_catalog/work_with_product_categories/#assign-product-categories-by-editing-product-details) or [tags]([[= user_doc =]]/content_management/create_edit_content_items/#add-taxonomy-entries).

Taxonomy suggestions build on existing [AI Actions](ai_actions_guide.md) functionality.
The [`TaxonomyEmbeddingFieldProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Taxonomy-Embedding-TaxonomyEmbeddingFieldProviderInterface.html)
 service uses an existing taxonomy tree as reference, generating an embedding for each path in the taxonomy tree and storing it in the search index.

For performance reasons, embeddings for the taxonomy tree entries are generated only in two cases:

- when the search engine is reindexed, for example, right after you enable the feature and run the `ibexa:reindex` command
- when an individual taxonomy entry is created or modified, it's embedding is updated

When the editor creates or edits a content item or a product, they can request that the application suggests tags or product categories to be associated with the item.
When it happens, the `Ibexa\Taxonomy\ActionHandler\TextToTaxonomyActionHandler` requests that an embedding is generated based on selected fields such as, for example, name and description.

!!! note "Field selection"

    You select the actual text fields, whose values are used as source for the embedding generation, when you create an [AI action]([[= user_doc =]]/ai_actions/work_with_ai_actions/#create-ai-actions-that-use-ibexa-connect) that uses the `text-to-taxonomy` handler.

The search engine then compares the generated embedding with the taxonomy path embeddings stored in its index.
By default, it selects the three best-matching taxonomy paths and presents them to the editor as suggestions.
The user can accept the suggestions, reject them, or request a new set of suggestions directly from the user interface.

### Enable Taxonomy suggestions

Taxonomy suggestions are built into the product and do not require additional installation.
However, before you can enable it, make sure the following prerequisites have been fulfilled:

- [Search engine](search_engines.md): Taxonomy suggestions require a search engine that supports vector search.
The feature has been tested to work with Elasticsearch or Solr 9.8.1+.
- [AI Actions](ai_actions.md): To be able to process embeddings, Taxonomy suggestions require that you have the AI Actions configured to support the default [OpenAI](configure_ai_actions.md#configure-access-to-openai) or the optional [Google Gemini](configure_ai_actions.md#install-google-gemini-connector) service.

!!! note "Alternative embeddings provider"

    To use Google Gemini as an alternative embeddings provider, you must also modify the default [taxonomy suggestions settings](taxonomy.md#change-embeddings-provider-to-google-gemini).

#### Enable taxonomy embedding indexing

Enable embedding indexing for taxonomy branches by changing the default setting from `false` to `true`.
Toggle this setting at any time to enable or disable indexing of taxonomy embeddings.

```yaml hl_lines="6"
ibexa:
    system:
        default:
            taxonomy:
                search:
                    index_embeddings: true
                    default_embedding_model: 'text-embedding-ada-002'
```

If you are happy with the default settings, clear the cache and reindex the search engine.

```bash
php bin/console cache:clear
php bin/console ibexa:reindex
```

#### Configure AI action

Once you enable the Taxonomy suggestions feature, you must [configure an AI action]([[= user_doc =]]/ai_actions/work_with_ai_actions/#create-ai-actions-that-control-taxonomy-suggestions) that handles the generation of embeddings for newly created or edited content items or products.

That's where you decide which exact fields from which content type should be used as input for embedding generation, how many suggestions are being presenter to the editor, and so on.

After you do it, your users are be able to assign tags and/or product categories by using suggestions provided by an AI engine.

### Customize Taxonomy suggestions

You can modify the default behavior of the Taxonomy suggestions model by changing various settings.

#### Change default number of suggestions

By default, the system returns three suggestions.
You can change the default number if needed by altering the following setting:

``` yaml hl_lines="4"
ibexa_taxonomy:
    text_to_taxonomy:
        default_suggested_taxonomies_limit: 5
```

You can also override this setting per AI action by editing its configuration.

#### Change default fields parsed when generating suggestions

The following setting decides which fields are used to generate suggestions by default.
You can change the default setting, if needed.

``` yaml hl_lines="6-9"
ibexa:
  system:
    default:
      content_type_field_type_groups:
        configurations:
          vectorizable_fields:
            - ibexa_string
            - ibexa_text
            - ibexa_richtext
```

This way you can limit field selection to meaningful text fields and avoid unsupported field types.
Like in the case of the number of suggestions, you can override this setting per AI action by editing its configuration.

!!! tip

    When selecting the input data for embedding creation, it's recommended to include only the essential information and limit the number of tokens sent.
    Otherwise, the embedding models can generate values that don't correspond closely to the actual meaning of the input.

### Change embedding generation models or embedding provider

By default, the system comes with a set of OpenAI models that can be used for embedding generation.
The following example shows these models listed in system configuration, together with a setting that controls what model is used when the editor requests taxonomy suggestions for an item.

Also, here is where you can change the name of the model used by the provider, the embedding's dimensions, and other settings.

```yaml hl_lines="20"
ibexa:
    system:
        default:
            embedding_models:
                text-embedding-3-small:
                    name: 'text-embedding-3-small'
                    dimensions: 1536
                    field_suffix: '3small'
                    embedding_provider: 'ibexa_openai'
                text-embedding-3-large:
                    name: 'text-embedding-3-large'
                    dimensions: 3072
                    field_suffix: '3large'
                    embedding_provider: 'ibexa_openai'
                text-embedding-ada-002:
                    name: 'text-embedding-ada-002'
                    dimensions: 1536
                    field_suffix: 'ada002'
                    embedding_provider: 'ibexa_openai'
            default_embedding_model: 'text-embedding-ada-002'
```

!!! caution "Change both embedding generation models"

    When you change the default suggestions generation model, ensure that you update the `ibexa.system.default.taxonomy.search.default_embedding_model` setting that is used for taxonomy indexing purposes.
    Otherwise the taxonomy suggestions feature fails to find matching entries.

#### Change embeddings provider to Google Gemini [[% include 'snippets/lts-update_badge.md' %]]

Once you have installed and configured the [Google Gemini connector](configure_ai_actions.md#install-google-gemini-connector), you can modify the default configuration to use the `ibexa_gemini` embedding provider and one of the [supported models](https://ai.google.dev/gemini-api/docs/embeddings):

```yaml hl_lines="15 22"
ibexa:
    system:
        default:
            embedding_models:
                gemini_embedding_001_1536:
                    name: 'gemini-embedding-001'
                    dimensions: 1536
                    field_suffix: 'gemini_embedding_001_1536_dv'
                    embedding_provider: 'ibexa_gemini'
                gemini_embedding_001_3072:
                    name: 'gemini-embedding-001'
                    dimensions: 3072
                    field_suffix: 'gemini_embedding_001_3072_dv'
                    embedding_provider: 'ibexa_gemini'
            default_embedding_model: 'gemini_embedding_001_1536'

# ...

            taxonomy:
                search:
                    index_embeddings: true
                    default_embedding_model: 'gemini_embedding_001_1536'
```

After you make the change:

- Update the [Solr schema](field_type_search.md#configuring-solr) or [Elasticsearch mappings](configure_elasticsearch.md#fine-tune-the-search-results) by adding dynamic field definitions. Ensure that they match the dimensions (for example, 1536 or 3072) and suffixes that you defined above
- Clear the cache and reindex the search engine

### Extending Taxonomy suggestions

You can extend the feature by replacing the default code by exploring one of the following ideas.

#### Replace the embedding provider

By default, the system uses the `ibexa_openai` connector.
You can add your own embedding provider if needed. To do it:

- Implement the [`EmbeddingProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-Embedding-EmbeddingProviderInterface.html)
- Register the service with the `ibexa.embedding_provider` tag

#### Extend the AI action form

You can extend the `TextToTaxonomyOptionsType` AI action form by inheriting from `Ibexa\Bundle\Taxonomy\Form\Type\AbstractActionConfigurationOptions`.
