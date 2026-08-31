---
description: Notify users through several channels.
month_change: false
---

# Notification channels

The `ibexa/notifications` package integrates the [Symfony Notifier]([[= symfony_doc =]]/notifier.html) with [[= product_name =]].
You can use it to create notifications and send them through various channels such as email, SMS, communication platforms,
and the [back office user notifications](notifications.md#user-notifications).

These notifications must not be confused with the [notification bars](notifications.md#notification-bars) or the [user notifications](notifications.md#user-notifications):

| Notification category                                      | Sent with                                                                                                                                                               | Description                                                                              |
|------------------------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------|------------------------------------------------------------------------------------------|
| [Notification bars](notifications.md#notification-bars)    | [`TranslatableNotificationHandlerInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-AdminUi-Notification-TranslatableNotificationHandlerInterface.html) | Rendered as a message bar in the bottom-right corner.                                    |
| [User notifications](notifications.md#user-notifications)  | [`NotificationService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html)                                                | Rendered as [back office notification]([[= user_doc =]]/getting_started/notifications/). |
| [Channel-based notifications](#subscribe-to-notifications) | [`NotificationServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Service-NotificationServiceInterface.html)                        | Rendering depends on the channel assigned to the notification type.                      |

Unlike notification bars and user notifications, channel-based notifications don't have a predefined channel.
You can configure how they are delivered to the user by using YAML configuration.
Several channels are provided, and you can create your own.

The [`Ibexa\Contracts\Notifications\Service\NotificationServiceInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Service-NotificationServiceInterface.html)
sends notifications, objects extending the `Symfony\Component\Notifier\Notification\Notification` class.
You can inject this notification service into your code to send the built-in or custom notification types.
Channel services implementing `Symfony\Component\Notifier\Channel\ChannelInterface` subscribe to a selection of notification types
and deliver notifications to users through various transports.

## Subscribe to notifications

Some events generate notifications that you can deliver to the users through one or more channels.

### Available notification types

Several built-in notification types are available.
They are sent by various notifiers like event subscribers, controllers or form processors.

| Notification type                                                                                                                                                                                          | Sent                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   | Default recipients                                                       |
|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|--------------------------------------------------------------------------|
| `Ibexa\AdminUi\Notifier\Notification\UserInvitation`                                                                                                                                                       | by `Ibexa\AdminUi\Notifier\UserInvitation` service implementing [`Ibexa\Contracts\User\Invitation\InvitationSender`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-User-Invitation-InvitationSender.html)                                                                                                                                                                                                                                                                                     | Given email address                                                      |
| `Ibexa\AdminUi\Notifier\Notification\UserPasswordReset`                                                                                                                                                    | by `Ibexa\AdminUi\Notifier\PasswordReset` service implementing [`Ibexa\Contracts\User\PasswordReset\NotifierInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-User-PasswordReset-NotifierInterface.html)                                                                                                                                                                                                                                                                              | Given email address                                                      |
| [`Ibexa\Contracts\FormBuilder\Notifications\FormSubmitted`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-FormBuilder-Notifications-FormSubmitted.html)                                           | on `Ibexa\Core\MVC\Symfony\MVCEvents::PRE_CONTENT_VIEW` (`ezpublish.pre_content_view`) when the content item has a form field through an `Ibexa\FormBuilder\FormSubmission\Notification\NotificationSenderInterface` implementation                                                                                                                                                                                                                                                                    | [Form submit email notification field](customize_email_notifications.md) |
| [`Ibexa\Contracts\Notifications\SystemNotification\SystemNotificationInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-SystemNotification-SystemNotificationInterface.html) | -                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                      | -                                                                        |
| [`Ibexa\Contracts\OrderManagement\Notification\OrderStatusChange`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-OrderManagement-Notification-OrderStatusChange.html)                             | on [`Ibexa\Contracts\OrderManagement\Event\CreateOrderEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-OrderManagement-Event-CreateOrderEvent.html), <br>and on [`Symfony\Component\Workflow\WorkflowEvents::ENTERED` (`workflow.entered`)]([[= symfony_doc =]]/workflow.html#using-events) when the subject is a [`Ibexa\Contracts\OrderManagement\Value\Order\OrderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-OrderManagement-Value-Order-OrderInterface.html) | Order owner                                                              |
| [`Ibexa\Contracts\Payment\Notification\PaymentStatusChange`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Payment-Notification-PaymentStatusChange.html)                                         | on `Symfony\Component\Workflow\WorkflowEvents::ENTERED` when the subject is a [`Ibexa\Contracts\Payment\Payment\PaymentInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Payment-Payment-PaymentInterface.html)                                                                                                                                                                                                                                                                       | Order owner                                                              |
| [`Ibexa\Contracts\Shipping\Notification\ShipmentStatusChange`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Shipping-Notification-ShipmentStatusChange.html)                                     | on `Symfony\Component\Workflow\WorkflowEvents::ENTERED` when the subject is a [`Ibexa\Contracts\Shipping\Shipment\ShipmentInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Shipping-Shipment-ShipmentInterface.html)                                                                                                                                                                                                                                                                 | Order owner                                                              |
| [`Ibexa\Contracts\User\Notification\UserInvitation`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-User-Notification-UserInvitation.html)                                                         | by `Ibexa\User\Invitation\MailSender` service implementing [`Ibexa\Contracts\User\Invitation\InvitationSender`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-User-Invitation-InvitationSender.html)                                                                                                                                                                                                                                                                                          | Given email address                                                      |
| [`Ibexa\Contracts\User\Notification\UserPasswordReset`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-User-Notification-UserPasswordReset.html)                                                   | by `Ibexa\User\PasswordReset\Notifier` service implementing [`Ibexa\Contracts\User\PasswordReset\NotifierInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-User-PasswordReset-NotifierInterface.html)                                                                                                                                                                                                                                                                                 | Given email address                                                      |
| [`Ibexa\Contracts\User\Notification\UserRegister`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-User-Notification-UserRegister.html)                                                             | by `Ibexa\User\Form\Processor\UserRegisterFormProcessor` on `Ibexa\User\Form\UserFormEvents::USER_REGISTER` (`user.edit.register`)                                                                                                                                                                                                                                                                                                                                                                     | Registered user                                                          |
| `Ibexa\Share\Notification\ContentEditInvitationNotification`<br>(alias `ibexa_content_edit_invitation`)                                                                                                    | on [`Ibexa\Contracts\Collaboration\Invitation\Event\CreateInvitationEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-CreateInvitationEvent.html) through a [`Ibexa\Contracts\Collaboration\Notification\NotificationFactoryInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Notification-NotificationFactoryInterface.html)                                                                                               | Given users                                                              |
| `Ibexa\Share\Notification\ContentViewInvitationNotification`<br>(alias `ibexa_content_view_invitation`)                                                                                                    | on [`Ibexa\Contracts\Collaboration\Invitation\Event\CreateInvitationEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-CreateInvitationEvent.html) through a [`Ibexa\Contracts\Collaboration\Notification\NotificationFactoryInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Notification-NotificationFactoryInterface.html)                                                                                               | Given users                                                              |
| `Ibexa\Share\Notification\ExternalParticipantContentViewInvitationNotification`<br>(alias `ibexa_external_participant_content_view_invitation`)                                                            | on [`Ibexa\Contracts\Collaboration\Invitation\Event\CreateInvitationEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Invitation-Event-CreateInvitationEvent.html) through a [`Ibexa\Contracts\Collaboration\Notification\NotificationFactoryInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-Notification-NotificationFactoryInterface.html)                                                                                               | Given email addresses                                                    |

Notice that `Ibexa\AdminUi\Notifier\Notification\UserInvitation` are sent by the back office and don't implement `Ibexa\Contracts\User\Notification\UserInvitation` which is made for front end users.
Same for the two `UserPasswordReset` in distinct namespaces.

### Available notification channels

You can list the notification channel services with the following command:

```bash
php bin/console debug:container --tag=notifier.channel
```

- `actito` - Notification forwarded as [transactional email](transactional_emails.md)
- `browser` - Notification forwarded as [flash message]([[= symfony_doc =]]/session.html#flash-messages)
- [`chat`]([[= symfony_doc =]]/notifier.html#chat-channel) - Notification forwarded to a communication platform like Slack, Microsoft Teams, or Google Chat
- [`desktop`]([[= symfony_doc =]]/notifier.html#desktop-channel) - Notification forwarded to desktop applications like JoliNotif
- [`email`]([[= symfony_doc =]]/notifier.html#email-channel) - Notification forwarded to email addresses
- `ibexa` - Notification forwarded as [back office user notifications](notifications.md#user-notifications)
- [`push`]([[= symfony_doc =]]/notifier.html#push-channel) - Notification forwarded to specific applications
- [`sms`]([[= symfony_doc =]]/notifier.html#sms-channel) - Notification forwarded to phone numbers

### Subscriptions configuration

You can find the default configuration in `config/packages/ibexa.yaml` and `config/packages/ibexa_admin_ui.yaml`.
You can modify it to define your own subscriptions.
This page contains several examples of subscriptions configuration.

!!! caution "Scopes may not merge as expected"

    Subscriptions defined for a scope may not merge with subscriptions from other scopes or from other files.
    For example, `default` scope might not be merged within a siteaccess group scope.
    To ensure you don't unsubscribe channels by mistake,
    always use the following command to check subscriptions for a siteaccess before and after any changes:

    ```bash
    php bin/console ibexa:debug:config notifications.subscriptions --siteaccess=<siteaccess>
    ```

    For example, the following command returns the subscription for the `admin` siteaccess.
    You should see subscriptions to handle back office password reset and user invitation, and the share invitations through, at least, `email`.

    ```bash
    php bin/console ibexa:debug:config notifications.subscriptions --siteaccess=admin --json | jq
    ```
    ```json
    {
      "ibexa_content_edit_invitation": {
        "channels": [
          "ibexa",
          "email"
        ]
      },
      "ibexa_content_view_invitation": {
        "channels": [
          "ibexa",
          "email"
        ]
      },
      "ibexa_external_participant_content_view_invitation": {
        "channels": [
          "email"
        ]
      },
      "Ibexa\\AdminUi\\Notifier\\Notification\\UserPasswordReset": {
        "channels": [
          "email"
        ]
      },
      "Ibexa\\AdminUi\\Notifier\\Notification\\UserInvitation": {
        "channels": [
          "email"
        ]
      },
      "Ibexa\\Contracts\\FormBuilder\\Notifications\\FormSubmitted": {
        "channels": [
          "email"
        ]
      }
    }
    ```

    While, the following command return the subscribtions for the default siteaccess.
    On a fresh installation, it returns the subscriptions of the `site` siteaccess.

    ```bash
    php bin/console ibexa:debug:config notifications.subscriptions --json | jq
    ```
    ```json
    {
      "Ibexa\\Contracts\\User\\Notification\\UserPasswordReset": {
        "channels": [
          "email"
        ]
      },
      "Ibexa\\Contracts\\User\\Notification\\UserInvitation": {
        "channels": [
          "email"
        ]
      },
      "Ibexa\\Contracts\\FormBuilder\\Notifications\\FormSubmitted": {
        "channels": [
          "email"
        ]
      }
    }
    ```

#### Subscription example

The following example shows how you can deliver notifications about Commerce-related activities through Slack:

1. Install the Slack Notifier package:

    ```bash
    composer require symfony/slack-notifier
    ```

2. In a .env file, [set the DSN to target a Slack channel or a Slack user](https://github.com/symfony/slack-notifier?tab=readme-ov-file#dsn-example):

    ```dotenv
    SLACK_DSN=slack://xoxb-token@default?channel=ibexa-notifications
    ```

3. Subscribe to notification types related to Commerce, such as order, payment, and shipment status changes.
   For example, define the following configuration in a new `config/packages/notifications.yaml` file:

    ``` yaml hl_lines="12-20"
    [[= include_code('code_samples/api/notifications/config/packages/notifications.yaml', 1, 20, indent_level=1) =]]
    ```

## Create notification class

You can define a new notification type and assign a new set of channels to it, customizing how it's delivered.
It must extend the `Symfony\Component\Notifier\Notification\Notification` class
and can optionally implement interfaces required by specific channels.

- Some channels don't accept the notification if it doesn't implement their specific notification interface.
  These interfaces come with a method to specifically format the notification for the channel.
- Some channels accept every notification and have a default formatting if the notification doesn't implement their specific notification interface.

| Channel   | Specific notification interface                                                                                                                                                                                         | Accepts any notification object |
|:----------|:------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|---------------------------------|
| `actito`  | `Symfony\Component\Notifier\Notification\EmailNotificationInterface`                                                                                                                                                    | **No**                          |
| `chat`    | `Symfony\Component\Notifier\Notification\ChatNotificationInterface`                                                                                                                                                     | Yes                             |
| `desktop` | `Symfony\Component\Notifier\Notification\DesktopNotificationInterface`                                                                                                                                                  | Yes                             |
| `email`   | `Symfony\Component\Notifier\Notification\EmailNotificationInterface`                                                                                                                                                    | **No**                          |
| `ibexa`   | <nobr>[`Ibexa\Contracts\Notifications\SystemNotification\SystemNotificationInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-SystemNotification-SystemNotificationInterface.html)</nobr> | **No**                          |
| `push`    | `Symfony\Component\Notifier\Notification\PushNotificationInterface`                                                                                                                                                     | Yes                             |
| `sms`     | `Symfony\Component\Notifier\Notification\SmsNotificationInterface`                                                                                                                                                      | **No**                          |

The `ibexa` channel sends notifications to users through their profile menu, exactly as [user notifications](notifications.md#user-notifications).
The [`SystemNotificationChannel` uses the core `NotificationService`](https://github.com/ibexa/notifications/blob/v5.0.7/src/lib/SystemNotification/SystemNotificationChannel.php#L51) to do so.

Some channels don't need a recipient:

- `browser`: Always sends a flash message to the current user
- `chat`: Always sends a message to the same connection resource

### Notification sending

Use the objects from the [`Ibexa\Contracts\Notifications`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-notifications.html) namespace to work with notifications.

The [`…\Service\NotificationServiceInterface::send()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Service-NotificationServiceInterface.html#method_send) expects two arguments:

- The first argument is an [`…\Value\NotificationInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Value-NotificationInterface.html).
  This interface is implemented by the [`…\Value\Notification\SymfonyNotificationAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Value-Notification-SymfonyNotificationAdapter.html)
  which allows you to wrap any class extending `Symfony\Component\Notifier\Notification\Notification`.
- The optional second argument is an array of [`…\Value\RecipientInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Value-RecipientInterface.html).
  This interface is implemented by the [`…\Value\Recipent\SymfonyRecipientAdapter`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Value-Recipent-SymfonyRecipientAdapter.html)
  used to wrap `Symfony\Component\Notifier\Recipient\RecipientInterface`.
    - This Symfony interface is implemented by [`…\Value\Recipent\UserRecipient`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Value-Recipent-UserRecipient.html)
       which can wrap classes implementing the [`Ibexa\Contracts\Core\Repository\Values\User\UserReference` interface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-User-UserReference.html),
        - The [`UserService` methods to load a user](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-UserService.html#method_loadUser) are returning objects implementing this `UserReference` interface.
        - The [`PermissionResolver::getCurrentUserReference()` method](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-PermissionResolver.html#method_getCurrentUserReference) is returning objects implementing this `UserReference` interface.

For example, to send a notification, you often use a combination like the following:

``` php hl_lines="11-14"
[[= include_code('code_samples/api/notifications/notification_send.php', 2) =]]
```

### `CommandExecuted` example

The following example is a command that sends a notification to users on several channels simultaneously.
This example could be a scheduled task or cron job that warns users about its result.

1. First, create a `CommandExecuted` notification type.
   It supports two channels (`ibexa`, `email`), but could be extended to support more.
   As constructor arguments, an instance takes the command itself, the exit code of the run, and any caught exceptions.

    ``` php
    [[= include_code('code_samples/api/notifications/src/Notifications/CommandExecuted.php', indent_level=1) =]]
    ```

2. Assign channels subscribed to this notification in `config/packages/notifications.yaml`:

    ``` yaml hl_lines="17-20"
    [[= include_code('code_samples/api/notifications/config/packages/notifications.yaml', 5, 24, indent_level=1) =]]
    ```

3. Create a command sending a `CommandExecuted` notification at the end of execution:
   It randomly succeeds or fails to demonstrate how notifications can communicate different execution results.
   It could be declared as a service to set the list of recipients' logins (`$recipientLogins`) from a configuration file.

    ``` php
    [[= include_code('code_samples/api/notifications/src/Command/NotificationSenderCommand.php', indent_level=1) =]]
    ```

When you execute this command, it fails randomly and notifies the Administrator user about the result.

![Ibexa notification example](notification-ibexa.png "Command notifications shown in the `ibexa` channel, the back office user notification menu")

### `ControllerFeedback` example

The following example shows a custom notification sent by a controller and displayed as a flash message on the corresponding page in the browser.

The following `ControllerFeedback` notification type is a class that only extends the base:

``` php
[[= include_code('code_samples/api/notifications/src/Notifications/ControllerFeedback.php') =]]
```

The `ControllerFeedback` notification is sent in a controller action:

``` php
[[= include_code('code_samples/api/notifications/src/Controller/NotificationSenderController.php') =]]
```

For the example, the notification is sent in a back office context for all editions and on the front end for Commerce edition.
An empty template only extending the page layout is used for the demonstration.

`templates/themes/admin/notification-sender-controller.html.twig`:

``` twig
[[= include_code('code_samples/api/notifications/templates/themes/admin/notification-sender-controller.html.twig') =]]
```

`templates/themes/storefront/notification-sender-controller.html.twig`:

``` twig
[[= include_code('code_samples/api/notifications/templates/themes/storefront/notification-sender-controller.html.twig') =]]
```

In the back office, a notification sent as a flash message has the `ibexa-alert--notification` CSS class.
This doesn't have a default style.
For this example, the style is the same as an existing alert message type.

The `assets/scss/notifications.scss` declares the CSS class `ibexa-alert--notification` as being the same as the `ibexa-alert--info` CSS class

``` scss
[[= include_code('code_samples/api/notifications/assets/scss/notifications.scss') =]]
```

This `assets/scss/notifications.scss` is added to the Admin UI layout in `webpack.config.js`:

``` javascript
[[= include_code('code_samples/api/notifications/webpack.config.js', 50) =]]
```

On the storefront, a notification sent as a flash message has the `ibexa-store-notification--notification` CSS class.
This class already has a default style applied.

Subscribe to this new notification type in `config/packages/notifications.yaml`:

- In the `admin_group` scope with the `browser` channel
- For Commerce edition, in the `storefront_group` scope with the `browser` channel

``` yaml hl_lines="13-15 43-45"
[[= include_code('code_samples/api/notifications/config/packages/notifications.yaml', 5, 6) =]]
        # …
[[= include_code('code_samples/api/notifications/config/packages/notifications.yaml', 26, 34) =]]
[[= include_code('code_samples/api/notifications/config/packages/notifications.yaml', 36, 65) =]]
[[= include_code('code_samples/api/notifications/config/packages/notifications.yaml', 67) =]]
```

!!! note "Subscriptions for `storefront_group`"

    Note that when introducing subscriptions configuration for the `storefront_group` scope that comes with Commerce edition,
    several subscriptions had to be copy-pasted into this SiteAccess group to have the same subscriptions as before
    when it was configured only by the `default` scope.
    For example, the subscriptions for the `site` SiteAccess belonging to this group
    can be checked with the following command during configuration:
    ```bash
    php bin/console ibexa:debug:config notifications.subscriptions --siteaccess=site
    ```

Visiting this controller's route in the back office (at `/admin/notification-sender`) triggers the notification as a flash message in the bottom-right corner:

![Notification in back office](notification-browser-admin.png "Controller message displayed as a flash message in the browser")

Visiting the controller's route in the default SiteAccess on Commerce edition (at `/notification-sender`) also triggers the notification as a flash message in the bottom-right corner:

![Notification in storefront](notification-browser-storefront.png "Controller message displayed as a flash message in the browser")

## Create custom channel

You may need to create new channels to subscribe to notifications and send them to new destinations.
For example, you could create a new channel for Slack that takes more than one DSN for finer dispatching.

A channel is a service implementing `Symfony\Component\Notifier\Channel\ChannelInterface`, and tagged `notifier.channel` alongside a `channel` identifier.

The following example is a custom channel that sends notifications to the logger.

``` php
[[= include_code('code_samples/api/notifications/src/Notifier/Channel/LogChannel.php') =]]
```

``` yaml
[[= include_code('code_samples/api/notifications/config/services.yaml') =]]
```

Now, the [`CommandExecuted` notification](#commandexecuted-example) can be subscribed to the `log` channel:

``` yaml hl_lines="5"
[[= include_code('code_samples/api/notifications/config/packages/notifications.yaml', 21, 25) =]]
```

The log contains the notifications
(in `var/log/dev.log` when run in the `dev` Symfony environment):

```console
% tail -Fn0 var/log/dev.log | grep --line-buffered CommandExecuted
[2026-03-26T01:01:23.888014+01:00] app.INFO: ✖app:send_notification {"class":"App\\Notifications\\CommandExecuted","importance":"high","content":""} []
[2026-03-27T01:02:54.123431+01:00] app.INFO: ✔app:send_notification {"class":"App\\Notifications\\CommandExecuted","importance":"low","content":""} []
```
