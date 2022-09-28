---
description: Add custom drop down menus to Back Office interface.
---

# Add drop-downs

In [[= product_name =]], you can create a reusable custom drop-down and implement it anywhere in the Back Office.
Follow the steps below to learn how to integrate this component to fit it to your project needs.

## Create `<select>` input

Set elements which are available for the `<select>` input, for example:

```twig
{% set source %}
<select class="ibexa-input">
    <option value="DE">DE</option>
    <option value="US">US</option>
    <option value="NO">NO</option>
    <option value="PL">PL</option> 
</select>
{% endset %}
```

 `<select>` input must have the `ibexa-input` class.
The `multiple` setting is optional, but you should add it if the drop-down attribute `multiple` is set to true.

Define `choices`:

```twig
{% set choices = [{
    value: "DE",
    label: "DE"
}, {
    value: "US",
    label: "US"
}, {
    value: "NO",
    label: "NO"
}, {
    value: "PL",
    label: "PL"
}] %}
```

If you need multilevel choices, use the following structure:

```twig
{% set choices = [{
    value: "DE",
    label: "DE"
}, {
    value: "US",
    label: "US"
}, {
    value: "NO",
    label: "NO"
}, {
    value: "PL",
    label: "PL",
    choices: [{
        value: "PL_S",
        label: "Silesian"
    }, {
        value: "PL_K",
        label: "Kashubian"
    }]
}] %}
```

To set `preferred_choices`, use the following:

```twig
{% set preferred_choices = [{
    value: "NO",
    label: "NO"
}] %}
```

For `value`, see the example:

```twig
{% set value = [{
    value: "DE",
    label: "DE"
}] %}
```

## Prepare custom drop-down structure

Next, prepare the component structure and place it in the template after setting the needed attributes. See the example:

```twig
{% include '@ibexadesign/ui/component/dropdown/dropdown.html.twig' with {
    source: source,
    choices: choices,
    preferred_choices: preferred_choices,
    value: value
} %}
```

## Drop-down attributes

The following attributes are available:

|Name|Values|Definition|
|---|------|----------|
|`source`| - |What is currently defined in the `<select>` input header.|
|`choices`| - |Elements listed in the drop-down.|
|`preferred_choices`|Elements listed at the top of the list with a separator.|
|`value`|-|The currently selected element. It is an object with a key `value`. |
|`multiple`| true</br>false|Boolean. To allow users to select multiple items.|
|`translation_domain`|true</br>false|Used for translating choices and placeholder.|
|`custom_form`|true</br>false|For custom form must be set to true.|
|`class`| - |Additional classes for the element with `ibexa-dropdown` class.|
|`placeholder`|Placeholder displayed when no option is selected.|
|`custom_init`|true</br>false|By default set to `false`. If set to `true`, requires manually initializing drop-down in JavaScript.|
|`is_disabled`|true</br>false|Disables drop-down.|
|`is_hidden`|true</br>false|Hides the whole widget.|
|`is_small`|true</br>false|Adjusts height of the widget (from 48px to 32px).|
|`is_ghost`|true</br>false|Changes layout of the widget, removes all borders and backgrounds (similar to buttons modifier).|
|`min_search_items`|number, default 5|Minimum number of options that have to be passed to show the search inside the drop-down.|
|`selected_item_label`|text|Allows setting constant label for widget. By default the visible label shows the currently selected options.|
|`has_select_all_toggler`|true</br>false|Allows showing a "Select all" option if the minimum number of items is reached.|
|`min_select_all_toggler_items`|number, default 5|Minimum number of items the dropdown must have for the "Select all" option to appear.|

![Drop-down expanded state](dropdown_expanded_state.png)

## Extend drop-down templates

### Initialize

All drop-downs are searched and initialized automatically in `admin.dropdown.js`.
To extend or modify the search, you need to add a `custom_init` attribute to the drop-down Twig parameters. Otherwise it will be initialized two times.
Next, run the following JavaScript code:

```javascript
(function (global, document) {
const container = document.querySelector('.ibexa-dropdown');
const dropdown = new global.ibexa.core.Dropdown({
    container,
    selectorSource,
});

dropdown.init();
})(window, window.document);
```

## Configuration options

Full list of options:

|Name|Description|Required|
|----|-----------|--------|
|`container`|Contains a reference to a DOM node where the custom drop-down is initialized.|required|
|`selectorSource`|Use to change class of the source element.|required|
