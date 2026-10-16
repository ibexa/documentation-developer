<?php declare(strict_types=1);

namespace App\Messenger;

use App\Message\SomeMessage;
use Ibexa\Contracts\Messenger\Transport\MessageProviderInterface;

final class SomeMessageProvider implements MessageProviderInterface
{
    public function getHandledClasses(): iterable
    {
        return [SomeMessage::class];
    }
}
