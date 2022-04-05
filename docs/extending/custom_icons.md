# Icons

## Customize Content Type icons

To add custom icons for existing Content Types or custom Content Types in [[= product_name =]], follow the instructions below.

### Configuration

To configure a custom icon for a Content Type, use the following configuration in `config/packages/ezplatform.yaml`, for example:

```yaml
ezplatform:
    system:
        default:
            content_type:
                article:
                    thumbnail: /assets/images/custom_icon.svg#custom
```

Place the icon in `public/assets/images` and remember to run `yarn encore <dev|prod>` after adding it.

!!! note "Icons format"
    To ensure proper display in the Back Office, all icons should have SVG format with `symbol`.

If you want to configure icons per SiteAccess, see [Icon sets](../guide/config_back_office.md#icon-sets).

### Icons size variants

The default icon size in the Back Office is `32px`. To change the default size, in the template add the modifier to the class name.

``` twig
<svg class="ibexa-icon ibexa-icon--medium ibexa-icon--create">
  <use xlink:href="{{ ibexa_icon_path('create') }}"></use>
</svg>
```

`ez_icon_path` - deprecated
`ibexa_icon_path` - allows to specify the path to to icons. free licence and paid licence.
community, public icons


The list of available icon sizes:

|Size|Class name|
|----|---------|
|`8px`|`--tiny`|
|`12px`|`--tiny-small`|
|`16px`|`--small`|
|`20px`|`--small-medium`|
|`24px`|`--medium`|
|`38px`|`--medium-large`|
|`48px`|`--large`|
|`64px`|`--extra-large`|


### Custom icons in Twig templates

Content Type icons are accessible in Twig templates with the `ez_content_type_icon` function.
It requires Content Type identifier as an argument. The function returns the path to a Content Type icon.

```twig
<svg class="ibexa-icon ibexa-icon-{{ content.contentType.identifier }}">
    <use xlink:href="{{ ez_content_type_icon(content.contentType.identifier) }}"></use>
</svg>
```



### Custom icons in JavaScript

Content Types icons configuration is stored in a global object: `eZ.adminUiConfig.contentTypes`.

You can easily retrieve the icon URL with the `getContentTypeIcon` helper function that is set on the global `eZ.helpers.contentType` object.
It takes Content Type identifier as an argument and returns one of the following items:

 - URL of a specified Content Type's icon
 - `null` if there is no Content Type with specified identifier

Example with `getContentTypeIcon`:

```jsx
const contentTypeIconUrl = eZ.helpers.contentType.getContentTypeIconUrl(contentTypeIdentifier);
return (
   <svg className="ibexa-icon">
       <use xlinkHref={contentTypeIconUrl} />
   </svg>
)
```

### Custom icons in React component

You can use React component to customize icons in Back Office and Page Builder.

See the example with React component in the `alert.js` configuration:

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