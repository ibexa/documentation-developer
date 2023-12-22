---
description: Learn basic information about user logging and registration processes.
---

# Basic user setup

## Login

In [[= product_name =]], users can log in with their user name or email.
For more information, see [Login methods](login_methods.md).

## Registration

[[= product_name =]] provides different registration options for private and business customers.
For more information, see [Register new users](user_registration.md).

### Private customers

A private customer can register directly via the`/register/private` route.

A double opt-in process checks the email address, and then creates and activates the user.

#### Activation link recipient

You can decide that emails with the activation link are not sent to the customer, but to a different email address.

``` yaml
siso_core.default.user_activation_receiver: supervisor@example.com
```

The email message contains the name of the user and a link to the user in the Back Office.
To generate a correct link to the Back Office, configure `related_admin_site_access`:

``` yaml
siso_core.default.related_admin_site_access: 'admin'
```

To adapt the success message of the private registration, modify the text module with the identifier `success_register_private`.

### Business customers

A business customer has two options to register:

1. Apply for a new account - fill the business form and apply for an account via the `/registration/choice` route.
The shop owner checks the provided data and creates a customer record in the ERP system.

1. Activate an account - a business customer who already has a customer number can register using a customer number and an invoice number.
The shop checks this data by sending a request to the ERP. There are two options:

    - activate a business account - the customer is created using their customer number and can immediately see their special discounts in the shop.
    - in [[= product_name_com =]], create the main contact in Customer Center. If Customer Center is enabled, the company is created in the shop, and the account is created as the main contact.  

## Configuration

You can specify the default Location ID for Users per SiteAccess:

``` yaml
siso_core.default.user_group_location: 106
siso_core.default.user_group_location.business: 106
siso_core.default.user_group_location.private: 106
siso_core.default.user_group_location.editor: 14
```

`redirect_homepage` configures the default list of URLs from which the user is redirected after login.

``` yaml
siso_core.default.redirect_homepage:
    - /login
    - /register
    - /registration
    - /password
    - /token
    - /change_password
```

### Account activation email

When the `info_email_after_user_activation` parameter is set to true,
the customer receives an email when the account is enabled using the activation link.

``` yaml
siso_core.default.info_email_after_user_activation: false
```

## Template list

| Path     | Description        |
| -------- | ------------------ |
| `Silversolutions/Bundle/EshopBundle/Resources/views/Forms/register_private.html.twig`  | Form for private customer registration |
| `Silversolutions/Bundle/EshopBundle/Resources/views/Forms/register_business.html.twig` | Form for business customer registration  |
| `Silversolutions/Bundle/EshopBundle/Resources/views/Forms/register_choice.html.twig`   | Overview page for registration, which offers buttons for the different registration types (and activation of existing customers) |
| `Silversolutions/Bundle/EshopBundle/Resources/views/Forms/activate_business.html.twig` | Form for activating existing customers   |
| `Silversolutions/Bundle/EshopBundle/Resources/views/Checkout/checkout_login.html.twig`   | Login form in checkout   |
| `Silversolutions/Bundle/EshopBundle/Resources/views/Security/login.html.twig`   | Login form  |
