# Object state API

You can manage object states via the PHP API, including creating object states and state groups and assigning them to content items.

[Object states](../../../administration/content_organization/object_states/index.md) enable you to set a custom state to any content. States are grouped into object state groups.

You can manage Object states by using the PHP API by using `ObjectStateService`.

> **Tip: Object state REST API**
>
> To learn how to manage object states using the REST API, see [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Objects/operation/api_contentobjects_contentIdobjectstates_get).

## Getting object state information

You can use the [`Ibexa\Contracts\Core\Repository\ObjectStateService`](../../../../../../ibexa/core/src/contracts/Repository/ObjectStateService.php) to get information about object state groups or object states.

```php
$objectStateGroup = $this->objectStateService->loadObjectStateGroupByIdentifier('ibexa_lock');
$objectState = $this->objectStateService->loadObjectStateByIdentifier($objectStateGroup, 'locked');

$output->writeln($objectStateGroup->getName());
$output->writeln($objectState->getName());
```

## Creating object states

To create an object state group and add object states to it, you need to make use of the [`Ibexa\Contracts\Core\Repository\ObjectStateService`](../../../../../../ibexa/core/src/contracts/Repository/ObjectStateService.php):

```php
$objectStateGroupStruct = $this->objectStateService->newObjectStateGroupCreateStruct($objectStateGroupIdentifier);
$objectStateGroupStruct->defaultLanguageCode = 'eng-GB';
$objectStateGroupStruct->names = ['eng-GB' => $objectStateGroupIdentifier];
$newObjectStateGroup = $this->objectStateService->createObjectStateGroup($objectStateGroupStruct);
```

[`ObjectStateService::createObjectStateGroup`](../../../../../../ibexa/core/src/contracts/Repository/ObjectStateService.php) takes as argument an [`Ibexa\Contracts\Core\Repository\Values\ObjectState\ObjectStateGroupCreateStruct`](../../../../../../ibexa/core/src/contracts/Repository/Values/ObjectState/ObjectStateGroupCreateStruct.php), in which you need to specify the identifier, default language and at least one name for the group.

To create an object state inside a group, use [`ObjectStateService::newObjectStateCreateStruct`](../../../../../../ibexa/core/src/contracts/Repository/ObjectStateService.php) and provide it with an `ObjectStateCreateStruct`:

```php
$stateStruct = $this->objectStateService->newObjectStateCreateStruct($objectStateIdentifier);
$stateStruct->defaultLanguageCode = 'eng-GB';
$stateStruct->names = ['eng-GB' => $objectStateIdentifier];
$this->objectStateService->createObjectState($newObjectStateGroup, $stateStruct);
```

## Assigning object state

To assign an object state to a content item, use [`ObjectStateService::setContentState`](../../../../../../ibexa/core/src/contracts/Repository/ObjectStateService.php). Provide it with a `ContentInfo` object of the content item, the object state group and the object state:

```php
$contentInfo = $this->contentService->loadContentInfo($contentId);
$objectStateGroup = $this->objectStateService->loadObjectStateGroupByIdentifier($objectStateGroupIdentifier);
$objectState = $this->objectStateService->loadObjectStateByIdentifier($objectStateGroup, $objectStateToAssign);

$this->objectStateService->setContentState($contentInfo, $objectStateGroup, $objectState);
```
