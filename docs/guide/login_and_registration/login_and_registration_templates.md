# Login and registration templates

## Template list

| Path     | Description        |
| -------- | ------------------ |
| `Silversolutions/Bundle/EshopBundle/Resources/views/Forms/register_private.html.twig`  | Form for private customer registration |
| `Silversolutions/Bundle/EshopBundle/Resources/views/Forms/register_business.html.twig` | Form for business customer registration  |
| `Silversolutions/Bundle/EshopBundle/Resources/views/Forms/register_choice.html.twig`   | Overview page for registration, which offers buttons for the different registration types (and activation of existing customers) |
| `Silversolutions/Bundle/EshopBundle/Resources/views/Forms/activate_business.html.twig` | Form for activating of existing customers   |
| `Silversolutions/Bundle/EshopBundle/Resources/views/Checkout/checkout_login.html.twig`   | Login form in checkout   |
| `Silversolutions/Bundle/EshopBundle/Resources/views/Security/login.html.twig`   | Login form  |

## Related routes

`vendor/silversolutions/silver.e-shop/src/Silversolutions/Bundle/EshopBundle/Resources/config/ses_routing.yml`:

``` yaml
silversolutions_forms_user_choice:
    pattern:  /registration/choice
    defaults: { _controller: SilversolutionsEshopBundle:Forms:chooseUserType }
silversolutions_forms:
    pattern:  /register/{formTypeResolver}
    defaults:
        _controller: SilversolutionsEshopBundle:Forms:forms
        breadcrumb_path: silversolutions_forms_user_choice/silversolutions_forms
        breadcrumb_names: silversolutions_forms_user_choice|breadcrumb/common.silver_forms.$formTypeResolver$
logout:
    path:   /logout

login:
    path:   /login
    defaults:  { _controller: SilversolutionsEshopBundle:Security:login }
```
