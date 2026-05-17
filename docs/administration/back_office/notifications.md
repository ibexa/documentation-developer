---
description: You can send notifications to users who work with the back office by using notification bars or notifications in the user menu.
month_change: false
---

# Notifications

You can send two types of notifications to the users:

- [Notification bar](#notification-bars) is displayed in specific situations as a message bar appearing at the bottom of the page.
  It appears to whoever is doing a specific operation in the back office.
- [User notifications](#user-notifications) are sent to a specific user.
  They appear in their profile in the back office.

To send notification to other channels, see [Notification channels](notification_channels.md).

## Notification bars

Notifications are displayed as a message bar in the back office.
There are four types of notifications: `info`, `success`, `warning` and `error`.

![Screenshot of a notification bar](notification2.png "Example of notification bar")

### Display notification bar from PHP

To send a notification from PHP, inject the `TranslatableNotificationHandlerInterface` into your class.

``` php
$this->notificationHandler->info(
    /** @Desc("Notification text") */
    'example.notification.text',
    [],
    'domain'
);
```

To have the notification translated, provide the message strings in the translation files under the correct domain and key.

### Display notification bar from front end

To create a notification from the front end (in this example, of type `info`), use the following code:

``` js
const eventInfo = new CustomEvent('ibexa-notify', {
    detail: {
        label: 'info',
        message: 'Notification text'
    }
});
```

Dispatch the event with `document.body.dispatchEvent(eventInfo);`.

### Notification bar timeout

To define the timeout for hiding Back-Office notification bars, per notification type, use the `ibexa.system.<scope>.notifications.<notification_type>.timeout` [configuration key](configuration.md#configuration-files):

``` yaml
ibexa:
    system:
        admin:
            notifications:
                error:
                    timeout: 0
                warning:
                    timeout: 0
                success:
                    timeout: 5000
                info:
                    timeout: 0
```

The values shown above are the defaults.
`0` means the notification doesn't hide automatically.

### `browser` notification channel

To send notification bars, you can also subscribe to a notification with the `browser` channel.

For more information, see [Notifications channels](notification_channels.md).

## User notifications

You can send notifications to users which are displayed in the user menu.

![Screenshot of the user menu with an highlight on the bell icon](notification3.png "Profile notification bell menu")

### Create a custom user notification

To create a new notification you can use the [`NotificationService::createNotification(CreateStruct $createStruct)` method](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html#method_createNotification)
like in the example below:

```php
[[= include_code('code_samples/back_office/notifications/src/EventListener/ContentPublishEventListener.php') =]]
```

A new type of user notification is created: `ContentPublished`.

### Display a custom user notification

To display a user notification, write a renderer and tag it as a service.

The example below presents a renderer that uses Twig to render a view:

```php
[[= include_code('code_samples/back_office/notifications/src/Notification/MyRenderer.php') =]]
```

You can add the template that is used in the `MyRenderer::render()` method to the `admin` theme
as `templates/themes/admin/notification.html.twig`:

```html+twig
[[= include_file('code_samples/back_office/notifications/templates/themes/admin/notification.html.twig') =]]
```

Finally, you need to add an entry to `config/services.yaml`
to tag and bound the renderer service to the `ContentPublished` type:

``` yaml
[[= include_file('code_samples/back_office/notifications/config/custom_services.yaml') =]]
```

### Display notification list

To display a list of notifications, expand the above renderer.

The example below presents a modified renderer that uses Twig to render a list view:

```php
[[= include_code('code_samples/back_office/notifications/src/Notification/ListRenderer.php') =]]
```

### `ibexa` notification channel

To send user notifications, you can also subscribe to a notification with the `ibexa` channel.

For more information, see [Notifications channels](notification_channels.md).
