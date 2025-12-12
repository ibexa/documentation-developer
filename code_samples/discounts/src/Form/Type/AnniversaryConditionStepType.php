<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\Discounts\Step\AnniversaryConditionStep;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends \Symfony\Component\Form\AbstractType<AnniversaryConditionStep>
 */
final class AnniversaryConditionStepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add(
            'enabled',
            CheckboxType::class,
            [
                'label' => 'Enable anniversary discount',
                'required' => false,
            ]
        )->add(
            'tolerance',
            NumberType::class,
            [
                'label' => 'Tolerance in days',
                'required' => false,
            ]
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AnniversaryConditionStep::class,
        ]);
    }
}
