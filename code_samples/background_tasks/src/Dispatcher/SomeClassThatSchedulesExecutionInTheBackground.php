<?php declare(strict_types=1);

namespace App\Dispatcher;

use Ibexa\Bundle\Messenger\Stamp\DeduplicateStamp;
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

        $deduplicationKey = 'my_message.project.<key_based_on_message>';
        $this->bus->dispatch($message, [new DeduplicateStamp($deduplicationKey)]);
    }
}
