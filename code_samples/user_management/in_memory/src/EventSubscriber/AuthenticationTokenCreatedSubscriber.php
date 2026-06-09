<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class InteractiveLoginSubscriber implements EventSubscriberInterface
{
    /**
     * @param array<string, string> $userMap
     *
     * @phpstan-param UserProviderInterface<\Ibexa\Core\MVC\Symfony\Security\UserInterface> $userProvider
     */
    public function __construct(
        private readonly UserProviderInterface $userProvider,
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
        if ($tokenUser instanceof InMemoryUser) {
            $userLogin = $this->userMap[$event->getAuthenticationToken()->getUserIdentifier()] ?? 'anonymous';
            $ibexaSecurityUser = $this->userProvider->loadUserByIdentifier($userLogin);
            $event->getAuthenticationToken()->setUser($ibexaSecurityUser);
        }
    }
}
