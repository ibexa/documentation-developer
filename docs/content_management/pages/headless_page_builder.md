---
description: Preview and edit in Page Builder using your frontend.
edition: experience
month_change: true
---

# Headless frontend preview in Page Builder

The Page Builder can preview landing pages rendered by your frontend application.

You provide a single URL for the frontend page and let it communicate with the Page Builder using the JavaScript message API.

## Configuration

1. In the left panel, go to **Administration** -> **SiteAccess Configuration**
1. Choose the SiteAccess that you want to set up a preview for. Do not choose a SiteAccess if you want to set up a default preview for the SiteAccesses that don't have a specific preview.
1. In **Available configurations** list, click **Headless**.
1. In **Edit configuration** section, expand the **Headless mode** drop-down list and select **Enabled**.
1. Populate the **Page Builder preview URL** field and click **Save**.

![Headless mode enabled with Page Builder preview URL](headless-saas-siteaccess-config.png)

## Communication protocol

The Page Builder loads the specified frontend resource when you edit a content item with the **Landing page** field.
The resource must use the JavaScript message API-based protocol to communicate with the Page Builder from within the iframe in which the Page Builder loads it.

The Page Builder sends messages to the frontend resource in the iframe.
You can receive them by listening for the [message event](https://developer.mozilla.org/en-US/docs/Web/API/Window/message_event).

The frontend resource sends messages back to the Page Builder.
You can send them by using the [`postMessage()`](https://developer.mozilla.org/en-US/docs/Web/API/Window/postMessage) method.
The target origin of those messages must be the Page Builder's origin.

```js
const pbOrigin = 'https://my-company.cohesivo.app';
window.parent.postMessage(message, pbOrigin);
```

These messages are JavaScript objects with the following structure:

```js
let message = {
    type: '<PREFIX>:<MESSAGE_TYPE>',
    data: {}
};
```

The `PREFIX` identifies the sender of each message type:

- `PB:` - for messages sent by the Page Builder
- `APP:` - for messages sent by the frontend resource

The data depends on the message type.

Message types are grouped by capability.
The frontend can declare which capabilities it supports, so that the Page Builder can avoid sending or expecting unsupported messages.

### Message types and capabilities

Handshake and core messages are mandatory and don't depend on optional capabilities.

| Capability         | Message type                                                                                | Description                          |
|--------------------|---------------------------------------------------------------------------------------------|--------------------------------------|
| (handshake)        | [`APP:INITIALIZED`](#communication-initialization)                                          | Establish protocol and capabilities. |
| (handshake)        | [`PB:INIT_MODE`](#communication-initialization)                                             | Confirm protocol and draft info.     |
| (core)             | [`PB:UPDATE_FIELD_DATA`](#on-field-update)                                                  | Send updated field data.             |
| (core)             | [`PB:DISPATCH_EVENT`](#re-dispatching-events)                                               | Re-dispatch a frontend event.       |
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
| `blocks.select`    | `APP:BLOCK_CLICKED`                                                                         | Block clicked.                       |
| `pointer.tracking` | [`APP:MOUSE_POSITION`](#geometry-and-pointer-tracking-blocksgeometry-and-pointertracking)   | Report mouse position.               |

### Communication initialization

First, the frontend sends an initialization message to the Page Builder, indicating which protocol versions and capabilities it supports:

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

The frontend may send the initialization message several times until the Page Builder replies.
The Page Builder replies with a confirmation message.

The confirmation `data` property object contains:

- the protocol version in use (`protocol.version`) and other supported versions (`protocol.supported`)
- a list of all available capabilities (`capabilities`)
- all block types, their attributes, and their configuration (`blocksConfig`) - types unavailable for this field are marked as not `visible`
- information about the content draft currently being edited (`intentParameters`)
- the current value of the Landing page field being edited (`fieldValue`), including the layout, zones, and blocks
- a block-ID-to-name mapping (`blocksIdMap`)
- a list of translations for the frontend to use (`translations`)

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

The `PB:UPDATE_FIELD_DATA` message is sent from the Page Builder to the frontend resource when the Landing page field value is updated.

Its data contains the field's new value, with the following structure:

- the current value of the Landing page field being edited (`fieldValue`), including the layout, zones, and blocks.
- the list of the existing block types, their attributes, and their configuration (`blocksConfig`)
- the block-ID-to-name mapping (`blocksIdMap`)
- the list of IDs from the new blocks that have been added (`highlightedBlockIds`)

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

The Page Builder sends the `PB:DISPATCH_EVENT` message to the frontend resource to be re-dispatched there as a custom event.
The message's data contains the name of the event to dispatch (`eventName`) and the data to pass in the event's `detail` property (`eventDetail`).

```js
window.addEventListener('message', (messageEvent) => {
    switch (messageEvent.data.type) {
        case 'PB:DISPATCH_EVENT':
            window.dispatchEvent(new CustomEvent(messageEvent.data.data.eventName, { detail: messageEvent.data.data.eventDetail }));
            break;
    }
});
```

#### Available events

- `ibexa-active-block-clicked` - Confirms that `APP:BLOCK_CLICKED` was received. It has no data
- `ibexa-post-update-blocks-preview` - Sent when the timeline is used
    - `fieldValue` - The same as in [`PB:UPDATE_FIELD_DATA`](#on-field-update)
    - `blockIds` - A list of all the block IDs
    - `blocksMaps` - A map of block config per block ID

```js
window.addEventListener('ibexa-post-update-blocks-preview', (customEvent) => {
    setLayout(customEvent.detail.fieldValue.layout);
    renderZones(customEvent.detail.fieldValue.zones);
});
```

### Geometry and pointer tracking (`blocks.geometry` and `pointer.tracking`)

Pointer tracking and geometry help the Page Builder position block-editing menus over the frontend preview.
These menus are `.c-pb-headless-preview-menu` elements positioned by the Page Builder in its DOM above the preview `iframe`.

The frontend preview sends the `APP:MOUSE_POSITION` message to report the mouse's current position to the Page Builder.

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

The frontend preview sends the `APP:POSITIONS_UPDATE` message to report the blocks' current positions to the Page Builder.
Its data contains a list of objects with block IDs, positions, and dimensions in the frontend preview.
This format is similar to the object returned by the [`getBoundingClientRect()`](https://developer.mozilla.org/en-US/docs/Web/API/Element/getBoundingClientRect) method.

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

Send this message whenever the positions of the blocks change, for example, after updating the blocks in response to [`PB:UPDATE_FIELD_DATA`](#on-field-update), scrolling, or resizing.

The frontend preview sends the `APP:SCROLL_END` message to notify the Page Builder that a scroll operation has ended.
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

### Dragging and dropping (`blocks.dnd`)

The Page Builder sends the `PB:DRAG_OVER` message to the frontend preview to report the mouse position while a new or existing block is being dragged.

!!! tip "Mouse tracking"

    - `APP:MOUSE_POSITION` helps the Page Builder track the mouse as it moves over the preview. Together with `APP:POSITIONS_UPDATE`, it lets the Page Builder determine whether the pointer is over a preview block.
    - `PB:DRAG_OVER` helps the frontend track the mouse as a block is dragged over the preview.

The Page Builder sends `PB:DRAG_START_PREVIEW` and `PB:DRAG_END_PREVIEW` messages at the beginning and end of a drag operation on an existing block in the frontend preview.
Message data contains the ID of the block being dragged (`blockId`).

```js
window.addEventListener('message', (messageEvent) => {
    switch (messageEvent.data.type) {
        case 'PB:DRAG_START_PREVIEW':
            document.querySelector(`[data-ibexa-block-id="${messageEvent.data.data.blockId}"]`).classList.add('c-pb-block-preview--is-dragging-out');
            break;
        case 'PB:DRAG_END_PREVIEW':
            document.querySelector(`[data-ibexa-block-id="${messageEvent.data.data.blockId}"]`).classList.remove('c-pb-block-preview--is-dragging-out');
            break;
    }
});
```

The Page Builder sends the `PB:DROP` message to the frontend preview to notify it that a block has been dropped.
The message has no data.
Combined with the most recent `PB:DRAG_OVER` message, it lets the frontend determine where the block was dropped.

The frontend preview sends the `APP:DROP_RESPONSE` message to the Page Builder to report where the block was dropped.

Its data contains:

- the ID of the zone where the block has been dropped (`zoneId`)
- the ID of the block that will follow the dropped block (`nextBlockId`), if the dropped block is not the last block in the zone

In the following example, `targetBlockId` is the ID of the block that the dragged block was dropped on or just before.
The dragged block is inserted in that block's place, moving the existing block down by one position.
If the dragged block is dropped at the bottom of the zone, `targetBlockId` is `null`.

```js
const dropResponseMessage = {
    type: 'APP:DROP_RESPONSE',
    data: {
        zoneId: zoneId,
        nextBlockId: targetBlockId,
    }
};
```

After the frontend sends `APP:DROP_RESPONSE`, the next `PB:UPDATE_FIELD_DATA` message from the Page Builder contains the dropped block's ID in its `highlightedBlockIds` array (`messageEvent.data.data.highlightedBlockIds`).

The Page Builder sends the `PB:SCROLL_BY` message when a block is dragged near an edge of the preview, indicating that the preview needs to be scrolled.
Its data contains the amount to scroll vertically (`top`).

```js
window.addEventListener('message', (messageEvent) => {
    switch (messageEvent.data.type) {
        case 'PB:SCROLL_BY':
            window.scrollBy(messageEvent.data.data);
            break;
    }
});
```

For information about reporting the end of a scroll operation and updating block positions, see `APP:SCROLL_END` and `APP:POSITIONS_UPDATE` in [Geometry (`blocks.geometry`)](#geometry-and-pointer-tracking-blocksgeometry-and-pointertracking).

### Block reveal (`blocks.reveal`)

The Page Builder sends the `PB:SCROLL_INTO_BLOCK` message to the frontend preview to request that a block be scrolled into view.
Its data contains the ID of the block to scroll into view (`blockId`).
It can be used with the [`scrollIntoView()`](https://developer.mozilla.org/en-US/docs/Web/API/Element/scrollIntoView) method.

```js
window.addEventListener('message', (messageEvent) => {
    switch (messageEvent.data.type) {
        case 'PB:SCROLL_INTO_BLOCK':
            const blockElementToScrollInto = document.querySelector(`[data-ibexa-block-id="${messageEvent.data.data.blockId}"]`);
            blockElementToScrollInto.scrollIntoView({ behavior: 'smooth', block: 'center' });
            break;
    }
});
```

### Block removal (`blocks.remove`)

The Page Builder sends the `PB:BLOCK_REMOVE` message to the frontend preview to notify it that a block should be removed, for example, from the Structure view.
Message data contains the ID of the block to remove (`blockId`).

The frontend preview sends the `APP:BLOCK_REMOVE_RESPONSE` message to the Page Builder to confirm that the block has been removed as requested by `PB:BLOCK_REMOVE`.
Message data contains the ID of the removed block (`blockId`).
You can send it immediately or after the removal animation.

```js
window.addEventListener('message', (messageEvent) => {
    switch (messageEvent.data.type) {
        case 'PB:BLOCK_REMOVE':
            const blockId = messageEvent.data.data.blockId;
            const blockElementToRemove = document.querySelector(`[data-ibexa-block-id="${blockId}"]`);
            if (blockElementToRemove) {
                blockElementToRemove.addEventListener('animationend', () => {
                    blockElementToRemove.remove();
                    window.parent.postMessage({
                        type: 'APP:BLOCK_REMOVE_RESPONSE',
                        data: {
                            blockId: blockId,
                        },
                    }, pbOrigin);
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

The frontend preview sends the `APP:BLOCK_REMOVE_REQUEST` message to the Page Builder to request that a block be removed.
Message data contains the ID of the block to remove (`blockId`).
The Page Builder responds with a `PB:UPDATE_FIELD_DATA` message.

## Guidelines for frontend implementation

The protocol documentation uses vanilla JavaScript examples, but you should use a JavaScript framework to implement the frontend.

The frontend and Page Builder preview should share as much code as possible.
For example, you could use the same controller, called in different ways, to determine whether to render the regular frontend or the Page Builder preview.

Each block type view should be implemented as a component so you can easily add new block types and new views.

You can name CSS classes as you wish, but following these conventions can make existing stylesheets easier to reuse.

### CSS classes and data attribute conventions

By convention, some class names are used only in the Page Builder preview, while others are always used.

For example, when the frontend is used in the Page Builder preview, the `c-pb-iframe__preview-body` class is added to the document body.

#### Zones

The always present `data-ibexa-zone-id` attribute (`zoneElement.dataset.ibexaZoneId`) contains the zone ID.

| Class name                       | PB only | Description                                         |
|----------------------------------|---------|-----------------------------------------------------|
| `landing-page__zone`             | No      | Every zone container                                |
| `landing-page__zone--${zone.id}` | No      | Each zone container with its own ID                 |
| `m-page-builder__zone`           | Yes     | Every zone container in the Page Builder preview    |
| `m-page-builder__zone--dragover` | Yes     | When a block is dragged over the zone               |
| `m-page-builder__zone--empty`    | Yes     | When the zone has no block                          |

### Blocks

The always present `data-ibexa-block-id` attribute (`blockElement.dataset.ibexaBlockId`) contains the block ID.

| Class name                            | PB only | Description                                                                                           |
|---------------------------------------|---------|-------------------------------------------------------------------------------------------------------|
| `landing-page__block`                 | No      | Every block container                                                                                 |
| `c-pb-block-preview`                  | Yes     | Every block container in the Page Builder preview                                                     |
| `c-pb-block-preview--is-dragging-out` | Yes     | When a block is being dragged                                                                         |
| `c-pb-block-preview--is-removing`     | Yes     | When a block is being removed (see [Block removal (`blocks.remove`)](#block-removal-blocksremove))    |
| `ibexa-mark-invisible`                | Yes     | When a scheduled block is marked as invisible                                                         |
| `c-pb-block-preview--unavailable`     | Yes     | When a block is unavailable for this field                                                            |
| `c-pb-block-preview__inner`           | Yes     | The inner container of a block                                                                        |
| `c-pb-block-preview__inner--invalid`  | Yes     | The inner container of a block with invalid attribute value                                           |
| `droppable-placeholder`               | Yes     | The placeholder element shown when a block is being dragged over a zone to indicate the drop position |
| `c-pb-block-preview--highlighted`     | Yes     | When a block is highlighted, for example, when newly dropped                                          |

## Static example

The following vanilla JavaScript demo is provided as-is to illustrate how to use the Page Builder protocol.
You can use it to observe the messages exchanged between the Page Builder and a frontend preview in the browser's JavaScript console.
It doesn't support all block types or views.

`page.html` is a static HTML page with JavaScript that handles Page Builder protocol messages and demonstrates the intended uses of the conventional CSS classes.
It works both as a standalone page and as a Page Builder preview.

??? note "`page.html`"

    ``` html hl_lines="175 527 778"
    [[= include_code('code_samples/page/headless/page.html', indent_level=1) =]]
    ```

Edit `page.html`:

- Change the `apiBaseUrl` constant to set the origin to which requests are sent for the REST API and conversion controller.
- Change the `pbOrigin` constant to set the Page Builder's origin.
- Change `pageContentTypeIds` to list the content type IDs that have a Landing Page field. You can set it to `false` to skip the content type check.

The demo supports the following block types and views:

- Code (`tag`) block type with `default` and `source_code` views
- Content List (`contentlist`) block type with `default` view
