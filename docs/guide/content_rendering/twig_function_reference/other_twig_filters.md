# Other Twig filters

### `ez_icon_path()`

`ez_icon_path()` generates a path to the selected icon from an icon set.

|Argument|Type|Description|
|------|------|------|
|`icon`|`string`|Identifier of an icon in the icon set.|
|`set`|`string`|Identifier of the configured icon set. If empty, the default icon set is used.|

```html+twig
<svg class="ez-icon ez-icon--medium ez-icon--light">
    <use xlink:href="{{ ez_icon_path('edit', 'my_icons') }}"></use>
</svg>
```
