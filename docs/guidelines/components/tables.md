# Tables

We use tables as main element for displaying content information.

##<div class="mgt-3 header-line">Basic tables</div>
**<div class="mgt-minus-2 mgb-3">Basic table</div>**
<div class="ez-guidelines-tables__with-header mgb-5">
[[code_example {html}
<div class="ez-table-header">
    <div class="ez-table-header__headline">System URL</div>
</div>
<table class="table">
    <thead>
        <tr>
            <th>URL</th>
            <th>Language</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>/places-tastes</td>
            <td>English (United Kingdom)</td>
        </tr>
    </tbody>
</table>
code_example]]
</div>

**<div class="mgb-3">Basic table with no content</div>**
<div class="ez-guidelines-tables__with-header mgb-5">
[[code_example {html}
<div class="ez-table-header">
    <div class="ez-table-header__headline">Reverse relations (content items using News)</div>
</div>
<p class="ez-table-no-content">This content item has no reverse relations</p>
code_example]]
</div>

**<div class="mgb-3">Basic table and actions buttons in Header</div>**
<div class="ez-guidelines-tables__with-header mgb-5">
[[code_example {html}
<div class="ez-table-header">
    <div class="ez-table-header__headline">Translation manager</div>
    <div>
        <button type="button" class="btn btn-primary">
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

**<div class="mgb-3">Basic table and action buttons in header and within rows</div>**
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
                <button type="button" class="btn btn-icon mx-2 ez-btn--content-edit" title="Restore Archived Version">
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

##<div class="mgt-3 header-line">Secondary table</div>
<div class="ez-guidelines-tables__with-header mgb-5">
[[code_example {html}
<div class="ez-table-header ground-base">
    <div class="ez-table-header__headline">Location Content Swap</div>
</div>
<table class="table ez-table--no-border">
    <tbody>
        <tr>
            <td>Swap the content item at this location with another
                <button type="button" class="btn btn-outline-secondary ml-5">Select content item</button>
            </td>
        </tr>
    </tbody>
</table>
code_example]]
</div>

##<div class="mgt-3 header-line">Notifications table</div>
<div class="ez-guidelines-tables__notifications mgb-5">
[[code_example {html}
<table class="table n-table--notifications">
    <thead>
        <tr>
            <th>Type</th>
            <th>Description</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody class="n-table__body">
        <tr class="n-notifications-modal__item fw-notification">
            <td class="n-notifications-modal__type">
                <span class="type__icon">
                    <svg class="ez-icon ez-icon--review">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="../../ez-icons.svg#review"></use>
                    </svg>
                </span>
                <span class="type__text">
                    Content review request
                </span>
            </td>
            <td class="n-notifications-modal__description">
                <p class="description__title">
                    From:
                    <span class="description__title__item">Administrator user</span>
                </p>
                <p class="description__text">Can you check this? Thxs!</p>
                <span class="description__read-more">Read more &raquo;</span>
            </td>
            <td class="n-notifications-modal__time">
                September 13, 2018 14:58
            </td>
        </tr>
    </tbody>
</table>
code_example]]
</div>

!!! Note
    This table is displayed within `.n-notifications-modal` modal. Styling relies on this class.


##<div class="mgt-3 header-line">List table</div>
<div class="ez-guidelines-tables__list mgb-5">
[[code_example {html}
<table class="table ez-table ez-table--list">
    <thead>
        <tr>
            <th colspan="2">
                Composer
            </th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Minimum stability</td>
            <td>stable</td>
        </tr>
    </tbody>
</table>
code_example]]
