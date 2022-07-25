---
description: Events that are triggered when working with Trash.
---

# Trash events

The following events are dispatched when managing Trash.

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeDeleteTrashItemEvent`|`TrashService::deleteTrashItem`|`TrashItem $trashItem`</br>`TrashItemDeleteResult|null $result`|
|`DeleteTrashItemEvent`|`TrashService::deleteTrashItem`|`TrashItem $trashItem`</br>`TrashItemDeleteResult $result`|
|`BeforeEmptyTrashEvent`|`TrashService::emptyTrash`|`TrashItemDeleteResultList|null $resultList`|
|`EmptyTrashEvent`|`TrashService::emptyTrash`|`TrashItemDeleteResultList $resultList`|
|`BeforeRecoverEvent`|`TrashService::recover`|`TrashItem $trashItem`</br>`Location $newParentLocation`</br>`Location|null $location`|
|`RecoverEvent`|`TrashService::recover`|`TrashItem $trashItem`</br>`Location $newParentLocation`</br>`Location $location`|
|`BeforeTrashEvent`|`TrashService::trash`|`Location $location`</br>`TrashItem|null $result`</br>`bool $resultSet = false`|
|`TrashEvent`|`TrashService::trash`|`Location $location`</br>`TrashItem|null $trashItem`|
