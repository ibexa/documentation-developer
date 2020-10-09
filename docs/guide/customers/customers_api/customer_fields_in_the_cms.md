# Customer fields

## User Content Type

By default, the User Content Type contains the following Fields:

|Field|Field identifier|Field Type|Note|
|--- |--- |--- |--- |
|Name|name|Text line|This attribute cannot be removed from the User Content Type. There are Users (such as admin, editors) who don't have any `customer_profile_data` information.|
|First name|first_name|Text line||
|Last name|last_name|Text line||
|Salutation|salutation|SesSelection||
|User Account|user_account|User account||
|Signature|signature|Text block||
|Image|image|Image||
|Customer number|customer_number|Text line||
|Contact Number|contact_number|Text line||
|Customer Profile Data|customer_profile_data|sesprofiledata|This Field contains a Base64-encoded string. If decoded and unserialized, this results in a customer profile data model entity.|
|Budget per order|budget_order|Float||
|Budget per month|budget_month|Float||

## Access to the profile

Not every user is allowed to modify their profile data in the shop (e.g. guest).
You have to add the Policy `siso_policy/forms_profile_edit` to a Role and assign it to customers.
The built-in "Ecommerce registered users" Role already includes this Policy.

### Getting the Policy in a controller

``` php
return $this->render(
            'SilversolutionsEshopBundle::details.html.twig',
            array(
                'grant_profile_edit' => $this->isGranted(new AuthorizationAttribute('siso_policy', 'forms_profile_edit')),
            )
        );
```

### Using the Policy in a template

``` html+twig
{% if grant_profile_edit %}
    <a href="{{ path('silversolutions_profile', {'formTypeResolver': 'my_account'}) }}" class="button float_left">{{ 'Change My Account'|st_translate('profile') }}</a>
    <div class="float_left">&nbsp;
    <a href="{{ path('ez_legacy', {'module_uri': '/user/password'}) }}" class="button float_left">{{ 'Change password'|st_translate() }}</a>
{% endif %}
```

### Restricting access to the form

You can also restrict access to the form if the user calls a URL that they do not have permissions for.
This is set in configuration:

``` yaml
ses_forms.configs.buyer:
    policy: siso_policy/forms_profile_edit
```

For example:

The customer calls URL `/profile/buyer` (wants to edit the buyer address) without having the appropriate Role.
