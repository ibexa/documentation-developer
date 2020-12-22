# Adapt the mappings for ERP functions [[% include 'snippets/experience_badge.md' %]]

[[= product_name_exp =]] uses a flexible way to map the request and response between the shop and the ERP system.

By default [[= product_name_exp =]] comes with a prepared mapping stored in the vendor bundle.
The mappings can be extended in your project bundles.

Your bundle has to be registered as a mapping bundle:

``` yaml
siso_erp.default.mapping_bundles:
    - 'MyProjectBundle'
    - 'SilversolutionsEshopBundle'
```

For each ERP message a mapping can be defined. In the following example the mapping identifier is `createorder`:

``` yaml
siso_erp.default.message_settings.createsalesorder:
    message_class: "Silversolutions\\Bundle\\EshopBundle\\Entities\\Messages\\CreateSalesOrderMessage"
    response_document_class: "\\Silversolutions\\Bundle\\EshopBundle\\Entities\\Messages\\Document\\OrderResponse"
    webservice_operation: "SV_OPENTRANS_CREATE_ORDER"
    mapping_identifier: "createorder"
```

The mapping files are using xslt and are located in `EshopBundle/Resources/mapping/wc3-nav/xsl`.
The folder `wc3-nav` can be configured in order to support different mappings in one installation (`siso_erp.default.target_code: 'wc3-nav'`).

The responsible mappings files for the `createorder` message are:

- `request.createorder.xsl`
- `response.createorder.xsl`

If you want to override the mapping, create the mapping files in your bundle structure:

- `MyBundle/Resources/mapping/wc3-nav/`

See [Create a standard message (UpdateCustomer)](../../guides/creating_a_new_erp_message/create_standard_message.md) to learn how to adapt the mapping using xslt.
