<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
//use Ibexa\Core\MVC\Symfony\Security\User;
use Ibexa\Core\MVC\Symfony\Security\UserWrapped;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\Security\Http\Event\AuthenticationTokenCreatedEvent;

final readonly class AuthenticationTokenCreatedSubscriber implements EventSubscriberInterface
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
            AuthenticationTokenCreatedEvent::class => ['onAuthenticationTokenCreated', 10],
        ];
    }

    public function onAuthenticationTokenCreated(AuthenticationTokenCreatedEvent $event): void
    {
        $tokenUser = $event->getAuthenticatedToken()->getUser();
        if (!$tokenUser instanceof InMemoryUser) {
            return;
        }
        $userIdentifier = $event->getAuthenticatedToken()->getUserIdentifier();
        $ibexaUser = null;
        if (array_key_exists($userIdentifier, $this->userMap)) {
            $ibexaUser = $this->userService->loadUserByLogin($this->userMap[$userIdentifier]);
        }
        if (null === $ibexaUser) {
            $anonymousUserId = (int)$this->configResolver->getParameter('anonymous_user_id');
            $ibexaUser = $this->userService->loadUser($anonymousUserId);
        }
        //$event->getAuthenticatedToken()->setUser(new User($ibexaUser));
        $event->getAuthenticatedToken()->setUser(new UserWrapped($tokenUser, $ibexaUser));
    }
}
