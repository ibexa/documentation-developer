<?php

declare(strict_types=1);

namespace App\Migrations\Action;

use Ibexa\Platform\Contracts\Migration\Serializer\Denormalizer\AbstractActionDenormalizer;
use Webmozart\Assert\Assert;

final class AssignSectionDenormalizer extends AbstractActionDenormalizer
{
    protected function supportsActionName(string $actionName, string $format = null): bool
    {
        return $actionName === AssignSection::TYPE;
    }

    /**
     * @param array<mixed> $data
     * @param string $type
     * @param string|null $format
     * @param array<mixed> $context
     *
     * @return \App\Migrations\Action\AssignSection
     */
    public function denormalize($data, string $type, string $format = null, array $context = []): AssignSection
    {
        Assert::keyExists($data, 'value');

        return new AssignSection($data['value']);
    }
}
