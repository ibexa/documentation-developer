<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
use Ibexa\Core\MVC\Symfony\Security\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

final readonly class InteractiveLoginSubscriber implements EventSubscriberInterface
{
    /** @param array<string, string> $userMap */
    public function __construct(
        private readonly ConfigResolverInterface $configResolver,
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
        $userIdentifier = $event->getAuthenticationToken()->getUserIdentifier();
        $ibexaUser = null;
        if (array_key_exists($userIdentifier, $this->userMap)) {
            $ibexaUser = $this->userService->loadUserByLogin($this->userMap[$userIdentifier]);
        }
        if (null === $ibexaUser) {
            $anonymousUserId = (int)$this->configResolver->getParameter('anonymous_user_id');
            $ibexaUser = $this->userService->loadUser($anonymousUserId);
        }
        $event->getAuthenticationToken()->setUser(new User($ibexaUser));
    }
}
