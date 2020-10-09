# Customers API

## Retrieving data in PHP

The following example gives access to the data available for the current user.
If the call is the first call after a login, the data from the ERP is fetched automatically if the user has a customer number. 

``` php
$customer = $this->get('silver_customer.customer_service')->getCurrentCustomer();
 
// now, you can access any public method/member from the customer object, e.g.:
 
$customerNumber = $customer->getCustomerNumber();
$email = $customer->getEmail();
 
/** @var $deliveryAddresses \Silversolutions\Bundle\EshopBundle\Entities\Messages\Document\Party */
$deliveryAddresses = $customer->getDeliveryAddresses();
 
```

If the ERP provides further information, you can find it in the `SesExtension` attribute:

``` php
$postingGroup = $deliveryAddresses[0]->SesExtension->value['CustomerPostingGroup'];
```

To access data from the User Content item: 

``` php
$customerProfileDataService = $this->get('ses.customer_profile_data.ez_erp');
$customerProfileData = $customerProfileDataService->getCustomerProfileData();

$testfield = $customerProfileData->getDataMap()->getAttribute('ez_testfield');
```

Note that the field in `dataMap` is prefixed with `ez_`. (The Field in the User Content Type has identifier `testfield`).

### Request a customer by number from the ERP

``` php
$erpService = $this->getContainer()->get('silver_erp.facade');
$selectCustomerResponse = $erpService->selectCustomer($no);
```
