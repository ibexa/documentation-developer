# Trash events

Events that are triggered when working with Trash.

The following events are dispatched when managing Trash.

| Event                        | Dispatched by                   | Properties                                                                 |
| ---------------------------- | ------------------------------- | -------------------------------------------------------------------------- |
| `BeforeDeleteTrashItemEvent` | `TrashService::deleteTrashItem` | `TrashItem $trashItem` `?TrashItemDeleteResult $result`                    |
| `DeleteTrashItemEvent`       | `TrashService::deleteTrashItem` | `TrashItem $trashItem` `TrashItemDeleteResult $result`                     |
| `BeforeEmptyTrashEvent`      | `TrashService::emptyTrash`      | `?TrashItemDeleteResultList $resultList`                                   |
| `EmptyTrashEvent`            | `TrashService::emptyTrash`      | `TrashItemDeleteResultList $resultList`                                    |
| `BeforeRecoverEvent`         | `TrashService::recover`         | `TrashItem $trashItem` `Location $newParentLocation` `?Location $location` |
| `RecoverEvent`               | `TrashService::recover`         | `TrashItem $trashItem` `Location $newParentLocation` `Location $location`  |
| `BeforeTrashEvent`           | `TrashService::trash`           | `Location $location` `?TrashItem $result` `bool $resultSet = false`        |
| `TrashEvent`                 | `TrashService::trash`           | `Location $location` `?TrashItem $trashItem`                               |
