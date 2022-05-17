<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\CodeStyle\PhpCsFixer\InternalConfigFactory;

$configFactory = new InternalConfigFactory();
$configFactory->withRules([
    'header_comment' => false,
]);

return $configFactory
    ->buildConfig()
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(
                array_filter([
                    __DIR__ . '/code_samples',
                    __DIR__ . '/tests',
                ], 'is_dir')
            )
            ->files()->name('*.php')
    );
