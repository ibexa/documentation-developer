# Using reCAPTCHA [[% include 'snippets/commerce_badge.md' %]]

The EWZRecaptchaBundle provides a reCAPTCHA form field for Symfony.
It includes an additional validator.

The following forms are ready to use reCAPTCHA:

- Contact form
- Cancellation form
- Registration forms
    - private
    - business
- Activate business

You can configure the following reCAPTCHA options in the Back Office:

- theme (light or dark)
- type (audio or image)
- size (normal or compact)
- defer - when present, specifies that the script is executed when the page has finished parsing.
- async - when present, specifies that the script is executed asynchronously as soon as it is available.

## Activating reCAPTCHA in forms

### 1\. Generate the reCAPTCHA API-Key pair

Go to: http://www.google.com/recaptcha/admin and log in.

Register a new domain to get a pair of keys.

### 2\. Configure reCAPTCHA

Add the generated keys to `parameters.yml`:

``` yaml
ewz_recaptcha_public_key: 6L************************************ev
ewz_recaptcha_private_key: 6L************************************hF
```

## Adding reCAPTCHA to a form

To add reCAPTCHA, extend the form entity and type.

Refer to `EshopBundle/Entities/Forms/RegisterBusiness.php` and `EshopBundle/Entities/Forms/Types/RegisterBusinessType.php` for examples.

When you have extended the form entity and type you must add a parameter to `forms.yml` and extend `configuration_core.yml` (`silver_form_type_business`):

Refer to `EshopBundle/Resources/config/forms.yml` and `EshopBundle/Resources/config/backend/configuration_core.yml` for examples.
