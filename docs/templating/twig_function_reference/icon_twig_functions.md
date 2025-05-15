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
  <use xlink:href="{{ ibexa_icon_path('create') }}"></use>
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
| ![about-info](img/icons/about-info.svg.png)                                     | `about-info`                   |
| ![about](img/icons/about.svg.png)                                               | `about`                        |
| ![airtime](img/icons/airtime.svg.png)                                           | `airtime`                      |
| ![align-center](img/icons/align-center.svg.png)                                 | `align-center`                 |
| ![align-justify](img/icons/align-justify.svg.png)                               | `align-justify`                |
| ![align-left](img/icons/align-left.svg.png)                                     | `align-left`                   |
| ![align-right](img/icons/align-right.svg.png)                                   | `align-right`                  |
| ![approved](img/icons/approved.svg.png)                                         | `approved`                     |
| ![arrow-right](img/icons/arrow-right.svg.png)                                   | `arrow-right`                  |
| ![article](img/icons/article.svg.png)                                           | `article`                      |
| ![assign-section](img/icons/assign-section.svg.png)                             | `assign-section`               |
| ![assign-user](img/icons/assign-user.svg.png)                                   | `assign-user`                  |
| ![author](img/icons/author.svg.png)                                             | `author`                       |
| ![autosave-error](img/icons/autosave-error.svg.png)                             | `autosave-error`               |
| ![autosave-off](img/icons/autosave-off.svg.png)                                 | `autosave-off`                 |
| ![autosave-on](img/icons/autosave-on.svg.png)                                   | `autosave-on`                  |
| ![autosave-saved](img/icons/autosave-saved.svg.png)                             | `autosave-saved`               |
| ![autosave-saving](img/icons/autosave-saving.svg.png)                           | `autosave-saving`              |
| ![b2b](img/icons/b2b.svg.png)                                                   | `b2b`                          |
| ![back-current-date](img/icons/back-current-date.svg.png)                       | `back-current-date`            |
| ![back](img/icons/back.svg.png)                                                 | `back`                         |
| ![banner](img/icons/banner.svg.png)                                             | `banner`                       |
| ![bell](img/icons/bell.svg.png)                                                 | `bell`                         |
| ![bestseller](img/icons/bestseller.svg.png)                                     | `bestseller`                   |
| ![block-add](img/icons/block-add.svg.png)                                       | `block-add`                    |
| ![block-invisible](img/icons/block-invisible.svg.png)                           | `block-invisible`              |
| ![block-visible-recurring](img/icons/block-visible-recurring.svg.png)           | `block-visible-recurring`      |
| ![block-visible](img/icons/block-visible.svg.png)                               | `block-visible`                |
| ![blog_post](img/icons/blog_post.svg.png)                                       | `blog_post`                    |
| ![blog](img/icons/blog.svg.png)                                                 | `blog`                         |
| ![bold](img/icons/bold.svg.png)                                                 | `bold`                         |
| ![bookmark-active](img/icons/bookmark-active.svg.png)                           | `bookmark-active`              |
| ![bookmark-manager](img/icons/bookmark-manager.svg.png)                         | `bookmark-manager`             |
| ![bookmark](img/icons/bookmark.svg.png)                                         | `bookmark`                     |
| ![box-collapse](img/icons/box-collapse.svg.png)                                 | `box-collapse`                 |
| ![browse](img/icons/browse.svg.png)                                             | `browse`                       |
| ![bubbles](img/icons/bubbles.svg.png)                                           | `bubbles`                      |
| ![button](img/icons/button.svg.png)                                             | `button`                       |
| ![business-deal-cash](img/icons/business-deal-cash.svg.png)                     | `business-deal-cash`           |
| ![campaign](img/icons/campaign.svg.png)                                         | `campaign`                     |
| ![captcha](img/icons/captcha.svg.png)                                           | `captcha`                      |
| ![caret-back](img/icons/caret-back.svg.png)                                     | `caret-back`                   |
| ![caret-double-back](img/icons/caret-double-back.svg.png)                       | `caret-double-back`            |
| ![caret-double-next](img/icons/caret-double-next.svg.png)                       | `caret-double-next`            |
| ![caret-down](img/icons/caret-down.svg.png)                                     | `caret-down`                   |
| ![caret-expanded](img/icons/caret-expanded.svg.png)                             | `caret-expanded`               |
| ![caret-next](img/icons/caret-next.svg.png)                                     | `caret-next`                   |
| ![caret-up](img/icons/caret-up.svg.png)                                         | `caret-up`                     |
| ![cart-upload](img/icons/cart-upload.svg.png)                                   | `cart-upload`                  |
| ![cart-wishlist](img/icons/cart-wishlist.svg.png)                               | `cart-wishlist`                |
| ![cart](img/icons/cart.svg.png)                                                 | `cart`                         |
| ![catalog](img/icons/catalog.svg.png)                                           | `catalog`                      |
| ![category](img/icons/category.svg.png)                                         | `category`                     |
| ![checkbox-multiple](img/icons/checkbox-multiple.svg.png)                       | `checkbox-multiple`            |
| ![checkbox](img/icons/checkbox.svg.png)                                         | `checkbox`                     |
| ![checkmark](img/icons/checkmark.svg.png)                                       | `checkmark`                    |
| ![circle-caret-down](img/icons/circle-caret-down.svg.png)                       | `circle-caret-down`            |
| ![circle-caret-left](img/icons/circle-caret-left.svg.png)                       | `circle-caret-left`            |
| ![circle-caret-right](img/icons/circle-caret-right.svg.png)                     | `circle-caret-right`           |
| ![circle-caret-up](img/icons/circle-caret-up.svg.png)                           | `circle-caret-up`              |
| ![circle-close](img/icons/circle-close.svg.png)                                 | `circle-close`                 |
| ![circle-create](img/icons/circle-create.svg.png)                               | `circle-create`                |
| ![clicked-recommendations](img/icons/clicked-recommendations.svg.png)           | `clicked-recommendations`      |
| ![clipboard](img/icons/clipboard.svg.png)                                       | `clipboard`                    |
| ![collapse](img/icons/collapse.svg.png)                                         | `collapse`                     |
| ![collection](img/icons/collection.svg.png)                                     | `collection`                   |
| ![comment](img/icons/comment.svg.png)                                           | `comment`                      |
| ![connect](img/icons/connect.svg.png)                                           | `connect`                      |
| ![column-one](img/icons/column-one.svg.png)                                     | `column-one`                   |
| ![column-two](img/icons/column-two.svg.png)                                     | `column-two`                   |
| ![components](img/icons/components.svg.png)                                     | `components`                   |
| ![contentlist](img/icons/content-list.svg.png)                                  | `contentlist`                  |
| ![content-tree](img/icons/content-tree.svg.png)                                 | `content-tree`                 |
| ![content-type-group](img/icons/content-type-group.svg.png)                     | `content-type-group`           |
| ![content-type-content](img/icons/content-type-content.svg.png)                 | `content-type-content`         |
| ![content-type](img/icons/content-type.svg.png)                                 | `content-type`                 |
| ![content-write](img/icons/content-write.svg.png)                               | `content-write`                |
| ![copy](img/icons/copy.svg.png)                                                 | `copy`                         |
| ![copy-subtree](img/icons/copy-subtree.svg.png)                                 | `copy-subtree`                 |
| ![core](img/icons/core.svg.png)                                                 | `core`                         |
| ![content-draft](img/icons/content-draft.svg.png)                               | `content-draft`                |
| ![create-content](img/icons/create-content.svg.png)                             | `create-content`               |
| ![create-location](img/icons/create-location.svg.png)                           | `create-location`              |
| ![crop](img/icons/crop.svg.png)                                                 | `crop`                         |
| ![create](img/icons/create.svg.png)                                             | `create`                       |
| ![custom_tags](img/icons/custom_tags.svg.png)                                   | `custom_tags`                  |
| ![customer](img/icons/customer.svg.png)                                         | `customer`                     |
| ![customer-portal](img/icons/customer-portal.svg.png)                           | `customer-portal`              |
| ![customer-portal-page](img/icons/customer-portal-page.svg.png)                 | `customer-portal-page`         |
| ![customer-type](img/icons/customer-type.svg.png)                               | `customer-type`                |
| ![dashboard-clean](img/icons/dashboard-clean.svg.png)                           | `dashboard-clean`              |
| ![dashboard-type](img/icons/dashboard-type.svg.png)                             | `dashboard-type`               |
| ![dashboard](img/icons/dashboard.svg.png)                                       | `dashboard`                    |
| ![database](img/icons/database.svg.png)                                         | `database`                     |
| ![date-updated](img/icons/date-updated.svg.png)                                 | `date-updated`                 |
| ![date](img/icons/date.svg.png)                                                 | `date`                         |
| ![discard](img/icons/discard.svg.png)                                           | `discard`                      |
| ![download](img/icons/download.svg.png)                                         | `download`                     |
| ![drag](img/icons/drag.svg.png)                                                 | `drag`                         |
| ![drafts](img/icons/drafts.svg.png)                                             | `drafts`                       |
| ![dropdown](img/icons/dropdown.svg.png)                                         | `dropdown`                     |
| ![earth-access](img/icons/earth-access.svg.png)                                 | `earth-access`                 |
| ![edit](img/icons/edit.svg.png)                                                 | `edit`                         |
| ![embed](img/icons/embed.svg.png)                                               | `embed`                        |
| ![embed-inline](img/icons/embed-inline.svg.png)                                 | `embed-inline`                 |
| ![erp](img/icons/erp.svg.png)                                                   | `erp`                          |
| ![error-icon](img/icons/error-icon.svg.png)                                     | `error-icon`                   |
| ![error](img/icons/error.svg.png)                                               | `error`                        |
| ![expand-left](img/icons/expand-left.svg.png)                                   | `expand-left`                  |
| ![explore](img/icons/explore.svg.png)                                           | `explore`                      |
| ![events-collected](img/icons/events-collected.svg.png)                         | `events-collected`             |
| ![facebook](img/icons/facebook.svg.png)                                         | `facebook`                     |
| ![factbox](img/icons/factbox.svg.png)                                           | `factbox`                      |
| ![fields](img/icons/fields.svg.png)                                             | `fields`                       |
| ![file-text](img/icons/file-text.svg.png)                                       | `file-text`                    |
| ![file-video](img/icons/file-video.svg.png)                                     | `file-video`                   |
| ![file](img/icons/file.svg.png)                                                 | `file`                         |
| ![filters-funnel](img/icons/filters-funnel.svg.png)                             | `filters-funnel`               |
| ![filters](img/icons/filters.svg.png)                                           | `filters`                      |
| ![flag](img/icons/flag.svg.png)                                                 | `flag`                         |
| ![flash](img/icons/flash.svg.png)                                               | `flash`                        |
| ![flip](img/icons/flip.svg.png)                                                 | `flip`                         |
| ![flip-horizontal](img/icons/flip-horizontal.svg.png)                           | `flip-horizontal`              |
| ![flip-vertical](img/icons/flip-vertical.svg.png)                               | `flip-vertical`                |
| ![focus](img/icons/focus.svg.png)                                               | `focus`                        |
| ![un-focus](img/icons/un-focus.svg.png)                                         | `un-focus`                     |
| ![focus-image](img/icons/focus-image.svg.png)                                   | `focus-image`                  |
| ![folder-empty](img/icons/folder-empty.svg.png)                                 | `folder-empty`                 |
| ![folder](img/icons/folder.svg.png)                                             | `folder`                       |
| ![form-data](img/icons/form-data.svg.png)                                       | `form-data`                    |
| ![form](img/icons/form.svg.png)                                                 | `form`                         |
| ![future-publication](img/icons/future-publication.svg.png)                     | `future-publication`           |
| ![gallery](img/icons/gallery.svg.png)                                           | `gallery`                      |
| ![go-right](img/icons/go-right.svg.png)                                         | `go-right`                     |
| ![go-to-root](img/icons/go-to-root.svg.png)                                     | `go-to-root`                   |
| ![go-up](img/icons/go-up.svg.png)                                               | `go-up`                        |
| ![h1](img/icons/h1.svg.png)                                                     | `h1`                           |
| ![h2](img/icons/h2.svg.png)                                                     | `h2`                           |
| ![h3](img/icons/h3.svg.png)                                                     | `h3`                           |
| ![h4](img/icons/h4.svg.png)                                                     | `h4`                           |
| ![h5](img/icons/h5.svg.png)                                                     | `h5`                           |
| ![h6](img/icons/h6.svg.png)                                                     | `h6`                           |
| ![hide](img/icons/hide.svg.png)                                                 | `hide`                         |
| ![history-file](img/icons/history-file.svg.png)                                 | `history-file`                 |
| ![history](img/icons/history.svg.png)                                           | `history`                      |
| ![home-page](img/icons/home-page.svg.png)                                       | `home-page`                    |
| ![image-center](img/icons/image-center.svg.png)                                 | `image-center`                 |
| ![image-editor](img/icons/image-editor.svg.png)                                 | `image-editor`                 |
| ![image-left](img/icons/image-left.svg.png)                                     | `image-left`                   |
| ![image-right](img/icons/image-right.svg.png)                                   | `image-right`                  |
| ![image-variations](img/icons/image-variations.svg.png)                         | `image-variations`             |
| ![image](img/icons/image.svg.png)                                               | `image`                        |
| ![imported-items](img/icons/imported-items.svg.png)                             | `imported-items`               |
| ![information](img/icons/information.svg.png)                                   | `information`                  |
| ![input-hidden](img/icons/input-hidden.svg.png)                                 | `input-hidden`                 |
| ![input-line-multiple](img/icons/input-line-multiple.svg.png)                   | `input-line-multiple`          |
| ![input-line](img/icons/input-line.svg.png)                                     | `input-line`                   |
| ![input-number](img/icons/input-number.svg.png)                                 | `input-number`                 |
| ![italic](img/icons/italic.svg.png)                                             | `italic`                       |
| ![keyword](img/icons/keyword.svg.png)                                           | `keyword`                      |
| ![landing_page](img/icons/landing_page.svg.png)                                 | `landing_page`                 |
| ![landingpage-add](img/icons/landingpage-add.svg.png)                           | `landingpage-add`              |
| ![landingpage-preview](img/icons/landingpage-preview.svg.png)                   | `landingpage-preview`          |
| ![languages-add](img/icons/languages-add.svg.png)                               | `languages-add`                |
| ![languages](img/icons/languages.svg.png)                                       | `languages`                    |
| ![last-purchased](img/icons/last-purchased.svg.png)                             | `last-purchased`               |
| ![last-viewed](img/icons/last-viewed.svg.png)                                   | `last-viewed`                  |
| ![layout-switch](img/icons/layout-switch.svg.png)                               | `layout-switch`                |
| ![layout-manager](img/icons/layout-manager.svg.png)                             | `layout-manager`               |
| ![link-content](img/icons/link-content.svg.png)                                 | `link-content`                 |
| ![link-remove](img/icons/link-remove.svg.png)                                   | `link-remove`                  |
| ![link-anchor](img/icons/link-anchor.svg.png)                                   | `link-anchor`                  |
| ![link](img/icons/link.svg.png)                                                 | `link`                         |
| ![list-numbered](img/icons/list-numbered.svg.png)                               | `list-numbered`                |
| ![list](img/icons/list.svg.png)                                                 | `list`                         |
| ![location-add-new](img/icons/location-add-new.svg.png)                         | `location-add-new`             |
| ![localize](img/icons/localize.svg.png)                                         | `localize`                     |
| ![lock-unlock](img/icons/lock-unlock.svg.png)                                   | `lock-unlock`                  |
| ![lock](img/icons/lock.svg.png)                                                 | `lock`                         |
| ![logout](img/icons/logout.svg.png)                                             | `logout`                       |
| ![maform](img/icons/maform.svg.png)                                             | `maform`                       |
| ![mail](img/icons/mail.svg.png)                                                 | `mail`                         |
| ![markup](img/icons/markup.svg.png)                                             | `markup`                       |
| ![media-type](img/icons/media-type.svg.png)                                     | `media-type`                   |
| ![media](img/icons/media.svg.png)                                               | `media`                        |
| ![merge](img/icons/merge.svg.png)                                               | `merge`                        |
| ![move](img/icons/move.svg.png)                                                 | `move`                         |
| ![newsletter](img/icons/newsletter.svg.png)                                     | `newsletter`                   |
| ![news](img/icons/news.svg.png)                                                 | `news`                         |
| ![notice](img/icons/notice.svg.png)                                             | `notice`                       |
| ![open-newtab](img/icons/open-newtab.svg.png)                                   | `open-newtab`                  |
| ![open-sametab](img/icons/open-sametab.svg.png)                                 | `open-sametab`                 |
| ![options](img/icons/options.svg.png)                                           | `options`                      |
| ![order-management](img/icons/order-management.svg.png)                         | `order-management`             |
| ![order-history](img/icons/order-history.svg.png)                               | `order-history`                |
| ![order-status](img/icons/order-status.svg.png)                                 | `order-status`                 |
| ![object-state](img/icons/object-state.svg.png)                                 | `object-state`                 |
| ![panels](img/icons/panels.svg.png)                                             | `panels`                       |
| ![previewed](img/icons/previewed.svg.png)                                       | `previewed`                    |
| ![paragraph-add](img/icons/paragraph-add.svg.png)                               | `paragraph-add`                |
| ![paragraph](img/icons/paragraph.svg.png)                                       | `paragraph`                    |
| ![pdf-file](img/icons/pdf-file.svg.png)                                         | `pdf-file`                     |
| ![personalize-block](img/icons/personalize-block.svg.png)                       | `personalize-block`            |
| ![personalize-content](img/icons/personalize-content.svg.png)                   | `personalize-content`          |
| ![personalize](img/icons/personalize.svg.png)                                   | `personalize`                  |
| ![pin-unpin](img/icons/pin-unpin.svg.png)                                       | `pin-unpin`                    |
| ![pin](img/icons/pin.svg.png)                                                   | `pin`                          |
| ![places](img/icons/places.svg.png)                                             | `places`                       |
| ![place](img/icons/place.svg.png)                                               | `place`                        |
| ![portfolio](img/icons/portfolio.svg.png)                                       | `portfolio`                    |
| ![price](img/icons/price.svg.png)                                               | `price`                        |
| ![previewed](img/icons/previewed.svg.png)                                       | `previewed`                    |
| ![product_list](img/icons/product_list.svg.png)                                 | `product_list`                 |
| ![product](img/icons/product.svg.png)                                           | `product`                      |
| ![product-catalog](img/icons/product-catalog.svg.png)                           | `product-catalog`              |
| ![product-category](img/icons/product-category.svg.png)                         | `product-category`             |
| ![product-low](img/icons/product-low.svg.png)                                   | `product-low`                  |
| ![product-type](img/icons/product-type.svg.png)                                 | `product-type`                 |
| ![profile](img/icons/profile.svg.png)                                           | `profile`                      |
| ![publish-later-cancel](img/icons/publish-later-cancel.svg.png)                 | `publish-later-cancel`         |
| ![publish-later-create](img/icons/publish-later-create.svg.png)                 | `publish-later-create`         |
| ![publish-later](img/icons/publish-later.svg.png)                               | `publish-later`                |
| ![publish](img/icons/publish.svg.png)                                           | `publish`                      |
| ![publish-hide](img/icons/publish-hide.svg.png)                                 | `publish-hide`                 |
| ![qa-catalog](img/icons/qa-catalog.svg.png)                                     | `qa-catalog`                   |
| ![qa-company](img/icons/qa-company.svg.png)                                     | `qa-company`                   |
| ![qa-content](img/icons/qa-content.svg.png)                                     | `qa-content`                   |
| ![qa-form](img/icons/qa-form.svg.png)                                           | `qa-form`                      |
| ![qa-product](img/icons/qa-product.svg.png)                                     | `qa-product`                   |
| ![quote](img/icons/quote.svg.png)                                               | `quote`                        |
| ![radio-button-multiple](img/icons/radio-button-multiple.svg.png)               | `radio-button-multiple`        |
| ![radio-button](img/icons/radio-button.svg.png)                                 | `radio-button`                 |
| ![rate-review](img/icons/rate-review.svg.png)                                   | `rate-review`                  |
| ![rate](img/icons/rate.svg.png)                                                 | `rate`                         |
| ![recent-activity](img/icons/recent-activity.svg.png)                           | `recent-activity`              |
| ![recently-added](img/icons/recently-added.svg.png)                             | `recently-added`               |
| ![recommendation-calls](img/icons/recommendation-calls.svg.png)                 | `recommendation-calls`         |
| ![redo](img/icons/redo.svg.png)                                                 | `redo`                         |
| ![refresh](img/icons/refresh.svg.png)                                           | `refresh`                      |
| ![rejected](img/icons/rejected.svg.png)                                         | `rejected`                     |
| ![relations](img/icons/relations.svg.png)                                       | `relations`                    |
| ![restore-parent](img/icons/restore-parent.svg.png)                             | `restore-parent`               |
| ![restore](img/icons/restore.svg.png)                                           | `restore`                      |
| ![reveal](img/icons/reveal.svg.png)                                             | `reveal`                       |
| ![review](img/icons/review.svg.png)                                             | `review`                       |
| ![roles](img/icons/roles.svg.png)                                               | `roles`                        |
| ![rss](img/icons/rss.svg.png)                                                   | `rss`                          |
| ![save](img/icons/save.svg.png)                                                 | `save`                         |
| ![save-exit](img/icons/save-exit.svg.png)                                       | `save-exit`                    |
| ![schedule](img/icons/schedule.svg.png)                                         | `schedule`                     |
| ![search](img/icons/search.svg.png)                                             | `search`                       |
| ![sections](img/icons/sections.svg.png)                                         | `sections`                     |
| ![send-review](img/icons/send-review.svg.png)                                   | `send-review`                  |
| ![server](img/icons/server.svg.png)                                             | `server`                       |
| ![settings-block](img/icons/settings-block.svg.png)                             | `settings-block`               |
| ![settings-config](img/icons/settings-config.svg.png)                           | `settings-config`              |
| ![sites-all](img/icons/sites-all.svg.png)                                       | `sites-all`                    |
| ![slider](img/icons/slider.svg.png)                                             | `slider`                       |
| ![spinner](img/icons/spinner.svg.png)                                           | `spinner`                      |
| ![square](img/icons/square.svg.png)                                             | `square`                       |
| ![stats](img/icons/stats.svg.png)                                               | `stats`                        |
| ![strikethrough](img/icons/strikethrough.svg.png)                               | `strikethrough`                |
| ![subscriber](img/icons/subscriber.svg.png)                                     | `subscriber`                   |
| ![subscript](img/icons/subscript.svg.png)                                       | `subscript`                    |
| ![superscript](img/icons/superscript.svg.png)                                   | `superscript`                  |
| ![swap](img/icons/swap.svg.png)                                                 | `swap`                         |
| ![system-information](img/icons/system-information.svg.png)                     | `system-information`           |
| ![table-add](img/icons/table-add.svg.png)                                       | `table-add`                    |
| ![table-cell](img/icons/table-cell.svg.png)                                     | `table-cell`                   |
| ![table-column](img/icons/table-column.svg.png)                                 | `table-column`                 |
| ![table-row](img/icons/table-row.svg.png)                                       | `table-row`                    |
| ![tag](img/icons/tag.svg.png)                                                   | `tag`                          |
| ![tags](img/icons/tags.svg.png)                                                 | `tags`                         |
| ![telephone](img/icons/telephone.svg.png)                                       | `telephone`                    |
| ![timeline](img/icons/timeline.svg.png)                                         | `timeline`                     |
| ![trash-empty](img/icons/trash-empty.svg.png)                                   | `trash-empty`                  |
| ![trash-notrashed](img/icons/trash-notrashed.svg.png)                           | `trash-notrashed`              |
| ![trash-send](img/icons/trash-send.svg.png)                                     | `trash-send`                   |
| ![trash](img/icons/trash.svg.png)                                               | `trash`                        |
| ![twitter](img/icons/twitter.svg.png)                                           | `twitter`                      |
| ![unarchive](img/icons/unarchive.svg.png)                                       | `unarchive`                    |
| ![underscore](img/icons/underscore.svg.png)                                     | `underscore`                   |
| ![undo](img/icons/undo.svg.png)                                                 | `undo`                         |
| ![upload-image](img/icons/upload-image.svg.png)                                 | `upload-image`                 |
| ![upload](img/icons/upload.svg.png)                                             | `upload`                       |
| ![user](img/icons/user.svg.png)                                                 | `user`                         |
| ![user_group](img/icons/user_group.svg.png)                                     | `user_group`                   |
| ![user-add](img/icons/user-add.svg.png)                                         | `user-add`                     |
| ![user-blocked](img/icons/user-blocked.svg.png)                                 | `user-blocked`                 |
| ![user-recycle](img/icons/user-recycle.svg.png)                                 | `user-recycle`                 |
| ![user-tick](img/icons/user-tick.svg.png)                                       | `user-tick`                    |
| ![user-type](img/icons/user-type.svg.png)                                       | `user-type`                    |
| ![users-personalization](img/icons/users-personalization.svg.png)               | `users-personalization`        |
| ![users-select](img/icons/users-select.svg.png)                                 | `users-select`                 |
| ![variation-1-1](img/icons/variation-1-1.svg.png)                               | `variation-1-1`                |
| ![variation-3-2](img/icons/variation-3-2.svg.png)                               | `variation-3-2`                |
| ![variation-4-3](img/icons/variation-4-3.svg.png)                               | `variation-4-3`                |
| ![variation-16-9](img/icons/variation-16-9.svg.png)                             | `variation-16-9`               |
| ![variation-custom](img/icons/variation-custom.svg.png)                         | `variation-custom`             |
| ![version-compare](img/icons/version-compare.svg.png)                           | `version-compare`              |
| ![version-compare-action](img/icons/version-compare-action.svg.png)             | `version-compare-action`       |
| ![versions](img/icons/versions.svg.png)                                         | `versions`                     |
| ![video](img/icons/video.svg.png)                                               | `video`                        |
| ![view-custom](img/icons/view-custom.svg.png)                                   | `view-custom`                  |
| ![view-desktop](img/icons/view-desktop.svg.png)                                 | `view-desktop`                 |
| ![view-grid](img/icons/view-grid.svg.png)                                       | `view-grid`                    |
| ![view-hide](img/icons/view-hide.svg.png)                                       | `view-hide`                    |
| ![view-list](img/icons/view-list.svg.png)                                       | `view-list`                    |
| ![view-mobile](img/icons/view-mobile.svg.png)                                   | `view-mobile`                  |
| ![view-tablet](img/icons/view-tablet.svg.png)                                   | `view-tablet`                  |
| ![view](img/icons/view.svg.png)                                                 | `view`                         |
| ![wand](img/icons/wand.svg.png)                                                 | `wand`                         |
| ![warning-triangle](img/icons/warning-triangle.svg.png)                         | `warning-triangle`             |
| ![warning](img/icons/warning.svg.png)                                           | `warning`                      |
| ![wiki-file](img/icons/wiki-file.svg.png)                                       | `wiki-file`                    |
| ![wiki](img/icons/wiki.svg.png)                                                 | `wiki`                         |
| ![workflow](img/icons/workflow.svg.png)                                         | `workflow`                     |
| ![vertical-left-right](img/icons/vertical-left-right.svg.png)                   | `vertical-left-right`          |
| ![menu](img/icons/menu.svg.png)                                                 | `menu`                         |
| ![hierarchy](img/icons/hierarchy.svg.png)                                       | `hierarchy`                    |
| ![cart-full](img/icons/cart-full.svg.png)                                       | `cart-full`                    |
| ![sites](img/icons/sites.svg.png)                                               | `sites`                        |
| ![interface-block](img/icons/interface-block.svg.png)                           | `interface-block`              |
| ![full-view](img/icons/full-view.svg.png)                                       | `full-view`                    |
| ![un-full-view](img/icons/un-full-view.svg.png)                                 | `un-full-view`                 |
