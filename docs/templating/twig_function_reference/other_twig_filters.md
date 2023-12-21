---
page_type: reference
---

# Other Twig filters

### `ibexa_user_get_current()`

`ibexa_user_get_current()` returns the User object (`Ibexa\Contracts\Core\Repository\Values\User\User`) of the current user.

``` html+twig
{{ ibexa_user_get_current().login }}
```

You can get the underlying Content item, for example the user's name,
by accessing the `content` property:

``` html+twig
{{ ibexa_render(ibexa_user_get_current().content) }}
```

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

#### Icon size variants

The default icon size in the Back Office is `32px`. To change the default size, in the template add the modifier to the class name.

``` twig
<svg class="ibexa-icon ibexa-icon--medium">
  <use xlink:href="{{ ibexa_icon_path('create') }}"></use>
</svg>
```

The list of available icon sizes:

|Size|Class postfix (modifiers)|
|----|---------|
|`8px`|`--tiny`|
|`12px`|`--tiny-small`|
|`16px`|`--small`|
|`20px`|`--small-medium`|
|`24px`|`--medium`|
|`38px`|`--medium-large`|
|`48px`|`--large`|
|`64px`|`--extra-large`|

### `ibexa_taxonomy_entries_for_content()`

`ibexa_taxonomy_entries_for_content()` fetches names of content categories.

| Argument | Type | Description |
|---------------|------|-------------|
| `content` | `Ibexa\Contracts\Core\Repository\Values\Content\Content` | Content item to display the category name for. |

```html+twig
{{ content|ibexa_taxonomy_entries_for_content|map(entry => "#{entry.name}")|join(', ') }} 
```