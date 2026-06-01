<?php declare(strict_types=1);

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
