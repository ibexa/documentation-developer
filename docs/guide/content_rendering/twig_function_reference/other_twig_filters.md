# Other Twig filters

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
