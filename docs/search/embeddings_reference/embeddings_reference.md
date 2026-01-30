---
month_change: true
description: Embedding queries, embedding configuration, providers, and embedding search fields
---

# Embeddings search reference

Embeddings provide vector representations of content or text, enabling semantic similarity search.
Foundational abstractions are provided for embedding-based search, while embedding providers generate vector representations.

## EmbeddingQuery

- [`Ibexa\Contracts\Core\Repository\Values\Content\EmbeddingQuery`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-EmbeddingQuery.html): Represents a semantic similarity search request.
It encapsulates an [Embedding](#embedding) instance and supports pagination and aggregations through the same API as standard content queries.
Embedding queries do not support criteria, sort clauses, facet builders, or spellcheck

## Embedding

- [`Ibexa\Contracts\Core\Repository\Values\Content\Query\Embedding`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Embedding.html): Represents the semantic input used for similarity search.
Depending on the embedding provider, it can encapsulate text or vector data

## Embedding providers

Embedding providers generate vector representations for inputs.

### Provider contracts

- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-Embedding-EmbeddingProviderInterface.html): Generates embeddings

- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderRegistryInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-Embedding-EmbeddingProviderRegistryInterface.html): Lists available embedding providers

- [`Ibexa\Contracts\Core\Search\Embedding\EmbeddingProviderResolverInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-Embedding-EmbeddingProviderResolverInterface.html): Resolves the provider for a given embedding configuration

## Embedding fields

- [`Ibexa\Contracts\Core\Search\FieldType\EmbeddingFieldFactory`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Search-FieldType-EmbeddingFieldFactory.html): Creates dedicated search fields that store embedding vectors

## Validation

- [`Ibexa\Contracts\Core\Repository\Values\Content\QueryValidatorInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-QueryValidatorInterface.html): Validates embedding queries and configurations are validated before reaching the search engine

!!! note "Taxonomy embeddings"

    Searching for embeddings can be used to support the [Taxonomy suggestions](taxonomy.md#taxonomy-suggestions) feature.
    The [`Ibexa\Contracts\Taxonomy\Search\Query\Value\TaxonomyEmbedding`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Taxonomy-Search-Query-Value-TaxonomyEmbedding.html) allows embedding queries to target taxonomy data.
