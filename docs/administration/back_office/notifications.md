---
description: You can send notifications to users who work with the Back Office by using notification bars or notifications in the user menu.
---

# Notifications

You can send two types on notifications to the users.

[Notification bar](#notification-bars) is displayed in specific situations as a message bar appearing at the bottom of the page.
It appears to whoever is doing a specific operation in the Back Office.

![Example of an info notification](notification2.png "Example of the notification bar")

[Custom notifications](#create-custom-notifications) are sent to a specific user.
They will appear in their profile in the Back Office.

![Notification in profile](notification3.png)

## Notification bars

Notifications are displayed as a message bar in the Back Office.
There are four types of notifications: `info`, `success`, `warning` and `error`.

### Displaying notifications from PHP

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

### Displaying notifications from front end

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

## Create custom notifications

You can send your own custom notifications to the user which will be displayed in the user menu.

To create a new notification you must use the `createNotification(Ibexa\Contracts\Core\Repository\Values\Notification\CreateStruct $createStruct)` method from `Ibexa\Contracts\Core\Repository\NotificationService`.

Example:

```php
[[= include_file('code_samples/back_office/notifications/src/EventListener/ContentPublishEventListener.php') =]]
```

To display the notification, write a renderer and tag it as a service.

The example below presents a renderer that uses Twig to render a view:

```php
[[= include_file('code_samples/back_office/notifications/src/Notification/MyRenderer.php') =]]
```

You can add the template that is defined above in the `render()` method to one of your custom bundles:

```html+twig
[[= include_file('code_samples/back_office/notifications/templates/themes/admin/notification.html.twig') =]]
```

Finally, you need to add an entry to `config/services.yaml`:

``` yaml
[[= include_file('code_samples/back_office/notifications/config/custom_services.yaml') =]]
```

## Notification timeout

To define the timeout for hiding Back-Office notification bars, per notification type,
use the following configuration (times are provided in milliseconds):

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

The values shown above are the defaults. `0` means the notification does not hide automatically.
