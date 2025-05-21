<?php declare(strict_types=1);

/**
 * @copyright Copyright (C) Ibexa. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\DeveloperDocumentation\Test;

use eZ\Publish\API\Repository\Values\Content\ContentCreateStruct;
use eZ\Publish\Core\FieldType\Image\Value;

class ContentDataCreator
{
    private $basePath;

    public const DOG_IMAGES_PATH = 'images/Photos/Dog Breed images';

    public const ARTICLE_IMAGES_PATH = 'images/Photos/Article images';

    public const RICHTEXT_XML = '<?xml version="1.0" encoding="UTF-8"?>
<section xmlns="http://docbook.org/ns/docbook" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:ezxhtml="http://ez.no/xmlns/ezpublish/docbook/xhtml" xmlns:ezcustom="http://ez.no/xmlns/ezpublish/docbook/custom" version="5.0-variant ezpublish-1.0">
<title ezxhtml:level="2">%s</title>
</section>';

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    public function fillWithData(ContentCreateStruct $contentCreateStruct, string $contentTypeIdentifier, $contentItemData): void
    {
        switch ($contentTypeIdentifier) {
            case 'folder':
                $this->createFolder($contentCreateStruct, $contentItemData);

                return;
            case 'article':
                $this->createArticle($contentCreateStruct, $contentItemData);

                return;
            case 'tip':
                $this->createTip($contentCreateStruct, $contentItemData);

                return;
            case 'dog_breed':
                $this->createDogBreed($contentCreateStruct, $contentItemData);

                return;
            default:
                throw new \InvalidArgumentException(sprintf('Unrecognised content type: %s', $contentTypeIdentifier));
        }
    }

    private function createDogBreed(ContentCreateStruct $contentCreateStruct, $data): void
    {
        $contentCreateStruct->setField('name', $data['contentName']);
        $contentCreateStruct->setField('short_description', $data['contentName']);

        $filePath = sprintf('%s/%s/%s', $this->basePath, self::DOG_IMAGES_PATH, $data['imageName']);
        $value = new Value(
            [
                'path' => $filePath,
                'fileSize' => filesize($filePath),
                'fileName' => basename($filePath),
                'alternativeText' => 'test',
            ]
        );
        $contentCreateStruct->setField('photo', $value);
        $contentCreateStruct->setField('description', sprintf(self::RICHTEXT_XML, 'I am a dog. Woof woof.'));
    }

    private function createTip(ContentCreateStruct $contentCreateStruct, $data): void
    {
        $contentCreateStruct->setField('title', $data['contentName']);
        $contentCreateStruct->setField('body', $data['contentName']);
    }

    private function createArticle(ContentCreateStruct $contentCreateStruct, $data): void
    {
        $contentCreateStruct->setField('title', $data['contentName']);
        $contentCreateStruct->setField('short_title', $data['contentName']);

        $filePath = sprintf('%s/%s/%s', $this->basePath, self::ARTICLE_IMAGES_PATH, $data['imageName']);
        $value = new Value(
            [
                'path' => $filePath,
                'fileSize' => filesize($filePath),
                'fileName' => basename($filePath),
                'alternativeText' => 'test',
            ]
        );
        $contentCreateStruct->setField('image', $value);

        $inputString = sprintf(self::RICHTEXT_XML, 'This is an article about a dog.');
        $contentCreateStruct->setField('body', $inputString);
        $contentCreateStruct->setField('intro', $inputString);
    }

    private function createFolder(ContentCreateStruct $contentCreateStruct, $data): void
    {
        $contentCreateStruct->setField('name', $data['contentName']);
        $contentCreateStruct->setField('short_name', $data['contentName']);
    }
}
