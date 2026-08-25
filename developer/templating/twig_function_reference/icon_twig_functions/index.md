# Icon Twig functions

Icon Twig functions enable referencing SVG icons in templates.

## `ibexa_icon_path()`

`ibexa_icon_path()` generates a path to the selected icon from an [icon set](../../../administration/back_office/back_office_elements/custom_icons/index.md#icon-sets).

| Argument | Type     | Description                                                                    |
| -------- | -------- | ------------------------------------------------------------------------------ |
| `icon`   | `string` | Identifier of an icon in the icon set.                                         |
| `set`    | `string` | Identifier of the configured icon set. If empty, the default icon set is used. |

```html+twig
<svg class="ibexa-icon ibexa-icon--medium ibexa-icon--light">
    <use xlink:href="{{ ibexa_icon_path('edit', 'my_icons') }}"></use>
</svg>
```

The icons can be displayed in different colors and sizes.

### Icon color variants

By default, the icon inherits the [`fill`](https://developer.mozilla.org/docs/Web/CSS/Reference/Properties/fill) attribute from the parent element. You can change it by using one of the available CSS modifiers:

| Modifier      | Usage                                  |
| ------------- | -------------------------------------- |
| `--light`     | To be used on dark backgrounds         |
| `--dark`      | To be used on light backgrounds        |
| `--base-dark` | To be used on light backgrounds        |
| `--primary`   | To use the primary back office color   |
| `--secondary` | To use the secondary back office color |

```html+twig
<svg class="ibexa-icon ibexa-icon--dark">
    <use xlink:href="{{ ibexa_icon_path('edit') }}"></use>
</svg>
```

### Icon size variants

The default icon size in the back office is `32px`. To change the default size, in the template add the modifier to the class name.

```html+twig
<svg class="ibexa-icon ibexa-icon--medium">
  <use xlink:href="{{ ibexa_icon_path('add') }}"></use>
</svg>
```

The list of available icon sizes:

| Modifier         | Size   |
| ---------------- | ------ |
| `--tiny`         | `8px`  |
| `--tiny-small`   | `12px` |
| `--small`        | `16px` |
| `--small-medium` | `20px` |
| `--medium`       | `24px` |
| `--medium-large` | `38px` |
| `--large`        | `48px` |
| `--extra-large`  | `64px` |

### Icons reference

The following icons are available out-of-the-box:

| Icon                         | Identifier                     |
| ---------------------------- | ------------------------------ |
| accessibility                | `accessibility`                |
| action-compare               | `action-compare`               |
| action-compare-versions      | `action-compare-versions`      |
| action-redo                  | `action-redo`                  |
| action-undo                  | `action-undo`                  |
| activate                     | `activate`                     |
| activity-clock               | `activity-clock`               |
| add                          | `add`                          |
| add-circle                   | `add-circle`                   |
| ai                           | `ai`                           |
| alert-error                  | `alert-error`                  |
| alert-warning                | `alert-warning`                |
| align-block-center           | `align-block-center`           |
| align-block-left             | `align-block-left`             |
| align-block-right            | `align-block-right`            |
| align-text-center            | `align-text-center`            |
| align-text-justified         | `align-text-justified`         |
| align-text-left              | `align-text-left`              |
| align-text-right             | `align-text-right`             |
| app                          | `app`                          |
| app-blog                     | `app-blog`                     |
| app-drawer                   | `app-drawer`                   |
| app-edit                     | `app-edit`                     |
| app-money                    | `app-money`                    |
| app-preview                  | `app-preview`                  |
| app-recent                   | `app-recent`                   |
| app-settings                 | `app-settings`                 |
| app-user                     | `app-user`                     |
| app-www                      | `app-www`                      |
| archived-restore             | `archived-restore`             |
| archived-version             | `archived-version`             |
| arrow-caret-down             | `arrow-caret-down`             |
| arrow-caret-left             | `arrow-caret-left`             |
| arrow-caret-right            | `arrow-caret-right`            |
| arrow-caret-up               | `arrow-caret-up`               |
| arrow-chevron-down           | `arrow-chevron-down`           |
| arrow-chevron-left           | `arrow-chevron-left`           |
| arrow-chevron-right          | `arrow-chevron-right`          |
| arrow-chevron-up             | `arrow-chevron-up`             |
| arrow-collapse-expand        | `arrow-collapse-expand`        |
| arrow-collapse-left          | `arrow-collapse-left`          |
| arrow-collapse-right         | `arrow-collapse-right`         |
| arrow-decrease               | `arrow-decrease`               |
| arrow-double-left            | `arrow-double-left`            |
| arrow-double-right           | `arrow-double-right`           |
| arrow-down                   | `arrow-down`                   |
| arrow-down-text              | `arrow-down-text`              |
| arrow-expand-left            | `arrow-expand-left`            |
| arrow-expand-right           | `arrow-expand-right`           |
| arrow-increase               | `arrow-increase`               |
| arrow-left                   | `arrow-left`                   |
| arrow-move-left              | `arrow-move-left`              |
| arrow-move-right             | `arrow-move-right`             |
| arrow-reload-dot             | `arrow-reload-dot`             |
| arrow-restore                | `arrow-restore`                |
| arrow-right                  | `arrow-right`                  |
| arrow-rotate                 | `arrow-rotate`                 |
| arrow-to-down                | `arrow-to-down`                |
| arrow-to-down-circle         | `arrow-to-down-circle`         |
| arrow-to-left                | `arrow-to-left`                |
| arrow-to-right               | `arrow-to-right`               |
| arrow-to-up                  | `arrow-to-up`                  |
| arrow-up                     | `arrow-up`                     |
| arrow-up-text                | `arrow-up-text`                |
| arrow-upgrade                | `arrow-upgrade`                |
| arrows-chevron-up-and-down   | `arrows-chevron-up-and-down`   |
| arrows-circle                | `arrows-circle`                |
| arrows-full-view             | `arrows-full-view`             |
| arrows-full-view-out         | `arrows-full-view-out`         |
| arrows-inside                | `arrows-inside`                |
| arrows-outside               | `arrows-outside`               |
| arrows-recycle               | `arrows-recycle`               |
| arrows-reload                | `arrows-reload`                |
| arrows-reload-user           | `arrows-reload-user`           |
| arrows-right-and-left        | `arrows-right-and-left`        |
| arrows-round                 | `arrows-round`                 |
| arrows-switch                | `arrows-switch`                |
| arrows-synchronize           | `arrows-synchronize`           |
| arrows-up-and-down           | `arrows-up-and-down`           |
| assign                       | `assign`                       |
| assign-tag                   | `assign-tag`                   |
| assign-user                  | `assign-user`                  |
| automation                   | `automation`                   |
| badge-certificate-horizontal | `badge-certificate-horizontal` |
| badge-certificate-vertical   | `badge-certificate-vertical`   |
| badge-star                   | `badge-star`                   |
| banner                       | `banner`                       |
| bell                         | `bell`                         |
| block-add                    | `block-add`                    |
| block-hidden                 | `block-hidden`                 |
| block-lock                   | `block-lock`                   |
| block-visible                | `block-visible`                |
| book                         | `book`                         |
| book-open                    | `book-open`                    |
| bookmark-filled              | `bookmark-filled`              |
| bookmark-outline             | `bookmark-outline`             |
| bookmarks                    | `bookmarks`                    |
| box-component                | `box-component`                |
| bulb-idea                    | `bulb-idea`                    |
| business-card                | `business-card`                |
| calculator                   | `calculator`                   |
| calendar                     | `calendar`                     |
| calendar-add                 | `calendar-add`                 |
| calendar-back                | `calendar-back`                |
| calendar-block               | `calendar-block`               |
| calendar-check               | `calendar-check`               |
| calendar-clock               | `calendar-clock`               |
| calendar-discard             | `calendar-discard`             |
| calendar-hidden              | `calendar-hidden`              |
| calendar-number              | `calendar-number`              |
| calendar-reload              | `calendar-reload`              |
| calendar-schedule            | `calendar-schedule`            |
| calendar-visible             | `calendar-visible`             |
| camera                       | `camera`                       |
| car                          | `car`                          |
| car-truck                    | `car-truck`                    |
| catalog                      | `catalog`                      |
| chart-area                   | `chart-area`                   |
| chart-area-line              | `chart-area-line`              |
| chart-bar                    | `chart-bar`                    |
| chart-donut                  | `chart-donut`                  |
| chart-donut-element          | `chart-donut-element`          |
| chart-dots                   | `chart-dots`                   |
| chart-dots-other             | `chart-dots-other`             |
| chart-gauges                 | `chart-gauges`                 |
| chart-histogram              | `chart-histogram`              |
| chart-line                   | `chart-line`                   |
| chart-line-graph             | `chart-line-graph`             |
| check-circle                 | `check-circle`                 |
| chevron-down-circle          | `chevron-down-circle`          |
| chevron-left-circle          | `chevron-left-circle`          |
| chevron-right-circle         | `chevron-right-circle`         |
| chevron-up-circle            | `chevron-up-circle`            |
| clipboard-check              | `clipboard-check`              |
| clipboard-list               | `clipboard-list`               |
| clock                        | `clock`                        |
| clock-play                   | `clock-play`                   |
| cloud                        | `cloud`                        |
| cloud-carbon                 | `cloud-carbon`                 |
| cloud-check                  | `cloud-check`                  |
| cloud-discard                | `cloud-discard`                |
| cloud-download               | `cloud-download`               |
| cloud-error                  | `cloud-error`                  |
| cloud-synch                  | `cloud-synch`                  |
| collaboration                | `collaboration`                |
| collection                   | `collection`                   |
| collection-products          | `collection-products`          |
| column-one                   | `column-one`                   |
| column-two                   | `column-two`                   |
| company                      | `company`                      |
| connection                   | `connection`                   |
| connection-erp               | `connection-erp`               |
| content-tree                 | `content-tree`                 |
| content-tree-arrow-up        | `content-tree-arrow-up`        |
| content-tree-copy            | `content-tree-copy`            |
| content-tree-create-location | `content-tree-create-location` |
| content-tree-restore-parent  | `content-tree-restore-parent`  |
| content-tree-site-structure  | `content-tree-site-structure`  |
| copy                         | `copy`                         |
| copyright                    | `copyright`                    |
| core                         | `core`                         |
| credit-card                  | `credit-card`                  |
| credit-card-hourglass        | `credit-card-hourglass`        |
| credit-card-payment          | `credit-card-payment`          |
| crop                         | `crop`                         |
| cursor                       | `cursor`                       |
| cursor-clicked               | `cursor-clicked`               |
| cursor-clicked-hand          | `cursor-clicked-hand`          |
| cursor-hand                  | `cursor-hand`                  |
| cursor-hand-click            | `cursor-hand-click`            |
| cursor-hand-grab             | `cursor-hand-grab`             |
| cursor-hand-pointer          | `cursor-hand-pointer`          |
| cursor-hand-swipe            | `cursor-hand-swipe`            |
| dashboard                    | `dashboard`                    |
| dashboard-type               | `dashboard-type`               |
| database                     | `database`                     |
| database-settings            | `database-settings`            |
| database-share               | `database-share`               |
| database-synch               | `database-synch`               |
| deactivate                   | `deactivate`                   |
| device-desktop-all-in-one    | `device-desktop-all-in-one`    |
| device-laptop                | `device-laptop`                |
| device-mobile                | `device-mobile`                |
| device-monitor               | `device-monitor`               |
| device-monitor-card          | `device-monitor-card`          |
| device-monitor-check         | `device-monitor-check`         |
| device-monitor-package       | `device-monitor-package`       |
| device-monitor-settings      | `device-monitor-settings`      |
| device-monitor-type          | `device-monitor-type`          |
| device-monitor-user          | `device-monitor-user`          |
| device-tablet                | `device-tablet`                |
| discard                      | `discard`                      |
| discard-circle               | `discard-circle`               |
| discount                     | `discount`                     |
| discount-ticket              | `discount-ticket`              |
| download                     | `download`                     |
| draft                        | `draft`                        |
| drag                         | `drag`                         |
| drag-and-drop                | `drag-and-drop`                |
| duplicate                    | `duplicate`                    |
| edit                         | `edit`                         |
| edit-draft                   | `edit-draft`                   |
| edit-draft-clock             | `edit-draft-clock`             |
| exclamation-mark             | `exclamation-mark`             |
| facebook                     | `facebook`                     |
| factbox                      | `factbox`                      |
| favourite-filled             | `favourite-filled`             |
| favourite-outline            | `favourite-outline`            |
| feather                      | `feather`                      |
| file                         | `file`                         |
| file-add                     | `file-add`                     |
| file-arrow-up                | `file-arrow-up`                |
| file-badge-certificate       | `file-badge-certificate`       |
| file-code                    | `file-code`                    |
| file-copyright               | `file-copyright`               |
| file-css                     | `file-css`                     |
| file-edit                    | `file-edit`                    |
| file-history                 | `file-history`                 |
| file-info                    | `file-info`                    |
| file-js                      | `file-js`                      |
| file-link                    | `file-link`                    |
| file-pdf                     | `file-pdf`                     |
| file-php                     | `file-php`                     |
| file-settings                | `file-settings`                |
| file-statistics              | `file-statistics`              |
| file-text                    | `file-text`                    |
| file-text-edit               | `file-text-edit`               |
| file-text-money              | `file-text-money`              |
| file-text-other              | `file-text-other`              |
| file-text-question-mark      | `file-text-question-mark`      |
| file-text-search             | `file-text-search`             |
| file-text-write              | `file-text-write`              |
| file-type                    | `file-type`                    |
| file-warning                 | `file-warning`                 |
| filters                      | `filters`                      |
| filters-funnel               | `filters-funnel`               |
| flag                         | `flag`                         |
| flip-horizontal              | `flip-horizontal`              |
| flip-vertical                | `flip-vertical`                |
| focus-centered               | `focus-centered`               |
| focus-target                 | `focus-target`                 |
| folder                       | `folder`                       |
| folder-browse                | `folder-browse`                |
| folder-open                  | `folder-open`                  |
| folder-open-move             | `folder-open-move`             |
| folders                      | `folders`                      |
| forbidden                    | `forbidden`                    |
| form-captcha                 | `form-captcha`                 |
| form-check                   | `form-check`                   |
| form-check-list              | `form-check-list`              |
| form-check-square            | `form-check-square`            |
| form-checkbox                | `form-checkbox`                |
| form-data                    | `form-data`                    |
| form-dropdown                | `form-dropdown`                |
| form-input                   | `form-input`                   |
| form-input-check             | `form-input-check`             |
| form-input-hidden            | `form-input-hidden`            |
| form-input-multi-line        | `form-input-multi-line`        |
| form-input-number            | `form-input-number`            |
| form-input-rename            | `form-input-rename`            |
| form-input-single-line       | `form-input-single-line`       |
| form-input-visible           | `form-input-visible`           |
| form-radio                   | `form-radio`                   |
| form-radio-list              | `form-radio-list`              |
| handshake                    | `handshake`                    |
| hash                         | `hash`                         |
| header-1                     | `header-1`                     |
| header-2                     | `header-2`                     |
| header-3                     | `header-3`                     |
| header-4                     | `header-4`                     |
| header-5                     | `header-5`                     |
| header-6                     | `header-6`                     |
| headphones-support           | `headphones-support`           |
| heart                        | `heart`                        |
| help                         | `help`                         |
| hierarchy-circle             | `hierarchy-circle`             |
| hierarchy-circle-more        | `hierarchy-circle-more`        |
| hierarchy-items              | `hierarchy-items`              |
| hierarchy-schema             | `hierarchy-schema`             |
| hierarchy-site-map           | `hierarchy-site-map`           |
| hierarchy-square             | `hierarchy-square`             |
| hierarchy-square-more        | `hierarchy-square-more`        |
| hierarchy-topology           | `hierarchy-topology`           |
| history                      | `history`                      |
| home                         | `home`                         |
| home-settings                | `home-settings`                |
| image                        | `image`                        |
| image-edit                   | `image-edit`                   |
| image-focus                  | `image-focus`                  |
| image-gallery                | `image-gallery`                |
| image-insert                 | `image-insert`                 |
| image-upload                 | `image-upload`                 |
| info-circle                  | `info-circle`                  |
| info-rounded                 | `info-rounded`                 |
| info-square                  | `info-square`                  |
| layout                       | `layout`                       |
| layout-navbar                | `layout-navbar`                |
| layout-navbar-add            | `layout-navbar-add`            |
| layout-navbar-preview        | `layout-navbar-preview`        |
| layout-navbar-visible        | `layout-navbar-visible`        |
| layout-switch                | `layout-switch`                |
| lift                         | `lift`                         |
| lightning                    | `lightning`                    |
| like                         | `like`                         |
| like-shine                   | `like-shine`                   |
| line-vertical                | `line-vertical`                |
| link                         | `link`                         |
| link-anchor                  | `link-anchor`                  |
| list-bullet                  | `list-bullet`                  |
| list-content                 | `list-content`                 |
| list-number                  | `list-number`                  |
| list-tasks                   | `list-tasks`                   |
| lock                         | `lock`                         |
| lock-focus                   | `lock-focus`                   |
| lock-rounded                 | `lock-rounded`                 |
| log-in                       | `log-in`                       |
| log-out                      | `log-out`                      |
| magnet                       | `magnet`                       |
| measure-ruler-bent           | `measure-ruler-bent`           |
| measure-ruler-straight       | `measure-ruler-straight`       |
| media-type                   | `media-type`                   |
| menu-hamburger               | `menu-hamburger`               |
| menu-hamburger-aligned       | `menu-hamburger-aligned`       |
| merge                        | `merge`                        |
| message                      | `message`                      |
| message-blog-post            | `message-blog-post`            |
| message-bubble               | `message-bubble`               |
| message-bubble-dots          | `message-bubble-dots`          |
| message-bubble-edit          | `message-bubble-edit`          |
| message-bubble-info          | `message-bubble-info`          |
| message-bubble-quote         | `message-bubble-quote`         |
| message-edit                 | `message-edit`                 |
| message-email                | `message-email`                |
| message-email-read           | `message-email-read`           |
| message-empty                | `message-empty`                |
| message-exchange             | `message-exchange`             |
| message-text                 | `message-text`                 |
| microphone                   | `microphone`                   |
| minus                        | `minus`                        |
| minus-circle                 | `minus-circle`                 |
| money-bag                    | `money-bag`                    |
| money-bills                  | `money-bills`                  |
| money-coin                   | `money-coin`                   |
| money-coins                  | `money-coins`                  |
| mood-happy-face              | `mood-happy-face`              |
| mood-sad-face                | `mood-sad-face`                |
| more                         | `more`                         |
| mountain                     | `mountain`                     |
| news                         | `news`                         |
| note                         | `note`                         |
| note-blog                    | `note-blog`                    |
| note-check                   | `note-check`                   |
| note-text                    | `note-text`                    |
| notebook                     | `notebook`                     |
| notebook-text                | `notebook-text`                |
| notes-list                   | `notes-list`                   |
| official-building            | `official-building`            |
| open-new-window              | `open-new-window`              |
| open-same-window             | `open-same-window`             |
| overdue                      | `overdue`                      |
| path-route                   | `path-route`                   |
| path-two-directions          | `path-two-directions`          |
| pause                        | `pause`                        |
| pen-write                    | `pen-write`                    |
| phone                        | `phone`                        |
| pin                          | `pin`                          |
| pin-location                 | `pin-location`                 |
| pin-location-money           | `pin-location-money`           |
| pin-location-question-mark   | `pin-location-question-mark`   |
| pins-locations               | `pins-locations`               |
| plane                        | `plane`                        |
| price                        | `price`                        |
| product                      | `product`                      |
| product-arrow-down           | `product-arrow-down`           |
| product-catalog              | `product-catalog`              |
| product-catalog-number       | `product-catalog-number`       |
| product-check                | `product-check`                |
| product-clock                | `product-clock`                |
| product-collection           | `product-collection`           |
| product-discard              | `product-discard`              |
| product-search               | `product-search`               |
| product-settings             | `product-settings`             |
| product-tag                  | `product-tag`                  |
| product-variant              | `product-variant`              |
| prompt                       | `prompt`                       |
| qa-admin                     | `qa-admin`                     |
| qa-catalog                   | `qa-catalog`                   |
| qa-click                     | `qa-click`                     |
| qa-clipboard                 | `qa-clipboard`                 |
| qa-cloud                     | `qa-cloud`                     |
| qa-company                   | `qa-company`                   |
| qa-editor                    | `qa-editor`                    |
| qa-file                      | `qa-file`                      |
| qa-form-check                | `qa-form-check`                |
| qa-info                      | `qa-info`                      |
| qa-product                   | `qa-product`                   |
| qa-store                     | `qa-store`                     |
| quote                        | `quote`                        |
| receipt                      | `receipt`                      |
| receipt-check                | `receipt-check`                |
| receipt-clock                | `receipt-clock`                |
| receipt-number               | `receipt-number`               |
| receipt-settings             | `receipt-settings`             |
| reveal                       | `reveal`                       |
| robot                        | `robot`                        |
| rocket                       | `rocket`                       |
| sales-revenue                | `sales-revenue`                |
| save                         | `save`                         |
| save-exit                    | `save-exit`                    |
| search                       | `search`                       |
| seen-this                    | `seen-this`                    |
| segments                     | `segments`                     |
| send                         | `send`                         |
| send-review                  | `send-review`                  |
| server                       | `server`                       |
| settings                     | `settings`                     |
| settings-cog                 | `settings-cog`                 |
| settings-configure           | `settings-configure`           |
| share                        | `share`                        |
| shield                       | `shield`                       |
| shipment                     | `shipment`                     |
| shipment-arrow               | `shipment-arrow`               |
| shipment-free                | `shipment-free`                |
| shop                         | `shop`                         |
| shopping-basket              | `shopping-basket`              |
| shopping-cart                | `shopping-cart`                |
| shopping-cart-add            | `shopping-cart-add`            |
| shopping-cart-arrow-up       | `shopping-cart-arrow-up`       |
| shopping-cart-heart          | `shopping-cart-heart`          |
| shopping-cart-settings       | `shopping-cart-settings`       |
| shopping-cart-star           | `shopping-cart-star`           |
| signal-radio                 | `signal-radio`                 |
| signal-rss                   | `signal-rss`                   |
| signal-wifi                  | `signal-wifi`                  |
| site                         | `site`                         |
| sites                        | `sites`                        |
| slider                       | `slider`                       |
| speaker                      | `speaker`                      |
| square                       | `square`                       |
| square-selection             | `square-selection`             |
| stack-overflow               | `stack-overflow`               |
| star-badge                   | `star-badge`                   |
| star-circle                  | `star-circle`                  |
| stars                        | `stars`                        |
| suitcase                     | `suitcase`                     |
| table-add                    | `table-add`                    |
| table-cell                   | `table-cell`                   |
| table-column                 | `table-column`                 |
| table-row                    | `table-row`                    |
| table-settings-column        | `table-settings-column`        |
| tag                          | `tag`                          |
| tag-settings                 | `tag-settings`                 |
| tags                         | `tags`                         |
| target                       | `target`                       |
| target-click                 | `target-click`                 |
| target-dynamic               | `target-dynamic`               |
| target-location              | `target-location`              |
| target-other                 | `target-other`                 |
| telephone                    | `telephone`                    |
| text-bold                    | `text-bold`                    |
| text-code                    | `text-code`                    |
| text-embedded                | `text-embedded`                |
| text-embedded-inline         | `text-embedded-inline`         |
| text-italic                  | `text-italic`                  |
| text-paragraph               | `text-paragraph`               |
| text-paragraph-add           | `text-paragraph-add`           |
| text-slash                   | `text-slash`                   |
| text-strikethrough           | `text-strikethrough`           |
| text-subscript               | `text-subscript`               |
| text-superscript             | `text-superscript`             |
| text-underline               | `text-underline`               |
| timeline                     | `timeline`                     |
| tool                         | `tool`                         |
| tool-group                   | `tool-group`                   |
| tools                        | `tools`                        |
| translation-language         | `translation-language`         |
| trash                        | `trash`                        |
| trash-discard                | `trash-discard`                |
| trash-open                   | `trash-open`                   |
| trash-send                   | `trash-send`                   |
| twitter                      | `twitter`                      |
| umbrella                     | `umbrella`                     |
| unarchive                    | `unarchive`                    |
| unassign-tag                 | `unassign-tag`                 |
| unlink                       | `unlink`                       |
| unlock                       | `unlock`                       |
| unpin                        | `unpin`                        |
| upload                       | `upload`                       |
| user                         | `user`                         |
| user-add                     | `user-add`                     |
| user-admin                   | `user-admin`                   |
| user-block                   | `user-block`                   |
| user-cart                    | `user-cart`                    |
| user-check                   | `user-check`                   |
| user-customer                | `user-customer`                |
| user-customer-number         | `user-customer-number`         |
| user-edit                    | `user-edit`                    |
| user-editor                  | `user-editor`                  |
| user-focus                   | `user-focus`                   |
| user-group                   | `user-group`                   |
| user-group-customer          | `user-group-customer`          |
| user-id                      | `user-id`                      |
| user-mail                    | `user-mail`                    |
| user-money                   | `user-money`                   |
| user-profile                 | `user-profile`                 |
| user-target                  | `user-target`                  |
| user-type                    | `user-type`                    |
| users-add                    | `users-add`                    |
| variation-1-1                | `variation-1-1`                |
| variation-16-9               | `variation-16-9`               |
| variation-3-2                | `variation-3-2`                |
| variation-4-3                | `variation-4-3`                |
| variation-custom             | `variation-custom`             |
| video                        | `video`                        |
| video-play                   | `video-play`                   |
| view-custom                  | `view-custom`                  |
| view-grid                    | `view-grid`                    |
| view-list                    | `view-list`                    |
| view-panels                  | `view-panels`                  |
| vinyl                        | `vinyl`                        |
| visibility                   | `visibility`                   |
| visibility-hidden            | `visibility-hidden`            |
| wand                         | `wand`                         |
| workflow                     | `workflow`                     |
| world                        | `world`                        |
| world-add                    | `world-add`                    |
| world-cursor                 | `world-cursor`                 |
| world-settings               | `world-settings`               |
| x                            | `x`                            |
| zoom-in                      | `zoom-in`                      |
| zoom-out                     | `zoom-out`                     |

## `ibexa_content_type_icon()`

`ibexa_content_type_icon()` generates a path to a content type icon.

| Argument       | Type     | Description              |
| -------------- | -------- | ------------------------ |
| `content_type` | `string` | Content type identifier. |

See [Customize content type icons](../../../administration/back_office/back_office_elements/custom_icons/index.md#customize-content-type-icons) to associate icons to content types.
