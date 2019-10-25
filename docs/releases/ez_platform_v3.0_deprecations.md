# eZ Platform v3.0 deprecations and backwards compatibility breaks

This page lists backwards compatibility breaks and deprecations introduced in eZ Platform v3.0.

## Symfony 4

v3.0 now uses Symfony 4 instead of Symfony 3.
Refer to [Symfony changelog](https://github.com/symfony/symfony/blob/master/CHANGELOG-4.0.md)
and [Symfony upgrade guides](https://github.com/symfony/symfony/blob/master/UPGRADE-4.0.md)
to learn about all changes it entails.

See [v3.0 project update](ez_platform_v3.0_project_update.md) for the steps you need to take to update your project to Symfony 4.
See also [full requirements for installing eZ Platform](../getting_started/requirements.md).

### Template configuration

Following the [upgrade to Symfony 4](#symfony-4), [the templating component integration is now deprecated.](https://symfony.com/blog/new-in-symfony-4-3-deprecated-the-templating-component-integration)
As a result, the way to indicate a template path has changed.

Example 1:

- Now: `"@@EzPlatformUser/user_settings/list.html.twig"`
- Formerly: `"EzPlatformUserBundle:user_settings:list.html.twig"`

Example 2:

- Now: `{% extends "@EzPublishCore/content_fields.html.twig" %}`
- Formerly: `{% extends "EzPublishCoreBundle::content_fields.html.twig" %}`

## Field Types

The following tags used to register Field Type features in the dependency injection container have been renamed:

|Former name|New name|
|-----------|--------|
|`ezpublish.fieldType`|`ezplatform.field_type`|
|`ezpublish.fieldType.indexable`|`ezplatform.field_type.indexable`|
|`ezpublish.storageEngine.legacy.converter`|`ezplatform.field_type.legacy_storage.converter`|
|`ezpublish.fieldType.parameterProvider`|`ezplatform.field_type.parameter_provider`|
|`ezpublish_rest.field_type_processor`|`ezplatform.field_type.rest.processor`|
|`ez.fieldFormMapper.value`|`ezplatform.field_type.form_mapper.value`|
|`ez.fieldFormMapper.definition`|`ezplatform.field_type.form_mapper.definition`|
|`ezpublish.fieldType.externalStorageHandler`|`ezplatform.field_type.external_storage_handler`|
|`ezpublish.fieldType.externalStorageHandler.gateway`|`ezplatform.field_type.external_storage_handler.gateway`|

Deprecated method `eZ\Publish\SPI\FieldType\FieldType::getName` is now supported with a new signature similar to `eZ\Publish\SPI\FieldType\Nameable::getFieldName()`, which has been removed.
See [eZ Platform v3.0 project update](ez_platform_v3.0_project_update.md#field-types) for further information.

The deprecated `eZ\Publish\Core\FieldType\RichText` namespace has been removed, as it was moved to a separate bundle in v2.4.

The following classes and namespaces have been deprecated and dropped:

- `eZ\Publish\SPI\FieldType\EventListener` 
- `eZ\Publish\SPI\FieldType\Event`
- `eZ\Publish\SPI\FieldType\Events\**`

Deprecated `ezprice` and `ezpage` Field Types have been removed.

## Configuration through `ezplatform`

In YAML configuration, `ezplatform` is now used instead of `ezpublish` as the main configuration key.

## Assetic support

Assetic support has been dropped.

## Installers

### Custom Installers

The following Symfony Service definitions that provide extension point to create custom installers have been removed:

- `ezplatform.installer.clean_installer`
- `ezplatform.installer.db_based_installer`

### Enterprise Edition installer

The `ezstudio.installer.studio_installer` service has been renamed to the FQCN-named
service `EzSystems\EzPlatformEnterpriseEditionInstallerBundle\Installer\Installer`.
Deprecated `ezplatform.ee.installer.class` DIC parameter has been removed.

See [eZ Platform v3.0 project update instructions](./ez_platform_v3.0_project_update.md#custom-installers) for upgrade details.

## date-based-publisher

No deprecations or backward compatibility breaks to document.

## doctrine-dbal-schema

No deprecations or backward compatibility breaks to document.

## ez-support-tools

No deprecations or backward compatibility breaks to document.

## ezplatform-admin-ui

### Functions renamed

|Former name|New name|
|-----------|--------|
|`ez_is_field_empty`|`ez_field_is_empty`|
|`ezplatform_admin_ui_component_group`|`ez_render_component_group`|
|`ez_platform_tabs`|`ez_render_tab_group`|
|`ez_render_fielddefinition_edit`|`ez_render_field_definition_edit`|
|`ez_path_string_to_locations`|`ez_path_to_locations`|
|`ez_image_asset_content_field_identifier`|`ez_content_field_identifier_image_asset`|
|`encode_field`|`ez_field_encode`|
|`ez_http_tag_location`|`ez_http_cache_tag_location`|
|`ez_first_filled_image_field_identifier`|`ez_content_field_identifier_first_filled_image`|
|`ez_render_fielddefinition_settings`|`ez_render_field_definition_settings`|
|`encode_block_value`|`ez_block_value_encode`|
|`ezplatform_page_builder_cross_origin_helper`|`ez_page_builder_cross_origin_helper`|

### Twig helper renamed

Selected Twig helpers names have been changed.

Additionally, the `ez_trans_prop` Twig function has been removed.

### Global variables renamed

|Former name|New name|
|-----------|--------|
|`admin_ui_config`|`ez_admin_ui_config`|
|`ezpublish`|`ezplatform`|

### Filters renamed

|Former name|New name|
|-----------|--------|
|`richtext_to_html5`|`ez_richtext_to_html5`|
|`richtext_to_html5_edit`|`ez_richtext_to_html5_edit`|

### JavaScript

#### Event names changed

Selected event names have been changed.

|Former name|New name|
|-----------|--------|
|`invalidFileSize`|`ez-invalid-file-size`|
|`addressNotFound`|`ez-address-not-found`|
|`cancelErrors`|`ez-cancel-errors`|
|`ezsettings.default.content_type.about`|`ezsettings.admin_group.content_type.about`|
|`ezsettings.default.content_type.article`|`ezsettings.admin_group.content_type.article`|
|`ezsettings.default.content_type.blog`|`ezsettings.admin_group.content_type.blog`|
|`ezsettings.default.content_type.blog_post`|`ezsettings.admin_group.content_type.blog_post`|
|`ezsettings.default.content_type.folder`|`ezsettings.admin_group.content_type.folder`|
|`ezsettings.default.content_type.form`|`ezsettings.admin_group.content_type.form`|
|`ezsettings.default.content_type.place`|`ezsettings.admin_group.content_type.place`|
|`ezsettings.default.content_type.product`|`ezsettings.admin_group.content_type.product`|
|`ezsettings.default.content_type.field`|`ezsettings.admin_group.content_type.field`|
|`ezsettings.default.content_type.user`|`ezsettings.admin_group.content_type.user`|
|`ezsettings.default.content_type.user_group`|`ezsettings.admin_group.content_type.user_group`|
|`ezsettings.default.content_type.file`|`ezsettings.admin_group.content_type.file`|
|`ezsettings.default.content_type.gallery`|`ezsettings.admin_group.content_type.gallery`|
|`ezsettings.default.content_type.image`|`ezsettings.admin_group.content_type.image`|
|`ezsettings.default.content_type.video`|`ezsettings.admin_group.content_type.video`|
|`ezsettings.default.content_type.landing_page`|`ezsettings.admin_group.content_type.landing_page`|
|`ezsettings.default.content_type.default-config`|`ezsettings.admin_group.content_type.default-config`|
|`ezsettings.default.pagination.search_limit`|`ezsettings.admin_group.pagination.search_limit`|
|`ezsettings.default.pagination.trash_limit`|`ezsettings.admin_group.pagination.trash_limit`|
|`ezsettings.default.pagination.section_limit`|`ezsettings.admin_group.pagination.section_limit`|
|`ezsettings.default.pagination.language_limit`|`ezsettings.admin_group.pagination.language_limit`|
|`ezsettings.default.pagination.role_limit`|`ezsettings.admin_group.pagination.role_limit`|
|`ezsettings.default.pagination.content_type_group_limit`|`ezsettings.admin_group.pagination.content_type_group_limit`|
|`ezsettings.default.pagination.content_type_limit`|`ezsettings.admin_group.pagination.content_type_limit`|
|`ezsettings.default.pagination.role_assignment_limit`|`ezsettings.admin_group.pagination.role_assignment_limit`|
|`ezsettings.default.pagination.policy_limit`|`ezsettings.admin_group.pagination.policy_limit`|
|`ezsettings.default.pagination.version_draft_limit`|`ezsettings.admin_group.pagination.version_draft_limit`|
|`ezsettings.default.pagination.content_system_url_limit`|`ezsettings.admin_group.pagination.content_system_url_limit`|
|`ezsettings.default.pagination.content_custom_url_limit`|`ezsettings.admin_group.pagination.content_custom_url_limit`|
|`ezsettings.default.pagination.content_role_limit`|`ezsettings.admin_group.pagination.content_role_limit`|
|`ezsettings.default.pagination.content_policy_limit`|`ezsettings.admin_group.pagination.content_policy_limit`|
|`ezsettings.default.pagination.bookmark_limit`|`ezsettings.admin_group.pagination.bookmark_limit`|
|`ezsettings.default.pagination.notification_limit`|`ezsettings.admin_group.pagination.notification_limit`|
|`ezsettings.default.pagination.content_draft_limit`|`ezsettings.admin_group.pagination.content_draft_limit`|
|`ezsettings.default.security.token_interval_spec`|`ezsettings.admin_group.security.token_interval_spec`|
|`ezsettings.default.user_content_type_identifier`|`ezsettings.admin_group.user_content_type_identifier`|
|`ezsettings.default.user_group_content_type_identifier`|`ezsettings.admin_group.user_group_content_type_identifier`|
|`ezsettings.default.subtree_operations.copy_subtree.limit`|`ezsettings.admin_group.subtree_operations.copy_subtree.limit`|
|`ezsettings.default.notifications.error.timeout`|`ezsettings.admin_group.notifications.error.timeout`|
|`ezsettings.default.notifications.warning.timeout`|`ezsettings.admin_group.notifications.warning.timeout`|
|`ezsettings.default.notifications.success.timeout`|`ezsettings.admin_group.notifications.success.timeout`|
|`ezsettings.default.notifications.info.timeout`|`ezsettings.admin_group.notifications.info.timeout`|
|`ezsettings.default.content_tree_module.load_more_limit`|`ezsettings.admin_group.content_tree_module.load_more_limit`|
|`ezsettings.default.content_tree_module.children_load_max_limit`|`ezsettings.admin_group.content_tree_module.children_load_max_limit`|
|`ezsettings.default.content_tree_module.tree_max_depth`|`ezsettings.admin_group.content_tree_module.tree_max_depth`|
|`ezsettings.default.content_tree_module.allowed_content_types`|`ezsettings.admin_group.content_tree_module.allowed_content_types`|
|`ezsettings.default.content_tree_module.ignored_content_types`|`ezsettings.admin_group.content_tree_module.ignored_content_types`|
|`ezsettings.default.content_tree_module.tree_root_location_id`|`ezsettings.admin_group.content_tree_module.tree_root_location_id`|

### Template organization

#### Templates renamed

The following templates used in the Back Office have been renamed:

|Former name|New name|
|-----------|--------|
|admin/systeminfo/composer.html.twig|admin/system_info/composer.html.twig|
|admin/systeminfo/database.html.twig|admin/system_info/database.html.twig|
|admin/systeminfo/hardware.html.twig|admin/system_info/hardware.html.twig|
|admin/systeminfo/info.html.twig|admin/system_info/info.html.twig|
|admin/systeminfo/php.html.twig|admin/system_info/php.html.twig|
|admin/systeminfo/symfony_kernel.html.twig|admin/system_info/symfony_kernel.html.twig|
|content/content_edit/parts/javascripts.html.twig|content/content_edit/part/javascripts.html.twig|
|content/content_edit/parts/stylesheets.html.twig|content/content_edit/part/stylesheets.html.twig|
|content/locationview.html.twig|content/location_view.html.twig|
|content/widgets/content_create.html.twig|content/widget/content_create.html.twig|
|content/widgets/content_edit.html.twig|content/widget/content_edit.html.twig|
|content/widgets/user_edit.html.twig|content/widget/user_edit.html.twig|
|errors/403.html.twig|error/403.html.twig|
|errors/404.html.twig|error/404.html.twig|
|errors/error.html.twig|error/error.html.twig|
|fieldtypes/edit/binary_base.html.twig|field_type/edit/binary_base.html.twig|
|fieldtypes/edit/binary_base_fields.html.twig|field_type/edit/binary_base_fields.html.twig|
|fieldtypes/edit/ezauthor.html.twig|field_type/edit/ezauthor.html.twig|
|fieldtypes/edit/ezbinaryfile.html.twig|field_type/edit/ezbinaryfile.html.twig|
|fieldtypes/edit/ezboolean.html.twig|field_type/edit/ezboolean.html.twig|
|fieldtypes/edit/ezdate.html.twig|field_type/edit/ezdate.html.twig|
|fieldtypes/edit/ezdatetime.html.twig|field_type/edit/ezdatetime.html.twig|
|fieldtypes/edit/ezgmaplocation.html.twig|field_type/edit/ezgmaplocation.html.twig|
|fieldtypes/edit/ezimage.html.twig|field_type/edit/ezimage.html.twig|
|fieldtypes/edit/ezimageasset.html.twig|field_type/edit/ezimageasset.html.twig|
|fieldtypes/edit/ezkeyword.html.twig|field_type/edit/ezkeyword.html.twig|
|fieldtypes/edit/ezmedia.html.twig|field_type/edit/ezmedia.html.twig|
|fieldtypes/edit/ezobjectrelation.html.twig|field_type/edit/ezobjectrelation.html.twig|
|fieldtypes/edit/ezobjectrelationlist.html.twig|field_type/edit/ezobjectrelationlist.html.twig|
|fieldtypes/edit/ezrichtext.html.twig|field_type/edit/ezrichtext.html.twig|
|fieldtypes/edit/ezselection.html.twig|field_type/edit/ezselection.html.twig|
|fieldtypes/edit/eztime.html.twig|field_type/edit/eztime.html.twig|
|fieldtypes/edit/ezuser.html.twig|field_type/edit/ezuser.html.twig|
|fieldtypes/edit/relation_base.html.twig|field_type/edit/relation_base.html.twig|
|fieldtypes/preview/content_fields.html.twig|field_type/preview/content_fields.html.twig|
|fieldtypes/preview/ezimageasset.html.twig|field_type/preview/ezimageasset.html.twig|
|fieldtypes/preview/ezobjectrelationlist_row.html.twig|field_type/preview/ezobjectrelationlist_row.html.twig|
|Limitation/null_limitation_values.html.twig|limitation/null_limitation_values.html.twig|
|Limitation/udw_limitation_value.html.twig|limitation/udw_limitation_value.html.twig|
|Limitation/udw_limitation_value_list_item.html.twig|limitation/udw_limitation_value_list_item.html.twig|
|parts/breadcrumbs.html.twig|part/breadcrumbs.html.twig|
|parts/form/assign_section_widget.html.twig|part/form/assign_section_widget.html.twig|
|parts/form/flat_widgets.html.twig|part/form/flat_widgets.html.twig|
|parts/location_bookmark.html.twig|part/location_bookmark.html.twig|
|parts/menu/sidebar_base.html.twig|part/menu/sidebar_base.html.twig|
|parts/menu/sidebar_right.html.twig|part/menu/sidebar_right.html.twig|
|parts/menu/sidebar_left.html.twig|part/menu/sidebar_left.html.twig|
|parts/menu/top_menu.html.twig|part/menu/top_menu.html.twig|
|parts/menu/top_menu_2nd_level.html.twig|part/menu/top_menu_2nd_level.html.twig|
|parts/menu/top_menu_base.html.twig|part/menu/top_menu_base.html.twig|
|parts/menu/user_menu.html.twig|part/menu/user_menu.html.twig|
|parts/navigation.html.twig|part/navigation.html.twig|
|parts/notification.html.twig|part/notification.html.twig|
|parts/page_title.html.twig|part/page_title.html.twig|
|parts/path.html.twig|part/path.html.twig|
|parts/tab/content_type.html.twig|part/tab/content_type.html.twig|
|parts/tab/default.html.twig|part/tab/default.html.twig|
|parts/tab/locationview.html.twig|part/tab/location_view.html.twig|
|parts/tab/system_info.html.twig|part/tab/system_info.html.twig|
|parts/table_header.html.twig|part/table_header.html.twig|
|parts/tag.html.twig|part/tag.html.twig|
|Security/base.html.twig|security/base.html.twig|
|Security/forgot_user_password/index.html.twig|security/forgot_user_password/index.html.twig|
|Security/forgot_user_password/success.html.twig|security/forgot_user_password/success.html.twig|
|Security/forgot_user_password/with_login.html.twig|security/forgot_user_password/with_login.html.twig|
|Security/form_fields.html.twig|security/form_fields.html.twig|
|Security/login.html.twig|security/login.html.twig|
|Security/mail/forgot_user_password.html.twig|security/mail/forgot_user_password.html.twig|
|Security/reset_user_password/index.html.twig|security/reset_user_password/index.html.twig|
|Security/reset_user_password/invalid_link.html.twig|security/reset_user_password/invalid_link.html.twig|
|Security/reset_user_password/success.html.twig|security/reset_user_password/success.html.twig|
|user-profile/change_user_password.html.twig|user_profile/change_user_password.html.twig|
|user-profile/form_fields.html.twig|user_profile/form_fields.html.twig|

#### Templates relocated


|Template name|Former location|New location|
|------------|---------------|------------|
|`@ezdesign/account/error/credentials_expired.html.twig`|`src/bundle/Resources/views/Security/error`|`src/bundle/Resources/views/themes/admin/account/error`|

For details, see [Template configuration](#template-configuration).

### Online Editor

All Online Editor front-end code and assets (such as JS, CSS, fonts, etc.)
have been moved from `ezplatform-admin-ui` to `ezplatform-richtext`.

### Adding new tabs in the Back Office

The way of adding custom tab groups in the Back Office has changed.
You now need to [make use of the `TabsComponent`](../guide/extending/extending_tabs.md#adding-a-new-tab-group).

### Code cleanup

The following deprecated items have been removed: 

|Removed code|Belongs to|Use instead|
|------------|----------|-----------|
|`canEdit`|`EzSystems\EzPlatformAdminUiBundle\Controller\LanguageController::viewAction`|`can_administrate`|
|`canAssign`|`EzSystems\EzPlatformAdminUiBundle\Controller\LanguageController::viewAction`|`can_administrate`|
|`baseLanguage`|`EzSystems\EzPlatformAdminUi\EventListener\ContentTranslateViewFilterParametersListener::onFilterViewParameters`|`base_language`|
|`contentType`|`EzSystems\EzPlatformAdminUi\EventListener\ContentTranslateViewFilterParametersListener::onFilterViewParameters`|`content_type`|
|`isPublished`|`EzSystems\EzPlatformAdminUi\EventListener\ContentTranslateViewFilterParametersListener::onFilterViewParameters`|`ContentInfo::isPublished`|
|`fieldDefinitionsByGroup`|`EzSystems\EzPlatformAdminUi\Tab\LocationView\ContentTab`| `field_definitions_by_group` |
|`full`|`window.eZ.adminUiConfig.dateFormat`| `fullDateTime` |
|`short`|`window.eZ.adminUiConfig.dateFormat`| `shortDateTime` |
|`limit`|`EzSystems\EzPlatformAdminUi\UI\Module\Subitems\ContentViewParameterSupplier`| - |
|`contentTypeNames`|`window.eZ.adminUiConfig`|`contentTypes`|

##### SubtreeQuery

Deprecated `SubtreeQuery` class has been removed. In v3.0, it was replaced by `EzSystems\EzPlatformAdminUi\QueryType\SubtreeQueryType`.

### Permission Choice Loaders

The following choiceLoaders classes deprecated in v2.5 have been removed:

- `EzSystems\EzPlatformAdminUi\Form\Type\ChoiceList\Loader\PermissionAwareContentTypeChoiceLoader`
- `EzSystems\EzPlatformAdminUi\Form\Type\ChoiceList\Loader\PermissionAwareLanguageChoiceLoader`

Instead, use the following classes:

- `EzSystems\EzPlatformAdminUi\Form\Type\ChoiceList\Loader\ContentCreateContentTypeChoiceLoader`
- `EzSystems\EzPlatformAdminUi\Form\Type\ChoiceList\Loader\ContentCreateLanguageChoiceLoader`

## ezplatform-admin-ui-assets

No deprecations or backward compatibility breaks to document.

## ezplatform-admin-ui-modules

### Universal Discovery Widget

The deprecated `universal_discovery_widget_module.default_location_id` setting has been replaced with `universal_discovery_widget_module.configuration.default.starting_location_id`.

## ezplatform-core

No deprecations or backward compatibility breaks to document.

## ezplatform-cron

No deprecations or backward compatibility breaks to document.

## ezplatform-design-engine

No deprecations or backward compatibility breaks to document.

## ezplatform-graphql

No deprecations or backward compatibility breaks to document.

## ezplatform-http-cache

HTTP cache bundle now uses FOS Cache Bundle v2. 

This entails that:

- `EzSystems\PlatformHttpCacheBundle\Proxy\TagAwareStore` has been removed.
- `EzSystems\PlatformHttpCacheBundle\Handler\TagHandler` has been changed so that the tag is now provided as an option in `header_formatter`.
- `tagResponse()` from `tagHandler` has been replaced by `tagSymfonyResponse()`.
- Deprecated `EzSystems\PlatformHttpCacheBundle\Handler\TagHandlerInterface` has been removed.
- `EzSystems\PlatformHttpCacheBundle\PurgeClient\PurgeClientInterface` now only accepts an array as argument in the `purge()` method, instead of an int.
- The `X-User-Hash` header for recognizing user context has been changed to `X-User-Context-Hash`.
- The `key` header for purging tags has been changed to `xkey-softpurge`.
- The `PURGE` method has been changed to `PURGEKEY`.
- The `ezplatform.http_cache.tags.header` parameter has been removed. Configuration now relies on FOS Cache configuration and its default values.

## ezplatform-ee-installer

No deprecations or backward compatibility breaks to document.

## ezplatform-form-builder

### JavaScript

#### Event names changed

The following event names have been changed:

|Former name|New name|
|-----------|--------|
|`openUdw`|`ez-open-udw`|
|`updateFieldName`|`ez-update-field-name`|
|`fbFormBuilderLoaded`|`ez-form-builder-loaded`|
|`fbFormBuilderUnloaded`|`ez-form-builder-unloaded`

## ezplatform-page-builder

#### JavaScript

#### Event names changed

The following event names have been changed:

|Former name|New name|
|-----------|--------|
|`openUdw`|`ez-open-udw`|
|`openAirtimePopup`|`ez-open-airtime-popup`|
|`postUpdateBlocksPreview`|`ez-post-update-blocks-preview`|
|`pbIframeLoaded`|`ez-page-builder-iframe-loaded`|
|`pbHideTools`|`ez-page-builder-hide-tools`|

Additionally, the listener for `pbPreviewReloaded` has been removed.

## ezplatform-page-fieldtype

No deprecations or backward compatibility breaks to document.

## ezplatform-matrix-fieldtype

No deprecations or backward compatibility breaks to document.

## ezplatform-rest

No deprecations or backward compatibility breaks to document.

## ezplatform-richtext

### Online Editor

Configuration providers exposing the following JavaScript variables have been dropped:

- `eZ.adminUiConfig.alloyEditor` replaced by `eZ.richText.alloyEditor`
- `eZ.adminUiConfig.richTextCustomTags` replaced by `eZ.richText.customTags`
- `eZ.adminUiConfig.richTextCustomStyles` replaced by `eZ.richtext.customStyles`

The following Webpack Encore entries have been changed:

- `ezplatform-admin-ui-alloyeditor-css` replaced by `ezplatform-richtext-onlineeditor-css`
- `ezplatform-admin-ui-alloyeditor-js` replaced by `ezplatform-richtext-onlineeditor-js`

All Online Editor front-end code and assets (such as JS, CSS, fonts, etc.)
have been moved from `ezplatform-admin-ui` to `ezplatform-richtext`.

### View matching

When matching views using custom services, the services must be now tagged with `ezplatform.view.matcher`.
The matching must be configured in the following way:

``` yaml
content_view:
    full:
        folder:
            template: folder.html.twig
            match:
                '@App\Matcher\MyMatcher': ~
```

## ezplatform-solr-search-engine

No deprecations or backward compatibility breaks to document.

## ezplatform-standard-design

No deprecations or backward compatibility breaks to document.

## ezplatform-user

### User settings

As a result of moving user settings to the [`ezplatform-user`](https://github.com/ezsystems/ezplatform-user) package,
the following deprecated code for handling the settings has been dropped:

- `EzSystems\EzPlatformAdminUi\UserSetting\`
- `EzSystems\EzPlatformAdminUi\Pagination\Pagerfanta\UserSettingsAdapter`
- `EzSystems\EzPlatformAdminUi\Form\Type\User\Setting\UserSettingUpdateType`
- `EzSystems\EzPlatformAdminUiBundle\Controller\UserProfile\UserPasswordChangeController`
- `EzSystems\EzPlatformAdminUiBundle\Controller\User\{UserSettingsController,UserForgotPasswordController}`

## ezplatform-workflow

No deprecations or backward compatibility breaks to document.

## ezpublish-kernel

### Elastic Search

Experimental, deprecated and unsupported code for Elastic Search 1.4.2 has been dropped from kernel,
to be replaced with a dedicated bundle for the latest Elastic version in the future.

### REST server

Transfer of REST code from kernel to a separate package results in the following change:

- The `eZ\Publish\Core\REST` and `eZ\Publish\Core\REST\Common\` namespaces have been replaced by `EzSystems\EzPlatformRest`.
- REST client has been dropped.

### SiteAccess matching

When matching SiteAccesses using custom services, the SiteAccess matcher service must be now tagged with `ezplatform.siteaccess.matcher`.

### Database

The following obsolete tables have been removed from the database schema:

??? note "Removed database tables"

    - ezapprove_items
    - ezbasket
    - ezcollab_group
    - ezcollab_item
    - ezcollab_item_group_link
    - ezcollab_item_message_link
    - ezcollab_item_participant_link
    - ezcollab_item_status
    - ezcollab_notification_rule
    - ezcollab_profile
    - ezcollab_simple_message
    - ezcomment
    - ezcomment_notification
    - ezcomment_subscriber
    - ezcomment_subscription
    - ezcontentbrowserecent
    - ezcurrencydata
    - ezdiscountrule
    - ezdiscountsubrule
    - ezdiscountsubrule_value
    - ezenumobjectvalue
    - ezenumvalue
    - ezforgot_password
    - ezgeneral_digest_user_settings
    - ezinfocollection
    - ezinfocollection_attribute
    - ezisbn_group
    - ezisbn_group_range
    - ezisbn_registrant_range
    - ezm_block
    - ezm_pool
    - ezmessage
    - ezmodule_run
    - ezmultipricedata
    - eznotificationcollection
    - eznotificationcollection_item
    - eznotificationevent
    - ezoperation_memento
    - ezorder
    - ezorder_item
    - ezorder_nr_incr
    - ezorder_status
    - ezorder_status_history
    - ezpaymentobject
    - ezpdf_export
    - ezpending_actions
    - ezprest_authcode
    - ezprest_authorized_clients
    - ezprest_clients
    - ezprest_token
    - ezproductcategory
    - ezproductcollection
    - ezproductcollection_item
    - ezproductcollection_item_opt
    - ezpublishingqueueprocesses
    - ezrss_export
    - ezrss_export_item
    - ezrss_import
    - ezscheduled_script
    - ezsearch_search_phrase
    - ezsession
    - ezsubtree_notification_rule
    - eztipafriend_counter
    - eztipafriend_request
    - eztrigger
    - ezuservisit
    - ezuser_discountrule
    - ezvatrule
    - ezvatrule_product_category
    - ezvattype
    - ezview_counter
    - ezwaituntildatevalue
    - ezwishlist
    - ezworkflow
    - ezworkflow_assign
    - ezworkflow_event
    - ezworkflow_group
    - ezworkflow_group_link
    - ezworkflow_process

You can drop unused tables from your database by executing:

``` sql
DROP TABLE <table_name>;
```

- The "Setup" folder and Section have been removed from clean installation data.
- The "Design" Section has been removed from clean installation data.

### Symfony Services

The `date_based_publisher.permission_resolver` Symfony Service deprecated in v2.5 has been removed. 
Instead, you can inject `eZ\Publish\API\Repository\PermissionResolver` and rely on auto-wiring.

### Template parameter names

The SiteAccess-aware `pagelayout` setting is deprecated in favor of `page_layout`.

View parameter `pagelayout` set by `pagelayout` setting is deprecated in favor of  `page_layout`.

## flex-workflow

No deprecations or backward compatibility breaks to document.

## repository-forms

No deprecations or backward compatibility breaks to document.
