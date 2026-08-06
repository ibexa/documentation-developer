<?php declare(strict_types=1);

namespace App\Export\User;

use Ibexa\Contracts\Cdp\Export\User\AbstractUserItemProcessor;
use Ibexa\Contracts\Core\Repository\Values\Content\Content;
use Ibexa\Core\FieldType\Date\Value as DateValue;
use InvalidArgumentException;

final class DateOfBirthUserItemProcessor extends AbstractUserItemProcessor
{
    public function __construct(
        private readonly string $dateOfBirthFieldIdentifier,
        string $userFieldTypeIdentifier
    ) {
        parent::__construct($userFieldTypeIdentifier);
    }

    protected function doProcess(array $processedItemData, Content $userContent): array
    {
        $userField = $this->getUserField($userContent);

        if (null === $userField) {
            throw new InvalidArgumentException('Content does not contain user field');
        }

        $dateOfBirth = '';
        $dateOfBirthField = $userContent->getField($this->dateOfBirthFieldIdentifier);

        if ($dateOfBirthField !== null
            && $dateOfBirthField->value instanceof DateValue
            && $dateOfBirthField->value->date !== null
        ) {
            $dateOfBirth = $dateOfBirthField->value->date->format('Y-m-d');
        }

        return array_merge(
            $processedItemData,
            [
                'date_of_birth' => $dateOfBirth,
            ]
        );
    }
}
