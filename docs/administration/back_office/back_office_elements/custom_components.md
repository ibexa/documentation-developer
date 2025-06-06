---
description: Back office components allow you to inject any custom widgets into selected places of the user interface.
---

# Customizing the back office with Twig Components

You can customize many of the back office views by using [Twig components](components.md).
This allows you to inject your own custom logic and extend the templates.

The available groups for the back office are:

## Admin UI

| Group name | Template file |
|---|---|
|`admin-ui-login-form-after` | `vendor/ibexa/admin-ui/src/bundle/Resources/views/themes/admin/account/login/index.html.twig` |
|`admin-ui-login-form-before` | `vendor/ibexa/admin-ui/src/bundle/Resources/views/themes/admin/account/login/index.html.twig` |
|`admin-ui-content-create-form-before`| <ul><li>`vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/content/create/create.html.twig`</li><li> `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/on_the_fly/create_on_the_fly.html.twig`</li><li>`vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/user/create.html.twig` </li></ul>|
|`admin-ui-content-create-form-after`|  <ul><li>`vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/content/create/create.html.twig`</li><li>`vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/on_the_fly/create_on_the_fly.html.twig`</li><li> `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/user/create.html.twig`</li></ul> |
|`admin-ui-content-edit-form-after`| <ul><li> `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/content/edit/edit.html.twig` </li><li>  `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/on_the_fly/edit_on_the_fly.html.twig`</li><li> `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/user/edit.html.twig`</li></ul> |
|`admin-ui-content-edit-form-before`| <ul><li>`vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/content/edit/edit.html.twig`</li><li>`vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/on_the_fly/edit_on_the_fly.html.twig`</li><li> `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/user/edit.html.twig`</li></ul>  |
|`admin-ui-content-edit-sections`| <ul><li>`vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/content/edit/edit.html.twig`</li><li>`vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/on_the_fly/create_on_the_fly.html.twig`</li><li>`vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/on_the_fly/edit_on_the_fly.html.twig`</li></ul> |
|`admin-ui-content-form-create-header-actions`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/content/create/create.html.twig` |
|`admin-ui-content-form-edit-header-actions`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/content/edit/edit.html.twig` |
|`admin-ui-content-tree-after`| `vendor/ibexa/admin-ui/src/bundle/Resources/views/themes/admin/content/location_view.html.twig` |
|`admin-ui-content-tree-before`| `vendor/ibexaadmin-ui/src/bundle/Resources/views/themes/admin/content/location_view.html.twig` |
|`admin-ui-content-type-edit-sections`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/content_type/edit.html.twig` |
|`admin-ui-content-type-tab-groups`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/content_type/index.html.twig` |
|`admin-ui-dashboard-all-tab-groups`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/dashboard/block/all.html.twig` |
|`admin-ui-dashboard-blocks`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/dashboard/dashboard.html.twig` |
|`admin-ui-dashboard-my-tab-groups`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/dashboard/block/me.html.twig` |
|`admin-ui-distraction-free-mode-extras`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/form_fields.html.twig` |
|`admin-ui-form-content-add-translation-body`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/content/modal/add_translation.html.twig` |
|`admin-ui-global-search-autocomplete-templates`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/global_search.html.twig` |
|`admin-ui-global-search`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/layout.html.twig` |
|`admin-ui-header-user-menu-middle`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/menu/user.html.twig` |
|`admin-ui-image-edit-actions-after`| <ul><li>`vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/field_type/edit/ezimage.html.twig` </li><li>`vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/field_type/edit/ezimageasset.html.twig` </li></ul>|
|`admin-ui-layout-content-after`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/layout.html.twig` |
|`admin-ui-link-manager-block`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/url_management/url_management.html.twig` |
|`admin-ui-location-view-content-alerts`| `vendor/ibexa/admin-ui/src/bundle/Resources/views/themes/admin/content/location_view.html.twig` |
|`admin-ui-location-view-tab-groups`| `vendor/ibexa/admin-ui/src/bundle/Resources/views/themes/admin/content/location_view.html.twig` |
|`admin-ui-location-view-tabs-after`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/tab/location_view.html.twig` |
|`admin-ui-script-body`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/layout.html.twig` |
|`admin-ui-script-head`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/layout.html.twig` |
|`admin-ui-stylesheet-body`| <ul><li>`vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/layout_error.html.twig`</li><li>`vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/layout.html.twig`</li> |
|`admin-ui-stylesheet-head`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/layout.html.twig` |
|`admin-ui-systeminfo-tab-groups`| `vendor/ibexa/system-info/src/bundle/Resources/views/themes/admin/system_info/info.html.twig` |
|`admin-ui-user-menu`| `vendor/ibexa/admin-ui-ui/src/bundle/Resources/views/themes/admin/ui/layout.html.twig` |
|`admin-ui-user-profile-blocks`| `vendor/ibexa/admin-ui/src/bundle/Resources/views/themes/admin/account/profile/view.html.twig` |

For more information, see [this example using few of those components](components.md#example).

## Calendar

| Group name | Template file |
|---|---|
|`admin-ui-calendar-widget-before`| `vendor/ibexa/calendar/src/bundle/Resources/views/themes/admin/calendar/view.html.twig` |

## Site Context

| Group name | Template file |
|---|---|
|`admin-ui-content-tree-before`| `vendor/ibexa/site-context/src/bundle/Resources/views/themes/admin/content/fullscreen.html.twig` |
|`admin-ui-content-tree-after`| `vendor/ibexa/site-context/src/bundle/Resources/views/themes/admin/content/fullscreen.html.twig` |

## Product Catalog

| Group name | Template file |
|---|---|
|`admin-ui-attribute-definition-block`| `vendor/ibexa/product-catalog/src/bundle/Resources/views/themes/admin/product_catalog/attribute_definition/view.html.twig` |
|`admin-ui-attribute-definition-options-block`| `pvendor/ibexa/roduct-catalog/src/bundle/Resources/views/themes/admin/product_catalog/attribute_definition/tab/details.html.twig` |
|`admin-ui-attribute-group-block`| `vendor/ibexa/product-catalog/src/bundle/Resources/views/themes/admin/product_catalog/attribute_group/view.html.twig` |
|`admin-ui-catalog-block`| `vendor/ibexa/product-catalog/src/bundle/Resources/views/themes/admin/product_catalog/catalog/view.html.twig` |
|`admin-ui-customer-group-block`| `vendor/ibexa/product-catalog/src/bundle/Resources/views/themes/admin/product_catalog/customer_group/view.html.twig` |
|`admin-ui-product-create-form-header-actions`| `vendor/ibexa/product-catalog/src/bundle/Resources/views/themes/admin/product_catalog/product/create.html.twig` |
|`admin-ui-product-create-form-after`| `vendor/ibexa/product-catalog/src/bundle/Resources/views/themes/admin/product_catalog/product/create.html.twig` |
|`admin-ui-product-edit-form-header-actions`| `vendor/ibexa/product-catalog/src/bundle/Resources/views/themes/admin/product_catalog/product/edit.html.twig` |
|`admin-ui-product-edit-form-after`| `vendor/ibexa/product-catalog/src/bundle/Resources/views/themes/admin/product_catalog/product/edit.html.twig` |
|`admin-ui-product-block`| `vendor/ibexa/product-catalog/src/bundle/Resources/views/themes/admin/product_catalog/product/view.html.twig` |
|`admin-ui-product-type-block`| `vendor/ibexa/product-catalog/src/bundle/Resources/views/themes/admin/product_catalog/product_type/view.html.twig` |

## Taxonomy

| Group name | Template file |
|---|---|
|`admin-ui-location-view-tab-groups`| `vendor/ibexa/taxonomy/src/bundle/Resources/views/themes/admin/ibexa/taxonomy/taxonomy_entry/show.html.twig` |

## Page Builder [[% include 'snippets/experience_badge.md' %]]

| Group name | Template file |
|---|---|
|`admin-ui-infobar-options-before`| `vendor/ibexa/page-builder/src/bundle/Resources/views/page_builder/infobar/base.html.twig` |

## Order Management [[% include 'snippets/commerce_badge.md' %]]

| Group name | Template file |
|---|---|
|`admin-ui-order-details-summary-stats`| `vendor/ibexa/order-management/src/bundle/Resources/views/themes/admin/order_management/order/details_summary.html.twig` |
|`admin-ui-order-details-summary-grid`| `vendor/ibexa/order-management/src/bundle/Resources/views/themes/admin/order_management/order/details_summary.html.twig` |

## Payments [[% include 'snippets/commerce_badge.md' %]]

| Group name | Template file |
|---|---|
|`admin-ui-payment-method-tabs`| `vendor/ibexa/payment/src/bundle/Resources/views/themes/admin/payment_method/view.html.twig` |

## Shipping [[% include 'snippets/commerce_badge.md' %]]

| Group name | Template file |
|---|---|
|`admin-ui-shipment-summary-grid`| `vendor/ibexa/shipping/src/bundle/Resources/views/themes/admin/shipment/tab/summary.html.twig` |
|`admin-ui-shipping-method-block`| `vendor/ibexa/shipping/src/bundle/Resources/views/themes/admin/shipping/shipping_method/view.html.twig` |

## AI Actions [[% include 'snippets/lts-update_badge.md' %]]

| Group name | Template file |
|---|---|
|`admin-ui-action-configuration-tabs`| `vendor/ibexa/connector-ai/src/bundle/Resources/views/themes/admin/connector_ai/action_configuration/view.html.twig` |

