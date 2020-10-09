# Customer profile data listeners

## ListenerInterface

`ListenerInterface` (`Silversolutions\Bundle\EshopBundle\EventListener\CustomerProfileData\ListenerInterface`)
defines the methods that all listeners must have (e.g. `onPreFetch()`, `onPostFetch()` events).

## EzErpListener

`EzErpListener` (`Silversolutions\Bundle\EshopBundle\EventListener\CustomerProfileData\EzErpListener`)
is the concrete event listener implementation. It provides ERP-related listeners, e.g. for ERP response success or fail.

- `onPostErpCustomerFetchFail()` loads customer data from the respective User Content item if it cannot be retrieved from the ERP.
Event: `ses_ez_erp_customer_profile_data_post_erp_customer_fetch_fail`
- `onPreFetch()` has no implementation
- `onPostFetch()` has no implementation
