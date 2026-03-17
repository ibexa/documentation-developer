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

For example, let's subscribe to Commerce activity with a Slack channel:

``` yaml
[[= include_file('code_samples/user_management/notifications/config/packages/custom_notifications.yaml', 0, 18) =]]
```

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
