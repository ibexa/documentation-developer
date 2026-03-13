<?php declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Core\MVC\Symfony\Event\InteractiveLoginEvent;
use Ibexa\Core\MVC\Symfony\MVCEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class InteractiveLoginSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Ibexa\Contracts\Core\Repository\UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public static function getSubscribedEvents()
    {
        return [
            MVCEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin',
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event)
    {
        // This loads a generic User and assigns it back to the event.
        // You may want to create Users here, or even load predefined Users depending on your own rules.
        $event->setApiUser($this->userService->loadUserByLogin('lolautruche'));
    }
}
