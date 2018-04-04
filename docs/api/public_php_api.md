# eZ Platform Public PHP API

The PHP API is also commonly referred to as the **public API**. Currently it exposes a Repository which allows you to create, read, update, manage and delete all objects available in eZ Platform. First and foremost content, but also related objects like Sections, Locations, Content Types, Content Type groups, languages and so on.

!!! info "API"

    An Application Programming Interface (API) allows you to connect your code to eZ Platform. You can learn the basic idea behind it from [the eZ Blog article](http://ez.no/Blog/How-would-you-explain-what-an-API-is-to-your-mom).
    
## Public API Guide

The public API gives you an easy access to the eZ Platform content repository. This repository is the core component that manages Content, Locations, Sections, Content Types, Users, User groups, and Roles. It also provides a new, clear interface for plugging in custom Field Types.

The public API is built on top of a layered architecture, including a persistence API that abstracts storage. By using the public API, you are sure that your code will be forward compatible with future releases based on enhanced, scalable and high-performance storage engines. Applications based on the public API are also fully backwards compatible by using the included storage engine based on the current kernel and database model.

### About this Guide

The objective of this public API guide is to progressively lead you through useful, everyday business logic, using the API in concrete recipes: obtaining a Location from a Content item, fetching a set of Content items, creating a User, and so on.

For each recipe, newly introduced elements will be explained in detail, including the required API components (services, value objects, etc.).

#### Suggested tools

In addition to this cookbook, we strongly recommend that you use a full featured PHP IDE, such as Eclipse or PHPStorm. It will provide you information on every piece of code you use, including objects and classes documentation. We have paid very careful attention to PHPDoc throughout this API, and such a tool is a very valuable help when using this API.

On top of this, generated public API documentation can be found online, in various formats:

-   doxygen: <http://apidoc.ez.no/doxygen/trunk/NS/html/>
-   sami: <http://apidoc.ez.no/sami/trunk/NS/html/>


## eZ Platform API Repository

This entity is the entry point to everything you do with the public API.

It enables you to create, retrieve, update and delete all the eZ Platform objects, as well as Content Types, Sections, Content states. It is always obtained through the service container.

**Obtaining the eZ Platform Repository via the service container**

``` php
/** @var $repository \eZ\Publish\API\Repository\Repository
$repository = $container->get( 'ezpublish.api.repository' );
```

Repository allows three types of operations: user authentication (getting / changing the current user), issuing transactions, and obtaining services. 

!!! tip "Inline objects documentation"

    Pay attention to the inline `phpdoc` block in this code stub. It tells your IDE that `$repository` is an instance of `\eZ\Publish\API\Repository\Repository`. If your IDE supports this feature, you will get code completion on the `$repository` object. This helper is a huge time saver when it comes to learning about the eZ Platform API.

## The service container

The above code snippet implies that the [service container](http://symfony.com/doc/2.8/service_container.html) is available in the context you are writing your code in.

In controllers, this generally is done by extending the Symfony `Controller` class. It comes with a `get()` method that calls the service container. In command line scripts, it requires that you extend the [`ContainerAwareCommand`](http://api.symfony.com/2.8/Symfony/Bundle/FrameworkBundle/Command/ContainerAwareCommand.html) base class instead of `Controller`. This class provides you with a `getContainer()` method that returns the service container.

!!! note "Getting the repository from eZ Platform controllers"

    In order to make it even easier to obtain the repository from controllers code, eZ Platform controllers extend a custom [Controller](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Bundle/EzPublishCoreBundle/Controller.html) class that provides a [`getRepository()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Bundle/EzPublishCoreBundle/Controller.html#method_getRepository) method which directly returns the Repository from the service container.

    You can and should do the same in your custom controllers.

## Authentication

One of the responsibilities of the Repository is user authentication. Every action will be executed *as* a user. In the context of a normal eZ Platform execution, the logged in user will of course be the current one, identified via one of the available authentication methods. This user's permissions will affect the behavior of the Repository. The user may for example not be allowed to create Content, or view a particular Section.

[Logging in to the Repository](#identifying-to-the-repository-with-a-login-and-a-password) is covered in other recipes of the Cookbook.

## Services

The main entry point to the repository's features are services. The public API breaks down access to Content, User, Content Types and other features into various services. Those services are obtained via the [Repository](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Repository.html), using `get`\[ServiceName\]`()` methods: `getContentService()`, `getUserService()`, etc.

Throughout the Cookbook, you will be guided through the various capabilities those services have, and how you can use them to implement your projects.

## Value objects

The elements (Content, Users) that services provide interaction with are provided as read-only [value objects](http://apidoc.ez.no/doxygen/trunk/NS/html/namespaceeZ_1_1Publish_1_1Core_1_1Repository_1_1Values.html) in the `eZ\Publish\Core\Repository\Values` namespace. Those objects are broken down into sub-namespaces: `Content`, `ContentType`, `User` and `ObjectState`, each sub-namespace containing a set of value objects, such as [`Content\Content`](https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/Core/Repository/Values/Content/Content.php) or [`User\Role`](https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/Core/Repository/Values/User/Role.php).

These objects are read-only by design. They are only meant to be used in order to fetch data from the Repository. They come with their own properties, such as `$content->id`, `$location->hidden`, but also with methods that provide access to more related information, such as `Relation::getSourceContentInfo()` or `Role::getPolicies()`. By design, a value object will only give you access to data that is related to it. More complex retrieval operations will require you to use the appropriate service, using information from your value object.

### Value info objects

Some complex value objects have an `Info` counterpart, like `ContentInfo`, the counterpart for `Content`. These objects are specific and provide you with lower-level information. For instance, `ContentInfo` will provide you with `currentVersionNo` or `remoteId`, while `Content` will let you retrieve Fields, the Content Type, or previous versions.

They are provided by the API, but are **read only**, can't be modified and sent back. Creation and modification of Repository values is done using `getContentCreateStruct()` and `getContentUpdateStruct()`.

## Create and update structs

In order to update or create elements in the Repository, you will use structs. They are usually provided by the service that manages the value objects you want to alter or create. For instance, the Content service has a `getContentCreateStruct()` method that returns a new `ContentCreateStruct` object. Equivalent methods exist for `UpdateStruct` objects as well, and for most value objects.

Using them is covered in the [Creating Content](public_php_api_managing_content.md#creating-content) and [Updating Content](public_php_api_managing_content.md#updating-content) chapters.
