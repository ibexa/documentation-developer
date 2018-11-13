# Customizing Form Builder email notifications

!!! enterprise
    
    ## Override email template  
    
    Email is one of the Submit button options you can choose from in the Form Builder Interface.
    It allows you to gather readers' email addresses to send notifications to.
    To customize Form Builder email submission notification you need to override Twig template `form_builder/form_submit_notification_email.html.twig`.
    It is built with two blocks, subject and body. Each of them is rendered independently and consists of three sets of parameters.
    
    |Parameter|Type|Description|
    |---------|----|-----------|
    |`content`|`eZ\Publish\API\Repository\Values\Content\Content`|Name of the form, its Content Type|
    |`form`|`EzSystems\EzPlatformFormBuilder\FieldType\Model\Form`|Definition of the form|
    |`data`|`EzSystems\EzPlatformFormBuilder\FieldType\Model\FormSubmission`|Sent data|  
    
    By adjusting them to your needs, you will change your email template.
    
    ## Configure sender details
    
    To send emails you also need to remember to configure `sender_address` in `app/config/config.yml`.
    It acts as a return address where all bounced messages will be returned to.
    You can learn more by visiting [Symfony Mailer Configuration Reference](https://symfony.com/doc/3.4/reference/configuration/swiftmailer.html#sender-address)