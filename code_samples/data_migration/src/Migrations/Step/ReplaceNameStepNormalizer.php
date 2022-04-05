<?php

declare(strict_types=1);

namespace App\Migrations\Step;

use Ibexa\Platform\Contracts\Migration\Serializer\AbstractStepNormalizer;
use Ibexa\Platform\Migration\ValueObject\Step\StepInterface;

/**
 * @extends \Ibexa\Platform\Contracts\Migration\Serializer\AbstractStepNormalizer<\App\Migrations\Step\ReplaceNameStep>
 */
final class ReplaceNameStepNormalizer extends AbstractStepNormalizer
{
    protected function normalizeStep(
        StepInterface $object,
        string $format = null,
        array $context = []
    ): array {
        assert($object instanceof ReplaceNameStep);

        return [
            'replacement' => $object->getReplacement(),
        ];
    }

    protected function denormalizeStep(
        $data,
        string $type,
        string $format,
        array $context = []
    ): ReplaceNameStep {
        return new ReplaceNameStep($data['replacement'] ?? null);
    }

    public function getHandledClassType(): string
    {
        return ReplaceNameStep::class;
    }

    public function getType(): string
    {
        return 'company_name';
    }

    public function getMode(): string
    {
        return 'replace';
    }
}
