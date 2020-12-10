# Newsletter

eZ Commerce offers a newsletter interface. It allows the user to subscribe to newsletters
and see the newsletter status or update newsletter details information in their profile.

There is no specific newsletter configured out of the box.
The standard offers only processes, templates, routes, configurations and an interface which can be used for newsletter integration.
A newsletter provider service with specific API implementation of this provider has to be implemented separately.

The newsletter status is fetched from the newsletter provider after the user logs in, and displayed in the user's profile.
The newsletter status is stored in customer profile data together with the list of IDs of newsletter topics, so it can be rendered in the template if required.

``` html+twig
{{ ses.profile.sesUser.subscribesNewsletter }}

{% set dataMap = ses.profile.getDataMap.dataMap %}
{% set newsletters = dataMap.subscribed_list_ids %}
{% if newsletters|default is not empty %}
  {% for newsletter in newsletters %}
    {{ newsletter }}
  {% endfor %}
{% endif %}
```

## Configuration

General newsletter configuration is located in `newsletter.yml`:

``` yaml
parameters:
    # you can disable the newsletter module here
    siso_newsletter.default.newsletter_active: true
    # enable if you want to support several newsletter topics
    siso_newsletter.default.support_several_newsletters: false
    # if enabled, user will be unsubscribed from all newsletters (topics) at once
    siso_newsletter.default.unsubscribe_globally: true
    # if enabled also logged in users will see the newsletter box
    siso_newsletter.default.display_newsletter_box_for_logged_in_users: true
```

### Default attributes

Following attributes are offered by default. These attributes are sent to the newsletter provider if available:

- First name
- Last name
- Gender
- Telephone Number
- Date of birth
- User language
- Last order date
- Last order amount
- Order amount total

### Additional attributes

There are places where you can add or modify additional user data and send it to a newsletter provider.
You can do it:

- before a user subscribes to the newsletter. By default the user language (current locale) is sent.
- after the user updates their profile or creates an order. By default, the newsletter details are updated with latest information about:
    - `last_order_date` - date when last order was made 
    - `last_order_amount` - order amount from last order
    - `order_amount_total` - total order amount for the user

In both cases any data from the [customer profile](../customers/customers.md) can be sent,
but you have to implement a custom event listener for that.

Attributes that do not exist in the newsletter provider have to be created first.

#### Additional newsletter data

To send additional data to the newsletter provider, implement an event listener
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
