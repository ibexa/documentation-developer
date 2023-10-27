<?php

namespace App\Security\Limitation\Mapper;

use eZ\Publish\API\Repository\Values\User\Limitation;
use EzSystems\EzPlatformAdminUi\Translation\Extractor\LimitationTranslationExtractor;
use EzSystems\RepositoryForms\Limitation\LimitationFormMapperInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CustomLimitationFormMapper implements LimitationFormMapperInterface
{
    public function mapLimitationForm(FormInterface $form, Limitation $data)
    {
        $form->add('limitationValues', CheckboxType::class, [
            'label' => LimitationTranslationExtractor::identifierToLabel($data->getIdentifier()),
            'required' => false,
            'data' => $data->limitationValues['value'],
            'property_path' => 'limitationValues[value]'
        ]);
    }

    public function getFormTemplate()
    {
        return '@ezdesign/limitation/custom_limitation_form.html.twig';
    }

    //TODO: public function filterLimitationValues(Limitation $limitation)
}
