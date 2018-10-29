# Buttons

We use button as main element for click function. Use a disabled attribute `disabled="disabled"` when a button can't be clicked.

##<div class="mgt-3 header-line">Basic buttons</div>

###<div class="mgt-minus-2"></div>
**<div class="mgt-minus-5 mgb-3">Primary button</div>**
[[code_example {html}
<button type="button" class="btn btn-primary">Confirm selection</button>
code_example]]

###<div class="mgt-minus-2"></div>
**<div class="mgb-3">Disabled state</div>**
[[code_example {html}
<button type="button" class="btn btn-primary" disabled="disabled">Confirm selection</button>
code_example]]

###<div class="mgt-minus-2"></div>
**<div class="mgb-3">Neutral button</div>**
[[code_example {html}
<button type="button" class="btn btn-dark">Cancel</button>
code_example]]

###<div class="mgt-minus-2"></div>
**<div class="mgb-3">Secondary button</div>**
[[code_example {html}
<button type="button" class="btn btn-secondary">Save</button>
code_example]]

###<div class="mgt-minus-2"></div>
**<div class="mgb-3">Negative button</div>**
[[code_example {html}
<button type="button" class="btn btn-danger">Send to trash</button>
code_example]]

###<div class="mgt-minus-2"></div>
**<div class="mgb-3">Outline button</div>**
[[code_example {html}
<button type="button" class="btn btn-outline-secondary">Select content item</button>
code_example]]

##<div class="mgt-3 header-line">Set of two buttons</div>
<div class="mgt-minus-3 mgb-4">When combining two buttons together emphasize the preferred primary action button with a bolded font-weight.</div>
<div class="ez-guidelines-buttons__two-buttons ez-guidelines-sample">
[[code_example {html}
<button type="button" class="btn btn-dark">Cancel</button>
<button type="button" class="btn btn-danger font-weight-bold">Send to trash</button>
code_example]]
<div class="ez-guidelines-sample__correct-block">Yes</div>
</div>

###
<div class="ez-guidelines-buttons__two-buttons ez-guidelines-sample ez-guidelines-sample-negative mgb-1">
[[code_example {html}
<button type="button" class="btn btn-dark">Cancel</button>
<button type="button" class="btn btn-danger">Send to trash</button>
code_example]]
<div class="ez-guidelines-sample__correct-block ez-guidelines-sample__correct-block-negative">No</div>
</div>

##<div class="mgt-5 header-line">Wide buttons</div>
<div class="mgt-minus-3 mgb-4">Add class `ez-btn--wide` when in need of a wider button in the UI.</div>
[[code_example {html}
<button type="button" class="btn btn-primary ez-btn--wide">Send for review</button>
code_example]]

##<div class="mgt-5 header-line">Buttons with icons</div>
<div class="mgt-minus-3 mgb-4">Add the icon you want to your action button and specify the classes you need for it.</div>
<div class="ez-guidelines-buttons__button-icon">
[[code_example {html}
<button type="button" class="btn btn-primary">
    <svg class="ez-icon ez-icon--medium ez-icon--light ez-icon-create">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#create"></use>
    </svg> 
    Create
</button>
code_example]]
</div>

!!! note
    We have used here a colored icon `ez-icon--light` as an example. If you want to dig more into icons check [Icons](resources/icons.md) within Resources.

##<div class="mgt-3 header-line">Buttons in menu bars</div>
<div class="mgt-minus-3 mgb-4">When adding a new action button that is part of the menu bars, `ez-side-menu` and `ez-context-menu`, we use the following two options: buttons and links that look like buttons as well.</div>

###<div class="mgt-minus-5"></div>
**<div class="mgb-3">Buttons within Discovery menu bar</div>**
<div class="mgt-minus-3 mgb-4">Buttons within the Discovery menu bar, `ez-side-menu`, are styled as follows:</div>
<div class="ez-guidelines-buttons__side-menu">
[[code_example {html}
<button type="button" class="btn btn-dark btn-block">
    <svg class="ez-icon ez-icon-browse">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#browse"></use>
    </svg>
    Browse
</button>
code_example]]
</div>

###<div></div>
**<div class="mgt-minus-1 mgb-3">Link Buttons within Discovery menu bar</div>**
<div class="mgt-minus-3 mgb-4">Links that look like buttons within the Discovery menu bar, `ez-side-menu`, have the same styling as buttons.</div>
<div class="ez-guidelines-buttons__side-menu btn-block--white">
[[code_example {html}
<a type="button" class="btn btn-dark btn-block">
    <svg class="ez-icon ez-icon-search">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#search"></use>
    </svg>
    Search
</a>
code_example]]
</div>

###<div></div>
**<div class="mgt-minus-1 mgb-3">Buttons within Context menu bar</div>**
<div class="mgt-minus-3 mgb-4">Buttons within the Context menu bar, `ez-context-menu`, allow users to interact with their specific content item. They are styled as secondary buttons.</div>
<div class="ez-guidelines-buttons__side-menu">
[[code_example {html}
<button type="button" class="btn btn-secondary btn-block">
    <svg class="ez-icon ez-icon-publish">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#publish"></use>
    </svg>
    Publish
</button>
code_example]]
</div>

##<div class="mgt-3 header-line">Buttons in tables</div>
<div class="mgt-minus-3 mgb-4">When adding a new action button that is part of content listed within tables, `ez-table-header`, we use the following two options: buttons that are part of the header and the ones that are included within table rows.</div>

###<div class="">Button in table header</div>
<div class="ez-guidelines-buttons__table-header">
[[code_example {html}
<button type="button" class="btn btn-primary">
    <svg class="ez-icon ez-icon-create">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#create"></use>
    </svg>
</button>
code_example]]
</div>

###<div class="mgt-3">Button in table rows</div>
<div class="ez-guidelines-buttons__table-row">
[[code_example {html}
<button type="button" class="btn btn-icon">
    <svg class="ez-icon ez-icon-edit">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#edit"></use>
    </svg>
</button>
code_example]]
</div>
