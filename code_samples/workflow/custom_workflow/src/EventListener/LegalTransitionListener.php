<?php

declare(strict_types=1);

namespace App\EventListener;

use Ibexa\Contracts\AdminUi\Notification\TranslatableNotificationHandlerInterface as NotificationInterface;
use Ibexa\Contracts\Workflow\Event\Action\AbstractTransitionWorkflowActionListener;
use Ibexa\Contracts\Workflow\Registry\WorkflowRegistryInterface;
use Symfony\Component\Workflow\Event\TransitionEvent;

class LegalTransitionListener extends AbstractTransitionWorkflowActionListener
{
    public function __construct(
        private readonly NotificationInterface $notificationHandler,
        protected WorkflowRegistryInterface $workflowRegistry
    ) {}

    public function getIdentifier(): string
    {
        return 'legal_transition_action';
    }

    public function onWorkflowEvent(TransitionEvent $event): void
    {
        $workflow = $this->workflowRegistry->getWorkflow($event->getWorkflowName());
        $metadata = $this->getActionMetadata($workflow, $event->getTransition());
        $message = $metadata['data']['message'] ?? '';

        $this->notificationHandler->info(
            $message,
            [],
            'domain'
        );

        $this->setResult($event, true);
    }
}
