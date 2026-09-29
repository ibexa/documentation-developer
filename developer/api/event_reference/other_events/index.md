# Other events

Events that are triggered when working with bookmarks, notifications, settings, forms and others.

## Bookmarks

The following events are dispatched when adding content items to bookmarks.

| Event                       | Dispatched by                     | Properties           |
| --------------------------- | --------------------------------- | -------------------- |
| `BeforeCreateBookmarkEvent` | `BookmarkService::createBookmark` | `Location $location` |
| `CreateBookmarkEvent`       | `BookmarkService::createBookmark` | `Location $location` |
| `BeforeDeleteBookmarkEvent` | `BookmarkService::deleteBookmark` | `Location $location` |
| `DeleteBookmarkEvent`       | `BookmarkService::deleteBookmark` | `Location $location` |

## Notifications

The following events refer to [notifications displayed in the user menu](../../../administration/back_office/notifications/index.md#user-notifications).

| Event                                                                                                                                                                                                   | Dispatched by                                                                                                                                                                                                 | Properties                                                 |
| ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ---------------------------------------------------------- |
| [`Ibexa\Contracts\Core\Repository\Events\Notification\BeforeCreateNotificationEvent`](../../../../../../ibexa/core/src/contracts/Repository/Events/Notification/BeforeCreateNotificationEvent.php)             | [`NotificationService::createNotification`](../../../../../../ibexa/core/src/contracts/Repository/NotificationService.php)             | `CreateStruct $createStruct` `?Notification $notification` |
| [`Ibexa\Contracts\Core\Repository\Events\Notification\CreateNotificationEvent`](../../../../../../ibexa/core/src/contracts/Repository/Events/Notification/CreateNotificationEvent.php)                         | [`NotificationService::createNotification`](../../../../../../ibexa/core/src/contracts/Repository/NotificationService.php)             | `Notification $notification` `CreateStruct $createStruct`  |
| [`Ibexa\Contracts\Core\Repository\Events\Notification\BeforeDeleteNotificationEvent`](../../../../../../ibexa/core/src/contracts/Repository/Events/Notification/BeforeDeleteNotificationEvent.php)             | [`NotificationService::deleteNotification`](../../../../../../ibexa/core/src/contracts/Repository/NotificationService.php)             | `Notification $notification`                               |
| [`Ibexa\Contracts\Core\Repository\Events\Notification\DeleteNotificationEvent`](../../../../../../ibexa/core/src/contracts/Repository/Events/Notification/DeleteNotificationEvent.php)                         | [`NotificationService::deleteNotification`](../../../../../../ibexa/core/src/contracts/Repository/NotificationService.php)             | `Notification $notification`                               |
| [`Ibexa\Contracts\Core\Repository\Events\Notification\BeforeMarkNotificationAsReadEvent`](../../../../../../ibexa/core/src/contracts/Repository/Events/Notification/BeforeMarkNotificationAsReadEvent.php)     | [`NotificationService::markNotificationAsRead`](../../../../../../ibexa/core/src/contracts/Repository/NotificationService.php)     | `Notification $notification`                               |
| [`Ibexa\Contracts\Core\Repository\Events\Notification\MarkNotificationAsReadEvent`](../../../../../../ibexa/core/src/contracts/Repository/Events/Notification/MarkNotificationAsReadEvent.php)                 | [`NotificationService::markNotificationAsRead`](../../../../../../ibexa/core/src/contracts/Repository/NotificationService.php)     | `Notification $notification`                               |
| [`Ibexa\Contracts\Core\Repository\Events\Notification\BeforeMarkNotificationAsUnreadEvent`](../../../../../../ibexa/core/src/contracts/Repository/Events/Notification/BeforeMarkNotificationAsUnreadEvent.php) | [`NotificationService::markNotificationAsUnread`](../../../../../../ibexa/core/src/contracts/Repository/NotificationService.php) | `Notification $notification`                               |
| [`Ibexa\Contracts\Core\Repository\Events\Notification\MarkNotificationAsUnreadEvent`](../../../../../../ibexa/core/src/contracts/Repository/Events/Notification/MarkNotificationAsUnreadEvent.php)             | [`NotificationService::markNotificationAsUnread`](../../../../../../ibexa/core/src/contracts/Repository/NotificationService.php) | `Notification $notification`                               |

## Settings

The following events refer to key/value application-wide settings in database.

| Event                      | Dispatched by                   | Properties                                                                               |
| -------------------------- | ------------------------------- | ---------------------------------------------------------------------------------------- |
| `BeforeCreateSettingEvent` | `SettingService::createSetting` | `SettingCreateStruct $settingCreateStruct` `?Setting $setting`                           |
| `CreateSettingEvent`       | `SettingService::createSetting` | `Setting $setting` `SettingCreateStruct $settingCreateStruct`                            |
| `BeforeUpdateSettingEvent` | `SettingService::updateSetting` | `Setting $setting` `SettingUpdateStruct $settingUpdateStruct` `?Setting $updatedSetting` |
| `UpdateSettingEvent`       | `SettingService::updateSetting` | `Setting $updatedSetting` `Setting $setting` `SettingUpdateStruct $settingUpdateStruct`  |
| `BeforeDeleteSettingEvent` | `SettingService::deleteSetting` | `Setting $setting`                                                                       |
| `DeleteSettingEvent`       | `SettingService::deleteSetting` | `Setting $setting`                                                                       |

## User preferences

The following events are dispatched when changing the user settings available in the user menu.

| Event                          | Dispatched by                              | Properties                                            |
| ------------------------------ | ------------------------------------------ | ----------------------------------------------------- |
| `BeforeSetUserPreferenceEvent` | `UserPreferenceService::setUserPreference` | `UserPreferenceSetStruct[] $userPreferenceSetStructs` |
| `SetUserPreferenceEvent`       | `UserPreferenceService::setUserPreference` | `UserPreferenceSetStruct[] $userPreferenceSetStructs` |

## DAM assets

| Event                 | Dispatched by                                        | Properties                                                                                                   |
| --------------------- | ---------------------------------------------------- | ------------------------------------------------------------------------------------------------------------ |
| `PublishVersionEvent` | `PublishAssetEventDispatcher::emitPublishAssetEvent` | `Content $content` `Connector\Dam\AssetIdentifier $assetIdentifier` `Connector\Dam\AssetSource $assetSource` |

## Image Editor

The following event is dispatched when the Image Editor optimizes an image. You can subscribe to it to customize the list of active image optimizers at runtime.

For more information, see [Customizing image optimizers with an event](../../../content_management/images/images/index.md#customizing-image-optimizers).

| Event                                                                                                                                                                     | Dispatched by                       | Properties                                           |
| ------------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ----------------------------------- | ---------------------------------------------------- |
| [`Ibexa\Contracts\ImageEditor\Event\ConfigureImageOptimizersEvent`](../../../../../../ibexa/image-editor/src/contracts/Event/ConfigureImageOptimizersEvent.php) | `SpatieChainOptimizer::` `optimize` | `array<Spatie\ImageOptimizer\Optimizer> $optimizers` |

## Form Builder (Experience, Commerce)

| Event                           | Dispatched by                                      | Properties                                                                                                         |
| ------------------------------- | -------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------ |
| `FieldAttributeDefinitionEvent` | `FieldDefinitionFactory::getAttributesDefinitions` | `FieldAttributeDefinitionBuilder $definitionBuilder` `array $configuration`                                        |
| `FieldDefinitionEvent`          | `FieldDefinitionFactory::getFieldDefinition`       | `FieldDefinitionBuilder $definitionBuilder` `array $configuration`                                                 |
| `FieldValidatorDefinitionEvent` | `FieldDefinitionFactory::getValidatorsDefinitions` | `FieldDefinitionBuilder $definitionBuilder` `array $configuration`                                                 |
| `FormActionEvent`               | `HandleFormSubmission::handleFormSubmission`       | `ContentView $contentView` `Ibexa\Contracts\FormBuilder\FieldType\Model\Form $form` `string $action` `mixed $data` |
| `FormSubmitEvent`               | `HandleFormSubmission::handleFormSubmission`       | `ContentView $contentView` `Ibexa\Contracts\FormBuilder\FieldType\Model\Form $form` `array $data`                  |
