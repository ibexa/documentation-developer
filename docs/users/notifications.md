---
description: Notify users TODO.
month_change: true
---

# Notifications

the `ibexa/notifications` package offers an extension to the [Symfony notifier]([[= symfony_doc =]]/notifier.html) allowing to subscribe to notifications and sent them to information channels like email addresses, SMS, communication platforms, etc., including the [🔔 Back Office user profile notification](/administration/back_office/notifications.md#create-custom-notifications).

Those notifications must not be confused with the [notification bars](/administration/back_office/notifications.md) (sent with [`TranslatableNotificationHandlerInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-AdminUi-Notification-TranslatableNotificationHandlerInterface.html))
or the [🔔 user notifications](/administration/back_office/notifications.md#create-custom-notifications) (sent with [`Ibexa\Contracts\Core\Repository\NotificationService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html)).

TODO: Introduce the [`Ibexa\Contracts\Notifications\Service\NotificationServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Service-NotificationServiceInterface.html)

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

TODO: What about notifications outside the `Ibexa\Contracts` namespace??

* `Ibexa\Share\Notification\ContentEditInvitationNotification`
* `Ibexa\Share\Notification\ContentViewInvitationNotification`
* `Ibexa\Share\Notification\ExternalParticipantContentViewInvitationNotification`

Available notification channels:

```bash
php bin/console debug:container --tag=notifier.channel
```

For example, let's subscribe to Commerce activity with a Slack channel:

```bash
composer require symfony/slack-notifier
```

* `browser` - Notification as flash message TODO: Test from a controller to see if it works
* `chat` - Notification sent to a communication platform like Slack, Microsoft Teams, Google Chat, etc.
* `desktop` - Notification sent to JoliNotif TODO: Do we support this?
* `email` - Notification sent to email addresses
* `ibexa` - Notification sent to back office user profiles
* `push` - TODO
* `sms` - Notification sent to phone numbers

In a .env file, [set the DSN for the targetted Slack channel or user](https://github.com/symfony/slack-notifier?tab=readme-ov-file#dsn-example):

```dotenv
SLACK_DSN=slack://xoxb-token@default?channel=ibexa-notifications
```

``` yaml
[[= include_file('code_samples/user_management/notifications/config/packages/custom_notifications.yaml', 0, 18) =]]
```

## Create a notification class

A new notification class can be created to send a new type of message to a new set of channels.
It must extend `Symfony\Component\Notifier\Notification\Notification`
and optionally implements some interfaces depending on the channels it could be sent to.

- Some channels don't accept the notification if it doesn't implement its related notification interface.
- Some channels accept every notification and have a default behavior if the notification doesn't implement their related notification interface.

TODO: List what type of channel notification interfaces can be implemented
TODO: Namespaces, Ibexa custom vs Symfony native

| Channel | Notification interface                                                                                                                                    | ! | Description |
|:--------|:----------------------------------------------------------------------------------------------------------------------------------------------------------|---|:------------|
| `chat`  | `ChatNotificationInterface`                                                                                                                               |   | TODO        |
| `email` | `EmailNotificationInterface`                                                                                                                              | &#10004; | TODO        |
| `ibexa` | [`SystemNotificationInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-SystemNotification-SystemNotificationInterface.html) | &#10004; | TODO        |
| `sms`   | `SmsNotificationInterface`                                                                                                                                | &#10004; | TODO        |

TODO: About `ibexa` channel being the [🔔 user notification](/administration/back_office/notifications.md#create-custom-notifications)
https://github.com/ibexa/notifications/blob/v5.0.6/src/lib/SystemNotification/SystemNotificationChannel.php#L51

TODO: How to deal with channels not needing a user like `chat` + Slack channel?

TODO: About `SymfonyNotificationAdapter` and `SymfonyRecipientAdapter`

### Example

The following example is a command that sends a notification to users on several channels simultaneously.
it could be a scheduled task, a cronjob, warning users about its final result. 

First, a `CommandExecuted` notification type is created.
It is supported by two channels for the example but could be extended to more.

``` php
[[= include_file('code_samples/user_management/notifications/src/Notifications/CommandExecuted.php') =]]
```

The channels subscribing to this notification are set in `config/packages/ibexa.yaml`:

``` yaml
[[= include_file('code_samples/user_management/notifications/config/packages/custom_notifications.yaml', 5, 9) =]]                # …
[[= include_file('code_samples/user_management/notifications/config/packages/custom_notifications.yaml', 18) =]]
```

TODO: Explain the command

``` php
[[= include_file('code_samples/user_management/notifications/src/Command/NotificationSenderCommand.php') =]]
```

TODO: Screenshots

## Create a channel

A channel is a service implementing `Symfony\Component\Notifier\Channel\ChannelInterface`, and tagged `notifier.channel` alongside a `channel` shortname.

The following example is a custom channel that sends notifications to the logger.

``` php
[[= include_file('code_samples/user_management/notifications/src/Notifier/Channel/LogChannel.php') =]]
```

``` yaml
[[= include_file('code_samples/user_management/notifications/config/services.yaml') =]]
```
