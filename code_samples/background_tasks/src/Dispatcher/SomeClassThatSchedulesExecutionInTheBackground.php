<?php declare(strict_types=1);

namespace App\Dispatcher;

use App\Message\SomeMessage;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp;
use Ibexa\Contracts\Messenger\Stamp\SudoStamp;
use Ibexa\Contracts\Messenger\Stamp\UserPermissionStamp;
use Symfony\Component\Messenger\MessageBusInterface;

final readonly class SomeClassThatSchedulesExecutionInTheBackground
{
    public function __construct(
        private MessageBusInterface $bus,
        private PermissionResolver $permissionResolver,
    ) {
    }

    public function schedule(): void
    {
        $this->bus->dispatch(new SomeMessage());

        $currentUserId = $this->permissionResolver->getCurrentUserReference()->getUserId();
        $this->bus->dispatch(new SomeMessage(), [new UserPermissionStamp($currentUserId)]);
        $this->bus->dispatch(new SomeMessage(), [new SudoStamp()]);

        $deduplicationKey = 'my_message.project.<key_based_on_message>';
        $this->bus->dispatch(new SomeMessage(), [new DeduplicateStamp($deduplicationKey)]);
    }
}
