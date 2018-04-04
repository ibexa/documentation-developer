# eZ Platform Public PHP API

The PHP API is also commonly referred to as the **public API**. Currently it exposes a Repository which allows you to create, read, update, manage and delete all objects available in eZ Platform. First and foremost content, but also related objects like Sections, Locations, Content Types, Content Type groups, languages and so on.

!!! info "API"

    An Application Programming Interface (API) allows you to connect your code to eZ Platform. You can learn the basic idea behind it from [the eZ Blog article](http://ez.no/Blog/How-would-you-explain-what-an-API-is-to-your-mom).

### eZ Platform API Repository

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

### The service container

The above code snippet implies that the [service container](http://symfony.com/doc/3.4/service_container.html) is available in the context you are writing your code in.

In controllers, this generally is done by extending the Symfony `Controller` class. It comes with a `get()` method that calls the service container. In command line scripts, it requires that you extend the [`ContainerAwareCommand`](http://api.symfony.com/3.4/Symfony/Bundle/FrameworkBundle/Command/ContainerAwareCommand.html) base class instead of `Controller`. This class provides you with a `getContainer()` method that returns the service container.

!!! note "Getting the repository from eZ Platform controllers"

    In order to make it even easier to obtain the repository from controllers code, eZ Platform controllers extend a custom [Controller](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Bundle/EzPublishCoreBundle/Controller.html) class that provides a [`getRepository()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Bundle/EzPublishCoreBundle/Controller.html#method_getRepository) method which directly returns the Repository from the service container.

    You can and should do the same in your custom controllers.

### Authentication

One of the responsibilities of the Repository is user authentication. Every action will be executed *as* a user. In the context of a normal eZ Platform execution, the logged in user will of course be the current one, identified via one of the available authentication methods. This user's permissions will affect the behavior of the Repository. The user may for example not be allowed to create Content, or view a particular Section.

[Logging in to the Repository](#identifying-to-the-repository-with-a-login-and-a-password) is covered in other recipes of the Cookbook.

### Services

The main entry point to the repository's features are services. The public API breaks down access to Content, User, Content Types and other features into various services. Those services are obtained via the [Repository](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Repository.html), using `get`\[ServiceName\]`()` methods: `getContentService()`, `getUserService()`, etc.

Throughout the Cookbook, you will be guided through the various capabilities those services have, and how you can use them to implement your projects.

### Value objects

The elements (Content, Users) that services provide interaction with are provided as read-only [value objects](http://apidoc.ez.no/doxygen/trunk/NS/html/namespaceeZ_1_1Publish_1_1Core_1_1Repository_1_1Values.html) in the `eZ\Publish\Core\Repository\Values` namespace. Those objects are broken down into sub-namespaces: `Content`, `ContentType`, `User` and `ObjectState`, each sub-namespace containing a set of value objects, such as [`Content\Content`](https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/Core/Repository/Values/Content/Content.php) or [`User\Role`](https://github.com/ezsystems/ezp-next/blob/master/eZ/Publish/Core/Repository/Values/User/Role.php).

These objects are read-only by design. They are only meant to be used in order to fetch data from the Repository. They come with their own properties, such as `$content->id`, `$location->hidden`, but also with methods that provide access to more related information, such as `Relation::getSourceContentInfo()` or `Role::getPolicies()`. By design, a value object will only give you access to data that is related to it. More complex retrieval operations will require you to use the appropriate service, using information from your value object.

#### Value info objects

Some complex value objects have an `Info` counterpart, like `ContentInfo`, the counterpart for `Content`. These objects are specific and provide you with lower-level information. For instance, `ContentInfo` will provide you with `currentVersionNo` or `remoteId`, while `Content` will let you retrieve Fields, the Content Type, or previous versions.

They are provided by the API, but are **read only**, can't be modified and sent back. Creation and modification of Repository values is done using `getContentCreateStruct()` and `getContentUpdateStruct()`.

### Create and update structs

In order to update or create elements in the Repository, you will use structs. They are usually provided by the service that manages the value objects you want to alter or create. For instance, the Content service has a `getContentCreateStruct()` method that returns a new `ContentCreateStruct` object. Equivalent methods exist for `UpdateStruct` objects as well, and for most value objects.

Using them is covered in the [Creating Content](#creating-content) and [Updating Content](#updating-content) chapters.

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

## Getting started with the public API

In this chapter, you will see two ways of customizing eZ Platform: command line scripts (for import scripts, for instance), and custom controllers.

### Symfony bundle

In order to test and use public API code, you will need to build a custom bundle. Bundles are Symfony's extensions, and are therefore also used to extend eZ Platform. Symfony provides code generation tools that will let you create your own bundle and get started in a few minutes.

In this chapter, you will see how to create a custom bundle, and implement both a command line script and a custom route with its own controller action and view. All shell commands assume that you use some Linux shell, but those commands would of course also work on Windows systems.

#### Generating a new bundle

First, change the directory to your eZ Platform root.

``` bash
$ cd /path/to/ezplatform
```

Then use the bin/console application with the `generate:bundle` command to start the bundle generation wizard.

!!! tip

    The `generate:bundle` command is only available in Symfony dev environment.

Follow the instructions provided by the wizard. Your objective is to create a bundle named `EzSystems/Bundles/CookBookBundle`, located in the `src` directory.

``` bash
$ php bin/console generate:bundle
```

The wizard will first ask about your bundle's namespace. Each bundle's namespace should feature a vendor name (for example: `EzSystems`), optionally followed by a sub-namespace (for example: `Bundle`), and end with the actual bundle's name, suffixed with bundle: `CookbookBundle`.

**Bundle namespace**

```
Your application code must be written in bundles. This command helps you generate them easily.

Each bundle is hosted under a namespace (like Acme/Bundle/BlogBundle).

The namespace should begin with a "vendor" name like your company name, your project name, or your client name, followed by one or more optional category sub-namespaces, and it should end with the bundle name itself (which must have Bundle as a suffix).

See http://symfony.com/doc/current/cookbook/bundles/best_practices.html#index-1 for more details on bundle naming conventions.

Use / instead of \ for the namespace delimiter to avoid any problem.

Bundle namespace: EzSystems/CookbookBundle
```

You will then be asked about the Bundle's name, used to reference your bundle in your code. You can go with the default, `EzSystemsCookbookBundle`. Just hit Enter to accept the default.

**Bundle name**

```
In your code, a bundle is often referenced by its name. It can be the concatenation of all namespace parts but it's really up to you to come up with a unique name (a good practice is to start with the vendor name).

Based on the namespace, we suggest EzSystemsCookbookBundle.

Bundle name [EzSystemsCookbookBundle]:
```

The next question is your bundle's location. By default, the script offers to place it in the `src` folder. This is perfectly acceptable unless you have a good reason to place it somewhere else. Just hit Enter to accept the default.

**Bundle directory**

```
The bundle can be generated anywhere. The suggested default directory uses the standard conventions.


Target directory [/path/to/ezpublish5/src]:
```

Next, you need to choose the generated configuration's format, out of YAML, XML, PHP or annotations. In eZ Platform yaml is mostly in use, and you will use it in this cookbook. Enter 'yml', and hit Enter.

**Configuration format**

```
Determine the format to use for the generated configuration.                                                                                                                        

Configuration format (yml, xml, php, or annotation) [annotation]: yml
```

The last choice is to generate code snippets demonstrating the Symfony directory structure. If you're learning Symfony, it is a good idea to accept, as it will create a controller, yaml files, etc.

**Generate snippets & directory structure**

```
To help you get started faster, the command can generate some code snippets for you.

Do you want to generate the whole directory structure [no]? yes
```

The generator will then summarize the previous choices, and ask for confirmation. Hit Enter to confirm.

**Summary and confirmation**

```
You are going to generate a "EzSystems\Bundle\CookbookBundle\EzSystemsCookbookBundle" bundle in "/path/to/ezpublish5/src/" using the "yml" format.

Do you confirm generation [yes]? yes
```

The wizard will generate the bundle, check autoloading, and ask about the activation of your bundle. Hit Enter in the answer to both questions to have your bundle automatically added to your kernel (`app/AppKernel.php`) and routes from your bundle added to the existing routes (`app/config/routing.yml`).

**Activation and generation**

```
  Bundle generation

Generating the bundle code: OK
Checking that the bundle is autoloaded: OK
Confirm automatic update of your Kernel [yes]?
Enabling the bundle inside the Kernel: OK
Confirm automatic update of the Routing [yes]?
Importing the bundle routing resource: OK

  You can now start using the generated code!
 
```

Your bundle should be generated and activated. Let's see how you can interact with the public API by creating a command line script, and a custom controller route and action.

#### Creating a command line script in your bundle

The framework and its bundles ship with a few scripts. They are all started using `php bin/console <command>`. You can get the complete list of existing command line scripts by executing `php bin/console list` from the eZ Platform root.

In this chapter, you will create a new command, identified as `ezplatform:cookbook:hello`, that takes an optional name argument, and greets that name. To do so, you need one thing: a class with a name ending with "Command" that extends `Symfony\Component\Console\Command\Command`. Note that in your case, you use `ContainerAwareCommand` instead of `Command`, since you need the dependency injection container to interact with the public API. In your bundle's directory (`src/EzSystems/CookbookBundle`), create a new directory named `Command`, and in this directory, a new file named `HelloCommand.php`.

Add this code to the file:

**HelloCommand.php**

``` php
<?php
namespace EzSystems\CookBookBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class HelloCommand extends \Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand
{
    /**
     * Configures the command
     */
    protected function configure()
    {
    }

    /**
     * Executes the command
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute( InputInterface $input, OutputInterface $output )
    {
    }
}
```

This is the skeleton for a command line script.

One class with a name ending with "Command" (`HelloCommand`), extends `Symfony\Bundle\FrameworkBundle\Command\Command`, and is part of your bundle's Command namespace. It has two methods: `configure()`, and `execute()`. You also import several classes and interfaces with the use keyword. The first two, `InputInterface` and `OutputInterface` are used to 'typehint' the objects that will allow you to provide input and output management in your script.

`Configure` will be used to set your command's name, as well as its options and arguments. `Execute` will contain the actual implementation of your command. Start by creating the `configure()` method.

**TestCommand::configure()**

``` php
protected function configure()
{
    $this->setName( 'ezplatform:cookbook:hello' );
    $this->setDefinition(
        array(
            new InputArgument( 'name', InputArgument::OPTIONAL, 'An argument' )
        )
    );
}
```

First, you use `setName()` to set your command's name to `ezplatform:cookbook:hello`. Then use `setDefinition()` to add an argument, named `name`, to your command.

You can read more about argument definitions and further options in the [Symfony Console documentation](http://symfony.com/doc/3.4/components/console/introduction.html). Once this is done, if you run `php bin/console list`, you should see `ezpublish:cookbook:hello` listed in the available commands. If you run it, it will however still do nothing.

Add something very simple to your `execute()` method so that your command actually does something.

**TestCommand::execute()**

``` php
protected function execute( InputInterface $input, OutputInterface $output )
{
    // fetch the input argument
    if ( !$name = $input->getArgument( 'name' ) )
    {
        $name = "World";
    }
    $output->writeln( "Hello $name" );
}
```

You can now run the command from the eZ Platform root.

**Hello world**

``` bash
$ php bin/console ezplatform:cookbook:hello world
Hello world
```

#### Creating a custom route with a controller action

In this short chapter, you will see how to create a new route that will catch a custom URL and execute a controller action. You will create a new route, `/cookbook/test`, that displays a simple 'Hello world' message. This tutorial is a simplified version of the official one that can be found on <http://symfony.com/doc/current/book/controller.html>.

During your bundle's generation, you have chosen to generate the bundle with default code snippets. Fortunately, almost everything you need is part of those snippets. You just need to do some editing, in particular in two locations: `src/EzSystems/Resources/CookbookBundle/config/routing.yml` and `src/EzSystems/CookbookBundle/Controllers/DefaultController.php`. The first one will be used to configure your route (`/cookbook/test`) as well as the controller action the route should execute, while the latter will contain the actual action's code.

##### routing.yml

This is the file where you define your action's URL matching. The generated file contains this YAML block:

**Generated routing.yml**

``` yaml
ez_systems_cookbook_homepage:
    path:     /hello/{name}
    defaults: { _controller: EzSystemsCookbookBundle:Default:index }
```

You can safely remove this default code, and replace it with this:

**Edited routing.yml**

``` yaml
ezsystems_cookbook_hello:
    path:     /cookbook/hello/{name}
    defaults: { _controller: EzSystemsCookbookBundle:Default:hello }
```

You defined a route that matches the URI `/cookbook/` and executes the action `hello` in the Default controller of your bundle. The next step is to create this method in the controller.

##### DefaultController.php

This controller was generated by the bundle generator. It contains one method, `helloAction()`, that matched the YAML configuration you have changed in the previous part. Rename the `indexAction()` method so that you end up with this code.

**DefaultController::helloAction()**

``` javascript
public function helloAction( $name )
{
    $response = new \Symfony\Component\HttpFoundation\Response;
    $response->setContent( "Hello $name" );
    return $response;
}
```

 This method receives the parameter defined in `routing.yml`. It is called "name" in the route definition, and must be called $name in the matching action. Since the action is named "hello" in `routing.yml`, the expected method name is `helloAction`.

Controller actions **must** return a Response object that will contain the response's content, the headers, and various optional properties that affect the action's behavior. In your case, you simply set the content, using `setContent()`, to "Hello $name". Go to <http://ezplatform/cookbook/hello/YourName>, and you should get "Hello YourName".

##### The custom EzPublishCoreBundle Controller

For convenience, a custom controller is available at [eZ\\Bundle\\EzPublishCoreBundle\\Controller](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Bundle/EzPublishCoreBundle/Controller.html). It gives you a few commodity methods:

|Method|Description|
|------|-----------|
|`getRepository()`| Returns the public API repository that gives you access to the various services through `getContentService()`, `getLocationService()` etc.|
|`getConfigResolver()`|Returns the [ConfigResolver](http://apidoc.ez.no/doxygen/trunk/NS/html/classeZ_1_1Bundle_1_1EzPublishCoreBundle_1_1DependencyInjection_1_1Configuration_1_1ConfigResolver.html) that gives you access to configuration data.|

You are encouraged to use it for your custom controllers that interact with eZ Platform.

With both command line scripts and HTTP routes, you have the basics you need to start writing public API code.

## Browsing, finding, viewing

You will start by going through the various ways to find and retrieve content from eZ Platform using the API. While this will be covered in further dedicated documentation, it is necessary to explain a few basic concepts of the public API. In the following recipes, you will learn about the general principles of the API as they are introduced in individual recipes.

### Displaying values from a Content item

In this recipe, you will see how to fetch a Content item from the repository, and obtain its Field's content.

Let's first see the full code. You can see the Command line version at <https://github.com/ezsystems/CookbookBundle/blob/master/Command/ViewContentCommand.php>

**Viewing content**

```php
$repository = $this->getContainer()->get( 'ezpublish.api.repository' );
$contentService = $repository->getContentService();
$contentTypeService = $repository->getContentTypeService();
$fieldTypeService = $repository->getFieldTypeService();

try
{
    $content = $contentService->loadContent( 66 );
    $contentType = $contentTypeService->loadContentType( $content->contentInfo->contentTypeId );
    // iterate over the field definitions of the content type and print out each field's identifier and value
    foreach( $contentType->fieldDefinitions as $fieldDefinition )
    {
        $output->write( $fieldDefinition->identifier . ": " );
        $fieldType = $fieldTypeService->getFieldType( $fieldDefinition->fieldTypeIdentifier );
        $field = $content->getField( $fieldDefinition->identifier );

        // We use the Field's toHash() method to get readable content out of the Field
        $valueHash = $fieldType->toHash( $field->value );
        $output->writeln( $valueHash );
    }
}
catch( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e )
{
    // if the id is not found
    $output->writeln( "No content with id $contentId" );
}
catch( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e )
{
    // not allowed to read this content
    $output->writeln( "Anonymous users are not allowed to read content with id $contentId" );
}
```

Let's analyze this code block by block.

``` php
$repository = $this->getContainer()->get( 'ezpublish.api.repository' );
$contentService = $repository->getContentService();
$contentTypeService = $repository->getContentTypeService();
$fieldTypeService = $repository->getFieldTypeService();
```

This is the initialization part. As explained above, everything in the public API goes through the repository via dedicated services. You get the repository from the service container, using the method `get()` of your container, obtained via `$this->getContainer()`. Using your `$repository` variable, fetch the two services you will be using `getContentService()` and `getFieldTypeService()`.

``` php
try
{
    // iterate over the field definitions of the content type and print out each field's identifier and value
    $content = $contentService->loadContent( 66 );
```

Everything starting from line 5 is about getting your Content and iterating over its Fields. You can see that the whole logic is part of a `try/catch` block. Since the public API uses Exceptions for error handling, this is strongly encouraged, as it will allow you to conditionally catch the various errors that may happen. The exceptions that can occur will be covered in a later paragraph.

The first thing you do is use the Content Service to load a Content item using its ID, 66: `$contentService->loadContent ( 66 )`. As you can see on the API doc page, this method expects a Content ID, and returns a [Content value object](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Content.html).

``` php
foreach( $contentType->fieldDefinitions as $fieldDefinition )
{
    // ignore ezpage
    if( $fieldDefinition->fieldTypeIdentifier == 'ezpage' )
        continue;
    $output->write( $fieldDefinition->identifier . ": " );
    $fieldType = $fieldTypeService->getFieldType( $fieldDefinition->fieldTypeIdentifier );
    $fieldValue = $content->getFieldValue( $fieldDefinition->identifier );
    $valueHash = $fieldType->toHash( $fieldValue );
    $output->writeln( $valueHash );
}
```

This block is the one that actually displays the value.

It iterates over the Content item's Fields using the Content Type's Field Definitions (`$contentType->fieldDefinitions`).

For each Field Definition, you start by displaying its identifier (`$fieldDefinition->identifier`). You then get the Field Type instance using the Field Type Service (`$fieldTypeService->getFieldType( $fieldDefinition->fieldTypeIdentifier )`). This method expects the requested Field Type's identifier, as a string (ezstring, ezxmltext, etc.), and returns an `eZ\Publish\API\Repository\FieldType` object.

The Field Value object is obtained using the `getFieldValue()` method of the Content value object which you obtained using `ContentService::loadContent()`.

Using the Field Type object, you can convert the Field Value to a hash using the `toHash()` method, provided by every Field Type. This method returns a primitive type (string, hash) out of a Field instance.

With this example, you should get a first idea on how you interact with the API. Everything is done through services, each service being responsible for a specific part of the repository (Content, Field Type, etc.).

### Loading Content in different languages

Since you didn't specify any language code, your Field object is returned in the given Content item's main language.

If you want to take SiteAccess languages into account:

-   Provide prioritized languages on `load()` this will be taken into account by the returned Content object when retrieving translated properties like fields, for example:
    `$contentService->loadContent( 66, $configResolver->getParameter('languages'));` 
    -   `ConfigResolver` is a service, so it can be obtained from Symfony Container or injected directly: `@ezpublish.config.resolver`.
    -   *Note: As of v2.0 this is planned to be done for you when you don't specify languages.*

Otherwise if you want to use an altogether different language, you can specify a language code in the `getField()` call:

``` php
$content->getFieldValue( $fieldDefinition->identifier, 'fre-FR' )
```

**Exceptions handling**

``` php
catch ( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e )
{
    $output->writeln( "<error>No content with id $contentId found</error>" );
}
catch ( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e )
{
    $output->writeln( "<error>Permission denied on content with id $contentId</error>" );
}
```

As said earlier, the public API uses [Exceptions](http://php.net/exceptions) to handle errors. Each method of the API may throw different exceptions, depending on what it does. Which exceptions can be thrown is usually documented for each method. In our case, `loadContent()` may throw two types of exceptions: `NotFoundException`, if the requested ID isn't found, and `UnauthorizedException` if the currently logged in user isn't allowed to view the requested content.

It is a good practice to cover each exception you expect to happen. In this case, since our Command takes the Content ID as a parameter, this ID may either not exist, or the referenced Content item may not be visible to our user. Both cases are covered with explicit error messages.

### Traversing a Location subtree

This recipe will show how to traverse a Location's subtree. The full code implements a command that takes a Location ID as an argument and recursively prints this location's subtree.

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/BrowseLocationsCommand.php>

In this code the [LocationService](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/LocationService.html) is introduced. This service is used to interact with Locations. You will use two methods from this service: [`loadLocation()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/LocationService.html#method_loadLocation), and [`loadLocationChildren()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/LocationService.html#method_loadLocationChildren).

**Loading a Location**

``` php
try
{
    // load the starting location and browse
    $location = $this->locationService->loadLocation( $locationId );
    $this->browseLocation( $location, $output );
}
catch ( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e )
{
    $output->writeln( "<error>No location found with id $locationId</error>" );
}
catch( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e )
{
    $output->writeln( "<error>Current users are not allowed to read location with id $locationId</error>" );
}
```

As for the ContentService, `loadLocation()` returns a value object, here a `Location`. Errors are handled with exceptions: `NotFoundException` if the Location ID couldn't be found, and `UnauthorizedException` if the current repository user isn't allowed to view this Location.

**Iterating over a Location's children**

``` php
private function browseLocation( Location $location, OutputInterface $output, $depth = 0 )
{
    $childLocationList = $this->locationService->loadLocationChildren( $location, $offset = 0, $limit = 10 );
    // If offset and limit had been specified to something else then "all", then $childLocationList->totalCount contains the total count for iteration use
    foreach ( $childLocationList->locations as $childLocation )
    {
        $this->browseLocation( $childLocation, $output, $depth + 1 );
    }
}
```

`LocationService::loadLocationChildren()` returns a [LocationList](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/LocationList.php) value objects that you can iterate over.

Note that unlike `loadLocation()`, you don't need to care for permissions here: the currently logged-in user's permissions will be respected when loading children, and Locations that can't be viewed won't be returned at all.

!!! note

    Should you need more advanced children fetching methods, the `SearchService` is what you are looking for.

### Viewing Content Metadata

Content is a central piece in the public API. You will often need to start from a Content item, and dig in from its metadata. Basic content metadata is made available through `ContentInfo` objects. This value object mostly provides primitive fields: `contentTypeId`, `publishedDate` or `mainLocationId`. But it is also used to request further Content-related value objects from various services.

The full example implements an `ezplatform:cookbook:view_content_metadata` command that prints out all the available metadata, given a Content ID.

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/ViewContentMetaDataCommand.php>

Several new services are introduced here: [`URLAliasService`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/URLAliasService.html), [`UserService`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/UserService.html) and [`SectionService`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/SectionService.html).

**Services initialization**

``` php
/** @var $repository \eZ\Publish\API\Repository\Repository */
$repository = $this->getContainer()->get( 'ezpublish.api.repository' );
$contentService = $repository->getContentService();
$locationService = $repository->getLocationService();
$urlAliasService = $repository->getURLAliasService();
$sectionService = $repository->getSectionService();
$userService = $repository->getUserService();
```

#### Setting the Repository User

In a command line script, the repository runs as if executed by the anonymous user. In order to identify it as a different user, you need to use the `UserService` together with `PermissionResolver` as follows (in the example `admin` is the login of the administrator user):

``` php
$permissionResolver = $repository->getPermissionResolver();
$user = $userService->loadUserByLogin('admin');
$permissionResolver->setCurrentUserReference($user);
```

This may be crucial when writing maintenance or synchronization scripts.

This is of course not required in template functions or controller code, as the HTTP layer will take care of identifying the user, and automatically set it in the repository.

#### The ContentInfo Value Object

You will now load a `ContentInfo` object using the provided ID and use it to get your Content item's metadata

``` php
$contentInfo = $contentService->loadContentInfo( $contentId );
```

#### Locations

**Getting Content Locations**

``` php
// show all locations of the content
$locations = $locationService->loadLocations( $contentInfo );
$output->writeln( "<info>LOCATIONS</info>" );
foreach ( $locations as $location )
{
    $urlAlias = $urlAliasService->reverseLookup( $location );
    $output->writeln( "  $location->pathString  ($urlAlias->path)" );
}
```

First use `LocationService::loadLocations()` to **get** the **Locations** for `ContentInfo`. This method returns an array of [`Location`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Location.php) value objects. In this example, you print out the Location's path string (/path/to/content). You also use [URLAliasService::reverseLookup()](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/URLAliasService.html#method_reverseLookup) to get the Location's main [URLAlias](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/URLAlias.html).

#### Relations

Now you will list relations from and to your Content. Since relations are versioned, you need to feed the [`ContentService::loadRelations()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentService.html#method_loadRelations) with a `VersionInfo` object. You can get the current version's `VersionInfo` using [`ContentService::loadVersionInfo()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentService.html#method_loadVersionInfo). If you had been looking for an archived version, you could have specified the version number as the second argument to this method.

**Browsing a Content's relations**

``` php
// show all relations of the current version
$versionInfo = $contentService->loadVersionInfo( $contentInfo );
$relations = $contentService->loadRelations( $versionInfo );
if ( !empty( $relations ) )
{
    $output->writeln( "<info>RELATIONS</info>" );
    foreach ( $relations as $relation )
    {
        $name = $relation->destinationContentInfo->name;
        $output->write( "  Relation of type " . $this->outputRelationType( $relation->type ) . " to content $name" );
    }
}
```

You can iterate over the [Relation](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Relation.html) objects array you got from `loadRelations()`, and use these value objects to get data about your relations. It has two main properties: `destinationContentInfo`, and `sourceContentInfo`. They also hold the relation type (embed, common, etc.), and the optional Field this relations is made with.

#### ContentInfo properties

You can of course get your Content item's metadata by using the value object's properties.

**Primitive object metadata**

``` php
// show meta data
$output->writeln( "\n<info>METADATA</info>" );
$output->writeln( "  <info>Name:</info> " . $contentInfo->name );
$output->writeln( "  <info>Type:</info> " . $contentType->identifier );
$output->writeln( "  <info>Last modified:</info> " . $contentInfo->modificationDate->format( 'Y-m-d' ) );
$output->writeln( "  <info>Published:</info> ". $contentInfo->publishedDate->format( 'Y-m-d' ) );
$output->writeln( "  <info>RemoteId:</info> $contentInfo->remoteId" );
$output->writeln( "  <info>Main Language:</info> $contentInfo->mainLanguageCode" );
$output->writeln( "  <info>Always available:</info> " . ( $contentInfo->alwaysAvailable ? 'Yes' : 'No' ) );
```

#### Owning user

You can use [`UserService::loadUser()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/UserService.html#method_loadUser) with Content `ownerId` property of our `ContentInfo` to load the Content's owner as a `User` value object.

``` php
$owner = $userService->loadUser( $contentInfo->ownerId );
$output->writeln( "  <info>Owner:</info> " . $owner->contentInfo->name );
```

To get the current version's creator, and not the content's owner, you need to use the `creatorId` property from the current version's `VersionInfo` object.

#### Section

The Section's ID can be found in the `sectionId` property of the `ContentInfo` object. To get the matching Section value object, you need to use the `SectionService::loadSection()` method.

``` php
$section = $sectionService->loadSection( $contentInfo->sectionId );
$output->writeln( "  <info>Section:</info> $section->name" );
```

#### Versions

To conclude you can also iterate over the Content's version, as `VersionInfo` value objects.

``` php
$versionInfoArray = $contentService->loadVersions( $contentInfo );
if ( !empty( $versionInfoArray ) )
{
    $output->writeln( "\n<info>VERSIONS</info>" );
    foreach ( $versionInfoArray as $versionInfo )
    {
        $creator = $userService->loadUser( $versionInfo->creatorId );
        $output->write( "  Version $versionInfo->versionNo " );
        $output->write( " by " . $creator->contentInfo->name );
        $output->writeln( " " . $this->outputStatus( $versionInfo->status ) . " " . $versionInfo->initialLanguageCode );
    }
}
```

Use the `ContentService::loadVersions()` method to get an array of `VersionInfo` objects.

### Search

This section covers how the [`SearchService`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/SearchService.html) can be used to search for Content, by using a [`Query`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query.html) and a combinations of [`Criteria`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion.html) you will get a [`SearchResult`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Search/SearchResult.html) object back containing list of Content and count of total hits. In the future this object will also include facets, spell checking etc. when running on a backend that supports it *(for instance Solr)*.

!!! note

    To be able to use search API described in this section, you need to create some content (articles, folders) under eZ Platform root.

##### Difference between filter and query

Query object contains two properties you can set criteria on `filter` and `query`. You can mix and match use or use both at the same time, there is one distinction between the two:

-   `query` Has an effect on scoring *(relevancy)* calculation, and also on the default sorting if `sortClause` is not specified, *when used with Solr and Elastic.* Typically `query` is used for `FullText` search criterion, otherwise you can place everything else on `filter`.

#### Performing a simple full text search

!!! tip "Checking feature support per search engine"

    To find out if a given search engine supports advanced full text capabilities, use the [`$searchService->supports($capabilityFlag)`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/SearchService.php#L187-L197) method.

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContentCommand.php>

In this recipe, you will run a simple full text search over every compatible attribute.

##### Query and Criterion objects

Described above`Query` object is used to build up a Content query based on a set of `Criterion` objects.

```php
$query = new \eZ\Publish\API\Repository\Values\Content\Query();
// Use 'query' over 'filter' for FullText to get hit score (relevancy) with Solr/Elastic
$query->query = new Query\Criterion\FullText( $text );
```

Multiple criteria can be grouped together using "logical criteria", such as [LogicalAnd](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/LogicalAnd.html) or [LogicalOr](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/LogicalOr.html). Since in this case you only want to run a text search, simply use a [`FullText`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/FullText.html) criterion object.

The full list of criteria can be found on your installation in the following directory [vendor/ezsystems/ezpublish-kernel/eZ/Publish/API/Repository/Values/Content/Query/Criterion](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/API/Repository/Values/Content/Query/Criterion). Additionally you may look at integration tests like [vendor/ezsystems/ezpublish-kernel/eZ/Publish/API/Repository/Tests/SearchServiceTest.php](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Tests/SearchServiceTest.php) for more details on how these are used.

##### Running the search query and using the results

The `Query` object is given as an argument to [`SearchService::findContent()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/SearchService.html#method_findContent). This method returns a `SearchResult` object. This object provides you with various information about the search operation (number of results, time taken, spelling suggestions, or facets, as well as, of course, the results themselves).

``` php
$result = $searchService->findContent( $query );
$output->writeln( 'Found ' . $result->totalCount . ' items' );
foreach ( $result->searchHits as $searchHit )
{
    $output->writeln( $searchHit->valueObject->contentInfo->name );
}
```

The `searchHits` properties of the `SearchResult` object is an array of `SearchHit` objects. In `valueObject` property of `SearchHit`, you will find the `Content` object that matches the given `Query`.

!!! Tip

    If you you are searching using a unique identifier, for instance using the Content ID or Content remote ID criterion, then you can use [`SearchService::findSingle()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/SearchService.html#method_findSingle), this takes a Criterion and returns a single Content item, or throws a `NotFound` exception if none is found.

#### Retrieving Sort Clauses for parent Location

You can use the method `$parentLocation->getSortClauses()` to return an array of Sort Clauses for direct use on `LocationQuery->sortClauses`.

#### Performing an advanced search

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContent2Command.php>

As explained in the previous chapter, Criterion objects are grouped together using logical criteria. You will now see how multiple criteria objects can be combined into a fine grained search `Query`.

``` php
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query;

// [...]

$query = new Query();
$criterion1 = new Criterion\Subtree( $locationService->loadLocation( 2 )->pathString );
$criterion2 = new Criterion\ContentTypeIdentifier( 'folder' );
$query->filter = new Criterion\LogicalAnd(
    array( $criterion1, $criterion2 )
);

$result = $searchService->findContent( $query );
```

A [`Subtree`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/Subtree.html) criterion limits the search to the subtree with `pathString`, which looks like: `/1/2/`. A [`ContentTypeId`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/ContentTypeId.html) Criterion to limit the search to Content of Content Type 1. Those two criteria are grouped with a `LogicalAnd` operator. The query is executed as before, with `SearchService::findContent()`.

##### Fine-tuning search results

###### `$languageFilter`

The `$languageFilter` parameter provides a prioritized list of languages for the current SiteAccess. Passing it is recommended for front-end use, because otherwise all languages of the Content items will be returned.

Additionally, you can make use of the `useAlwaysAvailable` argument of the `$languageFilter`. This in turn uses the `alwaysAvailable` flag which by default is set on Content Type. When it is set to `true`, it ensures that when a language from the prioritized list can't be matched, the Content will be returned in its main language.

###### `Criterion\Visibility`

`Criterion\Visibility` enables you to ensure that only visible content will be returned.

Note that the criterion behaves differently depending on the method you use, because Locations have visibility, but Content does not. This means that when using the `LocationQuery` (`findLocations($query)`), the method will return the Location, if it is visible. When used with the `Query` (`findContent($query)`), however, the Content item will be returned even if one of its Locations is visible (although others may be hidden). That is why using `Criterion\Visibility` is recommended with `LocationQuery`.

This example shows the usage of both `$languageFilter` and `Criterion\Visibility`:

``` php
$query = new LocationQuery([
    'filter' => new Criterion\LogicalAnd([
    new Criterion\Visibility(Criterion\Visibility::VISIBLE),
    new Criterion\ParentLocationId($parentLocation->id),
    ];),
    'sortClauses' => $parentLocation->getSortClauses(),
]);
$searchService->findLocations($query,
    ['languages' => $configResolver->getParameter('languages')]);
```

#### Performing a fetch like search

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/FindContent3Command.php>

A search isn't only meant for searching, it also provides the interface for what was called "fetch" in previous versions. As this is back-end agnostic, eZ Platform "ezfind" fetch functions are now powered by Solr (or ElasticSearch in experimental, unsupported setups).

Following the examples above you now change it a bit to combine several criteria with both an AND and an OR condition.

``` php
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query;

// [...]

$query = new Query();
$query->filter = new Criterion\LogicalAnd(
    array(
        new Criterion\ParentLocationId( 2 ),
        new Criterion\LogicalOr(
            array(
                new Criterion\ContentTypeIdentifier( 'folder' ),
                new Criterion\ContentTypeId( 2 )
            )
        )
    )
);

$result = $searchService->findContent( $query );
```

A `ParentLocationId` criterion limits the search to the children of Location 2. An array of `ContentTypeId` Criteria to limit the search to Content of Content Type's with ID 1 or 2 grouped in a `LogicalOr` operator. Those two criteria are grouped with a `LogicalAnd` operator. As always the query is executed as before, with `SearchService::findContent()`.

Change the Location filter to use the Subtree criterion filter as shown in the advanced search example above.

##### Using in() instead of OR

The above example is fine, but it can be optimized by taking advantage of the fact that all filter criteria support being given an array of values (IN operator) instead of a single value (EQ operator).

You can also use the [`ContentTypeIdentifier`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Query/Criterion/ContentTypeIdentifier.html) Criterion:

``` php
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query;

// [...]

$query = new Query();
$query->filter = new Criterion\LogicalAnd(
    array(
        new Criterion\ParentLocationId( 2 ),
        new Criterion\ContentTypeIdentifier( array( 'article', 'folder' ) )
    )
);

$result = $searchService->findContent( $query );
```

!!! tip

    All filter criteria are capable of doing an "IN" selection, the `ParentLocationId` above could, for example, have been provided `array( 2, 43 )` to include second level children in both your content tree (2) and your media tree (43).

#### Performing a Faceted Search

!!! note "Under construction"

    Faceted Search is not fully implemented yet.

    -   Implemented Facets SOLR BUNDLE &gt;=1.4: `User, ContentType, and Section` , see:   [![](https://jira.ez.no/images/icons/issuetypes/epic.png)EZP-26465](https://jira.ez.no/browse/EZP-26465?src=confmacro) - Search Facets M1 Development

    You can register [custom facet builder visitors](https://github.com/ezsystems/ezplatform-solr-search-engine/blob/v1.1.1/lib/Resources/config/container/solr/facet_builder_visitors.yml) with Solr for Content(Info) and SOLR BUNDLE &gt;=1.4 Location search.

    **Contribution starting point**

    The link above is also the starting point for contributing visitors for other API [FacetBuilders](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/API/Repository/Values/Content/Query/FacetBuilder) and [Facets](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/API/Repository/Values/Content/Search/Facet) . As for integration tests, fixtures that will need adjustments are found in [ezpublish-kernel](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/API/Repository/Tests/_fixtures/Solr) , and those missing in that link but [defined in SearchServiceTest](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Tests/SearchServiceTest.php#L2474), are basically not implemented yet.

To be able to take advantage of facets, you can set the `Query->facetBuilders` property, which will result in relevant facets being returned on `SearchResult->facets`. All facet builders share the following properties:

|Property|Description|
|--------|-----------|
|`name`| Recommended, to set the human-readable name of the returned facet for use in UI, so if you need translation this value should already be translated.|
|`minCount`| Optional, the minimum of hits of a given grouping, e.g. minimum number of content items in a given facet for it to be returned.|
|`limit`| Optional, Maximum number of facets to be returned; only X number of facets with the greatest number of hits will be returned.|

As an example, apply `UserFacet` to be able to group content according to the creator:

``` php
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\FacetBuilder;

// [...]

$query = new Query();
$query->filter = new Criterion\ContentTypeIdentifier(['article']);
$query->facetBuilders[] = new FacetBuilder\UserFacetBuilder(
    [
        'name' => 'Document owner',
        'type' => FacetBuilder\UserFacetBuilder::OWNER,// Specific to UserFacetBuilder, one of: OWNER, GROUP or MODIFIER
        'minCount' => 2,
        'limit' => 5
    ]
);

$result = $searchService->findContentInfo( $query );
list( $userId, $articleCount ) = $result->facets[0]->entries;
```

#### Performing a pure search count

In many cases you might need the number of Content items matching a search, but with no need to do anything else with the results.

Thanks to the fact that the `searchHits` property of the [`SearchResult`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/Search/SearchResult.html) object always refers to the total amount, it is enough to run a standard search and set `$limit` to 0. This way no results will be retrieved, and the search will not be slowed down, even when the number of matching results is huge.

``` php
use eZ\Publish\API\Repository\Values\Content\Query;

// [...]

$query = new Query();
$query->limit = 0;

// [...] ( Add criteria as shown above )

$resultCount = $searchService->findContent( $query )->totalCount;
```

## Managing Content

In the following recipes, you will see how to create Content.

### Identifying to the repository with a login and a password

As seen earlier, the Repository executes operations with a user's credentials. In a web context, the currently logged-in user is automatically identified. In a command line context, you need to manually log a user in. You have already seen how to manually load and set a user using their login. If you would like to identify a user using their credentials instead, this can be achieved in the following way:

**authentication**

``` php
$permissionResolver = $repository->getPermissionResolver();
$user = $userService->loadUserByCredentials( $username, $password );
$permissionResolver->setCurrentUserReference($user);
```

### Creating content

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/CreateContentCommand.php>

You will now see how to create Content using the public API. This example will work with the default Folder (ID 1) Content Type from eZ Platform.

``` php
/** @var $repository \eZ\Publish\API\Repository\Repository */
$repository = $this->getContainer()->get( 'ezpublish.api.repository' );
$contentService = $repository->getContentService();
$locationService = $repository->getLocationService();
$contentTypeService = $repository->getContentTypeService();
```

First, you need the required services. In this case: `ContentService`, `LocationService` and `ContentTypeService`.

#### The ContentCreateStruct

As explained in [above](#value-info-objects), value objects are read only. Dedicated objects are provided for Update and Create operations: structs, like `ContentCreateStruct` or `UpdateCreateStruct`. In this case, you need to use a `ContentCreateStruct`.

``` php
$contentType = $contentTypeService->loadContentTypeByIdentifier( 'article' );
$contentCreateStruct = $contentService->newContentCreateStruct( $contentType, 'eng-GB' );
```

First get the [`ContentType`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/ContentType/ContentType.html) you want to create a `Content` with. To do so, use [`ContentTypeService::loadContentTypeByIdentifier()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentTypeService.html#method_loadContentTypeByIdentifier), with the wanted `ContentType` identifier, like 'article'. Finally get a `ContentTypeCreateStruct` using [`ContentService::newContentCreateStruct()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentService.html#method_newContentCreateStruct), providing the Content Type and a Locale Code (eng-GB).

#### Setting the fields values

``` php
$contentCreateStruct->setField( 'title', 'My title' );
$contentCreateStruct->setField( 'intro', $intro );
$contentCreateStruct->setField( 'body', $body );
```

Using your create struct, you can now set the values for our Content item's Fields, using the [`setField()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/ContentCreateStruct.html#method_setField) method. For now, you will just set the title. `setField()` for a TextLine Field simply expects a string as input argument. More complex Field Types, like Author or Image, expect different input values.

The `ContentCreateStruct::setField()` method can take several type of arguments.

In any case, whatever the Field Type is, a Value of this type can be provided. For instance, a TextLine\\Value can be provided for a TextLine\\Type. Depending on the Field Type implementation itself, more specifically on the `fromHash()` method every Field Type implements, various arrays can be accepted, as well as primitive types, depending on the Type.

#### Setting the Location

In order to set a Location for your object, you must instantiate a [`LocationCreateStruct`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/LocationCreateStruct.html). This is done with `LocationService::newLocationCreateStruct()`, with the new Location's parent ID as an argument.

``` php
$locationCreateStruct = $locationService->newLocationCreateStruct( 2 );
```

#### Creating and publishing

To actually create your Content in the Repository, you need to use `ContentService::createContent()`. This method expects a `ContentCreateStruct`, as well as a `LocationCreateStruct`. You have created both in the previous steps.

``` php
$draft = $contentService->createContent( $contentCreateStruct, array( $locationCreateStruct ) );
$content = $contentService->publishVersion( $draft->versionInfo );
```

The `LocationCreateStruct` is provided as an array, since a Content item can have multiple Locations.

`createContent()` returns a new Content value object, with one version that has the DRAFT status. To make this Content visible, you need to publish it. This is done using `ContentService::publishVersion()`. This method expects a `VersionInfo` object as its parameter. In your case, simply use the current version from `$draft`, with the `versionInfo` property.

### Updating Content

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/UpdateContentCommand.php>

You will now see how the previously created Content can be updated. To do so, you will create a new draft for your Content, update it using a [`ContentUpdateStruct`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/ContentUpdateStruct.html), and publish the updated Version.

``` php
$contentInfo = $contentService->loadContentInfo( $contentId );
$contentDraft = $contentService->createContentDraft( $contentInfo );
```

To create your draft, you need to load the Content item's ContentInfo using `ContentService::loadContentInfo()`. You can then use `ContentService::createContentDraft()` to add a new Draft to your Content.

``` php
// instantiate a content update struct and set the new fields
$contentUpdateStruct = $contentService->newContentUpdateStruct();
$contentUpdateStruct->initialLanguageCode = 'eng-GB'; // set language for new version
$contentUpdateStruct->setField( 'title', $newTitle );
$contentUpdateStruct->setField( 'body', $newBody );
```

To set the new values for this version, you request a `ContentUpdateStruct` from the `ContentService` using the `newContentUpdateStruct()` method. Updating the values hasn't changed: you use the `setField()` method.

``` php
$contentDraft = $contentService->updateContent( $contentDraft->versionInfo, $contentUpdateStruct );
$content = $contentService->publishVersion( $contentDraft->versionInfo );
```

You can now use `ContentService::updateContent()` to apply your `ContentUpdateStruct` to your draft's `VersionInfo`. Publishing is done exactly the same way as for a new Content, using `ContentService::publishVersion()`.

### Handling translations

In the two previous examples, you set the ContentUpdateStruct's `initialLanguageCode` property. To translate an object to a new language, set the locale to a new one.

#### translating

``` php
$contentUpdateStruct->initialLanguageCode = 'ger-DE';
$contentUpdateStruct->setField( 'title', $newtitle );
$contentUpdateStruct->setField( 'body', $newbody );
```

It is possible to create or update content in multiple languages at once. There is one restriction: only one language can be set a version's language. This language is the one that will get a flag in the Back Office. However, you can set values in other languages for your attributes, using the `setField` method's third argument.

#### update multiple languages

``` php
// set one language for new version
$contentUpdateStruct->initialLanguageCode = 'fre-FR';

$contentUpdateStruct->setField( 'title', $newgermantitle, 'ger-DE' );
$contentUpdateStruct->setField( 'body', $newgermanbody, 'ger-DE' );

$contentUpdateStruct->setField( 'title', $newfrenchtitle );
$contentUpdateStruct->setField( 'body', $newfrenchbody );
```

Since you did not specify a locale for the last two fields, they are set for the `UpdateStruct`'s `initialLanguageCode`, fre-FR.

#### Delete translations

##### Delete translations from a Content item version

To delete translations from a Content item version, use the `deleteTranslationFromDraft` method on `ContentService`.

```
public function deleteTranslationFromDraft(VersionInfo $versionInfo, string $languageCode) : Content
```

This method returns a Content draft without the specified translation.

!!! note

    To remove the main translation, the main language needs to be changed manually
    using the `ContentService::updateContentMetadata` method first.
    Otherwise the method will throw an `\eZ\Publish\API\Repository\Exceptions\BadStateException`.


The PHP API consumer is responsible for creating a Content item version draft and publishing it after translation removal.

Since the returned Content draft is to be published, both search and HTTP cache are already handled
by `PublishVersion` slots once the call to `publishVersion()` is made.

Example:

``` php
$repository->beginTransaction();
/** @var \eZ\Publish\API\Repository\Repository $repository */
try {
    $versionInfo = $contentService->loadVersionInfoById($contentId, $versionNo);
    $contentDraft = $contentService->createContentDraft($versionInfo->contentInfo, $versionInfo);
    $contentDraft = $contentService->deleteTranslationFromDraft($contentDraft->versionInfo, $languageCode);
    $contentService->publishVersion($contentDraft->versionInfo);

    $repository->commit();
} catch (\Exception $e) {
    $repository->rollback();
    throw $e;
}
```

##### delete translation from all versions

To delete a translation from all Content item versions, use the `deleteTranslation` method on `ContentService`.

```
public function deleteTranslation(ContentInfo $contentInfo, $languageCode);
```

This operation is permanent, so the user should be warned about that.

The `deleteTranslation` method emits the [`DeleteTranslationSignal`](https://github.com/ezsystems/ezpublish-kernel/blob/6.13/eZ/Publish/Core/SignalSlot/Signal/ContentService/DeleteTranslationSignal.php).

### Creating Content containing an image

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/CreateImageCommand.php>

As explained above, the `setField()` method can accept various values: an instance of the Field Type's Value class, a primitive type, or a hash. The last two depend on what the `Type::acceptValue()` method is build up to handle. TextLine can, for instance, accept a simple string as an input value. In this example, you will see how to set an Image value.

Let's assume that you use the default image class. Creating your Content, using the Content Type and a `ContentCreateStruct`, has been covered above, and can be found in the full code. Let's focus on how the image is provided.

``` php
$file = '/path/to/image.png';

$value = new \eZ\Publish\Core\FieldType\Image\Value(
    array(
        'path' => '/path/to/image.png',
        'fileSize' => filesize( '/path/to/image.png' ),
        'fileName' => basename( 'image.png' ),
        'alternativeText' => 'My image'
    )
);
$contentCreateStruct->setField( 'image', $value );
```

This time, create your image by directly providing an [`Image\Value`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/Core/FieldType/Image/Value.html) object. The values are directly provided to the constructor using a hash with predetermined keys that depend on each Type. In this case: the path where the image can be found, its size, the file name, and an alternative text.

Images also implement a static [`fromString()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/Core/FieldType/Image/Value.html#method_fromString) method that will, given a path to an image, return an `Image\Value` object.

``` php
$value = \eZ\Publish\Core\FieldType\Image\Value::fromString( '/path/to/image.png' );
```

But as said before, whatever you provide `setField()` with is sent to the `acceptValue()` method. This method really is the entry point to the input formats a Field Type accepts. In this case, you could have provided setField with either a hash, similar to the one you provided the Image\\Value constructor with, or the path to your image, as a string.

``` php
$contentCreateStruct->setField( 'image', '/path/to/image.png' );

// or

$contentCreateStruct->setField( 'image', array(
    'path' => '/path/to/image.png',
    'fileSize' => filesize( '/path/to/image.png' ),
    'fileName' => basename( 'image.png' ),
    'alternativeText' => 'My image'
);
```

### Create Content with XML Text

The XML Text Field Type is not officially supported by eZ Platform, it was replaced by RichText. PlatformUI also does not support WYSIWYG editing of Fields of this type.

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/CreateXmlContentCommand.php>

**Working with XML Text**

!!! warning

    The XML Text is not officially supported, it was replaced by RichText. 

``` php
$xmlText = <<< EOX
<?xml version='1.0' encoding='utf-8'?>
<section>
<paragraph>This is a <strong>image test</strong></paragraph>
<paragraph><embed view='embed' size='medium' object_id='$imageId'/></paragraph>
</section>
EOX;
$contentCreateStruct->setField( 'body', $xmlText );
```

As for the last example above, use the multiple formats accepted by `setField()`, and provide your XML string as is. The only accepted format is internal XML, the one stored in the Legacy database.

!!! note

    The XSD for the internal XML representation can be found in a separate dependency: <https://github.com/ezsystems/ezplatform-xmltext-fieldtype>.

You embed an image in your XML, using the `<embed>` tag, providing an image Content ID as the `object_id` attribute.

!!! note "Using a custom format as input"

    More input formats will be added later. The API for that is actually already available: you simply need to implement the [`XmlText\Input`](https://github.com/ezsystems/ezplatform-xmltext-fieldtype/tree/master/lib/FieldType/XmlText/Input) interface. It contains one method, `getInternalRepresentation()` that must return an internal XML string. Create your own bundle, add your implementation to it, and use it in your code.

``` php
$input = new \My\XmlText\CustomInput( 'My custom format string' );
$contentCreateStruct->setField( 'body', $input );
```

### Deleting Content

``` php
$contentService->deleteContent( $contentInfo );
```

[`ContentService::deleteContent()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentService.html#method_deleteContent) method expects a `ContentInfo` as an argument. It will delete the given Content item, all of its Locations, as well as all of the Content item's Locations' descendants and their associated Content.

!!! caution

    Use with caution as deleted content cannot be recovered.

## Working with Locations

### Adding a new Location to a Content item

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/AddLocationToContentCommand.php>

You have seen earlier how you can create a Location for a newly created `Content`. It is of course also possible to add a new [`Location`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Location.php) to an existing `Content`.

``` php
try
{
    $locationCreateStruct = $locationService->newLocationCreateStruct( $parentLocationId );
    $contentInfo = $contentService->loadContentInfo( $contentId );
    $newLocation = $locationService->createLocation( $contentInfo, $locationCreateStruct );
    print_r( $newLocation );
}
// Content or location not found
catch ( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e )
{
    $output->writeln( $e->getMessage() );
}
// Permission denied
catch ( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e )
{
    $output->writeln( $e->getMessage() );
}
```

This is the required code. As you can see, both the Content Service and the Location Service are involved. Errors are handled the usual way, by intercepting the Exceptions the used methods may throw.

``` php
$locationCreateStruct = $locationService->newLocationCreateStruct( $parentLocationId );
```

Like during creation of a new Content item, you need to get a new `LocationCreateStruct`. You will use it to set your new [`Location`](https://github.com/ezsystems/ezpublish-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Location.php)'s properties. The new Location's parent ID is provided as a parameter to `LocationService::newLocationCreateStruct`.

In this example, the default values for the various `LocationCreateStruct` properties are used. You could of course have set custom values, like setting the Location as hidden ($location-&gt;hidden = true), or changed the remoteId (`$location->remoteId = $myRemoteId`).

``` php
$contentInfo = $contentService->loadContentInfo( $contentId );
```

To add a Location to a Content item, you need to specify the Content, using a [`ContentInfo`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/ContentInfo.html) object. Load one using `ContentService::loadContentInfo()`, using the Content ID as the argument.

``` php
$newLocation = $locationService->createLocation( $contentInfo, $locationCreateStruct );
```

Finally use `LocationService::createLocation()`, providing the `ContentInfo` obtained above, together with your `LocationCreateStruct`. The method returns the newly created Location value object.

### Hide/Unhide Location

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/HideLocationCommand.php>

As mentioned earlier a Location's visibility could be set while creating the Location, using the hidden property of the `LocationCreateStruct`. Changing a Location's visibility may have a large impact in the Repository: doing so will affect the Location's subtree visibility. For this reason, a `LocationUpdateStruct` doesn't let you toggle this property. You need to use the `LocationService` to do so.

``` php
$hiddenLocation = $locationService->hideLocation( $location );
$unhiddenLocation = $locationService->unhideLocation( $hiddenLocation );
```

There are two methods for this: `LocationService::hideLocation`, and `LocationService::unhideLocation()`. Both expect the `LocationInfo` as their argument, and return the modified Location value object.

The explanation above is valid for most Repository objects. Modification of properties that affect other parts of the system will require that you use a custom service method.

### Deleting a Location

Deleting Locations can be done in two ways: delete, or trash.

``` php
$locationService->deleteLocation( $locationInfo );
```

[`LocationService::deleteLocation()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/LocationService.html#method_deleteLocation) will permanently delete the Location, as well as all its descendants. Content that has only one Location will be permanently deleted as well. Those with more than one won't be, as they are still referenced by at least one Location.

``` php
$trashService->trash( $locationInfo );
```

`TrashService::trash()` will send the Location as well as all its descendants to the trash, where they can be found and restored until the Trash is emptied. Content isn't affected at all, since it is still referenced by the trash items.

The `TrashService` can be used to list, restore and delete Locations that were previously sent to trash using [`TrashService::trash()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/TrashService.html#method_trash).

### Setting a content item's main Location

This is done using the `ContentService`, by updating the `ContentInfo` with a `ContentUpdateStruct` that sets the new main location:

``` php
$repository = $this->getContainer()->get( 'ezpublish.api.repository' );
$contentService = $repository->getContentService();
$contentInfo = $contentService->loadContentInfo( $contentId );

$contentUpdateStruct = $contentService->newContentMetadataUpdateStruct();
$contentUpdateStruct->mainLocationId = 123;

$contentService->updateContentMetadata( $contentInfo, $contentUpdateStruct );
```

## Other recipes

### Assigning Section to content

!!! note "Full code"

    [https://github.com/ezsystems/CookbookBundle/tree/master/Command/AssignContentToSectionCommand.php](https://github.com/docb22/ez-publish-cookbook/tree/master/EzSystems/CookBookBundle/Command/AssignContentToSectionCommand.php)

The Section that a Content item belongs to can be set during creation, using the `ContentCreateStruct::$sectionId` property. However, as for many Repository objects properties, the Section can't be changed using a `ContentUpdateStruct`. The reason is still the same: changing a Content item's Section will affect the subtrees referenced by its Locations. For this reason, it is required that you use the `SectionService`. to change the Section of a Content item.

**assign section to content**

``` php
$contentInfo = $contentService->loadContentInfo( $contentId );
$section = $sectionService->loadSection( $sectionId );
$sectionService->assignSection( $contentInfo, $section );
```

This operation involves the `SectionService`, as well as the `ContentService`.

**assign section to content**

``` php
$contentInfo = $contentService->loadContentInfo( $contentId );
```

Use `ContentService::loadContentInfo()` to get the Content you want to update the Section for.

**assign section to content**

``` php
$section = $sectionService->loadSection( $sectionId );
```

`SectionService::loadSection()` is then used to load the Section you want to assign your Content to. Note that there is no `SectionInfo` object. Sections are quite simple, and you don't need to separate their metadata from their actual data. However, `SectionCreateStruct` and [`SectionUpdateStruct`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/Content/SectionUpdateStruct.html) objects must still be used to create and update Sections.

**assign section to content**

``` php
$sectionService->assignSection( $contentInfo, $section );
```

The actual update operation is done using `SectionService::assignSection()`, with the `ContentInfo` and the Section as arguments.

`SectionService::assignSection()` won't return the updated Content, as it has no knowledge of those objects. To get the Content with the newly assigned Location, you need to reload the `ContentInfo` using [`ContentService::loadContentInfo()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentService.html#method_loadContentInfo). This is also valid for descendants of the Content item. If you have any stored in your execution state, you need to reload them. Otherwise you would be using outdated Content data.

### Creating a Content Type

!!! note "Full code"

    <https://github.com/ezsystems/CookbookBundle/blob/master/Command/CreateContentTypeCommand.php>

Creating a `ContentType` is actually almost more complex than creating Content. It really isn't as common, and does not require the same kind of API as Content.

Let's split the code in three major parts.

``` php
try
{
    $contentTypeGroup = $contentTypeService->loadContentTypeGroupByIdentifier( 'content' );
}
catch ( \eZ\Publish\API\Repository\Exceptions\NotFoundException $e )
{
    $output->writeln( "content type group with identifier $groupIdentifier not found" );
    return;
}


$contentTypeCreateStruct = $contentTypeService->newContentTypeCreateStruct( 'mycontenttype' );
$contentTypeCreateStruct->mainLanguageCode = 'eng-GB';
$contentTypeCreateStruct->nameSchema = '<title>';
$contentTypeCreateStruct->names = array(
    'eng-GB' => 'My content type'
);
$contentTypeCreateStruct->descriptions = array(
    'eng-GB' => 'Description for my content type',
);
```

First, you need to load the `ContentTypeGroup` your `ContentType` will be created in. You do this using [`ContentTypeService::loadContentTypeGroupByIdentifier()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentTypeService.html#method_loadContentTypeGroupByIdentifier), which gives you back a `ContentTypeGroup` object. As for content, you then request a `ContentTypeCreateStruct` from the `ContentTypeService`, using `ContentTypeService::newContentTypeCreateStruct()`, with the desired identifier as the argument.

Using the create struct's properties, you can set the Type's properties:

-   the main language (`mainLanguageCode`) for the Type is set to eng-GB,
-   the content name generation pattern (`nameSchema`) is set to '&lt;title&gt;': Content items of this type will be named the same as their 'title' field.
-   the human-readable name for your Type is set using the `names` property. You give it a hash, indexed by the locale ('eng-GB') the name is set in. This locale must exist in the system.
-   the same way that you have set the `names` property, you can set human-readable descriptions, again as hashes indexed by locale code.

The next big part is to add `FieldDefinition` objects to your Content Type.

```php
// add a TextLine Field with identifier 'title'
$titleFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( 'title', 'ezstring' );
$titleFieldCreateStruct->names = array( 'eng-GB' => 'Title' );
$titleFieldCreateStruct->descriptions = array( 'eng-GB' => 'The Title' );
$titleFieldCreateStruct->fieldGroup = 'content';
$titleFieldCreateStruct->position = 10;
$titleFieldCreateStruct->isTranslatable = true;
$titleFieldCreateStruct->isRequired = true;
$titleFieldCreateStruct->isSearchable = true;
$contentTypeCreateStruct->addFieldDefinition( $titleFieldCreateStruct );


// add a TextLine Field body field
$bodyFieldCreateStruct = $contentTypeService->newFieldDefinitionCreateStruct( 'body', 'ezstring' );
$bodyFieldCreateStruct->names = array( 'eng-GB' => 'Body' );
$bodyFieldCreateStruct->descriptions = array( 'eng-GB' => 'Description for Body' );
$bodyFieldCreateStruct->fieldGroup = 'content';
$bodyFieldCreateStruct->position = 20;
$bodyFieldCreateStruct->isTranslatable = true;
$bodyFieldCreateStruct->isRequired = true;
$bodyFieldCreateStruct->isSearchable = true;
$contentTypeCreateStruct->addFieldDefinition( $bodyFieldCreateStruct );
```

You need to create a `FieldDefinitionCreateStruct` object for each `FieldDefinition` your `ContentType` will be made of. Those objects are obtained using [`ContentTypeService::newFieldDefinitionCreateStruct()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/ContentTypeService.html#method_newFieldDefinitionCreateStruct). This method expects the `FieldDefinition` identifier and its type as arguments. The identifiers match the ones from eZ Publish 4 (`ezstring` for TextLine, etc.).

Each field's properties are set using the create struct's properties:

-   `names` and `descriptions` are set using hashes indexed by the locale code, and with the name or description as an argument.
-   The `fieldGroup` is set to 'content'
-   Fields are ordered using the `position` property, ordered numerically in ascending order. It is set to an integer.
-   The translatable, required and searchable boolean flags are set using their respective property: `isTranslatable`, `isRequired` and `isSearchable`.

Once the properties for each create struct are set, the field is added to the Content Type create struct using [`ContentTypeCreateStruct::addFieldDefinition()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/Values/ContentType/ContentTypeCreateStruct.html#method_addFieldDefinition).

``` php
try
{
    $contentTypeDraft = $contentTypeService->createContentType( $contentTypeCreateStruct, array( $contentTypeGroup ) );
    $contentTypeService->publishContentTypeDraft( $contentTypeDraft );
}
catch ( \eZ\Publish\API\Repository\Exceptions\UnauthorizedException $e )
{
    $output->writeln( "<error>" . $e->getMessage() . "</error>" );
}
catch ( \eZ\Publish\API\Repository\Exceptions\ForbiddenException $e )
{
    $output->writeln( "<error>" . $e->getMessage() . "</error>" );
}
```

The last step is the same as for Content: create a Content Type draft using `ContentTypeService::createContentType()`, with the `ContentTypeCreateStruct` and an array of `ContentTypeGroup` objects are arguments. Then publish the Content Type draft using `ContentTypeService::publishContentTypeDraft()`.
