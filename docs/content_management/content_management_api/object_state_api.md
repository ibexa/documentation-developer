---
description: You can manage Object states via the PHP API, including creating Object states and state groups and assigning them to Content items.
---

# Object state API

[Object states](admin_panel.md#object-states) enable you to set a custom state to any content.
States are grouped into Object state groups.

You can manage Object states by using the PHP API by using `ObjectStateService`.

!!! tip "Object state REST API"

    To learn how to manage Object states using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-get-object-states-of-content-item).

## Getting Object state information

You can use the [`ObjectStateService`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ObjectStateService.php)
to get information about Object state groups or Object states.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ObjectStateCommand.php', 48, 53) =]]
```

## Creating Object states

To create an Object state group and add Object states to it,
you need to make use of the [`ObjectStateService`:](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ObjectStateService.php)

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ObjectStateCommand.php', 57, 61) =]]
```

[`ObjectStateService::createObjectStateGroup`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ObjectStateService.php#L34)
takes as argument an [`ObjectStateGroupCreateStruct`,](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/ObjectState/ObjectStateGroupCreateStruct.php)
in which you need to specify the identifier, default language and at least one name for the group.

To create an Object state inside a group,
use [`ObjectStateService::newObjectStateCreateStruct`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ObjectStateService.php#L210)
and provide it with an `ObjectStateCreateStruct`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ObjectStateCommand.php', 64, 68) =]]
```

## Assigning Object state

To assign an Object state to a Content item,
use [`ObjectStateService::setContentState`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ObjectStateService.php#L180)
Provide it with a `ContentInfo` object of the Content item, the Object state group and the Object state:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ObjectStateCommand.php', 78, 83) =]]
```
