# Notification channels

Notify users through several channels.

The `ibexa/notifications` package integrates the [Symfony Notifier](https://symfony.com/doc/7.4/notifier.html) with Ibexa DXP. You can use it to create notifications and send them through various channels such as email, SMS, communication platforms, and the [back office user notifications](../../administration/back_office/notifications/index.md#user-notifications).

These notifications must not be confused with the [notification bars](../../administration/back_office/notifications/index.md#notification-bars) or the [user notifications](../../administration/back_office/notifications/index.md#user-notifications):

| Notification category                                                                                          | Sent with                                                                                                                                                                                          | Description                                                                                                            |
| -------------------------------------------------------------------------------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------- |
| [Notification bars](../../administration/back_office/notifications/index.md#notification-bars)   | [`Ibexa\Contracts\AdminUi\Notification\TranslatableNotificationHandlerInterface`](../../../../../ibexa/admin-ui/src/contracts/Notification/TranslatableNotificationHandlerInterface.php) | Rendered as a message bar in the bottom-right corner.                                                                  |
| [User notifications](../../administration/back_office/notifications/index.md#user-notifications) | [`Ibexa\Contracts\Core\Repository\NotificationService`](../../../../../ibexa/core/src/contracts/Repository/NotificationService.php)                                                | Rendered as [back office notification](../../../user/getting_started/notifications/index.md). |
| [Channel-based notifications](#subscribe-to-notifications)                                                     | [`Ibexa\Contracts\Notifications\Service\NotificationServiceInterface`](../../../../../ibexa/notifications/src/contracts/Service/NotificationServiceInterface.php)                        | Rendering depends on the channel assigned to the notification type.                                                    |

Unlike notification bars and user notifications, channel-based notifications don't have a predefined channel. You can configure how they are delivered to the user by using YAML configuration. Several channels are provided, and you can create your own.

The [`Ibexa\Contracts\Notifications\Service\NotificationServiceInterface`](../../../../../ibexa/notifications/src/contracts/Service/NotificationServiceInterface.php) sends notifications, objects extending the `Symfony\Component\Notifier\Notification\Notification` class. You can inject this notification service into your code to send the built-in or custom notification types. Channel services implementing `Symfony\Component\Notifier\Channel\ChannelInterface` subscribe to a selection of notification types and deliver notifications to users through various transports.

## Subscribe to notifications

Some events generate notifications that you can deliver to the users through one or more channels.

### Available notification types

- [`Ibexa\Contracts\FormBuilder\Notifications\FormSubmitted`](../../../../../ibexa/form-builder/src/contracts/Notifications/FormSubmitted.php)
- [`Ibexa\Contracts\Notifications\SystemNotification\SystemNotification`](../../../../../ibexa/notifications/src/contracts/SystemNotification/SystemNotification.php)
- [`Ibexa\Contracts\OrderManagement\Notification\OrderStatusChange`](../../../../../ibexa/order-management/src/contracts/Notification/OrderStatusChange.php)
- [`Ibexa\Contracts\Payment\Notification\PaymentStatusChange`](../../../../../ibexa/payment/src/contracts/Notification/PaymentStatusChange.php)
- [`Ibexa\Contracts\Shipping\Notification\ShipmentStatusChange`](../../../../../ibexa/shipping/src/contracts/Notification/ShipmentStatusChange.php)
- [`Ibexa\Contracts\User\Notification\UserInvitation`](../../../../../ibexa/user/src/contracts/Notification/UserInvitation.php)
- [`Ibexa\Contracts\User\Notification\UserPasswordReset`](../../../../../ibexa/user/src/contracts/Notification/UserPasswordReset.php)
- [`Ibexa\Contracts\User\Notification\UserRegister`](../../../../../ibexa/user/src/contracts/Notification/UserRegister.php)
- `Ibexa\Share\Notification\ContentEditInvitationNotification`
- `Ibexa\Share\Notification\ContentViewInvitationNotification`
- `Ibexa\Share\Notification\ExternalParticipantContentViewInvitationNotification`

### Available notification channels

You can list the notification channel services with the following command:

```bash
php bin/console debug:container --tag=notifier.channel
```

- `actito` - Notification forwarded as [transactional email](../../commerce/transactional_emails/transactional_emails/index.md)
- `browser` - Notification forwarded as [flash message](https://symfony.com/doc/7.4/session.html#flash-messages)
- [`chat`](https://symfony.com/doc/7.4/notifier.html#chat-channel) - Notification forwarded to a communication platform like Slack, Microsoft Teams, or Google Chat
- [`desktop`](https://symfony.com/doc/7.4/notifier.html#desktop-channel) - Notification forwarded to desktop applications like JoliNotif
- [`email`](https://symfony.com/doc/7.4/notifier.html#email-channel) - Notification forwarded to email addresses
- `ibexa` - Notification forwarded as [back office user notifications](../../administration/back_office/notifications/index.md#user-notifications)
- [`push`](https://symfony.com/doc/7.4/notifier.html#push-channel) - Notification forwarded to specific applications
- [`sms`](https://symfony.com/doc/7.4/notifier.html#sms-channel) - Notification forwarded to phone numbers

### Subscriptions configuration

You can find the default configuration in `config/packages/ibexa.yaml` and `config/packages/ibexa_admin_ui.yaml`. You can modify it to define your own subscriptions. This page contains several examples of subscriptions configuration.

> **Caution: Scopes may not merge as expected**
>
> Subscriptions defined for a scope may not merge with subscriptions from other scopes or from other files. For example, `default` scope might not be merged within a siteaccess group scope. To ensure you don't unsubscribe channels by mistake, always use the following command to check subscriptions for a siteaccess before and after any changes:
>
> ```bash
> php bin/console ibexa:debug:config notifications.subscriptions --siteaccess=<siteaccess>
> ```

#### Subscription example

The following example shows how you can deliver notifications about Commerce-related activities through Slack:

1. Install the Slack Notifier package:

   ```bash
   composer require symfony/slack-notifier
   ```

2. In a .env file, [set the DSN to target a Slack channel or a Slack user](https://github.com/symfony/slack-notifier?tab=readme-ov-file#dsn-example):

   ```text
   SLACK_DSN=slack://xoxb-token@default?channel=ibexa-notifications
   ```

3. Subscribe to notification types related to Commerce, such as order, payment, and shipment status changes. For example, define the following configuration in a new `config/packages/notifications.yaml` file:

   ```yaml
   framework:
       notifier:
           chatter_transports:
               slack: '%env(SLACK_DSN)%'
   ibexa:
       system:
           default:
               notifier:
                   subscriptions:
                       # The configuration below is added to the `default` scope without overriding the one defined in ibexa.yaml
                       # Custom subscriptions:
                       Ibexa\OrderManagement\Notification\OrderStatusChange:
                           channels:
                               - chat
                       Ibexa\Payment\Notification\PaymentStatusChange:
                           channels:
                               - chat
                       Ibexa\Shipping\Notification\ShipmentStatusChange:
                           channels:
                               - chat
   ```

## Create notification class

You can define a new notification type and assign a new set of channels to it, customizing how it's delivered. It must extend the `Symfony\Component\Notifier\Notification\Notification` class and can optionally implement interfaces required by specific channels.

- Some channels don't accept the notification if it doesn't implement their specific notification interface. These interfaces come with a method to specifically format the notification for the channel.
- Some channels accept every notification and have a default formatting if the notification doesn't implement their specific notification interface.

| Channel   | Specific notification interface                                                                                                                                                                                                       | Accepts any notification object |
| --------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------- |
| `actito`  | `Symfony\Component\Notifier\Notification\EmailNotificationInterface`                                                                                                                                                                  | **No**                          |
| `chat`    | `Symfony\Component\Notifier\Notification\ChatNotificationInterface`                                                                                                                                                                   | Yes                             |
| `desktop` | `Symfony\Component\Notifier\Notification\DesktopNotificationInterface`                                                                                                                                                                | Yes                             |
| `email`   | `Symfony\Component\Notifier\Notification\EmailNotificationInterface`                                                                                                                                                                  | **No**                          |
| `ibexa`   | [`Ibexa\Contracts\Notifications\SystemNotification\SystemNotificationInterface`](../../../../../ibexa/notifications/src/contracts/SystemNotification/SystemNotificationInterface.php) | **No**                          |
| `push`    | `Symfony\Component\Notifier\Notification\PushNotificationInterface`                                                                                                                                                                   | Yes                             |
| `sms`     | `Symfony\Component\Notifier\Notification\SmsNotificationInterface`                                                                                                                                                                    | **No**                          |

The `ibexa` channel sends notifications to users through their profile menu, exactly as [user notifications](../../administration/back_office/notifications/index.md#user-notifications). The [`SystemNotificationChannel` uses the core `NotificationService`](https://github.com/ibexa/notifications/blob/v5.0.7/src/lib/SystemNotification/SystemNotificationChannel.php#L51) to do so.

Some channels don't need a recipient:

- `browser`: Always sends a flash message to the current user
- `chat`: Always sends a message to the same connection resource

### Notification sending

Use the objects from the [`Ibexa\Contracts\Notifications`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-notifications.html) namespace to work with notifications.

The [`…\Service\NotificationServiceInterface::send()`](../../../../../ibexa/notifications/src/contracts/Service/NotificationServiceInterface.php) expects two arguments:

- The first argument is an [`…\Value\NotificationInterface`](../../../../../ibexa/notifications/src/contracts/Value/NotificationInterface.php). This interface is implemented by the [`…\Value\Notification\SymfonyNotificationAdapter`](../../../../../ibexa/notifications/src/contracts/Value/Notification/SymfonyNotificationAdapter.php) which allows you to wrap any class extending `Symfony\Component\Notifier\Notification\Notification`.
- The optional second argument is an array of [`…\Value\RecipientInterface`](../../../../../ibexa/notifications/src/contracts/Value/RecipientInterface.php). This interface is implemented by the [`…\Value\Recipent\SymfonyRecipientAdapter`](../../../../../ibexa/notifications/src/contracts/Value/Recipent/SymfonyRecipientAdapter.php) used to wrap `Symfony\Component\Notifier\Recipient\RecipientInterface`.
  - This Symfony interface is implemented by [`…\Value\Recipent\UserRecipient`](../../../../../ibexa/notifications/src/contracts/Value/Recipent/UserRecipient.php) which can wrap classes implementing the [`Ibexa\Contracts\Core\Repository\Values\User\UserReference` interface](../../../../../ibexa/core/src/contracts/Repository/Values/User/UserReference.php),
    - The [`UserService` methods to load a user](../../../../../ibexa/core/src/contracts/Repository/UserService.php) are returning objects implementing this `UserReference` interface.
    - The [`PermissionResolver::getCurrentUserReference()` method](../../../../../ibexa/core/src/contracts/Repository/PermissionResolver.php) is returning objects implementing this `UserReference` interface.

For example, to send a notification, you often use a combination like the following:

```php
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
```

### `CommandExecuted` example

The following example is a command that sends a notification to users on several channels simultaneously. This example could be a scheduled task or cron job that warns users about its result.

1. First, create a `CommandExecuted` notification type. It supports two channels (`ibexa`, `email`), but could be extended to support more. As constructor arguments, an instance takes the command itself, the exit code of the run, and any caught exceptions.

   ```php
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
           parent::__construct((Command::SUCCESS === $this->exitCode ? '✔' : '✖') . $this->command->getName());
           $this->importance(Command::SUCCESS === $this->exitCode ? Notification::IMPORTANCE_LOW : Notification::IMPORTANCE_HIGH);
       }

       public function asEmailMessage(EmailRecipientInterface $recipient, ?string $transport = null): ?EmailMessage
       {
           $body = '';
           foreach ($this->exceptions as $exception) {
               $body .= $exception->getMessage() . '<br>';
           }

           $email = NotificationEmail::asPublicEmail()
               ->to($recipient->getEmail())
               ->subject($this->getSubject())
               ->html($body);

           return new EmailMessage($email);
       }

       public function asSystemNotification(UserRecipientInterface $recipient, ?string $transport = null): ?SystemMessage
       {
           $message = new SystemMessage($recipient->getUser());
           $message->setContext([
               'icon' => Command::SUCCESS === $this->exitCode ? 'check-circle' : 'discard-circle',
               'subject' => $this->command->getName(),
               'content' => 'Number of errors: ' . count($this->exceptions),
           ]);

           return $message;
       }
   }
   ```

2. Assign channels subscribed to this notification in `config/packages/notifications.yaml`:

   ```yaml
   ibexa:
       system:
           default:
               notifier:
                   subscriptions:
                       # The configuration below is added to the `default` scope without overriding the one defined in ibexa.yaml
                       # Custom subscriptions:
                       Ibexa\OrderManagement\Notification\OrderStatusChange:
                           channels:
                               - chat
                       Ibexa\Payment\Notification\PaymentStatusChange:
                           channels:
                               - chat
                       Ibexa\Shipping\Notification\ShipmentStatusChange:
                           channels:
                               - chat
                       App\Notifications\CommandExecuted:
                           channels:
                               - ibexa
                               - email
   ```

3. Create a command sending a `CommandExecuted` notification at the end of execution: It randomly succeeds or fails to demonstrate how notifications can communicate different execution results. It could be declared as a service to set the list of recipients' logins (`$recipientLogins`) from a configuration file.

   ```php
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
   ```

When you execute this command, it fails randomly and notifies the Administrator user about the result.

![Ibexa notification example](https://doc.ibexa.co/en/5.0/users/img/notification-ibexa.png "Command notifications shown in the ibexa channel, the back office user notification menu")

### `ControllerFeedback` example

The following example shows a custom notification sent by a controller and displayed as a flash message on the corresponding page in the browser.

The following `ControllerFeedback` notification type is a class that only extends the base:

```php
<?php declare(strict_types=1);

namespace App\Notifications;

use Symfony\Component\Notifier\Notification\Notification;

class ControllerFeedback extends Notification
{
}
```

The `ControllerFeedback` notification is sent in a controller action:

```php
<?php declare(strict_types=1);

namespace App\Controller;

use App\Notifications\ControllerFeedback;
use Ibexa\Contracts\Notifications\Service\NotificationServiceInterface;
use Ibexa\Contracts\Notifications\Value\Notification\SymfonyNotificationAdapter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NotificationSenderController extends AbstractController
{
    public function __construct(
        private readonly NotificationServiceInterface $notificationService,
    ) {
    }

    #[Route('/notification-sender')]
    public function index(): Response
    {
        $this->notificationService->send(
            new SymfonyNotificationAdapter((new ControllerFeedback('Message sent from controller'))->emoji('👍')),
        );

        return $this->render('@ibexadesign/notification-sender-controller.html.twig');
    }
}
```

For the example, the notification is sent in a back office context for all editions and on the front end for Commerce edition. An empty template only extending the page layout is used for the demonstration.

`templates/themes/admin/notification-sender-controller.html.twig`:

```twig
{% extends '@ibexadesign/ui/layout.html.twig' %}
```

`templates/themes/storefront/notification-sender-controller.html.twig`:

```twig
{% extends '@ibexadesign/storefront/layout.html.twig' %}
```

In the back office, a notification sent as a flash message has the `ibexa-alert--notification` CSS class. This doesn't have a default style. For this example, the style is the same as an existing alert message type.

The `assets/scss/notifications.scss` declares the CSS class `ibexa-alert--notification` as being the same as the `ibexa-alert--info` CSS class

```scss
@use '@ibexa-admin-ui/src/bundle/Resources/public/scss/_alerts.scss' as *;

.ibexa-alert {
    &--notification {
        @extend .ibexa-alert--info;
    }
}
```

This `assets/scss/notifications.scss` is added to the Admin UI layout in `webpack.config.js`:

```javascript
const ibexaConfigManager = require('@ibexa/frontend-config/webpack-config/manager');
const getIbexaConfig = require('@ibexa/frontend-config/webpack-config/ibexa');
const ibexaConfig = getIbexaConfig();

ibexaConfigManager.add({
    ibexaConfig,
    entryName: 'ibexa-admin-ui-layout-css',
    newItems: [
        path.resolve(__dirname, './assets/scss/notifications.scss'),
    ],
});

module.exports = [ibexaConfig, ...customConfigs, projectConfig];
```

On the storefront, a notification sent as a flash message has the `ibexa-store-notification--notification` CSS class. This class already has a default style applied.

Subscribe to this new notification type in `config/packages/notifications.yaml`:

- In the `admin_group` scope with the `browser` channel
- For Commerce edition, in the `storefront_group` scope with the `browser` channel

```yaml
ibexa:
    system:
        # …
        admin_group:
            notifier:
                subscriptions:
                    # The configuration below is added to the `admin_group` scope without overriding the one defined in ibexa_admin_ui.yaml
                    # Custom subscriptions:
                    App\Notifications\CommandExecuted:
                        channels:
                            - ibexa
                            - email
                    App\Notifications\ControllerFeedback:
                        channels:
                            - browser
        storefront_group:
            notifier:
                subscriptions:
                    # The configuration defined in ibexa.yaml for `default` scope is repeated as the configuration below overrides it
                    Ibexa\Contracts\User\Notification\UserPasswordReset:
                        channels:
                            - email
                    Ibexa\Contracts\User\Notification\UserInvitation:
                        channels:
                            - email
                    Ibexa\Contracts\FormBuilder\Notifications\FormSubmitted:
                        channels:
                            - email
                    # Custom subscriptions:
                    Ibexa\OrderManagement\Notification\OrderStatusChange:
                        channels:
                            - chat
                    Ibexa\Payment\Notification\PaymentStatusChange:
                        channels:
                            - chat
                    Ibexa\Shipping\Notification\ShipmentStatusChange:
                        channels:
                            - chat
                    App\Notifications\CommandExecuted:
                        channels:
                            - ibexa
                            - email
                    App\Notifications\ControllerFeedback:
                        channels:
                            - browser
```

> **Note: Subscriptions forstorefront_group**
>
> Note that when introducing subscriptions configuration for the `storefront_group` scope that comes with Commerce edition, several subscriptions had to be copy-pasted into this SiteAccess group to have the same subscriptions as before when it was configured only by the `default` scope. For example, the subscriptions for the `site` SiteAccess belonging to this group can be checked with the following command during configuration:
>
> ```bash
> php bin/console ibexa:debug:config notifications.subscriptions --siteaccess=site
> ```

Visiting this controller's route in the back office (at `/admin/notification-sender`) triggers the notification as a flash message in the bottom-right corner:

![Notification in back office](https://doc.ibexa.co/en/5.0/users/img/notification-browser-admin.png "Controller message displayed as a flash message in the browser")

Visiting the controller's route in the default SiteAccess on Commerce edition (at `/notification-sender`) also triggers the notification as a flash message in the bottom-right corner:

![Notification in storefront](https://doc.ibexa.co/en/5.0/users/img/notification-browser-storefront.png "Controller message displayed as a flash message in the browser")

## Create custom channel

You may need to create new channels to subscribe to notifications and send them to new destinations. For example, you could create a new channel for Slack that takes more than one DSN for finer dispatching.

A channel is a service implementing `Symfony\Component\Notifier\Channel\ChannelInterface`, and tagged `notifier.channel` alongside a `channel` identifier.

The following example is a custom channel that sends notifications to the logger.

```php
<?php declare(strict_types=1);

namespace App\Notifier\Channel;

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
```

```yaml
services:
    App\Notifier\Channel\LogChannel:
        tags:
            - { name: 'notifier.channel', channel: 'log' }
```

Now, the [`CommandExecuted` notification](#commandexecuted-example) can be subscribed to the `log` channel:

```yaml
                    App\Notifications\CommandExecuted:
                        channels:
                            - ibexa
                            - email
                            - log
```

The log contains the notifications (in `var/log/dev.log` when run in the `dev` Symfony environment):

```console
% tail -Fn0 var/log/dev.log | grep --line-buffered CommandExecuted
[2026-03-26T01:01:23.888014+01:00] app.INFO: ✖app:send_notification {"class":"App\\Notifications\\CommandExecuted","importance":"high","content":""} []
[2026-03-27T01:02:54.123431+01:00] app.INFO: ✔app:send_notification {"class":"App\\Notifications\\CommandExecuted","importance":"low","content":""} []
```
