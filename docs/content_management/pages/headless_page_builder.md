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

| Capability       | Message type              | Description                                                                                               |
|------------------|---------------------------|-----------------------------------------------------------------------------------------------------------|
| (handshake)      | APP:INITIALIZED           | To establish the communication and declare which protocol version and capabilities are supported.         |
| (handshake)      | PB:INIT_MODE              | To validate the communication and give information about the edited content draft.                        |
| (core)           | PB:UPDATE_FIELD_DATA      | To notify that the field has changed, like when a block have been edited or the layout has been switched. |
| (core)           | PB:DISPATCH_EVENT         | To help converting message into custom event. TODO                                                        |
| blocks.dnd       | PB:DRAG_START_PREVIEW     | TODO                                                                                                      |
| blocks.dnd       | PB:DRAG_OVER              | To give the position of the mouse while a new block is dragged.                                                                                                      |
| blocks.dnd       | PB:DRAG_END_PREVIEW       | TODO                                                                                                      |
| blocks.dnd       | PB:DROP                   | To notify that a new block has been dropped.                                                              |
| blocks.dnd       | APP:DROP_RESPONSE         | To notify that the drop action has been processed and declare which zone welcomed the new block.          |
| blocks.dnd       | PB:SCROLL_BY              | TODO                                                                                                      |
| blocks.geometry  | APP:POSITIONS_UPDATE      | To declare the actual position of the blocks (so the block editing menus can be positionned).                                                                                                      |
| blocks.geometry  | APP:SCROLL_END            | TODO                                                                                                      |
| blocks.remove    | PB:BLOCK_REMOVE           | TODO                                                                                                      |
| blocks.remove    | APP:BLOCK_REMOVE_RESPONSE | TODO                                                                                                      |
| blocks.remove    | APP:BLOCK_REMOVE_REQUEST  | TODO                                                                                                      |
| blocks.reveal    | PB:SCROLL_INTO_BLOCK      | TODO                                                                                                      |
| blocks.select    | APP:BLOCK_CLICKED         | To notify that a block has been clicked.                                                                                                      |
| pointer.tracking | APP:MOUSE_POSITION        | To declare the actual position of the mouse (so the block editing menus can be displayed on hover).                                                                                                      |
| preview.params   | PB:UPDATE_PREVIEW_PARAMS  | TODO                                                                                                      |

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
- the actual version of the protocol used (`protocol.version`) and the other supported versions (`protocol.supported`).
- a list of all available capabilities (`capabilities`)
- a list of the existing block types, their attributes, and their configuration (`blocksConfig`)
- information about the actually edited content draft (`intentParameters`)
- the current value of the Landing page field being edited (`fieldValue`) including the layout, zones, and blocks.
- a block ID to name mapping (`blocksIdMap`)
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
