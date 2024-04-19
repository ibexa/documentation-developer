<?php declare(strict_types=1);

namespace App\MyFeature;

class MyFeature extends \stdClass
{
    public function __construct(array $properties)
    {
        foreach ($properties as $propertyName => $propertyValue) {
            $this->$propertyName = $propertyValue;
        }
    }
}
