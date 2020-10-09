# Newsletter

eZ Commerce offers a newsletter interface. This allows the user to subscribe to newsletters
and see the newsletter status or update newsletter details information in their profile.

There is no specific newsletter provider connection configured out of the box.
The standard offers only processes, templates, routes, configurations and an interface which can be used for newsletter integration.
A newsletter provider service with specific API implementation of this provider has to be implemented separately.

## Newsletter features in eZ Commerce

- Double-opt-in process when a user subscribes to the newsletter
- User can subscribe from the newsletter box
- User can subscribe during the registration process
- User can subscribe and unsubscribe from their profile
- User can update their newsletter details from their profile
- User newsletter details are updated after ordering in the checkout
- The newsletter status is fetched from the newsletter provider after the login and the user sees the status in their profile.
The newsletter status is stored in customer profile data together with the list of IDs of newsletter topics, so it can be rendered in the template if required.

``` html+twig
{# true if user subscribed at least one newsletter #}
{{ ses.profile.sesUser.subscribesNewsletter }}

{# list of subscribed newsletter ids #}
{% set dataMap = ses.profile.getDataMap.dataMap %}
{% set newsletters = dataMap.subscribed_list_ids %}
{% if newsletters|default is not empty %}
  {% for newsletter in newsletters %}
    {{ newsletter }}
  {% endfor %}
{% endif %}
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

There are places where you can add or modify additional user data and send it to newsletter provider.

- Before a user subscribes to the newsletter. By default the user language (current locale) is sent.
- After the user updates their profile or creates an order. By default the newsletter details are updated with latest information about:
    - `last_order_date` - date when last order was made 
    - `last_order_amount` - order amount from last order
    - `order_amount_total` - total order amount for the user

In both cases any data from the [customer profile](../customers/customers.md) can be sent,
but you have to implement a custom event listener for that.

Attributes that do not exist in the newsletter provider have to be created first.

## Double-opt-in process

When a user subscribes to a newsletter throught the shop (newsletter box, registration, profile),
the shop first checks if the user already exists in the newsletter provider.
It can happen that the user had already subscribed in the past.

If the user is not known to the newsletter provider, the double opt-in process is started.

User data is stored in the shop in a [token](../user_management/token/token.md) and the user receives an email where they have to confirm their email address.

After the user clicks the link in the confirmation email, the token is invalidated and the user is subscribed to the newsletter.
If they are logged in, they can immediately update the status in their profile.
