<?php
declare(strict_types=1);

namespace App\Discounts\Step;

use App\Discounts\Condition\IsAccountAnniversary;
use Ibexa\Contracts\Discounts\Event\CreateDiscountCreateStructEvent;
use Ibexa\Contracts\Discounts\Event\CreateDiscountUpdateStructEvent;
use Ibexa\Contracts\Discounts\Event\CreateFormDataEvent;
use Ibexa\Contracts\Discounts\Event\DiscountStructEventInterface;
use Ibexa\Contracts\Discounts\Event\MapDiscountToFormDataEvent;
use Ibexa\Contracts\Discounts\Value\DiscountType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class AnniversaryConditionStepEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            CreateFormDataEvent::class => 'addAnniversaryConditionStep',
            MapDiscountToFormDataEvent::class => 'addAnniversaryConditionStep',
            CreateDiscountCreateStructEvent::class => 'addStepDataToStruct',
            CreateDiscountUpdateStructEvent::class => 'addStepDataToStruct',
        ];
    }

    /**
     * @param \Ibexa\Contracts\Discounts\Event\CreateFormDataEvent|\Ibexa\Contracts\Discounts\Event\MapDiscountToFormDataEvent $event
     */
    public function addAnniversaryConditionStep(Event $event): void
    {
        $data = $event->getData();
        if ($data->getType() !== DiscountType::CART) {
            return;
        }

        /** @var \App\Discounts\Condition\IsAccountAnniversary $discount */
        $discount = $event instanceof MapDiscountToFormDataEvent ?
                    $event->getDiscount()->getConditionByIdentifier(IsAccountAnniversary::IDENTIFIER) :
                    null;

        $conditionStep = $discount !== null ?
                        new AnniversaryConditionStep(true, $discount->getTolerance()) :
                        new AnniversaryConditionStep();

        $event->setData(
            $event->getData()->withStep(
                $conditionStep,
                AnniversaryConditionStep::IDENTIFIER,
                'Anniversary Condition',
                -45 // Priority
            )
        );
    }

    public function addStepDataToStruct(DiscountStructEventInterface $event): void
    {
        $step = $event->getData()
                        ->getStepByIdentifier(AnniversaryConditionStep::IDENTIFIER);

        if ($step === null) {
            return;
        }

        /** @var AnniversaryConditionStep $stepData */
        $stepData = $step->getStepData();

        if (!$stepData->enabled) {
            return;
        }

        $discountStruct = $event->getStruct();
        $discountStruct->addCondition(new IsAccountAnniversary($stepData->tolerance));
    }
}
