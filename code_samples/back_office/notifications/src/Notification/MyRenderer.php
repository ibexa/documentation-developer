<?php

declare(strict_types=1);

namespace App\Notification;

use Ibexa\Contracts\Core\Repository\Values\Notification\Notification;
use Ibexa\Core\Notification\Renderer\NotificationRenderer;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class MyRenderer implements NotificationRenderer
{
    protected $twig;
    protected $router;

    public function __construct(Environment $twig, RouterInterface $router)
    {
        $this->twig = $twig;
        $this->router = $router;
    }

    public function render(Notification $notification): string
    {
        return $this->twig->render('@ibexadesign/notification.html.twig', ['notification' => $notification]);
    }

    public function generateUrl(Notification $notification): ?string
    {
        if (array_key_exists('content_id', $notification->data)) {
            return $this->router->generate('ibexa.content.view', ['contentId' => $notification->data['content_id']]);
        }

        return null;
    }
}
