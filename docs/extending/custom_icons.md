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

    All icons should be in SVG format with `symbol` so they can display properly in the Back Office.

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

You can easily retrieve the icon URL with the `getContentTypeIcon`  helper function that is set on the global `ibexa.helpers.contentType` object.
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
