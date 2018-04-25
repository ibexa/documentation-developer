# SignalSlots

The SignalSlot system provides a means for realizing loosely coupled dependencies in the sense that a code entity A can react on an event occurring in code entity B, without A and B knowing each other directly. This works by dispatching event information through a central third instance, the so called dispatcher:

![SignalSlots diagram](img/signal_slots_diagram.png)

In the shown schematics, object B and one other object are interested in a certain Signal. B is a so-called Slot that can be announced to be interested in receiving a Signal (indicated by the circular connector to the dispatcher). Object A now sends the corresponding Signal. The Dispatcher takes care of realizing the dependency and informs the Slot A (and one other Slot) about the occurrence of the Signal.

Signals roughly equal events, while Slots roughly equal event handlers. An arbitrary number (0…n) of Slots can listen for a specific Signal. Every object that receives the Dispatcher as a dependency can send Signals. However, the following conditions apply (that typically do not apply to event handling systems):

- A Slot cannot return anything to the object that issued a Signal
- It is not possible for a Slot to stop the propagation of a Signal, i.e. all listening Slots will eventually receive the Signal

Those two conditions allow the asynchronous processing of Slots. That means: It is possible to determine, by configuration, that a Slot must not receive a Signal in the very same moment it occurs, but to receive it on a later point in time, maybe after other Signals from a queue have been processed or even on a completely different server.

## Signal

A Signal represents a specific event, e.g. that a content version has been published. It consists of information that is significant to the event, e.g. the content ID and version number. Therefore, a Signal is represented by an object of a class that is specific to the Signal and that extends from `eZ\Publish\Core\SignalSlot\Signal`. The full qualified name of the Signal class is used to uniquely identify the Signal. For example, the class `eZ\Publish\Core\SignalSlot\Signal\ContentService\PublishVersionSignal` identifies the example Signal.

In order to work properly with asynchronous processing, Signals must not consist of any logic and must not contain complex data structures (such as further objects and resources). Instead, they must be exportable using the `__set_state()` method, so that it is possible to transfer a Signal to a different system.

!!! note

    Signals can theoretically be sent by any object that gets hold of a SignalDispatcher (`eZ\Publish\Core\SignalSlot\SignalDispatcher`). However, at a first stage, **Signals are only sent by special implementations of the Public API to indicate core events**. These services must and will be used by default and will wrap the original service implementations.

## Slot

A Slot extends the system by realizing functionality that is executed when a certain Signal occurs. To implement a Slot, you must create a class that derives from `eZ\Publish\Core\SignalSlot\Slot`. The full qualified name of the Slot class is also used as the unique identifier of the Slot. The Slot base class requires you to implement the single method `receive()`. When your Slot is configured to listen to a certain Signal and this Signal occurs, the `receive()` method of your Slot is called.

Inside the `receive()` method of your Slot you can basically realize any kind of logic. However, it is recommended that you only dispatch the action to be triggered to a dedicated object. This allows you to trigger the same action from within multiple Slots and to re-use the implementation from a completely different context.

Note that, due to the nature of SignalSlot, the following requirements must be fulfilled by your Slot implementation:

- A Slot must not return anything to the Signal issuer
- A Slot must be aware that it is potentially executed delayed or even on a different server

**Important**: A single Slot should not take care of processing more than one Signal. Instead, if you need to trigger same or similar actions as different Signals occur. You should encapsulate these actions into a dedicated class, of which your Slots receive an instance to trigger this action.

## Example: Updating URL aliases

Updating URL aliases is a typical process that can be realized through a SignalSlot extension for different reasons:

- The action must be triggered on basis of different events (e.g. content update, location move, etc.)
- Direct implementation would involve complex dependencies between otherwise unrelated services
- The action is not critical to be executed immediately, but can be made asynchronous, if necessary

As a first step it needs to be determined for which Signals we need to listen in order to update URL aliases. Some of them are:

- `eZ\Publish\Core\SignalSlot\Signal\ContentService\PublishVersionSignal`
- `eZ\Publish\Core\SignalSlot\Signal\LocationService\CopySubtreeSignal`
- `eZ\Publish\Core\SignalSlot\Signal\LocationService\MoveSubtreeSignal`
- ...

There are of course additional Signals that trigger an update of URL aliases, but these are left out for simplicity here.

Now that we identified some Signals to react upon, we can start implementing Slots for these Signals. For the first Signal, which is issued as soon as a new version of Content is published, there exists a method in `eZ\Publish\SPI\Persistence\Content\UrlAlias\Handler` for exactly that purpose: `publishUrlAliasForLocation()`. The Signal contains the ID of the Content item and its newly published version number. Using this information, the corresponding Slot can fulfill its purposes with the following steps:

1. Load the corresponding content and its locations
1. Call the URL alias creation method for each location

To achieve this, the Slot has 2 dependencies:

- `eZ\Publish\SPI\Persistence\Content\Handler`
    to load the content itself in order to retrieve the names
- `eZ\Publish\SPI\Persistence\Content\Location\Handler`
    to load the locations
- `eZ\Publish\SPI\Persistence\Content\UrlAlias\Handler`
    to create the aliases for each location

So, a stub for the implementation could look like this:

``` php
namespace Acme\TestBundle\Slot;

use eZ\Publish\Core\SignalSlot\Slot as BaseSlot;
use eZ\Publish\API\Repository\Repository;
use eZ\Publish\SignalSlot\Signal;

class CreateUrlAliasesOnPublishSlot extends BaseSlot
{
    /**
     * @var \eZ\Publish\API\Repository\Repository
     */
    private $repository;
    public function __construct( Repository $repository )
    {
        $this->repository = $repository;
    }

    public function receive( Signal $signal )
    {
        if ( !$signal instanceof Signal\ContentService\PublishVersionSignal )
        {
            return;
        }
        // Load content
        // Load locations
        // Create URL aliases
    }
}
```

!!! note

    In order to make the newly created Slot react on the corresponding Signal, the following steps must be performed:

    1.  Make the Slot available through the Symfony service container as a service
    1.  Register the Slot to react to the Signal of type `eZ\Publish\Core\SignalSlot\Signal\ContentService\PublishVersionSignal`

    See the [Listening to Core events](../cookbook/listening_to_core_events.md) recipe in the developer cookbook for more information.

!!! note "Important note about template matching"

    **Template matching will NOT work if your content contains a Field Type that is not supported by the Repository**. It can be the case when you are in the process of a migration from eZ Publish 4.x, where custom datatypes have been developed.

    In this case the Repository will throw an exception, which is caught in the `ViewController`, and *if* you are using LegacyBridge it will end up doing a [fallback to legacy kernel](https://doc.ez.no/display/EZP/Legacy+template+fallback).

    The list of Field Types supported out of the box [is available here](../api/field_type_reference.md).

## Signals Reference

This section references **all available Signals** that you can listen to, triggered by ("Public") Repository API in eZ Platform.

For more information, check the [SignalSlots](#signal-slots) section and the [Listening to Core events](../cookbook/listening_to_core_events.md) recipe.

All Signals are relative to `eZ\Publish\Core\SignalSlot\Signal` namespace.

!!! note "Transactions"

    Signals are sent after transactions are executed, making Signals transaction safe.

#### ContentService

|Signal type|Properties|Triggered by|
|------|------|------|
|`ContentService\AddRelationSignal`|`srcContentId` (source contentId, aka referrer)</br>`srcVersionNo`</br>`dstContentId` (destination contentId, aka target)|`ContentService::addRelation()`|
|`ContentService\AddTranslationInfoSignal`|N/A|`ContentService::addTranslationInfo()`|
|`ContentService\CopyContentSignal`|`srcContentId` (original content ID)</br>`srcVersionNo`</br>`dstContentId` (contentId of the copy)</br>`dstVersionNo`</br>`dstParentLocationId` (locationId where the content has been copied)|`ContentService::copyContent()`|
|`ContentService\CreateContentDraftSignal`|`contentId`</br>`versionNo`</br>`userId` (ID of User used to create the draft, or null - current User)|`ContentService::createContentDraft()`|
|`ContentService\CreateContentSignal`|`contentId`</br>`versionNo`|`ContentService::createContent()`|
|`ContentService\DeleteContentSignal`|`contentId`</br>`affectedLocationIds`|`ContentService::deleteContent()`|
|`ContentService\DeleteRelationSignal`|`srcContentId`</br>`srcVersionNo`</br>`dstContentId`|`ContentService::deleteRelation()`|
|`ContentService\DeleteTranslationSignal`|`contentId`</br>`languageCode`|`ContentService::deleteTranslation()`|
|`ContentService\DeleteVersionSignal`|`contentId`</br>`versionNo`|`ContentService::deleteVersion()`|
|`ContentService\PublishVersionSignal`|`contentId`</br>`versionNo`|`ContentService::publishVersion()`|
|`ContentService\TranslateVersionSignal`|`contentId`</br>`versionNo`</br>`userId`|`ContentService::translationVersion()`|
|`ContentService\UpdateContentMetadataSignal`|`contentId`|`ContentService::updateContentMetadata()`|
|`ContentService\UpdateContentSignal`|`contentId`</br>`versionNo`|`ContentService::updateContent()`|

#### ContentTypeService

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

#### LanguageService

|Signal type|Properties|Triggered by|
|------|------|------|
|`LanguageService\CreateLanguageSignal`|`languageId`|`LanguageService::createLanguage()`|
|`LanguageService\DeleteLanguageSignal`|`languageId`|`LanguageService::deleteLanguage()`|
|`LanguageService\DisableLanguageSignal`|`languageId`|`LanguageService::disableLanguage()`|
|`LanguageService\EnableLanguageSignal`|`languageId`|`LanguageService::enableLanguage()`|
|`LanguageService\UpdateLanguageNameSignal`|`languageId`</br>`newName`|`LanguageService::updateLanguageName()`|

#### LocationService

|Signal type|Properties|Triggered by|
|------|------|------|
|`LocationService\CopySubtreeSignal`|`subtreeId` (top locationId of the subtree to be copied)</br>`targetParentLocationId`</br>`targetNewSubtreeId`|`LocationService::copySubtree()`|
|`LocationService\CreateLocationSignal`|`contentId`</br>`locationId`</br>`parentLocationId`|`LocationService::createLocation()`|
|`LocationService\DeleteLocationSignal`|`contentId`</br>`locationId`</br>`parentLocationId`|`LocationService::deleteLocation()`|
|`LocationService\HideLocationSignal`|`contentId`</br>`locationId`</br>`currentVersionNo`</br>`parentLocationId`|`LocationService::hideLocation()`|
|`LocationService\UnhideLocationSignal`|`contentId`</br>`locationId`</br>`currentVersionNo`</br>`parentLocationId`|`LocationService::unhideLocation()`|
|`LocationService\MoveSubtreeSignal`|`subtreeId`</br>`oldParentLocationId`</br>`newParentLocationId`|`LocationService::moveSubtree()`|
|`LocationService\SwapLocationSignal`|`content1Id`</br>`location1Id`</br>`parentLocation1Id`</br>`content2Id`</br>`location2Id`</br>`parentLocation1Id`|`LocationService::swapLocation()`|
|`LocationService\UpdateLocationSignal`|`contentId`</br>`locationId`</br>`parentLocationId`|`LocationService::updateLocation()`|

#### ObjectStateService

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

#### RoleService

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
|`RoleService\UnassignRoleFromUserGroupSignal`|`roleId`</br>`userGroupId`|`RoleService::unassignRoleFromUserGroup()`|
|`RoleService\UnassignRoleFromUserSignal`|`roleId`</br>`userId`|`RoleService::unassignRoleFromUser()`|
|`RoleService\UpdatePolicySignal`|`policyId`|`RoleService::updatePolicy()`|
|`RoleService\UpdateRoleDraftSignal`|`roleId`|`RoleService::updateRoleDraft()`|
|`RoleService\UpdateRoleSignal`|`roleId`|`RoleService::updateRole()`|

#### SectionService

|Signal type|Properties|Triggered by|
|------|------|------|
|`SectionService\AssignSectionSignal`|`contentId`</br>`sectionId`|`SectionService::assignSection()`|
|`SectionService\CreateSectionSignal`|`sectionId`|`SectionService::createSection()`|
|`SectionService\DeleteSectionSignal`|`sectionId`|`SectionService::deleteSection()`|
|`SectionService\UpdateSectionSignal`|`sectionId`|`SectionService::updateSection()`|

#### TrashService

|Signal type|Properties|Triggered by|
|------|------|------|
|`TrashService\DeleteTrashItemSignal`|`trashItemId`|`TrashService::deleteTrashItem()`|
|`TrashService\EmptyTrashSignal`|N/A|`TrashService::emptyTrash()`|
|`TrashService\RecoverSignal`|`trashItemId`</br>`contentId`</br>`newParentLocationId`</br>`newLocationId`|`TrashService::recover()`|
|`TrashService\TrashSignal`|`locationId`</br>`parentLocationId`</br>`contentId`</br>`contentTrashed`|`TrashService::trash()`|

#### URLAliasService

|Signal type|Properties|Triggered by|
|------|------|------|
|`URLAliasService\CreateGlobalUrlAliasSignal`|`urlAliasId`|`URLAliasService::createGlobalUrlAlias()`|
|`URLAliasService\CreateUrlAliasSignal`|`urlAliasId`|`URLAliasService::createUrlAlias()`|
|`URLAliasService\RemoveAliasesSignal`|`aliasList`|`URLAliasService::removeAliases()`|

#### URLWildcardService

|Signal type|Properties|Triggered by|
|------|------|------|
|`URLWildcardService\CreateSignal`|`urlWildcardId`|`URLWildcardService::create()`|
|`URLWildcardService\RemoveSignal`|`urlWildcardId`|`URLWildcardService::remove()`|
|`URLWildcardService\TranslateSignal`|`url`|`URLWildcardService::translate()`|

#### UserService

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
