# Additional newsletter data

To send additional data to the newsletter provider, you need to implement an event listener
that listens to `subscribe_newsletter_event` or `update_newsletter_event`.

``` php
public function setCustomParameters(SubscribeNewsletterEvent $event)
{
    $customerProfileData = $event->getCustomerProfileData();
    $params = $event->getParams();

    if ($customerProfileData instanceof CustomerProfileData && !array_key_exists('order_amount', $params)) {
        $userId = $customerProfileData->sesUser->sesUserObjectId;
        /** fetch the amount of all user orders */
        $orderAmount = $this->basketRepository->getUserOrdersAmount($userId);
        $params['order_amount'] = $orderAmount;
    }

    $event->setParams($params);
}
```

``` xml
<service id="project.newsletter.subscribe_newsletter_listener" class="%project.newsletter.subscribe_newsletter_listener.class%">
    <argument type="service" id="project.basket_repository"/>  
    <tag name="kernel.event_listener" event="subscribe_newsletter_event" method="setCustomParameters" />
</service>
```
