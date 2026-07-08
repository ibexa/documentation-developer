---
month_change: false
description: Configure custom icons to use for content types.
---

# Custom icons

## Customize content type icons

To add custom icons for existing content types or custom content types in [[= product_name =]], use the following configuration under the `ibexa.system.<scope>.content_type` [configuration key](configuration.md#configuration-files):

```yaml
ibexa:
    system:
        default:
            content_type:
                article:
                    thumbnail: /assets/images/custom_icon.svg#custom
                category:
                    thumbnail: /bundles/ibexaicons/img/all-icons.svg#folder
```

Place the icon in `public/assets/images` and run `yarn encore <dev|prod>` after adding it.

!!! note "Icons format"

    To ensure proper display in the back office, all icons should have SVG format with `symbol`.

Use the [scope](multisite_configuration.md#scope) if you want different icons for different SiteAccesses.

To see more Admin UI's `streamlineicons` icons, see [the icon reference](icon_twig_functions.md#icons-reference).

### Access icons in Twig templates

#### Content type icons

Content type icons are accessible in Twig templates via the [`ibexa_content_type_icon()` function](icon_twig_functions.md#ibexa_content_type_icon).
It requires content type identifier as an argument. The function returns the path to a content type icon.

```twig
<svg class="ibexa-icon ibexa-icon-{{ content.contentType.identifier }}">
    <use xlink:href="{{ ibexa_content_type_icon(content.contentType.identifier) }}"></use>
</svg>
```

#### UI Icons

User interface icons are accessible with [`ibexa_icon_path()` function](icon_twig_functions.md#ibexa_icon_path). The function returns a path from an icon identifier and an [icon set](#icon-sets) identifier arguments.

### Access icons in JavaScript

Content types icons configuration is stored in a global object: `ibexa.adminUiConfig.contentTypes`.

You can retrieve the icon URL with the `getContentTypeIcon` helper function that is set on the global `ibexa.helpers.contentType` object.
It takes content type identifier as an argument and returns one of the following items:

- URL of a specified content type's icon
- `null` if there is no content type with specified identifier

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

You can use a React component to change icons in back office and Page Builder.

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

## Customize UI icons

### Icon sets

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

The icon sets are used by [`ibexa_icon_path()` Twig function](icon_twig_functions.md#ibexa_icon_path).

- If you change the `default_icon_set` from one SiteAccess to another, `ibexa_icon_path(icon)` without `set` argument targets icons from different set files
- If you change the file path of an icon set from one SiteAccess to another, `ibexa_icon_path(icon, set)` with the same `set` argument targets icons from different set files

The built-in default icon set is `streamlineicons` (corresponding to `/bundles/ibexaicons/img/all-icons.svg`).
To see the icons available in this set, see [the icon reference](icon_twig_functions.md#icons-reference).
