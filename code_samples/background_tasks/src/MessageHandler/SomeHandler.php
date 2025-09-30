<?php

namespace App\MessageHandler;

use App\Message\SomeMessage;
final class SomeHandler
{
    public function __invoke(SomeMessage $message): void
    {
        // Handle message.
    }
}
