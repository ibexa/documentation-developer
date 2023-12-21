# Data processors

Data processors are executed after a form is submitted. You can use any number of data processors per form.
The configuration lists data processors that are executed in sequence, for example:

``` yaml
ses_forms.configs.business_activation:
    dataProcessors:
        - ses_forms.validate_business_activation
        - ses.customer_profile_data.data_processor.create_customer_profile_data
        - ses_forms.create_ez_user
        - ses_forms.login_new_ez_user 
```

## FormDataProcessorException

If one of the data processors throws `FormDataProcessorException`, this stops further processing.

The user sees the filled form with the error message from `FormDataProcessorException`.

## CreateCustomerProfileDataDataProcessor

`CreateCustomerProfileDataDataProcessor` creates a new [`CustomerProfileData`](../../customers/customer_api/customer_profile_data.md) object and fills it with data from the registration process.

Service ID: `ses.customer_profile_data.data_processor.create_customer_profile_data`

### Customer type

You can set the customer type in configuration:

``` yaml
parameters:
    ses_forms_values:
        customerType:
            private: private
            business: business
```

## CreateRegistrationTokenDataProcessor

`CreateRegistrationTokenDataProcessor` creates a new token with the help of [`TokenService`](../../users/token.md#tokenservice).

Service ID: `ses_forms.create_registration_token_data_processor`

The parameters for the `createToken()` method are taken from the configuration:

``` yaml
ses_registration:
    #time in seconds how long the token is valid
    registration_token_valid_until: 7200
    registration_token_action_service: silver_forms.token.enable_ez_user
    registration_token_action_service_method: enableEzUser 
```

## EzCreateUserDataProcessor

`EzCreateUserDataProcessor` creates a new `EzUser` object. This data processor relies on the result of `CreateCustomerProfileDataDataProcessor`,
because the [`CustomerProfileData`](../../customers/customer_api/customer_profile_data.md) object must be given.

The data processor sets the following fields in the User Content item:

- `login` 
- `email`
- `password`
- `name`
- `customer_number`
- `contact_number`
- `customer_profile_data`
- `ses_hastopay_vat`
- `ses_display_vat`

[[= product_name =]] provides a standard event for this handler, which adds a prefix to the login name of the user.
The prefix can be defined in the configuration key `data_processor_ez_user_login_prefix`.

``` xml
<service id="ses_data_processor.pre_execute.create_ez_user_handler" class="%ses_data_processor.pre_execute.create_ez_user_handler.class%">
            <argument type="service" id="ezpublish.config.resolver" />
            <tag name="kernel.event_listener" event="ses_pre_execute_ses_forms.create_ez_user" method="preExecute" />
</service>
```

Service ID: `ses_forms.create_ez_user`

Values set for private/business registration:

Private:

```
ses_hastopay_vat = true
ses_display_vat = true
```

Business:

```
ses_hastopay_vat = true
ses_display_vat = false
```

## EzUserDisableDataProcessor

`EzUserDisableDataProcessor` disables the User after registration.

Service ID: `ses_forms.disable_ez_user`

## EzUserLoginDataProcessor

`EzUserLoginDataProcessor` logs in as a User.

Service ID: `ses_forms.login_new_ez_user`

## HasFormChangedDataProcessor

`HasFormChangedDataProcessor` checks if the default values in the form are changed after the form is submitted.

Service ID: `ses.customer_profile_data.data_processor.has_form_changed`

## SendCancellationEmailDataProcessor

`SendCancellationEmailDataProcessor` sends an email after the user fills the cancellation form.

The cancellation email receiver and the cancellation subject can be set in configuration:

``` yaml
parameters:
    #recipient of the cancellation email
    siso_core.default.ses_swiftmailer:
        ...
        cancellationMailReceiver: contact@silversolutions.de

    #cancellation email subject
    siso_core.cancellation.subject: common.cancellation_email_subject
```

Service ID: `siso_core.data_processor.send_cancellation_email`
    
Corresponding form: `Silversolutions\Bundle\EshopBundle\Form\Cancellation`

## SendConfirmationMailDataProcessor

`SendConfirmationMailDataProcessor` sends an email in the following cases:

- When a private customer registers, an email is sent to the user email address with an activation link.
- When a business customer registers, an email is sent to the administrator with all submitted data (including attachment).
The task of the administrator is to validate the data.
- When a customer who has a customer number edits their profile data (see [HasFormChangedDataProcessor](#hasformchangeddataprocessor)), an email is sent to the administrator.

Symfony SwiftMailer is used to send the email.

Service ID: `ses_forms.send_confirmation_data_processor`

The mail sender and receiver can be set in configuration:

``` yaml
siso_core.default.ses_swiftmailer:
    mailSender: noreply@mydomain.de       
    mailReceiver: admin@mydomain.de #used as an admin email address
```

### Email Templates

Two templates are available for each form type, in `.txt` or `.html` format.

The name of the template must keep this form: `ConfirmationMail_' . $formName . '.txt.twig'`, `ConfirmationMail_' . $formName . '.html.twig'`.

``` 
ConfirmationMail_RegisterBusiness.html.twig
ConfirmationMail_RegisterBusiness.txt.twig

ConfirmationMail_RegisterPrivate.html.twig
ConfirmationMail_RegisterPrivate.txt.twig

ConfirmationMail_MyAccount.html.twig
ConfirmationMail_MyAccount.txt.twig

ConfirmationMail_Buyer.html.twig
ConfirmationMail_Buyer.txt.twig

//Fallback used when no template is find or defined
ConfirmationMail_Fallback.html.twig
ConfirmationMail_Fallback.txt.twig
```

!!! note "Footer"

    The default mail footer that is included into emails is located in `EshopBundle/Resources/views/Emails/mail_footer.html.twig`.

## SendContactEmailDataProcessor

`SendContactEmailDataProcessor` sends an email after the user fills the contact form.
If the user checked that they want to get a copy of this email, additional email is sent to the user email address as well.

By default the email is sent to the `contactMailReceiver` who is set in configuration:

``` yaml
parameters:
    siso_core.default.ses_swiftmailer:
          mailSender: noreply@silversolutions.de
          mailReceiver: azh@silversolutions.de
          contactMailReceiver: azh@silversolutions.de
```

Service ID: `siso_core.data_processor.send_contact_email`

Corresponding form: `Silversolutions\Bundle\EshopBundle\Form\Contact`

## SendRmaEmailDataProcessor

`SendRmaEmailDataProcessor` sends an email after the user has filled the RMA (return merchandise authorization) form.

The RMA mail receiver and the RMA subject can be set up in configuration.

The RMA mail receiver is the same one as the cancellation email receiver.

``` yaml
parameters:
    #recipient of the cancellation email
    siso_core.default.ses_swiftmailer:
        ...
        cancellationMailReceiver: contact@silversolutions.de

    #RMA email subject
    siso_core.default.rma_subject: "common.rma_email_subject"
```

Service ID: `siso_core.data_processor.send_rma_email`

Corresponding form: `Silversolutions\Bundle\EshopBundle\Form\RMA`

## UpdateBuyerDataProcessor

`UpdateBuyerDataProcessor` updates `CustomerProfileData` in the `User` object when the user edits the buyer address (see [HasFormChangedDataProcessor](#hasformchangeddataprocessor)).

The changes are stored only if the user has no customer number.

Service ID: `ses.customer_profile_data.data_processor.update_buyer`

Corresponding form: `Silversolutions\Bundle\EshopBundle\Form\Customer\Buyer`

## UpdateCustomerProfileDataProcessor

`UpdateCustomerProfileDataProcessor` updates `CustomerProfileData` in the `User` object when the user adds or edits their address.

Service ID: `siso_core.data_processor.update_customer_profile_data`

Corresponding form: `Silversolutions\Bundle\EshopBundle\Form\Address`

## UpdateMyAccountDataProcessor

`UpdateMyAccountDataProcessor` updates `CustomerProfileData` and other Content item attributes (like email) in the `User` object
when the user edits their account and introduces changes (see [HasFormChangedDataProcessor](#hasformchangeddataprocessor)).

The changes are stored only if the user has no customer number.

Service ID: `ses.customer_profile_data.data_processor.update_buyer`

Corresponding form: `Silversolutions\Bundle\EshopBundle\Form\Customer\MyAccount`

## ValidateBusinessActivationDataProcessor

`ValidateBusinessActivationDataProcessor` checks if the submitted invoice and customer number are valid.
This resolves communication with ERP.

Service ID: `ses_forms.validate_business_activation`
