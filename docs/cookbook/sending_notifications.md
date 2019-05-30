# Sending notifications

You can send two types on notifications to the users.

[Notification bars](#display-notification-bars) are displayed in specific situations as a message bar.
They will be shown to whoever is doing a specific operation in the Back Office.

![Example of an info notification](img/notification2.png)

[Flex Workflow notifications](#create-custom-notifications-using-the-flex-workflow-mechanism) are sent to a specific user.
They will appear in their profile in the Back Office.

![Notification in profile](img/notification3.png)

## Display notification bars

Notifications are displayed as a message bar in the Back Office.
There are four types of notifications: `info`, `success`, `warning` and `error`.

### Display notifications from PHP

To send a notification from PHP, inject the `TranslatableNotificationHandlerInterface` into your class.

``` php
$this->notificationHandler->info(
    /** @Desc("Notification text") */
    'example.notification.text',
    [],
    'domain'
);
```

To have the notification translated, you need to provide the message strings
in the translation files under the correct domain and key.

### Display notifications from front end

To create a notification from the front end (in this example, of type `info`), use the following code:

``` js
const eventInfo = new CustomEvent('ez-notify', {
    detail: {
        label: 'info',
        message: 'Notification text'
    }
});
```

Dispatch the event with `document.body.dispatchEvent(eventInfo);`

## Create custom notifications using the Flex Workflow mechanism

You can send your own custom notifications to the user with the same mechanism that is used to send notification from Flex Workflow.

To create a new notification you must use `createNotification(eZ\Publish\API\Repository\Values\Notification\CreateStruct $createStruct)` method from `\eZ\Publish\API\Repository\NotificationService`.

Example:

```php
<?php
use eZ\Publish\API\Repository\NotificationService;
use eZ\Publish\API\Repository\Values\Notification\CreateStruct;

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

To display the notification, write a Renderer and tag it as a service.

The example below presents a Renderer that uses Twig to render a view:

```php
<?php

declare(strict_types=1);

namespace AppBundle\Notification;

use eZ\Publish\API\Repository\Values\Notification\Notification;
use eZ\Publish\Core\Notification\Renderer\NotificationRenderer;
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
        return $this->twig->render('AppBundle::notification.html.twig', ['notification' => $notification]);
    }

    public function generateUrl(Notification $notification): ?string
    {
        if (array_key_exists('content_id', $notification->data)) {
            return $this->router->generate('_ez_content_view', ['contentId' => $notification->data['content_id']]);
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

You can add the template that is defined above in the `render()` method to one of your custom bundles.
In this example use the `AppBundle`:

```
{% extends '@EzPlatformAdminUi/notifications/notification_row.html.twig' %}

{% trans_default_domain 'custom_notification' %}

{% set wrapper_additional_classes = 'css-class-custom' %}

{% block icon %}
    <span class="type__icon">
        <svg class="ez-icon ez-icon--review">
            <use xlink:href="{{ asset('bundles/ezplatformadminui/img/ez-icons.svg') }}#notice"></use>
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


Finally, you need to add an entry to `services.yml`:

``` yaml
services:
    _defaults:
        autowire: true
        autoconfigure: false
        public: false
    AppBundle\Notification\MyRenderer:
    tags:
        - { name: ezpublish.notification.renderer, alias: MyNotification:TypeName }
```
