<?php declare(strict_types=1);

namespace App\Search\FieldMapper;

use Ibexa\Contracts\Core\Persistence\Content;
use Ibexa\Contracts\Core\Persistence\Content\Handler as ContentHandler;
use Ibexa\Contracts\Core\Persistence\Content\Location\Handler as LocationHandler;
use Ibexa\Contracts\Core\Search;
use Ibexa\Contracts\Solr\FieldMapper\ContentFieldMapper;

class WebinarEventParentNameFieldMapper extends ContentFieldMapper
{
    public function __construct(
        protected ContentHandler $contentHandler,
        protected LocationHandler $locationHandler
    ) {
    }

    public function accept(Content $content): bool
    {
        // ContentType with ID 42 is webinar event
        return $content->versionInfo->contentInfo->contentTypeId === 42;
    }

    /**
     * @return \Ibexa\Contracts\Core\Search\Field[]
     */
    public function mapFields(Content $content): array
    {
        $mainLocationId = $content->versionInfo->contentInfo->mainLocationId;
        $location = $this->locationHandler->load($mainLocationId);
        $parentLocation = $this->locationHandler->load($location->parentId);
        $parentContentInfo = $this->contentHandler->loadContentInfo($parentLocation->contentId);

        return [
            new Search\Field(
                'parent_name',
                $parentContentInfo->name,
                new Search\FieldType\StringField()
            ),
        ];
    }
}
