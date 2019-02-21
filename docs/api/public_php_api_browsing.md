# Browsing and viewing Content

You will start by going through the various ways to find and retrieve content from eZ Platform using the API. While this will be covered in further dedicated documentation, it is necessary to explain a few basic concepts of the public API. In the following recipes, you will learn about the general principles of the API as they are introduced in individual recipes.

## Displaying values from a Content item

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

## Loading Content in different languages

Since you didn't specify any language code, your Field object is returned in the given Content item's main language.

If you want to take SiteAccess languages into account:

-   Provide prioritized languages on `load()` this will be taken into account by the returned Content object when retrieving translated properties like fields, for example:
    `$contentService->loadContent( 66, $configResolver->getParameter('languages'));`
    -   `ConfigResolver` is a service, so it can be obtained from Symfony Container or injected directly: `@ezpublish.config.resolver`.

See [below](#siteaccess-aware-repository-optional) for information about SiteAccess-aware repository.

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

### SiteAccess-aware Repository - optional

The SiteAccess-aware repository is an instance of the eZ Platform Repository API which injects prioritised languages for you when you load data *(Content, Location, Content type, etc.)* and don't specify languages to load yourself in API arguments.

Currently it is:

- Available as a private service `ezpublish.siteaccessaware.repository`, including for the other Repository services
- Used out of the box on parameter converters for Content and Location
- Used out of the box on ContentView

Example of code before using SiteAccess-aware repository:

``` php
$content = $this->contentService->loadContent(
    42,
    $this->configResolver->getParameter('languages')
);

$name = $content->getVersionInfo()->getName();
$value = $content->getFieldValue('body')
```

Becomes:

``` php
$content = $this->contentService->loadContent(42);

$name = $content->getVersionInfo()->getName();
$value = $content->getFieldValue('body')
```

## Traversing a Location subtree

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
    // If offset and limit had been specified to something else than "all", then $childLocationList->totalCount contains the total count for iteration use
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

## Viewing Content Metadata

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

### Setting the Repository User

In a command line script, the repository runs as if executed by the anonymous user. In order to identify it as a different user, you need to use the `UserService` together with `PermissionResolver` as follows (in the example `admin` is the login of the administrator user):

``` php
$permissionResolver = $repository->getPermissionResolver();
$user = $userService->loadUserByLogin('admin');
$permissionResolver->setCurrentUserReference($user);
```

This may be crucial when writing maintenance or synchronization scripts.

This is of course not required in template functions or controller code, as the HTTP layer will take care of identifying the user, and automatically set it in the repository.

### The ContentInfo Value Object

You will now load a `ContentInfo` object using the provided ID and use it to get your Content item's metadata

``` php
$contentInfo = $contentService->loadContentInfo( $contentId );
```

### Locations

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

#### Location object with access to Content

You can directly get it by using `$location->getContent()`, it can also be very useful in a Twig via `location.content`. This functionality additionally introduces possibility to specify prioritised languages when loading a Location. Content will be loaded on-demand across result set you are loading (e.g. search and other places you can load several Locations).

### Relations

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

### ContentInfo properties

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

### Owning user

You can use [`UserService::loadUser()`](http://apidoc.ez.no/sami/trunk/NS/html/eZ/Publish/API/Repository/UserService.html#method_loadUser) with Content `ownerId` property of our `ContentInfo` to load the Content's owner as a `User` value object.

``` php
$owner = $userService->loadUser( $contentInfo->ownerId );
$output->writeln( "  <info>Owner:</info> " . $owner->contentInfo->name );
```

To get the current version's creator, and not the content's owner, you need to use the `creatorId` property from the current version's `VersionInfo` object.

### Section

The Section's ID can be found in the `sectionId` property of the `ContentInfo` object. To get the matching Section value object, you need to use the `SectionService::loadSection()` method.

``` php
$section = $sectionService->loadSection( $contentInfo->sectionId );
$output->writeln( "  <info>Section:</info> $section->name" );
```

### Versions

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
