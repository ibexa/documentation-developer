---
description: Overview of major recent additions to Ibexa DXP documentation.
month_change: true
---

# New in documentation

This page contains recent highlights and notable changes in [[= product_name =]] documentation.

## April 2025

### Content management

- Introduced a [custom DAM connector example](add_image_asset_from_dam.md#extend-dam-support-by-adding-custom-connector)
- Added [grace period definition and configuration](repository_configuration.md#grace-period-for-archived-versions)

### AI Actions

- Documented [how to couple AI Actions and Ibexa Connect](configure_ai_actions.md#configure-access-to-ibexa-connect) to build complex data transformation workflows without having to rely on custom code

### REST API

- Added [`/cart/{identifier}/summary` REST resource's `ShortCartSummary` response format](/api/rest_api/rest_api_reference/rest_api_reference.html#managing-commerce-carts-cart-summary)

### Infrastructure and maintenance

- Announced [v4.6.19 release notes](ibexa_dxp_v4.6.md#ibexa-dxp-v4619) and [v4.6.19 upgrade instructions](update_from_4.6.md#v4619) with an important security notice about RichText XML, and introducing [Ibexa Rector](update_from_4.6.md#ibexa-rector) to help to maintain custom code

## March 2025

### Release notes

- Redesigned [Release notes page](https://doc.ibexa.co/en/latest/release_notes/ibexa_dxp_v4.6/) now includes filters to easily sort by product edition or LTS update type, while the updated documentation homepage provides quick access to essential details, showcasing changes introduced in the latest patch and LTS Updates releases

### Requirements update

- Updated [requirements](https://doc.ibexa.co/en/latest/getting_started/requirements/#operating-system) for [[= product_name =]]: RHEL 9.5 and CentOS Stream 9 are now supported for v4.6

### AI Actions

- Specified minimum [[= product_name =]] version supported while working with AI Actions
    - AI Actions product guide: [Availability](https://doc.ibexa.co/en/latest/ai_actions/ai_actions_guide/#availability)
    - AI Actions section: [Install AI Actions](https://doc.ibexa.co/en/latest/ai_actions/install_ai_actions/)

### Online Editor

- Added an example in the Online Editor documentation showing how to [add characters and shortcuts for specific characters to the SpecialCharacters plugin in CKEditor configuration](https://doc.ibexa.co/en/latest/content_management/rich_text/extend_online_editor/#change-ckeditor-configuration)

### Templating

- Updated a description of the [`ibexa_render`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/content_twig_functions/#content-rendering) Twig function to mention its support for objects implementing the [`ContentAwareInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentAwareInterface.html) as argument

## February 2025

### Security

- Expanded security recommendations to follow when working with [images submitted by users](https://doc.ibexa.co/en/latest/content_management/images/images/#configuring-image-variations)

### Date and time attributes

- Added documentation for the latest LTS Update: [Date and time attributes](https://doc.ibexa.co/en/latest/pim/attributes/date_and_time/)

### Automated Translation

- Added information about how you can install and extend the [Automated Translation](https://doc.ibexa.co/en/latest/multisite/languages/automated_translations/) feature

### Interactive demos

- Updated [Form Builder](https://doc.ibexa.co/en/latest/content_management/forms/form_builder_guide/#how-does-form-builder-work), [Page Builder](https://doc.ibexa.co/en/latest/content_management/pages/page_builder_guide/#create-page), and [Online Editor](https://doc.ibexa.co/en/latest/content_management/rich_text/online_editor_guide/) product guides by addng interactive demos that present these features

### Page Builder clipboard

- Described how you can use the [Page Builder's clipboard](https://doc.ibexa.co/projects/userguide/en/latest/content_management/create_edit_pages/#copy-blocks) to copy blocks between pages

### REST API

- Described endpoints for [Segment](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_reference/rest_api_reference.html#segments) and [Segment Group](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_reference/rest_api_reference.html#segment-groups) management
- Described endpoints for [AI Action Configurations](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_reference/rest_api_reference.html#ai-actions-list-action-configurations) and [AI Action Types](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_reference/rest_api_reference.html#ai-actions-list-action-types)
- Improved the example for [creating Orders](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_reference/rest_api_reference.html#orders-create-order), to show how to pass shipping cost data

### HTTP Cache

- Improved the VCL snippet to cache the first ESI request when [using Basic Auth with Fastly](https://doc.ibexa.co/en/latest/infrastructure_and_maintenance/cache/http_cache/fastly/#enable-basic-auth-on-fastly)

### Search

- Expanded the lists of [search criteria](https://doc.ibexa.co/en/latest/search/criteria_reference/search_criteria_reference/) and [sort clauses](https://doc.ibexa.co/en/latest/search/sort_clause_reference/sort_clause_reference/) to show their support for [searching in Trash](https://doc.ibexa.co/en/latest/search/search_in_trash_reference/)

### Templating

- Added the [icon reference](https://doc.ibexa.co/en/latest/templating/twig_function_reference/icon_twig_functions/#icons-reference) that lists all the icons you can use when extending the back office
- Updated descriptions of the following Twig functions to mention their support for objects implementing the [`ContentAwareInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-ContentAwareInterface.html) as arguments:
    - [`ibexa_content_field_identifier_first_filled_image`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/image_twig_functions/#ibexa_content_field_identifier_first_filled_image)
    - [`ibexa_content_name`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/content_twig_functions/#ibexa_content_name)
    - [`ibexa_field_is_empty`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/field_twig_functions/#ibexa_field_is_empty)
    - [`ibexa_field_description`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/field_twig_functions/#ibexa_field_description)
    - [`ibexa_field_name`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/field_twig_functions/#ibexa_field_name)
    - [`ibexa_field_value`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/field_twig_functions/#ibexa_field_value)
    - [`ibexa_field`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/field_twig_functions/#ibexa_field)
    - [`ibexa_has_field`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/field_twig_functions/#ibexa_has_field)
    - [`ibexa_render_field`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/field_twig_functions/#field-rendering)
    - [`ibexa_seo_is_empty`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/content_twig_functions/#ibexa_content_name)
    - [`ibexa_seo`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/content_twig_functions/#ibexa_seo_is_empty)
    - [`ibexa_taxonomy_entries_for_content`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/content_twig_functions/#ibexa_seo)
- Described new Twig filter for product attributes grouping: [`ibexa_product_catalog_group_attributes`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/product_twig_functions/#ibexa_product_catalog_group_attributes)

### DDEV

- Described how you can use the [Ibexa Cloud addons](https://doc.ibexa.co/en/latest/ibexa_cloud/ddev_and_ibexa_cloud/#with-ibexa-cloud-add-ons) when working with [[= product_name_cloud =]] projects

### [[= product_name_cloud =]]

- Described how to [set up Composer authentication](https://doc.ibexa.co/en/latest/ibexa_cloud/install_on_ibexa_cloud/#composer-authentication-using-the-web-console) when creating an [[= product_name_cloud =]] project

#### PHP API

Enhanced the PHP API with the following new classes and interfaces:

- `Ibexa\Contracts\Cart`:
    - [`Value\Query\Criterion\LogicalAnd`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-Value-Query-Criterion-LogicalAnd.html)
    - [`Value\Query\Criterion\OwnerCriterion`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-Value-Query-Criterion-OwnerCriterion.html)
    - [`Value\Query\CriterionInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-Value-Query-CriterionInterface.html)
- `Ibexa\Contracts\Segmentation`:
    - [`Exception\ValidationFailedExceptionInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Segmentation-Exception-ValidationFailedExceptionInterface.html)
- `Ibexa\Contracts\ProductCatalog`:
    - [`Iterator\BatchIteratorAdapter\RegionFetchAdapter`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Iterator-BatchIteratorAdapter-RegionFetchAdapter.html)
- `Ibexa\Contracts\Connect`:
    - [`ConnectClientInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-ConnectClientInterface.html)
    - [`Exception\BadResponseException`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Exception-BadResponseException.html)
    - [`Exception\UnserializablePayload`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Exception-UnserializablePayload.html)
    - [`Exception\UnserializableResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Exception-UnserializableResponse.html)
    - [`PaginationInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-PaginationInterface.html)
    - [`Resource\DataStructure\DataStructureBuilder`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-DataStructure-DataStructureBuilder.html)
    - [`Resource\DataStructure\DataStructureCreateStruct`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-DataStructure-DataStructureCreateStruct.html)
    - [`Resource\DataStructure\DataStructureFilter`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-DataStructure-DataStructureFilter.html)
    - [`Resource\DataStructure\DataStructureProperty`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-DataStructure-DataStructureProperty.html)
    - [`Resource\DataStructure\DataStructurePropertyType`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-DataStructure-DataStructurePropertyType.html)
    - [`Resource\DataStructureInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-DataStructureInterface.html)
    - [`Resource\Hook\HookCreateStruct`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-Hook-HookCreateStruct.html)
    - [`Resource\Hook\HookFilter`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-Hook-HookFilter.html)
    - [`Resource\Hook\HookSetDetailsStruct`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-Hook-HookSetDetailsStruct.html)
    - [`Resource\HookInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-HookInterface.html)
    - [`Resource\Scenario\ScenarioCreateStruct`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-Scenario-ScenarioCreateStruct.html)
    - [`Resource\Scenario\ScenarioFilter`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-Scenario-ScenarioFilter.html)
    - [`Resource\ScenarioInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-ScenarioInterface.html)
    - [`Resource\Team\TeamVariableCreateStruct`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-Team-TeamVariableCreateStruct.html)
    - [`Resource\Team\TeamVariableFilter`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-Team-TeamVariableFilter.html)
    - [`Resource\Team\TeamVariableUpdateStruct`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-Team-TeamVariableUpdateStruct.html)
    - [`Resource\TeamInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-TeamInterface.html)
    - [`Resource\Template\TemplateCreateStruct`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-Template-TemplateCreateStruct.html)
    - [`Resource\Template\TemplateFilter`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-Template-TemplateFilter.html)
    - [`Resource\TemplateInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Resource-TemplateInterface.html)
    - [`Response\DataStructure\CreateResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-DataStructure-CreateResponse.html)
    - [`Response\DataStructure\ListResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-DataStructure-ListResponse.html)
    - [`Response\DataStructure\RetrieveResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-DataStructure-RetrieveResponse.html)
    - [`Response\Hook\CreateResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Hook-CreateResponse.html)
    - [`Response\Hook\ListResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Hook-ListResponse.html)
    - [`Response\Hook\RetrieveResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Hook-RetrieveResponse.html)
    - [`Response\Hook\SetDetailsResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Hook-SetDetailsResponse.html)
    - [`Response\Scenario\CreateResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Scenario-CreateResponse.html)
    - [`Response\Scenario\ListResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Scenario-ListResponse.html)
    - [`Response\Scenario\RetrieveResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Scenario-RetrieveResponse.html)
    - [`Response\Team\TeamVariableCreateResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Team-TeamVariableCreateResponse.html)
    - [`Response\Team\TeamVariableListResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Team-TeamVariableListResponse.html)
    - [`Response\Team\TeamVariableRetrieveResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Team-TeamVariableRetrieveResponse.html)
    - [`Response\Team\TeamVariableUpdateResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Team-TeamVariableUpdateResponse.html)
    - [`Response\Template\BlueprintResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Template-BlueprintResponse.html)
    - [`Response\Template\CreateResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Template-CreateResponse.html)
    - [`Response\Template\ListResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Template-ListResponse.html)
    - [`Response\Template\RetrieveResponse`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Response-Template-RetrieveResponse.html)
    - [`ResponseInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-ResponseInterface.html)
    - [`TransportInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-TransportInterface.html)
    - [`Value\Blueprint\Flow`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Value-Blueprint-Flow.html)
    - [`Value\Blueprint\Metadata\Scenario`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Value-Blueprint-Metadata-Scenario.html)
    - [`Value\Blueprint\Metadata`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Value-Blueprint-Metadata.html)
    - [`Value\Blueprint\Module\CustomWebhook`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Value-Blueprint-Module-CustomWebhook.html)
    - [`Value\Blueprint\Module\JsonCreate`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Value-Blueprint-Module-JsonCreate.html)
    - [`Value\Blueprint\Module\ModuleDesigner`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Value-Blueprint-Module-ModuleDesigner.html)
    - [`Value\Blueprint\Module\WebhookRespond`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Value-Blueprint-Module-WebhookRespond.html)
    - [`Value\Blueprint`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Value-Blueprint.html)
    - [`Value\Controller`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Value-Controller.html)
    - [`Value\Scheduling`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Connect-Value-Scheduling.html)

## January 2025

### Trainings

- The Content Editor Training has been released. Learn more in the [annoucement blogpost](https://www.ibexa.co/blog/constant-development-is-key-so-here-s-a-new-training-for-content-editors)

### Infrastructure and maintenance

- The upgrade instructions from v3.3 to v4.6 have been expanded with a section describing the [GraphQL changes in v4](https://doc.ibexa.co/en/latest/update_and_migration/from_3.3/to_4.0/#graphql)
- Ubuntu 24.04 has been added to the [list of officialy supported operating systems](https://doc.ibexa.co/en/latest/getting_started/requirements/#operating-system)

### PHP API

- Added the following interfaces and classes to the public PHP API:
    - [`Ibexa\Contracts\AdminUi\Permission\PermissionCheckContextProviderInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-AdminUi-Permission-PermissionCheckContextProviderInterface.html)
    - [`Ibexa\Contracts\AdminUi\Values\PermissionCheckContext`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-AdminUi-Values-PermissionCheckContext.html)
    - [`Ibexa\Contracts\Checkout\Discounts\DataMapper\DiscountsDataMapperInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Checkout-Discounts-DataMapper-DiscountsDataMapperInterface.html)
    - [`Ibexa\Contracts\Seo\Resolver\FieldValueResolverInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Seo-Resolver-FieldValueResolverInterface.html)

## December 2024

### Infrastructure and maintenance

- Added [v4.6.14 to v4.6.15 update instructions](https://doc.ibexa.co/en/latest/update_and_migration/from_4.6/update_from_4.6/#v4615)

## AI Actions

- Added [extending AI Actions](extend_ai_actions.md) documentation

### Security

- Expanded the [Security checklist](security_checklist.md) with advice on TLS, HSTS, DNSSEC, CAA, and domain update protection

### PHP API

- Added the following interfaces to the public PHP API:
    - [`Ibexa\Contracts\ProductCatalog\Values\Price\PriceEnvelopeInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Price-PriceEnvelopeInterface.html)
    - [`Ibexa\Contracts\ProductCatalog\Values\Price\PriceStampInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Price-PriceStampInterface.html)
    - [`Ibexa\Contracts\ProductCatalog\Values\StampInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-StampInterface.html)

## November 2024

### Infrastructure and maintenance

- Added [v4.6.13 to v4.6.14 update instructions](https://doc.ibexa.co/en/latest/update_and_migration/from_4.6/update_from_4.6/#v4614) which include security fixes
- Added [v3.3.40 to v3.3.41 update instructions](https://doc.ibexa.co/en/latest/update_and_migration/from_3.3/update_from_3.3/#v3341) which include security fixes

### Content management

- Added [AI Actions documentation](https://doc.ibexa.co/en/latest/ai_actions/ai_actions/)

### Search

- New [`IsBookmarked` location criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/isbookmarked_criterion/)
- [`IsUserEnabled` is now available on Solr and Elastisearch](https://doc.ibexa.co/en/latest/search/criteria_reference/isuserenabled_criterion/)

### Documentation

- When you search using the top bar, if there are more than the 10 listed results, you can see a link to a page with further results at the bottom of the drop-down suggestion list

### PHP API

- Added the following namespaces, interfaces, and classes to the public PHP API:
    - [`Ibexa\Contracts\Core\Validation`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-validation.html) namespace and its descendants
    - [`Ibexa\Contracts\Notifications\SystemNotification`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/namespaces/ibexa-contracts-notifications-systemnotification.html) namespace and its descendants
    - [`Ibexa\Contracts\Notifications\Value\Recipent\UserRecipientInterface`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Notifications-Value-Recipent-UserRecipientInterface.html)
    - [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\UpdatedAt`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-Criterion-UpdatedAt.html)
    - [`Ibexa\Contracts\ProductCatalog\Values\Product\Query\Criterion\UpdatedAtRange`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Values-Product-Query-Criterion-UpdatedAtRange.html)
    - [`Ibexa\Contracts\ProductCatalog\ProductReferencesResolverStrategy`](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-ProductReferencesResolverStrategy.html)

## October 2024

### Content management

- Added a caution at the end of the [Create custom Page block](https://doc.ibexa.co/en/latest/content_management/pages/create_custom_page_block/#add-edit-template) article
- Added `add_block_to_available_blocks` to a [list of available data migration actions](https://doc.ibexa.co/en/latest/content_management/data_migration/data_migration_actions/#available-migration-actions)

### Infrastructure and maintenance

- Updated the [reverse proxy configuration instructions](https://doc.ibexa.co/en/latest/infrastructure_and_maintenance/cache/http_cache/reverse_proxy/#varnish-and-basic-auth) by mentioning Basic Auth setup for Varnish
- Reorganized the [Updating Ibexa DXP](https://doc.ibexa.co/en/latest/update_and_migration/update_ibexa_dxp/) section to put information in logical order and remove duplicates
- [Added v4.6.11 to v4.6.12 update instructions](https://doc.ibexa.co/en/latest/update_and_migration/from_4.6/update_from_4.6/#v4612)
- [Added v4.6.12 to v4.6.13 update instructions](https://doc.ibexa.co/en/latest/update_and_migration/from_4.6/update_from_4.6/#v4613) mentioning a command to clean up duplicated entries in the `ezcontentobject_attribute` table
- Changed the [Update to v3.3](https://doc.ibexa.co/en/latest/update_and_migration/from_2.5/to_3.3/#b-update-the-app) instructions to help avoid an error at `composer update` stage
- Changed the instructions by adding a requirement to handle the [[= product_name_cloud =]] configuration:
    - [Update to v4.0](https://doc.ibexa.co/en/latest/update_and_migration/from_3.3/to_4.0/#ibexa-cloud)
    - [Update to v3.3.latest](https://doc.ibexa.co/en/latest/update_and_migration/from_3.3/update_from_3.3/#v3313)
- Added a suggestion to [remove obsolete database tables](https://doc.ibexa.co/en/latest/update_and_migration/from_4.3/update_from_4.3_new_commerce/#update-the-database) that were used by a legacy Commerce package

## Personalization

- Added dynamic attribute submodels information by:
    - mentioning them in [customizing the recommendation request](https://doc.ibexa.co/en/latest/personalization/api_reference/recommendation_api/#customizing-the-recommendation-request) instructions
    - describing them in [user documentation](https://doc.ibexa.co/projects/userguide/en/latest/personalization/recommendation_models/#dynamic-attributes)
- Added time-slot based models information by:
    - changing the list of parameters available when [customizing the recommendation request](https://doc.ibexa.co/en/latest/personalization/api_reference/recommendation_api/#customizing-the-recommendation-request)
    - describing them in [user documentation](https://doc.ibexa.co/projects/userguide/en/latest/personalization/recommendation_models/#time-slot-based-models)

- Updated configuration details (including endpoint addresses and code examples) in multiple how-to articles:
    - [Enable Personalization ](https://doc.ibexa.co/en/latest/personalization/enable_personalization/)
    - [Integrate recommendation service](https://doc.ibexa.co/en/latest/personalization/integrate_recommendation_service/)
    - [Tracking integration](https://doc.ibexa.co/en/latest/personalization/tracking_integration/)
    - [Track events with ibexa-tracker.js](https://doc.ibexa.co/en/latest/personalization/tracking_with_ibexa-tracker/)

### PIM

- Updated the [Product API](https://doc.ibexa.co/en/latest/pim/product_api/) article by fixing method signatures and adding links to the PHP API reference

### PHP API

- Added the following new classes to the public PHP API:
    - [Ibexa\Contracts\AdminUi\Menu](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/namespaces/ibexa-contracts-adminui-menu.html)
    - [Ibexa\Contracts\Core\Pool](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-pool.html)
    - [Ibexa\Contracts\CoreSearch\Values\Query](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/namespaces/ibexa-contracts-coresearch-values-query.html)
    - [Ibexa\Contracts\ProductCatalog\Local\Attribute\ContextAwareValueValidatorInterface](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-ProductCatalog-Local-Attribute-ContextAwareValueValidatorInterface.html)

### REST API

- Updated the [REST API authentication](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_authentication/) instructions

## September 2024

### Getting started

- Updated product version requirements and database connection configuration instructions in [Install Ibexa DXP with DDEV](https://doc.ibexa.co/en/latest/getting_started/install_with_ddev/#2-configure-ddev)

### Infrastructure and maintenance

- Modified v4.5.x to v4.6 update instructions by adding [Update Solr configuration](https://doc.ibexa.co/en/latest/update_and_migration/from_4.5/update_from_4.5/#update-solr-configuration) section
- Added [v4.6.8 to v4.6.11 update instructions](https://doc.ibexa.co/en/latest/update_and_migration/from_4.6/update_from_4.6/#v4611)

### PHP API

- Added edition information to [PHP API reference](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/) to aid navigation

### REST API
- Removed multiple obsolete RAML types from the [REST API reference](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_reference/rest_api_reference.html)

### User management

- Updated the OAuth server [installation instructions](https://doc.ibexa.co/en/latest/users/oauth_server/#server-installation)

## August 2024

### Product guides

- [[[= product_name_exp =]] product guide](https://doc.ibexa.co/en/latest/ibexa_products/ibexa_experience/)
- [[[= product_name_com =]] product guide](https://doc.ibexa.co/en/latest/ibexa_products/ibexa_commerce/)
- Added [page collecting all feature product guides](https://doc.ibexa.co/en/latest/product_guides/product_guides/)

### Content management

- Added how to [hide a taxonomy menu item](https://doc.ibexa.co/en/latest/content_management/taxonomy/taxonomy/#hide-menu-item)

### Data migration

- Added a note about [multi-repository and dynamic migration folders](https://doc.ibexa.co/en/latest/content_management/data_migration/managing_migrations/#migration-folders)

## July 2024

### Getting started

- Added instructions in [Install [[= product_name =]]](https://doc.ibexa.co/en/latest/getting_started/install_ibexa_dxp/#create-project) about using PHP 8.3 to create a project
- Updated the [requirements for running v3.3.x on PHP 8.3](https://doc.ibexa.co/en/latest/getting_started/requirements/#php)

### Infrastructure and maintenance

- Added [v4.6.4 to v4.6.8 update instructions](https://doc.ibexa.co/en/latest/update_and_migration/from_4.5/update_from_4.5/#v468)
- Modified [v3.3.x to v3.3.latest update instructions](https://doc.ibexa.co/en/latest/update_and_migration/from_3.3/update_from_3.3/#update-the-application)
- Updated the recommendations in [Performance](https://doc.ibexa.co/en/latest/infrastructure_and_maintenance/performance/#symfony) by mentioning Symfony

### Data migration

- Added a note about multi-repository scenario in [Managing migration](https://doc.ibexa.co/en/latest/content_management/data_migration/managing_migrations/#migration-folders)
- Updated the instructions for [Importing data](https://doc.ibexa.co/en/latest/content_management/data_migration/importing_data/#built-in-functions) by mentioning the `env` function and a possibility of swapping content items assigned to a location

### [[= product_name_cloud =]]

- Placed all articles about [[= product_name_cloud =]] [in a common location](https://doc.ibexa.co/en/latest/ibexa_cloud/ibexa_cloud/)

### [[= product_name_engage =]]

- [Added a landing page in the [[= product_name_engage =]] area](https://doc.ibexa.co/en/latest/ibexa_engage/ibexa_engage/)

### Product guides

- [[[= product_name_cloud =]] product guide](https://doc.ibexa.co/en/latest/ibexa_cloud/ibexa_cloud_guide/)

## June 2024

### [[= product_name_engage =]]

- [Learn more about [[= product_name_engage =]]](https://doc.ibexa.co/en/latest/ibexa_engage/install_ibexa_engage/)

### Search

- [Configuring Elasticsearch with analyzers for different languages](https://doc.ibexa.co/en/latest/search/search_engines/elasticsearch/configure_elasticsearch/#add-language-specific-analysers)
- [ContentName search criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/contentname_criterion/)

### Dashboard

- [Customizing the content type for Dashboard container](https://doc.ibexa.co/en/latest/administration/dashboard/configure_default_dashboard/#container-content-type-identifier)

### Infrastructure and maintenance

- [Updated [[= product_name_cloud =]] domain to ibexa.cloud](https://doc.ibexa.co/en/latest/getting_started/install_on_ibexa_cloud/#4-push-the-project)
- [v4.6.3 to v4.6.4 update instructions](https://doc.ibexa.co/en/latest/update_and_migration/from_4.5/update_from_4.5/#v464)

### Documentation

- A "new" pill now appears in the table of content alongside pages which have been recently created, or have recent important updates or additions

## May 2024

### PHP API

- [PHP API Reference](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/)

### Users

- [Warning about recent activity log and user privacy](https://doc.ibexa.co/en/latest/administration/recent_activity/recent_activity/#user-privacy)

## April 2024

### Product guides

- [[[= product_name_cdp =]] product guide](https://doc.ibexa.co/en/latest/cdp/cdp_guide/)

### Infrastructure and maintenance

- [v4.6.0 to v4.6.3 update instructions](https://doc.ibexa.co/en/latest/update_and_migration/from_4.5/update_from_4.5/#v463)

### Users

- [Recent activity](https://doc.ibexa.co/en/latest/administration/recent_activity/recent_activity/)
- [OAuth server](https://doc.ibexa.co/en/latest/users/oauth_server/)
- Updated [OAuth client](https://doc.ibexa.co/en/latest/users/oauth_client/)

### Back office

- [Customize back office search suggestions](https://doc.ibexa.co/en/latest/administration/back_office/customize_search_suggestion/)
- [Customize back office search result sorting](https://doc.ibexa.co/en/latest/administration/back_office/customize_search_sorting/)

### Templating

- [Site context Twig function `ibexa_site_context_aware`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/site_context_twig_functions/#ibexa_site_context_aware)
- [Storefront Twig function `ibexa_get_anonymous_user_id`](https://doc.ibexa.co/en/latest/templating/twig_function_reference/storefront_twig_functions/#ibexa_get_anonymous_user_id)

## March 2024

### Permissions

- Updated [Custom policies](https://doc.ibexa.co/en/latest/permissions/custom_policies/) article

### Content management

- Updated [BinaryFile field type](https://doc.ibexa.co/en/latest/content_management/field_types/field_type_reference/binaryfilefield/) description

### Commerce

- Description of [integration with Payum](https://doc.ibexa.co/en/latest/commerce/payment/payum_integration/) and payment processing gateways

### Search

- Updated [Elasticsearch search engine](https://doc.ibexa.co/en/latest/search/search_engines/elasticsearch/elasticsearch_overview/) description
- New Search Criteria:
    - [Image](https://doc.ibexa.co/en/latest/search/criteria_reference/image_criterion/)
    - [ImageDimensions](https://doc.ibexa.co/en/latest/search/criteria_reference/imagedimensions_criterion/)
    - [ImageFileSize](https://doc.ibexa.co/en/latest/search/criteria_reference/imagefilesize_criterion/)
    - [ImageHeight](https://doc.ibexa.co/en/latest/search/criteria_reference/imageheight_criterion/)
    - [ImageMimeType](https://doc.ibexa.co/en/latest/search/criteria_reference/imagemimetype_criterion/)
    - [ImageOrientation](https://doc.ibexa.co/en/latest/search/criteria_reference/imageorientation_criterion/)
    - [ImageWidth](https://doc.ibexa.co/en/latest/search/criteria_reference/imagewidth_criterion/)

## February 2024

### Dashboard

- New dashboard sections in User Documentation:
    - [Dashboard](https://doc.ibexa.co/projects/userguide/en/latest/getting_started/dashboard/dashboard/)
    - [Work with dashboard](https://doc.ibexa.co/projects/userguide/en/latest/getting_started/dashboard/work_with_dashboard/)
    - [Dashboard block reference](https://doc.ibexa.co/projects/userguide/en/latest/getting_started/dashboard/dashboard_block_reference/)
- Dashboard section in Developer Documentation:
    - [Configure default dashboard](https://doc.ibexa.co/en/latest/administration/dashboard/configure_default_dashboard/)
    - [Customize dashboard](https://doc.ibexa.co/en/latest/administration/dashboard/customize_dashboard/)
    - [PHP API Dashboard service](https://doc.ibexa.co/en/latest/administration/dashboard/php_api_dashboard_service/)

### DAM

- [Ibexa DAM](https://doc.ibexa.co/projects/userguide/en/latest/dam/ibexa_dam/)

### PIM

- [Price engine REST API](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_reference/rest_api_reference.html#product-catalog-load-the-list-of-product-prices)

### REST API

- [Shipment REST API](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_reference/rest_api_reference.html#shipments)

### Others

- [Updated Create custom view matcher article](https://doc.ibexa.co/en/latest/templating/templates/create_custom_view_matcher/)
- [Actito transactional email integration](https://doc.ibexa.co/en/latest/commerce/transactional_emails/transactional_emails/#configure-actito-integration)
- [Described user profile](https://doc.ibexa.co/projects/userguide/en/latest/getting_started/get_started/#edit-user-profile)

## January 2024

### Administration

- [Enhanced data migration doc](https://doc.ibexa.co/en/latest/content_management/data_migration/importing_data/)
- [Enhanced update to v3.3 procedure ](https://doc.ibexa.co/en/latest/update_and_migration/from_2.5/to_3.3/)

### Content management

- New sections in taxonomy documentation:
    - [How to hide the delete button in large subtrees](https://doc.ibexa.co/en/latest/content_management/taxonomy/taxonomy/#hide-delete-button-on-large-subtree)
    - [How to remove orphaned content items](https://doc.ibexa.co/en/latest/content_management/taxonomy/taxonomy/#remove-orphaned-content-items)
- Updated information in User Documentation:
    - [Enhanced create and edit pages article](https://doc.ibexa.co/projects/userguide/en/latest/content_management/create_edit_pages/)
    - [Edit embedded content items](https://doc.ibexa.co/projects/userguide/en/latest/content_management/create_edit_content_items/#edit-embedded-content-items)

### DAM

- [Ibexa DAM](https://doc.ibexa.co/projects/userguide/en/latest/dam/ibexa_dam/)

### Getting started

- [[[= product_name_headless =]] product guide](https://doc.ibexa.co/en/latest/ibexa_products/headless/)
- [Enhanced get started article](https://doc.ibexa.co/projects/userguide/en/latest/getting_started/get_started/#edit-user-profile) in User Documentation

### Image management

- [Upload and store images](https://doc.ibexa.co/projects/userguide/en/latest/image_management/upload_images/)
- [Moved Edit images from Content management](https://doc.ibexa.co/projects/userguide/en/latest/image_management/edit_images/)

### Personalization

- [Customize recommendation request with segment parameters](https://doc.ibexa.co/en/latest/personalization/api_reference/recommendation_api/#segment-parameters)

### PIM

- Product search Aggregations:
    - [BasePriceStatsAggregation](https://doc.ibexa.co/en/latest/search/aggregation_reference/basepricestats_aggregation/)
    - [CustomPriceStatsAggregation](https://doc.ibexa.co/en/latest/search/aggregation_reference/custompricestats_aggregation/)

## December 2023

### Content management

- [Segmentation events](https://doc.ibexa.co/en/latest/api/event_reference/segmentation_events/)
- [Checkbox page block attribute type](https://doc.ibexa.co/en/latest/content_management/pages/page_block_attributes/#block-attribute-types)
- [Updated Create Form Builder Form attribute procedure](https://doc.ibexa.co/en/latest/content_management/forms/create_form_attribute/#create-form-builder-form-attribute)

### PIM

- [Reorganized and updated information in User Documentation](https://doc.ibexa.co/projects/userguide/en/latest/pim/pim/)

### Templating

- [Taxonomy view matchers](https://doc.ibexa.co/en/latest/templating/templates/view_matcher_reference/#taxonomy-entry-id)
- [Get content category Twig filter](https://doc.ibexa.co/en/latest/templating/twig_function_reference/other_twig_filters/#ibexa_taxonomy_entries_for_content)
- [Updated arguments list for `ibexa_render()` method](https://doc.ibexa.co/en/latest/templating/twig_function_reference/content_twig_functions/#ibexa_render)
- [New Field information Twig functions](https://doc.ibexa.co/en/latest/templating/twig_function_reference/field_twig_functions/#ibexa_field_group_name)
- [Updated get user Twig functions](https://doc.ibexa.co/en/latest/templating/twig_function_reference/user_twig_functions/)

### User management

- [Reorganized information in the User Management area](https://doc.ibexa.co/en/latest/users/users/)

## November 2023

### Commerce

- [Option to handle multiple checkout workflows](https://doc.ibexa.co/en/latest/commerce/checkout/customize_checkout/#manage-multiple-workflows)

### CDP

- [CDP activation](https://doc.ibexa.co/en/latest/cdp/cdp_activation/cdp_activation/)

### Product guides

- [Page Builder product guide](https://doc.ibexa.co/en/latest/content_management/pages/page_builder_guide/)

### Infrastructure and maintenance

- [Updated enable Symfony Reverse Proxy](https://doc.ibexa.co/en/latest/infrastructure_and_maintenance/cache/http_cache/reverse_proxy/#using-symfony-reverse-proxy)

### Others

- [Redesigned requirements page](https://doc.ibexa.co/en/latest/getting_started/requirements/)
- [Updated [[= product_name_cloud =]] CLI](https://doc.ibexa.co/en/latest/getting_started/install_on_ibexa_cloud/)
- [Updated React app block procedure](https://doc.ibexa.co/en/latest/content_management/pages/react_app_block/)
- [Added fulltext features in search](https://doc.ibexa.co/en/latest/search/criteria_reference/fulltext_criterion/#supported-syntax)

## October 2023

### Commerce

- [Adding context data to cart](https://doc.ibexa.co/en/latest/commerce/cart/cart_api/#adding-context-data-to-cart)

### Personalization

- [Post visit and price drop triggers](https://doc.ibexa.co/projects/userguide/en/latest/personalization/triggers/#trigger-types)
- [Wishlist and Deletefromwishlist events](https://doc.ibexa.co/en/latest/personalization/api_reference/tracking_api/#track-events)

### PIM

- [VAT category configuration update](https://doc.ibexa.co/en/latest/pim/pim_configuration/#vat-rates)
- [Payment Method Name Criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/payment_method_name_criterion/)

### Product guides

- [User management product guide](https://doc.ibexa.co/en/latest/users/user_management_guide/)

### Migration

- [Enhance data migration doc](https://doc.ibexa.co/en/latest/content_management/data_migration/importing_data/)
- [Images migration example](https://doc.ibexa.co/en/latest/content_management/data_migration/importing_data/#images)
- [Expression language functions](https://doc.ibexa.co/en/latest/content_management/data_migration/importing_data/#built-in-functions)

## September 2023

### Commerce

- Cart
    - [Merge carts API](https://doc.ibexa.co/en/latest/commerce/cart/cart_api/#merge-carts)
- Checkout
    - [Reorder](https://doc.ibexa.co/en/latest/commerce/checkout/reorder/)
    - [Hide checkout step](https://doc.ibexa.co/en/latest/commerce/checkout/customize_checkout/#hide-checkout-step)
- Order management
    - [Define cancel order](https://doc.ibexa.co/en/latest/commerce/order_management/configure_order_management/#define-cancel-order)

### Personalization

- [Updated configuration for triggers](https://doc.ibexa.co/en/latest/personalization/api_reference/tracking_api/#tracking-events-based-on-recommendations)
- [Send messages with recommendations](https://doc.ibexa.co/en/latest/personalization/integrate_recommendation_service/#send-messages-with-recommendations)
- [Email triggers](https://doc.ibexa.co/projects/userguide/en/latest/personalization/triggers/) in User Documentation

### PIM

- [Product availability Twig extension](https://doc.ibexa.co/en/latest/templating/twig_function_reference/product_twig_functions/#ibexa_has_product_availability)
- [PriceQuery with its criteria](https://doc.ibexa.co/en/latest/search/criteria_reference/price_search_criteria/)
    - [Price API](https://doc.ibexa.co/en/latest/pim/price_api/#prices)

### REST API

- Added GET endpoint for all available [Sales Representatives Users](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_reference/rest_api_reference.html#corporate-account-read-list-of-sales-representatives)

### Storefront

- [Display language name instead of its code in language swticher](https://doc.ibexa.co/en/latest/templating/twig_function_reference/storefront_twig_functions/#ibexa_storefront_get_language_name_by_code)

### Templating

- [Render content in PHP](https://doc.ibexa.co/en/latest/templating/render_content/render_content_in_php/)

### Others

- Product guides integrated into Developer Documentation
    - [Content management](https://doc.ibexa.co/en/latest/content_management/content_management_guide/)
    - [Customer portal](https://doc.ibexa.co/en/latest/customer_management/customer_portal/)
    - [Form Builder](https://doc.ibexa.co/en/latest/content_management/forms/form_builder_guide/)
    - [Online editor](https://doc.ibexa.co/en/latest/content_management/rich_text/online_editor_guide/)
    - [Personalization](https://doc.ibexa.co/en/latest/personalization/personalization_guide/)
    - [PIM](https://doc.ibexa.co/en/latest/pim/pim_guide/)

- [Updated bundles list](https://doc.ibexa.co/en/latest/administration/project_organization/bundles/)

## August 2023

### New home page

- Redesigned [home page for User Documentation](https://doc.ibexa.co/projects/userguide/en/latest/)

### Administration

- [Install [[= product_name =]] with DDEV](https://doc.ibexa.co/en/latest/getting_started/install_with_ddev/)
- [Update from v3.3.x to v3.3.latest](https://doc.ibexa.co/en/latest/update_and_migration/from_3.3/update_from_3.3/)

### Commerce

- [Importing data](https://doc.ibexa.co/en/latest/content_management/data_migration/importing_data/#commerce)
- Cart
    - [Quick order](https://doc.ibexa.co/en/latest/commerce/cart/quick_order/)
- Checkout
    - [Create custom strategy](https://doc.ibexa.co/en/latest/commerce/checkout/customize_checkout/#create-custom-strategy)
- Payments
    - [Implement payment method filtering](https://doc.ibexa.co/en/latest/commerce/payment/payment_method_filtering/)
    - [Filter payment methods](https://doc.ibexa.co/projects/userguide/en/latest/commerce/payment/work_with_payment_methods/#filter-payment-methods)
- Shipping
    - [Extend shipping](https://doc.ibexa.co/en/latest/commerce/shipping_management/extend_shipping/)
    - [Filter shipping methods](https://doc.ibexa.co/projects/userguide/en/latest/commerce/shipping_management/work_with_shipping_methods/#filter-shipping-methods)

### Online Editor

- [Add CKEditor plugins](https://doc.ibexa.co/en/latest/content_management/rich_text/extend_online_editor/#add-ckeditor-plugins)

### PIM

- [Custom name schema strategy](https://doc.ibexa.co/en/latest/pim/create_custom_name_schema_strategy/)
- [IsVirtual Search Criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/isvirtual_criterion/)

### Security

- [Hidden state clarification](https://doc.ibexa.co/en/latest/infrastructure_and_maintenance/security/security_checklist/#do-not-use-hide-for-read-access-restriction)
- [Add timeouts information](https://doc.ibexa.co/en/latest/infrastructure_and_maintenance/security/security_checklist/#protect-against-brute-force-attacks)

## July 2023

### v4.5.1

- [v4.5.1 release notes](https://doc.ibexa.co/en/latest/release_notes/ibexa_dxp_v4.5/#v451)

### New home page

- Redesigned [home page for Developer Documentation](https://doc.ibexa.co/en/latest/)

### Getting started

- New cautions in [Install on [[= product_name_cloud =]]](https://doc.ibexa.co/en/latest/getting_started/install_on_ibexa_cloud/) about using `cloud.ibexa.co` instead of `platform.sh`

### Content management

- New Page block [[[= product_name_connect =]] scenario block](https://doc.ibexa.co/en/latest/content_management/pages/ibexa_connect_scenario_block/)
- Updated [Create custom Page blocks](https://doc.ibexa.co/en/latest/content_management/pages/create_custom_page_block/#add-block-javascript)

### Customer Portal

- Updated [Creating a Customer Portal](https://doc.ibexa.co/en/latest/customer_management/cp_page_builder/)

### Personalization

- [Multiple attributes in submodel computation](https://doc.ibexa.co/en/latest/personalization/api_reference/recommendation_api/#submodel-parameters)
- [Multiple attributes in submodel computation](https://doc.ibexa.co/projects/userguide/en/latest/personalization/recommendation_models/#submodels) in User Documentation

### PIM

- Updated [Enable purchasing products](https://doc.ibexa.co/en/latest/pim/enable_purchasing_products/#region-and-currency)
- [Virtual products](https://doc.ibexa.co/en/latest/pim/products/#product-types)
- [Virtual products in User Documentation](https://doc.ibexa.co/projects/userguide/en/latest/pim/create_virtual_product/)
- [Work with product attributes](https://doc.ibexa.co/projects/userguide/en/latest/pim/work_with_product_attributes/) in User Documentation

### REST API
- Added example of input payload in JSON format for [ContentTypeCreate in REST API reference](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-create-content-type)
- [Expected user](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_usage/rest_requests/#expected-user) header support

### Commerce

- [Virtual products in checkout](https://doc.ibexa.co/en/latest/commerce/checkout/checkout/#virtual-products-checkout)
- New Order and Shipment Search Criteria:
    - [Order Owner Criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/order_owner_criterion/)
    - [Shipment Owner Criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/shipment_owner_criterion/)

### Search

- REST API examples in multiple [existing Search Criteria descriptions](https://doc.ibexa.co/en/latest/search/search_criteria_and_sort_clauses/)
- New REST API-only Search Criteria:
    - Content search:
        - [ParentLocationRemoteId Criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/parentlocationremoteId_criterion/)
    - Product search:
        - [AttributeGroupIdentifier Criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/attributegroupidentifier_criterion/)
        - [AttributeName Criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/attributename_criterion/)
        - [CatalogIdentifier Criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/catalogidentifier_criterion/)
        - [CatalogName Criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/catalogname_criterion/)
        - [CatalogStatus Criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/catalogstatus_criterion/)
        - [FloatAttributeRange Criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/floatattributerange_criterion/)
        - [IntegerAttributeRange Criterion](https://doc.ibexa.co/en/latest/search/criteria_reference/integerattributerange_criterion/)

### Infrastructure and maintenance

- [Configure and customize Fastly](https://doc.ibexa.co/en/latest/infrastructure_and_maintenance/cache/http_cache/fastly/)
- Updated Security checklist:
    - [Block upload of unwanted file types](https://doc.ibexa.co/en/latest/infrastructure_and_maintenance/security/security_checklist/#block-upload-of-unwanted-file-types)
    - [Minimise exposure](https://doc.ibexa.co/en/latest/infrastructure_and_maintenance/security/security_checklist/#minimize-exposure)

## June 2023

### Personalization

- [Email triggers](https://doc.ibexa.co/en/latest/personalization/integrate_recommendation_service/#send-messages-with-recommendations)
- [Email triggers](https://doc.ibexa.co/projects/userguide/en/latest/personalization/triggers/) in User Documentation

### Search

- [Updated search engines documentation](https://doc.ibexa.co/en/latest/search/search_engines/search_engines/):
    - [Elasticsearch search engine](https://doc.ibexa.co/en/latest/search/search_engines/elasticsearch/elasticsearch_overview/)
    - [Solr search engine](https://doc.ibexa.co/en/latest/search/search_engines/solr_search_engine/solr_overview/)
    - [Legacy search engine](https://doc.ibexa.co/en/latest/search/search_engines/legacy_search_engine/legacy_search_overview/#legacy-search-engine)

### Commerce

- [Shipping methods management](https://doc.ibexa.co/projects/userguide/en/latest/commerce/shipping_management/work_with_shipping_methods/) in User Documentation
- [Payment methods management](https://doc.ibexa.co/projects/userguide/en/latest/commerce/payment/work_with_payments/) in User Documentation
- Stock Search Criteria and Aggregation:
    - [ProductStockRangeAggregation](https://doc.ibexa.co/en/latest/search/aggregation_reference/productstockrange_aggregation/)
    - [ProductStock](https://doc.ibexa.co/en/latest/search/criteria_reference/productstock_criterion/)
    - [ProductStockRange](https://doc.ibexa.co/en/latest/search/criteria_reference/productstockrange_criterion/)

## May 2023

### v4.5

- [v4.5 release notes](https://doc.ibexa.co/en/latest/release_notes/ibexa_dxp_v4.5/) and guide on how to [update to v4.5](https://doc.ibexa.co/en/latest/update_and_migration/from_4.4/update_from_4.4/)

### Customer Portal

- [Corporate account company and member REST API reference](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_reference/rest_api_reference.html#corporate-account)
- [Creating a Customer Portal](https://doc.ibexa.co/en/latest/customer_management/cp_page_builder/)

### Commerce

- [Extending payments](https://doc.ibexa.co/en/latest/commerce/payment/extend_payment/)
- Reference for commerce-related events:
    - [Cart events](https://doc.ibexa.co/en/latest/api/event_reference/cart_events/)
    - [Order management events](https://doc.ibexa.co/en/latest/api/event_reference/order_management_events/)
    - [Payment events](https://doc.ibexa.co/en/latest/api/event_reference/payment_events/)

## April 2023

### Payment

- [Payment management](https://doc.ibexa.co/en/latest/commerce/payment/payment/), including [configuring payment workflow](https://doc.ibexa.co/en/latest/commerce/payment/configure_payment/), [payment](https://doc.ibexa.co/en/latest/commerce/payment/payment_api/), and [payment method PHP API](https://doc.ibexa.co/en/latest/commerce/payment/payment_method_api/)

### Orders

- [Order management](https://doc.ibexa.co/en/latest/commerce/order_management/order_management/), including [configuring order workflow](https://doc.ibexa.co/en/latest/commerce/order_management/configure_order_management/) and [Orders REST API reference](https://doc.ibexa.co/en/latest/api/rest_api/rest_api_reference/rest_api_reference.html#orders)

### Shipping

- [Shipping management](https://doc.ibexa.co/en/latest/commerce/shipping_management/shipping_management/), including [configuring shipment workflow](https://doc.ibexa.co/en/latest/commerce/shipping_management/configure_shipment/), [shipment](https://doc.ibexa.co/en/latest/commerce/shipping_management/shipment_api/), and [shipping method PHP API](https://doc.ibexa.co/en/latest/commerce/shipping_management/shipping_method_api/)

### Search

- Search Criteria and Sort Clauses covering the new commerce features:
    - Order [Search Criteria](https://doc.ibexa.co/en/latest/search/criteria_reference/order_search_criteria/)
    and [Sort Clauses](https://doc.ibexa.co/en/latest/search/sort_clause_reference/order_sort_clauses/)
    - Payment [Search Criteria](https://doc.ibexa.co/en/latest/search/criteria_reference/payment_search_criteria/)
    and [Sort Clauses](https://doc.ibexa.co/en/latest/search/sort_clause_reference/payment_sort_clauses/)
    - Payment method [Search Criteria](https://doc.ibexa.co/en/latest/search/criteria_reference/payment_method_search_criteria/)
    and [Sort Clauses](https://doc.ibexa.co/en/latest/search/sort_clause_reference/payment_method_sort_clauses/)
    - Shipment [Search Criteria](https://doc.ibexa.co/en/latest/search/criteria_reference/shipment_search_criteria/)
    and [Sort Clauses](https://doc.ibexa.co/en/latest/search/sort_clause_reference/shipment_sort_clauses/)

### New Page blocks

- [React app Page block](https://doc.ibexa.co/en/latest/content_management/pages/react_app_block/)
- [Bestsellers block](https://doc.ibexa.co/projects/userguide/en/latest/content_management/block_reference/#bestsellers-block)

### Others

- [Translation comparison](https://doc.ibexa.co/projects/userguide/en/latest/content_management/translate_content/#translation-comparison)
- [Managing Segments](https://doc.ibexa.co/projects/userguide/en/latest/personalization/segment_management/)

## March 2023

- [Order management API](https://doc.ibexa.co/en/latest/commerce/order_management/order_management_api/)
- [Customizing checkout](https://doc.ibexa.co/en/latest/commerce/checkout/customize_checkout/)
- Extended [table reusable component documentation](https://doc.ibexa.co/en/latest/administration/back_office/back_office_elements/reusable_components/#tables)
- How to [add GraphQL support to custom field types](https://doc.ibexa.co/en/latest/api/graphql/graphql_custom_ft/)
- How to [customize field type metadata](https://doc.ibexa.co/en/latest/content_management/field_types/customize_field_type_metadata/)

## February 2023

### Storefront

- [Storefront](https://doc.ibexa.co/en/latest/commerce/storefront/storefront/) documentation,
including how to [configure](https://doc.ibexa.co/en/latest/commerce/storefront/configure_storefront/)
and [extend Storefront](https://doc.ibexa.co/en/latest/commerce/storefront/extend_storefront/).

### Cart

- [Cart](https://doc.ibexa.co/en/latest/commerce/cart/cart/) documentation, including
[PHP API](https://doc.ibexa.co/en/latest/commerce/cart/cart_api/).

### Checkout

- [Checkout](https://doc.ibexa.co/en/latest/commerce/checkout/checkout/) documentation, including [how to configure checkout](https://doc.ibexa.co/en/latest/commerce/checkout/configure_checkout/), description of main [PHP API methods](https://doc.ibexa.co/en/latest/commerce/checkout/checkout_api/), and [checkout-related Twig functions](https://doc.ibexa.co/en/latest/templating/twig_function_reference/checkout_twig_functions/)

### Other

- How to [create a Form Builder Form attribute](https://doc.ibexa.co/en/latest/content_management/forms/create_form_attribute/)
- [Update guide for v4.4](https://doc.ibexa.co/en/latest/update_and_migration/from_4.3/update_from_4.3/)

## January 2023

### Page Builder

- Description of new Page Builder blocks: [Catalog](https://doc.ibexa.co/projects/userguide/en/latest/content_management/block_reference/#catalog-block) and [Product collection](https://doc.ibexa.co/projects/userguide/en/latest/content_management/block_reference/#product-collection-block)

### Other

- [Fastly Image Optimizer](https://doc.ibexa.co/en/latest/content_management/images/fastly_io/)
- [Storing field type settings externally](https://doc.ibexa.co/en/latest/content_management/field_types/field_type_storage/#storing-field-type-settings-externally)
