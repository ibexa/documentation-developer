<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

use Ibexa\Contracts\Rector\Sets\IbexaSetList;
use Rector\Config\RectorConfig;
use Rector\DowngradePhp81\Rector\ClassMethod\AddReturnTypeWillChangeAttributeRector;
use Rector\DowngradePhp82\Rector\FuncCall\DowngradeIteratorCountToArrayRector;
use Rector\Symfony\DowngradeSymfony70\Rector\Class_\DowngradeSymfonyCommandAttributeRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/code_samples',
    ])
    ->withSkip([
        DowngradeIteratorCountToArrayRector::class,
        AddReturnTypeWillChangeAttributeRector::class => [
            __DIR__ . '/code_samples/field_types/2dpoint_ft/src/FieldType/Point2D/Value.php',
            __DIR__ . '/code_samples/field_types/2dpoint_ft/steps/step_1/Value.php',
            __DIR__ . '/code_samples/field_types/generic_ft/src/FieldType/HelloWorld/Value.php',
        ],
    ])
    ->withSets([
        IbexaSetList::IBEXA_46->value,
    ])
    ->withDowngradeSets(php74: true)
    ->withRules([
        DowngradeSymfonyCommandAttributeRector::class,
    ]);
