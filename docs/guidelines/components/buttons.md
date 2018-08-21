# Buttons

We use button as main element for click function. Use a disabled attribute `disabled="disabled"` when a button can't be clicked.

##<div class="mgt-3 header-line">Basic buttons</div>

###<div class="mgt-minus-2">Primary button</div>
[[code_example {html}
<button type="button" class="btn btn-primary">Confirm selection</button>
code_example]]

###<div class="mgt-3">Disabled state</div>
[[code_example {html}
<button type="button" class="btn btn-primary" disabled="disabled">Confirm selection</button>
code_example]]

###<div class="mgt-3">Neutral button</div>
[[code_example {html}
<button type="button" class="btn btn-dark">Cancel</button>
code_example]]

###<div class="mgt-3">Secondary button</div>
[[code_example {html}
<button type="button" class="btn btn-secondary">Save</button>
code_example]]

###<div class="mgt-3">Negative button</div>
[[code_example {html}
<button type="button" class="btn btn-danger">Send to trash</button>
code_example]]

###<div class="mgt-3">Outline button</div>
[[code_example {html}
<button type="button" class="btn btn-outline-secondary">Select content item</button>
code_example]]

##<div class="mgt-3 header-line">Wide buttons</div>
<div class="mgt-minus-3 mgb-4">Add class <code>btn--wide</code> when in need of a wider button in the UI.</div>
[[code_example {html}
<button type="button" class="btn btn-primary ez-btn--wide">Send for review</button>
code_example]]

##<div class="mgt-3 header-line">Buttons with icons</div>
<div class="mgt-minus-3 mgb-4">Add class <code>btn--wide</code> when in need of a wider button in the UI.</div>
[[code_example {html}
<button type="button" class="btn btn-primary">
    <svg class="ez-icon ez-icon--medium ez-icon--light ez-icon-create">
        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../ez-icons.svg#create"></use>
    </svg>
    <span>Create</span>
</button>
code_example]]