# Content events

Events that are triggered when working with content.

| Event                              | Dispatched by                           | Properties                                                                                                                                   |
| ---------------------------------- | --------------------------------------- | -------------------------------------------------------------------------------------------------------------------------------------------- |
| `BeforeCreateContentDraftEvent`    | `ContentService::createContentDraft`    | `ContentInfo $contentInfo` `VersionInfo $versionInfo` `User $creator` `?Language $language` `?Content $contentDraft`                         |
| `CreateContentDraftEvent`          | `ContentService::createContentDraft`    | `Content $contentDraft` `ContentInfo $contentInfo` `VersionInfo $versionInfo` `User $creator` `?Language $language`                          |
| `BeforeCreateContentEvent`         | `ContentService::createContent`         | `ContentCreateStruct $contentCreateStruct` `array $locationCreateStructs` `?Content $content` `string[] or null $fieldIdentifiersToValidate` |
| `CreateContentEvent`               | `ContentService::createContent`         | `ContentCreateStruct $contentCreateStruct` `array $locationCreateStructs` `Content $content` `string[] or null $fieldIdentifiersToValidate`  |
| `BeforeUpdateContentEvent`         | `ContentService::updateContent`         | `VersionInfo $versionInfo` `ContentUpdateStruct $contentUpdateStruct` `?Content $content` `string[] or null $fieldIdentifiersToValidate`     |
| `UpdateContentEvent`               | `ContentService::updateContent`         | `Content $content` `VersionInfo $versionInfo` `ContentUpdateStruct $contentUpdateStruct` `string[] or null $fieldIdentifiersToValidate`      |
| `BeforeUpdateContentMetadataEvent` | `ContentService::updateContentMetadata` | `ContentInfo $contentInfo` `ContentMetadataUpdateStruct $contentMetadataUpdateStruct` `?Content $content`                                    |
| `UpdateContentMetadataEvent`       | `ContentService::updateContentMetadata` | `Content $content` `ContentInfo $contentInfo` `ContentMetadataUpdateStruct $contentMetadataUpdateStruct`                                     |
| `BeforeCopyContentEvent`           | `ContentService::copyContent`           | `ContentInfo $contentInfo` `LocationCreateStruct $destinationLocationCreateStruct` `VersionInfo $versionInfo` `?Content $content`            |
| `CopyContentEvent`                 | `ContentService::copyContent`           | `Content $content` `ContentInfo $contentInfo` `LocationCreateStruct $destinationLocationCreateStruct` `VersionInfo $versionInfo`             |
| `BeforePublishVersionEvent`        | `ContentService::publishVersion`        | `VersionInfo $versionInfo` `?Content $content` `string[] $translations`                                                                      |
| `PublishVersionEvent`              | `ContentService::publishVersion`        | `Content $content` `VersionInfo $versionInfo` `string[] $translations`                                                                       |
| `BeforeDeleteContentEvent`         | `ContentService::deleteContent`         | `ContentInfo $contentInfo` `array or null $locations`                                                                                        |
| `DeleteContentEvent`               | `ContentService::deleteContent`         | `array $locations` `ContentInfo $contentInfo`                                                                                                |
| `BeforeDeleteVersionEvent`         | `ContentService::deleteVersion`         | `VersionInfo $versionInfo`                                                                                                                   |
| `DeleteVersionEvent`               | `ContentService::deleteVersion`         | `VersionInfo $versionInfo`                                                                                                                   |

## Relations

| Event                       | Dispatched by                    | Properties                                                                           |
| --------------------------- | -------------------------------- | ------------------------------------------------------------------------------------ |
| `BeforeAddRelationEvent`    | `ContentService::addRelation`    | `VersionInfo $sourceVersion` `ContentInfo $destinationContent` `?Relation $relation` |
| `AddRelationEvent`          | `ContentService::addRelation`    | `Relation $relation` `VersionInfo $sourceVersion` `ContentInfo $destinationContent`  |
| `BeforeDeleteRelationEvent` | `ContentService::deleteRelation` | `VersionInfo $sourceVersion` `ContentInfo $destinationContent`                       |
| `DeleteRelationEvent`       | `ContentService::deleteRelation` | `VersionInfo $sourceVersion` `ContentInfo $destinationContent`                       |

## Content translations

| Event                          | Dispatched by                       | Properties                                 |
| ------------------------------ | ----------------------------------- | ------------------------------------------ |
| `BeforeDeleteTranslationEvent` | `ContentService::deleteTranslation` | `ContentInfo $contentInfo` `$languageCode` |
| `DeleteTranslationEvent`       | `ContentService::deleteTranslation` | `ContentInfo $contentInfo` `$languageCode` |

## Hiding and revealing

| Event                      | Dispatched by                   | Properties                 |
| -------------------------- | ------------------------------- | -------------------------- |
| `BeforeHideContentEvent`   | `ContentService::hideContent`   | `ContentInfo $contentInfo` |
| `HideContentEvent`         | `ContentService::hideContent`   | `ContentInfo $contentInfo` |
| `BeforeRevealContentEvent` | `ContentService::revealContent` | `ContentInfo $contentInfo` |
| `RevealContentEvent`       | `ContentService::revealContent` | `ContentInfo $contentInfo` |
