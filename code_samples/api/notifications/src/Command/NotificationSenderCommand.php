<?php

declare(strict_types=1);

namespace App\Command;

use App\Notifications\CommandExecuted;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Notifications\Service\NotificationServiceInterface;
use Ibexa\Contracts\Notifications\Value\Notification\SymfonyNotificationAdapter;
use Ibexa\Contracts\Notifications\Value\Recipent\SymfonyRecipientAdapter;
use Ibexa\Contracts\Notifications\Value\Recipent\UserRecipient;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Notifier\Recipient\RecipientInterface;

#[AsCommand(name: 'app:send_notification', description: 'Example of command sending a notification')]
class NotificationSenderCommand extends Command
{
    /** @param array<int, string> $recipientLogins */
    public function __construct(
        private readonly NotificationServiceInterface $notificationService,
        private readonly UserService $userService,
        private readonly array $recipientLogins = ['admin'],
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var array<int, \Throwable> $exceptions */
        $exceptions = [];

        try {
            // Do something
            if (random_int(0, 1) == 1) {
                throw new \RuntimeException('Something went wrong');
            }
            $exitCode = Command::SUCCESS;
        } catch (\Exception $exception) {
            $exceptions[] = $exception;
            $exitCode = Command::FAILURE;
        }

        $recipients = [];
        foreach ($this->recipientLogins as $login) {
            try {
                $user = $this->userService->loadUserByLogin($login);
                $recipients[] = new UserRecipient($user);
            } catch (\Exception $exception) {
                $exceptions[] = $exception;
            }
        }

        $this->notificationService->send(
            new SymfonyNotificationAdapter(new CommandExecuted($this, $exitCode, $exceptions)),
            array_map(
                static fn (RecipientInterface $recipient): SymfonyRecipientAdapter => new SymfonyRecipientAdapter($recipient),
                $recipients
            )
        );

        return $exitCode;
    }
}
