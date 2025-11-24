<?php declare(strict_types=1);

namespace App\Discounts\Step;

use App\Form\Type\CustomStepType;
use Ibexa\Contracts\Discounts\Admin\Form\Data\DiscountStepData;
use Ibexa\Contracts\Discounts\Admin\Form\Listener\AbstractStepFormListener;
use JMS\TranslationBundle\Model\Message;
use JMS\TranslationBundle\Translation\TranslationContainerInterface;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\FormInterface;

final class CustomStepFormListener extends AbstractStepFormListener implements TranslationContainerInterface
{
    public function isDataSupported(DiscountStepData $data): bool
    {
        return $data->getStepData() instanceof CustomStep;
    }

    public function addFields(FormInterface $form, DiscountStepData $data, PreSetDataEvent $event): void
    {
        $form->add(
            'stepData',
            CustomStepType::class,
            [
                'label' => false,
            ]
        );
    }

    public static function getTranslationMessages(): array
    {
        return [
            (new Message('discount.step.custom.label', 'discount'))->setDesc('Custom'),
        ];
    }
}
