# Content type events

Events that are triggered when working with content types.

| Event                                | Dispatched by                                 | Properties                                                                                                          |
| ------------------------------------ | --------------------------------------------- | ------------------------------------------------------------------------------------------------------------------- |
| `BeforeCreateContentTypeDraftEvent`  | `ContentTypeService::createContentTypeDraft`  | `ContentType $contentType` `?ContentTypeDraft $contentTypeDraft`                                                    |
| `CreateContentTypeDraftEvent`        | `ContentTypeService::createContentTypeDraft`  | `ContentTypeDraft $contentTypeDraft` `ContentType $contentType`                                                     |
| `BeforeCreateContentTypeEvent`       | `ContentTypeService::createContentType`       | `ContentTypeCreateStruct $contentTypeCreateStruct` `array $contentTypeGroups` `?ContentTypeDraft $contentTypeDraft` |
| `CreateContentTypeEvent`             | `ContentTypeService::createContentType`       | `ContentTypeDraft $contentTypeDraft` `ContentTypeCreateStruct $contentTypeCreateStruct` `array $contentTypeGroups`  |
| `BeforeUpdateContentTypeDraftEvent`  | `ContentTypeService::updateContentTypeDraft`  | `ContentTypeDraft $contentTypeDraft` `ContentTypeUpdateStruct $contentTypeUpdateStruct`                             |
| `UpdateContentTypeDraftEvent`        | `ContentTypeService::updateContentTypeDraft`  | `ContentTypeDraft $contentTypeDraft` `ContentTypeUpdateStruct $contentTypeUpdateStruct`                             |
| `BeforeCopyContentTypeEvent`         | `ContentTypeService::copyContentType`         | `ContentType $contentType` `User $creator` `?ContentType $contentTypeCopy`                                          |
| `CopyContentTypeEvent`               | `ContentTypeService::copyContentType`         | `ContentType $contentTypeCopy` `ContentType $contentType` `User $creator`                                           |
| `BeforePublishContentTypeDraftEvent` | `ContentTypeService::publishContentTypeDraft` | `ContentTypeDraft $contentTypeDraft`                                                                                |
| `PublishContentTypeDraftEvent`       | `ContentTypeService::publishContentTypeDraft` | `ContentTypeDraft $contentTypeDraft`                                                                                |
| `BeforeDeleteContentTypeEvent`       | `ContentTypeService::deleteContentType`       | `ContentType $contentType`                                                                                          |
| `DeleteContentTypeEvent`             | `ContentTypeService::deleteContentType`       | `ContentType $contentType`                                                                                          |

## Content type groups

| Event                               | Dispatched by                                | Properties                                                                                                          |
| ----------------------------------- | -------------------------------------------- | ------------------------------------------------------------------------------------------------------------------- |
| `BeforeCreateContentTypeGroupEvent` | `ContentTypeService::createContentTypeGroup` | `ContentTypeCreateStruct $contentTypeCreateStruct` `array $contentTypeGroups` `?ContentTypeDraft $contentTypeDraft` |
| `CreateContentTypeGroupEvent`       | `ContentTypeService::createContentTypeGroup` | `ContentTypeGroup $contentTypeGroup` `ContentTypeGroupCreateStruct $contentTypeGroupCreateStruct`                   |
| `BeforeUpdateContentTypeGroupEvent` | `ContentTypeService::updateContentTypeGroup` | `ContentTypeGroup $contentTypeGroup` `ContentTypeGroupUpdateStruct $contentTypeGroupUpdateStruct`                   |
| `UpdateContentTypeGroupEvent`       | `ContentTypeService::updateContentTypeGroup` | `ContentTypeGroup $contentTypeGroup` `ContentTypeGroupUpdateStruct $contentTypeGroupUpdateStruct`                   |
| `BeforeDeleteContentTypeGroupEvent` | `ContentTypeService::deleteContentTypeGroup` | `ContentTypeGroup $contentTypeGroup`                                                                                |
| `DeleteContentTypeGroupEvent`       | `ContentTypeService::deleteContentTypeGroup` | `ContentTypeGroup $contentTypeGroup`                                                                                |

## Content type translations

| Event                                     | Dispatched by                                      | Properties                                                                                           |
| ----------------------------------------- | -------------------------------------------------- | ---------------------------------------------------------------------------------------------------- |
| `BeforeRemoveContentTypeTranslationEvent` | `ContentTypeService::removeContentTypeTranslation` | `ContentTypeDraft $contentTypeDraft` `string $languageCode` `?ContentTypeDraft $newContentTypeDraft` |
| `RemoveContentTypeTranslationEvent`       | `ContentTypeService::removeContentTypeTranslation` | `ContentTypeDraft $newContentTypeDraft` `ContentTypeDraft $contentTypeDraft` `string $languageCode`  |

## Field definitions

| Event                              | Dispatched by                               | Properties                                                                                                                         |
| ---------------------------------- | ------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------- |
| `BeforeAddFieldDefinitionEvent`    | `ContentTypeService::addFieldDefinition`    | `ContentTypeDraft $contentTypeDraft` `FieldDefinitionCreateStruct $fieldDefinitionCreateStruct`                                    |
| `AddFieldDefinitionEvent`          | `ContentTypeService::addFieldDefinition`    | `ContentTypeDraft $contentTypeDraft` `FieldDefinitionCreateStruct $fieldDefinitionCreateStruct`                                    |
| `BeforeUpdateFieldDefinitionEvent` | `ContentTypeService::updateFieldDefinition` | `ContentTypeDraft $contentTypeDraft` `FieldDefinition $fieldDefinition` `FieldDefinitionUpdateStruct $fieldDefinitionUpdateStruct` |
| `UpdateFieldDefinitionEvent`       | `ContentTypeService::updateFieldDefinition` | `ContentTypeDraft $contentTypeDraft` `FieldDefinition $fieldDefinition` `FieldDefinitionUpdateStruct $fieldDefinitionUpdateStruct` |
| `BeforeRemoveFieldDefinitionEvent` | `ContentTypeService::removeFieldDefinition` | `ContentTypeDraft $contentTypeDraft` `FieldDefinition $fieldDefinition`                                                            |
| `RemoveFieldDefinitionEvent`       | `ContentTypeService::removeFieldDefinition` | `ContentTypeDraft $contentTypeDraft` `FieldDefinition $fieldDefinition`                                                            |

## Assigning to groups

| Event                                 | Dispatched by                                  | Properties                                                      |
| ------------------------------------- | ---------------------------------------------- | --------------------------------------------------------------- |
| `BeforeAssignContentTypeGroupEvent`   | `ContentTypeService::assignContentTypeGroup`   | `ContentType $contentType` `ContentTypeGroup $contentTypeGroup` |
| `AssignContentTypeGroupEvent`         | `ContentTypeService::assignContentTypeGroup`   | `ContentType $contentType` `ContentTypeGroup $contentTypeGroup` |
| `BeforeUnassignContentTypeGroupEvent` | `ContentTypeService::unassignContentTypeGroup` | `ContentType $contentType` `ContentTypeGroup $contentTypeGroup` |
| `UnassignContentTypeGroupEvent`       | `ContentTypeService::unassignContentTypeGroup` | `ContentType $contentType` `ContentTypeGroup $contentTypeGroup` |
