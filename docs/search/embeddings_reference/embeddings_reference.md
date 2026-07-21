---
month_change: false
description: Embedding queries, embedding configuration, providers, and embedding search fields
---

# Embeddings search reference

Embeddings provide vector representations of content or text, enabling [semantic similarity search](search_api.md#search-with-embeddings).
Foundational abstractions are provided for embedding-based search, while embedding providers generate vector representations.

Searching with embeddings is designed for use with the [Taxonomy suggestions](taxonomy.md#taxonomy-suggestions) feature.
The [`Ibexa\Contracts\Taxonomy\Search\Query\Value\TaxonomyEmbedding`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Taxonomy-Search-Query-Value-TaxonomyEmbedding.html) class allows embedding queries to target taxonomy data.

!!! note "Feature support"

    Searching with embeddings requires a search engine that supports it, such as Elasticsearch or Solr 9.8.1+.

## Core query objects

### EmbeddingQuery

- [`Ibexa\Contracts\Core\Repository\Values\Content\EmbeddingQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-EmbeddingQuery.html) represents a semantic similarity search request.
    It encapsulates an [Embedding](#embedding) instance and supports pagination, aggregations, and result counting through the same API as standard content queries.

    !!! note "Embedding query properties"

        Embedding queries do not use criteria for similarity, but for additional filtering applied through the query filter. 
        Also, embedding queries do not allow standard Query properties supported by [search engines](search_engines.md) other than the Legacy Search, such as `query`, `sortClauses`, or `spellcheck`.

- [EmbeddingQueryBuilder](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-EmbeddingQueryBuilder.html) is a builder for constructing `EmbeddingQuery` instances.
    It helps construct queries consistently and integrates embedding queries with the search query pipeline.
    You must provide the required embedding value by using the `withEmbedding` method

### Embedding

- [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Embedding`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Embedding.html) represents the vector input used
for similarity search.
    It stores embedding values as float arrays, while providers generate those vectors from text input

## Query execution

Embedding queries are executed by the search engine by using the configured embedding model and provider.

At runtime, the system resolves the appropriate embedding provider and ensures that the embedding vector is compatible with the configured model.
Runtime validation includes validating vector dimensionality and selecting the correct indexed field for similarity search.
Field selection is determined by the configured embedding model and backend specific query mapping, while vector dimensionality is validated when the query reaches the search engine.

## Embedding providers

Embedding providers implement the contract for generating vector representations of input data.
Out of the box, embedding search integration is provided for `TaxonomyEmbedding`.
If you use a custom embedding value type, implement matching embedding visitors for your [search engine](search_engines.md).
Otherwise, query execution may fail due to no visitor available.

- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-Embedding-EmbeddingProviderInterface.html) generates embeddings for the provided text or other input

- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderRegistryInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-Embedding-EmbeddingProviderRegistryInterface.html) lists available embedding providers or gets one by its identifier

- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderResolverInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-Embedding-EmbeddingProviderResolverInterface.html) determines the embedding provider to be used for generating embeddings based on the system configuration, or a demand passed through the `resolveByModelIdentifier` method

## Configuration

Models used to resolve embedding queries must be configured per SiteAccess in [system configuration](configuration.md).
Each entry defines the model's name, vector dimensionality, the field suffix, and the embedding provider that generates vectors.
Field suffixes assigned to the models must be unique, as they become part of the indexed field name.
You select the default model by setting a value in the `default_embedding_model` key.

``` yaml
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

For a real-life example of embedding models configuration, see [Taxonomy suggestions](taxonomy.md#change-embedding-generation-models-or-embedding-provider).

- [EmbeddingConfigurationInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-Embedding-EmbeddingConfigurationInterface.html) allows access to the embedding model configuration in the system (for example, list of available models, default model name, default provider, field suffix, and so on)

## Embedding fields

Embedding vectors are stored in dedicated search fields.
These fields can be used by the search engine to perform vector similarity comparisons when embedding queries are executed.

``` php
[[= include_code('code_samples/api/public_php_api/src/embedding_fields.php') =]]
```

Once you create a field, subscribe to the `ContentIndexCreateEvent` indexing event that [adds the field to the index](index_custom_elasticsearch_data.md).

- [`Ibexa\Contracts\Core\Search\FieldType\EmbeddingFieldFactory`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-FieldType-EmbeddingFieldFactory.html) creates dedicated search fields that store embedding vectors

## Validation

- [`Ibexa\Contracts\Core\Repository\Values\Content\QueryValidatorInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-QueryValidatorInterface.html) validates embedding query structure before execution
