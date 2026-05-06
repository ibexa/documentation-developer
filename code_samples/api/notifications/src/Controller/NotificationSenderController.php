<?php declare(strict_types=1);

namespace App\api\notifications\src\Controller;

use App\api\notifications\src\Notifications\ControllerFeedback;
use Ibexa\Contracts\Notifications\Service\NotificationServiceInterface;
use Ibexa\Contracts\Notifications\Value\Notification\SymfonyNotificationAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NotificationSenderController extends AbstractController
{
    public function __construct(
        private readonly NotificationServiceInterface $notificationService,
    ) {
    }

    #[Route('/notification-sender')]
    public function index(): Response
    {
        $this->notificationService->send(
            new SymfonyNotificationAdapter((new ControllerFeedback('Message sent from controller'))->emoji('👍')),
        );

        return $this->render('@ibexadesign/notification-sender-controller.html.twig');
    }
}
