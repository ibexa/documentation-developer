<?php

declare(strict_types=1);

namespace EzSystems\Raml2Html\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class TestTypeUsageCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setName('test:type:usage')
            ->setDescription('Check that types are used')
            ->setHelp('Parse ibexa-types.raml and check if each type is used.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $definedTypes = yaml_parse_file('docs/api//rest_api/rest_api_reference/input/ibexa-types.raml');
        $usedByRouteTypeList = [];
        $usedByOtherTypeTypeList = [];

        foreach ($definedTypes as $type => $typeDefinition) {
            $usageFileList = shell_exec("grep 'type: $type' -R docs/api/rest_api/rest_api_reference/input | grep -v examples | grep -v ibexa-types.raml");
            if (!empty($usageFileList)) {
                $usedByRouteTypeList[] = $type;
            }
        }

        foreach ($usedByRouteTypeList as $usedByRouteType) {
            $definedType = $definedTypes[$usedByRouteType];
            $usedType = str_ends_with($definedType['type'], '[]') ? substr($definedType['type'], 0, -2) : $definedType['type'];
            if (!in_array($usedType, $usedByOtherTypeTypeList)) {
                $usedByOtherTypeTypeList[] = $usedType;
            }
            if (array_key_exists('properties', $definedType)) {
                foreach ($definedType['properties'] as $property => $propertyDefinition) {
                    if (is_array($propertyDefinition)) {
                        if (array_key_exists('type', $propertyDefinition)) {
                            if ('array' === $propertyDefinition['type']) {
                                $usedType = $propertyDefinition['items'];
                            } elseif (str_ends_with($propertyDefinition['type'], '[]')) {
                                $usedType = substr($propertyDefinition['type'], 0, -2);
                            } else {
                                $usedType = $propertyDefinition['type'];
                            }
                        }
                    } else {
                        if (str_ends_with($propertyDefinition, '[]')) {
                            $usedType = substr($propertyDefinition, 0, -2);
                        } else {
                            $usedType = $propertyDefinition;
                        }
                    }
                    if (!in_array($usedType, $usedByOtherTypeTypeList)) {
                        $usedByOtherTypeTypeList[] = $usedType;
                    }
                }
            }
        }

        $usedTypeList = array_merge($usedByRouteTypeList, $usedByOtherTypeTypeList);
        $unusedTypeList = array_diff(array_keys($definedTypes), $usedTypeList);

        dump($unusedTypeList);

        return 0;
    }
}
