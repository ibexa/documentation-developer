---
description: Add links to Content items or specific built-in and custom routes in your templates.
---

# URLs and routes

To link to a [Location](url_twig_functions.md#ibexa_path) Twig function.
You need to provide the function with a Location, Content, ContentInfo or [RouteReference](#routereference) object:

``` html+twig
<p><a href="{{ ibexa_path(location) }}">Location</a></p>

<p><a href="{{ ibexa_path(content.contentInfo) }}">Content Info</a></p>
```

Use [`ibexa_url()`](url_twig_functions.md#ibexa_url) to get an absolute URL to a Content item or Location:

``` html+twig
<p><a href="{{ ibexa_url(location) }}">Location</a></p>
```

## RouteReference

You can use the [`ibexa_route()`](url_twig_functions.md#ibexa_route) Twig function
to create a RouteReference object based on the provided information.

A RouteReference contains a route with its parameters and can be modified after it is created.
Here, the route is based on the ID of the Location.

``` html+twig
{% set routeReference = ibexa_route("ibexa.url.alias", { 'locationId': 2 }) %}
<p><a href="{{ ibexa_path(routeReference) }}">Route</a></p>
```

A route can also be based on the ID of the Content item.
The resulting link points to the Content item's main Location.

``` html+twig
{% set routeReference = ibexa_route("ibexa.url.alias", { 'contentId': 456 }) %}
<p><a href="{{ ibexa_path(routeReference) }}">Route</a></p>
```

With `ibexa_route()` you can modify the route contained in RouteReference after creation, for example, by providing additional parameters:

``` html+twig
{% set routeReference = ibexa_route("ibexa.url.alias", { 'locationId': 2 }) %}
{% do routeReference.set("param", "param-value") %}
```

You can also use `ibexa_route()` to create links to predefined routes, such as the `ibexa.search` route that leads to a search form page:

``` html+twig
<a href="{{ ibexa_path(ibexa_route('ibexa.search')) }}">Search</a>
```

## File download links

To provide a download link for a file, use `ibexa_route()` with the `ibexa_content_download` route:

``` html+twig
{% set download_route = ibexa_route('ibexa_content_download', {
    'content': file,
    'fieldIdentifier': 'file',
}) %}

<a href="{{ ibexa_path(download_route) }}">Download</a>
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
| `ibexa.user.user_register` | `/user/register` | User registration form |
| `ibexa.user.register_confirmation`</br>`ibexa.user.user_register_confirmation` | `/register-confirm`</br>`/user/register-confirm` | Confirmation page after user registration |

### Login

|Route name|Path|Description|
|---|---|---|
|`login` | `/login` | [Login form](add_login_form.md) |
|`logout`</br>`ibexa.commerce.customer.logout` | `/logout`</br>`/profile/logout` | Logging out the current user |

### Profile

|Route name|Path|Description|
|---|---|---|
| `ibexa.commerce.customer.detail` | `/profile` | User profile |
| `ibexa.commerce.address.book.list` | `/profile/address_book` | User address book |

### Password

|Route name|Path|Description|
|---|---|---|
| `ibexa.user_profile.change_password`</br>`ibexa.commerce.password_change` | `/user/change-password`</br>`/change_password` | Form for password change|
| `ibexa.user.forgot_password` | `/user/forgot-password` | [Form for password resetting](add_forgot_password_option.md) |
| `ibexa.user.forgot_password.migration` | `/user/forgot-password/migration` | Form for resetting password after expiration|
| `ibexa.user.forgot_password.login` | `/user/forgot-password/login` | Form for resetting password based on login instead of email address |
| `ibexa.user.reset_password` | `/user/reset-password/{hashKey}` | Form for resetting password based on a generated link |

### Shop [[% include 'snippets/commerce_badge.md' %]]

|Route name|Path|Description|
|---|---|---|
| `ibexa.commerce.bestsellers` | `/bestsellers` | [Bestseller page](bestsellers.md) |

| Route          | Controller     | Description |
| -------------- | -------------- | ----------- |
| `/basket/show`   | `showAction()`   | Shows a basket with all basket lines |
| `/basket/add`    | `addAction()`    | Adds a product (product list) to the basket |
| `/basket/update` | `updateAction()` | Changes attributes (for example, quantity) of a basket line in the basket |
| `/basket/delete` | `deleteAction()` | Removes a basket line from the basket by the given basket line ID |

### Content

|Route name|Path|Description|
|---|---|---|
| `ibexa_content_download` | `/content/download/{contentId}/{fieldIdentifier}/{filename}` | Downloading a binary file |
| `ibexa.content.create_no_draft` | `/content/create/nodraft/{contentTypeIdentifier}/{language}/{parentLocationId}` | [Creating a Content item without using a draft](user_generated_content.md#creating-a-content-item-without-using-a-draft) |
| `ibexa.content.draft.edit` | `/content/edit/draft/{contentId}/{versionNo}/{language}/{locationId}` | [Editing a Content item](user_generated_content.md#editing-a-content-item) |
| `ibexa.content.draft.create` | `/content/create/draft/{contentId}/{fromVersionNo}/{fromLanguage}` | [Creating a new draft](user_generated_content.md#creating-a-new-draft) |

### Search

|Route name|Path|Description|
|---|---|---|
| `ibexa.search` | `/search` | Search form |
