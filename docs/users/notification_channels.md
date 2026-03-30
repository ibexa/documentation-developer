---
description: Notify users through several channels.
month_change: true
---

# Notification channels

the `ibexa/notifications` package offers an extension to the [Symfony notifier]([[= symfony_doc =]]/notifier.html)
allowing to subscribe to notifications and forward them to information channels like email addresses, SMS, communication platforms, etc.,
including the [Back Office user profile notification](notifications.md#create-custom-notifications).

Those notifications must not be confused with the [notification bars](notifications.md#notification-bars) (sent with [`TranslatableNotificationHandlerInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-AdminUi-Notification-TranslatableNotificationHandlerInterface.html))
or the [user notifications](notifications.md#create-custom-notifications) (sent with [core `NotificationService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html)).

The service implementing the [`Ibexa\Contracts\Notifications\Service\NotificationServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Service-NotificationServiceInterface.html)
sends notifications extending the `Symfony\Component\Notifier\Notification\Notification`.
Other services can have this notification service injected and send their own typed notifications.
Channel services implementing `Symfony\Component\Notifier\Channel\ChannelInterface` subscribe to a selections of notification types
and take some actions like, for example, to convey notifications to users through various transports.

## Subscribe to notifications

Some events send notifications you can subscribe to with one or more channels.

Available notifications:

* [`Ibexa\Contracts\FormBuilder\Notifications\FormSubmitted`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-FormBuilder-Notifications-FormSubmitted.html)
* [`Ibexa\Contracts\Notifications\SystemNotification\SystemNotification`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-SystemNotification-SystemNotification.html)
* [`Ibexa\Contracts\OrderManagement\Notification\OrderStatusChange`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-OrderManagement-Notification-OrderStatusChange.html)
* [`Ibexa\Contracts\Payment\Notification\PaymentStatusChange`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Payment-Notification-PaymentStatusChange.html)
* [`Ibexa\Contracts\Shipping\Notification\ShipmentStatusChange`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Shipping-Notification-ShipmentStatusChange.html)
* [`Ibexa\Contracts\User\Notification\UserInvitation`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-User-Notification-UserInvitation.html)
* [`Ibexa\Contracts\User\Notification\UserPasswordReset`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-User-Notification-UserPasswordReset.html)
* [`Ibexa\Contracts\User\Notification\UserRegister`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-User-Notification-UserRegister.html)
* `Ibexa\Share\Notification\ContentEditInvitationNotification`
* `Ibexa\Share\Notification\ContentViewInvitationNotification`
* `Ibexa\Share\Notification\ExternalParticipantContentViewInvitationNotification`

Available notification channels:

```bash
php bin/console debug:container --tag=notifier.channel
```

* `browser` - Notification forwarded as flash message
* [`chat`]([[= symfony_doc =]]/notifier.html#chat-channel) - Notification forwarded to a communication platform like Slack, Microsoft Teams, or Google Chat
* [`desktop`]([[= symfony_doc =]]/notifier.html#chat-channel) - Notification forwarded to desktop applications like JoliNotif
* `email` - Notification forwarded to email addresses
* `ibexa` - Notification forwarded to back office user profiles
* [`push`]([[= symfony_doc =]]/notifier.html#push-channel) - Notification forwarded to specific applications
* [`sms`]([[= symfony_doc =]]/notifier.html#sms-channel) - Notification forwarded to phone numbers

Some default subscriptions can be found in `config/packages/ibexa.yaml` and `config/packages/ibexa_admin_ui.yaml`.

!!! caution "Scopes may not merge as expected"

    Subscriptions defined for a scope may not merge with subscriptions from others scopes or from other files.
    For example, `default` scope might not be merged within a siteaccess group scope.
    To ensure you don't unsubscribe against your will,
    always use the following command to check subscriptions for a siteaccess before and after additions:

    ```bash
    php bin/console ibexa:debug:config notifications.subscriptions --siteaccess=<siteaccess>
    ```

### Subscription example

For example, let's subscribe to Commerce activity with a Slack channel.

Install the Slack Notifier package:

```bash
composer require symfony/slack-notifier
```

In a .env file, [set the DSN to target a Slack channel or a Slack user](https://github.com/symfony/slack-notifier?tab=readme-ov-file#dsn-example):

```dotenv
SLACK_DSN=slack://xoxb-token@default?channel=ibexa-notifications
```

Subscribe to notification types related to Commerce like order, payment, and shipment status changes.
For example, in a new `config/packages/notifications.yaml` file:

``` yaml hl_lines="12-20"
[[= include_file('code_samples/user_management/notifications/config/packages/notifications.yaml', 0, 20) =]]
```

## Create a notification class

A new notification class can be created to send a new type of message to a new set of channels.
It must extend `Symfony\Component\Notifier\Notification\Notification`
and optionally implements some interfaces depending on the channels it could be sent to.

- Some channels don't accept the notification if it doesn't implement its related notification interface. See the ⚠ column in the table below.
- Some channels accept every notification and have a default behavior if the notification doesn't implement their related notification interface.

| Channel   | Notification interface         | ⚠        |
|:----------|:-------------------------------|----------|
| `chat`    | `ChatNotificationInterface`    |          |
| `desktop` | `DesktopNotificationInterface` |          |
| `email`   | `EmailNotificationInterface`   | &#10004; |
| `ibexa`   | `SystemNotificationInterface`  | &#10004; |
| `push`    | `PushNotificationInterface`    |          |
| `sms`     | `SmsNotificationInterface`     | &#10004; |

Notice tha the [`SystemNotificationInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-SystemNotification-SystemNotificationInterface.html) is not part of Symfony and has its own namespace.

The `ibexa` channel send notifications to users through their profile menu, exactly as [user notification](notifications.md#create-custom-notifications).
The [`SystemNotificationChannel` uses the core `NotificationService`](https://github.com/ibexa/notifications/blob/v5.0.6/src/lib/SystemNotification/SystemNotificationChannel.php#L51) to do so.

Some channels don't need a recipient:

- `browser`: Always send a flash message to the current user
- `chat`: Always send message to the same connection resource

### Notification sending

In the [`Ibexa\Contracts\Notifications`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-notifications.html) namespace can be found everything needed to work with notifications.

The [`…\Service\NotificationServiceInterface::send()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Service-NotificationServiceInterface.html#method_send) expects two arguments:

- The first argument is an [`…\Value\NotificationInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Value-NotificationInterface.html).
  This interface is implemented by the [`…\Value\Notification\SymfonyNotificationAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Value-Notification-SymfonyNotificationAdapter.html)
  which allows to wrap any class extending `Symfony\Component\Notifier\Notification\Notification`.
- The optional second argument is an array of [`…\Value\RecipientInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Value-RecipientInterface.html).
  This interface is implemented by the [`…\Value\Recipent\SymfonyRecipientAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Value-Recipent-SymfonyRecipientAdapter.html)
  made to wrap `Symfony\Component\Notifier\Recipient\RecipientInterface`.
     - This Symfony interface is implemented by [`…\Value\Recipent\UserRecipient`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Value-Recipent-UserRecipient.html)
       which can wrap classes implementing the [`Ibexa\Contracts\Core\Repository\Values\User\UserReference` interaface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-User-UserReference.html)
         - The [`UserService` methods to load a user](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-UserService.html#method_loadUser) are returning objects implementing this `UserReference` interface.
         - The [`PermissionResolver::getCurrentUserReference()` method](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-PermissionResolver.html#method_getCurrentUserReference) is returning objects implementing this `UserReference` interface.

So, for example, to send a notification, you often as this kind of combo:

```php hl_lines="8-11"
use App\Notifications\MyNotification; // Extends Symfony\Component\Notifier\Notification\Notification
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Notifications\Service\NotificationServiceInterface;
use Ibexa\Contracts\Notifications\Value\Notification\SymfonyNotificationAdapter;
use Ibexa\Contracts\Notifications\Value\Recipent\SymfonyRecipientAdapter;
use Ibexa\Contracts\Notifications\Value\Recipent\UserRecipient;
//…
$this->notificationService->send(
    new SymfonyNotificationAdapter(new MyNotification($subject)),
    [new SymfonyRecipientAdapter(new UserRecipient($this->permissionResolver->getCurrentUserReference()))],
);
//…
```

### `CommandExecuted` example

The following example is a command that sends a notification to users on several channels simultaneously.
it could be a scheduled task, a cronjob, warning users about its final result. 

First, a `CommandExecuted` notification type is created.
It is supported by two channels for the example but could be extended to more.
As constructor arguments, an instance takes the command itself, the exit code of the run, and caught exceptions.

``` php
[[= include_file('code_samples/user_management/notifications/src/Notifications/CommandExecuted.php') =]]
```

The channels subscribing to this notification are set in `config/packages/notifications.yaml`:

``` yaml hl_lines="17-20"
[[= include_file('code_samples/user_management/notifications/config/packages/notifications.yaml', 4, 24) =]]
```

The example command sends a `CommandExecuted` notification at the end of what could be a regular execution.
It randomly succeeds or fails to show how the notification can be used to communicate different execution results.

``` php
[[= include_file('code_samples/user_management/notifications/src/Command/NotificationSenderCommand.php') =]]
```

If you execute this command, it will some time succeed, some time fails.

![Ibexa notification example](notification-ibexa.png "Command notifications shown in the `ibexa` channel, the back office user notification menu")

### `ControllerFeedback` example

The following example shows a custom notification sent by a controller and displayed as a flash message on the corresponding page in the browser.

The following `ControllerFeedback` notification type is just a class extending the base:

``` php
[[= include_file('code_samples/user_management/notifications/src/Notifications/ControllerFeedback.php') =]]
```

The `ControllerFeedback` notification is sent in a controller action:

``` php
[[= include_file('code_samples/user_management/notifications/src/Controller/NotificationSenderController.php') =]]
```

For the example, the notification is sent in a back office context for all editions and on the front end for Commerce edition.
An empty template only extending the pagelayout is used for the demonstration.

`templates/themes/admin/notification-sender-controller.html.twig`:
``` twig
[[= include_file('code_samples/user_management/notifications/templates/themes/admin/notification-sender-controller.html.twig') =]]
```

`templates/themes/storefront/notification-sender-controller.html.twig`:
``` twig
[[= include_file('code_samples/user_management/notifications/templates/themes/storefront/notification-sender-controller.html.twig') =]]
```

In the back office, a notification sent as a flash message has the `ibexa-alert--notification` CSS class.
This hasn't a default style.
For this example, the style will be the same as an existing alert message type.

The `assets/scss/notifications.scss` declare the CSS class `ibexa-alert--notification` as being the same as the `ibexa-alert--info` CSS class

``` scss
[[= include_file('code_samples/user_management/notifications/assets/scss/notifications.scss') =]]
```

This `assets/scss/notifications.scss` is added to the Admin UI layout in `webpack.config.js`:

``` javascript
[[= include_file('code_samples/user_management/notifications/webpack.config.js', 49) =]]
```

On the storefront, a notification sent as a flash message has the `ibexa-store-notification--notification` CSS class.
This class already has a default style.

Subscribe to this new notification type in `config/packages/notifications.yaml`:

- in the `admin_group` scope with the `browser` channel
- For Commerce edition, in the `storefront_group` scope with the `browser` channel

``` yaml hl_lines="13-15 43-45"
[[= include_file('code_samples/user_management/notifications/config/packages/notifications.yaml', 4, 6) =]]        # …
[[= include_file('code_samples/user_management/notifications/config/packages/notifications.yaml', 25, 34) =]][[= include_file('code_samples/user_management/notifications/config/packages/notifications.yaml', 35, 65) =]][[= include_file('code_samples/user_management/notifications/config/packages/notifications.yaml', 66) =]]
```

Reaching this controller in the back office (at `/admin/notification-sender`) triggers the notification as a flash message in the bottom-right corner:

![Browser back office notification example](notification-browser-admin.png "Controller message displayed as a flash message in the browser")

Reaching the controller in the default siteaccess on Commerce edition (at `/notification-sender`) also triggers the notification as a flash message in the bottom-right corner:

![Browser storefront notification example](notification-browser-storefront.png "Controller message displayed as a flash message in the browser")


## Create a custom channel

A channel is a service implementing `Symfony\Component\Notifier\Channel\ChannelInterface`, and tagged `notifier.channel` alongside a `channel` shortname.

The following example is a custom channel that sends notifications to the logger.

``` php
[[= include_file('code_samples/user_management/notifications/src/Notifier/Channel/LogChannel.php') =]]
```

``` yaml
[[= include_file('code_samples/user_management/notifications/config/services.yaml') =]]
```

Now, [`CommandExecuted` notification](#commandexecuted-example) can be subscribed to with the `log` channel:

``` yaml hl_lines="5"
[[= include_file('code_samples/user_management/notifications/config/packages/notifications.yaml', 20, 25) =]]
```

The log file contains the notifications:

```console
% tail -Fn0 var/log/dev.log | grep --line-buffered CommandExecuted
[2026-03-26T01:01:54.123431+01:00] app.INFO: ✔app:send_notification {"class":"App\\Notifications\\CommandExecuted","importance":"low","content":""} []
[2026-03-27T01:01:23.888014+01:00] app.INFO: ✖app:send_notification {"class":"App\\Notifications\\CommandExecuted","importance":"high","content":""} []
```
