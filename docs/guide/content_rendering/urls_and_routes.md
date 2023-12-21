---
description: Add links to Content items or specific built-in and custom routes in your templates.
---

# URLs and routes

To link to a [Location](../content_management.md#locations) or [Content item](../content_model.md#content-items), use the [`ez_path()`](twig_function_reference/url_twig_functions.md#ez_path) Twig function.
You need to provide the function with a Location, Content, ContentInfo or [RouteReference](#routereference) object:

``` html+twig
<p><a href="{{ ez_path(location) }}">Location</a></p>

<p><a href="{{ ez_path(content.contentInfo) }}">Content Info</a></p>
```

Use [`ez_url()`](twig_function_reference/url_twig_functions.md#ez_url) to get an absolute URL to a Content item or Location:

``` html+twig
<p><a href="{{ ez_url(location) }}">Location</a></p>
```

## RouteReference

You can use the [`ez_route()`](twig_function_reference/url_twig_functions.md#ez_route) Twig function
to create a RouteReference object based on the provided information.

A RouteReference contains a route with its parameters and can be modified after it is created.
Here, the route is based on the ID of the Location.

``` html+twig
{% set routeReference = ez_route("ez_urlalias", { 'locationId': 2 }) %}
<p><a href="{{ ez_path(routeReference) }}">Route</a></p>
```

A route can also be based on the ID of the Content item.
The resulting link points to the Content item's main Location.

``` html+twig
{% set routeReference = ez_route("ez_urlalias", { 'contentId': 456 }) %}
<p><a href="{{ ez_path(routeReference) }}">Route</a></p>
```

With `ez_route()` you can modify the route contained in RouteReference after creation, for example, by providing additional parameters:

``` html+twig
{% set routeReference = ez_route("ez_urlalias", { 'locationId': 2 }) %}
{% do routeReference.set("param", "param-value") %}
```

You can also use `ez_route()` to create links to predefined routes, such as the `ezplatform.search` route that leads to a search form page:

``` html+twig
<a href="{{ ez_path(ez_route('ezplatform.search')) }}">Search</a>
```

## File download links

To provide a download link for a file, use `ez_route()` with the `ez_content_download` route:

``` html+twig
{% set download_route = ez_route('ez_content_download', {
    'content': file,
    'fieldIdentifier': 'file',
}) %}

<a href="{{ ez_path(download_route) }}">Download</a>
```

## Route list

The following built-in routes are available for the front of the website.

!!! tip

    To view all routes existing in the system, including internal and Back-Office related ones, run:

    ``` bash
    php bin/console debug:router
    ```

### Registration


|Route name|Path|Description|
|---|---|---|
| `ezplatform.user.user_register` | `/user/register` | User registration form |
| `ezplatform.user.register_confirmation`</br>`ezplatform.user.user_register_confirmation` | `/register-confirm`</br>`/user/register-confirm` | Confirmation page after user registration |

### Login

|Route name|Path|Description|
|---|---|---|
|`login` | `/login` | [Login form](layout/add_login_form.md) |
|`logout`</br>`silversolutionsCustomerLogout` | `/logout`</br>`/profile/logout` | Logging out the current user |

### Profile

|Route name|Path|Description|
|---|---|---|
| `silversolutionsCustomerDetail` | `/profile` | User profile |
| `silversolutions_address_book_list` | `/profile/address_book` | User address book |

### Password

|Route name|Path|Description|
|---|---|---|
| `ezplatform.user_profile.change_password`</br>`silversolutions_password_change` | `/user/change-password`</br>`/change_password` | Form for password change|
| `ezplatform.user.forgot_password` | `/user/forgot-password` | [Form for password resetting](layout/add_forgot_password.md) |
| `ezplatform.user.forgot_password.migration` | `/user/forgot-password/migration` | Form for resetting password after expiration|
| `ezplatform.user.forgot_password.login` | `/user/forgot-password/login` | Form for resetting password based on login instead of email address |
| `ezplatform.user.reset_password` | `/user/reset-password/{hashKey}` | Form for resetting password based on a generated link |

### Shop [[% include 'snippets/commerce_badge.md' %]]

|Route name|Path|Description|
|---|---|---|
| `silversolutions_bestsellers` | `/bestsellers` | [Bestseller page](../bestsellers.md) |
| `silversolutions_delegate` | `/delegate` | [Delegate function](../users/delegate_function.md) |
| `silversolutions_undelegate` | `/undelegate` | [Undelegate function](../users/delegate_function.md) |

### Content

|Route name|Path|Description|
|---|---|---|
| `ez_content_download` | `/content/download/{contentId}/{fieldIdentifier}/{filename}` | Downloading a binary file |
| `ezplatform.content.create_no_draft` | `/content/create/nodraft/{contentTypeIdentifier}/{language}/{parentLocationId}` | [Creating a Content item without using a draft](../user_generated_content.md#creating-a-content-item-without-using-a-draft) |
| `ezplatform.content.draft.edit` | `/content/edit/draft/{contentId}/{versionNo}/{language}/{locationId}` | [Editing a Content item](../user_generated_content.md#editing-a-content-item) |
| `ezplatform.content.draft.create` | `/content/create/draft/{contentId}/{fromVersionNo}/{fromLanguage}` | [Creating a new draft](../user_generated_content.md#creating-a-new-draft) |

### Search

|Route name|Path|Description|
|---|---|---|
| `ezplatform.search` | `/search` | Search form |
