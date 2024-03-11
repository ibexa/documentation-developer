---
description: User Twig functions enable getting repository user information.
page_type: reference
---

# User Twig functions

### `ibexa_user_get_current()`

`ibexa_user_get_current()` returns the User object (`Ibexa\Contracts\Core\Repository\Values\User\User`) of the current user.

``` html+twig
{{ ibexa_user_get_current().login }}
```

You can get the underlying Content item, for example to display the user's last name,
by accessing the `content` property:

``` html+twig
{{ ibexa_render_field(ibexa_user_get_current().content, 'last_name') }}
```

### `ibexa_current_user()`

`ibexa_current_user()` is a deprecated alias of `ibexa_user_get_current()`.


### `ibexa_is_current_user()`

The `ibexa_is_current_user()` Twig function checks whether a user is the current repository user.

#### Examples

```html+twig
{% if ibexa_is_current_user(version_info.author) %}
    <!-- Display edit link -->
{% endif %}
```