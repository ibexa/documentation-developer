# Form templates [[% include 'snippets/commerce_badge.md' %]]

### Template list

|Template|Description|
|--- |--- |
|`register_business.html.twig`|Renders the business registration form|
|`register_private.html.twig`|Renders the private registration form|
|`activate_business.html.twig`|Renders the account activation form for existing customers|
|`my_account.html.twig`|Renders the update my account data form|
|`buyer.html.twig`|Renders the update the buyer address form|
|`invoice.html.twig`|Renders the update the invoice address form|
|`password_change.html.twig`|Renders the change password form|
|`password_reminder.html.twig`|Renders the forgot password form|
|`cancellation.html.twig`|Renders the online cancellation form (RMA)|
|`contact.html.twig`|Renders the contact us form|

|Subtemplate|Description|
|--- |--- |
|`party.html.twig`|Renders the party form attributes|
|`custom_form_label.html.twig`|Renders custom template for the form label|

To define a route to a form, pass the `formTypeResolver` as a parameter:

``` html+twig
<a href="{{ path('silversolutions_service', {'formTypeResolver': 'registration_private'}) }}">{{ 'msg.register_here'|st_translate }}</a>
```
