# Forms [[% include 'snippets/commerce_badge.md' %]]

[[= product_name_com =]] offers a unified way of handling all one-page forms.

One-page forms have several common criteria:

- They are displayed on a single page.
- After submitting some processes are executed in the backend.
- After server response the user sees a confirmation page with a success or error message.

[[= product_name_com =]] uses [Symfony forms](http://symfony.com/doc/3.4/forms.html) as a part of the solution.

You can pre-fill the form with default values when it is loaded for the first time.
The process that pre-fills the form is called a [pre-data processor](form_api/predataprocessors.md).

You can define actions that are executed after the form is submitted.
These actions are services that are called in a sequence and are able to exchange the data.
These actions are called [`dataProcessors`](form_api/dataprocessors.md).

If process execution is not successful, the process can store an error message
and display it on the confirmation page.

You can decide what happens after the form is submitted - on server response.
You can differ between valid and invalid responses and change the behavior according to your needs.

Usually a confirmation page is displayed, but you can choose one of the following behaviors:

- confirmation page
- redirect to another page:
    - another route from the shop
    - external URL

## Creating a form

To create a form you must define and implement the form component parts (form entity, form type, template)
and its services (`preDataProcessor` and `dataProcessors`) and point to them in [configuration](#configuration).

### FormTypeResolver

`formTypeResolver` identifies the form in the URL.

`FormsController::formsAction` handles the form and `formTypeResolver` is the parameter that tells it
which forms configuration should be used.

``` yaml
silversolutions_service:
    path:  /service/{formTypeResolver}
    defaults: { _controller: Silversolutions\Bundle\EshopBundle\Controller\FormsController::formsAction }
```

When you call the URL `/service/registration_private` the `FormsController::formsAction` method
uses the forms configuration.

#### Define another URL for the form

If you want to change the URL for the form, define a new route for `FormsController::formsAction`.

The parameter `formTypeResolver` must still be part of the URL.

``` yaml
test_project_forms:
    path:  /shop_functions/{formTypeResolver}
    defaults: { _controller: Silversolutions\Bundle\EshopBundle\Controller\FormsController::formsAction }
```

Then, when you call `/shop_functions/registration_private`, the `FormsController::formsAction` is used.

### Configuration

The configuration parameter must follow this syntax:

``` yaml
ses_forms.configs.{formTypeResolver}
```

`formTypeResolver` identifies the form and has a special function.

You can define the whole form behavior using configuration.

In the following example, `formTypeResolver` value is `registration_private`.

``` yaml
parameters:
    ses_forms.configs.registration_private:
        modelClass: Silversolutions\Bundle\EshopBundle\Entities\Forms\RegisterPrivate
        # either typeClass or typeService has to be defined
        typeClass: Silversolutions\Bundle\EshopBundle\Entities\Forms\Types\RegisterPrivateType
        typeService: silver_forms.register_private_type
        template: SilversolutionsEshopBundle:Forms:register_private.html.twig
        invalidMessage: error_message_register
        validMessage: success_register_private 
        policy: siso_policy/forms_profile_edit
        response:
            valid:
               template: SilversolutionsEshopBundle:Forms:register_private_valid.html.twig 
                httpResponse: 'http://www.google.de'
                routeName: 'silversolutions_forms_user_choice'
            invalid:         
                template: SilversolutionsEshopBundle:Forms:register_private_valid.html.twig
                httpResponse: 'http://www.google.de'
                routeName: 'silversolutions_forms_user_choice'
        preDataProcessor: ses_forms.fill_private_form
        dataProcessors:            
            - ses_forms.create_ez_user
            - ses_forms.disable_ez_user
            - ses_forms.create_registration_token_data_processor
            - ses_forms.send_confirmation_data_processor
```

|Configuration key|Description|
|--- |--- |
|`modelClass`|Required. A fully-qualified class path to the form entity. This class must extend `Silversolutions\Bundle\EshopBundle\Entities\Forms\AbstractFormEntity`|
|`typeClass`|Required if `typeService` is not defined. A fully-qualified class path to the form type. Using `typeService` gives more flexibility.|
|`typeService` |Required if `typeClass` is not defined. ID of the form type service.|
|`template`|Required. Template that renders the form.|
|`validMessage`|General success message displayed on the confirmation page if form submission is successful.|
|`invalidMessage`|General error message displayed on the confirmation page if form submission failed.|
|`preDataProcessor`|ID of the service that pre-fills the form.|
|`dataProcessors`|List of service IDs that are executed in sequence after the form is submitted.|
|`response`|Behavior definition on the server response. If not defined, the confirmation page (template) is displayed.|
|`policy`|Required user Policy. If the user doesn't have the Policy, they cannot see the form. The Policy must be defined as `module/function`|
