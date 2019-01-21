# Drag and drop interface class

In eZ Platform you are able to create a generic interface for drag and drop interactions that can be reused in many places.

First prepare the HTML code structure that will be placed in a Twig template in the following way:

```html
<div class="items-container" data-placeholder="HTML template for placeholder"></div>
```

Next, add options in the same Twig template or in a JavaScript code that comes with the template following the convention:

```javascript
const draggable = new global.eZ.core.Draggable({
        itemsContainer: HTMLElement of .items-container,
        selectorItem: String,
        selectorPlaceholder: String,
});
```

For more information on creating Twig templates see [Templating basics](../guide/templates.md).

## Options

Full list of options:

|Option|Description|Required|
|------|-----------|--------|
|`itemsContainer`|a reference to DOM node containing a draggable items|required|
|`selectorItem`|a CSS selector of a draggable item|required|
|`selectorPlaceholder`|a CSS selector of a placeholder|required|
|`afterInit`|a callback function invoked after interface initialization|optional|
|`afterDragStart`|a callback function invoked after starting to drag|optional|
|`afterDragOver`|a callback function invoked after moving onto a droppable element|optional|
|`afterDrop`|a callback function invoked after dropping an element|optional|
|`attachCustomEventHandlersToItem`|a function to be invoked while attaching event handlers to every item in the item's container|optional|