# Customize scenarios with PHP code

Customize product tour scenarios with custom event listeners

Editions: LTS Update

You can customize the product tour scenarios with the [`RenderProductTourScenarioEvent`](../../../api/event_reference/integrated_help_events/index.md) event. This event is dispatched before a product tour scenario is rendered. You can use it to:

- modify tour steps based on user permissions or roles
- add or remove steps dynamically
- change block content based on runtime conditions
- integrate custom data into tour scenarios

With the following example, a custom onboarding scenario is built. It starts only when the current user has a pending [notification](../../../../user/getting_started/notifications/index.md).

First, define a custom product tour scenario. It contains a placeholder step with a single block.

```yaml
ibexa:
    system:
        admin_group:
            product_tour:
                notifications:
                    type: 'targetable'
                    steps:
                        placeholder_step:
                            step_title_translation_key: 'This is a placeholder step'
                            target: '.ibexa-header-user-menu__notifications-toggler'
                            blocks:
                                - type: text
                                  params:
                                      text_translation_key: 'This is a placeholder block, modified during event subscriber execution'
```

Then, create a subscriber that modifies the scenario.

```php
<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Ibexa\Contracts\Core\Repository\NotificationService;
use Ibexa\Contracts\IntegratedHelp\Event\RenderProductTourScenarioEvent;
use Ibexa\IntegratedHelp\ProductTour\Block\LinkBlock;
use Ibexa\IntegratedHelp\ProductTour\Block\TextBlock;
use Ibexa\IntegratedHelp\ProductTour\ProductTourStep;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class NotificationScenarioSubscriber implements EventSubscriberInterface
{
    public function __construct(private NotificationService $notificationService)
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RenderProductTourScenarioEvent::class => ['onRenderScenario'],
        ];
    }

    public function onRenderScenario(RenderProductTourScenarioEvent $event): void
    {
        $scenario = $event->getScenario();
        $steps = $scenario->getSteps();

        if ($scenario->getIdentifier() !== 'notifications') {
            return;
        }

        foreach ($steps as $step) {
            $scenario->removeStep($step);
        }

        if (!$this->hasUnreadNotifications()) {
            return;
        }

        $customStep = new ProductTourStep();
        $customStep->setIdentifier('custom_step_identifier');
        $customStep->setInteractionMode('clickable');
        $customStep->setTarget('.ibexa-header-user-menu__notifications-toggler');
        $customStep->setTitle('You have unread notifications');
        $customStep->addBlock(new TextBlock('Click here to preview your unread notifications.'));
        $customStep->addBlock(new LinkBlock(
            'https://doc.ibexa.co/projects/userguide/en/latest/getting_started/notifications/',
            'Learn more about notifications'
        ));

        $scenario->addStep($customStep);
    }

    private function hasUnreadNotifications(): bool
    {
        return $this->notificationService->getPendingNotificationCount() > 0;
    }
}
```

The subscriber executes the following actions:

- makes sure the correct scenario is being processed
- removes all the existing scenario steps
- verifies that the current user has a pending notification
- adds a custom clickable step to highlight the unread notification

![Scenario built with PHP triggered on unread notification](https://doc.ibexa.co/en/5.0/administration/back_office/img/product_tour/custom_scenario.png "Scenario built with PHP triggered on unread notification")
