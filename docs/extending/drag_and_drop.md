# Add drag and drop

You can create a generic interface for drag and drop interactions that you can reuse in many places across the Back Office.

First, prepare the HTML code structure and place it in a Twig template. See the example:

```html
<div class="items-container" data-placeholder="HTML template for placeholder"></div>
```

To initialize a drag and drop interface, add a JavaScript Code that comes with the template following the convention:

```javascript
const draggable = new window.ibexa.core.Draggable({
        itemsContainer: HTMLElement of .items-container,
        selectorItem: String,
        selectorPlaceholder: String,
});
```

For more information on creating Twig templates, see [Templating basics](../guide/content_rendering/templates/templates.md).

## Configuration options

Full list of options:

|Option|Description|Required|
|------|-----------|--------|
|`itemsContainer`|Reference to DOM node containing a draggable item.|required|
|`selectorItem`|CSS selector of a draggable item.|required|
|`selectorPlaceholder`|CSS selector of a placeholder.|required|
|`afterInit`|Callback function invoked after interface initialization.|optional|
|`afterDragStart`|Callback function invoked after starting to drag.|optional|
|`afterDragOver`|Callback function invoked after moving onto a droppable element.|optional|
|`afterDrop`|Callback function invoked after dropping an element.|optional|
|`attachCustomEventHandlersToItem`|Function to be invoked while attaching event handlers to every item in the item's container. Item of `HTMLElement` type is passed to the function as the first param.|optional|
