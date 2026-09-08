---
description: Form Builder enables creating dynamic forms to use in surveys, questionnaires, sign-up forms and others.
---

# Forms

You can build forms consisting of different fields in the Form Builder.

[[% include 'snippets/forms_caution.md' %]]

## Existing Form fields

### Captcha field

The Captcha Form field is based on [Gregwar/CaptchaBundle](https://github.com/Gregwar/CaptchaBundle).

![Captcha field](extending_form_builder_captcha_default.png)

You can customize the field by adding configuration to `config/packages/gregwar_captcha.yaml` under `gregwar_captcha`:

``` yaml
gregwar_captcha:
    as_url: true
    width: 150
    invalid_message: Code does not match, please retry.
    reload: true
```

The example configuration above resizes the Captcha image (line 3), changes the error message (line 4), and enables the user to reload the code (line 5).

![Custom captcha field](extending_form_builder_captcha_result.png)

For information about available options, see [Gregwar/CaptchaBundle's documentation](https://github.com/Gregwar/CaptchaBundle#options).

## Form-uploaded files

You can use Forms to enable the user to upload files.
The default location for files uploaded in this way is `/Media/Files/Form Uploads`.
You can change it with the following configuration:

``` yaml
ibexa:
    system:
        default:
            form_builder:
                upload_location_id: 54
```

This applies only if no specific location is defined in the Form itself.
