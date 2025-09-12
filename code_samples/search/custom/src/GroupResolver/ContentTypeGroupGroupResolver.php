<?php

declare(strict_types=1);

namespace App\GroupResolver;

use Ibexa\Contracts\Core\Persistence\Content\Type\Handler;
use Ibexa\Contracts\Elasticsearch\ElasticSearch\Index\Group\GroupResolverInterface;
use Ibexa\Contracts\Elasticsearch\Mapping\BaseDocument;

final readonly class ContentTypeGroupGroupResolver implements GroupResolverInterface
{
    public function __construct(private Handler $contentTypeHandler)
    {
    }

    public function resolveDocumentGroup(BaseDocument $document): string
    {
        $index = $this->contentTypeHandler->load($document->contentTypeId)->groupIds[0];

        return (string)$index;
    }
}
