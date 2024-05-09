<?php declare(strict_types=1);

/**
 * @copyright Copyright (C) Ibexa. All rights reserved.
 *
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\DeveloperDocumentation\Test\Context;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use EzSystems\DeveloperDocumentation\Test\ContentDataCreator;

class ContentContext implements Context
{
    /** @var \eZ\Publish\API\Repository\Repository */
    private $repository;

    /** @var \eZ\Publish\API\Repository\ContentService */
    private $contentService;

    /** @var \eZ\Publish\API\Repository\LocationService */
    private $locationService;

    private const ADMIN_USER_ID = 14;

    private const EZ_PLATFORM_FOLDER_CONTENT_ID = 1;

    private $pathStringLocationMap;

    private $basePath;

    public function __construct($repository, $basePath)
    {
        $this->basePath = $basePath;
        $this->repository = $repository;
        $this->contentService = $this->repository->getContentService();
        $this->locationService = $this->repository->getLocationService();
        $this->pathStringLocationMap = ['Home' => 2];
    }

    public function createContent($contentTypeIdentifier, $parentPathString, $contentItemData): void
    {
        $permissionResolver = $this->repository->getPermissionResolver();
        $user = $this->repository->getUserService()->loadUser(self::ADMIN_USER_ID);
        $permissionResolver->setCurrentUserReference($user);

        $locationCreateStruct = $this->locationService->newLocationCreateStruct($this->pathStringLocationMap[$parentPathString]);
        $contentType = $this->repository->getContentTypeService()->loadContentTypeByIdentifier($contentTypeIdentifier);
        $contentCreateStruct = $this->contentService->newContentCreateStruct($contentType, 'eng-GB');

        $contentDataCreator = new ContentDataCreator($this->basePath);
        $contentDataCreator->fillWithData($contentCreateStruct, $contentTypeIdentifier, $contentItemData);

        $draft = $this->contentService->createContent($contentCreateStruct, [$locationCreateStruct]);
        $content = $this->contentService->publishVersion($draft->versionInfo);

        $newItemPathString = sprintf('%s/%s', $parentPathString, $contentItemData['contentName']);
        $this->pathStringLocationMap[$newItemPathString] = $content->contentInfo->mainLocationId;
    }

    /**
     * @Given I delete eZ Platform Folder under Home
     */
    public function deleteContentItem(): void
    {
        $permissionResolver = $this->repository->getPermissionResolver();
        $user = $this->repository->getUserService()->loadUser(self::ADMIN_USER_ID);
        $permissionResolver->setCurrentUserReference($user);

        $contentInfo = $this->contentService->loadContentInfo(self::EZ_PLATFORM_FOLDER_CONTENT_ID);
        $this->contentService->deleteContent($contentInfo);
    }

    /**
     * @Given I create :contentTypeIdentifier content items in :parentPathString
     */
    public function createContentItems($contentTypeIdentifier, $parentPathString, TableNode $contentItemsData): void
    {
        foreach ($contentItemsData as $contentItemData) {
            $this->createContent($contentTypeIdentifier, $parentPathString, $contentItemData);
        }
    }
}
