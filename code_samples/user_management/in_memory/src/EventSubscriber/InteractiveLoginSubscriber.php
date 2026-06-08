<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Core\MVC\Symfony\Security\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

final readonly class InteractiveLoginSubscriber implements EventSubscriberInterface
{
    /** @param array<string, string> $userMap */
    public function __construct(
        private readonly UserService $userService,
        private readonly array $userMap = [],
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin',
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $tokenUser = $event->getAuthenticationToken()->getUser();
        if (!$tokenUser instanceof InMemoryUser) {
            return;
        }
        $userLogin = $this->userMap[$event->getAuthenticationToken()->getUserIdentifier()] ?? 'anonymous';
        $ibexaUser = $this->userService->loadUserByLogin($userLogin);
        $event->getAuthenticationToken()->setUser(new User($ibexaUser));
    }
}
