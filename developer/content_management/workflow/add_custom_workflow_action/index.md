# Add custom workflow action

Add custom actions that are performed during specific workflow transitions.

Built-in workflow actions enable you to [automatically publish a content item](../workflow/index.md#content-publishing) or to [send a notification to reviewers](../workflow/index.md#notifications).

You can also create custom actions that are called when content reaches a specific stage or goes through a transition in a workflow.

The following example shows how to configure two custom actions that send customized notifications.

## Configure custom action

Configure the first custom action under the `ibexa.system.<scope>.workflows` [configuration key](../../../administration/configuration/configuration/index.md#configuration-files):

```yaml
ibexa:
    system:
        default:
            workflows:
                custom_workflow:
                    transitions:
                        to_legal:
                            from: [draft]
                            to: [legal]
                            label: To legal
                            color: '#8888ba'
                            icon: '/bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#alert-error'
                            reviewers:
                                required: true
                                user_group: 13
                            actions:
                                legal_transition_action:
                                    data:
                                        message: "Sent to the legal department"
```

The configuration indicates the name of the custom action (`legal_transition_action`). `data` contains additional data that is passed to the action. In this case, it's a message to display.

## Create event listener

To define what the action does, create an event listener `src/EventListener/LegalTransitionListener.php`:

```php
<?php

declare(strict_types=1);

namespace App\EventListener;

use Ibexa\Contracts\AdminUi\Notification\TranslatableNotificationHandlerInterface as NotificationInterface;
use Ibexa\Contracts\Workflow\Event\Action\AbstractTransitionWorkflowActionListener;
use Symfony\Component\Workflow\Event\TransitionEvent;

class LegalTransitionListener extends AbstractTransitionWorkflowActionListener
{
    public function __construct(private readonly NotificationInterface $notificationHandler)
    {
    }

    public function getIdentifier(): string
    {
        return 'legal_transition_action';
    }

    public function onWorkflowEvent(TransitionEvent $event): void
    {
        $metadata = $this->getActionMetadata($event->getWorkflow(), $event->getTransition());
        $message = $metadata['data']['message'] ?? '';

        $this->notificationHandler->info(
            $message,
            [],
            'domain'
        );

        $this->setResult($event, true);
    }
}
```

This listener displays a notification bar at the bottom of the page when a content item goes through the `to_legal` transition.

The content of the notification is the message configured in `actions.legal_transition_action.data`. To get it, access the metadata for this transition through `getActionMetadata()` (line 27).

Register the listener as a service (in `config/services.yaml`):

```yaml
services:
    App\EventListener\LegalTransitionListener:
        tags:
            - { name: ibexa.workflow.action.listener }
```

## Use custom transition value

Line 36 in the listener above sets a custom result value for the transition. You can use this value in other stages and transitions for this content item, for example:

```yaml
                        approved_by_legal:
                            from: [legal]
                            to: [done]
                            label: Approved by legal
                            color: '#88ad88'
                            icon: '/bundles/ibexaadminuiassets/vendors/ids-assets/dist/img/all-icons.svg#form-checkbox'
                            actions:
                                publish: ~
                                approved_transition_action:
                                    condition:
                                        - result.legal_transition_action == true
```

The action indicated here is performed only if the result from the `legal_transition_action` is set to `true`. Then, the following `src/EventListener/ApprovedTransitionListener` is called:

```php
<?php

declare(strict_types=1);

namespace App\EventListener;

use Ibexa\Contracts\AdminUi\Notification\TranslatableNotificationHandlerInterface as NotificationInterface;
use Ibexa\Contracts\Workflow\Event\Action\AbstractTransitionWorkflowActionListener;
use Symfony\Component\Workflow\Event\TransitionEvent;

class ApprovedTransitionListener extends AbstractTransitionWorkflowActionListener
{
    public function __construct(private readonly NotificationInterface $notificationHandler)
    {
    }

    public function getIdentifier(): string
    {
        return 'approved_transition_action';
    }

    public function onWorkflowEvent(TransitionEvent $event): void
    {
        $context = $event->getContext();
        $message = $context['message'];

        $this->notificationHandler->info(
            $message,
            [],
            'domain'
        );
    }
}
```

Register this listener as a service:

```yaml
services:
    App\EventListener\ApprovedTransitionListener:
        tags:
            - { name: ibexa.workflow.action.listener }
```

This listener also displays a notification, but in this case its content is taken from the message that the user types when choosing the `Done` transition.

The message is contained in the context of the action.

`$event->getContext()` (line 27) gives you access to the context. The context contains:

- `$workflowId` - the ID of the current workflow
- `$message` - content of the user's message when sending the content item through the transitions
- `$reviewerId` - ID of the user who was selected as a reviewer
- `$result` - an array of transition actions performed so far

You can also modify the context using the `setContext()` method. For example, you can override the message typed by the user:

```php
/**
 * @var array<string, mixed> $context
 * @var \Symfony\Component\Workflow\Event\TransitionEvent $event
 */
$new_context = $context;
$new_context['message'] = 'This article went through proofreading';
$event->setContext($new_context);
```
