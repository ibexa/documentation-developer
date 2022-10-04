<?php

declare(strict_types=1);

namespace App\GroupResolver;

use eZ\Publish\API\Repository\ContentTypeService;
use Ibexa\Contracts\Elasticsearch\ElasticSearch\Index\Group\GroupResolverInterface;
use Ibexa\Contracts\Elasticsearch\Mapping\BaseDocument;

final class ContentTypeGroupGroupResolver implements GroupResolverInterface
{
    private $contentTypeService;

    public function __construct(ContentTypeService $contentTypeService)
    {
        $this->contentTypeService = $contentTypeService;
    }

    public function resolveDocumentGroup(BaseDocument $document): string
    {
        $index = $this->contentTypeService->loadContentType($document->contentTypeId)->contentTypeGroups[0]->id;

        return (string)$index;
    }
}
