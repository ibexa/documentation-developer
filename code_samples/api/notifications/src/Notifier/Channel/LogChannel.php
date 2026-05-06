<?php declare(strict_types=1);

namespace App\api\notifications\src\Notifier\Channel;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Notifier\Channel\ChannelInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\RecipientInterface;

class LogChannel implements ChannelInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function notify(Notification $notification, RecipientInterface $recipient, ?string $transportName = null): void
    {
        if (isset($this->logger)) {
            $this->logger->info($notification->getSubject(), [
                'class' => $notification::class,
                'importance' => $notification->getImportance(),
                'content' => $notification->getContent(),
            ]);
        }
    }

    public function supports(Notification $notification, RecipientInterface $recipient): bool
    {
        return true;
    }
}
