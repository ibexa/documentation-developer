# MailHelperService

`MailHelperService` is used to create, render and send emails from eZ Commerce.

## Interface and implementations

|                                           |                                                                                                          |
| ----------------------------------------- | -------------------------------------------------------------------------------------------------------- |
| Interface definition                      | `vendor/silversolutions/silver.tools/src/Siso/Bundle/ToolsBundle/Service/MailHelperServiceInterface.php` |
| Implementation class (using Swift-Mailer) | `vendor/silversolutions/silver.tools/src/Siso/Bundle/ToolsBundle/Service/SwiftMailHelperService.php`     |

## Using

!!! note

    `$subject` is translated in the helper service. Translating it in advance is unnecessary or, in rare cases, could even cause conflicts.

!!! note

    The `SwiftMailHelperService` uses [Mail Logging](../../../guide/logging/logging.md) to help administrators keep track of all the sent emails.
    
    In the Customer center the content of any template parameter named `password` is logged with a masked/removed value.

You can send predefined plain text and/or HTML content by using `sendMail()` or `sendMailWithRenderedTemplate()`.

``` php
$sender = 'fd@silversolutions.de';
$recipient = 'rel@silversolutions.de';
$subject = 'Test Mail';
/** @var \Siso\Bundle\ToolsBundle\Service\MailHelperServiceInterface $mailerService */
$mailerService = $container->get('siso_tools.mailer_helper');
$attachment = '/path/to/file/to/attach.jpg'; // optional
 
// using sendMail()
$mailerService->sendMail(
    $sender,
    $recipient,
    $subject,
    'This is my plain text mail',
    '<html><body><h1>HTML Mail</h1>My HTML mail</body></html>',
    $attachment
);
 
// using sendMailWithRenderedTemplate() with Twig template paths
$mailerService->sendMailWithRenderedTemplate(
    $sender,
    $recipient,
    $subject,
    'SilversolutionsEshopBundle:Checkout/Email:order_confirmation.txt.twig',    // template for plain-text mail
    'SilversolutionsEshopBundle:Checkout/Email:order_confirmation.html.twig',   // template for HTML mail
    array(                                                                      // optional Twig parameters
        'template_param_1' => array('test', 'array'),
        'template_param_2' => 'this is a parameter for the templates',
    ),
    $attachment
);
```
