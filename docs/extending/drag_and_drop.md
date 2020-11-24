# Creating drag and drop interface

In [[= product_name =]], you can create a generic interface for drag and drop interactions reusable in many places.

First, prepare the HTML code structure that will be placed in a Twig template in the following way:

```html
<div class="items-container" data-placeholder="HTML template for placeholder"></div>
```

Next, add options in the same Twig template or in a JavaScript code that comes with the template following the convention:

```javascript
const draggable = new window.eZ.core.Draggable({
        itemsContainer: HTMLElement of .items-container,
        selectorItem: String,
        selectorPlaceholder: String,
});
```

For more information on creating Twig templates, see [Templating basics](../guide/templates.md).

## Options

Full list of options:

|Option|Description|Required|
|------|-----------|--------|
|`itemsContainer`|Reference to DOM node containing a draggable item|required|
|`selectorItem`|CSS selector of a draggable item|required|
|`selectorPlaceholder`|CSS selector of a placeholder|required|
|`afterInit`|Callback function invoked after interface initialization|optional|
|`afterDragStart`|Callback function invoked after starting to drag|optional|
|`afterDragOver`|Callback function invoked after moving onto a droppable element|optional|
|`afterDrop`|Callback function invoked after dropping an element|optional|
|`attachCustomEventHandlersToItem`|Function to be invoked while attaching event handlers to every item in the item's container. Item of `HTMLElement` type is passed to the function as the first param|optional|
