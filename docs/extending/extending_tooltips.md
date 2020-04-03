# Extending tooltips

Tooltips help provide more information for the users when they hover over, focus on, or tap an element.
eZ Platform tooltips use [Bootstrap tooltips.](https://getbootstrap.com/docs/4.1/components/tooltips/)

To create a tooltip you have to add a `title` attribute with a custom tooltip text for HTMLnode.

```html
<button title="custom tooltip text">click me</button>
```

Additionally, you can add following attributes:

- `data-extra-classes` - an additional class for tooltip container `.tooltip`
- `data-tooltip-container-selector` - a css selector for a tooltip container (Bootstrap tooltip `data-container` attribute)

Example of a tooltip with additional attributes:

```html
<button title="custom tooltip text" data-extra-classes="additional_class" data-tooltip-container-selector="selector">
	click me
</button>
```

You can also add tooltip helpers to the JavaScript `eZ.helpers` object:

- `eZ.helpers.tooltips.parse(optional HTMLnode)` - creates a tooltip. Equivalent of `$(selector).tooltip()`. HTMLnode will execute `querySelectorAll` on this object, a `window.document` is default value.
- `eZ.helpers.tooltips.hideAll(optional HTMLnode)` - closes all tooltips. Equivalent of `$(selector).tooltip('hide')`. HTMLnode will execute `querySelectorAll` on this object, a `window.document` is default value.
