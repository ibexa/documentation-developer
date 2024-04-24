<?php declare(strict_types=1);

namespace App\MyFeature;

class MyFeature extends \stdClass
{
    /** 
     * @param array<string, mixed> $properties
     */
    public function __construct(array $properties)
    {
        foreach ($properties as $propertyName => $propertyValue) {
            $this->$propertyName = $propertyValue;
        }
    }
}
