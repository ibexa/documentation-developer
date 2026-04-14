<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\NotificationService;
use Ibexa\Contracts\IntegratedHelp\Event\RenderProductTourScenarioEvent;
use Ibexa\IntegratedHelp\ProductTour\Block\LinkBlock;
use Ibexa\IntegratedHelp\ProductTour\Block\TextBlock;
use Ibexa\IntegratedHelp\ProductTour\ProductTourStep;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class NotificationScenarioSubscriber implements EventSubscriberInterface
{
    public function __construct(private NotificationService $notificationService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RenderProductTourScenarioEvent::class => ['onRenderScenario'],
        ];
    }

    public function onRenderScenario(RenderProductTourScenarioEvent $event): void
    {
        $scenario = $event->getScenario();
        $steps = $scenario->getSteps();

        if ($scenario->getIdentifier() !== 'notifications') {
            return;
        }

        foreach ($steps as $step) {
            $scenario->removeStep($step);
        }

        if (!$this->hasUnreadNotifications()) {
            return;
        }

        $customStep = new ProductTourStep();
        $customStep->setIdentifier('custom_step_identifier');
        $customStep->setInteractionMode('clickable');
        $customStep->setTarget('.ibexa-header-user-menu__notifications-toggler');
        $customStep->setTitle('You have unread notifications');
        $customStep->addBlock(new TextBlock('Click here to preview your unread notifications.'));
        $customStep->addBlock(new LinkBlock(
            'https://doc.ibexa.co/projects/userguide/en/latest/getting_started/notifications/',
            'Learn more about notifications'
        ));

        $scenario->addStep($customStep);
    }

    private function hasUnreadNotifications(): bool
    {
        return $this->notificationService->getPendingNotificationCount() > 0;
    }
}
