<?php declare(strict_types=1);

namespace App\Notifications;

use Ibexa\Contracts\Notifications\SystemNotification\SystemMessage;
use Ibexa\Contracts\Notifications\SystemNotification\SystemNotificationInterface;
use Ibexa\Contracts\Notifications\Value\Recipent\UserRecipientInterface;
use Symfony\Bridge\Twig\Mime\NotificationEmail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Notifier\Message\EmailMessage;
use Symfony\Component\Notifier\Notification\EmailNotificationInterface;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\Recipient\EmailRecipientInterface;
use Throwable;

class CommandExecuted extends Notification implements SystemNotificationInterface, EmailNotificationInterface
{
    /** @param array<int, Throwable> $exceptions */
    public function __construct(
        private readonly Command $command,
        private readonly int $exitCode,
        private readonly array $exceptions
    ) {
        parent::__construct($this->command->getName());
    }

    public function asEmailMessage(EmailRecipientInterface $recipient, ?string $transport = null): ?EmailMessage
    {
        $subject = (0 === $this->exitCode ? '✔' : '✖') . $this->command->getName();

        $body = '';
        foreach ($this->exceptions as $exception) {
            $body .= $exception->getMessage() . '<br>';
        }

        $email = NotificationEmail::asPublicEmail()
            ->to($recipient->getEmail())
            ->subject($subject)
            ->html($body);

        return new EmailMessage($email);
    }

    public function asSystemNotification(UserRecipientInterface $recipient, ?string $transport = null): ?SystemMessage
    {
        $message = new SystemMessage($recipient->getUser());
        $message->setContext([
            'icon' => 0 === $this->exitCode ? 'check-circle' : 'discard-circle',
            'subject' => $this->command->getName(),
            'content' => 0 === $this->exitCode ? 'No error' : count($this->exceptions) . ' error' . (count($this->exceptions) > 1 ? 's' : ''),
        ]);

        return $message;
    }
}
