---
month_change: true
description: Embedding queries, embedding configuration, providers, and embedding search fields
---

# Embeddings search reference

Embeddings provide vector representations of content or text, enabling semantic similarity search.
Foundational abstractions are provided for embedding-based search, while embedding providers generate vector representations.

## EmbeddingQuery

- [`Ibexa\Contracts\Core\Repository\Values\Content\EmbeddingQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-EmbeddingQuery.html): Represents a semantic similarity search request.
It encapsulates an [Embedding](#embedding) instance and supports filtering, pagination, aggregations, and result counting through the same API as standard content queries.
Embedding queries do not support criteria, Sort Clauses, facet builders, or spellcheck

## Embedding

- [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Embedding`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Embedding.html): Represents the vector input used
for similarity search.
It stores embedding values as float arrays, while providers generate those vectors from text input

## Embedding providers

Embedding providers generate vector representations for inputs.
Out of the box, embedding search integration is provided for TaxonomyEmbedding.
If you use a custom embedding value type, implement matching embedding
visitors for your search engine (Solr/Elasticsearch).
Otherwise, query execution may fail with "No visitor available".

### Provider contracts

- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-Embedding-EmbeddingProviderInterface.html): Generates embeddings

- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderRegistryInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-Embedding-EmbeddingProviderRegistryInterface.html): Lists available embedding providers

- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderResolverInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-Embedding-EmbeddingProviderResolverInterface.html): Resolves the provider for a given embedding configuration

## Embedding fields

- [`Ibexa\Contracts\Core\Search\FieldType\EmbeddingFieldFactory`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-FieldType-EmbeddingFieldFactory.html): Creates dedicated search fields that store embedding vectors

## Validation

- [`Ibexa\Contracts\Core\Repository\Values\Content\QueryValidatorInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-QueryValidatorInterface.html): Validates embedding queries before they reach the search engine

!!! note "Taxonomy embeddings"

    Searching for embeddings can be used to support the [Taxonomy suggestions](taxonomy.md#taxonomy-suggestions) feature.
    The [`Ibexa\Contracts\Taxonomy\Search\Query\Value\TaxonomyEmbedding`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Taxonomy-Search-Query-Value-TaxonomyEmbedding.html) allows embedding queries to target taxonomy data.
