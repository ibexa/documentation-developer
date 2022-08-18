# Customer API

## Retrieving data in PHP

The following example gives access to the data available for the current user.
If the call is the first call after a login, the data is fetched automatically if the user has a customer number. 

``` php
$customer = $this->get('silver_customer.customer_service')->getCurrentCustomer();
 
// now, you can access any public method/member from the customer object, e.g.:
 
$customerNumber = $customer->getCustomerNumber();
$email = $customer->getEmail();
 
/** @var $deliveryAddresses \Ibexa\Bundle\Commerce\Eshop\Entities\Messages\Document\Party */
$deliveryAddresses = $customer->getDeliveryAddresses();
 
```

To access data from the User Content item: 

``` php
$customerProfileDataService = $this->get('Ibexa\Bundle\Commerce\Eshop\Services\CustomerProfileData\EzErpCustomerProfileDataService');
$customerProfileData = $customerProfileDataService->getCustomerProfileData();

$testfield = $customerProfileData->getDataMap()->getAttribute('ez_testfield');
```

Note that the field in `dataMap` is prefixed with `ez_`. (The Field in the User Content Type has identifier `testfield`).
