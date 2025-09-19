---
description: Events that are triggered when working with bookmarks, notifications, settings, forms and others.
page_type: reference
month_change: true
---

# Other events

## Bookmarks

The following events are dispatched when adding content items to bookmarks.

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateBookmarkEvent`|`BookmarkService::createBookmark`|`Location $location`|
|`CreateBookmarkEvent`|`BookmarkService::createBookmark`|`Location $location`|
|`BeforeDeleteBookmarkEvent`|`BookmarkService::deleteBookmark`|`Location $location`|
|`DeleteBookmarkEvent`|`BookmarkService::deleteBookmark`|`Location $location`|

## Notifications

The following events refer to [notifications displayed in the user menu](notifications.md#create-custom-notifications).

| Event | Dispatched by | Properties |
|---|---|---|
|[`BeforeCreateNotificationEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Events-Notification-BeforeCreateNotificationEvent.html)|[`NotificationService::createNotification`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html#method_createNotification)|`CreateStruct $createStruct`</br>`Notification|null $notification`|
|[`CreateNotificationEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Events-Notification-CreateNotificationEvent.html)|[`NotificationService::createNotification`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html#method_createNotification)|`Notification $notification`</br>`CreateStruct $createStruct`|
|[`BeforeDeleteNotificationEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Events-Notification-BeforeDeleteNotificationEvent.html)|[`NotificationService::deleteNotification`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html#method_deleteNotification)|`Notification $notification`|
|[`DeleteNotificationEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Events-Notification-DeleteNotificationEvent.html)|[`NotificationService::deleteNotification`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html#method_deleteNotification)|`Notification $notification`|
|[`BeforeMarkNotificationAsReadEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Events-Notification-BeforeMarkNotificationAsReadEvent.html)|[`NotificationService::markNotificationAsRead`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html#method_markNotificationAsRead)|`Notification $notification`|
|[`MarkNotificationAsReadEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Events-Notification-MarkNotificationAsReadEvent.html)|[`NotificationService::markNotificationAsRead`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html#method_markNotificationAsRead)|`Notification $notification`|
|[`BeforeMarkNotificationAsUnreadEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Events-Notification-BeforeMarkNotificationAsUnreadEvent.html)|[`NotificationService::markNotificationAsUnread`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html#method_markNotificationAsUnread)|`Notification $notification`|
|[`MarkNotificationAsUnreadEvent`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Events-Notification-MarkNotificationAsUnreadEvent.html)|[`NotificationService::markNotificationAsUnread`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html#method_markNotificationAsUnread)|`Notification $notification`|

## Settings

The following events refer to key/value application-wide settings in database.

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateSettingEvent`|`SettingService::createSetting`|`SettingCreateStruct $settingCreateStruct`</br>`Setting|null $setting`|
|`CreateSettingEvent`|`SettingService::createSetting`|`Setting $setting`</br>`SettingCreateStruct $settingCreateStruct`|
|`BeforeUpdateSettingEvent`|`SettingService::updateSetting`|`Setting $setting`</br>`SettingUpdateStruct $settingUpdateStruct`</br>`Setting|null $updatedSetting`|
|`UpdateSettingEvent`|`SettingService::updateSetting`|`Setting $updatedSetting`</br>`Setting $setting`</br>`SettingUpdateStruct $settingUpdateStruct`|
|`BeforeDeleteSettingEvent`|`SettingService::deleteSetting`|`Setting $setting`|
|`DeleteSettingEvent`|`SettingService::deleteSetting`|`Setting $setting`|

## User preferences

The following events are dispatched when changing the user settings available in the user menu.

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeSetUserPreferenceEvent`|`UserPreferenceService::setUserPreference`|`UserPreferenceSetStruct[] $userPreferenceSetStructs`|
|`SetUserPreferenceEvent`|`UserPreferenceService::setUserPreference`|`UserPreferenceSetStruct[] $userPreferenceSetStructs`|

## DAM assets

| Event | Dispatched by | Properties |
|---|---|---|
|`PublishVersionEvent`|`PublishAssetEventDispatcher::emitPublishAssetEvent`|`Content $content`</br>`Connector\Dam\AssetIdentifier $assetIdentifier`</br>`Connector\Dam\AssetSource $assetSource`|

## Form Builder [[% include 'snippets/experience_badge.md' %]] [[% include 'snippets/commerce_badge.md' %]]

| Event | Dispatched by | Properties |
|---|---|---|
|`FieldAttributeDefinitionEvent`|`FieldDefinitionFactory::getAttributesDefinitions`|`FieldAttributeDefinitionBuilder $definitionBuilder`</br>`array $configuration`|
|`FieldDefinitionEvent`|`FieldDefinitionFactory::getFieldDefinition`|`FieldDefinitionBuilder $definitionBuilder`</br>`array $configuration`|
|`FieldValidatorDefinitionEvent`|`FieldDefinitionFactory::getValidatorsDefinitions`|`FieldDefinitionBuilder $definitionBuilder`</br>`array $configuration`|
|`FormActionEvent`|`HandleFormSubmission::handleFormSubmission`|`ContentView $contentView`</br>`Ibexa\Contracts\FormBuilder\FieldType\Model\Form  $form`</br>`string $action`</br>`mixed  $data`|
|`FormSubmitEvent`|`HandleFormSubmission::handleFormSubmission`|`ContentView $contentView`</br>`Ibexa\Contracts\FormBuilder\FieldType\Model\Form $form`</br>`array $data`|
