<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\SomeMessage;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SomeHandler implements MessageHandlerInterface
{
    public function __invoke(SomeMessage $message): void
    {
        // Handle message.
    }
}
