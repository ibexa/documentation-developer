---
description: Icon Twig functions enable referencing SVG icons in templates.
page_type: reference
month_change: false
---

# Icon Twig functions

### `ibexa_icon_path()`

`ibexa_icon_path()` generates a path to the selected icon from an icon set.

|Argument|Type|Description|
|------|------|------|
|`icon`|`string`|Identifier of an icon in the icon set.|
|`set`|`string`|Identifier of the configured icon set. If empty, the default icon set is used.|

```html+twig
<svg class="ibexa-icon ibexa-icon--medium ibexa-icon--light">
    <use xlink:href="{{ ibexa_icon_path('edit', 'my_icons') }}"></use>
</svg>
```

The icons can be displayed in different colors and sizes.

#### Icon color variants

By default, the icon inherits the [`fill`](https://developer.mozilla.org/en-US/docs/Web/CSS/fill) attribute from the parent element.
You can change it by using one of the available CSS modifiers:

|Modifier|Usage|
|---|---|
| `--light` | To be used on dark backgrounds |
| `--dark` | To be used on light backgrounds |
| `--base-dark` | To be used on light backgrounds |
| `--primary` | To use the primary back office color |
| `--secondary` | To use the secondary back office color |

```html+twig
<svg class="ibexa-icon ibexa-icon--dark">
    <use xlink:href="{{ ibexa_icon_path('edit') }}"></use>
</svg>
```

#### Icon size variants

The default icon size in the back office is `32px`.
To change the default size, in the template add the modifier to the class name.

``` html+twig
<svg class="ibexa-icon ibexa-icon--medium">
  <use xlink:href="{{ ibexa_icon_path('add') }}"></use>
</svg>
```

The list of available icon sizes:

|Modifier|Size|
|----|---------|
|`--tiny`|`8px`|
|`--tiny-small`|`12px`|
|`--small`|`16px`|
|`--small-medium`|`20px`|
|`--medium`|`24px`|
|`--medium-large`|`38px`|
|`--large`|`48px`|
|`--extra-large`|`64px`|

#### Icons reference

The following icons are available out-of-the-box:

| Icon                                                                            | Identifier                     |
|---------------------------------------------------------------------------------|--------------------------------|
| ![accessibility](img/icons/accessibility.svg.png) | `accessibility` |
| ![action-compare](img/icons/action-compare.svg.png) | `action-compare` |
| ![action-compare-versions](img/icons/action-compare-versions.svg.png) | `action-compare-versions` |
| ![action-redo](img/icons/action-redo.svg.png) | `action-redo` |
| ![action-undo](img/icons/action-undo.svg.png) | `action-undo` |
| ![activate](img/icons/activate.svg.png) | `activate` |
| ![activity-clock](img/icons/activity-clock.svg.png) | `activity-clock` |
| ![add](img/icons/add.svg.png) | `add` |
| ![add-circle](img/icons/add-circle.svg.png) | `add-circle` |
| ![ai](img/icons/ai.svg.png) | `ai` |
| ![alert-error](img/icons/alert-error.svg.png) | `alert-error` |
| ![alert-warning](img/icons/alert-warning.svg.png) | `alert-warning` |
| ![align-block-center](img/icons/align-block-center.svg.png) | `align-block-center` |
| ![align-block-left](img/icons/align-block-left.svg.png) | `align-block-left` |
| ![align-block-right](img/icons/align-block-right.svg.png) | `align-block-right` |
| ![align-text-center](img/icons/align-text-center.svg.png) | `align-text-center` |
| ![align-text-justified](img/icons/align-text-justified.svg.png) | `align-text-justified` |
| ![align-text-left](img/icons/align-text-left.svg.png) | `align-text-left` |
| ![align-text-right](img/icons/align-text-right.svg.png) | `align-text-right` |
| ![app](img/icons/app.svg.png) | `app` |
| ![app-blog](img/icons/app-blog.svg.png) | `app-blog` |
| ![app-drawer](img/icons/app-drawer.svg.png) | `app-drawer` |
| ![app-edit](img/icons/app-edit.svg.png) | `app-edit` |
| ![app-money](img/icons/app-money.svg.png) | `app-money` |
| ![app-preview](img/icons/app-preview.svg.png) | `app-preview` |
| ![app-recent](img/icons/app-recent.svg.png) | `app-recent` |
| ![app-settings](img/icons/app-settings.svg.png) | `app-settings` |
| ![app-user](img/icons/app-user.svg.png) | `app-user` |
| ![app-www](img/icons/app-www.svg.png) | `app-www` |
| ![archived-restore](img/icons/archived-restore.svg.png) | `archived-restore` |
| ![archived-version](img/icons/archived-version.svg.png) | `archived-version` |
| ![arrow-caret-down](img/icons/arrow-caret-down.svg.png) | `arrow-caret-down` |
| ![arrow-caret-left](img/icons/arrow-caret-left.svg.png) | `arrow-caret-left` |
| ![arrow-caret-right](img/icons/arrow-caret-right.svg.png) | `arrow-caret-right` |
| ![arrow-caret-up](img/icons/arrow-caret-up.svg.png) | `arrow-caret-up` |
| ![arrow-chevron-down](img/icons/arrow-chevron-down.svg.png) | `arrow-chevron-down` |
| ![arrow-chevron-left](img/icons/arrow-chevron-left.svg.png) | `arrow-chevron-left` |
| ![arrow-chevron-right](img/icons/arrow-chevron-right.svg.png) | `arrow-chevron-right` |
| ![arrow-chevron-up](img/icons/arrow-chevron-up.svg.png) | `arrow-chevron-up` |
| ![arrow-collapse-expand](img/icons/arrow-collapse-expand.svg.png) | `arrow-collapse-expand` |
| ![arrow-collapse-left](img/icons/arrow-collapse-left.svg.png) | `arrow-collapse-left` |
| ![arrow-collapse-right](img/icons/arrow-collapse-right.svg.png) | `arrow-collapse-right` |
| ![arrow-decrease](img/icons/arrow-decrease.svg.png) | `arrow-decrease` |
| ![arrow-double-left](img/icons/arrow-double-left.svg.png) | `arrow-double-left` |
| ![arrow-double-right](img/icons/arrow-double-right.svg.png) | `arrow-double-right` |
| ![arrow-down](img/icons/arrow-down.svg.png) | `arrow-down` |
| ![arrow-down-text](img/icons/arrow-down-text.svg.png) | `arrow-down-text` |
| ![arrow-expand-left](img/icons/arrow-expand-left.svg.png) | `arrow-expand-left` |
| ![arrow-expand-right](img/icons/arrow-expand-right.svg.png) | `arrow-expand-right` |
| ![arrow-increase](img/icons/arrow-increase.svg.png) | `arrow-increase` |
| ![arrow-left](img/icons/arrow-left.svg.png) | `arrow-left` |
| ![arrow-move-left](img/icons/arrow-move-left.svg.png) | `arrow-move-left` |
| ![arrow-move-right](img/icons/arrow-move-right.svg.png) | `arrow-move-right` |
| ![arrow-reload-dot](img/icons/arrow-reload-dot.svg.png) | `arrow-reload-dot` |
| ![arrow-restore](img/icons/arrow-restore.svg.png) | `arrow-restore` |
| ![arrow-right](img/icons/arrow-right.svg.png) | `arrow-right` |
| ![arrow-rotate](img/icons/arrow-rotate.svg.png) | `arrow-rotate` |
| ![arrow-to-down](img/icons/arrow-to-down.svg.png) | `arrow-to-down` |
| ![arrow-to-down-circle](img/icons/arrow-to-down-circle.svg.png) | `arrow-to-down-circle` |
| ![arrow-to-left](img/icons/arrow-to-left.svg.png) | `arrow-to-left` |
| ![arrow-to-right](img/icons/arrow-to-right.svg.png) | `arrow-to-right` |
| ![arrow-to-up](img/icons/arrow-to-up.svg.png) | `arrow-to-up` |
| ![arrow-up](img/icons/arrow-up.svg.png) | `arrow-up` |
| ![arrow-up-text](img/icons/arrow-up-text.svg.png) | `arrow-up-text` |
| ![arrow-upgrade](img/icons/arrow-upgrade.svg.png) | `arrow-upgrade` |
| ![arrows-chevron-up-and-down](img/icons/arrows-chevron-up-and-down.svg.png) | `arrows-chevron-up-and-down` |
| ![arrows-circle](img/icons/arrows-circle.svg.png) | `arrows-circle` |
| ![arrows-full-view](img/icons/arrows-full-view.svg.png) | `arrows-full-view` |
| ![arrows-full-view-out](img/icons/arrows-full-view-out.svg.png) | `arrows-full-view-out` |
| ![arrows-inside](img/icons/arrows-inside.svg.png) | `arrows-inside` |
| ![arrows-outside](img/icons/arrows-outside.svg.png) | `arrows-outside` |
| ![arrows-recycle](img/icons/arrows-recycle.svg.png) | `arrows-recycle` |
| ![arrows-reload](img/icons/arrows-reload.svg.png) | `arrows-reload` |
| ![arrows-reload-user](img/icons/arrows-reload-user.svg.png) | `arrows-reload-user` |
| ![arrows-right-and-left](img/icons/arrows-right-and-left.svg.png) | `arrows-right-and-left` |
| ![arrows-round](img/icons/arrows-round.svg.png) | `arrows-round` |
| ![arrows-switch](img/icons/arrows-switch.svg.png) | `arrows-switch` |
| ![arrows-synchronize](img/icons/arrows-synchronize.svg.png) | `arrows-synchronize` |
| ![arrows-up-and-down](img/icons/arrows-up-and-down.svg.png) | `arrows-up-and-down` |
| ![assign](img/icons/assign.svg.png) | `assign` |
| ![assign-tag](img/icons/assign-tag.svg.png) | `assign-tag` |
| ![assign-user](img/icons/assign-user.svg.png) | `assign-user` |
| ![automation](img/icons/automation.svg.png) | `automation` |
| ![badge-certificate-horizontal](img/icons/badge-certificate-horizontal.svg.png) | `badge-certificate-horizontal` |
| ![badge-certificate-vertical](img/icons/badge-certificate-vertical.svg.png) | `badge-certificate-vertical` |
| ![badge-star](img/icons/badge-star.svg.png) | `badge-star` |
| ![banner](img/icons/banner.svg.png) | `banner` |
| ![bell](img/icons/bell.svg.png) | `bell` |
| ![block-add](img/icons/block-add.svg.png) | `block-add` |
| ![block-hidden](img/icons/block-hidden.svg.png) | `block-hidden` |
| ![block-lock](img/icons/block-lock.svg.png) | `block-lock` |
| ![block-visible](img/icons/block-visible.svg.png) | `block-visible` |
| ![book](img/icons/book.svg.png) | `book` |
| ![book-open](img/icons/book-open.svg.png) | `book-open` |
| ![bookmark-filled](img/icons/bookmark-filled.svg.png) | `bookmark-filled` |
| ![bookmark-outline](img/icons/bookmark-outline.svg.png) | `bookmark-outline` |
| ![bookmarks](img/icons/bookmarks.svg.png) | `bookmarks` |
| ![box-component](img/icons/box-component.svg.png) | `box-component` |
| ![bulb-idea](img/icons/bulb-idea.svg.png) | `bulb-idea` |
| ![business-card](img/icons/business-card.svg.png) | `business-card` |
| ![calculator](img/icons/calculator.svg.png) | `calculator` |
| ![calendar](img/icons/calendar.svg.png) | `calendar` |
| ![calendar-add](img/icons/calendar-add.svg.png) | `calendar-add` |
| ![calendar-back](img/icons/calendar-back.svg.png) | `calendar-back` |
| ![calendar-block](img/icons/calendar-block.svg.png) | `calendar-block` |
| ![calendar-check](img/icons/calendar-check.svg.png) | `calendar-check` |
| ![calendar-clock](img/icons/calendar-clock.svg.png) | `calendar-clock` |
| ![calendar-discard](img/icons/calendar-discard.svg.png) | `calendar-discard` |
| ![calendar-hidden](img/icons/calendar-hidden.svg.png) | `calendar-hidden` |
| ![calendar-number](img/icons/calendar-number.svg.png) | `calendar-number` |
| ![calendar-reload](img/icons/calendar-reload.svg.png) | `calendar-reload` |
| ![calendar-schedule](img/icons/calendar-schedule.svg.png) | `calendar-schedule` |
| ![calendar-visible](img/icons/calendar-visible.svg.png) | `calendar-visible` |
| ![camera](img/icons/camera.svg.png) | `camera` |
| ![car](img/icons/car.svg.png) | `car` |
| ![car-truck](img/icons/car-truck.svg.png) | `car-truck` |
| ![catalog](img/icons/catalog.svg.png) | `catalog` |
| ![chart-area](img/icons/chart-area.svg.png) | `chart-area` |
| ![chart-area-line](img/icons/chart-area-line.svg.png) | `chart-area-line` |
| ![chart-bar](img/icons/chart-bar.svg.png) | `chart-bar` |
| ![chart-donut](img/icons/chart-donut.svg.png) | `chart-donut` |
| ![chart-donut-element](img/icons/chart-donut-element.svg.png) | `chart-donut-element` |
| ![chart-dots](img/icons/chart-dots.svg.png) | `chart-dots` |
| ![chart-dots-other](img/icons/chart-dots-other.svg.png) | `chart-dots-other` |
| ![chart-gauges](img/icons/chart-gauges.svg.png) | `chart-gauges` |
| ![chart-histogram](img/icons/chart-histogram.svg.png) | `chart-histogram` |
| ![chart-line](img/icons/chart-line.svg.png) | `chart-line` |
| ![chart-line-graph](img/icons/chart-line-graph.svg.png) | `chart-line-graph` |
| ![check-circle](img/icons/check-circle.svg.png) | `check-circle` |
| ![chevron-down-circle](img/icons/chevron-down-circle.svg.png) | `chevron-down-circle` |
| ![chevron-left-circle](img/icons/chevron-left-circle.svg.png) | `chevron-left-circle` |
| ![chevron-right-circle](img/icons/chevron-right-circle.svg.png) | `chevron-right-circle` |
| ![chevron-up-circle](img/icons/chevron-up-circle.svg.png) | `chevron-up-circle` |
| ![clipboard-check](img/icons/clipboard-check.svg.png) | `clipboard-check` |
| ![clipboard-list](img/icons/clipboard-list.svg.png) | `clipboard-list` |
| ![clock](img/icons/clock.svg.png) | `clock` |
| ![clock-play](img/icons/clock-play.svg.png) | `clock-play` |
| ![cloud](img/icons/cloud.svg.png) | `cloud` |
| ![cloud-carbon](img/icons/cloud-carbon.svg.png) | `cloud-carbon` |
| ![cloud-check](img/icons/cloud-check.svg.png) | `cloud-check` |
| ![cloud-discard](img/icons/cloud-discard.svg.png) | `cloud-discard` |
| ![cloud-download](img/icons/cloud-download.svg.png) | `cloud-download` |
| ![cloud-error](img/icons/cloud-error.svg.png) | `cloud-error` |
| ![cloud-synch](img/icons/cloud-synch.svg.png) | `cloud-synch` |
| ![collaboration](img/icons/collaboration.svg.png) | `collaboration` |
| ![collection](img/icons/collection.svg.png) | `collection` |
| ![collection-products](img/icons/collection-products.svg.png) | `collection-products` |
| ![column-one](img/icons/column-one.svg.png) | `column-one` |
| ![column-two](img/icons/column-two.svg.png) | `column-two` |
| ![company](img/icons/company.svg.png) | `company` |
| ![connection](img/icons/connection.svg.png) | `connection` |
| ![connection-erp](img/icons/connection-erp.svg.png) | `connection-erp` |
| ![content-tree](img/icons/content-tree.svg.png) | `content-tree` |
| ![content-tree-arrow-up](img/icons/content-tree-arrow-up.svg.png) | `content-tree-arrow-up` |
| ![content-tree-copy](img/icons/content-tree-copy.svg.png) | `content-tree-copy` |
| ![content-tree-create-location](img/icons/content-tree-create-location.svg.png) | `content-tree-create-location` |
| ![content-tree-restore-parent](img/icons/content-tree-restore-parent.svg.png) | `content-tree-restore-parent` |
| ![content-tree-site-structure](img/icons/content-tree-site-structure.svg.png) | `content-tree-site-structure` |
| ![copy](img/icons/copy.svg.png) | `copy` |
| ![copyright](img/icons/copyright.svg.png) | `copyright` |
| ![core](img/icons/core.svg.png) | `core` |
| ![credit-card](img/icons/credit-card.svg.png) | `credit-card` |
| ![credit-card-hourglass](img/icons/credit-card-hourglass.svg.png) | `credit-card-hourglass` |
| ![credit-card-payment](img/icons/credit-card-payment.svg.png) | `credit-card-payment` |
| ![crop](img/icons/crop.svg.png) | `crop` |
| ![cursor](img/icons/cursor.svg.png) | `cursor` |
| ![cursor-clicked](img/icons/cursor-clicked.svg.png) | `cursor-clicked` |
| ![cursor-clicked-hand](img/icons/cursor-clicked-hand.svg.png) | `cursor-clicked-hand` |
| ![cursor-hand](img/icons/cursor-hand.svg.png) | `cursor-hand` |
| ![cursor-hand-click](img/icons/cursor-hand-click.svg.png) | `cursor-hand-click` |
| ![cursor-hand-grab](img/icons/cursor-hand-grab.svg.png) | `cursor-hand-grab` |
| ![cursor-hand-pointer](img/icons/cursor-hand-pointer.svg.png) | `cursor-hand-pointer` |
| ![cursor-hand-swipe](img/icons/cursor-hand-swipe.svg.png) | `cursor-hand-swipe` |
| ![dashboard](img/icons/dashboard.svg.png) | `dashboard` |
| ![dashboard-type](img/icons/dashboard-type.svg.png) | `dashboard-type` |
| ![database](img/icons/database.svg.png) | `database` |
| ![database-settings](img/icons/database-settings.svg.png) | `database-settings` |
| ![database-share](img/icons/database-share.svg.png) | `database-share` |
| ![database-synch](img/icons/database-synch.svg.png) | `database-synch` |
| ![deactivate](img/icons/deactivate.svg.png) | `deactivate` |
| ![device-desktop-all-in-one](img/icons/device-desktop-all-in-one.svg.png) | `device-desktop-all-in-one` |
| ![device-laptop](img/icons/device-laptop.svg.png) | `device-laptop` |
| ![device-mobile](img/icons/device-mobile.svg.png) | `device-mobile` |
| ![device-monitor](img/icons/device-monitor.svg.png) | `device-monitor` |
| ![device-monitor-card](img/icons/device-monitor-card.svg.png) | `device-monitor-card` |
| ![device-monitor-check](img/icons/device-monitor-check.svg.png) | `device-monitor-check` |
| ![device-monitor-package](img/icons/device-monitor-package.svg.png) | `device-monitor-package` |
| ![device-monitor-settings](img/icons/device-monitor-settings.svg.png) | `device-monitor-settings` |
| ![device-monitor-type](img/icons/device-monitor-type.svg.png) | `device-monitor-type` |
| ![device-monitor-user](img/icons/device-monitor-user.svg.png) | `device-monitor-user` |
| ![device-tablet](img/icons/device-tablet.svg.png) | `device-tablet` |
| ![discard](img/icons/discard.svg.png) | `discard` |
| ![discard-circle](img/icons/discard-circle.svg.png) | `discard-circle` |
| ![discount](img/icons/discount.svg.png) | `discount` |
| ![discount-ticket](img/icons/discount-ticket.svg.png) | `discount-ticket` |
| ![download](img/icons/download.svg.png) | `download` |
| ![draft](img/icons/draft.svg.png) | `draft` |
| ![drag](img/icons/drag.svg.png) | `drag` |
| ![drag-and-drop](img/icons/drag-and-drop.svg.png) | `drag-and-drop` |
| ![duplicate](img/icons/duplicate.svg.png) | `duplicate` |
| ![edit](img/icons/edit.svg.png) | `edit` |
| ![edit-draft](img/icons/edit-draft.svg.png) | `edit-draft` |
| ![edit-draft-clock](img/icons/edit-draft-clock.svg.png) | `edit-draft-clock` |
| ![exclamation-mark](img/icons/exclamation-mark.svg.png) | `exclamation-mark` |
| ![facebook](img/icons/facebook.svg.png) | `facebook` |
| ![factbox](img/icons/factbox.svg.png) | `factbox` |
| ![favourite-filled](img/icons/favourite-filled.svg.png) | `favourite-filled` |
| ![favourite-outline](img/icons/favourite-outline.svg.png) | `favourite-outline` |
| ![feather](img/icons/feather.svg.png) | `feather` |
| ![file](img/icons/file.svg.png) | `file` |
| ![file-add](img/icons/file-add.svg.png) | `file-add` |
| ![file-arrow-up](img/icons/file-arrow-up.svg.png) | `file-arrow-up` |
| ![file-badge-certificate](img/icons/file-badge-certificate.svg.png) | `file-badge-certificate` |
| ![file-code](img/icons/file-code.svg.png) | `file-code` |
| ![file-copyright](img/icons/file-copyright.svg.png) | `file-copyright` |
| ![file-css](img/icons/file-css.svg.png) | `file-css` |
| ![file-edit](img/icons/file-edit.svg.png) | `file-edit` |
| ![file-history](img/icons/file-history.svg.png) | `file-history` |
| ![file-info](img/icons/file-info.svg.png) | `file-info` |
| ![file-js](img/icons/file-js.svg.png) | `file-js` |
| ![file-link](img/icons/file-link.svg.png) | `file-link` |
| ![file-pdf](img/icons/file-pdf.svg.png) | `file-pdf` |
| ![file-php](img/icons/file-php.svg.png) | `file-php` |
| ![file-settings](img/icons/file-settings.svg.png) | `file-settings` |
| ![file-statistics](img/icons/file-statistics.svg.png) | `file-statistics` |
| ![file-text](img/icons/file-text.svg.png) | `file-text` |
| ![file-text-edit](img/icons/file-text-edit.svg.png) | `file-text-edit` |
| ![file-text-money](img/icons/file-text-money.svg.png) | `file-text-money` |
| ![file-text-other](img/icons/file-text-other.svg.png) | `file-text-other` |
| ![file-text-question-mark](img/icons/file-text-question-mark.svg.png) | `file-text-question-mark` |
| ![file-text-search](img/icons/file-text-search.svg.png) | `file-text-search` |
| ![file-text-write](img/icons/file-text-write.svg.png) | `file-text-write` |
| ![file-type](img/icons/file-type.svg.png) | `file-type` |
| ![file-warning](img/icons/file-warning.svg.png) | `file-warning` |
| ![filters](img/icons/filters.svg.png) | `filters` |
| ![filters-funnel](img/icons/filters-funnel.svg.png) | `filters-funnel` |
| ![flag](img/icons/flag.svg.png) | `flag` |
| ![flip-horizontal](img/icons/flip-horizontal.svg.png) | `flip-horizontal` |
| ![flip-vertical](img/icons/flip-vertical.svg.png) | `flip-vertical` |
| ![focus-centered](img/icons/focus-centered.svg.png) | `focus-centered` |
| ![focus-target](img/icons/focus-target.svg.png) | `focus-target` |
| ![folder](img/icons/folder.svg.png) | `folder` |
| ![folder-browse](img/icons/folder-browse.svg.png) | `folder-browse` |
| ![folder-open](img/icons/folder-open.svg.png) | `folder-open` |
| ![folder-open-move](img/icons/folder-open-move.svg.png) | `folder-open-move` |
| ![folders](img/icons/folders.svg.png) | `folders` |
| ![forbidden](img/icons/forbidden.svg.png) | `forbidden` |
| ![form-captcha](img/icons/form-captcha.svg.png) | `form-captcha` |
| ![form-check](img/icons/form-check.svg.png) | `form-check` |
| ![form-check-list](img/icons/form-check-list.svg.png) | `form-check-list` |
| ![form-check-square](img/icons/form-check-square.svg.png) | `form-check-square` |
| ![form-checkbox](img/icons/form-checkbox.svg.png) | `form-checkbox` |
| ![form-data](img/icons/form-data.svg.png) | `form-data` |
| ![form-dropdown](img/icons/form-dropdown.svg.png) | `form-dropdown` |
| ![form-input](img/icons/form-input.svg.png) | `form-input` |
| ![form-input-check](img/icons/form-input-check.svg.png) | `form-input-check` |
| ![form-input-hidden](img/icons/form-input-hidden.svg.png) | `form-input-hidden` |
| ![form-input-multi-line](img/icons/form-input-multi-line.svg.png) | `form-input-multi-line` |
| ![form-input-number](img/icons/form-input-number.svg.png) | `form-input-number` |
| ![form-input-rename](img/icons/form-input-rename.svg.png) | `form-input-rename` |
| ![form-input-single-line](img/icons/form-input-single-line.svg.png) | `form-input-single-line` |
| ![form-input-visible](img/icons/form-input-visible.svg.png) | `form-input-visible` |
| ![form-radio](img/icons/form-radio.svg.png) | `form-radio` |
| ![form-radio-list](img/icons/form-radio-list.svg.png) | `form-radio-list` |
| ![handshake](img/icons/handshake.svg.png) | `handshake` |
| ![hash](img/icons/hash.svg.png) | `hash` |
| ![header-1](img/icons/header-1.svg.png) | `header-1` |
| ![header-2](img/icons/header-2.svg.png) | `header-2` |
| ![header-3](img/icons/header-3.svg.png) | `header-3` |
| ![header-4](img/icons/header-4.svg.png) | `header-4` |
| ![header-5](img/icons/header-5.svg.png) | `header-5` |
| ![header-6](img/icons/header-6.svg.png) | `header-6` |
| ![headphones-support](img/icons/headphones-support.svg.png) | `headphones-support` |
| ![heart](img/icons/heart.svg.png) | `heart` |
| ![help](img/icons/help.svg.png) | `help` |
| ![hierarchy-circle](img/icons/hierarchy-circle.svg.png) | `hierarchy-circle` |
| ![hierarchy-circle-more](img/icons/hierarchy-circle-more.svg.png) | `hierarchy-circle-more` |
| ![hierarchy-items](img/icons/hierarchy-items.svg.png) | `hierarchy-items` |
| ![hierarchy-schema](img/icons/hierarchy-schema.svg.png) | `hierarchy-schema` |
| ![hierarchy-site-map](img/icons/hierarchy-site-map.svg.png) | `hierarchy-site-map` |
| ![hierarchy-square](img/icons/hierarchy-square.svg.png) | `hierarchy-square` |
| ![hierarchy-square-more](img/icons/hierarchy-square-more.svg.png) | `hierarchy-square-more` |
| ![hierarchy-topology](img/icons/hierarchy-topology.svg.png) | `hierarchy-topology` |
| ![history](img/icons/history.svg.png) | `history` |
| ![home](img/icons/home.svg.png) | `home` |
| ![home-settings](img/icons/home-settings.svg.png) | `home-settings` |
| ![image](img/icons/image.svg.png) | `image` |
| ![image-edit](img/icons/image-edit.svg.png) | `image-edit` |
| ![image-focus](img/icons/image-focus.svg.png) | `image-focus` |
| ![image-gallery](img/icons/image-gallery.svg.png) | `image-gallery` |
| ![image-insert](img/icons/image-insert.svg.png) | `image-insert` |
| ![image-upload](img/icons/image-upload.svg.png) | `image-upload` |
| ![info-circle](img/icons/info-circle.svg.png) | `info-circle` |
| ![info-rounded](img/icons/info-rounded.svg.png) | `info-rounded` |
| ![info-square](img/icons/info-square.svg.png) | `info-square` |
| ![layout](img/icons/layout.svg.png) | `layout` |
| ![layout-navbar](img/icons/layout-navbar.svg.png) | `layout-navbar` |
| ![layout-navbar-add](img/icons/layout-navbar-add.svg.png) | `layout-navbar-add` |
| ![layout-navbar-preview](img/icons/layout-navbar-preview.svg.png) | `layout-navbar-preview` |
| ![layout-navbar-visible](img/icons/layout-navbar-visible.svg.png) | `layout-navbar-visible` |
| ![layout-switch](img/icons/layout-switch.svg.png) | `layout-switch` |
| ![lift](img/icons/lift.svg.png) | `lift` |
| ![lightning](img/icons/lightning.svg.png) | `lightning` |
| ![like](img/icons/like.svg.png) | `like` |
| ![like-shine](img/icons/like-shine.svg.png) | `like-shine` |
| ![line-vertical](img/icons/line-vertical.svg.png) | `line-vertical` |
| ![link](img/icons/link.svg.png) | `link` |
| ![link-anchor](img/icons/link-anchor.svg.png) | `link-anchor` |
| ![list-bullet](img/icons/list-bullet.svg.png) | `list-bullet` |
| ![list-content](img/icons/list-content.svg.png) | `list-content` |
| ![list-number](img/icons/list-number.svg.png) | `list-number` |
| ![list-tasks](img/icons/list-tasks.svg.png) | `list-tasks` |
| ![lock](img/icons/lock.svg.png) | `lock` |
| ![lock-focus](img/icons/lock-focus.svg.png) | `lock-focus` |
| ![lock-rounded](img/icons/lock-rounded.svg.png) | `lock-rounded` |
| ![log-in](img/icons/log-in.svg.png) | `log-in` |
| ![log-out](img/icons/log-out.svg.png) | `log-out` |
| ![magnet](img/icons/magnet.svg.png) | `magnet` |
| ![measure-ruler-bent](img/icons/measure-ruler-bent.svg.png) | `measure-ruler-bent` |
| ![measure-ruler-straight](img/icons/measure-ruler-straight.svg.png) | `measure-ruler-straight` |
| ![media-type](img/icons/media-type.svg.png) | `media-type` |
| ![menu-hamburger](img/icons/menu-hamburger.svg.png) | `menu-hamburger` |
| ![menu-hamburger-aligned](img/icons/menu-hamburger-aligned.svg.png) | `menu-hamburger-aligned` |
| ![merge](img/icons/merge.svg.png) | `merge` |
| ![message](img/icons/message.svg.png) | `message` |
| ![message-blog-post](img/icons/message-blog-post.svg.png) | `message-blog-post` |
| ![message-bubble](img/icons/message-bubble.svg.png) | `message-bubble` |
| ![message-bubble-dots](img/icons/message-bubble-dots.svg.png) | `message-bubble-dots` |
| ![message-bubble-edit](img/icons/message-bubble-edit.svg.png) | `message-bubble-edit` |
| ![message-bubble-info](img/icons/message-bubble-info.svg.png) | `message-bubble-info` |
| ![message-bubble-quote](img/icons/message-bubble-quote.svg.png) | `message-bubble-quote` |
| ![message-edit](img/icons/message-edit.svg.png) | `message-edit` |
| ![message-email](img/icons/message-email.svg.png) | `message-email` |
| ![message-email-read](img/icons/message-email-read.svg.png) | `message-email-read` |
| ![message-empty](img/icons/message-empty.svg.png) | `message-empty` |
| ![message-exchange](img/icons/message-exchange.svg.png) | `message-exchange` |
| ![message-text](img/icons/message-text.svg.png) | `message-text` |
| ![microphone](img/icons/microphone.svg.png) | `microphone` |
| ![minus](img/icons/minus.svg.png) | `minus` |
| ![minus-circle](img/icons/minus-circle.svg.png) | `minus-circle` |
| ![money-bag](img/icons/money-bag.svg.png) | `money-bag` |
| ![money-bills](img/icons/money-bills.svg.png) | `money-bills` |
| ![money-coin](img/icons/money-coin.svg.png) | `money-coin` |
| ![money-coins](img/icons/money-coins.svg.png) | `money-coins` |
| ![mood-happy-face](img/icons/mood-happy-face.svg.png) | `mood-happy-face` |
| ![mood-sad-face](img/icons/mood-sad-face.svg.png) | `mood-sad-face` |
| ![more](img/icons/more.svg.png) | `more` |
| ![mountain](img/icons/mountain.svg.png) | `mountain` |
| ![news](img/icons/news.svg.png) | `news` |
| ![note](img/icons/note.svg.png) | `note` |
| ![note-blog](img/icons/note-blog.svg.png) | `note-blog` |
| ![note-check](img/icons/note-check.svg.png) | `note-check` |
| ![note-text](img/icons/note-text.svg.png) | `note-text` |
| ![notebook](img/icons/notebook.svg.png) | `notebook` |
| ![notebook-text](img/icons/notebook-text.svg.png) | `notebook-text` |
| ![notes-list](img/icons/notes-list.svg.png) | `notes-list` |
| ![official-building](img/icons/official-building.svg.png) | `official-building` |
| ![open-new-window](img/icons/open-new-window.svg.png) | `open-new-window` |
| ![open-same-window](img/icons/open-same-window.svg.png) | `open-same-window` |
| ![overdue](img/icons/overdue.svg.png) | `overdue` |
| ![path-route](img/icons/path-route.svg.png) | `path-route` |
| ![path-two-directions](img/icons/path-two-directions.svg.png) | `path-two-directions` |
| ![pause](img/icons/pause.svg.png) | `pause` |
| ![pen-write](img/icons/pen-write.svg.png) | `pen-write` |
| ![phone](img/icons/phone.svg.png) | `phone` |
| ![pin](img/icons/pin.svg.png) | `pin` |
| ![pin-location](img/icons/pin-location.svg.png) | `pin-location` |
| ![pin-location-money](img/icons/pin-location-money.svg.png) | `pin-location-money` |
| ![pin-location-question-mark](img/icons/pin-location-question-mark.svg.png) | `pin-location-question-mark` |
| ![pins-locations](img/icons/pins-locations.svg.png) | `pins-locations` |
| ![plane](img/icons/plane.svg.png) | `plane` |
| ![price](img/icons/price.svg.png) | `price` |
| ![product](img/icons/product.svg.png) | `product` |
| ![product-arrow-down](img/icons/product-arrow-down.svg.png) | `product-arrow-down` |
| ![product-catalog](img/icons/product-catalog.svg.png) | `product-catalog` |
| ![product-catalog-number](img/icons/product-catalog-number.svg.png) | `product-catalog-number` |
| ![product-check](img/icons/product-check.svg.png) | `product-check` |
| ![product-clock](img/icons/product-clock.svg.png) | `product-clock` |
| ![product-collection](img/icons/product-collection.svg.png) | `product-collection` |
| ![product-discard](img/icons/product-discard.svg.png) | `product-discard` |
| ![product-search](img/icons/product-search.svg.png) | `product-search` |
| ![product-settings](img/icons/product-settings.svg.png) | `product-settings` |
| ![product-tag](img/icons/product-tag.svg.png) | `product-tag` |
| ![product-variant](img/icons/product-variant.svg.png) | `product-variant` |
| ![prompt](img/icons/prompt.svg.png) | `prompt` |
| ![qa-admin](img/icons/qa-admin.svg.png) | `qa-admin` |
| ![qa-catalog](img/icons/qa-catalog.svg.png) | `qa-catalog` |
| ![qa-click](img/icons/qa-click.svg.png) | `qa-click` |
| ![qa-clipboard](img/icons/qa-clipboard.svg.png) | `qa-clipboard` |
| ![qa-cloud](img/icons/qa-cloud.svg.png) | `qa-cloud` |
| ![qa-company](img/icons/qa-company.svg.png) | `qa-company` |
| ![qa-editor](img/icons/qa-editor.svg.png) | `qa-editor` |
| ![qa-file](img/icons/qa-file.svg.png) | `qa-file` |
| ![qa-form-check](img/icons/qa-form-check.svg.png) | `qa-form-check` |
| ![qa-info](img/icons/qa-info.svg.png) | `qa-info` |
| ![qa-product](img/icons/qa-product.svg.png) | `qa-product` |
| ![qa-store](img/icons/qa-store.svg.png) | `qa-store` |
| ![quote](img/icons/quote.svg.png) | `quote` |
| ![receipt](img/icons/receipt.svg.png) | `receipt` |
| ![receipt-check](img/icons/receipt-check.svg.png) | `receipt-check` |
| ![receipt-clock](img/icons/receipt-clock.svg.png) | `receipt-clock` |
| ![receipt-number](img/icons/receipt-number.svg.png) | `receipt-number` |
| ![receipt-settings](img/icons/receipt-settings.svg.png) | `receipt-settings` |
| ![reveal](img/icons/reveal.svg.png) | `reveal` |
| ![robot](img/icons/robot.svg.png) | `robot` |
| ![rocket](img/icons/rocket.svg.png) | `rocket` |
| ![sales-revenue](img/icons/sales-revenue.svg.png) | `sales-revenue` |
| ![save](img/icons/save.svg.png) | `save` |
| ![save-exit](img/icons/save-exit.svg.png) | `save-exit` |
| ![search](img/icons/search.svg.png) | `search` |
| ![seen-this](img/icons/seen-this.svg.png) | `seen-this` |
| ![segments](img/icons/segments.svg.png) | `segments` |
| ![send](img/icons/send.svg.png) | `send` |
| ![send-review](img/icons/send-review.svg.png) | `send-review` |
| ![server](img/icons/server.svg.png) | `server` |
| ![settings](img/icons/settings.svg.png) | `settings` |
| ![settings-cog](img/icons/settings-cog.svg.png) | `settings-cog` |
| ![settings-configure](img/icons/settings-configure.svg.png) | `settings-configure` |
| ![share](img/icons/share.svg.png) | `share` |
| ![shield](img/icons/shield.svg.png) | `shield` |
| ![shipment](img/icons/shipment.svg.png) | `shipment` |
| ![shipment-arrow](img/icons/shipment-arrow.svg.png) | `shipment-arrow` |
| ![shipment-free](img/icons/shipment-free.svg.png) | `shipment-free` |
| ![shop](img/icons/shop.svg.png) | `shop` |
| ![shopping-basket](img/icons/shopping-basket.svg.png) | `shopping-basket` |
| ![shopping-cart](img/icons/shopping-cart.svg.png) | `shopping-cart` |
| ![shopping-cart-add](img/icons/shopping-cart-add.svg.png) | `shopping-cart-add` |
| ![shopping-cart-arrow-up](img/icons/shopping-cart-arrow-up.svg.png) | `shopping-cart-arrow-up` |
| ![shopping-cart-heart](img/icons/shopping-cart-heart.svg.png) | `shopping-cart-heart` |
| ![shopping-cart-settings](img/icons/shopping-cart-settings.svg.png) | `shopping-cart-settings` |
| ![shopping-cart-star](img/icons/shopping-cart-star.svg.png) | `shopping-cart-star` |
| ![signal-radio](img/icons/signal-radio.svg.png) | `signal-radio` |
| ![signal-rss](img/icons/signal-rss.svg.png) | `signal-rss` |
| ![signal-wifi](img/icons/signal-wifi.svg.png) | `signal-wifi` |
| ![site](img/icons/site.svg.png) | `site` |
| ![sites](img/icons/sites.svg.png) | `sites` |
| ![slider](img/icons/slider.svg.png) | `slider` |
| ![speaker](img/icons/speaker.svg.png) | `speaker` |
| ![square](img/icons/square.svg.png) | `square` |
| ![square-selection](img/icons/square-selection.svg.png) | `square-selection` |
| ![stack-overflow](img/icons/stack-overflow.svg.png) | `stack-overflow` |
| ![star-badge](img/icons/star-badge.svg.png) | `star-badge` |
| ![star-circle](img/icons/star-circle.svg.png) | `star-circle` |
| ![stars](img/icons/stars.svg.png) | `stars` |
| ![suitcase](img/icons/suitcase.svg.png) | `suitcase` |
| ![table-add](img/icons/table-add.svg.png) | `table-add` |
| ![table-cell](img/icons/table-cell.svg.png) | `table-cell` |
| ![table-column](img/icons/table-column.svg.png) | `table-column` |
| ![table-row](img/icons/table-row.svg.png) | `table-row` |
| ![table-settings-column](img/icons/table-settings-column.svg.png) | `table-settings-column` |
| ![tag](img/icons/tag.svg.png) | `tag` |
| ![tag-settings](img/icons/tag-settings.svg.png) | `tag-settings` |
| ![tags](img/icons/tags.svg.png) | `tags` |
| ![target](img/icons/target.svg.png) | `target` |
| ![target-click](img/icons/target-click.svg.png) | `target-click` |
| ![target-dynamic](img/icons/target-dynamic.svg.png) | `target-dynamic` |
| ![target-location](img/icons/target-location.svg.png) | `target-location` |
| ![target-other](img/icons/target-other.svg.png) | `target-other` |
| ![telephone](img/icons/telephone.svg.png) | `telephone` |
| ![text-bold](img/icons/text-bold.svg.png) | `text-bold` |
| ![text-code](img/icons/text-code.svg.png) | `text-code` |
| ![text-embedded](img/icons/text-embedded.svg.png) | `text-embedded` |
| ![text-embedded-inline](img/icons/text-embedded-inline.svg.png) | `text-embedded-inline` |
| ![text-italic](img/icons/text-italic.svg.png) | `text-italic` |
| ![text-paragraph](img/icons/text-paragraph.svg.png) | `text-paragraph` |
| ![text-paragraph-add](img/icons/text-paragraph-add.svg.png) | `text-paragraph-add` |
| ![text-slash](img/icons/text-slash.svg.png) | `text-slash` |
| ![text-strikethrough](img/icons/text-strikethrough.svg.png) | `text-strikethrough` |
| ![text-subscript](img/icons/text-subscript.svg.png) | `text-subscript` |
| ![text-superscript](img/icons/text-superscript.svg.png) | `text-superscript` |
| ![text-underline](img/icons/text-underline.svg.png) | `text-underline` |
| ![timeline](img/icons/timeline.svg.png) | `timeline` |
| ![tool](img/icons/tool.svg.png) | `tool` |
| ![tool-group](img/icons/tool-group.svg.png) | `tool-group` |
| ![tools](img/icons/tools.svg.png) | `tools` |
| ![translation-language](img/icons/translation-language.svg.png) | `translation-language` |
| ![trash](img/icons/trash.svg.png) | `trash` |
| ![trash-discard](img/icons/trash-discard.svg.png) | `trash-discard` |
| ![trash-open](img/icons/trash-open.svg.png) | `trash-open` |
| ![trash-send](img/icons/trash-send.svg.png) | `trash-send` |
| ![twitter](img/icons/twitter.svg.png) | `twitter` |
| ![umbrella](img/icons/umbrella.svg.png) | `umbrella` |
| ![unarchive](img/icons/unarchive.svg.png) | `unarchive` |
| ![unassign-tag](img/icons/unassign-tag.svg.png) | `unassign-tag` |
| ![unlink](img/icons/unlink.svg.png) | `unlink` |
| ![unlock](img/icons/unlock.svg.png) | `unlock` |
| ![unpin](img/icons/unpin.svg.png) | `unpin` |
| ![upload](img/icons/upload.svg.png) | `upload` |
| ![user](img/icons/user.svg.png) | `user` |
| ![user-add](img/icons/user-add.svg.png) | `user-add` |
| ![user-admin](img/icons/user-admin.svg.png) | `user-admin` |
| ![user-block](img/icons/user-block.svg.png) | `user-block` |
| ![user-cart](img/icons/user-cart.svg.png) | `user-cart` |
| ![user-check](img/icons/user-check.svg.png) | `user-check` |
| ![user-customer](img/icons/user-customer.svg.png) | `user-customer` |
| ![user-customer-number](img/icons/user-customer-number.svg.png) | `user-customer-number` |
| ![user-edit](img/icons/user-edit.svg.png) | `user-edit` |
| ![user-editor](img/icons/user-editor.svg.png) | `user-editor` |
| ![user-focus](img/icons/user-focus.svg.png) | `user-focus` |
| ![user-group](img/icons/user-group.svg.png) | `user-group` |
| ![user-group-customer](img/icons/user-group-customer.svg.png) | `user-group-customer` |
| ![user-id](img/icons/user-id.svg.png) | `user-id` |
| ![user-mail](img/icons/user-mail.svg.png) | `user-mail` |
| ![user-money](img/icons/user-money.svg.png) | `user-money` |
| ![user-profile](img/icons/user-profile.svg.png) | `user-profile` |
| ![user-target](img/icons/user-target.svg.png) | `user-target` |
| ![user-type](img/icons/user-type.svg.png) | `user-type` |
| ![users-add](img/icons/users-add.svg.png) | `users-add` |
| ![variation-1-1](img/icons/variation-1-1.svg.png) | `variation-1-1` |
| ![variation-16-9](img/icons/variation-16-9.svg.png) | `variation-16-9` |
| ![variation-3-2](img/icons/variation-3-2.svg.png) | `variation-3-2` |
| ![variation-4-3](img/icons/variation-4-3.svg.png) | `variation-4-3` |
| ![variation-custom](img/icons/variation-custom.svg.png) | `variation-custom` |
| ![video](img/icons/video.svg.png) | `video` |
| ![video-play](img/icons/video-play.svg.png) | `video-play` |
| ![view-custom](img/icons/view-custom.svg.png) | `view-custom` |
| ![view-grid](img/icons/view-grid.svg.png) | `view-grid` |
| ![view-list](img/icons/view-list.svg.png) | `view-list` |
| ![view-panels](img/icons/view-panels.svg.png) | `view-panels` |
| ![vinyl](img/icons/vinyl.svg.png) | `vinyl` |
| ![visibility](img/icons/visibility.svg.png) | `visibility` |
| ![visibility-hidden](img/icons/visibility-hidden.svg.png) | `visibility-hidden` |
| ![wand](img/icons/wand.svg.png) | `wand` |
| ![workflow](img/icons/workflow.svg.png) | `workflow` |
| ![world](img/icons/world.svg.png) | `world` |
| ![world-add](img/icons/world-add.svg.png) | `world-add` |
| ![world-cursor](img/icons/world-cursor.svg.png) | `world-cursor` |
| ![world-settings](img/icons/world-settings.svg.png) | `world-settings` |
| ![x](img/icons/x.svg.png) | `x` |
| ![zoom-in](img/icons/zoom-in.svg.png) | `zoom-in` |
| ![zoom-out](img/icons/zoom-out.svg.png) | `zoom-out` |

