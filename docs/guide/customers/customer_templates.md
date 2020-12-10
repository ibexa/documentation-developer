# Customer templates

The global `ses.profile` Twig variable contains the main information about the current user,
their addresses and data from the ERP.

If the user has a customer number, customer information is automatically fetched from the ERP.
The data is stored in the session and is provided by the variable `ses.profile`.

`SilversolutionsEshopBundle/Resources/views/details.html.twig` is the standard template for displaying customer data.

## Getting customer profile data

As `ses.profile` in the template returns the currently logged-in profile,
you can use all read-only members from [`CustomerProfileData`](customer_api/customer_profile_data.md).

For example:

``` html+twig
Current customer number: {{ ses.profile.sesUser.customerNumber }}
E-Mail address:          {{ ses.profile.sesUser.email }}
  
{% if ses.profile.sesUser.isLoggedIn %}
    Hello customer #{{ ses.profile.sesUser.customerNumber }}.
  
    {% if ses.profile.sesUser.contact.isBlocked %}
        You are blocked
    {% endif %}
{% endif %}
  
{% if ses.profile.sesUser.isAnonymous %}
    <p>Anonymous user</p>
{% endif %}
```
