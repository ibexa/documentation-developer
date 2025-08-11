<!-- vale VariablesVersion = NO -->

# Ibexa DXP v5.0 renames, deprecations and removals

This page lists backwards compatibility breaks and deprecations introduced in [[= product_name =]] v5.0.

!!! tip "Upgrade to v5"

    For a guide on moving your project to v5.0,
    see [Update and migration instructions](../update_and_migration/from_4.6/update_to_5.0.md).

[[= product_name =]] v5.0 introduces further modifications to significant parts of the code to align with the ones introduced in previous versions.

These changes include dropped packages, changing database table and column names, field identifiers, namespaces, function names, and others.

## Dropped packages

[[= product_name =]] v5.0 no longer includes legacy Commerce packages.
The solution has been replaced with [Commerce](commerce.md) that is included as standard and has been continuously developed since v4.4.

Also, packages `compatibility-layer` and `icons` have been dropped.

## Database table and column names

A number of database table and column names have changed.
If your custom code directly queries them, you need to update the code.

| Old name                                              | New name                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `ezbinaryfile`                                          | `ibexa_binary_file`                                                       |
| `ezcobj_state`                                          | `ibexa_object_state`                                                      |
| `ezcobj_state_group`                                    | `ibexa_object_state_group`                                                |
| `ezcobj_state_group_language`                           | `ibexa_object_state_group_language`                                       |
| `ezcobj_state_language`                                 | `ibexa_object_state_language`                                             |
| `ezcobj_state_link`                                     | `ibexa_object_state_link`                                                 |
| `ezcontent_language`                                    | `ibexa_content_language`                                                  |
| `ezcontentbrowsebookmark`                               | `ibexa_content_bookmark`                                                  |
| `ezcontentclass`                                        | `ibexa_content_type`                                                      |
| `ezcontentclass_attribute`                              | `ibexa_content_type_field_definition`                                     |
| `ezcontentclass_attribute.contentclass_id`              | `ibexa_content_type_field_definition.content_type_id`                     |
| `ezcontentclass_attribute_ml`                           | `ibexa_content_type_field_definition_ml`                                  |
| `ezcontentclass_attribute_ml.contentclass_attribute_id` | `ibexa_content_type_field_definition_ml.content_type_field_definition_id` |
| `ezcontentclass_classgroup`                             | `ibexa_content_type_group_assignment`                                     |
| `ezcontentclass_classgroup.contentclass_id`             | `ibexa_content_type_group_assignment.content_type_id`                     |
| `ezcontentclass_name`                                   | `ibexa_content_type_name`                                                 |
| `ezcontentclass_name.contentclass_id`                   | `ibexa_content_type_name.content_type_id`                                 |
| `ezcontentclassgroup`                                   | `ibexa_content_type_group`                                                |
| `ezcontentobject`                                       | `ibexa_content`                                                           |
| `ezcontentobject.contentclass_id`                       | `ibexa_content.content_type_id`                                           |
| `ezcontentobject_attribute`                             | `ibexa_content_field`                                                     |
| `ezcontentobject_attribute.contentclassattribute_id`    | `ibexa_content_field.content_type_field_definition_id`                    |
| `ezcontentobject_link`                                  | `ibexa_content_relation`                                                  |
| `ezcontentobject_link.contentclassattribute_id`         | `ibexa_content_relation.content_type_field_definition_id`                 |
| `ezcontentobject_name`                                  | `ibexa_content_name`                                                      |
| `ezcontentobject_trash`                                 | `ibexa_content_trash`                                                     |
| `ezcontentobject_tree`                                  | `ibexa_content_tree`                                                      |
| `ezcontentobject_version`                               | `ibexa_content_version`                                                   |
| `ezdatebasedpublisher_scheduled_entries`                | `ibexa_scheduler_scheduled_entries`                                       |
| `ezdfsfile`                                             | `ibexa_dfs_file`                                                          |
| `ezeditorialworkflow_markings`                          | `ibexa_workflow_markings`                                                 |
| `ezeditorialworkflow_transitions`                       | `ibexa_workflow_transitions`                                              |
| `ezeditorialworkflow_workflows`                         | `ibexa_workflow_workflows`                                                |
| `ezform_field_attributes`                               | `ibexa_form_field_attributes`                                             |
| `ezform_field_validators`                               | `ibexa_form_field_validators`                                             |
| `ezform_fields`                                         | `ibexa_form_fields`                                                       |
| `ezform_form_submission_data`                           | `ibexa_form_form_submission_data`                                         |
| `ezform_form_submissions`                               | `ibexa_form_form_submissions`                                             |
| `ezform_forms`                                          | `ibexa_form_forms`                                                        |
| `ezgmaplocation`                                        | `ibexa_map_location`                                                      |
| `ezimagefile`                                           | `ibexa_image_file`                                                        |
| `ezkeyword`                                             | `ibexa_keyword`                                                           |
| `ezkeyword_attribute_link`                              | `ibexa_keyword_field_link`                                                |
| `ezmedia`                                               | `ibexa_media`                                                             |
| `eznode_assignment`                                     | `ibexa_node_assignment`                                                   |
| `eznotification`                                        | `ibexa_notification`                                                      |
| `ezpackage`                                             | `ibexa_package`                                                           |
| `ezpage_attributes`                                     | `ibexa_page_attributes`                                                   |
| `ezpage_blocks`                                         | `ibexa_page_blocks`                                                       |
| `ezpage_blocks_design`                                  | `ibexa_page_blocks_design`                                                |
| `ezpage_blocks_visibility`                              | `ibexa_page_blocks_visibility`                                            |
| `ezpage_map_attributes_blocks`                          | `ibexa_page_map_attributes_blocks`                                        |
| `ezpage_map_blocks_zones`                               | `ibexa_page_map_blocks_zones`                                             |
| `ezpage_map_zones_pages`                                | `ibexa_page_map_zones_pages`                                              |
| `ezpage_pages`                                          | `ibexa_page_pages`                                                        |
| `ezpage_zones`                                          | `ibexa_page_zones`                                                        |
| `ezpolicy`                                              | `ibexa_policy`                                                            |
| `ezpolicy_limitation`                                   | `ibexa_policy_limitation`                                                 |
| `ezpolicy_limitation_value`                             | `ibexa_policy_limitation_value`                                           |
| `ezpreferences`                                         | `ibexa_preferences`                                                       |
| `ezrole`                                                | `ibexa_role`                                                              |
| `ezsearch_object_word_link`                             | `ibexa_search_object_word_link`                                           |
| `ezsearch_object_word_link.contentclass_id`             | `ibexa_search_object_word_link.content_type_id`                           |
| `ezsearch_object_word_link.contentclass_attribute_id`   | `ibexa_search_object_word_link.content_type_field_definition_id`          |
| `ezsearch_word`                                         | `ibexa_search_word`                                                       |
| `ezsection`                                             | `ibexa_section`                                                           |
| `ezsite`                                                | `ibexa_site`                                                              |
| `ezsite_data`                                           | `ibexa_site_data`                                                         |
| `ezsite_public_access`                                  | `ibexa_site_public_access`                                                |
| `ezurl`                                                 | `ibexa_url`                                                               |
| `ezurl_object_link`                                     | `ibexa_url_content_link`                                                  |
| `ezurlalias`                                            | `ibexa_url_alias`                                                         |
| `ezurlalias_ml`                                         | `ibexa_url_alias_ml`                                                      |
| `ezurlalias_ml_incr`                                    | `ibexa_url_alias_ml_incr`                                                 |
| `ezurlwildcard`                                         | `ibexa_url_wildcard`                                                      |
| `ezuser`                                                | `ibexa_user`                                                              |
| `ezuser_accountkey`                                     | `ibexa_user_accountkey`                                                   |
| `ezuser_role`                                           | `ibexa_user_role`                                                         |
| `ezuser_setting`                                        | `ibexa_user_setting`                                                      |

## Field type identifiers

Several field type identifiers have changed.

| Old identifier (`legacy_alias`) | New identifier (`alias`)        |
|:--------------------------------|:--------------------------------|
| `ezauthor`                        | `ibexa_author`                    |
| `ezbinaryfile`                    | `ibexa_binaryfile`                |
| `ezboolean`                       | `ibexa_boolean`                   |
| `ezcontentquery`                  | `ibexa_content_query`             |
| `ezcountry`                       | `ibexa_country`                   |
| `ezdate`                          | `ibexa_date`                      |
| `ezdatetime`                      | `ibexa_datetime`                  |
| `ezemail`                         | `ibexa_email`                     |
| `ezfloat`                         | `ibexa_float`                     |
| `ezform`                          | `ibexa_form`                      |
| `ezgmaplocation`                  | `ibexa_gmap_location`             |
| `ezimage`                         | `ibexa_image`                     |
| `ezimageasset`                    | `ibexa_image_asset`               |
| `ezinteger`                       | `ibexa_integer`                   |
| `ezisbn`                          | `ibexa_isbn`                      |
| `ezkeyword`                       | `ibexa_keyword`                   |
| `ezlandingpage`                   | `ibexa_landing_page`              |
| `ezmatrix`                        | `ibexa_matrix`                    |
| `ezmedia`                         | `ibexa_media`                     |
| `ezobjectrelation`                | `ibexa_object_relation`           |
| `ezobjectrelationlist`            | `ibexa_object_relation_list`      |
| `ezrichtext`                      | `ibexa_richtext`                  |
| `ezselection`                     | `ibexa_selection`                 |
| `ezstring`                        | `ibexa_string`                    |
| `eztext`                          | `ibexa_text`                      |
| `eztime`                          | `ibexa_time`                      |
| `ezurl`                           | `ibexa_url`                       |
| `ezuser`                          | `ibexa_user`                      |


## PHP API classes and methods

!!! note "[[= product_name_base =]] Rector"

    [[[= product_name_base =]] Rector package](https://github.com/ibexa/rector) has been introduced that is based on [Rector](https://github.com/rectorphp) and comes with additional rules for working with Ibexa code.
    You can use it to get rid of PHP code deprecations.

### `ibexa/admin-ui`

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Contracts\AdminUi\Permission\PermissionCheckerInterface::getContentCreateLimitations`| `\Ibexa\AdminUi\Permission\LimitationResolverInterface::getContentCreateLimitations` | 
| `\Ibexa\Contracts\AdminUi\Permission\PermissionCheckerInterface::getContentUpdateLimitations` | `\Ibexa\AdminUi\Permission\LimitationResolverInterface::getContentUpdateLimitations` |
| `\Ibexa\Contracts\AdminUi\UniversalDiscovery\Provider::getRestFormat` | Removed |
| `\Ibexa\AdminUi\Form\Type\Search\DateIntervalType` | `\Ibexa\AdminUi\Form\Type\Date\DateIntervalType`|
| `\Ibexa\AdminUi\Siteaccess\SiteaccessResolverInterface::getSiteaccessesForLocation`| `\Ibexa\AdminUi\Siteaccess\SiteaccessResolverInterface::getSiteAccessesList`|
| `\Ibexa\AdminUi\Siteaccess\SiteaccessResolverInterface::getSiteaccesses`| `\Ibexa\AdminUi\Siteaccess\SiteaccessResolverInterface::getSiteAccessesList`|
| `\Ibexa\AdminUi\Specification\AbstractSpecification`| `\Ibexa\Contracts\Core\Specification\AbstractSpecification`|
| `\Ibexa\AdminUi\Specification\AndSpecification` | `\Ibexa\Contracts\Core\Specification\AndSpecification` |
| `\Ibexa\AdminUi\Specification\NotSpecification` | `\Ibexa\Contracts\Core\Specification\NotSpecification` |
| `\Ibexa\AdminUi\Specification\OrSpecification` | `\Ibexa\Contracts\Core\Specification\OrSpecification` |
| `\Ibexa\AdminUi\Specification\SpecificationInterface` | `\Ibexa\Contracts\Core\Specification\SpecificationInterface` |
| `\Ibexa\AdminUi\Tab\Dashboard\PagerContentToDataMapper` | `\Ibexa\AdminUi\Tab\Dashboard\PagerLocationToDataMapper` |
| `\Ibexa\AdminUi\Translation\Extractor\LimitationTranslationExtractor` | Removed |
| `\Ibexa\AdminUi\Translation\Extractor\PolicyTranslationExtractor` | Removed |
| `\Ibexa\AdminUi\UI\Dataset\ContentDraftsDataset` | `\Ibexa\AdminUi\UI\Dataset\ContentDraftListDataset` |
| `\Ibexa\AdminUi\UI\Dataset\DatasetFactory::relations` | `\Ibexa\AdminUi\UI\Dataset\DatasetFactory::relationList` |
| `\Ibexa\AdminUi\UI\Dataset\DatasetFactory::contentDrafts` | `\Ibexa\AdminUi\UI\Dataset\DatasetFactory::contentDraftList` |
| `\Ibexa\AdminUi\UI\Value\ValueFactory::createRelation` | `\Ibexa\AdminUi\UI\Value\ValueFactory::createRelationItem` |
| `\Ibexa\AdminUi\Validator\ValidationErrorsProcessor` | `\Ibexa\ContentForms\Validator\ValidationErrorsProcessor` |
| `\Ibexa\AdminUi\Validator\Constraints\FieldTypeValidator` | `\Ibexa\ContentForms\Validator\Constraints\FieldTypeValidator` |

### `ibexa/cart`

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Cart\Money\MoneyFactory`| `\Ibexa\ProductCatalog\Money\IntlMoneyFactory`|

### `ibexa/content-forms`

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Bundle\ContentForms\Controller\UserRegisterController`| `\Ibexa\Bundle\User\Controller\UserRegisterController`|
| `\Ibexa\ContentForms\User\View\UserRegisterConfirmView`| `\Ibexa\User\View\UserRegisterConfirmView`|
| `\Ibexa\ContentForms\User\View\UserRegisterFormView`| `\Ibexa\User\View\UserRegisterFormView`|

### `ibexa/core`

Support for facet search has been dropped, use the `Aggregation` API instead.

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Bundle\Core\DependencyInjection\Security\PolicyProvider\RepositoryPolicyProvider`| Removed |
| `\Ibexa\Bundle\Core\Imagine\VariationPathGenerator`| `\Ibexa\Contracts\Core\Variation\VariationPathGenerator`|
| `\Ibexa\ContentForms\User\View\UserRegisterFormView`| `\Ibexa\User\View\UserRegisterFormView`|
| `/Ibexa\Bundle\Debug\Collector\PersistenceCacheCollector::getCount` |  `\Ibexa\Bundle\Debug\Collector\PersistenceCacheCollector::getStats` |
| `\Ibexa\Bundle\RepositoryInstaller\Installer\Installer::createConfiguration` | Deprecated |
| `\Ibexa\Contracts\Core\FieldType\FieldStorage::getIndexData` | `\Ibexa\Contracts\Core\FieldType\Indexable` |
| `\Ibexa\Contracts\Core\FieldType\BinaryBase\PathGenerator` |  `\Ibexa\Contracts\Core\FieldType\BinaryBase\PathGeneratorInterface` |
| `\Ibexa\Contracts\Core\IO\BinaryFile::$mimeType` | `\Ibexa\Core\IO\IOMetadataHandler::getMimeType` |
| `\Ibexa\Contracts\Core\Persistence\Handler::beginTransaction` | `\Ibexa\Contracts\Core\Persistence\TransactionHandler::beginTransaction` |
| `\Ibexa\Contracts\Core\Persistence\Handler::commit` | `\Ibexa\Contracts\Core\Persistence\TransactionHandler::commit` |
| `\Ibexa\Contracts\Core\Persistence\Handler::rollback` |  `\Ibexa\Contracts\Core\Persistence\TransactionHandler::rollback` |
| `\Ibexa\Contracts\Core\Persistence\Bookmark\Bookmark::$name` | Removed |
| `\Ibexa\Contracts\Core\Persistence\Bookmark\CreateStruct::$name` | Removed |
| `\Ibexa\Contracts\Core\Persistence\Content\ContentInfo::STATUS_ARCHIVED` |  `\Ibexa\Contracts\Core\Persistence\Content\ContentInfo::STATUS_TRASHED` |
| `\Ibexa\Contracts\Core\Persistence\Content\ContentInfo::$isPublished` | Removed. Use `ContentInfo::$status` with value `STATUS_PUBLISHED`. |
| `\Ibexa\Contracts\Core\Persistence\Content\LoadStruct` | Removed |
| `\Ibexa\Contracts\Core\Persistence\Content\Location::$pathIdentificationString` | Removed |
| `\Ibexa\Contracts\Core\Persistence\Content\Location\CreateStruct::$pathIdentificationString` | Removed |
| `\Ibexa\Contracts\Core\Persistence\Content\Location\Handler::markSubtreeModified` | Removed |
| `\Ibexa\Contracts\Core\Persistence\FieldType\IsEmptyValue` | Removed |
| `\Ibexa\Contracts\Core\Persistence\User\Handler::loadPoliciesByUserId` | Removed |
| `\Ibexa\Contracts\Core\Repository\ContentService::loadContentDrafts` |  `\Ibexa\Contracts\Core\Repository\ContentService::loadContentDraftList` |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Location::SORT_FIELD_MODIFIED_SUBNODE` | Removed |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\FacetBuilder` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\LogicalOperator::getSpecifications` | Removed |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Location\IsMainLocation::createFromQueryBuilder` | Removed. Use the constructor directly. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Location\Priority::createFromQueryBuilder` | Removed. Use the constructor directly. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\FacetBuilder\ContentTypeFacetBuilder` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\FacetBuilder\CriterionFacetBuilder` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\FacetBuilder\DateRangeFacetBuilder` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\FacetBuilder\FieldFacetBuilder` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\FacetBuilder\FieldRangeFacetBuilder` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\FacetBuilder\Location` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\FacetBuilder\LocationFacetBuilder` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\FacetBuilder\SectionFacetBuilder` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\FacetBuilder\TermFacetBuilder` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\FacetBuilder\UserFacetBuilder` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Query\FacetBuilder\Location\LocationFacetBuilder` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Search\Facet` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchResult::$facets` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchResult::$spellSuggestion` | `\Ibexa\Contracts\Core\Repository\Values\Content\Search\SearchResult::$spellcheck` |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Search\Facet\ContentTypeFacet` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Search\Facet\CriterionFacet` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Search\Facet\DateRangeFacet` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Search\Facet\FieldFacet` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Search\Facet\FieldRangeFacet` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Search\Facet\LocationFacet` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Search\Facet\RangeFacetEntry` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Search\Facet\SectionFacet` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Search\Facet\TermFacet` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Search\Facet\UserFacet` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Core\Repository\Values\Content\Trash\SearchResult::$count` | `\Ibexa\Contracts\Core\Repository\Values\Content\Trash\SearchResult::$totalCount` |
| `\Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType::@$isContainer` | `\Ibexa\Contracts\Core\Repository\Values\ContentType\ContentType::isContainer` |
| `\Ibexa\Contracts\Core\User\Identity` | Removed. Use the `FOSHttpCacheBundle` user context feature. |
| `\Ibexa\Core\Event\UserService` | Listen to `BeforeUpdateUserPasswordEvent` instead of `BeforeUpdateUserEvent`. |
| `\Ibexa\Core\Event\UserService` | Listen to `UpdateUserPasswordEvent` instead of `UpdateUserEvent`. |
| `\Ibexa\Core\FieldType\GatewayBasedStorage` | `\Ibexa\Contracts\Core\FieldType\GatewayBasedStorage` |
| `\Ibexa\Core\FieldType\StorageGateway` | `\Ibexa\Contracts\Core\FieldType\StorageGatewayInterface` |
| `\Ibexa\Core\FieldType\Image\Value::@$path` | Equivalent to `$id` or `$inputUri`, depending on which one is set. |
| `\Ibexa\Core\FieldType\Image\Value::fromString` | `\Ibexa\Core\FieldType\FieldType::acceptValue` |
| `\Ibexa\Core\Helper\FieldHelper::getFieldDefinition` | If content exists, use `$content->getContentType()->getFieldDefinition($identifier)`. |
| `\Ibexa\Core\Helper\PreviewLocationProvider::loadMainLocation` | `\Ibexa\Core\Helper\PreviewLocationProvider::loadMainLocationByContent` |
| `\Ibexa\Core\IO\IOServiceInterface::getExternalPath` | `\Ibexa\Core\IO\IOServiceInterface::loadBinaryFileByUri` |
| `\Ibexa\Core\IO\IOServiceInterface::getInternalPath` | Removed. Use the `uri` property. |
| `\Ibexa\Core\IO\MetadataHandler` | Removed |
| `\Ibexa\Core\IO\MetadataHandler\ImageSize` | Removed |
| `\Ibexa\Core\IO\Values\BinaryFile::$mimeType` | `\Ibexa\Core\IO\IOServiceInterface::getMimeType` |
| `\Ibexa\Core\MVC\Symfony\MVCEvents::CACHE_CLEAR_CONTENT` | Removed |
| `\Ibexa\Core\MVC\Symfony\Event\ContentCacheClearEvent` | Removed |
| `\Ibexa\Core\MVC\Symfony\Locale\LocaleConverterInterface::convertToEz` | `\Ibexa\Core\MVC\Symfony\Locale\LocaleConverterInterface::convertToRepository` |
| `\Ibexa\Core\MVC\Symfony\SiteAccess\Matcher\Regex\Host` | Removed |
| `\Ibexa\Core\MVC\Symfony\SiteAccess\Matcher\Regex\URI` | Removed |
| `\Ibexa\Core\MVC\Symfony\View\Provider\Content` | Removed |
| `\Ibexa\Core\MVC\Symfony\View\Provider\Location` | Removed |
| `\Ibexa\Core\Persistence\Cache\PersistenceLogger::getCount` | `\Ibexa\Core\Persistence\Cache\PersistenceLogger::getStats` |
| `\Ibexa\Core\Persistence\Legacy\Handler::beginTransaction` | Removed. Use `\Ibexa\Contracts\Core\Persistence\TransactionHandler\TransactionHandler::beginTransaction`. |
| `\Ibexa\Core\Persistence\Legacy\Handler::commit` | Removed. Use `\Ibexa\Contracts\Core\Persistence\TransactionHandler\TransactionHandler::commit`. |
| `\Ibexa\Core\Persistence\Legacy\Handler::rollback` | Removed. Use `\Ibexa\Contracts\Core\Persistence\TransactionHandler\TransactionHandler::rollback`. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\AuthorConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\BinaryFileConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\CheckboxConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\CountryConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\DateAndTimeConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter` | Removed the `timestamp` property. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\DateConverter` | Removed the `timestamp` property. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\DateConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\EmailAddressConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\FloatConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\IntegerConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\ISBNConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\KeywordConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\MapLocationConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\MediaConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\NullConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\RelationConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\SelectionConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\TextBlockConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\TextLineConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\TimeConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\FieldValue\Converter\UrlConverter::create` | Removed. Use the default constructor. |
| `\Ibexa\Core\Persistence\Legacy\Content\Language\MaskGenerator::generateLanguageMask` | `\Ibexa\Core\Persistence\Legacy\Content\Language\MaskGenerator::generateLanguageMaskFromLanguageCodes` |
| `\Ibexa\Core\Repository\PermissionsCriterionHandler` | Removed |
| `\Ibexa\Core\Repository\SectionService::countAssignedContents` | Deprecated. Use `SearchService` with `Section` criterion. |
| `\Ibexa\Core\Repository\Helper\NameSchemaService` | `\Ibexa\Contracts\Core\Repository\NameSchema\NameSchemaServiceInterface` |
| `\Ibexa\Core\Repository\Helper\RoleDomainMapper` | Removed |
| `\Ibexa\Core\Repository\Mapper\ContentTypeDomainMapper::buildSPIFieldDefinitionUpdate` | `\Ibexa\Core\Repository\Mapper\ContentTypeDomainMapper::buildSPIFieldDefinitionFromUpdateStruct` |
| `\Ibexa\Core\Repository\Mapper\ContentTypeDomainMapper::buildSPIFieldDefinitionCreate` | `\Ibexa\Core\Repository\Mapper\ContentTypeDomainMapper::buildSPIFieldDefinitionFromCreateStruct` |
| `\Ibexa\Core\Repository\User\PasswordHashServiceInterface` | `\Ibexa\Contracts\Core\Repository\PasswordHashService` |
| `\Ibexa\Core\Search\Common\FieldNameResolver::getFieldNamesget` | `\Ibexa\Core\Search\Common\FieldNameResolver::getFieldTypes` |
| `\Ibexa\Core\Search\Common\IncrementalIndexer::createSearchIndex` | Removed |
| `\Ibexa\Tests\Integration\Core\Repository\BaseTest::isVersion4` | Removed |
| `\Ibexa\Tests\Integration\Core\Repository\SearchServiceTest::testDeprecatedCriteriaProperty` | Removed |
| `\Ibexa\Tests\Core\Repository\Service\Mock\PermissionsCriterionHandlerTest` | Removed |
| `\Ibexa\Contracts\Core\Repository\Values\Translation` | Implementations must implement `\Stringable` interface. |
| `\Ibexa\Bundle\Core\ApiLoader\RepositoryConfigurationProvider` | Deprecated. Use `\Ibexa\Contracts\Core\Container\ApiLoader\RepositoryConfigurationProviderInterface`. |
| `\Ibexa\Bundle\Core\ApiLoader\RepositoryFactory` | Deprecated. Use `\Ibexa\Core\Base\Container\ApiLoader\RepositoryFactory`.|

!!! note "Dropped single colon notation"

    [[= product_name_base =]]-named controllers can no longer be referenced using a single-colon notation.
    For example, `ibexa_content:viewAction` must be changed to `ibexa_content::viewAction`.

    The change affects the following controllers:

    - ibexa_content
    - ibexa_query
    - ibexa_query_render
    - ibexa.controller.content.preview

### ibexa/corporate-account

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Bundle\CorporateAccount\Controller\ApplicationController\PersistenceCacheCollector::alreadyExistsAction`| Removed |

### ibexa/design-engine

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\DesignEngine\Templating\TemplateNameResolverInterface::EZ_DESIGN_NAMESPACE`| Removed. Use the `\Ibexa\Contracts\DesignEngine\DesignAwareInterface::DESIGN_NAMESPACE` constant. |

### ibexa/elasticsearch

Support for facets in `ibexa/elasticsearch` has been dropped, use the `Aggregation` API instead.

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Contracts\Elasticsearch\Query\FacetBuilderVisitor` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Contracts\Elasticsearch\Query\FacetResultExtractor` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\FacetBuilderVisitor\AbstractTermsVisitor` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\FacetBuilderVisitor\ContentTypeVisitor` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\FacetBuilderVisitor\DispatcherVisitor` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\FacetBuilderVisitor\FilteredFacetVisitorDecorator` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\FacetBuilderVisitor\GlobalFacetVisitorDecorator` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\FacetBuilderVisitor\SectionVisitor` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\FacetBuilderVisitor\UserVisitor` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\ResultExtractor\FacetResultExtractor\AbstractTermsResultExtractor` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\ResultExtractor\FacetResultExtractor\ContentTypeResultExtractor` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\ResultExtractor\FacetResultExtractor\DispatcherResultExtractor` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\ResultExtractor\FacetResultExtractor\FilteredFacetResultExtractorDecorator` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\ResultExtractor\FacetResultExtractor\GlobalFacetResultExtractorDecorator` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\ResultExtractor\FacetResultExtractor\SectionResultExtractor` | Removed. Use the `Aggregation` API. |
| `\Ibexa\Elasticsearch\Query\ResultExtractor\FacetResultExtractor\UserResultExtractor` | Removed. Use the `Aggregation` API. |

### ibexa/fieldtype-page

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Bundle\FieldTypePage\DependencyInjection\Compiler\AbstractConfigurationAwareCompilerPass::EXTENSION_CONFIG_KEY` | Removed. Use the `\Ibexa\Bundle\FieldTypePage\DependencyInjection\IbexaFieldTypePageExtension::EXTENSION_NAME` constant. |
| `\Ibexa\Bundle\FieldTypePage\DependencyInjection\Compiler\BlockDefinitionConfigurationCompilerPass::EXTENSION_CONFIG_KEY` | Removed. Use the `\Ibexa\Bundle\FieldTypePage\DependencyInjection\IbexaFieldTypePageExtension::EXTENSION_NAME` constant. |
| `\Ibexa\FieldTypePage\FieldType\Page\Block\Renderer\Event\Listener\PreviewTemplateEventSubscriber` | Removed |
| `\Ibexa\FieldTypePage\ScheduleBlock\ScheduleService::distributeItems` | Removed |

### ibexa/fieldtype-query

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\FieldTypeQuery\QueryFieldPaginationService` | Removed |
| `\Ibexa\FieldTypeQuery\Persistence\Legacy\Content\FieldValue\Converter\QueryConverter::create` | Removed. Use the default constructor. |

### ibexa/fieldtype-richtext

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\FieldTypeRichText\Translation\Extractor\OnlineEditorCustomAttributesExtractor` | Removed |
| `\Ibexa\FieldTypeQuery\Persistence\Legacy\Content\FieldValue\Converter\QueryConverter::create` | Removed. Use the default constructor. |

!!! note "Missing custom tag configuration error"

    If the stored RichText record includes any custom tags that aren’t configured or recognized, saving the content will cause a validation error.

### ibexa/form-builder

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Bundle\FormBuilder\DependencyInjection\Configuration::TREE_ROOT` | Removed. Use the `\Ibexa\Bundle\FormBuilder\DependencyInjection\IbexaFormBuilderExtension::EXTENSION_NAME` constant. |
| `\Ibexa\FormBuilder\FieldType\Storage\FormStorage::getIndexData` | Removed |

### ibexa/graphql

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\GraphQL\Schema\ImagesVariationsBuilder` | Removed |
| `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::domainContentCollectionField` | `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::itemConnectionField` |
| `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::domainContentName` | `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::itemName` |
| `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::domainContentConnection` | `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::itemConnectionName` |
| `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::domainContentCreateInputName` | `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::itemCreateInputName` |
| `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::domainContentUpdateInputName` | `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::itemUpdateInputName` |
| `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::domainContentTypeName` | `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::itemUpdateInputName` |
| `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::domainContentField` | `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::itemField` |
| `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::domainMutationCreateContentField` | `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::itemMutationCreateItemField` |
| `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::domainMutationUpdateContentField` | `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::itemMutationUpdateItemField` |
| `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::domainGroupName` | `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::itemGroupName` |
| `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::domainGroupTypesName` | `\Ibexa\GraphQL\Schema\Domain\Content\NameHelper::itemGroupTypesName` |
| `\Ibexa\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\FieldDefinitionArgsBuilderMapper` | `\Ibexa\Contracts\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\FieldDefinitionMapper` |
| `\Ibexa\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\FieldDefinitionInputMapper` | `\Ibexa\Contracts\GraphQL\Schema\Domain\Content\Mapper\FieldDefinition\FieldDefinitionMapper` |

### ibexa/measurement

!!! note "Dropped `measurement` product attribute"

    The deprecated product attribute `measurement` has been removed.
    The change does not affect the [measurement field type](measurementfield.md).

### ibexa/migrations

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Migration\ValueObject\ContentType\Matcher::CONTENT_TYPE_IDENTIFIER` | Removed. Use the `\Ibexa\Migration\StepExecutor\ContentType\IdentifierFinder::CONTENT_TYPE_IDENTIFIER` constant. |

### ibexa/product-catalog

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\ProductCatalog\Bridge` | Migrate data to a local product catalog. |

### ibexa/page-builder

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Bundle\PageBuilder\DependencyInjection\IbexaPageBuilderExtension::SESSION_KEY_SITEACCESS` | Removed |
| `\Ibexa\PageBuilder\PageBuilder\PreviewLanguageCodeResolver` | Removed |
| `\Ibexa\PageBuilder\Siteaccess\SiteaccessService::resolveSiteAccessForLocation` | `\Ibexa\AdminUi\Siteaccess\SiteaccessResolverInterface::getSiteAccessesListForLocation` |
| `\Ibexa\PageBuilder\Siteaccess\SiteaccessService::resolveSiteAccessForContent` | `\Ibexa\Contracts\PageBuilder\Siteaccess\SiteAccessResolver::resolveSiteAccessForContent` |
| `\Ibexa\PageBuilder\Siteaccess\SiteaccessService::resolveSiteAccessBasedOnLanguage` | Removed |

### ibexa/rest

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Bundle\Rest\EventListener\CsrfListener::isLoginRequest` | Add `csrf_protection: false` attribute to route definition. |
| `\Ibexa\Bundle\Rest\EventListener\CsrfListener::isSessionRoute` | Add `csrf_protection: false` attribute to route definition. |
| `\Ibexa\Bundle\Rest\EventListener\RequestListener::REST_PREFIX_PATTERN` | Use `\Ibexa\Contracts\Rest\UriParser\UriParserInterface::isRestRequest` function. |
| `\Ibexa\Bundle\Rest\EventListener\RequestListener::hasRestPrefix` | Use `\Ibexa\Contracts\Rest\UriParser\UriParserInterface::isRestRequest` function. |
| `\Ibexa\Bundle\Rest\RequestParser\Router` | `\Ibexa\Contracts\Rest\UriParser\UriParserInterface` |
| `\Ibexa\Contracts\Rest\Output\Generator::generateMediaType` | `\Ibexa\Contracts\Rest\Output\Generator::generateMediaTypeWithVendor` |
| `\Ibexa\Rest\Output\FieldTypeSerializer::serializeFieldValue` | `\Ibexa\Rest\Output\FieldTypeSerializer::serializeContentFieldValue` |
| `\Ibexa\Rest\Server\Controller\Content::createView` | Forwards the request to the new `/views` location, but returns a 301. |
| `\Ibexa\Rest\Server\Controller\User::$csrfTokenStorage` | Removed |
| `\Ibexa\Rest\Server\Controller\User::$sessionController` | Removed |
| `\Ibexa\Rest\Server\Controller\User::createSession` | `\Ibexa\Rest\Server\Controller\SessionController::refreshSessionAction` |
| `\Ibexa\Rest\Server\Controller\User::refreshSession` | `\Ibexa\Rest\Server\Controller\SessionController::refreshSessionAction` |
| `\Ibexa\Rest\Server\Controller\User::deleteSession` | `\Ibexa\Rest\Server\Controller\SessionController::refreshSessionAction` |

### ibexa/scheduler

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Bundle\Rest\EventListener\CsrfListener::isLoginRequest` | Add `csrf_protection: false` attribute to route definition. |

### ibexa/site-factory

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Bundle\SiteFactory\DependencyInjection\Configuration::TREE_ROOT` | Removed. Use the `\Ibexa\Bundle\SiteFactory\DependencyInjection\IbexaSiteFactoryExtension::EXTENSION_NAME` constant. |
| `\Ibexa\SiteFactory\Event\EventDispatcher` |  Removed |
| `\Ibexa\SiteFactory\ServiceDecorator\SiteServiceDecorator` |  Removed |
| `\Ibexa\SiteFactory\ServiceEvent\Events\BeforeCreateSiteEvent` |  Removed |
| `\Ibexa\SiteFactory\ServiceEvent\Events\BeforeDeleteSiteEvent` |  Removed |
| `\Ibexa\SiteFactory\ServiceEvent\Events\BeforeUpdateSiteEvent` |  Removed |
| `\Ibexa\SiteFactory\ServiceEvent\Events\CreateSiteEvent` |  Removed |
| `\Ibexa\SiteFactory\ServiceEvent\Events\DeleteSiteEvent` |  Removed |
| `\Ibexa\SiteFactory\ServiceEvent\Events\UpdateSiteEvent` |  Removed |

### ibexa/solr

Support for facet search has been dropped, use the `Aggregation` API instead.

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Solr\Handler::$resultExtractor` | Use `$contentResultExtractor` or `$locationResultExtractor`. |
| `\Ibexa\Solr\Gateway\UpdateSerializer` | `\Ibexa\Solr\Gateway\UpdateSerializer\XmlUpdateSerializer` |
| `\Ibexa\Solr\Query\FacetBuilderVisitor` | Use `Aggregation API`. |
| `\Ibexa\Solr\Query\FacetFieldVisitor` | Use `Aggregation API`. |
| `\Ibexa\Solr\Query\Common\FacetBuilderVisitor\Aggregate` | Use `Aggregation API`. |
| `\Ibexa\Solr\Query\Common\FacetBuilderVisitor\ContentType` | Use `Aggregation API`. |
| `\Ibexa\Solr\Query\Common\FacetBuilderVisitor\Section` | Use `Aggregation API`. |
| `\Ibexa\Solr\Query\Common\FacetBuilderVisitor\User` | Use `Aggregation API`. |
| `\Ibexa\Solr\Query\Content\CriterionVisitor\Field` | `\Ibexa\Solr\Query\Common\CriterionVisitor\Field` |

### ibexa/storefront

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Contracts\Storefront\Repository\TaxonomyTreeServiceInterface::getPath` | `\Ibexa\Contracts\Taxonomy\Service\TaxonomyServiceInterface::getPath` |

### ibexa/system-info

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Bundle\SystemInfo\SystemInfo\Collector\IbexaSystemInfoCollector::CONTENT_PACKAGES` | Removed. Use the `\Ibexa\Bundle\SystemInfo\SystemInfo\Collector\IbexaSystemInfoCollector::HEADLESS_PACKAGES` constant. |
| `\Ibexa\Bundle\SystemInfo\SystemInfo\Collector\IbexaSystemInfoCollector::ENTERPRISE_PACKAGES` | Removed. Use `IbexaSystemInfoCollector::EXPERIENCE_PACKAGES` or `IbexaSystemInfoCollector::HEADLESS_PACKAGES` constant. |
| `\Ibexa\Bundle\SystemInfo\SystemInfo\Value\IbexaSystemInfo::$stability` | `\Ibexa\Bundle\SystemInfo\SystemInfo\Value\IbexaSystemInfo` is considered internal. |

### ibexa/workflow

| Old FQN                                              | New FQN / Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `\Ibexa\Contracts\Workflow\Service\WorkflowServiceInterface::loadWorkflowMetadataOriginatedByUser` | Removed |
| `\Ibexa\Contracts\Workflow\Service\WorkflowServiceInterface::loadAllWorkflowMetadata` | Removed |

## PHP method parameters

The `ValueObject` argument was replaced by `object` in a number of interfaces in `core` and `migrations` package.
In `core`, this change improves extensibility by enabling the use of custom object types to be interpreted by `PermissionResolver`.
In `migrations`, it makes it easier to integrate custom data types, especially when using `AbstractStepFactory`.

!!! note "Change examples"

    Below the lists you may find examples of changes in those interfaces or classes that you are most likely to use in your work.
    
### ibexa/core

| PHP Interface or class                                     | Methods                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `Ibexa\Contracts\Core\Repository\PermissionResolver` | `canUser`, `lookupLimitations` |
| `Ibexa\Contracts\Core\Limitation/TargetAwareType` | `evaluate` |
| `Ibexa\Contracts\Core\Limitation/Type` | `evaluate` |
| `Ibexa\Core\Limitation\BlockingLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\ChangeOwnerLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\ContentTypeLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\LanguageLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\LocationLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\MemberOfLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\NewObjectStateLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\NewSectionLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\ObjectStateLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\OwnerLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\ParentContentTypeLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\ParentDepthLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\ParentOwnerLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\ParentUserGroupLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\RoleLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\SectionLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\SiteAccessLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\StatusLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\SubtreeLimitationType` | `evaluate` |
| `Ibexa\Core\Limitation\UserGroupLimitationType` | `evaluate` |
| `Ibexa\Core\Repository\Permission\CachedPermissionService` | `canUser`, `lookupLimitations` |
| `Ibexa\Core\Repository\Permission\PermissionResolver` | `canUser`, `lookupLimitations` |

??? note "Changes in `src/contracts/Repository/PermissionResolver.php`"

    ![`PermissionResolver.php`](5.0_Repository.PermissionResolver.png)

### ibexa/migrations

| PHP Interface or class                                     | Methods                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `Ibexa\Contracts\Migration\StepExecutor\AbstractStepExecutor` | `doCollectReferences`, `handleActions` |
| `Ibexa\Migration\Generator\Content\StepBuilder\Create` | `build` |
| `Ibexa\Migration\Generator\Content\StepBuilder\Delete` | `build` |
| `Ibexa\Migration\Generator\Content\StepBuilder\Factory` | `prepareLogMessage` |
| `Ibexa\Migration\Generator\Content\StepBuilder\Update` | `build` |
| `Ibexa\Migration\Generator\ContentTypeGroup\StepBuilder\Create` | `build` |
| `Ibexa\Migration\Generator\ContentTypeGroup\StepBuilder\Delete` | `build` |
| `Ibexa\Migration\Generator\ContentTypeGroup\StepBuilder\Factory` | `prepareLogMessage` |
| `Ibexa\Migration\Generator\ContentTypeGroup\StepBuilder\Update` | `build` |
| `Ibexa\Migration\Generator\Language\StepBuilder\Create` | `build` |
| `Ibexa\Migration\Generator\Language\StepBuilder\Factory` | `prepareLogMessage` |
| `Ibexa\Migration\Generator\Location\StepBuilder\Factory` | `prepareLogMessage` |
| `Ibexa\Migration\Generator\Location\StepBuilder\Update` | `build` |
| `Ibexa\Migration\Generator\ObjectState\StepBuilder\Create` | `build` |
| `Ibexa\Migration\Generator\ObjectState\StepBuilder\Factory` | `prepareLogMessage` |
| `Ibexa\Migration\Generator\ObjectStateGroup\StepBuilder\Create` | `build` |
| `Ibexa\Migration\Generator\ObjectStateGroup\StepBuilder\Factory` | `prepareLogMessage` |
| `Ibexa\Migration\Generator\Role\StepBuilder\RoleCreateStepBuilder` | `build` |
| `Ibexa\Migration\Generator\Role\StepBuilder\RoleDeleteStepBuilder` | `build` |
| `Ibexa\Migration\Generator\Role\StepBuilder\RoleStepFactory` | `prepareLogMessage` |
| `Ibexa\Migration\Generator\Role\StepBuilder\RoleUpdateStepBuilder` | `build` |
| `Ibexa\Migration\Generator\Section\StepBuilder\Create` | `build` |
| `Ibexa\Migration\Generator\Section\StepBuilder\Factory` | `prepareLogMessage` |
| `Ibexa\Migration\Generator\Section\StepBuilder\Update` | `build` |
| `Ibexa\Migration\Generator\StepBuilder\AbstractStepFactory` | `create`, `log`, `prepareLogMessage` |
| `Ibexa\Migration\Generator\StepBuilder\ContentTypeCreateStepBuilder` | `build` |
| `Ibexa\Migration\Generator\StepBuilder\ContentTypeDeleteStepBuilder` | `build` |
| `Ibexa\Migration\Generator\StepBuilder\ContentTypeStepFactory` | `prepareLogMessage` |
| `Ibexa\Migration\Generator\StepBuilder\ContentTypeUpdateStepBuilder` | `build` |
| `Ibexa\Migration\Generator\StepBuilder\LoggerContentTypeCreateStepBuilder` | `build` |
| `Ibexa\Migration\Generator\StepBuilder\StepBuilderInterface` | `build` |
| `Ibexa\Migration\Generator\StepBuilder\StepFactoryInterface` | `build` |
| `Ibexa\Migration\Generator\User\StepBuilder\Create` | `build` |
| `Ibexa\Migration\Generator\User\StepBuilder\Factory` | `prepareLogMessage` |
| `Ibexa\Migration\Generator\User\StepBuilder\Update` | `build` |
| `Ibexa\Migration\Generator\UserGroup\StepBuilder\Create` | `build` |
| `Ibexa\Migration\Generator\UserGroup\StepBuilder\Delete` | `build` |
| `Ibexa\Migration\Generator\UserGroup\StepBuilder\Factory` | `prepareLogMessage` |
| `Ibexa\Migration\Generator\UserGroup\StepBuilder\Update` | `build` |
| `Ibexa\Migration\StepExecutor\ReferenceDefinition\Resolver` | `resolve` |
| `Ibexa\Migration\StepExecutor\ReferenceDefinition\ResolverInterface` | `resolve` |


??? note "Changes in `Ibexa\Migration\Generator\StepBuilder\StepFactoryInterface`"

    ![`StepFactoryInterface.php`](5.0_StepBuilder.StepFactoryInterface.png)

??? note "Changes in `Ibexa\Migration\StepExecutor\ReferenceDefinition\ResolverInterface`"

    ![`ResolverInterface.php`](5.0_StepExecutor.ReferenceDefinition.ResolverInterface.png)

??? note "Changes in `Ibexa\Migration\Generator\StepBuilder\AbstractStepFactory`"

    ![`AbstractStepFactory.php`](5.0_StepBuilder.AbstractStepFactory.png)

## Services

The following service definitions have been removed:

| Service name                                              |  Comment                                                                |
|:------------------------------------------------------|:------------------------------------------------------------------------|
| `ibexa.cart.number_formatter.currency.factory` | Removed |

## JavaScript classes and functions

|Old class or function|New class or function|
|:----|:----|
| `formatLine` const in `/src/bundle/Resources/public/js/scripts/helpers/form.error.helper.js` | Removed |
| `parseAll` const in `/src/bundle/Resources/public/js/scripts/helpers/middle.ellipsis.js` | Removed |
| `fileSizeToString` const in `src/bundle/ui-dev/src/modules/multi-file-upload/helpers/text.helper.js` | Use `fileSizeToString` function from `/src/bundle/ui-dev/src/modules/common/helpers/text.helper.js`. |
| `src/bundle/ui-dev/src/modules/common/components/backdrop/backdrop.js` | Use the `ibexa.core.Backdrop` component. |
| `src/bundle/ui-dev/src/modules/page-builder/components/block/sidebar.block.js` | `src/bundle/ui-dev/src/modules/page-builder/components/block/block.js` |
| `src/bundle/ui-dev/src/modules/page-builder/components/block/sidebar.blocks.group.js` | `src/bundle/ui-dev/src/modules/page-builder/components/block/blocks.group.js` |
| `src/bundle/ui-dev/src/modules/page-builder/components/sidebar/sidebar.js` | `src/bundle/ui-dev/src/modules/page-builder/components/toolbox.js` |
| `src/bundle/ui-dev/src/modules/tree-builder/components/indentation-vertical/indentation.vertical.js)`| `src/bundle/ui-dev/src/modules/tree-builder/components/indentation-horizontal/indentation.horizontal.js` |
| `src/bundle/ui-dev/src/modules/tree-builder/components/portal-provider/portal.provider.js` | `tree-builder/src/bundle/ui-dev/src/modules/tree-builder/components/portal/portal.js` |
| `src/bundle/ui-dev/src/modules/tree-builder/hooks/usePortal.js` | `tree-builder/src/bundle/ui-dev/src/modules/tree-builder/components/portal/portal.js` |

## Configuration keys

| Old name | New name |
|:----|:----|
| `ibexa.system.*.database.*` | `ibexa.repositories` |
| `ibexa.system.*.session_name` | `ibexa.system.*.session.name` |
| `ibexa.site_access.config.default.user_registration.group_id` | `ibexa.site_access.config.default.user_registration.group_remote_id` |
| `ezpublish_http_basic` | Use `http_basic` in `security.yml` directly. |

## Session prefix

The default prefix used for [SiteAccess sessions](sessions.md) has been renamed.

| Old prefix | New prefix |
|:----|:----|
| `eZSESSID` | `IBX_SESSION_ID` |

## CSS settings

|Old setting|New setting|
|:----|:----|
| `ibexa-alert--complementary` | `ibexa-alert--info` |
| `sidebar-drag-items` | `toolbox-drag-items` |
| `sidebar-drag-items-group` | `toolbox-drag-items-group` |
| `sidebar-drag-item` | `tooblox-drag-item` |
| `/src/bundle/Resources/public/scss/mixins/_font.scss` | Removed |
| `/src/bundle/Resources/public/scss/_iframe-backdrop.scss` | Removed |

## Twig templates, functions and filters

The global Twig variable `ez_richtext_config` has been renamed to `ibexa_richtext_config`.

| Old name| New name / Comment |
|:----|:----|
| `\Ibexa\Core\MVC\Symfony\Templating\Twig\Extension\` | Removed `ezplatform` variable, use the `ibexa` global variable. |
| `\Ibexa\Core\MVC\Symfony\View\ParametersInjector\ViewbaseLayout\` | Removed `pagelayout` variable, use `page_layout`. |
| `/src/bundle/Resources/views/themes/admin/account/form_fields.html.twig` | Deprecated, extend `@ibexadesign/ui/form_fields.html.twig` directly. |
| `/src/bundle/Resources/views/themes/admin/content/edit/content_header.html.twig` | Removed |
| `/src/bundle/Resources/views/themes/admin/ui/footer.html.twig` | Deprecated |
| `/src/bundle/Resources/views/themes/corporate/customer_portal/registration/registration_already_exists.html.twig` | Removed |
| `/src/bundle/Resources/views/block_preview.html.twig` | Removed |
| `\Ibexa\Scheduler\Dashboard\AllScheduledTab` | Removed `type` variable. Use `content_type.name`. |
| `\Ibexa\Scheduler\Dashboard\MyScheduledTab` | Removed `type` variable. Use `content_type.name`. |
| `\Ibexa\Bundle\User\Controller\DefaultProfileImageController` | Removed `type` variable. Use `text_color`. Remove `default(text)` from `initials.svg.twig`. |
| `\Ibexa\Bundle\User\Controller\DefaultProfileImageController` | Removed `background` variable, use `background_color`. Remove `default(background)` from `initials.svg.twig`. |
