<?php

declare(strict_types=1);

namespace App\EventListener;

use Ibexa\Contracts\AdminUi\Notification\TranslatableNotificationHandlerInterface as NotificationInterface;
use Ibexa\Contracts\Workflow\Event\Action\AbstractTransitionWorkflowActionListener;
use Symfony\Component\Workflow\Event\TransitionEvent;

class ApprovedTransitionListener extends AbstractTransitionWorkflowActionListener
{
    public function __construct(private readonly NotificationInterface $notificationHandler)
    {
    }

    public function getIdentifier(): string
    {
        return 'approved_transition_action';
    }

    public function onWorkflowEvent(TransitionEvent $event): void
    {
        $context = $event->getContext();
        $message = $context['message'];

        $this->notificationHandler->info(
            $message,
            [],
            'domain'
        );
    }
}
