# Object state events

Events that are triggered when working with object states and object state groups.

| Event                          | Dispatched by                           | Properties                                                                                                          |
| ------------------------------ | --------------------------------------- | ------------------------------------------------------------------------------------------------------------------- |
| `BeforeCreateObjectStateEvent` | `ObjectStateService::createObjectState` | `ObjectStateGroup $objectStateGroup` `ObjectStateCreateStruct $objectStateCreateStruct` `?ObjectState $objectState` |
| `CreateObjectStateEvent`       | `ObjectStateService::createObjectState` | `ObjectState $objectState` `ObjectStateGroup $objectStateGroup` `ObjectStateCreateStruct $objectStateCreateStruct`  |
| `BeforeUpdateObjectStateEvent` | `ObjectStateService::updateObjectState` | `ObjectState $objectState` `ObjectStateUpdateStruct $objectStateUpdateStruct` `?ObjectState $updatedObjectState`    |
| `UpdateObjectStateEvent`       | `ObjectStateService::updateObjectState` | `ObjectState $updatedObjectState` `ObjectState $objectState` `ObjectStateUpdateStruct $objectStateUpdateStruct`     |
| `BeforeDeleteObjectStateEvent` | `ObjectStateService::deleteObjectState` | `ObjectState $objectState`                                                                                          |
| `DeleteObjectStateEvent`       | `ObjectStateService::deleteObjectState` | `ObjectState $objectState`                                                                                          |

## Object state groups

| Event                               | Dispatched by                                | Properties                                                                                                                                     |
| ----------------------------------- | -------------------------------------------- | ---------------------------------------------------------------------------------------------------------------------------------------------- |
| `BeforeCreateObjectStateGroupEvent` | `ObjectStateService::createObjectStateGroup` | `ObjectStateGroupCreateStruct $objectStateGroupCreateStruct` `?ObjectStateGroup $objectStateGroup`                                             |
| `CreateObjectStateGroupEvent`       | `ObjectStateService::createObjectStateGroup` | `ObjectStateGroup $objectStateGroup` `ObjectStateGroupCreateStruct $objectStateGroupCreateStruct`                                              |
| `BeforeUpdateObjectStateGroupEvent` | `ObjectStateService::updateObjectStateGroup` | `ObjectStateGroup $objectStateGroup` `ObjectStateGroupUpdateStruct $objectStateGroupUpdateStruct` `?ObjectStateGroup $updatedObjectStateGroup` |
| `UpdateObjectStateGroupEvent`       | `ObjectStateService::updateObjectStateGroup` | `ObjectStateGroup $updatedObjectStateGroup` `ObjectStateGroup $objectStateGroup` `ObjectStateGroupUpdateStruct $objectStateGroupUpdateStruct`  |
| `BeforeDeleteObjectStateGroupEvent` | `ObjectStateService::deleteObjectStateGroup` | `ObjectStateGroup $objectStateGroup`                                                                                                           |
| `DeleteObjectStateGroupEvent`       | `ObjectStateService::deleteObjectStateGroup` | `ObjectStateGroup $objectStateGroup`                                                                                                           |

## Setting states

| Event                                 | Dispatched by                                  | Properties                                                                                 |
| ------------------------------------- | ---------------------------------------------- | ------------------------------------------------------------------------------------------ |
| `BeforeSetContentStateEvent`          | `ObjectStateService::deleteObjectState`        | `ContentInfo $contentInfo` `ObjectStateGroup $objectStateGroup` `ObjectState $objectState` |
| `SetContentStateEvent`                | `ObjectStateService::deleteObjectState`        | `ContentInfo $contentInfo` `ObjectStateGroup $objectStateGroup` `ObjectState $objectState` |
| `BeforeSetPriorityOfObjectStateEvent` | `ObjectStateService::setPriorityOfObjectState` | `ObjectState $objectState` `private $priority`                                             |
| `SetPriorityOfObjectStateEvent`       | `ObjectStateService::setPriorityOfObjectState` | `ObjectState $objectState` `private $priority`                                             |
