# Login and registration

[[= product_name_com =]] uses [[= product_name_oss =]]'s user management functionality. Users are located in the "Users" Section.

[[= product_name_com =]] extends the user management with the following attributes:

- Customer profile data
- Customer number
- Contact number

Customer profile data is able to store additional information coming from the ERP,
such as invoice address, buyer address, delivery addresses and other customer-related information. 

Customer number and contact number are used to assign a shop user to a customer in the ERP system.

Each shop can use a special user group to separate users. It is also possible to share users between different shops.

## Important routes

- Login: `/login`
- Registration for private customers: `/register/private`
- Registration entry page: `/registration/choice`

## Login process

When a user logs in:

- The shop checks if the user has a customer number 
    - The customer data from the ERP is stored in a field in the eZ User Content item (Customer profile data). If the ERP system is not available, the shop accesses the most recent data from the ERP.
- The shop checks if the user has a contact number  
    - The contact data from the ERP is fetched and stored in Customer profile data as well.

When the data is stored in the ERP, the shop takes care of the versions created by [[= product_name_oss =]].
[[= product_name_oss =]] limits the number of versions created per Content item.
The shop uses a setting to limit the number of versions (`silver_tools.default.versions_count: 10`) and removes the archived versions.
If the number of versions to be removed exceeds 20, only 20 versions are removed to ensure the login process does not take too much time (and lead to a timeout). 

## Login

[[= product_name_com =]] provides a flexible login functionality. A user can log in to the shop with a username or email and a password.
Additionally, you can add a field "customer number", which is required for logging into the customer center.

The methods `retrieveUser()` and `checkAuthentication()` of `AuthenticationProvider` are overriden to provide the login functionality.

The logic for searching for a user is:

- Determined by the Location ID, which is configured per SiteAccess (`siso_core.default.user_group_location`).
- Checks if a User with the given email address is stored under the configured Location.
The search looks in subfolders such as business, private or editors.

## Registration options

[[= product_name_com =]] provides different options for users to register in the shop. 

There are different registration forms for different target groups, such as private or business customers.

### Private customer

A private customer can register directly.

A double opt-in process checks the email address, creates and activates the user.

### Business customer

A business customer has two options to register:

1. Apply for new account - fill the business form and apply for an account.   

The shop owner checks the provided data and creates a customer record in the ERP system.

1. Activate account - a business customer who already has a customer number can register using a customer number and an invoice number.

The shop checks this data by sending a request to the ERP. There are two options:

- activate business account - the customer is created using their customer number and can immediately see their special discounts in the shop.
- create the main contact in Customer Center - if Customer Center is enabled, the company is created in the shop, and the account is created as the main contact.  

The forms and the processes behind the forms can be customized.

## Technical information

### Access control

For more information about security, see [Access control](../user_management/access_control.md).

### Token

For more information about using the Token system offered by Symfony, see [TokenController](../user_management/token/tokencontroller.md).
