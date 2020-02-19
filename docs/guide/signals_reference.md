# Signals reference

This page references **all available Signals** that you can listen to, triggered by ("Public") Repository API in eZ Platform.

For more information, check [Listening to Core events](signalslots.md#listening-to-core-events).

All Signals are relative to `eZ\Publish\Core\SignalSlot\Signal` namespace.

!!! note "Transactions"

    Signals are sent after transactions are executed, making Signals transaction safe.

### BookmarkService
|Signal type|Properties|Triggered by|
|------|------|------|
|`BookmarkService\CreateBookmarkSignal`|`locationId`|`BookmarkService::createBookmark()`|
|`BookmarkService\DeleteBookmarkSignal`|`locationId`|`BookmarkService::deleteBookmark()`|

### ContentService

|Signal type|Properties|Triggered by|
|------|------|------|
|`ContentService\AddRelationSignal`|`srcContentId` (source contentId, aka referrer)</br>`srcVersionNo`</br>`dstContentId` (destination contentId, aka target)|`ContentService::addRelation()`|
|`ContentService\AddTranslationInfoSignal` (deprecated)|N/A||
|`ContentService\CopyContentSignal`|`srcContentId` (original content ID)</br>`srcVersionNo`</br>`dstContentId` (contentId of the copy)</br>`dstVersionNo`</br>`dstParentLocationId` (locationId where the content has been copied)|`ContentService::copyContent()`|
|`ContentService\CreateContentDraftSignal`|`contentId`</br>`versionNo`</br>`newVersionNo`</br>`userId` (ID of User used to create the draft, or null - current User)</br>`languageCode`|`ContentService::createContentDraft()`|
|`ContentService\CreateContentSignal`|`contentId`</br>`versionNo`|`ContentService::createContent()`|
|`ContentService\DeleteContentSignal`|`contentId`</br>`affectedLocationIds`|`ContentService::deleteContent()`|
|`ContentService\DeleteRelationSignal`|`srcContentId`</br>`srcVersionNo`</br>`dstContentId`|`ContentService::deleteRelation()`|
|`ContentService\DeleteTranslationSignal`|`contentId`</br>`languageCode`|`ContentService::deleteTranslation()`|
|`ContentService\DeleteVersionSignal`|`contentId`</br>`versionNo`|`ContentService::deleteVersion()`|
|`ContentService\HideContentSignal`|`contentId`|`ContentService::hideContent()`|
|`ContentService\PublishVersionSignal`|`contentId`</br>`versionNo`</br>`affectedTranslations`|`ContentService::publishVersion()`|
|`ContentService\RevealContentSignal`|`contentId`|`ContentService::revealContent()`|
|`ContentService\TranslateVersionSignal` (deprecated)|`contentId`</br>`versionNo`</br>`userId`||
|`ContentService\UpdateContentMetadataSignal`|`contentId`|`ContentService::updateContentMetadata()`|
|`ContentService\UpdateContentSignal`|`contentId`</br>`versionNo`|`ContentService::updateContent()`|

### ContentTypeService

|Signal type|Properties|Triggered by|
|------|------|------|
|`ContentTypeService\AddFieldDefinitionSignal`|`contentTypeDraftId`|<p>`ContentTypeService::addFieldDefinition()`</p>|
|`ContentTypeService\AssignContentTypeGroupSignal`|`contentTypeId`</br>`contentTypeGroupId`|`ContentTypeService::assignContentTypeGroup()`|
|`ContentTypeService\CopyContentTypeSignal`|`contentTypeId`</br>`userId`|`ContentTypeService::copyContentType()`|
|`ContentTypeService\CreateContentTypeDraftSignal`|`contentTypeId`|`ContentTypeService::createContentTypeDraft()`|
|`ContentTypeService\CreateContentTypeGroupSignal`|`groupId`|`ContentTypeService::createContentTypeGroup()`|
|`ContentTypeService\CreateContentTypeSignal`|`contentTypeId`|`ContentTypeService::createContentType()`|
|`ContentTypeService\DeleteContentTypeGroupSignal`|`contentTypeGroupId`|`ContentTypeService::deleteContentTypeGroup()`|
|`ContentTypeService\DeleteContentTypeSignal`|`contentTypeId`|`ContentTypeService::deleteContentType()`|
|`ContentTypeService\PublishContentTypeDraftSignal`|`contentTypeDraftId`|`ContentTypeService::publishContentTypeDraft()`|
|`ContentTypeService\RemoveFieldDefinitionSignal`|`contentTypeDraftId`</br>`fieldDefinitionId`|`ContentTypeService::removeFieldDefinition()`|
|`ContentTypeService\UnassignContentTypeGroupSignal`|`contentTypeId`</br>`contentTypeGroupId`|`ContentTypeService::unassignContentTypeGroup()`|
|`ContentTypeService\UpdateContentTypeDraftSignal`|`contentTypeDraftId`|`ContentTypeService::updateContentTypeDraft()`|
|`ContentTypeService\UpdateContentTypeGroupSignal`|`contentTypeGroupId`|`ContentTypeService::updateContentTypeGroup()`|
|`ContentTypeService\UpdateFieldDefinitionSignal`|`contentTypeDraftId`</br>`fieldDefinitionId`|`ContentTypeService::updateFieldDefinition()`|
|`ContentTypeService\RemoveContentTypeDraftTranslationSignal`|`contentTypeDraftId`</br>`languageCode`|`ContentTypeService::removeContentTypeTranslation()`|

### LanguageService

|Signal type|Properties|Triggered by|
|------|------|------|
|`LanguageService\CreateLanguageSignal`|`languageId`|`LanguageService::createLanguage()`|
|`LanguageService\DeleteLanguageSignal`|`languageId`|`LanguageService::deleteLanguage()`|
|`LanguageService\DisableLanguageSignal`|`languageId`|`LanguageService::disableLanguage()`|
|`LanguageService\EnableLanguageSignal`|`languageId`|`LanguageService::enableLanguage()`|
|`LanguageService\UpdateLanguageNameSignal`|`languageId`</br>`newName`|`LanguageService::updateLanguageName()`|

### LocationService

|Signal type|Properties|Triggered by|
|------|------|------|
|`LocationService\CopySubtreeSignal`|`subtreeId` (top locationId of the subtree to be copied)</br>`targetParentLocationId`</br>`targetNewSubtreeId`|`LocationService::copySubtree()`|
|`LocationService\CreateLocationSignal`|`contentId`</br>`locationId`</br>`parentLocationId`|`LocationService::createLocation()`|
|`LocationService\DeleteLocationSignal`|`contentId`</br>`locationId`</br>`parentLocationId`|`LocationService::deleteLocation()`|
|`LocationService\HideLocationSignal`|`contentId`</br>`locationId`</br>`currentVersionNo`</br>`parentLocationId`|`LocationService::hideLocation()`|
|`LocationService\UnhideLocationSignal`|`contentId`</br>`locationId`</br>`currentVersionNo`</br>`parentLocationId`|`LocationService::unhideLocation()`|
|`LocationService\MoveSubtreeSignal`|`subtreeId`</br>`oldParentLocationId`</br>`newParentLocationId`|`LocationService::moveSubtree()`|
|`LocationService\SwapLocationSignal`|`content1Id`</br>`location1Id`</br>`parentLocation1Id`</br>`content2Id`</br>`location2Id`</br>`parentLocation1Id`|`LocationService::swapLocation()`|
|`LocationService\UpdateLocationSignal`|`contentId`</br>`locationId`</br>`parentLocationId`|`LocationService::updateLocation()`</br>`URLAliasService::refreshSystemUrlAliasesForLocation`|

### NotificationService

|Signal type|Properties|Triggered by|
|------|------|------|
|`NotificationService\NotificationCreateSigna`|`ownerId`</br>`type`</br>`data`|`NotificationService::createNotification`|
|`NotificationService\NotificationDeleteSigna`|`notificationId`|`NotificationService::deleteNotification`|
|`NotificationService\NotificationReadSignal`|`notificationId`|`NotificationService::markNotificationAsRead`|

### ObjectStateService

|Signal type|Properties|Triggered by|
|------|------|------|
|`ObjectStateService\CreateObjectStateGroupSignal`|`objectStateGroupId`|`ObjectStateService::createObjectStateGroup()`|
|`ObjectStateService\CreateObjectStateSignal`|`objectStateGroupId`</br>`objectStateId`|`ObjectStateService::createObjectState()`|
|`ObjectStateService\DeleteObjectStateGroupSignal`|`objectStateGroupId`|`ObjectStateService::deleteObjectStateGroup()`|
|`ObjectStateService\DeleteObjectStateSignal`|`objectStateId`|`ObjectStateService::deleteObjectState()`|
|`ObjectStateService\SetContentStateSignal`|`contentId`</br>`objectStateGroupId`</br>`objectStateId`|`ObjectStateService::setContentState()`|
|`ObjectStateService\SetPriorityOfObjectStateSignal`|`objectStateId`</br>`priority`|`ObjectStateService::setPriorityOfObjectState()`|
|`ObjectStateService\UpdateObjectStateGroupSignal`|`objectStateGroupId`|`ObjectStateService::updateObjectStateGroup()`|
|`ObjectStateService\UpdateObjectStateSignal`|`objectStateId`|`ObjectStateService::updateObjectState()`|

### RoleService

|Signal type|Properties|Triggered by|
|------|------|------|
|`RoleService\AddPolicyByRoleDraftSignal`|`roleId`</br>`policyId`|`RoleService::addPolicyByRoleDraft()`|
|`RoleService\AddPolicySignal`|`roleId`</br>`policyId`|`RoleService::addPolicy()`|
|`RoleService\AssignRoleToUserGroupSignal`|`roleId`</br>`userGroupId`</br>`roleLimitation`|`RoleService::assignRoleToUserGroup()`|
|`RoleService\AssignRoleToUserSignal`|`roleId`</br>`userId`</br>`roleLimitation`|`RoleService::assignRoleToUser()`|
|`RoleService\CreateRoleDraftSignal`|`roleId`|`RoleService::createRoleDraft()`|
|`RoleService\CreateRoleSignal`|`roleId`|`RoleService::createRole()`|
|`RoleService\DeleteRoleDraftSignal`|`roleId`|`RoleService::deleteRoleDraft()`|
|`RoleService\DeleteRoleSignal`|`roleId`|`RoleService::deleteRole()`|
|`RoleService\PublishRoleDraftSignal`|`roleId`|`RoleService::publishRoleDraft()`|
|`RoleService\RemovePolicyByRoleDraftSignal`|`roleId`</br>`policyId`|`RoleService::removePolicyByRoleDraft()`|
|`RoleService\RemovePolicySignal`|`roleId`</br>`policyId`|`RoleService::removePolicy()`|
|`RoleService\RemoveRoleAssignmentSignal`|`roleAssignmentId`|`RoleService::removeRoleAssignment()`|
|`RoleService\UnassignRoleFromUserGroupSignal`|`roleId`</br>`userGroupId`|`RoleService::unassignRoleFromUserGroup()` (deprecated)|
|`RoleService\UnassignRoleFromUserSignal`|`roleId`</br>`userId`|`RoleService::unassignRoleFromUser()` (deprecated)|
|`RoleService\UpdatePolicySignal`|`policyId`|`RoleService::updatePolicy()` (deprecated)</br>`RoleService::updatePolicyByRoleDraft()`|
|`RoleService\UpdateRoleDraftSignal`|`roleId`|`RoleService::updateRoleDraft()`|
|`RoleService\UpdateRoleSignal`|`roleId`|`RoleService::updateRole()` (deprecated)|

### SectionService

|Signal type|Properties|Triggered by|
|------|------|------|
|`SectionService\AssignSectionSignal`|`contentId`</br>`sectionId`|`SectionService::assignSection()`|
|`SectionService\AssignSectionToSubtreeSignal`|`locationId`</br>`sectionId`|`SectionService::assignSectionToSubtree()`|
|`SectionService\CreateSectionSignal`|`sectionId`|`SectionService::createSection()`|
|`SectionService\DeleteSectionSignal`|`sectionId`|`SectionService::deleteSection()`|
|`SectionService\UpdateSectionSignal`|`sectionId`|`SectionService::updateSection()`|

### TrashService

|Signal type|Properties|Triggered by|
|------|------|------|
|`TrashService\DeleteTrashItemSignal`|`trashItemDeleteResult`|`TrashService::deleteTrashItem()`|
|`TrashService\EmptyTrashSignal`|`trashItemDeleteResultList `|`TrashService::emptyTrash()`|
|`TrashService\RecoverSignal`|`trashItemId`</br>`contentId`</br>`newParentLocationId`</br>`newLocationId`|`TrashService::recover()`|
|`TrashService\TrashSignal`|`locationId`</br>`parentLocationId`</br>`contentId`</br>`contentTrashed`|`TrashService::trash()`|

### URLAliasService

|Signal type|Properties|Triggered by|
|------|------|------|
|`URLAliasService\CreateGlobalUrlAliasSignal`|`urlAliasId`|`URLAliasService::createGlobalUrlAlias()`|
|`URLAliasService\CreateUrlAliasSignal`|`urlAliasId`|`URLAliasService::createUrlAlias()`|
|`URLAliasService\RemoveAliasesSignal`|`aliasList`|`URLAliasService::removeAliases()`|

### URLService

|Signal type|Properties|Triggered by|
|------|------|------|
|`URLService\UpdateUrlSignal`|`urlId`</br>`urlChanged`|`URLService::updateUrl()`|

### URLWildcardService

|Signal type|Properties|Triggered by|
|------|------|------|
|`URLWildcardService\CreateSignal`|`urlWildcardId`|`URLWildcardService::create()`|
|`URLWildcardService\RemoveSignal`|`urlWildcardId`|`URLWildcardService::remove()`|
|`URLWildcardService\TranslateSignal`|`url`|`URLWildcardService::translate()`|

### UserService

|Signal type|Properties|Triggered by|
|------|------|------|
|`UserService\AssignUserToUserGroupSignal`|`userId`</br>`userGroupId`|`UserService::assignUserToUserGroup()`|
|`UserService\CreateUserGroupSignal`|`userGroupId`|`UserService::createUserGroup()`|
|`UserService\CreateUserSignal`|`userId`|`UserService::createUser()`|
|`UserService\DeleteUserGroupSignal`|`userGroupId`</br>`affectedLocationIds`|`UserService::deleteUserGroup()`|
|`UserService\DeleteUserSignal`|`userId`</br>`affectedLocationIds`|`UserService::deleteUser()`|
|`UserService\MoveUserGroupSignal`|`userGroupId`</br>`newParentId`|`UserService::moveUserGroup()`|
|`UserService\UnAssignUserFromUserGroupSignal`|`userId`</br>`userGroupId`|`UserService::unAssignUserFromUserGroup()`|
|`UserService\UpdateUserGroupSignal`|`userGroupId`|`UserService::updateUserGroup()`|
|`UserService\UpdateUserSignal`|`userId`|`UserService::updateUser()`|
|`UserService\UpdateUserTokenSignal`|`userId`|`UserService::updateUserToken()`|

### UserPreferenceService

|Signal type|Properties|Triggered by|
|------|------|------|
|`UserPreferenceService\UserPreferenceSetSignal`|`name`</br>`value`|`UserPreferenceService::setUserPreference()`|
