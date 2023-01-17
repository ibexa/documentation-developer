---
description: Form Builder enables creating dynamic forms to use in surveys, questionnaires, sign-up forms and others.
edition: experience
---

# Forms

You can build forms consisting of different fields in the Form Builder.

!!! tip

    To learn how to get, create, and delete form submissions by using the PHP API,
    see [Form API](form_api.md).

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

The example configuration above resizes the Captcha image (line 3), changes the error message (line 4),
and enables the user to reload the code (line 5).

![Custom captcha field](extending_form_builder_captcha_result.png)

For information about available options, see [Gregwar/CaptchaBundle's documentation.](https://github.com/Gregwar/CaptchaBundle#options)

!!! note

    If your installation uses Varnish to manage content cache, you must modify the configuration to avoid issues with the Captcha field. For more information, see [Ensure proper captcha behavior](reverse_proxy.md#ensure-proper-captcha-behavior).

## Form submission purging

You can purge all submissions of a given form. 
To do this, run the following command, where `form-id` stands for Content ID 
of the form for which you want to purge data:

```bash
php bin/console ibexa:form-builder:purge-form-submissions [options] [--] <form-id>
```

The following table lists some of the available options and their meaning: 

| Switch | Option | Description |
|--------------|------------|------------|
| `-l` | `--language-code=LANGUAGE-CODE` | Passes a language code, for example, "eng-GB". |
| `-u` | `--user[=USER]` | Passes a repository username. By default it is "admin". |
| `-c` | `--batch-size[=BATCH-SIZE]` | Passes a number of URLs to check in a single iteration. Set it to avoid using too much memory. By default it is set to 50. |
| | `--siteaccess[=SITEACCESS]` | Passes a SiteAccess to use for operations. If not provided, the default SiteAccess is used. |

## Form-uploaded files

You can use Forms to enable the user to upload files.
The default Location for files uploaded in this way is `/Media/Files/Form Uploads`.
You can change it with the following configuration:

``` yaml
ibexa:
    system:
        default:
            form_builder:
                upload_location_id: 54
```

This applies only if no specific Location is defined in the Form itself.
