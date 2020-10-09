# Customer profile data controller

`Silversolutions\Bundle\EshopBundle\Controller\CustomerProfileDataController`

## Actions

|Action|Route|Description|
|--- |--- |--- |
|`showDetailAction()`|`silversolutionsCustomerDetail`|Renders the profile detail page|
|`addressBookAction()`|`silversolutions_address_book_list`|Renders the address book (a list with delivery addresses that come from ERP)|
|`addressBookDeleteAction()`|`silversolutions_address_book_delete`|Removes the given delivery address from ERP and customer profile data|
|`logoutAction()`|`silversolutionsCustomerLogout`|Unsets all profile data within the session, logs out the user and redirects to the previous page|

## Profile detail page

![](../../img/customer_2.png)

The user can manage their profile data on this page.

The user can perform the following actions in the address list:

- update an existing delivery address
- create a new delivery address
- remove an existing delivery address

All changes in the delivery addresses will be sent to the ERP.
