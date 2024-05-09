<?php declare(strict_types=1);

/**
 * @copyright Copyright (C) Ibexa. All rights reserved.
 *
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */

namespace EzSystems\DeveloperDocumentation\Test;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Yaml\Yaml;

class ConfigurationEditor
{
    /** @var string */
    private $configFilePath;

    public function __construct(string $configFilePath)
    {
        $this->configFilePath = $configFilePath;
    }

    public function add($configEntries): void
    {
        $parsedConfig = Yaml::parse(file_get_contents($this->configFilePath));

        foreach ($configEntries as $key => $value) {
            $this->addSingle($parsedConfig, $key, $value);
        }

        file_put_contents($this->configFilePath, Yaml::dump($parsedConfig, 5, 4));
    }

    private function addSingle(&$parsedConfig, $key, $value): void
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $parsedKey = $this->parseKey($key);
        $currentValue = $propertyAccessor->getValue($parsedConfig, $parsedKey);

        if (is_array($currentValue)) {
            if (is_array($value)) {
                $value = array_merge($currentValue, $value);
            } else {
                $currentValue[] = $value;
                $value = $currentValue;
            }
        }

        $propertyAccessor->setValue($parsedConfig, $parsedKey, $value);
    }

    private function parseKey(string $key): string
    {
        $keys = explode('.', $key);
        $parsed = '';
        foreach ($keys as $keyPart) {
            $parsed .= sprintf('[%s]', $keyPart);
        }

        return $parsed;
    }
}
