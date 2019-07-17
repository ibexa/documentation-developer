# Public PHP API

The Public PHP API enables you to interact with eZ Platform's Repository and content model from your PHP code.

You can use it to create, read, update, manage, and delete all objects available in eZ Platform, namely 
content and related objects such as Sections, Locations, Content Types, languages, etc.

The PHP API is built on top of a layered architecture, including a persistence SPI that abstracts storage.
Using the API ensures that your code will be forward compatible with future releases based on other storage engines.

!!! tip

    For more information see a [presentation about eZ Platform API.](https://alongosz.github.io/ezconf2018-api/)

## Using API services

You can access the PHP API by injecting relevant services into your code.

The API provides access to Content, User, Content Types and other features through various services.
Those services are obtained using `get[ServiceName]()` methods: `getContentService()`, `getUserService()`, etc.

The full list of available services covers:

- ContentService
- ContentTypeService
- FieldTypeService
- LanguageService
- LocationService
- NotificationService
- ObjectStateService
- RoleService
- SearchService
- SectionService
- TranslationService
- TrashService
- URLAliasService
- URLService
- URLWildcardService
- UserPreferenceService
- UserService

## Value objects

The services provide interaction with read-only value objects from the `eZ\Publish\API\Repository\Values` namespace.
Those objects are divided into sub-namespaces: `Content`, `ContentType`, `User` and `ObjectState`.
Each sub-namespace contains a set of value objects,
such as [`Content\Content`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.2/eZ/Publish/API/Repository/Values/Content/Content.php)
or [`User\Role`](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.2/eZ/Publish/API/Repository/Values/User/Role.php).

Value objects come with their own properties, such as `$content->id` or `$location->hidden`,
as well as with methods that provide access to more related information,
such as `Relation::getSourceContentInfo()` or `Role::getPolicies()`.

### Creating and updating objects

Value objects serve to fetch data from the Repository and are read-only.
To create and modify Repository values you need to use structs, such as `getContentCreateStruct()` or `getContentUpdateStruct()`.

### Value info objects

Some complex value objects have an `Info` counterpart, for example `ContentInfo` for `Content`.
These objects provide you with lower-level information.
For instance, `ContentInfo` contains `currentVersionNo` or `remoteId`,
while `Content` enables you to retrieve Fields, Content Type, or previous versions.

## Authentication

One of the responsibilities of the Repository is user authentication. Every action is executed *as* a user.

When using the PHP API, authentication is performed in three ways:
- [automatically in the Back Office](#back-office-authentication)
- [using `sudo()`](#using-sudo)
- by [setting the Repository user](#setting-the-repository-user)

### Back Office authentication

When actions are performed through the Back Office, they are executed as the logged-in user.
This user's permissions will affect the behavior of the Repository.
The user may, for example, not be allowed to create Content, or view a particular Section.

### Using `sudo()`

To skip permission checks, you can use the `sudo()` method.
It allows API execution to be performed with full access, sand-boxed.

You can use this method to perform an action that the current user does not have permissions for.

For example, to [hide a Location](public_php_api_locations.md#hideunhide-location), use:

``` php
use eZ\Publish\API\Repository\Repository;

$hiddenLocation = $repository->sudo(function (Repository $repository) use ($location) {
    return $repository->getLocationService()->hideLocation($location);
});
```

### Setting the Repository user

In a command line script, the Repository runs as if executed by the anonymous user.
While [using `sudo()`](#using-sudo) is the recommended option,
you can also set the current user to a user with necessary permissions to achieve the same effect.

In order to identify as a different user, you need to use the `UserService` together with `PermissionResolver`
(in the example `admin` is the login of the administrator user):

``` php
$permissionResolver = $repository->getPermissionResolver();
$user = $userService->loadUserByLogin('admin');
$permissionResolver->setCurrentUserReference($user);
```

This is not required in template functions or controller code,
as the HTTP layer takes care of identifying the user, and automatically sets it in the repository.

If you want to identify a user with their credentials instead, provide them in the following way:

``` php
$permissionResolver = $repository->getPermissionResolver();
$user = $userService->loadUserByCredentials($username, $password);
$permissionResolver->setCurrentUserReference($user);
```
