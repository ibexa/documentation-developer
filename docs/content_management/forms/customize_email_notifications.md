---
description: Adapt the form and content of emails sent out from the Form Builder.
edition: experience
---

# Customize email notifications

Email is one of the Submit button options you can add to a form in the Form Builder.
Use it to configure a list of email addresses that get notifications about newly filled forms.

![Email notification](email_notification.png)

## Override email template

To customize the form submission email, override the `form_builder/form_submit_notification_email.html.twig` template.
It contains two blocks: `subject` and `body`.
Each of them is rendered independently and consists of three sets of parameters.

|Parameter|Type|Description|
|---------|----|-----------|
|`content`|`Ibexa\Contracts\Core\Repository\Values\Content\Content`|Name of the form, its Content Type|
|`form`|`Ibexa\Contracts\FormBuilder\FieldType\Model\Form`|Definition of the form|
|`data`|`Ibexa\Contracts\FormBuilder\FieldType\Model\FormSubmission`|Sent data|  

## Configure sender details

Some email providers require a sender address to be set, so to avoid unsent emails when using Form Builder,
it is recommended to configure `sender_address` in `config/packages/swiftmailer.yaml`.
This email acts as a sender and return address for all bounced messages.

!!! note

    Since November 2021 the Swift Mailer is no longer supported and the integration with Symfony is deprecated in Symfony 6.0.
    The Swift Mailer got replaced by the Symfony Mailer.

Add `sender_address` entry to `config/packages/swiftmailer.yaml`:

```yaml
swiftmailer:
    url: '%env(MAILER_URL)%'
    spool: { type: 'memory' }
    sender_address: '%env(MAILER_SENDER_ADDRESS)%'
```

In the `.env` file, define a new environment variable:
`MAILER_SENDER_ADDRESS=mail@example.com`
and configure your mail server connection details in the `MAILER_URL` environmental variable.
