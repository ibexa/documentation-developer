# Translation cache for Text modules [[% include 'snippets/commerce_badge.md' %]]

!!! note

    See [SignalSlots documentation](https://doc.ezplatform.com/en/2.5/guide/signalslots/#signals-reference) for more information about the SignalSlot system.

## RemoveTranslationCacheSlot

The `RemoveTranslationCacheSlot` slot is used to remove translations of `st_textmodules` immediately after they have been updated, deleted, created, moved to or recovered from Trash.

`RemoveTranslationCacheSlot` only accepts the following signals:

``` php
Signal\ContentService\UpdateContentSignal
Signal\ContentService\DeleteContentSignal
Signal\ContentService\CreateContentSignal
Signal\TrashService\TrashSignal
Signal\TrashService\RecoverSignal
```
