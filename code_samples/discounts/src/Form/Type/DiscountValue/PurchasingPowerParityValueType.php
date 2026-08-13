<?php
declare(strict_types=1);

namespace App\Form\Type\DiscountValue;

use App\Form\Data\PurchasingPowerParityValue;
use Ibexa\Bundle\Discounts\Form\Type\DiscountValueType;
use Ibexa\Contracts\ProductCatalog\Values\RegionInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends \Symfony\Component\Form\AbstractType<\App\Form\Data\PurchasingPowerParityValue>
 */
final class PurchasingPowerParityValueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $availableRegionHandler = static function (FormInterface $form, PurchasingPowerParityValue $data): void {
            $regions = $data->getDiscountData()->getGeneralProperties()->getRegions();
            $regionNames = implode(', ', array_map(static fn (RegionInterface $region): string => $region->getIdentifier(), $regions));

            $options = [
                'required' => false,
                'disabled' => true,
                'label' => 'This discount applies to the following regions',
                'data' => $regionNames,
            ];

            $form->add('value', TextType::class, $options);
        };

        $builder->add('type', FormType::class, [
            'mapped' => false,
            'label' => false,
        ]);

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            static function (PreSetDataEvent $event) use ($availableRegionHandler): void {
                $form = $event->getForm();
                $availableRegionHandler($form, $event->getData());
            },
        );
        $builder->get('type')->addEventListener(
            FormEvents::POST_SUBMIT,
            static function (PostSubmitEvent $event) use ($availableRegionHandler): void {
                $form = $event->getForm()->getParent();
                assert($form !== null);
                $availableRegionHandler($form, $form->getData());
            },
        );
    }

    #[\Override]
    public function getParent(): string
    {
        return DiscountValueType::class;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PurchasingPowerParityValue::class,
        ]);
    }
}
