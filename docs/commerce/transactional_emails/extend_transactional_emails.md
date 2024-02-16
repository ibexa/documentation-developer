---
description: Customize transactional emails to meet your specific business requirements.
edition: commerce
---

# Customize transactional emails

Customizing the transactional email feature allows for better alignment with your specific business requirements.

## Configure workflows

[[= product_name =]] uses workflows to define processes in various Commerce components.
Predefined workflows exist for [order processing](../order_management/configure_order_management.md#default-order-processing-configuration), [payment](../payment/configure_payment.md#default-payment-workflow-configuration) and [shipment](../shipping_management/configure_shipment.md#default-shipment-workflow-configuration).
You can customize those workflows to trigger pushing notifications at various places of these workflows, for example:

``` yaml
framework:
    workflows:
        ibexa_payment:
            # ...
            places:
                pending:
                    metadata:
                        # ...
                        trigger_notification: true # true or false
```

## Define additional variables

[[= product_name =]] comes with a predefined [set of variables](transactional_emails_parameters.md) that you can use when building a template for your transactional email campaign at Actito.
If this list is not sufficient, you can use Events to include additional variables:

```php
<?php

namespace App\EventSubscriber;
  
use Ibexa\Contracts\ConnectorActito\Client\TransactionalMail\SimpleParameter;
use Ibexa\Contracts\ConnectorActito\Event\TransactionalMailRequest\ParametersFactoryEvent;
use Ibexa\Contracts\OrderManagement\Notification\OrderAwareNotificationInterface;
use Ibexa\Contracts\Payment\Notification\PaymentAwareNotificationInterface;
use Ibexa\Contracts\Payment\PaymentMethodServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class TransactionalMailFactoryEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ParametersFactoryEvent::class => 'onParametersFactoryEvent',
        ];
    }

    public function onParametersFactoryEvent(ParametersFactoryEvent $event): void
    {
        $event->addParameter(
            new SimpleParameter(
                'newVariable',
                ['value'],
            ),
        );

        $event->addParameter(
            new SimpleParameter(
                'anotherVariable',
                ['multiple', 'values'],
            ),
        );
    }
}
```

## Customize Actito end-user profile

The Actito platform offers many features for customer data collection, including segmentation, subscriptions and interaction tracking.
This information can be later user for generating statistics, establishing trends, or used to calculate Personalization recommendations.
To use these features you need to provide profile data to API requests yourself.
You do it by means of events that are triggered during profile building.

For example, the `Ibexa\Contracts\ConnectorActito\Event\TransactionalMailRequest\ProfileFactoryEvent` event is triggered for every transactional notification, and it lets you set required data that is passed to Actito API:

```php
<?php
  
namespace App\EventSubscriber;

use Ibexa\Contracts\ConnectorActito\Client\TransactionalMail\Attribute;
use Ibexa\Contracts\ConnectorActito\Client\TransactionalMail\Segmentation;
use Ibexa\Contracts\ConnectorActito\Event\TransactionalMailRequest\ProfileFactoryEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
  
final class TransactionalMailFactoryEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ProfileFactoryEvent::class => 'onProfileFactoryEvent',
        ];
    }

    public function onProfileFactoryEvent(ProfileFactoryEvent $event): void
    {
        $recipient = $event->getRecipient();
        $profile = $event->getProfile();
      	$user = $recipient->getUser();
				
      	// Provide additional data if your profile has more attributes:
        $attributes = $profile->getAttributes();
        $attributes[] = new Attribute('name', $user->getName());
        $profile->setAttributes($attributes);

        // Passing segmentation data to the profile
        $segmentations = [
            new Segmentation(
                'Frequent visitors',
                'storefront_users',
                true,
            ),
        ];
        $profile->setSegmentations($segmentations);

        // Use the same mechanism to pass other profile data
        $profile->setSubscriptions(...);
        $profile->setDataCollection(...);
    }
}
```

## Send emails in language of commerce presence

Actito supports sending out emails in one language only per campaign.
To send emails in different languages from one notification, for example, because your application serves end-users from different locales, for each notification and language pair, you must create a separate campaign.
You could do it by adding a language suffix to a campaign name.

On [[= product_name =]] side, to support this scenario, you must use an Event Subscriber on `Ibexa\Contracts\ConnectorActito\Event\ResolveCampaignEvent`:

```php
<?php

namespace App\EventSubscriber;

use Ibexa\ConnectorActito\Campaign\Campaign;
use Ibexa\Contracts\ConnectorActito\Event\ResolveCampaignEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ResolveCampaginEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ResolveCampaignEvent::class => 'onCampaignResolve',
        ];
    }

    public function onCampaignResolve(ResolveCampaignEvent $event): void
    {
        // you can use below data in your logic
        $resolvedCampaign = $event->getCampaign();
        $recipient = $event->getRecipient();
        $notification = $event->getNotification();

        // when new campaign was determined, set it to the event
        $campaign = new Campaign('new_order_created_12-2023_en-US');
        $event->setCampaign($campaign);
    }
}
```