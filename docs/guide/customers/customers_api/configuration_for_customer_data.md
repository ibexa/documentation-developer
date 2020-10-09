# Configuration for customer data

## User Groups for private and business customers

To separate business and private users in one installation, there are two User Groups in the "Shop user" group.
You can configure those groups using `user_group_location.business` and `user_group_location.private`
in `app/config/ecommerce_parameters.yml`:

``` yaml
siso_core.default.user_group_location.business: 385
siso_core.default.user_group_location.private: 388
```

## Timeout for ERP updates

The shop checks the age of the customer data that is stored in the session.
If it is too old (past timeout) the shop fetches the data from the ERP again.

The default timeout is configured in `EshopBundle/Resources/config/default_values.yml`:

``` yaml
# the timeout in seconds, how long the remote data is valid (default 600s = 10m)
silver_customer.config.default_values.remote_validation_timeout: 600
```

## Default handling for VAT

You can define VAT handling rules in configuration.
If `isPriceInclVat` is set to `true`, the customer always sees prices including VAT.
For B2B shops, the handling can be changed.
You can override the setting per customer if required (e.g. if the ERP provides this information per customer).
In some cases the customer does not have to pay VAT at all (for example, for shopping abroad).

``` yaml
ses.customer_profile_data.isPriceInclVat: true
# if set to false, VAT is set to 0.0
ses.customer_profile_data.setHasToPayVat: true
```

## Working with contact data

### Fetching of the customer contact data

You can configure when customer contact data is fetched:

- `onPreEvent`: contact is requested before requesting customer data
- `onPostEvent`: contact is requested after requesting customer data
- `disabled`: disable selecting contact before/after requesting customer data 

``` yaml
silver_customer.config.default_values.select_contact_mode: "onPostEvent"
```

##### Set up the contact number

Set the contact number in the Back Office, in the `contact_number` Field of a User Content item,
for example:

**Contact number:** KT100210

### Connecting to the events

To take advantage of existing events, for example to modify customer contact data,
an `EventService` must listen to the `ses_ez_erp_customer_pre_remote_data` and `ses_ez_erp_customer_post_remote_data` events:

``` xml
<service id="silver_customer.customer_event_service" class="%silver_customer.customer_event_service.class%">
            <tag name="kernel.event_listener" event="ses_ez_erp_customer_pre_remote_data" method="onPreRemoteData" />
            <tag name="kernel.event_listener" event="ses_ez_erp_customer_post_remote_data" method="onPostRemoteData" />           
</service>
```

You also have to implement appropriate methods:

``` php
/**
     * Gives the opportunity to modify the customer via $customerEvent->getCustomer()
     * before retrieving the customer data form ERP
     * @param AbstractCustomerEvent $customerEvent
     */
    public function onPreRemoteData(AbstractCustomerEvent $customerEvent)
    {
        if ($this->selectContactOptions['onPreEvent']) {
            $this->setContactData($customerEvent);
        }
    }
    /**
     * Gives the opportunity to modify the customer via $customerEvent->getCustomer()
     * after retrieving the customer data form ERP
     * @param AbstractCustomerEvent $customerEvent
     */
    public function onPostRemoteData(AbstractCustomerEvent $customerEvent)
    {
        if ($this->selectContactOptions['onPostEvent']) {
            $this->setContactData($customerEvent);
        }
    }
```

## User edit interface configuration for backend

You can add new form fields for buyer address and delivery addresses in the Back Office.
The additional fields are stored in `ses_extension` of the address.
If the configured `ses_extension` field does not exist, it is created.

Default configuration:

``` yaml
siso_core.default.additional_buyer_ses_extension_form_fields: []
siso_core.default.additional_delivery_ses_extension_form_fields: []
```
