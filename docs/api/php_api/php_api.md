---
description: Public PHP API exposes the Repository in a number of services and allows creating, reading, updating, managing, and deleting objects.
page_type: reference
---

# PHP API

The [public PHP API](/api/php_api/php_api_reference/index.html) enables you to interact with [[= product_name =]]'s Repository and content model from your PHP code.

You can use it to create, read, update, manage, and delete all objects available in [[= product_name =]], namely content and related objects such as sections, locations, content types, or languages.

The PHP API is built on top of a layered architecture, including a persistence SPI that abstracts storage.
Using the API ensures that your code is forward compatible with future releases based on other storage engines.

## Using API services

The API provides access to content, user, content types, and other features through various services.

The full list of available services covers:

- [BatchOrderService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-BatchOrderServiceInterface.html)
- [CorporateAccountService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CorporateAccount-Service-CorporateAccountService.html) (recommended for company creation)
- [CompanyService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CorporateAccount-Service-CompanyService.html)
- [ContentService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentService.html)
- [ContentTypeService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ContentTypeService.html)
- [FieldTypeService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-FieldTypeService.html)
- [InvitationService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-User-Invitation-InvitationService.html)
- [LanguageService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LanguageService.html)
- [LocationService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-LocationService.html)
- [MemberService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CorporateAccount-Service-MemberService.html)
- [NotificationService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-NotificationService.html)
- [ObjectStateService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-ObjectStateService.html)
- [RoleService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-RoleService.html)
- [SearchService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SearchService.html)
- [SectionService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-SectionService.html)
- [ShippingAddressService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-CorporateAccount-Service-ShippingAddressService.html)
- [SpreadsheetProcessorInterface](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Cart-FileProcessor-SpreadsheetProcessorInterface.html)
- [TaxonomyService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Taxonomy-Service-TaxonomyServiceInterface.html)
- [TranslationService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-TranslationService.html)
- [TrashService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-TrashService.html)
- [URLAliasService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-URLAliasService.html)
- [URLService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-URLService.html)
- [URLWildcardService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-URLWildcardService.html)
- [UserPreferenceService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-UserPreferenceService.html)
- [UserService](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-UserService.html)

You can access the PHP API by injecting relevant services into your code:

- By using [auto-wiring]([[= symfony_doc =]]/service_container/autowiring.html), and the service classname in the `Ibexa\Contracts` namespace (see `bin/console debug:autowiring | grep Ibexa.Contracts`).
- By using [service parameters]([[= symfony_doc =]]/service_container.html#service-parameters), and service aliases (see `bin/console debug:autowiring | grep ibexa.api`).
- By using the repository's `get[ServiceName]()` methods, for example, [`Repository::getContentService()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Repository.html#method_getContentService), or [`getUserService()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Repository.html#method_getUserService).
  (Prefer injecting several Repository's dedicated services instead of the whole Repository if the Repository itself isn't needed.)

!!! caution

    The PHP API's services can be accessed with `Ibexa\Bundle\Core\Controller::getRepository()` by extending it from a [custom controller](controllers.md), but such approach isn't recommended, and you should prefer dependency injection.

## Value objects

The services provide interaction with read-only value objects from the [`Ibexa\Contracts\Core\Repository\Values`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-repository-values.html) namespace.
Those objects are divided into sub-namespaces, such as [`Content`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-repository-values-content.html), [`User`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-repository-values-user.html) or [`ObjectState`](/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-repository-values-objectstate.html).
Each sub-namespace contains a set of value objects,
such as [`Content\Content`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Content.html) or [`User\Role`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-User-Role.html).

Value objects come with their own properties, such as `$content->id` or `$location->hidden`, and with methods that provide access to more related information, such as [`Content\Relation::getSourceContentInfo()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Relation.html#method_getSourceContentInfo) or [`User\Role::getPolicies()`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-User-Role.html#method_getPolicies).

### Creating and updating objects

Value objects fetch data from the repository and are read-only.
To create and modify repository values, use data structures, such as [`ContentService::newContentCreateStruct()`](https://github.com/ibexa/core/blob/v4.6.6/src/contracts/Repository/ContentService.php#L572) or [`LocationService::newLocationUpdateStruct()`](https://github.com/ibexa/core/blob/v4.6.6/src/contracts/Repository/LocationService.php#L238).

### Value info objects

Some complex value objects have an `Info` counterpart, for example [`ContentInfo`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/ContentInfo.php) for [`Content`](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Content.php).
These objects provide you with lower-level information.
For instance, `ContentInfo` contains `currentVersionNo` or `remoteId`, while `Content` enables you to retrieve fields, content type, or previous versions.

!!! note

    The public PHP API value objects should not be serialized.

    Serialization of value objects, for example, `Ibexa\Contracts\Core\Repository\Values\Content\ContentInfo` /  `Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo` or `Ibexa\Contracts\Core\Repository\Values\Content\Location` results in memory limit exceeded error.


## Authentication

One of the responsibilities of the repository is user authentication.
Every action is executed *as* a user.

When you use the PHP API, authentication is performed in three ways:

- [automatically in the back office](#back-office-authentication)
- [by using `sudo()`](#using-sudo)
- by [setting the Repository user](#setting-the-repository-user)

### Back office authentication

When actions are performed through the back office, they're executed as the logged-in user.
This user's permissions affects the behavior of the repository.
The user may, for example, not be allowed to create content, or view a particular section.

### Using `sudo()`

To skip permission checks, you can use the `sudo()` method.
It allows API execution to be performed with full access, sand-boxed.

You can use this method to perform an action that the current user doesn't have permissions for.

For example, to [hide a Location](managing_content.md#hiding-and-revealing-locations), use:

``` php
use Ibexa\Contracts\Core\Repository\Repository;

//...

$hiddenLocation = $repository->sudo(function (Repository $repository) use ($location) {
    return $repository->getLocationService()->hideLocation($location);
});
```

### Setting the repository user

In a command line script, the repository runs as if executed by the anonymous user.
While [using `sudo()`](#using-sudo) is the recommended option, you can also set the current user to a user with necessary permissions to achieve the same effect.

To identify as a different user, you need to use the `UserService` together with `PermissionResolver` (in the example `admin` is the login of the administrator user):

``` php
[[= include_file('code_samples/api/public_php_api/src/Command/CreateContentCommand.php', 55, 57) =]]
```

!!! tip

    [`Ibexa\Contracts\Core\Repository\PermissionService`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-PermissionService.html) can be injected to have a Service which provides both `PermissionResolver` and `PermissionCriterionResolver`.
    It supports auto-wiring.

This isn't required in template functions or controller code, as the HTTP layer takes care of identifying the user, and automatically sets it in the repository.

If you want to identify a user with their credentials instead, provide them in the following way:

``` php
$user = $userService->loadUserByCredentials($username, $password);
$permissionResolver->setCurrentUserReference($user);
```

## Exception handling

PHP API uses [Exceptions](https://www.php.net/exceptions) to handle errors.
Each API method may throw different exceptions, depending on what it does.

It's good practice to cover every exception you expect to happen.

For example if you're using a command which takes the content ID as a parameter, the ID may either not exist, or the referenced content item may not be visible to the user.

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

[[= product_name =]] uses the [Symfony service container]([[= symfony_doc =]]/service_container.html) for dependency resolution.

[Symfony dependency injection]([[= symfony_doc =]]/components/dependency_injection.html) ensures that any required services are available in your custom code (for example, controllers) when you inject them into the constructor.

Symfony service container uses service tags to dedicate services to a specific purpose.
They're usually used for extension points.

[[= product_name =]] uses service tags to expose multiple features.
For example, field types are tagged `ibexa.field_type`.

!!! tip

    For a list of all service tags exposed by Symfony, see its [reference documentation]([[= symfony_doc =]]/reference/dic_tags.html).
