---
description: Events that are triggered when working with Content Types.
---

# Content Type events

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateContentTypeDraftEvent`|`ContentTypeService::createContentTypeDraft`|`ContentType $contentType`</br>`ContentTypeDraft|null $contentTypeDraft`|
|`CreateContentTypeDraftEvent`|`ContentTypeService::createContentTypeDraft`|`ContentTypeDraft $contentTypeDraft`</br>`ContentType $contentType`|
|`BeforeCreateContentTypeEvent`|`ContentTypeService::createContentType`|`ContentTypeCreateStruct $contentTypeCreateStruct`</br>`array $contentTypeGroups`</br>`ContentTypeDraft|null $contentTypeDraft`|
|`CreateContentTypeEvent`|`ContentTypeService::createContentType`|`ContentTypeDraft $contentTypeDraft`</br>`ContentTypeCreateStruct $contentTypeCreateStruct`</br>`array $contentTypeGroups`|
|`BeforeUpdateContentTypeDraftEvent`|`ContentTypeService::updateContentTypeDraft`|`ContentTypeDraft $contentTypeDraft`</br>`ContentTypeUpdateStruct $contentTypeUpdateStruct`|
|`UpdateContentTypeDraftEvent`|`ContentTypeService::updateContentTypeDraft`|`ContentTypeDraft $contentTypeDraft`</br>`ContentTypeUpdateStruct $contentTypeUpdateStruct`|
|`BeforeCopyContentTypeEvent`|`ContentTypeService::copyContentType`|`ContentType $contentType`</br>`User $creator`</br>`ContentType|null $contentTypeCopy`|
|`CopyContentTypeEvent`|`ContentTypeService::copyContentType`|`ContentType $contentTypeCopy`</br>`ContentType $contentType`</br>`User $creator`|
|`BeforePublishContentTypeDraftEvent`|`ContentTypeService::publishContentTypeDraft`|`ContentTypeDraft $contentTypeDraft`|
|`PublishContentTypeDraftEvent`|`ContentTypeService::publishContentTypeDraft`|`ContentTypeDraft $contentTypeDraft`|
|`BeforeDeleteContentTypeEvent`|`ContentTypeService::deleteContentType`|`ContentType $contentType`|
|`DeleteContentTypeEvent`|`ContentTypeService::deleteContentType`|`ContentType $contentType`|

## Content Type groups

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateContentTypeGroupEvent`|`ContentTypeService::createContentTypeGroup`|`ContentTypeCreateStruct $contentTypeCreateStruct`</br>`array $contentTypeGroups`</br>`ContentTypeDraft|null $contentTypeDraft`|
|`CreateContentTypeGroupEvent`|`ContentTypeService::createContentTypeGroup`|`ContentTypeGroup $contentTypeGroup`</br>`ContentTypeGroupCreateStruct $contentTypeGroupCreateStruct`|
|`BeforeUpdateContentTypeGroupEvent`|`ContentTypeService::updateContentTypeGroup`|`ContentTypeGroup $contentTypeGroup`</br>`ContentTypeGroupUpdateStruct $contentTypeGroupUpdateStruct`|
|`UpdateContentTypeGroupEvent`|`ContentTypeService::updateContentTypeGroup`|`ContentTypeGroup $contentTypeGroup`</br>`ContentTypeGroupUpdateStruct $contentTypeGroupUpdateStruct`|
|`BeforeDeleteContentTypeGroupEvent`|`ContentTypeService::deleteContentTypeGroup`|`ContentTypeGroup $contentTypeGroup`|
|`DeleteContentTypeGroupEvent`|`ContentTypeService::deleteContentTypeGroup`|`ContentTypeGroup $contentTypeGroup`|

## Content Type translations

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeRemoveContentTypeTranslationEvent`|`ContentTypeService::removeContentTypeTranslation`|`ContentTypeDraft $contentTypeDraft`</br>`string $languageCode`</br>`ContentTypeDraft|null $newContentTypeDraft`|
|`RemoveContentTypeTranslationEvent`|`ContentTypeService::removeContentTypeTranslation`|`ContentTypeDraft $newContentTypeDraft`</br>`ContentTypeDraft $contentTypeDraft`</br>`string $languageCode`|

## Field definitions

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeAddFieldDefinitionEvent`|`ContentTypeService::addFieldDefinition`|`ContentTypeDraft $contentTypeDraft`</br>`FieldDefinitionCreateStruct $fieldDefinitionCreateStruct`|
|`AddFieldDefinitionEvent`|`ContentTypeService::addFieldDefinition`|`ContentTypeDraft $contentTypeDraft`</br>`FieldDefinitionCreateStruct $fieldDefinitionCreateStruct`|
|`BeforeUpdateFieldDefinitionEvent`|`ContentTypeService::updateFieldDefinition`|`ContentTypeDraft $contentTypeDraft`</br>`FieldDefinition $fieldDefinition`</br>`FieldDefinitionUpdateStruct $fieldDefinitionUpdateStruct`|
|`UpdateFieldDefinitionEvent`|`ContentTypeService::updateFieldDefinition`|`ContentTypeDraft $contentTypeDraft`</br>`FieldDefinition $fieldDefinition`</br>`FieldDefinitionUpdateStruct $fieldDefinitionUpdateStruct`|
|`BeforeRemoveFieldDefinitionEvent`|`ContentTypeService::removeFieldDefinition`|`ContentTypeDraft $contentTypeDraft`</br>`FieldDefinition $fieldDefinition`|
|`RemoveFieldDefinitionEvent`|`ContentTypeService::removeFieldDefinition`|`ContentTypeDraft $contentTypeDraft`</br>`FieldDefinition $fieldDefinition`|

## Assigning to groups

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeAssignContentTypeGroupEvent`|`ContentTypeService::assignContentTypeGroup`|`ContentType $contentType`</br>`ContentTypeGroup $contentTypeGroup`|
|`AssignContentTypeGroupEvent`|`ContentTypeService::assignContentTypeGroup`|`ContentType $contentType`</br>`ContentTypeGroup $contentTypeGroup`|
|`BeforeUnassignContentTypeGroupEvent`|`ContentTypeService::unassignContentTypeGroup`|`ContentType $contentType`</br>`ContentTypeGroup $contentTypeGroup`|
|`UnassignContentTypeGroupEvent`|`ContentTypeService::unassignContentTypeGroup`|`ContentType $contentType`</br>`ContentTypeGroup $contentTypeGroup`|
