<?php
declare(strict_types=1);

namespace App\Setting;

use eZ\Publish\Core\Base\Exceptions\InvalidArgumentException;
use EzSystems\EzPlatformUser\UserSetting\FormMapperInterface;
use EzSystems\EzPlatformUser\UserSetting\ValueDefinitionInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class Unit implements ValueDefinitionInterface, FormMapperInterface
{
    public const METRIC_OPTION = 'metric';
    public const IMPERIAL_OPTION = 'imperial';

    public function getName(): string
    {
        return 'Unit';
    }

    public function getDescription(): string
    {
        return 'Choose between metric and imperial unit systems';
    }

    public function getDisplayValue(string $storageValue): string
    {
        switch ($storageValue) {
            case self::METRIC_OPTION:
                return 'Metric';
            case self::IMPERIAL_OPTION:
                return 'Imperial';
            default:
                throw new InvalidArgumentException(
                    '$storageValue',
                    sprintf('There is no \'%s\' option', $storageValue)
                );
        }
    }

    public function getDefaultValue(): string
    {
        return 'metric';
    }

    public function mapFieldForm(FormBuilderInterface $formBuilder, ValueDefinitionInterface $value): FormBuilderInterface
    {
        $choices = [
            'Metric' => self::METRIC_OPTION,
            'Imperial' => self::IMPERIAL_OPTION,
        ];

        return $formBuilder->create(
            'value',
            ChoiceType::class,
            [
                'multiple' => false,
                'required' => true,
                'label' => $this->getDescription(),
                'choices' => $choices,
            ]
        );
    }
}
