---
description: Events that are triggered when working with object states and object state groups.
---

# Object state events

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateObjectStateEvent`|`ObjectStateService::createObjectState`|`ObjectStateGroup $objectStateGroup`</br>`ObjectStateCreateStruct $objectStateCreateStruct`</br>`ObjectState|null $objectState`|
|`CreateObjectStateEvent`|`ObjectStateService::createObjectState`|`ObjectState $objectState`</br>`ObjectStateGroup $objectStateGroup`</br>`ObjectStateCreateStruct $objectStateCreateStruct`|
|`BeforeUpdateObjectStateEvent`|`ObjectStateService::updateObjectState`|`ObjectState $objectState`</br>`ObjectStateUpdateStruct $objectStateUpdateStruct`</br>`ObjectState|null $updatedObjectState`|
|`UpdateObjectStateEvent`|`ObjectStateService::updateObjectState`|`ObjectState $updatedObjectState`</br>`ObjectState $objectState`</br>`ObjectStateUpdateStruct $objectStateUpdateStruct`|
|`BeforeDeleteObjectStateEvent`|`ObjectStateService::deleteObjectState`|`ObjectState $objectState`|
|`DeleteObjectStateEvent`|`ObjectStateService::deleteObjectState`|`ObjectState $objectState`|

## Object state groups

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeCreateObjectStateGroupEvent`|`ObjectStateService::createObjectStateGroup`|`ObjectStateGroupCreateStruct $objectStateGroupCreateStruct`</br>`ObjectStateGroup|null $objectStateGroup`|
|`CreateObjectStateGroupEvent`|`ObjectStateService::createObjectStateGroup`|`ObjectStateGroup $objectStateGroup`</br>`ObjectStateGroupCreateStruct $objectStateGroupCreateStruct`|
|`BeforeUpdateObjectStateGroupEvent`|`ObjectStateService::updateObjectStateGroup`|`ObjectStateGroup $objectStateGroup`</br>`ObjectStateGroupUpdateStruct $objectStateGroupUpdateStruct`</br>`ObjectStateGroup|null $updatedObjectStateGroup`|
|`UpdateObjectStateGroupEvent`|`ObjectStateService::updateObjectStateGroup`|`ObjectStateGroup $updatedObjectStateGroup`</br>`ObjectStateGroup $objectStateGroup`</br>`ObjectStateGroupUpdateStruct $objectStateGroupUpdateStruct`|
|`BeforeDeleteObjectStateGroupEvent`|`ObjectStateService::deleteObjectStateGroup`|`ObjectStateGroup $objectStateGroup`|
|`DeleteObjectStateGroupEvent`|`ObjectStateService::deleteObjectStateGroup`|`ObjectStateGroup $objectStateGroup`|

## Setting states

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeSetContentStateEvent`|`ObjectStateService::deleteObjectState`|`ContentInfo $contentInfo`</br>`ObjectStateGroup $objectStateGroup`</br>`ObjectState $objectState`|
|`SetContentStateEvent`|`ObjectStateService::deleteObjectState`|`ContentInfo $contentInfo`</br>`ObjectStateGroup $objectStateGroup`</br>`ObjectState $objectState`|
|`BeforeSetPriorityOfObjectStateEvent`|`ObjectStateService::setPriorityOfObjectState`|`ObjectState $objectState`</br>`private $priority`|
|`SetPriorityOfObjectStateEvent`|`ObjectStateService::setPriorityOfObjectState`|`ObjectState $objectState`</br>`private $priority`|
