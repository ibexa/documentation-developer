# Creating custom icons

## Custom Content Type icons

To add custom icons for existing Content Types or custom Content Types in [[= product_name_oss =]], follow the instructions below.
For more information on icons used in [[= product_name_oss =]], see [the Icons section](../guidelines/resources/icons.md).

### Configuration

A configuration of the default icon for Content Type is possible via the `default-config` key in `config/packages/ezplatform.yaml`, e.g.:

```yaml
ezplatform:
    system:
       default:
           content_type:
              default-config:
                 thumbnail: /assets/images/mydefaulticon.svg
```

To configure a custom icon, you need to replace the `default-config` key with a Content Type identifier.
For example:

```yaml
ezplatform:
    system:
       default:
           content_type:
              article:
                 thumbnail: /assets/images/customicon.svg
```

!!! note "Icons format"

    All icons should be in SVG format so they can display properly in Back Office.

### Custom icons in Twig templates

Content Type icons are accessible in Twig templates via the `ez_content_type_icon` function.
It requires Content Type identifier as an argument. The function returns the path to a Content Type icon.

```twig
<svg class="ez-icon ez-icon-{{ contentType.identifier }}">
    <use xlink:href="{{ ez_content_type_icon(contentType.identifier) }}"></use>
</svg>
```

If the icon for a given Content Type is **not specified** in the configuration, the default icon is returned.

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
