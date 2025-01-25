<?php

declare(strict_types=1);

namespace App\GroupResolver;

use Ibexa\Contracts\Core\Persistence\Content\Type\Handler;
use Ibexa\Contracts\Elasticsearch\ElasticSearch\Index\Group\GroupResolverInterface;
use Ibexa\Contracts\Elasticsearch\Mapping\BaseDocument;

final class ContentTypeGroupGroupResolver implements GroupResolverInterface
{
    private Handler $contentTypeHandler;

    public function __construct(Handler $contentTypeHandler)
    {
        $this->contentTypeHandler = $contentTypeHandler;
    }

    public function resolveDocumentGroup(BaseDocument $document): string
    {
        $index = $this->contentTypeHandler->load($document->contentTypeId)->groupIds[0];

        return (string)$index;
    }
}
