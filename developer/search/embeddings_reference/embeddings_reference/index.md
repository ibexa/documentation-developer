# Embeddings search reference

Embedding queries, embedding configuration, providers, and embedding search fields

Embeddings provide vector representations of content or text, enabling [semantic similarity search](../../search_api/index.md#search-with-embeddings). Foundational abstractions are provided for embedding-based search, while embedding providers generate vector representations.

Searching with embeddings is designed for use with the [Taxonomy suggestions](../../../content_management/taxonomy/taxonomy/index.md#taxonomy-suggestions) feature. The [`Ibexa\Contracts\Taxonomy\Search\Query\Value\TaxonomyEmbedding`](../../../../../../ibexa/taxonomy/src/contracts/Search/Query/Value/TaxonomyEmbedding.php) class allows embedding queries to target taxonomy data.

> **Note: Feature support**
>
> Searching with embeddings requires a search engine that supports it, such as Elasticsearch or Solr 9.8.1+.

## Core query objects

### EmbeddingQuery

- [`Ibexa\Contracts\Core\Repository\Values\Content\EmbeddingQuery`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/EmbeddingQuery.php) represents a semantic similarity search request. It encapsulates an [Embedding](#embedding) instance and supports pagination, aggregations, and result counting through the same API as standard content queries.

  > **Note: Embedding query properties**
  >
  > Embedding queries do not use criteria for similarity, but for additional filtering applied through the query filter. Also, embedding queries do not allow standard Query properties supported by [search engines](../../search_engines/search_engines/index.md) other than the Legacy Search, such as `query`, `sortClauses`, or `spellcheck`.

- [`Ibexa\Contracts\Core\Repository\Values\Content\EmbeddingQueryBuilder`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/EmbeddingQueryBuilder.php) is a builder for constructing `EmbeddingQuery` instances. It helps construct queries consistently and integrates embedding queries with the search query pipeline. You must provide the required embedding value by using the `withEmbedding` method

### Embedding

- [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Embedding`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/Embedding.php) represents the vector input used for similarity search. It stores embedding values as float arrays, while providers generate those vectors from text input

## Query execution

Embedding queries are executed by the search engine by using the configured embedding model and provider.

At runtime, the system resolves the appropriate embedding provider and ensures that the embedding vector is compatible with the configured model. Runtime validation includes validating vector dimensionality and selecting the correct indexed field for similarity search. Field selection is determined by the configured embedding model and backend specific query mapping, while vector dimensionality is validated when the query reaches the search engine.

## Embedding providers

Embedding providers implement the contract for generating vector representations of input data. Out of the box, embedding search integration is provided for `TaxonomyEmbedding`. If you use a custom embedding value type, implement matching embedding visitors for your [search engine](../../search_engines/search_engines/index.md). Otherwise, query execution may fail due to no visitor available.

- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderInterface`](../../../../../../ibexa/core/src/contracts/Search/Embedding/EmbeddingProviderInterface.php) generates embeddings for the provided text or other input
- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderRegistryInterface`](../../../../../../ibexa/core/src/contracts/Search/Embedding/EmbeddingProviderRegistryInterface.php) lists available embedding providers or gets one by its identifier
- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderResolverInterface`](../../../../../../ibexa/core/src/contracts/Search/Embedding/EmbeddingProviderResolverInterface.php) determines the embedding provider to be used for generating embeddings based on the system configuration, or a demand passed through the `resolveByModelIdentifier` method

## Configuration

Models used to resolve embedding queries must be configured per SiteAccess in [system configuration](../../../administration/configuration/configuration/index.md). Each entry defines the model's name, vector dimensionality, the field suffix, and the embedding provider that generates vectors. Field suffixes assigned to the models must be unique, as they become part of the indexed field name. You select the default model by setting a value in the `default_embedding_model` key.

```yaml
ibexa:
    system:
        default:
            embedding_models:
                text-embedding-3-small:
                    name: 'text-embedding-3-small'
                    dimensions: 1536
                    field_suffix: '3small'
                    embedding_provider: 'ibexa_openai'
            default_embedding_model: text-embedding-ada-002
```

For a real-life example of embedding models configuration, see [Taxonomy suggestions](../../../content_management/taxonomy/taxonomy/index.md#change-embedding-generation-models-or-embedding-provider).

- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingConfigurationInterface`](../../../../../../ibexa/core/src/contracts/Search/Embedding/EmbeddingConfigurationInterface.php) allows access to the embedding model configuration in the system (for example, list of available models, default model name, default provider, field suffix, and so on)

## Embedding fields

Embedding vectors are stored in dedicated search fields. These fields can be used by the search engine to perform vector similarity comparisons when embedding queries are executed.

```php
<?php declare(strict_types=1);

// Create an embedding field using the default embedding provider (type derived from configuration's field suffix)

/** @var Ibexa\Contracts\Core\Search\FieldType\EmbeddingFieldFactory $factory */
$embeddingField = $factory->create();
echo $embeddingField->getType(); // for example, "ibexa_dense_vector_model_123"

// Create a custom embedding field with a specific type
$customField = $factory->create('custom_embedding_type');
echo $customField->getType(); // "custom_embedding_type"
```

Once you create a field, subscribe to the `ContentIndexCreateEvent` indexing event that [adds the field to the index](../../extensibility/index_custom_elasticsearch_data/index.md).

- [`Ibexa\Contracts\Core\Search\FieldType\EmbeddingFieldFactory`](../../../../../../ibexa/core/src/contracts/Search/FieldType/EmbeddingFieldFactory.php) creates dedicated search fields that store embedding vectors

## Validation

- [`Ibexa\Contracts\Core\Repository\Values\Content\QueryValidatorInterface`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/QueryValidatorInterface.php) validates embedding query structure before execution
