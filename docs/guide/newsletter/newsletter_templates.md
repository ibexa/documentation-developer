# Newsletter templates

### Template list

|Path|Description|
|--- |--- |
|`Silversolutions/Bundle/EshopBundle/Resources/views/Newsletter/newsletter_box.html.twig`|Renders [the newsletter box](#newsletter-box).|
|`Silversolutions/Bundle/EshopBundle/Resources/views/Newsletter/newsletter_message.html.twig`|Renders a simple page with success/error messages after a user subscribes/unsubscribes to or from newsletter|
|`Silversolutions/Bundle/EshopBundle/Resources/views/Emails/ConfirmationMail_SubscribeNewsletter.html.twig`|HTML confirmation email that is sent to the user in the double opt-in process|
|`Silversolutions/Bundle/EshopBundle/Resources/views/Emails/ConfirmationMail_SubscribeNewsletter.txt.twig`|Text confirmation email that is sent to the user in the double opt-in process|

### Newsletter box

The newsletter box can be rendered as an ESI block or in the Page Builder. 
The box is cached per user.

All parameters from the block template are available in the box.

![](../img/newsletter_1.png)

## Rendering a newsletter form

You can use a render statement to render the newsletter form in a template:

``` php
{{ render(
    controller(
        'SisoNewsletterBundle:Newsletter:renderNewsletterBox',
        {'params' : { 'display_hr' : true }}
    )
) }}
```
