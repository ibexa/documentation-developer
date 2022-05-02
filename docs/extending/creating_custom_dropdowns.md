# Create custom drop-downs

In [[= product_name =]], you can create a reusable custom drop-down and implement it anywhere in the Back Office.
Follow the steps below to learn how to integrate this component to fit it to your project needs.

## Prepare custom drop-down structure

First prepare the component structure and place it in the template inside the `content` section. See the example:

```twig
{% include '@ibexadesign/ui/component/dropdown.html.twig' with {
    source,
    choices,
    preferred_choices,
    value,
    multiple,
    translation_domain,
    custom_form,
    class,
    placeholder,
    custom_init,
} %}
```

## Create `<select>` input

Next, set elements which are available for the `<select>` input, for example:

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

 `<select>` input shoud have `ibexa-input` class.

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

If you need a multilevel `choices`, use the following structure:

```twig{% set choices = [{
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

You can configure the following attributes:

Name|Values|Definition|
|---|------|----------|
|`source`| - |What is currently defined in the `<select>` input header.|
|`choices`| - |Elements listed in the drop-down.|
|`preferred_choices`|Elements listed at the top of the list with a separator.|
|`value`|-|The currently selected element.It is an object with a key `value`. |
|`multiple`| true</br>false|Boolean. To allow users to select multiple items, add this attribute to the same element.|
|`translation_domain`|true</br>false|Used for translating choices and placeholder.|
|`custom_form`|true</br>false|For custom form must be set to true.|
|`class`| - |Additional classes for the element with `ibexa-dropdown` class.|
`placeholder`|Displayed placeholder when no option is selected.|
|`custom_init`|true</br>false|By default set to `false`. If set to `true`, requires to manually initialize drop-down in the JavaScript.|

![Drop-down expanded state](img/dropdown_expanded_state.png)

## Initialize

All drop-downs are searched and initialized automatically in `admin.dropdown.js`. However, if you want to extend it or make some modifications, run the following JavaScript code:

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
|`container`|Contains a reference to a DOM node where custom drop-down is initialized.|required|
|`selectorSource`|Contains a reference |required|
|`itemsContainer`|Contains a reference to a duplicated items container.|required|
|`hasDefaultSelection`|Contains a boolean value. If set to `true` the first option will be selected as a placeholder or selected value.|optional|
|`selectedItemTemplate`|Contains a literal template string with placeholders for `value` and `label` data.|optional|