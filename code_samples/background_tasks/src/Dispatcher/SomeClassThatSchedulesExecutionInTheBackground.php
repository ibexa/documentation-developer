<?php declare(strict_types=1);

namespace App\Dispatcher;

use Ibexa\Bundle\Messenger\Stamp\DeduplicateStamp;
use Symfony\Component\Messenger\Envelope;
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
        // Dispatch directly. Message is wrapped with envelope without any stamps.
        $this->bus->dispatch($message);

        // Alternatively, wrap with stamps. In this case, DeduplicateStamp ensures
        // that if similar command exists in the queue (or is being processed)
        // it will not be queued again.
        $envelope = Envelope::wrap(
            $message,
            [new DeduplicateStamp('command-name-1')]
        );

        $this->bus->dispatch($envelope);
    }
}
