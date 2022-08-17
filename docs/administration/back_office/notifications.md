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
<?php

use Ibexa\Contracts\Core\Repository\NotificationService;
use Ibexa\Contracts\Core\Repository\Values\Notification\CreateStruct;

//..
/** @var NotificationService */
private $notificationService;

/**
* @param NotificationService $notificationService
*/
public function __construct( NotificationService $notificationService)
{
    $this->notificationService = $notificationService;
}

//...

$data = [
    'content_name' => $content->getName(),
    'content_id' => $content->id,
    'message' => 'Lorem ipsum dolor sit amet, consetetur ....'
];

$notification = new CreateStruct();
$notification->ownerId = $receiverId;
$notification->type = 'MyNotification:TypeName';
$notification->data = $data;

$this->notificationService->createNotification($notification);
```

To display the notification, write a renderer and tag it as a service.

The example below presents a renderer that uses Twig to render a view:

```php
<?php

declare(strict_types=1);

namespace App\Notification;

use Ibexa\Contracts\Core\Repository\Values\Notification\Notification;
use Ibexa\Core\Notification\Renderer\NotificationRenderer;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class MyRenderer implements NotificationRenderer
{
    protected $twig;
    protected $router;

    public function __construct(Environment $twig, RouterInterface $router)
    {
        $this->twig = $twig;
        $this->router = $router;
    }

    public function render(Notification $notification): string
    {
        return $this->twig->render('notification.html.twig', ['notification' => $notification]);
    }

    public function generateUrl(Notification $notification): ?string
    {
        if (array_key_exists('content_id', $notification->data)) {
            return $this->router->generate('ibexa.content.view', ['contentId' => $notification->data['content_id']]);
        }

        return null;
    }
}
```

You can build a content edit draft route like this:

```
return $this->router->generate('ez_content_draft_edit', [
    'contentId' => $contentInfo->id,
    'versionNo' => $contentInfo->currentVersionNo,
    'language' => $contentInfo->mainLanguageCode,
]);
```

You can add the template that is defined above in the `render()` method to one of your custom bundles:

```
{% extends '@ibexadesign/account/notifications/list_item.html.twig' %}

{% trans_default_domain 'custom_notification' %}

{% set wrapper_additional_classes = 'css-class-custom' %}

{% block icon %}
    <span class="type__icon">
        <svg class="ibexa-icon ibexa-icon--review">
            <use xlink:href="{{ asset('bundles/ibexaplatformicons/img/all-icons.svg') }}#notice"></use>
        </svg>
    </span>
{% endblock %}

{% block notification_type %}
    <span class="type__text">
        {{ 'Notice'|trans|desc('Notice') }}
    </span>
{% endblock %}

{% block message %}
    <td class="n-notifications-modal__description">
        <p class="description__title"><span class="description__title__item">{{ notification.data.content_name }}</p>
        <p class="description__text{% if notification.data.message|length > 50 %} description__text--ellipsis{% endif %}">{{ notification.data.message }}</p>
        <span class="description__read-more">{{ 'content.notice.read_more'|trans|desc('Read more &raquo;') }}</span>
    </td>
{% endblock %}

```


Finally, you need to add an entry to `config/services.yaml`:

``` yaml
services:
    _defaults:
        autowire: true
        autoconfigure: false
        public: false
        
    App\Notification\MyRenderer:
        tags:
            - { name: ibexa.notification.renderer, alias: MyNotification:TypeName }
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
