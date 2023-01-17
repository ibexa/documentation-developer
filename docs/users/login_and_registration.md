---
description: Configure registering and activating customers.
---

# Login and registration

## Login

In [[= product_name =]], users can log in with their user name or email.

## Registration

[[= product_name =]] provides different registration options for private and business customers.

### Private customers

A private customer can register directly via the`/register/private` route.

A double opt-in process checks the email address, and then creates and activates the user.

#### Activation link recipient

You can decide that emails with the activation link are not sent to the customer, but to a different email address.

``` yaml
ibexa.commerce.site_access.config.core.default.user_activation_receiver: supervisor@example.com
```

The email message contains the name of the user and a link to the user in the Back Office.
To generate a correct link to the Back Office, configure `related_admin_site_access`:

``` yaml
ibexa.commerce.site_access.config.core.default.related_admin_site_access: 'admin'
```

To adapt the success message of the private registration, modify the text module with the identifier `success_register_private`.

### Business customers

A business customer has two options to register:

1. Apply for a new account - fill the business form and apply for an account via the `/registration/choice` route.

1. Activate an account - a business customer who already has a customer number can register using a customer number and an invoice number.
The shop checks this data. There are two options:

    - activate a business account - the customer is created using their customer number and can immediately see their special discounts in the shop.
    - in [[= product_name_com =]], create the main contact in Customer Center. If Customer Center is enabled, the company is created in the shop, and the account is created as the main contact.  

## Configuration

You can specify the default Location ID for Users per SiteAccess:

``` yaml
ibexa.commerce.site_access.config.core.default.user_group_location: 106
ibexa.commerce.site_access.config.core.default.user_group_location.business: 106
ibexa.commerce.site_access.config.core.default.user_group_location.private: 106
ibexa.commerce.site_access.config.core.default.user_group_location.editor: 14
```

`redirect_homepage` configures the default list of URLs from which the user is redirected after login.

``` yaml
ibexa.commerce.site_access.config.core.default.redirect_homepage:
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
ibexa.commerce.site_access.config.core.default.info_email_after_user_activation: false
```

## Template list

| Path     | Description        |
| -------- | ------------------ |
| `Eshop/Resources/views/Forms/register_private.html.twig`  | Form for private customer registration |
| `Eshop/Resources/views/Forms/register_business.html.twig` | Form for business customer registration  |
| `Eshop/Resources/views/Forms/register_choice.html.twig`   | Overview page for registration, which offers buttons for the different registration types (and activation of existing customers) |
| `Eshop/Resources/views/Forms/activate_business.html.twig` | Form for activating existing customers   |
| `Eshop/Resources/views/Checkout/checkout_login.html.twig`   | Login form in checkout   |
| `Eshop/Resources/views/Security/login.html.twig`   | Login form  |
