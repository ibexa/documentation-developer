# Repository

The content Repository is where all your content is stored.

## Locations

A Content item could not function in the system without having a place – a Location – assigned to it. When a new Content item is published, a new Location is automatically created and the item is placed in it.

Together, all Locations form a tree which is the basic way of organizing Content in the system and specific to eZ Platform. Every published Content item has a Location and, as a consequence, also a place in this tree.

A Content item receives a Location only once it has been published. This means that a freshly created draft does not have a Location yet.

A Content item can have more than one Location. This can be used to have the same content in two or more places in the tree, for example an article at the same time on the front page and in the archive. Even in such a case, one of these places is always the main Location.

The tree is hierarchical, with an empty root Location (which is not assigned any Content item) and a structure of dependent Locations below it. Every Location (aside from the root) has one parent Location and can have any number of children. There are no Locations outside this tree.

### Top level Locations

Top level Locations are direct children of the root of the tree. The root has Location ID 1, is not related to any Content items and should not be used directly.

Under this root there are preset top level Locations in each installation which cannot be deleted:

![Content and Media top Locations](img/content_structure_media_library.png)

#### Content

"Content" is the top level Location for the actual contents of a site. This part of the tree is typically used for organizing folders, articles, information pages, etc. This means that it contains the actual content structure of the site, which can be viewed by selecting the "Content structure" tab in the Content mode interface. The default ID number of the "Content" Location is 2; it references a "Folder" Content item.

#### Media

"Media" is the top level Location which stores and organizes information that is frequently used by Content items located below the "Content" node. It usually contains images, animations, documents and other files. They can be viewed by selecting the "Media library" tab in the Content mode interface. The default ID number of the "Media" Location is 43; it references a "Folder" Content item.

#### Users

![Users in admin panel](img/admin_panel_users.png)

"Users" is the top level Location that contains the built-in system for managing User accounts. A User is simply a Content item of the "User account" Content Type. The Users are organized within "User Group" Content items below this Location. In other words, the "Users" Location contains the actual Users and User Groups, which can be viewed by selecting the "Users" tab in the Admin Panel. The default identification number of the "Users" Location is 5; it references a "User Group" Content item.

#### Other top level Locations

Another top level location, with the ID 48, corresponds to "Setup" and is not regularly used to store content.

You should not add any more content directly below Location 1, but instead store any content under one of those top-level Locations.

### Location visibility

Location visibility is a mechanism which allows you to control which parts of the content tree are available to the visitor.

Given that once a Content item is published, it cannot be un-published, limiting visibility is the only method used to withdraw content from the website without moving it to Trash. When the Location of a Content item is hidden, any access to it will be denied, preventing the system from displaying it.

Visibility does not need to be set individually for every Location. Instead, when a Location is hidden, all of its descendants in the tree will be hidden as well. This means that a Location can have one of three different visibility statuses:

- Visible
- Hidden
- Hidden by superior

By default all Locations are Visible. If a Location is made invisible manually, its status is set to Hidden. At the same time all Locations under it will change status to Hidden by superior.

From the visitor's perspective a Location behaves the same whether its status is Hidden or Hidden by superior – it will be unavailable in the website. The difference is that a Location Hidden by superior cannot be revealed manually. It will only become visible once all of its ancestor Locations are made Visible again.

A Hidden by superior status does not override a Hidden status. This means that if a Location is Hidden manually and later one of its ancestors is Hidden as well, the first Location's status does not change – it remains Hidden (not Hidden by superior). If the ancestor Location is made visible again, the first Location still remains Hidden.

The way visibility works can be illustrated using the following scenarios:

##### Hiding a visible Location

![Hiding a visible Location](img/node_visibility_hide.png)

When you hide a Location that was visible before, it will get the status Hidden. Underlying Locations will be marked Hidden by superior. The visibility status of underlying Locations that were already Hidden or Hidden by superior will not be changed.

##### Hiding a Location which is Hidden by superior

![Hiding a Location which is Hidden by superior](img/node_visibility_hide_invisible.png)

When you explicitly hide a Location which was Hidden by superior, it will get the status Hidden. Since the underlying Locations are already either Hidden or Hidden by superior, their visibility status will not be changed.

##### Revealing a Location with a visible ancestor

![Revealing a Location with a visible ancestor](img/node_visibility_unhide1.png)

When you reveal a Location which has a visible ancestor, this Location and its children will become visible. However, underlying Locations that were explicitly hidden by a user will retain the Hidden status (and their children will be remain Hidden by superior).

##### Revealing a Location with a Hidden ancestor

![Revealing a Location with a Hidden ancestor](img/node_visibility_unhide2.png)

When you reveal a Location that has a Hidden ancestor, it will **not** become Visible itself. Because it still has invisible ancestors, its status will change to Hidden by superior.

!!! tip "In short"

    A Location can only be Visible when all of its ancestors are Visible as well.

#### Visibility mechanics

The visibility mechanics are controlled by two flags: Hidden flag and Invisible flag. The Hidden flag informs whether the node has been hidden by a user or not. A raised Invisible flag means that the node is invisible either because it was hidden by a user or by the system. Together, the flags represent the three visibility statuses:

|Hidden flag|Invisible flag|Status|
|------|------|------|
|-|-|The Location is visible.|
|1|1|The Location is invisible and it was hidden by a user.|
|-|1|The Location is invisible and it was hidden by the system because its ancestor is hidden/invisible.|

!!! caution "Visibility and permissions"

    The Location visibility flag is not permission-based and thus acts as a simple potential filter. **It is not meant to restrict access to content**.

    If you need to restrict access to a given Content item, use **Sections** or other **Limitations**, which are permission-based.

## Content Relations

Content items are located in a tree structure through the Locations they are placed in. However, Content items themselves can also be related to one another.

A Relation can be created between any two Content items in the Repository. This feature is typically used in situations when you need to connect and/or reuse information that is scattered around in the system. For example, it allows you to add images to news articles. Instead of using a fixed set of image attributes, the images are stored as separate Content items outside the article.

There are different types of Relations available in the system. First of all, content can be related on item or on Field level.

Relations at Field level are created using one of two special Field Types: Content relation (single) and Content relations (multiple). As the names suggest, such Fields allow you to select one or more other Content items in the Field value, which will be linked to these Fields. Content relation (single) is an example of a one-to-one relationship, and Content relations (multiple) – a one-to-many relationship.

Relations at item level can be of three different types:

1. Common relations are created between two Content items using the Public API.
1. RichText linked relations are created using a Field of the RichText type. Whenever an internal link (a link to another Location or Content item) is inserted into a Field represented by this Field Type, the system will automatically create a relation of this type. Note that such a relation is automatically removed from the system when the corresponding link is removed from the Content item.
1. RichText embedded relations also use a RichText Field. Whenever an Embed element is inserted into a Field represented by this Field Type, the system will automatically create a relation of this type, that is relate the embedded Content item to the one that is being edited. Note that a relation of this type is automatically removed from the system when the corresponding element is removed.

## Sections

Sections are used to divide Content items in the tree into groups that are more easily manageable by content editors. Division into Sections allows you, among others, to set permissions for only a part of the tree.

Technically, a Section is a number, a name and an identifier. Content items are placed in Sections by being assigned the Section ID, with one item able to be in only one Section.

When a new Content item is created, its Section ID is set to the default Section (which is usually Standard). When the item is published it is assigned to the same Section as its parent. Because Content must always be in a Section, unassigning happens by choosing a different Section to move it into. If a Content item has multiple Location assignments then it is always the Section ID of the item referenced by the parent of the main Location that will be used. In addition, if the main Location of a Content item with multiple Location assignments is changed then the Section ID of that item will be updated.

When content is moved to a different Location, the item itself and all of its subtree will be assigned to the Section of the new Location. Note that it works only for copy and move; assigning a new section to a parent's Content does not affect the subtree, meaning that Subtree cannot currently be updated this way.

Sections can only be removed if no Content items are assigned to them. Even then, it should be done carefully. When a Section is deleted, it is only its definition itself that will be removed. Other references to the Section will remain and thus the system will most likely lose consistency. That is why removing Sections may corrupt permission settings, template output and other things in the system.

Section ID numbers are not recycled. If a Section is removed, its ID number will not be reused when a new Section is created.

![Sections screen](img/admin_panel_sections.png)

## Content Repository configuration

The default storage engine for the Repository is called Legacy storage engine.

You can define several Repositories within a single application. However, you can only use one per site.

### Configuration examples

#### Using default values

``` yaml
# ezplatform.yml
ezpublish:
    repositories:
        # Defining Repository with alias "main"
        # Default storage engine is used, with default connection
        # Equals to:
        # main: { storage: { engine: legacy, connection: <defaultConnectionName> } }
        main: ~

    system:
        # All members of my_siteaccess_group will use "main" Repository
        # No need to set "repository", it will take the first defined Repository by default
        my_siteaccess_group:
            # ...
```

If no Repository is specified for a SiteAccess or SiteAccess group, the first Repository defined under `ezpublish.repositories` will be used.

#### All explicit

``` yaml
# ezplatform.yml
doctrine:
    dbal:
        default_connection: my_connection_name
        connections:
            my_connection_name:
                driver:   pdo_mysql
                host:     localhost
                port:     3306
                dbname:   my_database
                user:     my_user
                password: my_password
                charset:  UTF8

            another_connection_name:
                # ...

ezpublish:
    repositories:
        first_repository: { storage: { engine: legacy, connection: my_connection_name, config: {} } }
        second_repository: { storage: { engine: legacy, connection: another_connection_name, config: {} } }

    # ...

    system:
        my_first_siteaccess:
            repository: first_repository

            # ...

        my_second_siteaccess:
            repository: second_repository
```

#### Legacy storage engine

Legacy storage engine uses [Doctrine DBAL](http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/) (Database Abstraction Layer). Database settings are supplied by [DoctrineBundle](https://github.com/doctrine/DoctrineBundle). As such, you can refer to [DoctrineBundle's documentation](https://github.com/doctrine/DoctrineBundle/blob/master/Resources/doc/configuration.rst#doctrine-dbal-configuration).

!!! note "ORM"

    Doctrine ORM is **not** provided by default. If you want to use it, you will need to add `doctrine/orm` as a dependency in your `composer.json`.

### Field groups configuration

Field groups, used in content and Content Type editing, can be configured from the `repositories` section. Values entered there are field group *identifiers*:

``` yaml
repositories:
    default:
        fields_groups:
            list: [content, features, metadata]
            default: content
```

These identifiers can be given human-readable values and translated. Those values are used when editing Content Types. The translation domain is `ezplatform_fields_groups`.
This file will define English names for field groups:

``` yaml
# app/Resources/translations/ezplatform_fields_groups.en.yml
content: Content
metadata: Metadata
user_data: User data
```

### Limit of archived Content item versions

`default_version_archive_limit` controls the number of archived versions per Content item that will be stored in the Repository, by default set to 5. This setting is configured in the following way (typically in `ezplatform.yml`):

``` yaml
ezpublish:
    repositories:
        default:
            options:
                default_version_archive_limit: 10
```

This limit is enforced on publishing a new version and only covers archived versions, not drafts.

!!! tip

    Don't set `default_version_archive_limit` too high, with Legacy storage engine you'll get performance degradation if you store too many versions. Default value of 5 is in general the recommended value, but the less content you have overall, the more you can increase this to, for instance, 25 or even 50.

## Persistence cache

![SPI cache diagram](img/spi_cache.png)

#### Layers

Persistence cache can best be described as an implementation of `SPI\Persistence` that decorates the main backend implementation *(currently: "Legacy Storage Engine")*.

As shown in the illustration, this is done in the exact same way as the SignalSlot feature is a custom implementation of `API\Repository` decorating the main Repository. In the case of Persistence Cache, instead of sending events on calls passed on to the decorated implementation, most of the load calls are cached, and calls that perform changes purge the affected caches. Cache handlers *(Memcached, Redis, Filesystem, etc.)* can configured using Symfony configuration. For how to reuse this Cache service in your own custom code, see below.

#### Transparent cache

With the persistence cache, just like with the HTTP cache, eZ Platform tries to follow principles of "Transparent caching", this can shortly be described as a cache which is invisible to the end user and to the admin/editors of eZ Platform where content is always returned "fresh". In other words, there should be no need to manually clear the cache like it was frequently the case with eZ Publish 4.x. This is possible thanks to an interface that follows CRUD *(Create Read Update Delete)* operations per domain, and the fact that the number of other operations capable of affecting a certain domain is kept to a minimum.

##### Entity stored only once

To make the transparent caching principle as effective as possible, entities are, as much as possible, only stored once in cache by their primary id. Lookup by alternative identifiers (`identifier`, `remoteId`, etc.) is only cached with the identifier as cache key and primary `id` as its cache value, and compositions *(list of objects)* usually keep only the array of primary IDs as their cache value.

This means a couple of things:

- Memory consumption is kept low
- Cache purging logic is kept simple (For example: `$sectionService->delete( 3 )` clears `section/3` cache entry)
- Lookup by `identifier` and list of objects needs several cache lookups to be able to assemble the result value
- Cache warmup usually takes several page loads to reach full as identifier is first cached, then the object

#### What is cached?

Persistence cache aims at caching most `SPI\Persistence` calls used in common page loads, including everything needed for permission checking and URL alias lookups.

Notes:

- `UrlWildCardHandler` is not currently cached
- Currently in case of transactions this is handled very simply by clearing all cache on rollback, this can be improved in the future if needed.
- Some tree/batch operations will cause clearing all persistence cache, this will be improved in the future when we change to a cache service cable of cache tagging.
- Search is not defined as Persistence and the queries themselves are not planned to be cached. Use [Solr](search.md#solr-bundle) which does this for you to improve scale and offload your database.

*For further details on which calls are cached or not, and where/how to contribute additional caches, check out the [source](https://github.com/ezsystems/ezpublish-kernel/tree/master/eZ/Publish/Core/Persistence/Cache).*

### Persistence cache configuration

!!! note

    Current implementation uses Symfony cache. It technically supports the following cache backends:
    [APCu, Array, Chain, Doctrine, Filesystem, Memcached, PDO & Doctrine DBAL, Php Array, Proxy, Redis](https://symfony.com/doc/current/components/cache/cache_pools.html#creating-cache-pools).
    We recommend using Redis for clustering and Filesystem for single server.

*Use of Memcached or Redis is a requirement for use in Clustering setup. For an overview of this feature, see [Clustering](clustering.md).*

!!! note

    When eZ Platform changes to another PSR-6 based cache system in the future, then configuration documented below will change.

**Cache service**

The cache system is exposed as a "cache" service, and can be reused by any other service as described in the [Using Cache service](repository.md#using-cache-service) section.

#### Configuration

By default, configuration currently uses **FileSystem** to store cache files, which is defined in [`default_parameters.yml`](https://github.com/ezsystems/ezplatform/blob/2.0/app/config/default_parameters.yml#L22).
You can select a different cache backend and configure it's parameters in the relevant file in the `cache_pool` folder.

##### Multi Repository setup

In `ezplatform.yml` you can specify which cache pool you want to use on a SiteAccess or SiteAccess group level. The following example shows use in a SiteAccess group:

``` yaml
# ezplatform.yml site group setting
ezpublish:
    system:
        # "site_group" refers to the group configured in site access
        site_group:
            # by default cache service is set to cache.app via parameter '%env(CACHE_POOL)%'
            cache_service_name: '%env(CACHE_POOL)%'
```

!!! note "One cache pool for each Repository"

    If your installation has several Repositories *(databases)*, make sure every group of sites using different Repositories also uses a different cache pool.

#### Redis

This cache backend is using [Redis, a in-memory data structure store](http://redis.io/), via [Redis pecl extension](https://pecl.php.net/package/redis). This is an alternative cache solution for [multi-server (cluster) setups](clustering.md), besides using Memcached.

See [Redis Cache Adapter in Symfony documentation](https://symfony.com/doc/3.4/components/cache/adapters/redis_adapter.html#configure-the-connection)
for information on how to configure Redis.

!!! note

    To use this, you need to set `cache_service_name` to `cache.redis`.

**Example**

``` yaml
services:
    cache.redis:
        parent: cache.adapter.redis
        tags:
            - name: cache.pool
              clearer: cache.app_clearer
              provider: 'redis://secret@example.com:1234/13'
```

!!! caution "Clearing Redis cache"

    The regular `php app/console cache:clear` command does not clear Redis persistence cache.
    To clear it, use the console command shipped with Redis: `redis-cli flushall`.

#### Memcached

This cache backend is using [Memcached, a distributed caching solution](http://memcached.org/). This is the main supported cache solution for [multi server (cluster) setups](clustering.md), besides using Redis.

See [Memcached Cache Adapter in Symfony documentation](https://symfony.com/doc/3.4/components/cache/adapters/memcached_adapter.html#configure-the-connection)
for information on how to configure Memcached.

!!! note

    To use this, you need to set `cache_service_name` to `cache.memcached`.

Example:

``` yaml
services:
    cache.memcached:
        parent: cache.adapter.memcached
        tags:
            - name: cache.pool
              clearer: cache.app_clearer
              provider: 'memcached://user:pass@localhost?weight=33'
```

!!! caution "Connection errors issue"

    If Memcached does display connection errors when using the default (ascii) protocol, then switching to binary protocol *(in the configuration and Memcached daemon)* should resolve the issue.

### Using Cache Service

Using the internal cache service allows you to use an interface and to not have to care whether the system has been configured to place the cache in Memcached or on File system. And as eZ Platform requires that instances use a cluster-aware cache in Cluster setup, you can safely assume your cache is shared *(and invalidated)* across all web servers.

!!! note

    Current implementation uses a caching library called TagAwareAdapter which implements `Psr\Cache\CacheItemPoolInterface`,
    and therefore is compatible with PSR-6.

!!! caution "Use unique vendor prefix for Cache key"

    When reusing the cache service within your own code, it is very important to not conflict with the cache keys used by others. That is why the example of usage below starts with a unique `myApp` key. For the namespace of your own cache, you must do the same! So never clear cache using the cache service without your key specified, otherwise you'll clear all cache.

##### Get Cache service

##### Via Dependency injection

In your Symfony services configuration you can simply define that you require the "cache" service in your configuration like so:

``` yaml
# yml configuration
    myApp.myService:
        class: %myApp.myService.class%
        arguments:
            - @ezpublish.cache_pool
```

The "cache" service is an instance of `Symfony\Component\Cache\Adapter\TagAwareAdapter` and implements the `Psr\Cache\CacheItemPoolInterface` interface.

##### Via Symfony Container

Like any other service, it is also possible to get the "cache" service via container like so:

``` php
// Getting the cache service in PHP

/** @var \Symfony\Component\Cache\Adapter\TagAwareAdapterInterface */
$pool = $container->get('ezpublish.cache_pool');
```

#### Using the cache service

Example usage of the cache service:

``` php
// Example
$cacheItem = $pool->getItem("myApp-object-${id}");
if ($cacheItem->isHit()) {
    return $cacheItem->get();
}

$myObject = $container->get('my_app.backend_service')->loadObject($id)
$cacheItem->set($myObject);
$cacheItem->tag(['myApp-category-' . $myObject->categoryId]);
$pool->save($cacheItem);

return $myObject;
```

For more info on usage, take a look at [Symfony Cache's documentation](https://symfony.com/doc/3.4/components/cache.html).

#### Clearing Persistence cache

Persistence cache uses a separate Cache Pool decorator which by design prefixes cache keys with "ez\_spi". Clearing persistence cache can thus be done in the following way:

``` php
// getting the cache service in php

/** @var $cacheService \eZ\Publish\Core\Persistence\Cache\CacheServiceDecorator */
$cacheService = $container->get('ezpublish.cache_pool.spi.cache.decorator');
 
// To clear all cache (not recommended without a good reason)
$pool->clear();

// To clear a specific cache item (check source for more examples in eZ\Publish\Core\Persistence\Cache\*)
$pool->deleteItems(["ez-content-info-$contentId"]);

// Symfony cache is tag-based, so you can clear all cache related to a Content item like this:
$pool->invalidateTags(["content-$contentId"]);
```

## Services: Public API

The Public API exposes Symfony services for all of its Repository services.

| Service ID                           | Type                                           |
|--------------------------------------|------------------------------------------------|
| `ezpublish.api.service.content`      | `eZ\Publish\API\Repository\ContentService`     |
| `ezpublish.api.service.content_type` | `eZ\Publish\API\Repository\ContentTypeService` |
| `ezpublish.api.service.field_type`   | `eZ\Publish\API\Repository\FieldTypeService`   |
| `ezpublish.api.service.language`     | `eZ\Publish\API\Repository\LanguageService`    |
| `ezpublish.api.service.location`     | `eZ\Publish\API\Repository\LocationService`    |
| `ezpublish.api.service.object_state` | `eZ\Publish\API\Repository\ObjectStateService` |
| `ezpublish.api.service.role`         | `eZ\Publish\API\Repository\RoleService`        |
| `ezpublish.api.service.search`       | `eZ\Publish\API\Repository\SearchService`      |
| `ezpublish.api.service.section`      | `eZ\Publish\API\Repository\SectionService`     |
| `ezpublish.api.service.trash`        | `eZ\Publish\API\Repository\TrashService`       |
| `ezpublish.api.service.url`          | `eZ\Publish\API\Repository\URLService`         |
| `ezpublish.api.service.url_alias`    | `eZ\Publish\API\Repository\URLAliasService`    |
| `ezpublish.api.service.url_wildcard` | `eZ\Publish\API\Repository\URLWildcardService` |
| `ezpublish.api.service.user`         | `eZ\Publish\API\Repository\UserService`        |

## SignalSlots

The SignalSlot system provides a means for realizing loosely coupled dependencies in the sense that a code entity A can react on an event occurring in code entity B, without A and B knowing each other directly. This works by dispatching event information through a central third instance, the so called dispatcher:

![SignalSlots diagram](img/signal_slots_diagram.png)

In the shown schematics, object B and one other object are interested in a certain Signal. B is a so-called Slot that can be announced to be interested in receiving a Signal (indicated by the circular connector to the dispatcher). Object A now sends the corresponding Signal. The Dispatcher takes care of realizing the dependency and informs the Slot A (and one other Slot) about the occurrence of the Signal.

Signals roughly equal events, while Slots roughly equal event handlers. An arbitrary number (0…n) of Slots can listen for a specific Signal. Every object that receives the Dispatcher as a dependency can send Signals. However, the following conditions apply (that typically do not apply to event handling systems):

- A Slot cannot return anything to the object that issued a Signal
- It is not possible for a Slot to stop the propagation of a Signal, i.e. all listening Slots will eventually receive the Signal

Those two conditions allow the asynchronous processing of Slots. That means: It is possible to determine, by configuration, that a Slot must not receive a Signal in the very same moment it occurs, but to receive it on a later point in time, maybe after other Signals from a queue have been processed or even on a completely different server.

### Signal

A Signal represents a specific event, e.g. that a content version has been published. It consists of information that is significant to the event, e.g. the content ID and version number. Therefore, a Signal is represented by an object of a class that is specific to the Signal and that extends from `eZ\Publish\Core\SignalSlot\Signal`. The full qualified name of the Signal class is used to uniquely identify the Signal. For example, the class `eZ\Publish\Core\SignalSlot\Signal\ContentService\PublishVersionSignal` identifies the example Signal.

In order to work properly with asynchronous processing, Signals must not consist of any logic and must not contain complex data structures (such as further objects and resources). Instead, they must be exportable using the `__set_state()` method, so that it is possible to transfer a Signal to a different system.

!!! note

    Signals can theoretically be sent by any object that gets hold of a SignalDispatcher (`eZ\Publish\Core\SignalSlot\SignalDispatcher`). However, at a first stage, **Signals are only sent by special implementations of the Public API to indicate core events**. These services must and will be used by default and will wrap the original service implementations.

### Slot

A Slot extends the system by realizing functionality that is executed when a certain Signal occurs. To implement a Slot, you must create a class that derives from `eZ\Publish\Core\SignalSlot\Slot`. The full qualified name of the Slot class is also used as the unique identifier of the Slot. The Slot base class requires you to implement the single method `receive()`. When your Slot is configured to listen to a certain Signal and this Signal occurs, the `receive()` method of your Slot is called.

Inside the `receive()` method of your Slot you can basically realize any kind of logic. However, it is recommended that you only dispatch the action to be triggered to a dedicated object. This allows you to trigger the same action from within multiple Slots and to re-use the implementation from a completely different context.

Note that, due to the nature of SignalSlot, the following requirements must be fulfilled by your Slot implementation:

- A Slot must not return anything to the Signal issuer
- A Slot must be aware that it is potentially executed delayed or even on a different server

**Important**: A single Slot should not take care of processing more than one Signal. Instead, if you need to trigger same or similar actions as different Signals occur. You should encapsulate these actions into a dedicated class, of which your Slots receive an instance to trigger this action.

### Example: Updating URL aliases

Updating URL aliases is a typical process that can be realized through a SignalSlot extension for different reasons:

- The action must be triggered on basis of different events (e.g. content update, location move, etc.)
- Direct implementation would involve complex dependencies between otherwise unrelated services
- The action is not critical to be executed immediately, but can be made asynchronous, if necessary

As a first step it needs to be determined for which Signals we need to listen in order to update URL aliases. Some of them are:

- `eZ\Publish\Core\SignalSlot\Signal\ContentService\PublishVersionSignal`
- `eZ\Publish\Core\SignalSlot\Signal\LocationService\CopySubtreeSignal`
- `eZ\Publish\Core\SignalSlot\Signal\LocationService\MoveSubtreeSignal`
- ...

There are of course additional Signals that trigger an update of URL aliases, but these are left out for simplicity here.

Now that we identified some Signals to react upon, we can start implementing Slots for these Signals. For the first Signal, which is issued as soon as a new version of Content is published, there exists a method in `eZ\Publish\SPI\Persistence\Content\UrlAlias\Handler` for exactly that purpose: `publishUrlAliasForLocation()`. The Signal contains the ID of the Content item and its newly published version number. Using this information, the corresponding Slot can fulfill its purposes with the following steps:

1. Load the corresponding content and its locations
1. Call the URL alias creation method for each location

To achieve this, the Slot has 2 dependencies:

- `eZ\Publish\SPI\Persistence\Content\Handler`
    to load the content itself in order to retrieve the names
- `eZ\Publish\SPI\Persistence\Content\Location\Handler`
    to load the locations
- `eZ\Publish\SPI\Persistence\Content\UrlAlias\Handler`
    to create the aliases for each location

So, a stub for the implementation could look like this:

``` php
namespace Acme\TestBundle\Slot;

use eZ\Publish\Core\SignalSlot\Slot as BaseSlot;
use eZ\Publish\API\Repository\Repository;
use eZ\Publish\SignalSlot\Signal;

class CreateUrlAliasesOnPublishSlot extends BaseSlot
{
    /**
     * @var \eZ\Publish\API\Repository\Repository
     */
    private $repository;
    public function __construct( Repository $repository )
    {
        $this->repository = $repository;
    }

    public function receive( Signal $signal )
    {
        if ( !$signal instanceof Signal\ContentService\PublishVersionSignal )
        {
            return;
        }
        // Load content
        // Load locations
        // Create URL aliases
    }
}
```

!!! note

    In order to make the newly created Slot react on the corresponding Signal, the following steps must be performed:

    1.  Make the Slot available through the Symfony service container as a service
    1.  Register the Slot to react to the Signal of type `eZ\Publish\Core\SignalSlot\Signal\ContentService\PublishVersionSignal`

    See the [Listening to Core events](../cookbook/listening_to_core_events.md) recipe in the developer cookbook for more information.

!!! note "Important note about template matching"

    **Template matching will NOT work if your content contains a Field Type that is not supported by the Repository**. It can be the case when you are in the process of a migration from eZ Publish 4.x, where custom datatypes have been developed.

    In this case the Repository will throw an exception, which is caught in the `ViewController`, and *if* you are using LegacyBridge it will end up doing a [fallback to legacy kernel](https://doc.ez.no/display/EZP/Legacy+template+fallback).

    The list of Field Types supported out of the box [is available here](../api/field_type_reference.md).

## Signals Reference

This section references **all available Signals** that you can listen to, triggered by ("Public") Repository API in eZ Platform.

For more information, check the [SignalSlots](#signal-slots) section and the [Listening to Core events](../cookbook/listening_to_core_events.md) recipe.

All Signals are relative to `eZ\Publish\Core\SignalSlot\Signal` namespace.

!!! note "Transactions"

    Signals are sent after transactions are executed, making Signals transaction safe.


#### ContentService

|Signal type|Properties|Triggered by|
|------|------|------|
|`ContentService\AddRelationSignal`|`srcContentId` (source contentId, aka referrer)</br>`srcVersionNo`</br>`dstContentId` (destination contentId, aka target)|`ContentService::addRelation()`|
|`ContentService\AddTranslationInfoSignal`|N/A|`ContentService::addTranslationInfo()`|
|`ContentService\CopyContentSignal`|`srcContentId` (original content ID)</br>`srcVersionNo`</br>`dstContentId` (contentId of the copy)</br>`dstVersionNo`</br>`dstParentLocationId` (locationId where the content has been copied)|`ContentService::copyContent()`|
|`ContentService\CreateContentDraftSignal`|`contentId`</br>`versionNo`</br>`userId` (ID of User used to create the draft, or null - current User)|`ContentService::createContentDraft()`|
|`ContentService\CreateContentSignal`|`contentId`</br>`versionNo`|`ContentService::createContent()`|
|`ContentService\DeleteContentSignal`|`contentId`</br>`affectedLocationIds`|`ContentService::deleteContent()`|
|`ContentService\DeleteRelationSignal`|`srcContentId`</br>`srcVersionNo`</br>`dstContentId`|`ContentService::deleteRelation()`|
|`ContentService\DeleteTranslationSignal`|`contentId`</br>`languageCode`|`ContentService::deleteTranslation()`|
|`ContentService\DeleteVersionSignal`|`contentId`</br>`versionNo`|`ContentService::deleteVersion()`|
|`ContentService\PublishVersionSignal`|`contentId`</br>`versionNo`|`ContentService::publishVersion()`|
|`ContentService\TranslateVersionSignal`|`contentId`</br>`versionNo`</br>`userId`|`ContentService::translationVersion()`|
|`ContentService\UpdateContentMetadataSignal`|`contentId`|`ContentService::updateContentMetadata()`|
|`ContentService\UpdateContentSignal`|`contentId`</br>`versionNo`|`ContentService::updateContent()`|

#### ContentTypeService

|Signal type|Properties|Triggered by|
|------|------|------|
|`ContentTypeService\AddFieldDefinitionSignal`|`contentTypeDraftId`|<p>`ContentTypeService::addFieldDefinition()`</p>|
|`ContentTypeService\AssignContentTypeGroupSignal`|`contentTypeId`</br>`contentTypeGroupId`|`ContentTypeService::assignContentTypeGroup()`|
|`ContentTypeService\CopyContentTypeSignal`|`contentTypeId`</br>`userId`|`ContentTypeService::copyContentType()`|
|`ContentTypeService\CreateContentTypeDraftSignal`|`contentTypeId`|`ContentTypeService::createContentTypeDraft()`|
|`ContentTypeService\CreateContentTypeGroupSignal`|`groupId`|`ContentTypeService::createContentTypeGroup()`|
|`ContentTypeService\CreateContentTypeSignal`|`contentTypeId`|`ContentTypeService::createContentType()`|
|`ContentTypeService\DeleteContentTypeGroupSignal`|`contentTypeGroupId`|`ContentTypeService::deleteContentTypeGroup()`|
|`ContentTypeService\DeleteContentTypeSignal`|`contentTypeId`|`ContentTypeService::deleteContentType()`|
|`ContentTypeService\PublishContentTypeDraftSignal`|`contentTypeDraftId`|`ContentTypeService::publishContentTypeDraft()`|
|`ContentTypeService\RemoveFieldDefinitionSignal`|`contentTypeDraftId`</br>`fieldDefinitionId`|`ContentTypeService::removeFieldDefinition()`|
|`ContentTypeService\UnassignContentTypeGroupSignal`|`contentTypeId`</br>`contentTypeGroupId`|`ContentTypeService::unassignContentTypeGroup()`|
|`ContentTypeService\UpdateContentTypeDraftSignal`|`contentTypeDraftId`|`ContentTypeService::updateContentTypeDraft()`|
|`ContentTypeService\UpdateContentTypeGroupSignal`|`contentTypeGroupId`|`ContentTypeService::updateContentTypeGroup()`|
|`ContentTypeService\UpdateFieldDefinitionSignal`|`contentTypeDraftId`</br>`fieldDefinitionId`|`ContentTypeService::updateFieldDefinition()`|

#### LanguageService

|Signal type|Properties|Triggered by|
|------|------|------|
|`LanguageService\CreateLanguageSignal`|`languageId`|`LanguageService::createLanguage()`|
|`LanguageService\DeleteLanguageSignal`|`languageId`|`LanguageService::deleteLanguage()`|
|`LanguageService\DisableLanguageSignal`|`languageId`|`LanguageService::disableLanguage()`|
|`LanguageService\EnableLanguageSignal`|`languageId`|`LanguageService::enableLanguage()`|
|`LanguageService\UpdateLanguageNameSignal`|`languageId`</br>`newName`|`LanguageService::updateLanguageName()`|

#### LocationService

|Signal type|Properties|Triggered by|
|------|------|------|
|`LocationService\CopySubtreeSignal`|`subtreeId` (top locationId of the subtree to be copied)</br>`targetParentLocationId`</br>`targetNewSubtreeId`|`LocationService::copySubtree()`|
|`LocationService\CreateLocationSignal`|`contentId`</br>`locationId`</br>`parentLocationId`|`LocationService::createLocation()`|
|`LocationService\DeleteLocationSignal`|`contentId`</br>`locationId`</br>`parentLocationId`|`LocationService::deleteLocation()`|
|`LocationService\HideLocationSignal`|`contentId`</br>`locationId`</br>`currentVersionNo`</br>`parentLocationId`|`LocationService::hideLocation()`|
|`LocationService\UnhideLocationSignal`|`contentId`</br>`locationId`</br>`currentVersionNo`</br>`parentLocationId`|`LocationService::unhideLocation()`|
|`LocationService\MoveSubtreeSignal`|`subtreeId`</br>`oldParentLocationId`</br>`newParentLocationId`|`LocationService::moveSubtree()`|
|`LocationService\SwapLocationSignal`|`content1Id`</br>`location1Id`</br>`parentLocation1Id`</br>`content2Id`</br>`location2Id`</br>`parentLocation1Id`|`LocationService::swapLocation()`|
|`LocationService\UpdateLocationSignal`|`contentId`</br>`locationId`</br>`parentLocationId`|`LocationService::updateLocation()`|

#### ObjectStateService

|Signal type|Properties|Triggered by|
|------|------|------|
|`ObjectStateService\CreateObjectStateGroupSignal`|`objectStateGroupId`|`ObjectStateService::createObjectStateGroup()`|
|`ObjectStateService\CreateObjectStateSignal`|`objectStateGroupId`</br>`objectStateId`|`ObjectStateService::createObjectState()`|
|`ObjectStateService\DeleteObjectStateGroupSignal`|`objectStateGroupId`|`ObjectStateService::deleteObjectStateGroup()`|
|`ObjectStateService\DeleteObjectStateSignal`|`objectStateId`|`ObjectStateService::deleteObjectState()`|
|`ObjectStateService\SetContentStateSignal`|`contentId`</br>`objectStateGroupId`</br>`objectStateId`|`ObjectStateService::setContentState()`|
|`ObjectStateService\SetPriorityOfObjectStateSignal`|`objectStateId`</br>`priority`|`ObjectStateService::setPriorityOfObjectState()`|
|`ObjectStateService\UpdateObjectStateGroupSignal`|`objectStateGroupId`|`ObjectStateService::updateObjectStateGroup()`|
|`ObjectStateService\UpdateObjectStateSignal`|`objectStateId`|`ObjectStateService::updateObjectState()`|

#### RoleService

|Signal type|Properties|Triggered by|
|------|------|------|
|`RoleService\AddPolicyByRoleDraftSignal`|`roleId`</br>`policyId`|`RoleService::addPolicyByRoleDraft()`|
|`RoleService\AddPolicySignal`|`roleId`</br>`policyId`|`RoleService::addPolicy()`|
|`RoleService\AssignRoleToUserGroupSignal`|`roleId`</br>`userGroupId`</br>`roleLimitation`|`RoleService::assignRoleToUserGroup()`|
|`RoleService\AssignRoleToUserSignal`|`roleId`</br>`userId`</br>`roleLimitation`|`RoleService::assignRoleToUser()`|
|`RoleService\CreateRoleDraftSignal`|`roleId`|`RoleService::createRoleDraft()`|
|`RoleService\CreateRoleSignal`|`roleId`|`RoleService::createRole()`|
|`RoleService\DeleteRoleDraftSignal`|`roleId`|`RoleService::deleteRoleDraft()`|
|`RoleService\DeleteRoleSignal`|`roleId`|`RoleService::deleteRole()`|
|`RoleService\PublishRoleDraftSignal`|`roleId`|`RoleService::publishRoleDraft()`|
|`RoleService\RemovePolicyByRoleDraftSignal`|`roleId`</br>`policyId`|`RoleService::removePolicyByRoleDraft()`|
|`RoleService\RemovePolicySignal`|`roleId`</br>`policyId`|`RoleService::removePolicy()`|
|`RoleService\RemoveRoleAssignmentSignal`|`roleAssignmentId`|`RoleService::removeRoleAssignment()`|
|`RoleService\UnassignRoleFromUserGroupSignal`|`roleId`</br>`userGroupId`|`RoleService::unassignRoleFromUserGroup()`|
|`RoleService\UnassignRoleFromUserSignal`|`roleId`</br>`userId`|`RoleService::unassignRoleFromUser()`|
|`RoleService\UpdatePolicySignal`|`policyId`|`RoleService::updatePolicy()`|
|`RoleService\UpdateRoleDraftSignal`|`roleId`|`RoleService::updateRoleDraft()`|
|`RoleService\UpdateRoleSignal`|`roleId`|`RoleService::updateRole()`|

#### SectionService

|Signal type|Properties|Triggered by|
|------|------|------|
|`SectionService\AssignSectionSignal`|`contentId`</br>`sectionId`|`SectionService::assignSection()`|
|`SectionService\CreateSectionSignal`|`sectionId`|`SectionService::createSection()`|
|`SectionService\DeleteSectionSignal`|`sectionId`|`SectionService::deleteSection()`|
|`SectionService\UpdateSectionSignal`|`sectionId`|`SectionService::updateSection()`|

#### TrashService

|Signal type|Properties|Triggered by|
|------|------|------|
|`TrashService\DeleteTrashItemSignal`|`trashItemId`|`TrashService::deleteTrashItem()`|
|`TrashService\EmptyTrashSignal`|N/A|`TrashService::emptyTrash()`|
|`TrashService\RecoverSignal`|`trashItemId`</br>`contentId`</br>`newParentLocationId`</br>`newLocationId`|`TrashService::recover()`|
|`TrashService\TrashSignal`|`locationId`</br>`parentLocationId`</br>`contentId`</br>`contentTrashed`|`TrashService::trash()`|

#### URLAliasService

|Signal type|Properties|Triggered by|
|------|------|------|
|`URLAliasService\CreateGlobalUrlAliasSignal`|`urlAliasId`|`URLAliasService::createGlobalUrlAlias()`|
|`URLAliasService\CreateUrlAliasSignal`|`urlAliasId`|`URLAliasService::createUrlAlias()`|
|`URLAliasService\RemoveAliasesSignal`|`aliasList`|`URLAliasService::removeAliases()`|

#### URLService

|Signal type|Properties|Triggered by|
|------|------|------|
|`URLService\UpdateUrlSignal`|`urlId`|`URLService::updateUrl()`|

#### URLWildcardService

|Signal type|Properties|Triggered by|
|------|------|------|
|`URLWildcardService\CreateSignal`|`urlWildcardId`|`URLWildcardService::create()`|
|`URLWildcardService\RemoveSignal`|`urlWildcardId`|`URLWildcardService::remove()`|
|`URLWildcardService\TranslateSignal`|`url`|`URLWildcardService::translate()`|

#### UserService

|Signal type|Properties|Triggered by|
|------|------|------|
|`UserService\AssignUserToUserGroupSignal`|`userId`</br>`userGroupId`|`UserService::assignUserToUserGroup()`|
|`UserService\CreateUserGroupSignal`|`userGroupId`|`UserService::createUserGroup()`|
|`UserService\CreateUserSignal`|`userId`|`UserService::createUser()`|
|`UserService\DeleteUserGroupSignal`|`userGroupId`</br>`affectedLocationIds`|`UserService::deleteUserGroup()`|
|`UserService\DeleteUserSignal`|`userId`</br>`affectedLocationIds`|`UserService::deleteUser()`|
|`UserService\MoveUserGroupSignal`|`userGroupId`</br>`newParentId`|`UserService::moveUserGroup()`|
|`UserService\UnAssignUserFromUserGroupSignal`|`userId`</br>`userGroupId`|`UserService::unAssignUserFromUserGroup()`|
|`UserService\UpdateUserGroupSignal`|`userGroupId`|`UserService::updateUserGroup()`|
|`UserService\UpdateUserSignal`|`userId`|`UserService::updateUser()`|

## SPI and API repositories

The `ezpublish-api` and `ezpublish-spi` repositories are read-only splits of `ezsystems/ezpublish-kernel`
They are available to make dependencies easier and more lightweight.

### API

This package is a split of the eZ Platform Public API. It includes the **services interfaces** and **domain objects** from the `eZ\Publish\API` namespace.

It offers a lightweight way to make your project depend on eZ Platform API and Domain objects, without depending on the whole `ezpublish-kernel`.

The repository is read-only, automatically updated from https://github.com/ezsystems/ezpublish-kernel.

Requiring `ezpublish-api` in your project (on the example of version 6.7):

```
"require": {
    "ezsystems/ezpublish-api": "~6.7"
}
```

### SPI

This package is a split of the eZ Platform SPI (persistence interfaces).

It can be used as a dependency, instead of the whole `ezpublish-kernel`, by packages implementing custom eZ Platform storage engines, or by any package that requires classes from the `eZ\Publish\SPI` namespace.

The repository is read-only, automatically updated from https://github.com/ezsystems/ezpublish-kernel.

Requiring `ezpublish-spi` in your project (on the example of version 6.7):

```
"require": {
    "ezsystems/ezpublish-spi": "~6.7"
}
```

## Regenerating URL Aliases

!!! note "Enabling EzPublishMigrationBundle bundle"

    The URL Alias regeneration command is not available in a default installation, because
    the bundle with the feature is not enabled in the AppKernel. To enable it, add the
    following to your `dev` environment bundles in `app/AppKernel.php`:

    ```
    $bundles[] = new \eZ\Bundle\EzPublishMigrationBundle\EzPublishMigrationBundle();
    ```

The command `ezplatform:regenerate:legacy_storage_url_aliases` regenerates URL aliases for Locations and migrates existing custom Location and global URL aliases to a separate database table. The separate table must be named `__migration_ezurlalias_ml` and should be created manually to be identical (but empty) as the existing table `ezurlalias_ml` before the command is executed.

After the script finishes, to complete migration the table should be renamed to `ezurlalias_ml` manually. Using available options for `action` argument, you can back up custom Location and global URL aliases separately and inspect them before restoring them to the migration table. They will be stored in backup tables named `__migration_backup_custom_alias` and `__migration_backup_global_alias` (created automatically).

It is also possible to skip custom Location and global URL aliases altogether and regenerate only automatically created URL aliases for Locations (use the `autogenerate` action to achieve this). During the script execution the database should not be modified. Since this script can potentially run for a very long time, to avoid memory exhaustion run it in production environment using the `--env=prod` switch.
