# Configuration for customer data

## User Groups for private and business customers

To separate business and private users in one installation, there are two User Groups in the "Shop user" group.
You can configure those groups in shop configuration, by using `user_group_location.business` and `user_group_location.private`:

``` yaml
siso_core.default.user_group_location.business: 385
siso_core.default.user_group_location.private: 388
```

## Timeout for ERP updates

The shop checks the age of the customer data that is stored in the session.
If it is too old (past timeout), the shop fetches the data from the ERP again.

You configure the default timeout (in seconds) in `EshopBundle/Resources/config/default_values.yml`:

``` yaml
silver_customer.config.default_values.remote_validation_timeout: 600
```

## Default handling for VAT

You can define VAT handling rules in configuration.
If `isPriceInclVat` is set to `true`, the customer always sees prices including VAT.
For B2B shops, the handling can be changed.
You can override the setting per customer if required (e.g. if the ERP provides this information per customer).
In some cases, the customer does not have to pay VAT at all (for example, for shopping abroad).

``` yaml
ses.customer_profile_data.isPriceInclVat: true
# if set to false, VAT is set to 0.0
ses.customer_profile_data.setHasToPayVat: true
```

## Contact data

### Fetching customer contact data

You can configure when customer contact data is fetched:

- `onPreEvent`: contact is requested before requesting customer data
- `onPostEvent`: contact is requested after requesting customer data
- `disabled`: disable selecting contact before/after requesting customer data

``` yaml
silver_customer.config.default_values.select_contact_mode: "onPostEvent"
```

## User edit interface configuration for backend

You can add new form fields for buyer address and delivery addresses in the Back Office.
The additional fields are stored in `ses_extension` of the address.
If the configured `ses_extension` field does not exist, it is created.

``` yaml
siso_core.default.additional_buyer_ses_extension_form_fields: ['custom_field']
siso_core.default.additional_delivery_ses_extension_form_fields: ['custom_field_2']
```
