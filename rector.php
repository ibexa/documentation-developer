<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Rector\Config\RectorConfig;
use Ibexa\Contracts\Rector\Sets\IbexaSetList;
use Rector\Symfony\DowngradeSymfony70\Rector\Class_\DowngradeSymfonyCommandAttributeRector;
use Rector\DowngradePhp82\Rector\FuncCall\DowngradeIteratorCountToArrayRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/code_samples',
    ])
    ->withSkip([
        DowngradeIteratorCountToArrayRector::class,
    ])
    ->withSets([
        IbexaSetList::IBEXA_46->value,
    ])
    ->withDowngradeSets(php74: true)
    ->withRules([
        DowngradeSymfonyCommandAttributeRector::class,
    ]);
