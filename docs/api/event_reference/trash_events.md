---
description: Events that are triggered when working with Trash.
page_type: reference
---

# Trash events

The following events are dispatched when managing Trash.

| Event | Dispatched by | Properties |
|---|---|---|
|`BeforeDeleteTrashItemEvent`|`TrashService::deleteTrashItem`|`TrashItem $trashItem`<br>`?TrashItemDeleteResult $result`|
|`DeleteTrashItemEvent`|`TrashService::deleteTrashItem`|`TrashItem $trashItem`<br>`TrashItemDeleteResult $result`|
|`BeforeEmptyTrashEvent`|`TrashService::emptyTrash`|`?TrashItemDeleteResultList $resultList`|
|`EmptyTrashEvent`|`TrashService::emptyTrash`|`TrashItemDeleteResultList $resultList`|
|`BeforeRecoverEvent`|`TrashService::recover`|`TrashItem $trashItem`<br>`Location $newParentLocation`<br>`?Location $location`|
|`RecoverEvent`|`TrashService::recover`|`TrashItem $trashItem`<br>`Location $newParentLocation`<br>`Location $location`|
|`BeforeTrashEvent`|`TrashService::trash`|`Location $location`<br>`?TrashItem $result`<br>`bool $resultSet = false`|
|`TrashEvent`|`TrashService::trash`|`Location $location`<br>`?TrashItem $trashItem`|
