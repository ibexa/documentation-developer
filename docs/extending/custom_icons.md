# Creating custom icons

## Custom Content Type icons

To add custom icons for existing Content Types or custom Content Types in [[= product_name =]], follow the instructions below.
For more information on icons used in [[= product_name =]], see [the Icons section](../guidelines/resources/icons.md).

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

    All icons should be in SVG format with `symbol` so they can display properly in the Back Office.

### Custom icons in Twig templates

Content Type icons are accessible in Twig templates via the `ez_content_type_icon` function.
It requires Content Type identifier as an argument. The function returns the path to a Content Type icon.

```twig
<svg class="ez-icon ez-icon-{{ content.contentType.identifier }}">
    <use xlink:href="{{ ez_content_type_icon(content.contentType.identifier) }}"></use>
</svg>
```

### Custom icons in JavaScript

Content Types icons configuration is stored in a global object: `eZ.adminUiConfig.contentTypes`.

You can easily retrieve the icon URL with the `getContentTypeIcon`  helper function that is set on the global `eZ.helpers.contentType` object.
It takes Content Type identifier as an argument and returns one of the following items:

 - URL of a given Content Type's icon
 - `null` if there is no Content Type with given identifier

Example with `getContentTypeIcon`:

```jsx
const contentTypeIconUrl = eZ.helpers.contentType.getContentTypeIconUrl(contentTypeIdentifier);
return (
   <svg className="ez-icon">
       <use xlinkHref={contentTypeIconUrl} />
   </svg>
)
```
