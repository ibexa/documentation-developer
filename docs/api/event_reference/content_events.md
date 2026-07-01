---
description: Events that are triggered when working with content.
page_type: reference
---

# Content events

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateContentDraftEvent`|`ContentService::createContentDraft`|`ContentInfo $contentInfo`</br>`VersionInfo $versionInfo`</br>`User $creator`</br>`?Language $language`</br>`?Content $contentDraft`|
|`CreateContentDraftEvent`|`ContentService::createContentDraft`|`Content $contentDraft`</br>`ContentInfo $contentInfo`</br>`VersionInfo $versionInfo`</br>`User $creator`</br>`?Language $language`|
|`BeforeCreateContentEvent`|`ContentService::createContent`|`ContentCreateStruct $contentCreateStruct`</br>`array $locationCreateStructs`</br>`?Content $content`</br>`string[] or null  $fieldIdentifiersToValidate`|
|`CreateContentEvent`|`ContentService::createContent`|`ContentCreateStruct $contentCreateStruct`</br>`array $locationCreateStructs`</br>`Content $content`</br>`string[] or null $fieldIdentifiersToValidate`|
|`BeforeUpdateContentEvent`|`ContentService::updateContent`|`VersionInfo $versionInfo`</br>`ContentUpdateStruct $contentUpdateStruct`</br>`?Content $content`</br>`string[] or null $fieldIdentifiersToValidate`|
|`UpdateContentEvent`|`ContentService::updateContent`|`Content $content`</br>`VersionInfo $versionInfo`</br>`ContentUpdateStruct $contentUpdateStruct`</br>`string[] or null $fieldIdentifiersToValidate`|
|`BeforeUpdateContentMetadataEvent`|`ContentService::updateContentMetadata`|`ContentInfo $contentInfo`</br>`ContentMetadataUpdateStruct $contentMetadataUpdateStruct`</br>`?Content $content`|
|`UpdateContentMetadataEvent`|`ContentService::updateContentMetadata`|`Content $content`</br>`ContentInfo $contentInfo`</br>`ContentMetadataUpdateStruct $contentMetadataUpdateStruct`|
|`BeforeCopyContentEvent`|`ContentService::copyContent`|`ContentInfo $contentInfo`</br>`LocationCreateStruct $destinationLocationCreateStruct`</br>`VersionInfo $versionInfo`</br>`?Content $content`|
|`CopyContentEvent`|`ContentService::copyContent`|`Content $content`</br>`ContentInfo $contentInfo`</br>`LocationCreateStruct $destinationLocationCreateStruct`</br>`VersionInfo $versionInfo`|
|`BeforePublishVersionEvent`|`ContentService::publishVersion`|`VersionInfo $versionInfo`</br>`?Content $content`</br>`string[] $translations`|
|`PublishVersionEvent`|`ContentService::publishVersion`|`Content $content`</br>`VersionInfo $versionInfo`</br>`string[] $translations`|
|`BeforeDeleteContentEvent`|`ContentService::deleteContent`|`ContentInfo $contentInfo`</br>`array or null $locations`|
|`DeleteContentEvent`|`ContentService::deleteContent`|`array $locations`</br>`ContentInfo $contentInfo`|
|`BeforeDeleteVersionEvent`|`ContentService::deleteVersion`|`VersionInfo $versionInfo`|
|`DeleteVersionEvent`|`ContentService::deleteVersion`|`VersionInfo $versionInfo`|

## Relations

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeAddRelationEvent`|`ContentService::addRelation`|`VersionInfo $sourceVersion`</br>`ContentInfo $destinationContent`</br>`?Relation $relation`|
|`AddRelationEvent`|`ContentService::addRelation`|`Relation $relation`</br>`VersionInfo $sourceVersion`</br>`ContentInfo $destinationContent`|
|`BeforeDeleteRelationEvent`|`ContentService::deleteRelation`|`VersionInfo $sourceVersion`</br>`ContentInfo $destinationContent`|
|`DeleteRelationEvent`|`ContentService::deleteRelation`|`VersionInfo $sourceVersion`</br>`ContentInfo $destinationContent`|

## Content translations

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeDeleteTranslationEvent`|`ContentService::deleteTranslation`|`ContentInfo $contentInfo`</br>`$languageCode`|
|`DeleteTranslationEvent`|`ContentService::deleteTranslation`|`ContentInfo $contentInfo`</br>`$languageCode`|

## Hiding and revealing

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeHideContentEvent`|`ContentService::hideContent`|`ContentInfo $contentInfo`|
|`HideContentEvent`|`ContentService::hideContent`|`ContentInfo $contentInfo`|
|`BeforeRevealContentEvent`|`ContentService::revealContent`|`ContentInfo $contentInfo`|
|`RevealContentEvent`|`ContentService::revealContent`|`ContentInfo $contentInfo`|
