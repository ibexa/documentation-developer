# Creating custom dropdowns

In eZ Platform you are able to implement custom dropdowns anywhere in the system.
Follow bellow steps to learn how to manipulate small component/library in order to do so. 

## Prepare custom dropdown structure

First prepare the HTML code structure in the following way:

```html hl_lines="2"
<div class="ez-custom-dropdown">
    <select class="ez-custom-dropdown__select" hidden multiple>
        <option value="1" selected>Option 1</option>
        <option value="2">Option 2</option>
        <option value="3">Option 3</option>
        <option value="4">Option 4</option>
    </select>
    <div class="ez-custom-dropdown__wrapper">
        <ul class="ez-custom-dropdown__selection-info"></ul>
        <ul class="ez-custom-dropdown__items ez-custom-dropdown__items--hidden">
            <li data-value="" class="ez-custom-dropdown__item" disabled>Select an option</li>
            <li data-value="1" class="ez-custom-dropdown__item">Option 1</li>
            <li data-value="2" class="ez-custom-dropdown__item">Option 2</li>
            <li data-value="3" class="ez-custom-dropdown__item">Option 3</li>
            <li data-value="4" class="ez-custom-dropdown__item">Option 4</li>
        </ul>
    </div>
</div>
```

Highlighted line in the code above contains a hidden native `select` input. It stores values of selection.
Input is hidden because custom dropdown replicates its functionality.
Do not remove it. Removal would break the functionality of any submission form.

![Dropdown expanded state](img/dropdown_expanded_state.jpg)

## Generate <select> input

Next step is generating a standard select input with `ez-custom-dropdown__select` CSS class added to `<select></select>` element.
This element should contain at least one additional attribute: `hidden`. 
If you want to allow users to pick multiple items from a list add the `multiple` attribute to the same element.

```html
    <select class="ez-custom-dropdown__select" hidden multiple></select>
```

![Dropdown multiple selection](img/dropdown_multiple_selection.jpg)

## Add attributes

Next look into `data-value` attribute that is added in the above code to replicated options with the CSS class: `ez-custom-dropdown__item`. It stores a value of an option from a select input.

You can provide placeholder text for your custom dropdown.
To do so remove `data-value` attribute and add `disabled` attribute to the item in the replicated list of options as shown in the example below. 
 It will make it unclickable.
 
 ```html
<li data-value="" class="ez-custom-dropdown__item" disabled>Select an option</li>
<li data-value="1" class="ez-custom-dropdown__item">Option 1</li>
```

## Initialize

To initialize custom dropdown run below JavaScript code:

```javascript
(function (global, document) {
const container = document.querySelector('.ez-custom-dropdown');

const dropdown = new global.eZ.core.CustomDropdown({
    container: container,
    sourceInput: container.querySelector('.ez-custom-dropdown__select'),
    itemsContainer: container.querySelector('.ez-custom-dropdown__items'),
    hasDefaultSelection: true
});

dropdown.init();
})(window, window.document);
```

## Configuration options

Full list of options:

|Name|Description|Required|
|----|-----------|--------|
|`container`|contains a reference to a DOM node where custom dropdown is initialized|required|
|`sourceInput`|contains a reference to a DOM node where the value of selected option is stored. Presumably, it should be a reference to a select input node|required|
|`itemsContainer`|contains a reference to a replicated items container|required|
|`hasDefaultSelection`|contains a boolean value. If set to `true` the first option will be selected as a placeholder or selected value|optional|
|`selectedItemTemplate`|contains a literal template string with placeholders for `value` and `label` data|optional|

In the above code samples you will find 4 of 5 configuration options.
Default template HTML code structure for missing `selectedItemTemplate` looks like this:

```html
    <li class="ez-custom-dropdown__selected-item" data-value="{{value}}">{{label}}<span class="${CLASS_REMOVE_SELECTION}"></span></li>
```