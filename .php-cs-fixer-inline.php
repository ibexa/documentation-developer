<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

/**
 * PHP-CS-Fixer configuration for auto-generated inline snippets in code_samples/_inline_php/.
 *
 * Builds on top of the shared factory with additional rule overrides:
 * - psr_autoloading is disabled: snippet files are named line_N.php and do not
 *   correspond to any class, so the filename≠class-name rule does not apply.
 */
[$configFactory, $commonRules] = require __DIR__ . '/.php-cs-fixer-factory.php';

$configFactory->withRules(array_merge($commonRules, [
    'psr_autoloading' => false,
    'AdamWojs/phpdoc_force_fqcn_fixer' => false,
]));

return $configFactory
    ->buildConfig()
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__ . '/code_samples/_inline_php')
            ->files()->name('*.php')
    );
