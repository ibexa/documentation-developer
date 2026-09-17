---
description: The Page Builder can preview pages outside the DXP.
edition: experience
month_change: true
---

# Headless front-end preview in Page Builder

The Page Builder can preview pages hosted outside the DXP.

You provide a single URL for the front-end page and let it communicate with the Page Builder using the JavaScript message API.

The usage of this front-end page instead of the DXP one is set per content type. TODO: This is on-prem only, SaaS don't have the choice

## Configuration TODO: How this is declared on Saas?

First, set up the feature, for example, in `config/packages/ibexa_page_builder.yaml`:

```yaml
ibexa:
    system:
        admin_group:
            page_builder:
                headless:
                    enabled: true
                    base_url: 'https://example.com/page.html' # The front-end URL loaded by the Page Builder's iframe
```

Then, edit the content types with Landing page field type that are used headless,
edit that field, and check the option "Edit in the headless Page Builder".

![Checked "Edit in the headless Page Builder"](page-edit-headless.png)

## Communication protocol

The front-end resource targeted by `base_url` is loaded by the Page Builder when editing a content having a Landing page field "Edit in the headless Page Builder" enabled.
This resource must follow a protocol to communicate with the Page Builder from the iframe is loaded in.
This protocol is based on the JavaScript message API.

The Page Builder sends messages to the framed front-end resource.
They can be received by listening the [message event](https://developer.mozilla.org/en-US/docs/Web/API/EventSource/message_event).

The front-end resource sends back messages to the Page Builder.
They can be sent using the [`postMessage()`](https://developer.mozilla.org/en-US/docs/Web/API/Window/postMessage) method.
The target origin of those messages must be the Page Builder's origin.

```js
const pbOrigin = 'https://admin.example.com/';
window.parent.postMessage(message, pbOrigin);
```

Those messages are JS objects with the following structure:

```js
let message = {
    type: 'PREFIX:MESSAGE_TYPE',
    data: {}
};
```

The `PREFIX` sort message types by their sender.
`PB:` for messages sent by the Page Builder, `APP:` for messages sent by the front-end resource.

The data depends on the message type.

Message types are then sorted by capabilities.
So the front-end can declare which capabilities it supports and the Page Builder can refrain from sending or expecting unsupported messages.

### Message types and capabilities

The handshake and core messages are mandatory and not related to an optional capability.

| Capability       | Message type                                       | Description                                                                                               |
|------------------|----------------------------------------------------|-----------------------------------------------------------------------------------------------------------|
| (handshake)      | [`APP:INITIALIZED`](#communication-initialization) | To establish the communication and declare which protocol version and capabilities are supported.         |
| (handshake)      | [`PB:INIT_MODE`](#communication-initialization)    | To validate the communication and give information about the edited content draft.                        |
| (core)           | [`PB:UPDATE_FIELD_DATA`](#on-field-update)         | To notify that the field has changed, like when a block have been edited or the layout has been switched. |
| (core)           | [`PB:DISPATCH_EVENT`](##re-dispatching-events)     | TODO: To notify of event that should be dispached                                                         |
| blocks.dnd       | [`PB:DRAG_START_PREVIEW`](#drag-and-drop)          | To notify that an existing block starts being dragged in the preview.                                     |
| blocks.dnd       | [`PB:DRAG_OVER`](#drag-and-drop)                   | To give the position of the mouse while a block is dragged.                                               |
| blocks.dnd       | [`PB:DRAG_END_PREVIEW`](#drag-and-drop)            | To notify that an existing block stopped being dragged in the preview.                                    |
| blocks.dnd       | [`PB:DROP`](#drag-and-drop)                        | To notify that a block has been dropped.                                                                  |
| blocks.dnd       | [`APP:DROP_RESPONSE`](#drag-and-drop)              | To notify that the drop action has been processed and declare which zone welcomed the block.              |
| blocks.dnd       | [`PB:SCROLL_BY`](#drag-and-drop)                   | TODO                                                                                                      |
| blocks.geometry  | APP:POSITIONS_UPDATE                               | To declare the actual position of the blocks (so the block editing menus can be positionned).             |
| blocks.geometry  | APP:SCROLL_END                                     | TODO                                                                                                      |
| blocks.remove    | PB:BLOCK_REMOVE                                    | TODO                                                                                                      |
| blocks.remove    | APP:BLOCK_REMOVE_RESPONSE                          | TODO                                                                                                      |
| blocks.remove    | APP:BLOCK_REMOVE_REQUEST                           | TODO                                                                                                      |
| blocks.reveal    | PB:SCROLL_INTO_BLOCK                               | TODO                                                                                                      |
| blocks.select    | APP:BLOCK_CLICKED                                  | To notify that a block has been clicked.                                                                  |
| pointer.tracking | APP:MOUSE_POSITION                                 | To declare the actual position of the mouse (so the block editing menus can be displayed on hover).       |
| preview.params   | PB:UPDATE_PREVIEW_PARAMS                           | TODO                                                                                                      |

### Communication initialization

First, the front-end send an initialization message to the Page Builder, indicating which version of the protocol and which capabilities are supported:

```js
const initializedMessage = {
    type: 'APP:INITIALIZED',
    data: {
        protocol: {
            supported: [1]
        },
        capabilities: [
            'blocks.dnd',
            'blocks.geometry',
            'blocks.select',
            'pointer.tracking',
            // …
        ],
    }
};
```

The Page Builder replies with a confirmation message.
The initialization message might be sent several times until the Page Builder replies to it.

This confirmation `data` contains:
- the actual version of the protocol used (`protocol.version`) and the other supported versions (`protocol.supported`)
- a list of all available capabilities (`capabilities`)
- a list of the existing block types, their attributes, and their configuration (`blocksConfig`)
- information about the actually edited content draft (`intentParameters`)
- the current value of the Landing page field being edited (`fieldValue`) including the layout, zones, and blocks.
- a block-ID-to-name mapping (`blocksIdMap`)
- a list of translations for the front-end to use (`translations`)

```json
{
    "type": "PB:INIT_MODE",
    "data": {
        "protocol": {
            "version": 1,
            "supported": [
                1
            ]
        },
        "capabilities": [
            "blocks.dnd",
            "blocks.geometry",
            "blocks.remove",
            "blocks.reveal",
            "blocks.select",
            "pointer.tracking",
            "preview.params"
        ],
        "blocksConfig": [
            {
                "type": "block_type",
                "name": "Block type name",
                "category": "Block category",
                "thumbnail": "path/to/block/thumbnail.file",
                "visible": true,
                "views": {
                    "default": {
                        "name": "Default"
                    }
                },
                "attributes": [
                    {
                        "id": "attribute_id",
                        "name": "Attribute name",
                        "type": "attribute_type",
                        "value": null,
                        "constraints": {
                            "not_blank": {
                                "message": "Please select…"
                            }
                        }
                    }
                ]
            }
        ],
        "intentParameters": {
            "locationId": "2",
            "contentId": 52,
            "versionNo": 6,
            "languageCode": "eng-GB"
        },
        "fieldValue": {
            "layout": "ibexa_fieldtype_page.layouts.<layout_definition>.identifier",
            "zones": [
                {
                    "id": "123",
                    "name": "ibexa_fieldtype_page.layouts.<layout_definition>.zones.<zone_definition>.name",
                    "blocks": [
                        {
                            "visible": true,
                            "id": "456",
                            "type": "block_type",
                            "name": "Block name",
                            "view": "default",
                            "class": null,
                            "style": null,
                            "compiled": "",
                            "since": null,
                            "till": null,
                            "attributes": [
                                {
                                    "id": "789",
                                    "name": "attribute_name",
                                    "value": "…"
                                }
                            ]
                        }
                    ]
                }
            ]
        },
        "blocksIdMap": {
            "456": "Block name"
        },
        "translations": {
            "block.attribute.invalid": "%name% is invalid",
            "block.no_availability.content": "You have to delete it to publish",
            "block.no_availability.delete": "Delete",
            "block.no_availability.title": "This element is not available in this page",
            "block.unknown.type": "Unknown block type: %type% (block name: %name%)",
            "drag.drop.blocks.here": "Drag and drop blocks here",
            "structure.drop.zone": "Drop zone %number%"
        }
    }
}
```

### On field update

The `PB:UPDATE_FIELD_DATA` message is sent from the Page Builder to the front-end resource when the Landing page field value is updated.

Its data contains the new value of the field with the following structure:
- a list of the existing block types, their attributes, and their configuration (`blocksConfig`)
- the current value of the Landing page field being edited (`fieldValue`) including the layout, zones, and blocks.
- a block-ID-to-name mapping (`blocksIdMap`)
- a list of Ids from the new blocks that have been added (`highlightedBlockIds`)

```json
{
    "type": "PB:UPDATE_FIELD_DATA",
    "data": {
        "blocksConfig": [],
        "fieldValue": {
            "layout": "…",
            "zones": []
        },
        "blocksIdMap": {},
        "highlightedBlockIds": []
    }
}
```

### Re-dispatching events

The `PB:DISPATCH_EVENT` message is sent from the Page Builder to the front-end resource for being re-dispatched there as a custom event.

```js
window.addEventListener('message', (messageEvent) => {
    switch (messageEvent.data.type) {
        case 'PB:DISPATCH_EVENT':
            document.body.dispatchEvent(new CustomEvent(messageEvent.data.data.eventName, { detail: messageEvent.data.data.eventDetail }));
            break;
    }
});
```

TODO: Available events
- `ibexa-active-block-clicked`?
- `ibexa-post-update-blocks-preview`?

### Drag and drop (`blocks.dnd`)

`PB:DRAG_OVER` message is sent from the Page Builder to the front-end preview to give the position of the mouse while a (new or existing) block is dragged.

`PB:DRAG_START_PREVIEW` and `PB:DRAG_END_PREVIEW` are sent at the beginning and at the end of a drag operation on an existing block in the front-end preview.
Its data contains the ID of the block being dragged (`blockId`).

`PB:DROP` message is sent from the Page Builder to the front-end preview to notify that a block has been dropped.
It has no data. Combined with the last `PB:DRAG_OVER` message, the front-end can determine where the block has been dropped.

`APP:DROP_RESPONSE` message is sent from the front-end preview to the Page Builder to tell where the block has been dropped.

Its data contains:
- the ID of the zone where the block has been dropped (`zoneId`)
- the ID of the block that is now next to the dropped block (`nextBlockId`) if the dropped block isn't the last one of the zone.

In the following example, `targetBlockId` is the ID of a block the dropped block was dropped on or just before, so the dragged block takes its place and move it below, or `null` when dropped at the bottom of the zone.

```js
const dropResponseMessage = {
    type: 'APP:DROP_RESPONSE',
    data: {
        zoneId: zoneId,
        nextBlockId: targetBlockId,
    }
};
```

TODO: `PB:SCROLL_BY` when a block is dragged near the top or bottom of the preview, and it needs to be scrolled up or down.
