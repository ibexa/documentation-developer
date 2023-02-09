<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Corporate\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class VerifyType extends AbstractType
{
    private const FIELD_APPLICATION = 'application';
    private const FIELD_NOTES = 'notes';
    private const FIELD_VERIFY = 'verify';

    public function buildForm(
        FormBuilderInterface $builder,
        array $options
    ): void {
        $builder
            ->add(self::FIELD_APPLICATION, HiddenType::class)
            ->add('new_field', TextType::class)
            ->add(self::FIELD_NOTES, TextareaType::class, [
                'required' => false,
            ])
            ->add(self::FIELD_VERIFY, SubmitType::class);
    }
}
