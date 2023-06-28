<?php declare(strict_types=1);

namespace App\Search\FieldMapper;

use Ibexa\Contracts\Core\Persistence\Content;
use Ibexa\Contracts\Core\Persistence\Content\Handler as ContentHandler;
use Ibexa\Contracts\Core\Persistence\Content\Location\Handler as LocationHandler;
use Ibexa\Contracts\Core\Search;
use Ibexa\Contracts\Solr\FieldMapper\ContentFieldMapper;

class WebinarEventTitleFulltextFieldMapper extends ContentFieldMapper
{
    /**
     * @var \Ibexa\Contracts\Core\Persistence\Content\Type\Handler
     */
    protected \Ibexa\Contracts\Core\Persistence\Content\Type\Handler $contentHandler;

    /**
     * @var \Ibexa\Contracts\Core\Persistence\Content\Location\Handler
     */
    protected \Ibexa\Contracts\Core\Persistence\Content\Location\Handler $locationHandler;

    /**
     * @param \Ibexa\Contracts\Core\Persistence\Content\Handler $contentHandler
     * @param \Ibexa\Contracts\Core\Persistence\Content\Location\Handler $locationHandler
     */
    public function __construct(
        ContentHandler $contentHandler,
        LocationHandler $locationHandler
    ) {
        $this->contentHandler = $contentHandler;
        $this->locationHandler = $locationHandler;
    }

    public function accept(Content $content)
    {
        // ContentType with ID 42 is webinar event
        return $content->versionInfo->contentInfo->contentTypeId == 42;
    }

    public function mapFields(Content $content)
    {
        $mainLocationId = $content->versionInfo->contentInfo->mainLocationId;
        $location = $this->locationHandler->load($mainLocationId);
        $parentLocation = $this->locationHandler->load($location->parentId);
        $parentContentInfo = $this->contentHandler->loadContentInfo($parentLocation->contentId);

        return [
            new Search\Field(
                'fulltext',
                $parentContentInfo->name,
                new Search\FieldType\FullTextField()
            ),
        ];
    }
}
