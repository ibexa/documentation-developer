# Sending notifications

You can send two types on notifications to the users.

## Display notification bars

You can have your PHP code send notification that will be displayed as a message bar in the Back Office.
To do that, inject the `NotificationHandlerInterface` into your class.
You can use one of the four methods representing the following notification types: `info`, `success`, `warning` and `error`.

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

![Example of an info notification](img/notification2.png)

## Create custom notifications using the Flex Workflow mechanism

!!! enterprise

    You can send your own custom notifications to the user
    with the same mechanism that is used to send notification from Flex Workflow.

    To create a new notification you must emit the `NotificationSignal`,
    which will be caught by the `NotificationBundle`:

    ``` php
    $this->signalDispatcher->emit(new NotificationSignal([
        'ownerId' => $receiverId,  // User to be notified
        'type' => 'MyNotification:TypeName', // Notification type name
        'data' => $data, // Any data structure to be used by the notification (message etc.)
    ]));
    ```

    To display the notification, write a Renderer and tag it as a service.

    The example below presents a Renderer that uses Twig to render a view:

    ``` php
    <?php
    declare(strict_types=1);

    namespace AppBundle\Notification;

    use EzSystems\Notification\SPI\Renderer\NotificationRenderer;
    use EzSystems\Notification\SPI\Persistence\ValueObject\Notification;
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
            if (property_exists($notification->data, 'content_id')) {
                return $this->router->generate('ez_content_draft_edit', [
                    'contentId' => $notification->data->content_id,
                    'versionNo' => $notification->data->version_number,
                    'language' => $notification->data->language,
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
            - { name: ezstudio.notification.renderer, alias: 'MyNotification:TypeName' }
    ```
