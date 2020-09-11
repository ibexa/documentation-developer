# Tooltips

We use Tooltips to provide more information for the users to identify an element, such as a description of its function, and guide them to take action.

**<div class="mgt-3">How they work</div>**
To add a new tooltip you have to add a `title` attribute with the custom tooltip text in the HTMLnode that should to have a tooltip.

```html
<button type="button" class="class" title="your custom tooltip text">click me</button>
```
Additionally, you can add following attributes:

- `data-extra-classes` - an additional class for tooltip container `.tooltip`
- `data-tooltip-container-selector` - a css selector for a tooltip container (Bootstrap tooltip `data-container` attribute)

Example of a tooltip with additional attributes:

```html
<button type="button" class="class" title="your custom tooltip text" data-extra-classes="additional_class" data-tooltip-container-selector="selector">
	click me
</button>
```

You can also add tooltip helpers to the JavaScript `eZ.helpers` object:

- `eZ.helpers.tooltips.parse(optional HTMLnode)` - creates a tooltip. Equivalent of `$(selector).tooltip()`. HTMLnode will execute `querySelectorAll` on this object, a `window.document` is default value.
- `eZ.helpers.tooltips.hideAll(optional HTMLnode)` - closes all tooltips. Equivalent of `$(selector).tooltip('hide')`. HTMLnode will execute `querySelectorAll` on this object, a `window.document` is default value.

A tooltip is displayed automatically when the user hovers the pointer over an action button, and removed when the user clicks the control or move the mouse. The tooltip can also be triggered by focusing on that specific element with the keyboard (tab key), or tapping on it.

!!! note
    Our application relies on [Bootstrap's tooltips](https://getbootstrap.com/docs/4.1/components/tooltips/). Check out their documentation for basic aspects regarding Tooltips configuration.

**<div class="mgt-3">Behavior & motion</div>**
A tooltip is displayed upon hovering over an action button. It shows up over 150ms and fades out over 75ms.

##<div class="mgt-3 header-line">Examples</div>

###<div class="mgt-minus-2"></div>
**<div class="mgt-minus-5 mgb-3">Tooltips in buttons with icons</div>**
<div class="ez-guidelines-tooltips-sample">
[[code_example {html}
<button type="button" class="btn btn-primary" title="Select content">
    <svg class="ez-icon ez-icon--medium ez-icon--light">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#relations"></use>
    </svg>
    Select content
</button>
<button type="button" class="btn ez-btn btn-secondary"  title="Add author">
    <svg class="ez-icon ez-icon-create">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#create"></use>
    </svg>
</button>
<button type="button" class="btn ez-btn btn-dark" title="Open new tab">
    <svg class="ez-icon ez-icon-open-newtab">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#open-newtab"></use>
    </svg>
</button>
code_example]]
</div>

###<div class="mgt-minus-2"></div>
**<div class="mgb-3">Tooltips in Table header</div>**
<div class="ez-guidelines-tables__with-header mgb-5">
[[code_example {html}
<div class="ez-table-header">
    <div class="ez-table-header__headline">Translation manager</div>
    <div>
        <button type="button" class="btn btn-primary" title="Add translation">
            <svg class="ez-icon ez-icon--medium ez-icon--light ez-icon-create">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#create"></use>
            </svg> 
        </button>
        <button type="button" class="btn btn-danger" disabled="disabled">
            <svg class="ez-icon ez-icon--medium ez-icon--light ez-icon-trash">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#trash"></use>
            </svg> 
        </button>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>Language name</th>
            <th>Language code</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="ez-checkbox-cell">
                <input type="checkbox">
            </td>
            <td>English (United Kingdom)</td>
            <td>eng-GB</td>
        </tr>
    </tbody>
</table>
code_example]]
</div>

###<div class="mgt-minus-2"></div>
**<div class="mgb-3">Tooltips in Table rows</div>**
<div class="ez-guidelines-tables__with-header ez-guidelines-tables__with-header--action-btn mgb-5">
[[code_example {html}
<div class="ez-table-header">
    <div class="ez-table-header__headline">Archived versions</div>
    <div>
        <button type="button" class="btn btn-danger" disabled="disabled">
            <svg class="ez-icon ez-icon--medium ez-icon--light ez-icon-trash">
                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#trash"></use>
            </svg> 
        </button>
    </div>
</div>
<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>Version</th>
            <th>Modified language</th>
            <th>Contributor</th>
            <th>Created</th>
            <th>Last saved</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="ez-table__cell ez-table__cell--has-checkbox">
                <input type="checkbox">
            </td>
            <td class="ez-table__cell">1</td>
            <td class="ez-table__cell">English (United Kingdom)</td>
            <td class="ez-table__cell">Administrator User</td>
            <td class="ez-table__cell">May 03, 2019 15:05</td>
            <td class="ez-table__cell">May 03, 2019 15:05</td>
            <td class="ez-table__cell ez-table__cell--has-action-btns text-right">
                <button type="button" class="btn btn-icon mx-2 ez-btn--content-edit" title="Restore archived version">
                    <svg class="ez-icon ez-icon-edit">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#archive-restore"></use>
                    </svg>
                </button>
            </td>
        </tr>
    </tbody>
</table>
code_example]]
</div>