---
description: Overview of major recent additions to Ibexa DXP documentation.
---

# New in documentation

This page contains recent highlights and notable changes in Ibexa DXP documentation.

## August 2023

### New home page

- Redesigned [home page for the user documentation](https://doc.ibexa.co/projects/userguide/en/latest/)

### Administration

- [Install [[= product_name =]] with DDEV](https://doc.ibexa.co/en/master/getting_started/install_with_ddev/)
- [Update from v3.3.x to v3.3.latest](https://doc.ibexa.co/en/master/update_and_migration/from_3.3/update_from_3.3/)

### Commerce

- [Importing data](https://doc.ibexa.co/en/master/content_management/data_migration/importing_data/#commerce)
- Cart
    - [Quick order](https://doc.ibexa.co/en/master/commerce/cart/quick_order/)
- Checkout
    - [Create custom strategy](https://doc.ibexa.co/en/master/commerce/checkout/customize_checkout/#create-custom-strategy)
- Payments
    - [Implement payment method filtering](https://doc.ibexa.co/en/master/commerce/payment/payment_method_filtering/)
    - [Filter payment methods](https://doc.ibexa.co/projects/userguide/en/master/commerce/payment/work_with_payment_methods/#edit-existing-payment-method)
- Shipping
    - [Extend shipping](https://doc.ibexa.co/en/master/commerce/shipping_management/extend_shipping/)
    - [Filter shipping methods](https://doc.ibexa.co/projects/userguide/en/master/commerce/shipping_management/work_with_shipping_methods/#filter-shipping-methods)

### Online Editor

- [Add CKEditor plugins](https://doc.ibexa.co/en/master/content_management/rich_text/extend_online_editor/#add-ckeditor-plugins)

### PIM

- [Custom name schema strategy](https://doc.ibexa.co/en/master/pim/create_custom_name_schema_strategy/)
- [IsVirtual Search Criterion](https://doc.ibexa.co/en/master/search/criteria_reference/isvirtual_criterion/)

### Security

- [Hidden state clarification](https://doc.ibexa.co/en/master/infrastructure_and_maintenance/security/security_checklist/#do-not-use-hide-for-read-access-restriction)
- [Add timeouts information](https://doc.ibexa.co/en/master/infrastructure_and_maintenance/security/security_checklist/#protect-against-brute-force-attacks)

## July 2023

### v4.5.1

- [v4.5.1 release notes](https://doc.ibexa.co/en/master/release_notes/ibexa_dxp_v4.5/#v451)

### New home page

- Redesigned [home page for the developer documentation](https://doc.ibexa.co/en/latest/)

### Getting started

- New cautions in [Install on Ibexa Cloud](https://doc.ibexa.co/en/master/getting_started/install_on_ibexa_cloud/) about using `cloud.ibexa.co` instead of `platform.sh`

### Content management

- New Page block [Ibexa Connect scenario block](https://doc.ibexa.co/en/master/content_management/pages/ibexa_connect_scenario_block/)
- Updated [Create custom Page blocks](https://doc.ibexa.co/en/master/content_management/pages/create_custom_page_block/#add-block-javascript)

### Customer Portal

- Updated [Creating a Customer Portal](https://doc.ibexa.co/en/master/customer_management/cp_page_builder/)

### Personalization

- [Multiple attributes in submodel computation](https://doc.ibexa.co/en/master/personalization/api_reference/recommendation_api/#submodel-parameters)
- [Multiple attributes in submodel computation](https://doc.ibexa.co/projects/userguide/en/master/personalization/recommendation_models/#submodels) in user documentation

### PIM

- Updated [Enable purchasing products](https://doc.ibexa.co/en/master/pim/enable_purchasing_products/#region-and-currency)
- [Virtual products](https://doc.ibexa.co/en/master/pim/products/#product-types)
- [Virtual products in user documentation](https://doc.ibexa.co/projects/userguide/en/master/pim/create_virtual_product/)
- [Work with product attributes](https://doc.ibexa.co/projects/userguide/en/master/pim/work_with_product_attributes/) in user documentation

### REST API
- Added example of input payload in JSON format for [ContentTypeCreate in REST API reference](https://doc.ibexa.co/en/master/api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-create-content-type)
- [Expected user](https://doc.ibexa.co/en/master/api/rest_api/rest_api_usage/rest_requests/#expected-user) header support

### Commerce

- [Virtual products in checkout](https://doc.ibexa.co/en/master/commerce/checkout/checkout/#virtual-products-checkout)
- New Order and Shipment Search Criteria:
    - [Order Owner Criterion](https://doc.ibexa.co/en/master/search/criteria_reference/order_owner_criterion/)
    - [Shipment Owner Criterion](https://doc.ibexa.co/en/master/search/criteria_reference/shipment_owner_criterion/)

### Search

- REST API examples in multiple [existing Search Criteria descriptions](https://doc.ibexa.co/en/master/search/search_criteria_and_sort_clauses/)
- New REST API-only Search Criteria:
    - Content search:
        - [ParentLocationRemoteId Criterion](https://doc.ibexa.co/en/master/search/criteria_reference/parentlocationremoteId_criterion/)
    - Product search:
        - [AttributeGroupIdentifier Criterion](https://doc.ibexa.co/en/master/search/criteria_reference/attributegroupidentifier_criterion/)
        - [AttributeName Criterion](https://doc.ibexa.co/en/master/search/criteria_reference/attributename_criterion/)
        - [CatalogIdentifier Criterion](https://doc.ibexa.co/en/master/search/criteria_reference/catalogidentifier_criterion/)
        - [CatalogName Criterion](https://doc.ibexa.co/en/master/search/criteria_reference/catalogname_criterion/)
        - [CatalogStatus Criterion](https://doc.ibexa.co/en/master/search/criteria_reference/catalogstatus_criterion/)
        - [FloatAttributeRange Criterion](https://doc.ibexa.co/en/master/search/criteria_reference/floatattributerange_criterion/)
        - [IntegerAttributeRange Criterion](https://doc.ibexa.co/en/master/search/criteria_reference/integerattributerange_criterion/)
    
### Infrastructure and maintenance

- [Configure and customize Fastly](https://doc.ibexa.co/en/master/infrastructure_and_maintenance/cache/http_cache/fastly/)
- Updated Security checklist:
    - [Block upload of unwanted file types](https://doc.ibexa.co/en/master/infrastructure_and_maintenance/security/security_checklist/#block-upload-of-unwanted-file-types)
    - [Minimise exposure](https://doc.ibexa.co/en/master/infrastructure_and_maintenance/security/security_checklist/#minimize-exposure)

## June 2023

### Personalization

- [Email triggers](https://doc.ibexa.co/en/master/personalization/integrate_recommendation_service/#send-emails-with-recommendations)
- [Email triggers](https://doc.ibexa.co/projects/userguide/en/master/personalization/triggers/) in user documentation

### Search

- [Updated search engines documentation](https://doc.ibexa.co/en/master/search/search_engines/search_engines/):
    - [Elasticsearch search engine](https://doc.ibexa.co/en/master/search/search_engines/elastic_search/elastic_search_overview/)
    - [Solr search engine](https://doc.ibexa.co/en/master/search/search_engines/solr_search_engine/solr_overview/)
    - [Legacy search engine](https://doc.ibexa.co/en/master/search/search_engines/legacy_search_engine/legacy_search_overview/#legacy-search-engine)

### Commerce

- [Shipping methods management](https://doc.ibexa.co/projects/userguide/en/master/commerce/shipping_management/work_with_shipping_methods/) in user documentation
- [Payment methods management](https://doc.ibexa.co/projects/userguide/en/master/commerce/payment/work_with_payments/) in user documentation
- Stock Search Criteria and Aggregation:
    - [ProductStockRangeAggregation](https://doc.ibexa.co/en/master/search/aggregation_reference/productstockrange_aggregation/)
    - [ProductStock](https://doc.ibexa.co/en/master/search/criteria_reference/productstock_criterion/)
    - [ProductStockRange](https://doc.ibexa.co/en/master/search/criteria_reference/productstockrange_criterion/)

## May 2023

### v4.5

- [v4.5 release notes](https://doc.ibexa.co/en/master/release_notes/ibexa_dxp_v4.5/) and guide on how to [update to v4.5](https://doc.ibexa.co/en/master/update_and_migration/from_4.4/update_from_4.4/)

### Customer Portal

- [Corporate account company and member REST API reference](https://doc.ibexa.co/en/master/api/rest_api/rest_api_reference/rest_api_reference.html#corporate-account)
- [Creating a Customer Portal](https://doc.ibexa.co/en/master/customer_management/cp_page_builder/)

### Commerce

- [Extending payments](https://doc.ibexa.co/en/master/commerce/payment/extend_payment/)
- Reference for commerce-related events:
    - [Cart events](https://doc.ibexa.co/en/master/api/event_reference/cart_events/)
    - [Order management events](https://doc.ibexa.co/en/master/api/event_reference/order_management_events/)
    - [Payment events](https://doc.ibexa.co/en/master/api/event_reference/payment_events/)

## April 2023

### Payment

- [Payment management](https://doc.ibexa.co/en/master/commerce/payment/payment/),
including [configuring payment workflow](https://doc.ibexa.co/en/master/commerce/payment/configure_payment/),
as well as [payment](https://doc.ibexa.co/en/master/commerce/payment/payment_api/)
and [payment method PHP API](https://doc.ibexa.co/en/master/commerce/payment/payment_method_api/).

### Orders

- [Order management](https://doc.ibexa.co/en/master/commerce/order_management/order_management/),
including [configuring order workflow](https://doc.ibexa.co/en/master/commerce/order_management/configure_order_management/)
and [Orders REST API reference](https://doc.ibexa.co/en/master/api/rest_api/rest_api_reference/rest_api_reference.html#orders).

### Shipping

- [Shipping management](https://doc.ibexa.co/en/master/commerce/shipping_management/shipping_management/),
including [configuring shipment workflow](https://doc.ibexa.co/en/master/commerce/shipping_management/configure_shipment/),
as well as [shipment](https://doc.ibexa.co/en/master/commerce/shipping_management/shipment_api/)
and [shipping method PHP API](https://doc.ibexa.co/en/master/commerce/shipping_management/shipping_method_api/).

### Search

- Search Criteria and Sort Clauses covering the new commerce features:
    - Order [Search Criteria](https://doc.ibexa.co/en/master/search/criteria_reference/order_search_criteria/)
    and [Sort Clauses](https://doc.ibexa.co/en/master/search/sort_clause_reference/order_sort_clauses/)
    - Payment [Search Criteria](https://doc.ibexa.co/en/master/search/criteria_reference/payment_search_criteria/)
    and [Sort Clauses](https://doc.ibexa.co/en/master/search/sort_clause_reference/payment_sort_clauses/)
    - Payment method [Search Criteria](https://doc.ibexa.co/en/master/search/criteria_reference/payment_method_search_criteria/) 
    and [Sort Clauses](https://doc.ibexa.co/en/master/search/sort_clause_reference/payment_method_sort_clauses/)
    - Shipment [Search Criteria](https://doc.ibexa.co/en/master/search/criteria_reference/shipment_search_criteria/)
    and [Sort Clauses](https://doc.ibexa.co/en/master/search/sort_clause_reference/shipment_sort_clauses/)

### New Page blocks

- [React app Page block](https://doc.ibexa.co/en/master/content_management/pages/react_app_block/)
- [Bestsellers block](https://doc.ibexa.co/projects/userguide/en/master/content_management/block_reference/#bestsellers-block)

### Others

- [Translation comparison](https://doc.ibexa.co/projects/userguide/en/master/content_management/translate_content/#translation-comparison)
- [Managing Segments](https://doc.ibexa.co/projects/userguide/en/master/personalization/segment_management/)

## March 2023

- [Order management API](https://doc.ibexa.co/en/master/commerce/order_management/order_management_api/)
- [Customizing checkout](https://doc.ibexa.co/en/master/commerce/checkout/customize_checkout/)
- Extended [table reusable component documentation](https://doc.ibexa.co/en/master/administration/back_office/back_office_elements/reusable_components/#tables)
- How to [add GraphQL support to custom Field Types](https://doc.ibexa.co/en/master/api/graphql/graphql_custom_ft/)
- How to [customize Field Type metadata](https://doc.ibexa.co/en/master/content_management/field_types/customize_field_type_metadata/)

## February 2023

### Storefront

- [Storefront](https://doc.ibexa.co/en/master/commerce/storefront/storefront/) documentation,
including how to [configure](https://doc.ibexa.co/en/master/commerce/storefront/configure_storefront/)
and [extend Storefront](https://doc.ibexa.co/en/master/commerce/storefront/extend_storefront/).

### Cart

- [Cart](https://doc.ibexa.co/en/master/commerce/cart/cart/) documentation, including
[PHP API](https://doc.ibexa.co/en/master/commerce/cart/cart_api/).

### Checkout

- [Checkout](https://doc.ibexa.co/en/master/commerce/checkout/checkout/) documentation,
including how to [configure checkout](https://doc.ibexa.co/en/master/commerce/checkout/configure_checkout/).
Description of main [PHP API methods](https://doc.ibexa.co/en/master/commerce/checkout/checkout_api/)
as well as [checkout-related Twig functions](https://doc.ibexa.co/en/master/templating/twig_function_reference/checkout_twig_functions/).

### Other

- How to [create a Form Builder Form attribute](https://doc.ibexa.co/en/master/content_management/forms/create_form_attribute/)
- [Update guide for v4.4](https://doc.ibexa.co/en/master/update_and_migration/from_4.3/update_from_4.3/)

## January 2023

### Page Builder

- Description of new Page Builder blocks: [Catalog](https://doc.ibexa.co/projects/userguide/en/master/content_management/block_reference/#catalog-block) and [Product collection](https://doc.ibexa.co/projects/userguide/en/master/content_management/block_reference/#product-collection-block).

### Other

- [Fastly Image Optimizer](https://doc.ibexa.co/en/master/content_management/images/fastly_io/)
- [Storing Field Type settings externally](https://doc.ibexa.co/en/master/content_management/field_types/field_type_storage/#storing-field-type-settings-externally)
