<?php

declare(strict_types=1);

namespace App\Notification;

use Ibexa\Contracts\Core\Repository\Values\Notification\Notification;
use Ibexa\Core\Notification\Renderer\NotificationRenderer;
use Ibexa\Core\Notification\Renderer\TypedNotificationRendererInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class MyRenderer implements NotificationRenderer, TypedNotificationRendererInterface
{
    protected Environment $twig;

    protected RouterInterface $router;

    protected TranslatorInterface $translator;

    public function __construct(Environment $twig, RouterInterface $router, TranslatorInterface $translator)
    {
        $this->twig = $twig;
        $this->router = $router;
        $this->translator = $translator;
    }

    public function render(Notification $notification): string
    {
        return $this->twig->render('@ibexadesign/notification.html.twig', [
            'notification' => $notification,
            'template_to_extend' => '@ibexadesign/account/notifications/list_item.html.twig',
        ]);
    }

    public function generateUrl(Notification $notification): ?string
    {
        if (array_key_exists('content_id', $notification->data)) {
            return $this->router->generate('ibexa.content.view', ['contentId' => $notification->data['content_id']]);
        }

        return null;
    }

    public function getTypeLabel(): string
    {
        return /** @Desc("Workflow stage changed") */
            $this->translator->trans(
                'workflow.notification.stage_change.label',
                [],
                'ibexa_workflow'
            );
    }
}
