<?php

declare(strict_types=1);

namespace App\TranslationsManagement;

use Ibexa\AdminUi\Form\Type\Content\Translation\TranslationAddType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

final class MyTranslationAddExtension extends AbstractTypeExtension
{
    public static function getExtendedTypes(): iterable
    {
        return [TranslationAddType::class];
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('my_custom_field'/* ... */);
    }
}
