---
description: Public PHP API exposes the Repository in a number of services and allows creating, reading, updating, managing, and deleting objects.
---

# PHP API

The public PHP API enables you to interact with [[= product_name =]]'s Repository and content model from your PHP code.

You can use it to create, read, update, manage, and delete all objects available in [[= product_name =]], namely
content and related objects such as Sections, Locations, Content Types, languages, etc.

The PHP API is built on top of a layered architecture, including a persistence SPI that abstracts storage.
Using the API ensures that your code will be forward compatible with future releases based on other storage engines.

!!! tip

    For more information see a [presentation about [[= product_name =]] API.](https://alongosz.github.io/ezconf2018-api/)

## Using API services

You can access the PHP API by injecting relevant services into your code.

The API provides access to Content, User, Content Types and other features through various services.
Those services are obtained using `get[ServiceName]()` methods: `getContentService()`, `getUserService()`, etc.

The full list of available services covers:

- CompanyService
- [ContentService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentService.php)
- [ContentTypeService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ContentTypeService.php)
- [FieldTypeService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/FieldTypeService.php)
- [InvitationService](https://github.com/ibexa/user/blob/main/src/contracts/Invitation/InvitationService.php)
- [LanguageService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LanguageService.php)
- [LocationService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/LocationService.php)
- MemberService
- [NotificationService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/NotificationService.php)
- [ObjectStateService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/ObjectStateService.php)
- [RoleService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/RoleService.php)
- [SearchService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/SearchService.php)
- [SectionService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/SectionService.php)
- ShippingAddressService
- TaxonomyService
- [TranslationService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/TranslationService.php)
- [TrashService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/TrashService.php)
- [URLAliasService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/URLAliasService.php)
- [URLService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/URLService.php)
- [URLWildcardService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/URLWildcardService.php)
- [UserPreferenceService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/UserPreferenceService.php)
- [UserService](https://github.com/ibexa/core/blob/main/src/contracts/Repository/UserService.php)

## Value objects

The services provide interaction with read-only value objects from the `Ibexa\Contracts\Core\Repository\Values` namespace.
Those objects are divided into sub-namespaces, such as `Content`, `User` or `ObjectState`.
Each sub-namespace contains a set of value objects,
such as [`Content\Content`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Content.php) or [`User\Role`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/User/Role.php).

Value objects come with their own properties, such as `$content->id` or `$location->hidden`,
as well as with methods that provide access to more related information,
such as `Relation::getSourceContentInfo()` or `Role::getPolicies()`.

### Creating and updating objects

Value objects fetch data from the Repository and are read-only.
To create and modify Repository values you need to use structs, such as `getContentCreateStruct()` or `getContentUpdateStruct()`.

### Value info objects

Some complex value objects have an `Info` counterpart,
for example [`ContentInfo`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentInfo.php)
for [`Content`.](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Content.php)
These objects provide you with lower-level information.
For instance, `ContentInfo` contains `currentVersionNo` or `remoteId`,
while `Content` enables you to retrieve Fields, Content Type, or previous versions.

!!! note

    The Public API value objects should not be serialized.

    Serialization of value objects, for example, `Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo` /  `Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo` 
    or `Ibexa\Contracts\Core\Repository\Values\Content\Location` results in memory limit exceeded error.


## Authentication

One of the responsibilities of the Repository is user authentication. Every action is executed *as* a user.

When using the PHP API, authentication is performed in three ways:

- [automatically in the Back Office](#back-office-authentication)
- [using `sudo()`](#using-sudo)
- by [setting the Repository user](#setting-the-repository-user)

### Back Office authentication

When actions are performed through the Back Office, they are executed as the logged-in User.
This User's permissions will affect the behavior of the Repository.
The User may, for example, not be allowed to create content, or view a particular Section.

### Using `sudo()`

To skip permission checks, you can use the `sudo()` method.
It allows API execution to be performed with full access, sand-boxed.

You can use this method to perform an action that the current User does not have permissions for.

For example, to [hide a Location](managing_content.md#hiding-and-revealing-locations), use:

``` php
use Ibexa\Contracts\Core\Repository\Repository;

//...

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
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentCommand.php', 50, 52) =]]
```

!!! tip

    `Ibexa\Contracts\Core\Repository\PermissionService` can be injected to have a Service which provides both `PermissionResolver` and `PermissionCriterionResolver`. It supports auto-wiring.    

This is not required in template functions or controller code,
as the HTTP layer takes care of identifying the user, and automatically sets it in the repository.

If you want to identify a user with their credentials instead, provide them in the following way:

``` php
$user = $userService->loadUserByCredentials($username, $password);
$permissionResolver->setCurrentUserReference($user);
```

## Exception handling

PHP API uses [Exceptions](http://php.net/exceptions) to handle errors.
Each API method may throw different exceptions, depending on what it does.

It is good practice to cover every exception you expect to happen.

For example if you are using a command which takes the Content ID as a parameter,
the ID may either not exist, or the referenced Content item may not be visible to the user.

Both cases should be covered with error messages:

``` php
try {
    // ...
    } catch (\Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException $e) {
        $output->writeln("<error>No content with id $contentId found</error>");
    } catch (\Ibexa\Contracts\Core\Repository\Exceptions\UnauthorizedException $e) {
        $output->writeln("<error>Permission denied on content with id $contentId</error>");
    }
```

## Service container

[[= product_name =]] uses the [Symfony service container]([[=symfony_doc=]]/service_container.html) for dependency resolution.

[Symfony dependency injection]([[=symfony_doc=]]/components/dependency_injection.html) ensures that any required services are available in your custom code
(for example, controllers) when you inject them into the constructor.

Symfony service container uses service tags to dedicate services to a specific purpose. They are usually used for extension points.

[[= product_name =]] exposes multiple features using service tags, for example, Field Types.

!!! tip

    For a list of all service tags exposed by Symfony, see its [reference documentation]([[=symfony_doc=]]/reference/dic_tags.html).
