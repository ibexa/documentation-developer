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

| Capability         | Message type                                                                                | Description                          |
|--------------------|---------------------------------------------------------------------------------------------|--------------------------------------|
| (handshake)        | [`APP:INITIALIZED`](#communication-initialization)                                          | Establish protocol and capabilities. |
| (handshake)        | [`PB:INIT_MODE`](#communication-initialization)                                             | Confirm protocol and draft info.     |
| (core)             | [`PB:UPDATE_FIELD_DATA`](#on-field-update)                                                  | Send updated field data.             |
| (core)             | [`PB:DISPATCH_EVENT`](#re-dispatching-events)                                               | Re-dispatch a front-end event.       |
| `blocks.dnd`       | [`PB:DRAG_START_PREVIEW`](#drag-and-drop-blocksdnd)                                         | Existing block drag started.         |
| `blocks.dnd`       | [`PB:DRAG_OVER`](#drag-and-drop-blocksdnd)                                                  | Mouse position during drag.          |
| `blocks.dnd`       | [`PB:DRAG_END_PREVIEW`](#drag-and-drop-blocksdnd)                                           | Existing block drag ended.           |
| `blocks.dnd`       | [`PB:DROP`](#drag-and-drop-blocksdnd)                                                       | Drop notification.                   |
| `blocks.dnd`       | [`APP:DROP_RESPONSE`](#drag-and-drop-blocksdnd)                                             | Report where the block was dropped.  |
| `blocks.dnd`       | [`PB:SCROLL_BY`](#drag-and-drop-blocksdnd)                                                  | Scroll the preview.                  |
| `blocks.geometry`  | [`APP:POSITIONS_UPDATE`](#geometry-and-pointer-tracking-blocksgeometry-and-pointertracking) | Report block positions.              |
| `blocks.geometry`  | [`APP:SCROLL_END`](#geometry-and-pointer-tracking-blocksgeometry-and-pointertracking)       | Scroll ended.                        |
| `blocks.remove`    | [`PB:BLOCK_REMOVE`](#block-removal-blocksremove)                                            | Remove a block.                      |
| `blocks.remove`    | [`APP:BLOCK_REMOVE_RESPONSE`](#block-removal-blocksremove)                                  | Confirm removal.                     |
| `blocks.remove`    | [`APP:BLOCK_REMOVE_REQUEST`](#block-removal-blocksremove)                                   | Request block removal.               |
| `blocks.reveal`    | [`PB:SCROLL_INTO_BLOCK`](#block-reveal-blocksreveal)                                        | Scroll a block into view.            |
| `blocks.select`    | `APP:BLOCK_CLICKED`                                                                         | TODO: Block clicked.                 |
| `pointer.tracking` | [`APP:MOUSE_POSITION`](#geometry-and-pointer-tracking-blocksgeometry-and-pointertracking)   | Report mouse position.               |
| `preview.params`   | [`PB:UPDATE_PREVIEW_PARAMS`](#preview-parameters-update-previewparams)                      | TODO: Update preview params.         |

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

- Always, the current value of the Landing page field being edited (`fieldValue`) including the layout, zones, and blocks.
  <br>For example, only `fieldValue` is sent when manipulating the [timeline]([[= user_doc =]]/content_management/schedule_publishing/#timeline)![](page_builder_toolbartimelinetoggler.png){style="display:inline;width:27px;vertical-align:middle;"}.
- Optionally, a list of the existing block types, their attributes, and their configuration (`blocksConfig`)
- Optionally, a block-ID-to-name mapping (`blocksIdMap`)
- Optionally, a list of Ids from the new blocks that have been added (`highlightedBlockIds`)

```json
{
    "type": "PB:UPDATE_FIELD_DATA",
    "data": {
        "fieldValue": {
            "layout": "…",
            "zones": []
        },
        "blocksConfig": [],
        "blocksIdMap": {},
        "highlightedBlockIds": []
    }
}
```

### Re-dispatching events

The `PB:DISPATCH_EVENT` message is sent from the Page Builder to the front-end resource for being re-dispatched there as a custom event.
Its data contains the name of the event to dispatch (`eventName`) and the data to pass to the event detail (`eventData`).

```js
window.addEventListener('message', (messageEvent) => {
    switch (messageEvent.data.type) {
        case 'PB:DISPATCH_EVENT':
            window.dispatchEvent(new CustomEvent(messageEvent.data.data.eventName, { detail: messageEvent.data.data.eventData }));
            break;
    }
});
```

#### Available events

- `ibexa-active-block-clicked`: It confirms `APP:BLOCK_CLICKED` have been received. It has no data.
- `ibexa-post-update-blocks-preview`: It's a complement to [`PB:UPDATE_FIELD_DATA`](#on-field-update) with more data
    - `fieldValue`: The same as in `PB:UPDATE_FIELD_DATA`
    - `blockIds`: A list of all the block IDs
    - `blocksMaps`: A map of block config per block ID

```js
window.addEventListener('ibexa-post-update-blocks-preview', (customEvent) => {
    setLayout(customEvent.details.fieldValue.layout);
    renderZones(customEvent.details.fieldValue.zones);
});
```

### Geometry and pointer tracking (`blocks.geometry` and `pointer.tracking`)

The pointer tracking and the geometry helps the Page Builder to position the block editing menus above the front-end preview.
Such menu is a `.c-pb-headless-preview-menu` element positioned by the Page Builder from its DOM above the preview `iframe`.

`APP:MOUSE_POSITION` message is sent from the front-end preview to the Page Builder to declare the actual position of the mouse.

```js
window.addEventListener('mousemove', (mouseEvent) => {
    window.parent.postMessage({
        type: 'APP:MOUSE_POSITION',
        data: {
            x: mouseEvent.clientX,
            y: mouseEvent.clientY,
        },
    }, pbOrigin);
});
```

`APP:POSITIONS_UPDATE` message is sent from the front-end preview to the Page Builder to declare the actual position of the blocks.
Its data contains a list of objects with block IDs, their positions, and dimensions in the front-end preview.
This format is close to [`getBoundingClientRect()`](https://developer.mozilla.org/en-US/docs/Web/API/Element/getBoundingClientRect) method.

```js
const positionsUpdate = () => {
    let blocks = [];
    for (const blockElement of document.getElementsByClassName('landing-page__block')) {
        const blockId = blockElement.dataset.ibexaBlockId;
        const blockRect = blockElement.getBoundingClientRect();
        blocks.push({
            id: blockId,
            top: blockRect.top,
            left: blockRect.left,
            right: blockRect.right,
            bottom: blockRect.bottom,
            width: blockRect.width,
            height: blockRect.height,
        });
    }
    window.parent.postMessage({
        type: 'APP:POSITIONS_UPDATE',
        data: {
            blocks: blocks,
        },
    }, pbOrigin);
};
```

This message should be sent each time the positions of the blocks change.
It should be sent after updating the blocks, like in response to [`PB:UPDATE_FIELD_DATA`](#on-field-update).
It should be sent after scrolling or resizing.

`APP:SCROLL_END` message is sent from the front-end preview to the Page Builder to notify that a scroll operation has ended.
It has no data.

```js
window.addEventListener('scrollend', (event) => {
    window.parent.postMessage({
        type: 'APP:SCROLL_END',
    }, pbOrigin);
    positionsUpdate();
});
window.addEventListener('resize', (event) => {
    positionsUpdate();
});
window.addEventListener('message', (messageEvent) => {
    switch (messageEvent.data.type) {
        case 'PB:UPDATE_FIELD_DATA':
            setLayout(messageEvent.data.data.fieldValue.layout);
            renderZones(messageEvent.data.data.fieldValue.zones);
            positionsUpdate();
            break;
    }
});
```

TODO: Is there other events that should trigger a positions update?

### Drag and drop (`blocks.dnd`)

`PB:DRAG_OVER` message is sent from the Page Builder to the front-end preview to give the position of the mouse while a (new or existing) block is dragged.

!!! tip

    - `APP:MOUSE_POSITION` helps the Page Builder to know where the mouse is when moved over the preview.
    - `PB:DRAG_OVER` helps the front-end to know where the mouse is when a block is dragged over the preview.

`PB:DRAG_START_PREVIEW` and `PB:DRAG_END_PREVIEW` are sent at the beginning and at the end of a drag operation on an existing block in the front-end preview.
Its data contains the ID of the block being dragged (`blockId`).

`PB:DROP` message is sent from the Page Builder to the front-end preview to notify that a block has been dropped.
It has no data. Combined with the last `PB:DRAG_OVER` message, the front-end can determine where the block has been dropped.

`APP:DROP_RESPONSE` message is sent from the front-end preview to the Page Builder to tell where the block has been dropped.

Its data contains:

- the ID of the zone where the block has been dropped (`zoneId`)
- the ID of a block that is now below the dropped block (`nextBlockId`) if the dropped block isn't the last one of the zone.

In the following example, `targetBlockId` value is the ID of a block the dropped block was dropped on or just before, so the dragged block takes its place and move it below, or `null` when dropped at the bottom of the zone.

```js
const dropResponseMessage = {
    type: 'APP:DROP_RESPONSE',
    data: {
        zoneId: zoneId,
        nextBlockId: targetBlockId,
    }
};
```

`PB:SCROLL_BY` message is sent from the Page Builder when a block is dragged near a border of the preview which needs to be scrolled.
Its data contains the `top` or `left` amount to scroll by.

```js
window.addEventListener('message', (messageEvent) => {
    switch (messageEvent.data.type) {
        case 'PB:SCROLL_BY':
            window.scrollBy(messageEvent.data.data);
            break;
    }
});
```

See [Geometry (`blocks.geometry`)](#geometry-and-pointer-tracking-blocksgeometry-and-pointertracking)'s `APP:SCROLL_END` message to declare the end of the scroll operation
and `APP:POSITIONS_UPDATE` message to update the blocks positions.

### Block reveal (`blocks.reveal`)

`PB:SCROLL_INTO_BLOCK` is send by the Page Builder to the front-end preview to request that a block is scrolled into view.
Its data contains the ID of the block to scroll into view (`blockId`).
It can be used with the [`scrollIntoView()`](https://developer.mozilla.org/en-US/docs/Web/API/Element/scrollIntoView) method.

```js
window.addEventListener('message', (messageEvent) => {
    switch (messageEvent.data.type) {
        case 'PB:SCROLL_INTO_BLOCK':
            const blockElementToScrollInto = document.getElementById('block_' + messageEvent.data.data.blockId);
            blockElementToScrollInto.scrollIntoView({ behavior: 'smooth', block: 'center' });
            break;
    }
});
```

### Block removal (`blocks.remove`)

`PB:BLOCK_REMOVE` message is sent from the Page Builder to the front-end preview to notify that a block should be removed, for example, from the Structure view.
Its data contains the ID of the block to remove (`blockId`).

`APP:BLOCK_REMOVE_RESPONSE` message is sent from the front-end preview to the Page Builder to confirm that the block has been removed as requested by `PB:BLOCK_REMOVE`.
Its data contains the ID of the removed block (`blockId`).
It can be sent immediately or after removal animation.

```js
window.addEventListener('message', (messageEvent) => {
    switch (messageEvent.data.type) {
        case 'PB:BLOCK_REMOVE':
            const blockId = messageEvent.data.data.blockId;
            const blockElementToRemove = document.getElementById('block_' + blockId);
            if (blockElementToRemove) {
                blockElementToRemove.addEventListener('animationend', () => {
                    blockElementToRemove.remove();
                    window.parent.postMessage({
                        type: 'APP:BLOCK_REMOVE_RESPONSE',
                        data: {
                            blockId: blockId,
                        },
                    });
                });
                blockElementToRemove.classList.add('c-pb-block-preview--is-removing');
            } else {
                console.error('No block element found for block ID ' + messageEvent.data.data.blockId, 'notification.headless_unresponsive_preview');
            }
            break;
    }
});
```
```css
.c-pb-block-preview--is-removing {
    animation-duration: 1s;
    animation-name: c-pb-block-preview--is-removing;
}
@keyframes c-pb-block-preview--is-removing {
    to {
        opacity: 0;
        height: 0;
    }
}
```

`APP:BLOCK_REMOVE_REQUEST` message is sent from the front-end preview to the Page Builder to request the removal of a block.
Its data contains the ID of the block to remove (`blockId`).
The Page Builder responses with a `PB:UPDATE_FIELD_DATA`.

### Preview parameters update (`preview.params`)

`PB:UPDATE_PREVIEW_PARAMS` message is sent from the Page Builder to the front-end preview when TODO: it's sent on several occasions without data. It seems also (if not mainly) used by segmentation.
