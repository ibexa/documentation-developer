# Form components

We list here all the basic form components that eZ Platform uses.

Remember to add the `type` you may want for extending or customizing the form you are working on.

##<div class="mgt-3 header-line">Label</div>
[[code_example {html}
<div class="form-group">
    <label class="ez-label">Identifier</label>
</div>
code_example]]

##<div class="mgt-3 header-line">Label & Input box</div>
[[code_example {html}
<div class="form-group">
    <label for="example_location_update" class="ez-label">Identifier</label>
    <input type="text" id="example_location_update" name="example_location_update" class="form-control">
</div>
code_example]]

##<div class="mgt-3 header-line">Input number</div>
<div class="ez-guidelines-formcomponent-number">
[[code_example {html}
<div class="form-group">
    <label for="example_number" class="ez-label">Number</label>
    <input type="number" id="example_number" name="example_number" class="form-control">
</div>
code_example]]
</div>

##<div class="mgt-3 header-line">Select list</div>
<div class="ez-guidelines-formcomponent">
[[code_example {html}
<div class="form-group">
    <label for="example_order_by" class="ez-label">Order by</label>
    <select id="example_order_by" name="example_order_by" class="form-control">
        <option>Content name</option>
        <option>Location priority</option>
        <option>Modification date</option>
        <option>Publication date</option>
        <option>Location path</option>
        <option>Section identifier</option>
        <option>Location depth</option>
        <option>Location ID</option>
        <option>Content ID</option>
    </select>
</div>
code_example]]
</div>

##<div class="mgt-3 header-line">Multiple Select list</div>
<div class="ez-guidelines-formcomponent-multiple">
[[code_example {html}
<div class="form-group">
    <label for="example_role_assignment" class="ez-label">Group</label>
    <select id="example_role_assignment" name="example_role_assignment" class="form-control" multiple="multiple">
        <option>Administrator Users</option>
        <option>Anonymous Users</option>
        <option>App Contributors</option>
        <option>Editors</option>
        <option>Members</option>
        <option>Users</option>
    </select>
</div>
code_example]]
</div>

##<div class="mgt-3 header-line">Radio buttons & Checkboxes</div>
[[code_example {html}
<div class="form-check form-check-inline">
    <input type="radio" id="example_radio-button_one" name="example_radio-button" class="form-check-input">
    <label class="form-check-label radio-inline" for="example_radio-button_one">No limitations</label>
</div>
<div class="form-check form-check-inline">
    <input type="radio" id="example_radio-button_two" name="example_radio-button" class="form-check-input">
    <label class="form-check-label radio-inline" for="example_radio-button_two">No limitations</label>
</div>
code_example]]

**<div class="mgt-3 mgb-3">Radio buttons group example:</div>**
<div class="ez-guidelines-formcomponent-radioExample">
[[code_example {html}
<div class="form-check form-check-inline">
    <input type="radio" id="example_radio-option_one" name="example_radio-button" class="form-check-input">
    <label class="form-check-label radio-inline" for="example_radio-option_one">No limitations</label>
</div>
<div class="example-group">
    <div class="form-check form-check-inline">
        <input type="radio" id="example_radio-option_two" name="example_radio-button" class="form-check-input">
        <label class="form-check-label radio-inline" for="example_radio-option_two">Sections</label>
    </div>
    <select id="example_role_assignment" name="example_role_assignment" class="form-control" multiple="multiple">
        <option>Setup</option>
        <option>Form</option>
        <option>Media</option>
        <option>Content</option>
        <option>Extra section</option>
        <option>Users</option>
    </select>
</div>
<div class="example-group">
    <div class="form-check form-check-inline">
        <input type="radio" id="example_radio-button_three" name="example_radio-button" class="form-check-input">
        <label class="form-check-label radio-inline" for="example_radio-option_three">Subtree</label>
    </div>
    <button type="button" class="btn btn-secondary">
        <svg class="ez-icon ez-icon--medium ez-icon--light ez-icon--select-subtree">
            <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#relations"></use>
        </svg>
        Select Subtree
    </button>
</div>
code_example]]
</div>

**<div class="mgt-5 mgb-3">Checkboxes single example:</div>**
[[code_example {html}
<div class="form-check form-check-inline">
    <input type="checkbox" id="example_checkbox-single" name="example_checkbox-single" class="form-check-input">
    <label class="form-check-label checkbox-inline" for="example_checkbox-single">Container</label>
</div>
code_example]]

**<div class="mgt-5 mgb-3">Checkboxes group example:</div>**
[[code_example {html}
<div class="form-check form-check-inline">
    <input type="checkbox" id="example_checkbox-one" name="example_checkbox-one" class="form-check-input">
    <label class="form-check-label checkbox-inline" for="example_checkbox-one">Option 1</label>
</div>
<div class="form-check form-check-inline">
    <input type="checkbox" id="example_checkbox-two" name="example_checkbox-two" class="form-check-input">
    <label class="form-check-label checkbox-inline" for="example_checkbox-two">Option 2</label>
</div>
code_example]]