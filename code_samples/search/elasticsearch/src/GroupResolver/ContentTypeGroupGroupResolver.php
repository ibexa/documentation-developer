<?php

declare(strict_types=1);

namespace App\GroupResolver;

use eZ\Publish\SPI\Persistence\Content\Type\Handler;
use Ibexa\Contracts\Elasticsearch\ElasticSearch\Index\Group\GroupResolverInterface;
use Ibexa\Platform\Contracts\ElasticSearchEngine\Mapping\BaseDocument;

final class ContentTypeGroupGroupResolver implements GroupResolverInterface
{
    private $contentTypeHandler;

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
