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

### Icons size variants

The default icon size is `32px`. To change the default size, add the modificator to the class name.

``` twig
<svg class="ibexa-icon ibexa-icon--medium ibexa-icon--create">
  <use xlink:href="{{ ibexa_icon_path('create') }}"></use>
</svg>
```

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

 - URL of a given Content Type's icon
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

### Custom icons in React

In Page Builder and Back Office React icons can be configured.