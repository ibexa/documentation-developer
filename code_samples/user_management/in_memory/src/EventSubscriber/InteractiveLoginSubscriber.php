<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Core\MVC\Symfony\Security\User;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\SecurityEvents;

class InteractiveLoginSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly UserService $userService)
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin'
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        $userMap = [
            'from_memory_user' => 'generic_customer_account',
        ];
        $userLogin = $userMap[$event->getAuthenticationToken()->getUserIdentifier()] ?? 'anonymous';
        $ibexaUser = $this->userService->loadUserByLogin($userLogin);
        $event->getAuthenticationToken()->setUser(new User($ibexaUser));

        return $event;
    }
}
