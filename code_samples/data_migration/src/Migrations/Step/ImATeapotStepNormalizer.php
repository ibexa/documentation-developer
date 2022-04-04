<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Migrations\ImATeapot;

use Ibexa\Contracts\Migration\Serializer\AbstractStepNormalizer;
use Ibexa\Migration\ValueObject\Step\StepInterface;

/**
 * @extends \Ibexa\Contracts\Migration\Serializer\AbstractStepNormalizer<\App\Migrations\ImATeapot\ImATeapotStep>
 */
final class ImATeapotStepNormalizer extends AbstractStepNormalizer
{
    protected function normalizeStep(
        StepInterface $object,
        string $format = null,
        array $context = []
    ): array {
        assert($object instanceof ImATeapotStep);

        return [
            'replacement' => $object->getReplacement(),
        ];
    }

    protected function denormalizeStep(
        $data,
        string $type,
        string $format,
        array $context = []
    ): ImATeapotStep {
        return new ImATeapotStep($data['replacement'] ?? null);
    }

    public function getHandledClassType(): string
    {
        return ImATeapotStep::class;
    }

    public function getType(): string
    {
        return 'im_a';
    }

    public function getMode(): string
    {
        return 'teapot';
    }
}
