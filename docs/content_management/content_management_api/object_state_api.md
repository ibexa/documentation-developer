---
description: You can manage object states via the PHP API, including creating object states and state groups and assigning them to content items.
---

# Object state API

[Object states](object_states.md) enable you to set a custom state to any content.
States are grouped into object state groups.

You can manage Object states by using the PHP API by using `ObjectStateService`.

!!! tip "Object state REST API"

    To learn how to manage object states using the REST API, see [REST API reference](../../api/rest_api/rest_api_reference/rest_api_reference.html#managing-content-get-object-states-of-content-item).

## Getting object state information

You can use the [`ObjectStateService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ObjectStateService.html) to get information about object state groups or object states.

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ObjectStateCommand.php', 48, 53) =]]
```

## Creating object states

To create an object state group and add object states to it, you need to make use of the [`ObjectStateService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ObjectStateService.html):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ObjectStateCommand.php', 57, 61) =]]
```

[`ObjectStateService::createObjectStateGroup`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ObjectStateService.html#method_createObjectStateGroup) takes as argument an [`ObjectStateGroupCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-ObjectState-ObjectStateGroupCreateStruct.html), in which you need to specify the identifier, default language and at least one name for the group.

To create an object state inside a group, use [`ObjectStateService::newObjectStateCreateStruct`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ObjectStateService.html#method_newObjectStateCreateStruct) and provide it with an `ObjectStateCreateStruct`:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ObjectStateCommand.php', 63, 67) =]]
```

## Assigning object state

To assign an object state to a content item, use [`ObjectStateService::setContentState`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ObjectStateService.html#method_setContentState).
Provide it with a `ContentInfo` object of the content item, the object state group and the object state:

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/ObjectStateCommand.php', 77, 82) =]]
```
