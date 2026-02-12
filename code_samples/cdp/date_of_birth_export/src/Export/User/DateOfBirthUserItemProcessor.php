<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Export\User;

use Ibexa\Contracts\Cdp\Export\User\AbstractUserItemProcessor;
use Ibexa\Contracts\Core\Repository\Values\Content\Content;
use Ibexa\Core\Base\Exceptions\InvalidArgumentException;
use Ibexa\Core\FieldType\Date\Value as DateValue;

final class DateOfBirthUserItemProcessor extends AbstractUserItemProcessor
{
    private string $dateOfBirthFieldIdentifier;

    public function __construct(
        string $dateOfBirthFieldIdentifier,
        string $userFieldTypeIdentifier
    ) {
        $this->dateOfBirthFieldIdentifier = $dateOfBirthFieldIdentifier;

        parent::__construct($userFieldTypeIdentifier);
    }

    protected function doProcess(array $processedItemData, Content $userContent): array
    {
        $userField = $this->getUserField($userContent);

        if (null === $userField) {
            throw new InvalidArgumentException('$userContent', 'User content does not contain user field');
        }

        $dateOfBirthField = $userContent->getField($this->dateOfBirthFieldIdentifier);

        if (null === $dateOfBirthField || !$dateOfBirthField->value instanceof DateValue) {
            return $processedItemData;
        }

        /** @var \Ibexa\Core\FieldType\Date\Value $dateValue */
        $dateValue = $dateOfBirthField->value;

        if (null === $dateValue->date) {
            return $processedItemData;
        }

        return array_merge(
            $processedItemData,
            [
                'date_of_birth' => $dateValue->date->format('Y-m-d'),
            ]
        );
    }
}
