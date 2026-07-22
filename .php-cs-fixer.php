<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

[$configFactory, $commonRules] = require __DIR__ . '/.php-cs-fixer-factory.php';

$configFactory->withRules($commonRules);

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
            ->exclude('_inline_php') // handled separately by .php-cs-fixer-inline.php
            ->files()->name('*.php')
    );
