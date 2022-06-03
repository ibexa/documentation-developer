# Add drop-downs

In [[= product_name =]], you can create a reusable custom drop-down and implement it anywhere in the Back Office.
Follow the steps below to learn how to integrate this component to fit it to your project needs.

## Prepare custom drop-down structure

First prepare the component HTML code structure in the template inside the `content` section:

```html hl_lines="2 11 12"
<div class="ibexa-custom-dropdown">
    <select class="ibexa-custom-dropdown__select" hidden multiple>
        <option value="1">Option 1</option>
        <option value="2">Option 2</option>
        <option value="3">Option 3</option>
        <option value="4">Option 4</option>
    </select>
    <div class="ibexa-custom-dropdown__wrapper">
        <ul class="ibexa-custom-dropdown__selection-info"></ul>
        <ul class="ibexa-custom-dropdown__items ibexa-custom-dropdown__items--hidden">
            <li data-value="" class="ibexa-custom-dropdown__item" disabled>Select an option</li>
            <li data-value="1" class="ibexa-custom-dropdown__item">Option 1</li>
            <li data-value="2" class="ibexa-custom-dropdown__item">Option 2</li>
            <li data-value="3" class="ibexa-custom-dropdown__item">Option 3</li>
            <li data-value="4" class="ibexa-custom-dropdown__item">Option 4</li>
        </ul>
    </div>
</div>
```

In line two, the code contains a hidden native `select` input. It stores the selection values.
Input is hidden because a custom drop-down duplicates its functionality.

!!! caution

    Do not remove the `select` input, otherwise form submission may not work.

![Dropdown expanded state](img/dropdown_expanded_state.jpg)

## Generate `<select>` input

Next, generate a standard select input with the `ibexa-custom-dropdown__select` CSS class added to the `<select>` element.
This element should contain at least one additional attribute: `hidden`. 
If you want to allow users to pick multiple items from a list, add the `multiple` attribute to the same element.

Example:

```html
    <select class="ibexa-custom-dropdown__select" hidden multiple></select>
```

![Drop-down multiple selection](img/dropdown_multiple_selection.jpg)

## Add attributes

Next, look at the `data-value` attribute in the code (line 11 and 12) for duplicated options with the CSS class: `ibexa-custom-dropdown__item`.
It stores a value of an option from a select input.

You can provide placeholder text for your custom drop-down. To do so:

- put a `data-value` attribute with no value `data-value=""`
- add a `disabled` attribute to the item in the duplicated list of options to make it unclickable.


Example:  
 
```html
<li data-value="" class="ibexa-custom-dropdown__item" disabled>Select an option</li>
<li data-value="1" class="ibexa-custom-dropdown__item">Option 1</li>
```

## Initialize

To initialize a custom drop-down, run the following JavaScript code:

```javascript
(function (global, document) {
const container = document.querySelector('.ibexa-custom-dropdown');

const dropdown = new global.ibexa.core.CustomDropdown({
    container: container,
    sourceInput: container.querySelector('.ibexa-custom-dropdown__select'),
    itemsContainer: container.querySelector('.ibexa-custom-dropdown__items'),
    hasDefaultSelection: true
});

dropdown.init();
})(window, window.document);
```

## Configuration options

Full list of options:

|Name|Description|Required|
|----|-----------|--------|
|`container`|contains a reference to a DOM node where custom drop-down is initialized.|required|
|`sourceInput`|contains a reference to a DOM node where the value of selected option is stored. Preferably, it should be a reference to a select input node.|required|
|`itemsContainer`|contains a reference to a duplicated items container.|required|
|`hasDefaultSelection`|contains a boolean value. If set to `true` the first option is selected as a placeholder or selected value.|optional|
|`selectedItemTemplate`|contains a literal template string with placeholders for `value` and `label` data.|optional|

In the code samples you can find 4 of 5 configuration options.
Default template HTML code structure for missing `selectedItemTemplate` looks like this:

```html
    <li class="ibexa-custom-dropdown__selected-item" data-value="{{value}}">{{label}}<span class="${CLASS_REMOVE_SELECTION}"></span></li>
```
