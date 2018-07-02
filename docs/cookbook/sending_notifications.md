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

To send a notification from PHP, inject the `NotificationHandlerInterface` into your class.

``` php
$this->notificationHandler->info('Notification text');
```

To have the notification translated, make use of the `TranslatorInterface`.
You need to provide the message strings in the translation files under the correct domain and key.

``` php
$this->notificationHandler->info(
    $this->translator->trans(
        /** @Desc("Notification text") */
        'example.notification.text',
        [],
        'domain'
    )
);
```

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

use eZ\Publish\API\Repository\Values\Notification\CreateStruct;

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
        return $this->twig->render('@FlexWorkflow/notification.html.twig', ['notification' => $notification]);
    }
    
    public function generateUrl(Notification $notification): ?string
    {
        if (array_key_exists('content_id', $notification->data)) {
            return $this->router->generate('ez_content_draft_edit', [
                 'contentId' => $notification->data['content_id'],
                 'versionNo' => $notification->data['version_number'],
                 'language' => $notification->data['language'],
            ]);
        }
        
        return null;
    }
}
```

Finally, you need to add an entry to `services.yml`:

``` yaml
AppBundle\Notification\MyRenderer:
    arguments:
        - '@twig'
        - '@router'
    tags:
        - { name: ezpublish.notification.renderer, alias: 'MyNotification:TypeName' }
```
