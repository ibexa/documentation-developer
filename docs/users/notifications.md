---
description: Notify users TODO.
month_change: true
---

# Notifications

TODO: [notification bar](/administration/back_office/notifications.md) VS [🔔 user notification](/administration/back_office/notifications.md#create-custom-notifications) VS this

TODO:
[Ibexa\Contracts\Core\Repository\NotificationService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html)
versus
[Ibexa\Contracts\Notifications\Service\NotificationServiceInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Service-NotificationServiceInterface.html)

Based on [Symfony notifier]([[= symfony_doc =]]/notifier.html)

Use an existing notification class

TODO: List available classes

Create a notification class

TODO: List what type of channel notification interfaces can be implemented
TODO: Namespaces, Ibexa custom vs Symfony native

| Channel | Notification interface                                                                                                                                    | Description |
|:--------|:----------------------------------------------------------------------------------------------------------------------------------------------------------|:------------|
| `ibexa` | [`SystemNotificationInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-SystemNotification-SystemNotificationInterface.html) | TODO        |
| `email` | `EmailNotificationInterface`                                                                                                                              | TODO        |
| `chat`  | `ChatNotificationInterface`                                                                                                                               | TODO        |
| `sms`   | `SmsNotificationInterface`                                                                                                                                | TODO        |

TODO: About `ibexa` channel being the [🔔 user notification](/administration/back_office/notifications.md#create-custom-notifications)
https://github.com/ibexa/notifications/blob/v5.0.6/src/lib/SystemNotification/SystemNotificationChannel.php#L51

TODO: About `SymfonyNotificationAdapter` and `SymfonyRecipientAdapter`

### Example

The following example is a command that sends a notification to users on several channels simultaneously.
it could be a scheduled task, a cronjob, warning users about its final result. 

First, a `CommandExecuted` notification type is created.
It is supported by two channels for the example but could be extended to more.

``` php
[[= include_file('code_samples/user_management/notifications/src/Notifications/CommandExecuted.php') =]]
```

The channels subscribing to this notification are set in `config/packages/ibexa.yaml` below the default ones:

``` yaml
[[= include_file('code_samples/user_management/notifications/config/packages/ibexa.yaml') =]]
```

TODO: Explain the command

``` php
[[= include_file('code_samples/user_management/notifications/src/Command/NotificationSenderCommand.php') =]]
```
