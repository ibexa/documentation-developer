<?php

declare(strict_types=1);

namespace App\Notification;

use Ibexa\Contracts\Core\Repository\Values\Notification\Notification;
use Ibexa\Core\Notification\Renderer\NotificationRenderer;
use Ibexa\Core\Notification\Renderer\TypedNotificationRendererInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class ListRenderer implements NotificationRenderer, TypedNotificationRendererInterface
{
    protected Environment $twig;

    protected RouterInterface $router;

    protected RequestStack $requestStack;

    public function __construct(Environment $twig, RouterInterface $router, RequestStack $requestStack)
    {
        $this->twig = $twig;
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    public function render(Notification $notification): string
    {
        $templateToExtend = '@ibexadesign/account/notifications/list_item.html.twig';
        $currentRequest = $this->requestStack->getCurrentRequest();
        if ($currentRequest && $currentRequest->attributes->getBoolean('render_all')) {
            $templateToExtend = '@ibexadesign/account/notifications/list_item_all.html.twig';
        }

        return $this->twig->render('@ibexadesign/notification.html.twig', [
            'notification' => $notification,
            'template_to_extend' => $templateToExtend,
        ]);
    }

    public function generateUrl(Notification $notification): ?string
    {
        if (array_key_exists('content_id', $notification->data)) {
            return $this->router->generate('ibexa.content.view', [
                'contentId' => $notification->data['content_id'],
            ]);
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
