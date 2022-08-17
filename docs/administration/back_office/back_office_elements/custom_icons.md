---
description: Configure custom icons to use for Content Types.
---

# Custom icons

## Customize Content Type icons

To add custom icons for existing Content Types or custom Content Types in [[= product_name =]],
use the following configuration in `config/packages/ibexa.yaml`, for example:

```yaml
ibexa:
    system:
        default:
            content_type:
                article:
                    thumbnail: /assets/images/custom_icon.svg#custom
```

Place the icon in `public/assets/images` and run `yarn encore <dev|prod>` after adding it.

!!! note "Icons format"

    To ensure proper display in the Back Office, all icons should have SVG format with `symbol`.

If you want to configure icons per SiteAccess, see [Icon sets](#icon-sets).

To see more configuration options, see [icon sizes](other_twig_filters.md).

### Access icons in Twig templates

Content Type icons are accessible in Twig templates via the `ibexa_content_type_icon` function.
It requires Content Type identifier as an argument. The function returns the path to a Content Type icon.

```twig
<svg class="ibexa-icon ibexa-icon-{{ content.contentType.identifier }}">
    <use xlink:href="{{ ibexa_content_type_icon(content.contentType.identifier) }}"></use>
</svg>
```

### Access icons in JavaScript

Content Types icons configuration is stored in a global object: `ibexa.adminUiConfig.contentTypes`.

You can retrieve the icon URL with the `getContentTypeIcon` helper function that is set on the global `ibexa.helpers.contentType` object.
It takes Content Type identifier as an argument and returns one of the following items:

- URL of a specified Content Type's icon
- `null` if there is no Content Type with specified identifier

Example with `getContentTypeIcon`:

```jsx
const contentTypeIconUrl = ibexa.helpers.contentType.getContentTypeIconUrl(contentTypeIdentifier);
return (
   <svg className="ibexa-icon">
       <use xlinkHref={contentTypeIconUrl} />
   </svg>
)
```

### Icons React component

You can use a React component to change icons in Back Office and Page Builder.

The following example from the `alert.js` file shows configuration for icons in the [alert](reusable_components.md#alerts) component:

```jsx hl_lines="2"
<div className={className} role="alert">
    <Icon name={iconName} customPath={iconPath} extraClasses="ibexa-icon--small ibexa-alert__icon" />
    <div className={contentClassName}>
        {title && <div className="ibexa-alert__title">{title}</div>}
        {subtitle && <div className="ibexa-alert__subtitle">{subtitle}</div>}
    <div className="ibexa-alert__extra_content">{children}</div>
    </div>
        {showCloseBtn && (
            <button
                className="btn ibexa-btn ibexa-btn--ghost ibexa-btn--small ibexa-btn--no-text ibexa-alert__close-btn"
                onClick={onClose}>
                <Icon name="discard" extraClasses="ibexa-icon--tiny-small" />
            </button>
        )}
</div>
```

`Icon` component has three attributes (called props):

- `customPath` - a path to the custom icon
- `name` - the path is generated inside the component provided you use icon from the system
- `extraClasses` - additional CSS classes, use to set for example, icon size.

## Icon sets

You can configure icon sets to be used per SiteAccess:

``` yaml
ibexa:
    system:
        <siteaccess>:
            assets:
                icon_sets:
                    my_icons: /assets/images/icons/my_icons.svg
                    additional_icons: /assets/images/icons/additional_icons.svg
                default_icon_set: my_icons
```
