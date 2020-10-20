# Customers templating

[[= product_name_com =]] provides a global Twig variable `ses` which is available in all templates.
The variable provides the `profile` method which contains information about the current customer.

If the user has a customer number, [[= product_name_com =]] automatically fetches customer information from the ERP.
The data is stored in the session and is provided by the variable `ses.profile`.
Subsequent calls do not initiate a new request to the ERP because the data from the ERP is cached and handled by the Symfony session handlers.

[[= product_name_com =]] provides a standard template for displaying customer data:
`SilversolutionsEshopBundle/Resources/views/details.html.twig`.

## Getting customer profile data

As `ses.profile` in the template returns the currently logged-in profile, you are able to use all read-only members from the [`CustomerProfileData`](customers_api/customer_profile_data_components/customer_profile_data_model.md) implementation.

For example:

``` html+twig
Current customer number: {{ ses.profile.sesUser.customerNumber }}
All delivery addresses:  {% set deliveryAddresses = ses.deliveryParty %}
E-Mail address:          {{ ses.profile.sesUser.email }}
 
{# check if the user is logged in and blocked: #}
{% if ses.profile.sesUser.isLoggedIn %}
    Hello customer #{{ ses.profile.sesUser.customerNumber }}.
 
    {% if ses.profile.sesUser.contact.isBlocked %}
        Sorry, but you are blocked!
    {% endif %}
{% endif %}
 
{# check if the user is logged in as an anonymous user: #}
{% if ses.profile.sesUser.isAnonymous %}
    <p>Anonymous user</p>
{% endif %}
```

You can use any data from `CustomerProfileData`, see [example in the model](customers_api/customer_profile_data_components/customer_profile_data_model.md).

## Getting data from a buyer party

``` html+twig
{# Example for getting customized data from the ERP stored in the BuyerParty #}

{% set buyerParty = ses.defaultBuyerAddress %}
{% if buyerParty.SesExtension.value.Gliederungskennzeichen is defined and buyerParty.SesExtension.value.Gliederungskennzeichen == '1' %}

{% endif %}

{# Get the invoiceParty #}
{% set invoiceAddress = ses.defaultInvoiceParty %}

{# Get the delivery address #} 
{% set deliveryAddress = ses.defaultDeliveryParty %}
```

To output the telephone number of the contact, point to the member variable `$phoneNumber` of the `Contact`.

``` 
Phone number of contact {{ ses.profile.sesUser.contact.phoneNumber }}
```

![](../img/customer_templating.png)
