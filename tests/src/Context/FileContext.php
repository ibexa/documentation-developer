<?php declare(strict_types=1);

/**
 * @copyright Copyright (C) Ibexa. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\DeveloperDocumentation\Test\Context;

use Behat\Behat\Context\Context;
use function dirname;

class FileContext implements Context
{
    private $basePath;

    private const SOURCE_FILE_DIRECTORY = 'vendor/ezsystems/developer-documentation/tests/source_files';

    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @Given I create a file :path containing :sourceFile
     */
    public function createFile($path, $sourceFile): void
    {
        $content = file_get_contents(sprintf('%s/%s/%s', $this->basePath, self::SOURCE_FILE_DIRECTORY, $sourceFile));
        $destinationPath = sprintf('%s/%s', $this->basePath, $path);
        $this->createDirectoryStructure($destinationPath);

        file_put_contents($destinationPath, $content);
    }

    /**
     * @Given I add thumbnail image to :path
     */
    public function addThumbnail($path): void
    {
        $sourcePath = sprintf('%s/%s', $this->basePath, 'tutorial_data_2/public/assets/images/layouts/sidebar.png');
        $destinationPath = sprintf('%s/%s/%s', $this->basePath, $path, 'sidebar.png');
        $this->createDirectoryStructure($destinationPath);

        copy($sourcePath, $destinationPath);
    }

    /**
     * @Given I copy the block icon to :path
     */
    public function copyIcon($path): void
    {
        $sourcePath = sprintf('%s/%s', $this->basePath, 'tutorial_data_2/public/assets/images/blocks/random_block.svg');
        $destinationPath = sprintf('%s/%s/%s', $this->basePath, $path, 'random_block.svg');
        $this->createDirectoryStructure($destinationPath);

        copy($sourcePath, $destinationPath);
    }

    /**
     * @Given I append to :file file :sourcePath
     */
    public function appendToFile($file, $sourceFile): void
    {
        $content = file_get_contents(sprintf('%s/%s/%s', $this->basePath, self::SOURCE_FILE_DIRECTORY, $sourceFile));
        file_put_contents($file, $content, FILE_APPEND | LOCK_EX);
    }

    private function createDirectoryStructure($destinationPath): void
    {
        $directoryStructure = dirname($destinationPath);
        if (!file_exists($directoryStructure)) {
            mkdir($directoryStructure, 0777, true);
        }
    }
}
