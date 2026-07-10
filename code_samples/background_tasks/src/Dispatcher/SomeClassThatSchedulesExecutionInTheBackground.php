<?php declare(strict_types=1);

namespace App\Dispatcher;

use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Messenger\Stamp\SudoStamp;
use Ibexa\Contracts\Messenger\Stamp\UserPermissionStamp;
use Symfony\Component\Messenger\MessageBusInterface;

final class SomeClassThatSchedulesExecutionInTheBackground
{
    private MessageBusInterface $bus;

    public function __construct(MessageBusInterface $bus)
    {
        $this->bus = $bus;
    }

    public function schedule(object $message): void
    {
        $this->bus->dispatch($message);

        $currentUserId = $this->permissionResolver->getCurrentUserReference()->getUserId();
        $this->bus->dispatch($message, [new UserPermissionStamp($currentUserId)]);
        $this->bus->dispatch($message, [new SudoStamp()]);
    }
}
