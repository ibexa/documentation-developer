<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Corporate\EventSubscriber;

use App\Corporate\Form\VerifyType;
use Ibexa\Contracts\AdminUi\Notification\TranslatableNotificationHandlerInterface;
use Ibexa\Contracts\CorporateAccount\Event\Application\Workflow\ApplicationWorkflowFormEvent;
use Ibexa\Contracts\CorporateAccount\Event\Application\Workflow\MapApplicationWorkflowFormEvent;
use Ibexa\CorporateAccount\Event\ApplicationWorkflowEvents;
use Ibexa\CorporateAccount\Persistence\Legacy\ApplicationState\HandlerInterface;
use Ibexa\CorporateAccount\Persistence\Values\ApplicationStateUpdateStruct;
use JMS\TranslationBundle\Annotation\Desc;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormFactoryInterface;

final class VerifyStateEventSubscriber implements EventSubscriberInterface
{
    private const VERIFY_STATE = 'verify';

    private FormFactoryInterface $formFactory;

    private HandlerInterface $applicationStateHandler;

    private TranslatableNotificationHandlerInterface $notificationHandler;

    public function __construct(
        FormFactoryInterface $formFactory,
        HandlerInterface $applicationStateHandler,
        TranslatableNotificationHandlerInterface $notificationHandler
    ) {
        $this->formFactory = $formFactory;
        $this->applicationStateHandler = $applicationStateHandler;
        $this->notificationHandler = $notificationHandler;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MapApplicationWorkflowFormEvent::class => 'mapApplicationWorkflowForm',
            ApplicationWorkflowEvents::getStateEvent(self::VERIFY_STATE) => 'applicationVerify',
        ];
    }

    public function mapApplicationWorkflowForm(MapApplicationWorkflowFormEvent $event): void
    {
        if ($event->getState() === self::VERIFY_STATE) {
            $form = $this->formFactory->create(VerifyType::class, $event->getData());

            $event->setForm($form);
        }
    }

    public function applicationVerify(ApplicationWorkflowFormEvent $event): void
    {
        $data = $event->getData();

        if (!is_array($data)) {
            return;
        }

        $applicationStateUpdateStruct = new ApplicationStateUpdateStruct($event->getApplicationState()->getId());
        $applicationStateUpdateStruct->state = self::VERIFY_STATE;

        $this->applicationStateHandler->update($applicationStateUpdateStruct);

        $this->notificationHandler->success(
            /** @Desc("Application moved to Verification state") */
            'application.state.verify.notification',
            [],
            'corporate_account_application'
        );
    }
}
