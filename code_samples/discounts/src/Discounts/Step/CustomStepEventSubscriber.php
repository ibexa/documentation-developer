<?php
declare(strict_types=1);

namespace App\Discounts\Step;

use Ibexa\Contracts\Discounts\Event\CreateFormDataEvent;
use Ibexa\Contracts\Discounts\Value\DiscountType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class CustomStepEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            CreateFormDataEvent::class => 'onCreateFormDataEvent',
        ];
    }

    public function onCreateFormDataEvent(CreateFormDataEvent $event): void
    {
        $data = $event->getData();
        if ($data->getType() !== DiscountType::CART) {
            return;
        }

        $event->setData(
            $event->getData()->withStep(
                new CustomStep(),
                CustomStep::IDENTIFIER,
                'Custom step',
                -45
            )
        );
    }
}
