<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Composer\Autoload\ClassLoader;

/** @var \Composer\Autoload\ClassLoader $loader */
$loader = require __DIR__ . '/../vendor/autoload.php';

/**
 * Register every code_samples src/ directory (at any depth) under the App\ PSR-4 prefix.
 *
 * Each code sample is a standalone mini-application that uses the App\ namespace.
 * Registering all their src/ directories allows PHP to resolve !php/const tags
 * (e.g. !php/const App\Discounts\Condition\IsAccountAnniversary::IDENTIFIER)
 * that reference example classes documented alongside the YAML snippets.
 *
 * Composer's ClassLoader searches registered paths in order and uses the first
 * match, so the three FQCNs that happen to exist in multiple samples
 * (App\Kernel, App\Controller\CustomController, App\QueryType\MenuQueryType)
 * will silently resolve to whichever sample's definition is found first.
 * This is acceptable because none of those classes are referenced by
 * !php/const tags anywhere in the YAML files or documentation.
 */
$codeSamplesDir = realpath(__DIR__ . '/../code_samples');

$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($codeSamplesDir, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $item) {
    if ($item->isDir() && $item->getFilename() === 'src') {
        $loader->addPsr4('App\\', $item->getRealPath());
    }
}
