<?php declare(strict_types=1);

namespace App\Setting\Group;

use Ibexa\User\UserSetting\Group\AbstractGroup;

final class MyGroup extends AbstractGroup
{
    public function __construct(
        array $values = []
    ) {
        parent::__construct($values);
    }

    public function getName(): string
    {
        return 'My Group';
    }

    public function getDescription(): string
    {
        return 'My custom setting group';
    }
}
