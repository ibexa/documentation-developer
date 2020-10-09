# Customer profile data events

## CustomerProfileDataEventInterface

`CustomerProfileDataEventInterface` (`Silversolutions\Bundle\EshopBundle\Event\CustomerProfileData\CustomerProfileDataEventInterface`)
is the general interface for any event that is thrown in customer profile data services.

## AbstractCustomerProfileDataEvent

`AbstractCustomerProfileDataEvent` (`Silversolutions\Bundle\EshopBundle\Event\CustomerProfileData\AbstractCustomerProfileDataEvent`)
is the abstract event for any customer profile data event and helper methods like `setCustomerProfileData()` to make a profile available for an event listener.

## EzErpCustomerProfileDataEvent

`EzErpCustomerProfileDataEvent` (`\Silversolutions\Bundle\EshopBundle\Event\CustomerProfileData\EzErpCustomerProfileDataEvent`)
is the concrete event which also provides the User Content item, for example for fallback purposes when the ERP does not respond
(see [Customer profile data listeners](customer_profile_data_listeners.md)).

The following events are dispatched by `Silversolutions\Bundle\EshopBundle\Services\CustomerProfileData\EzErpCustomerProfileDataService`:

|Event ID|Description|
|--- |--- |
|`ses_ez_erp_customer_profile_data_pre_fetch`|Thrown before any data is fetched from storage|
|`ses_ez_erp_customer_profile_data_post_fetch`|Thrown after all data is fetched from storage|
|`ses_ez_erp_customer_profile_data_pre_erp_customer_fetch`|Thrown before ERP customer data is fetched|
|`ses_ez_erp_customer_profile_data_post_erp_customer_fetch_success`|Thrown after ERP customer data is successfully fetched|
|`ses_ez_erp_customer_profile_data_post_erp_customer_fetch_fail`|Thrown after ERP customer data fetching failed|
|`ses_ez_erp_customer_profile_data_pre_erp_contact_fetch`|Thrown before ERP contact data is fetched|
|`ses_ez_erp_customer_profile_data_post_erp_contact_fetch_success`|Thrown after ERP contact data fetching successed|
|`ses_ez_erp_customer_profile_data_post_erp_contact_fetch_fail`|Thrown after ERP contact data fetching failed|
|`ses_ez_erp_customer_profile_data_pre_get_customer`|Thrown before customer data is returned|
|`ses_ez_erp_customer_profile_data_pre_save_customer`|Thrown before customer data is saved|
