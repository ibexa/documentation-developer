<?php declare(strict_types=1);

// Create an embedding field using the default embedding provider (type derived from configuration's field suffix)

/** @var Ibexa\Contracts\Core\Search\FieldType\EmbeddingFieldFactory $factory */
$embeddingField = $factory->create();
echo $embeddingField->getType(); // for example, "ibexa_dense_vector_model_123"

// Create a custom embedding field with a specific type
$customField = $factory->create('custom_embedding_type');
echo $customField->getType(); // "custom_embedding_type"
