<?php declare(strict_types=1);

use App\Notifications\MyNotification; // extends Symfony\Component\Notifier\Notification\Notification
use Ibexa\Contracts\Notifications\Value\Notification\SymfonyNotificationAdapter;
use Ibexa\Contracts\Notifications\Value\Recipent\SymfonyRecipientAdapter;
use Ibexa\Contracts\Notifications\Value\Recipent\UserRecipient;

$subject = 'My subject';

/** @var \Ibexa\Contracts\Notifications\Service\NotificationServiceInterface $notificationService */
/** @var \Ibexa\Contracts\Core\Repository\UserService $userService */
/** @var \Ibexa\Contracts\Core\Repository\PermissionResolver $permissionResolver */
$notificationService->send(
    new SymfonyNotificationAdapter(new MyNotification($subject)),
    [new SymfonyRecipientAdapter(new UserRecipient($userService->loadUser($permissionResolver->getCurrentUserReference()->getUserId())))],
);
