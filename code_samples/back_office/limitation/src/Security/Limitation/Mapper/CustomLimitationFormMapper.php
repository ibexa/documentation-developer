<?php

declare(strict_types=1);

namespace App\Security\Limitation\Mapper;

use Ibexa\AdminUi\Limitation\LimitationFormMapperInterface;
use Ibexa\Contracts\Core\Repository\Values\User\Limitation;
use Ibexa\Core\Limitation\LimitationIdentifierToLabelConverter;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormInterface;

class CustomLimitationFormMapper implements LimitationFormMapperInterface
{
    public function mapLimitationForm(FormInterface $form, Limitation $data): void
    {
        $form->add('limitationValues', CheckboxType::class, [
            'label' => LimitationIdentifierToLabelConverter::convert($data->getIdentifier()),
            'required' => false,
            'data' => $data->limitationValues['value'],
            'property_path' => 'limitationValues[value]',
        ]);
    }

    public function getFormTemplate(): string
    {
        return '@ibexadesign/limitation/custom_limitation_form.html.twig';
    }

    public function filterLimitationValues(Limitation $limitation): void
    {
    }
}
