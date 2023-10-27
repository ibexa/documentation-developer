<?php

declare(strict_types=1);

namespace App\EventListener;

use EzSystems\EzPlatformAdminUi\Notification\TranslatableNotificationHandlerInterface as NotificationInterface;
use EzSystems\EzPlatformWorkflow\Event\Action\AbstractTransitionWorkflowActionListener;
use Symfony\Component\Workflow\Event\TransitionEvent;

class ApprovedTransitionListener extends AbstractTransitionWorkflowActionListener
{
    private $notificationHandler;

    public function __construct(NotificationInterface $notificationHandler)
    {
        $this->notificationHandler = $notificationHandler;
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
