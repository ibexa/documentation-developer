<?php
declare(strict_types=1);

namespace App\Discounts\Step;

use App\Discounts\Condition\IsAccountAnniversary;
use Ibexa\Contracts\Discounts\Event\CreateFormDataEvent;
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
}
