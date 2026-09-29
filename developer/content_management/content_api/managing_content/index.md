# Managing content

PHP API enables managing content Locations, content types, content in Trash, and Calendar events.

## Locations

You can manage [locations](../../locations/index.md) that hold content using [`Ibexa\Contracts\Core\Repository\LocationService`](../../../../../../ibexa/core/src/contracts/Repository/LocationService.php).

> **Tip: Location REST API**
>
> To learn how to manage locations using the REST API, see [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Objects/operation/api_contentobjects_contentIdlocations_post).

### Adding a new location to a content item

Every published content item must have at least one location. One content item can have more that one location, which means it's presented in more than one place in the content tree.

Creating a new location, like creating content, requires using a struct, because a location value object is read-only.

To add a new location to existing content you need to create a [`Ibexa\Contracts\Core\Repository\Values\Content\LocationCreateStruct`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/LocationCreateStruct.php) and pass it to the [`LocationService::createLocation`](../../../../../../ibexa/core/src/contracts/Repository/LocationService.php) method:

```php
        $locationCreateStruct = $this->locationService->newLocationCreateStruct($parentLocationId);

        $contentInfo = $this->contentService->loadContentInfo($contentId);
        $newLocation = $this->locationService->createLocation($contentInfo, $locationCreateStruct);
```

`LocationCreateStruct` must receive the parent location ID. It sets the `parentLocationId` property of the new location.

You can also provide other properties for the location, otherwise they're set to their defaults:

```php
$locationCreateStruct->priority = 500;
$locationCreateStruct->hidden = true;
```

### Changing the main location

When a content item has more that one location, one location is always considered the main one. You can change the main location using [`Ibexa\Contracts\Core\Repository\ContentService`](../../../../../../ibexa/core/src/contracts/Repository/ContentService.php), by updating the `ContentInfo` with a [`Ibexa\Contracts\Core\Repository\Values\Content\ContentUpdateStruct`](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/ContentUpdateStruct.php) that sets the new main location:

```php
$contentUpdateStruct = $this->contentService->newContentMetadataUpdateStruct();
$contentUpdateStruct->mainLocationId = $locationId;

$this->contentService->updateContentMetadata($contentInfo, $contentUpdateStruct);
```

### Hiding and revealing locations

To hide or reveal (unhide) a location you need to make use of [`LocationService::hideLocation`](../../../../../../ibexa/core/src/contracts/Repository/LocationService.php) or [`LocationService::unhideLocation`:](../../../../../../ibexa/core/src/contracts/Repository/LocationService.php)

```php
        $this->locationService->hideLocation($location);

        $this->locationService->unhideLocation($location);
```

See [location visibility](../../locations/index.md#location-visibility) for detailed information on the behavior of visible and hidden Locations.

### Deleting a location

You can remove a location either by deleting it, or sending it to Trash.

Deleting makes use of [`LocationService::deleteLocation()`](../../../../../../ibexa/core/src/contracts/Repository/LocationService.php). It permanently deletes the location, together with its whole subtree.

Content which has only this one location is permanently deleted as well. Content which has more locations is still available in its other locations. If you delete the [main location](#changing-the-main-location) of a content item that has more locations, another location becomes the main one.

```php
$location = $this->locationService->loadLocation($locationId);

$this->locationService->deleteLocation($location);
```

To send the location and its subtree to Trash, use [`TrashService::trash`](../../../../../../ibexa/core/src/contracts/Repository/TrashService.php). Items in Trash can be later [restored, or deleted permanently](#trash).

```php
$this->trashService->trash($location);
```

### Moving and copying a subtree

You can move a location with its whole subtree using [`LocationService::moveSubtree`](../../../../../../ibexa/core/src/contracts/Repository/LocationService.php):

```php
$sourceLocation = $this->locationService->loadLocation($locationId);
$targetLocation = $this->locationService->loadLocation($targetLocationId);
$this->locationService->moveSubtree($sourceLocation, $targetLocation);
```

[`LocationService::copySubtree`](../../../../../../ibexa/core/src/contracts/Repository/LocationService.php) is used in the same way, but it copies the location and its subtree instead of moving it.

> **Tip: Tip**
>
> To copy a subtree you can also make use of the built-in `copy-subtree` command: `bin/console ibexa:copy-subtree <sourceLocationId> <targetLocationId>`.

> **Note: Note**
>
> [Copy subtree limit](../../../administration/back_office/back_office_configuration/index.md#copy-subtree-limit) only applies to operations in the back office. It's ignored when copying subtrees using the PHP API.

## Trash

> **Tip: Trash REST API**
>
> To learn how to manage Trash using the REST API, see [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Trash).

To empty the Trash (remove all locations in Trash), use [`TrashService::emptyTrash`](../../../../../../ibexa/core/src/contracts/Repository/TrashService.php), which takes no arguments.

You can recover an item from Trash using [`TrashService::recover`](../../../../../../ibexa/core/src/contracts/Repository/TrashService.php). You must provide the method with the ID of the object in Trash. Trash location is identical to the origin location of the object.

```php
$this->trashService->recover($trashItem, $newParent);
```

The content item is restored under its previous location. You can also provide a different location to restore in as a second argument:

```php
/**
 * @var \Ibexa\Contracts\Core\Repository\Values\Content\TrashItem $trashItem
 * @var \Ibexa\Contracts\Core\Repository\LocationService $locationService
 * @var \Ibexa\Contracts\Core\Repository\TrashService $trashService
 */
$locationId = 12345;
$newParent = $locationService->loadLocation($locationId);
$trashService->recover($trashItem, $newParent);
```

You can also search through Trash items and sort the results using several public PHP API Search Criteria and Sort Clauses that have been exposed for `TrashService` queries. For more information, see [Search in trash](../../../search/search_api/index.md#search-in-trash).

## Content types

> **Tip: Content type REST API**
>
> To learn how to manage content types using the REST API, see REST API reference for [content types](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Type) and [content type groups](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Type-Groups).

### Adding content types

To operate on content types, you need to make use of [`Ibexa\Contracts\Core\Repository\ContentTypeService`](../../../../../../ibexa/core/src/contracts/Repository/ContentTypeService.php).

Adding a new content type, like creating content, must happen with the use of a struct, because a content type value object is read-only. In this case you use [`Ibexa\Contracts\Core\Repository\Values\ContentType\ContentTypeCreateStruct`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/ContentTypeCreateStruct.php).

A content type must have at least one name, in the main language, and at least one field definition.

```php
        $contentTypeCreateStruct = $this->contentTypeService->newContentTypeCreateStruct($contentTypeIdentifier);
        $contentTypeCreateStruct->mainLanguageCode = 'eng-GB';
        $contentTypeCreateStruct->nameSchema = '<name>';

        $contentTypeCreateStruct->names = [
            'eng-GB' => $contentTypeIdentifier,
        ];

        $titleFieldCreateStruct = $this->contentTypeService->newFieldDefinitionCreateStruct('name', 'ibexa_string');

        $contentTypeCreateStruct->addFieldDefinition($titleFieldCreateStruct);

        $contentTypeDraft = $this->contentTypeService->createContentType(
            $contentTypeCreateStruct,
            [$contentTypeGroup]
        );

        $this->contentTypeService->publishContentTypeDraft($contentTypeDraft);
```

You can specify more details of the field definition in the create struct, for example:

```php
$titleFieldCreateStruct = $this->contentTypeService->newFieldDefinitionCreateStruct('name', 'ibexa_string');
$titleFieldCreateStruct->names = ['eng-GB' => 'Name'];
$titleFieldCreateStruct->descriptions = ['eng-GB' => 'The name'];
$titleFieldCreateStruct->fieldGroup = 'content';
$titleFieldCreateStruct->position = 10;
$titleFieldCreateStruct->isTranslatable = true;
$titleFieldCreateStruct->isRequired = true;
$titleFieldCreateStruct->isSearchable = true;
```

### Copying content types

To copy a content type, use [`ContentTypeService::copyContentType`](../../../../../../ibexa/core/src/contracts/Repository/ContentTypeService.php):

```php
$contentTypeToCopy = $this->contentTypeService->loadContentTypeByIdentifier($contentTypeIdentifier);

$copy = $this->contentTypeService->copyContentType($contentTypeToCopy);
```

The copy is automatically getting an identifier based on the original content type identifier and the copy's ID, for example: `copy_of_folder_21`.

To change the identifier of the copy, use a [`Ibexa\Contracts\Core\Repository\Values\ContentType\ContentTypeUpdateStruct`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/ContentTypeUpdateStruct.php):

```php
$copy = $this->contentTypeService->copyContentType($contentTypeToCopy);
$copyDraft = $this->contentTypeService->createContentTypeDraft($copy);
$copyUpdateStruct = $this->contentTypeService->newContentTypeUpdateStruct();
$copyUpdateStruct->identifier = $copyIdentifier;
$copyUpdateStruct->names = ['eng-GB' => $copyIdentifier];
$this->contentTypeService->updateContentTypeDraft($copyDraft, $copyUpdateStruct);
```

### Finding and filtering content types

You can find content types that match specific criteria by using the [`ContentTypeService::findContentTypes()`](../../../../../../ibexa/core/src/contracts/Repository/ContentTypeService.php) method. This method accepts a `ContentTypeQuery` object that supports filtering and sorting by IDs, identifiers, group membership, and other criteria.

> **Note: Criteria, sort clauses and REST APIs**
>
> For a full list of available criteria and sort clauses that you can use when finding and filtering content types, see [Content Type Search Criteria](../../../search/content_type_search_reference/content_type_criteria/index.md) and [Content Type Search Sort Clauses](../../../search/content_type_search_reference/content_type_sort_clauses/index.md) references.
>
> For the REST API, see [Filter content types](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Type/operation/api_contenttypesview_post).

The following example shows how you can use the criteria to find content types:

```php
<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\Values\ContentType\Query\ContentTypeQuery;
use Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:find_content_types',
    description: 'Lists content types that match specific criteria.'
)]
class FindContentTypeCommand extends Command
{
    public function __construct(private readonly ContentTypeService $contentTypeService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Find content types from the "Content" group that contains a specific field definition (in this case, a "Body" field).
        $query = new ContentTypeQuery(
            new Criterion\LogicalAnd([
                new Criterion\ContentTypeGroupName(['Content']),
                new Criterion\ContainsFieldDefinitionId([121]),
            ]),
            [
                new SortClause\Id(),
                new SortClause\Identifier(),
                new SortClause\Name(),
            ]
        );

        $searchResult = $this->contentTypeService->findContentTypes($query);

        $output->writeln('Found ' . $searchResult->getTotalCount() . ' content type(s):');

        foreach ($searchResult->getContentTypes() as $contentType) {
            $output->writeln(sprintf(
                '- [%d] %s (identifier: %s)',
                $contentType->id,
                $contentType->getName(),
                $contentType->identifier
            ));
        }

        return Command::SUCCESS;
    }
}
```

#### Query parameters

When constructing a `ContentTypeQuery`, you can pass the following parameters:

- `?CriterionInterface $criterion = null` — a filter to apply (use one or a combination of the criteria above)
- `array $sortClauses = []` — list of sort clauses to order the results
- `int $offset = 0` — starting offset (for pagination)
- `int $limit = 25` — maximum number of results to return

## Calendar events

You can handle the calendar using `CalendarServiceInterface` (`Ibexa\Contracts\Calendar\CalendarServiceInterface`).

> **Tip: Calendar REST API**
>
> To learn how to manage the Calendar using the REST API, see [REST API reference](https://doc.ibexa.co/en/5.0/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Calendar).

### Getting events

To get a list of events for a specified time period, use the `CalendarServiceInterface::getEvents` method. You need to provide the method with an EventQuery, which takes a date range and a count as the minimum of parameters:

```php
$dateFrom = new \DateTimeImmutable('2023-01-01T10:00:00+00:00');
$dateTo = new \DateTimeImmutable('2023-12-31T10:0:00+00:00');
$dateRange = new Calendar\DateRange($dateFrom, $dateTo);

$eventQuery = new Calendar\EventQuery($dateRange, 10);

$eventList = $this->calendarService->getEvents($eventQuery);

foreach ($eventList as $event) {
    $output->writeln($event->getName() . '; date: ' . $event->getDateTime()->format('T Y-m-d H:i:s'));
}
```

You can also get the first and last event in the list by using the `first()` and `last()` methods of an `EventCollection` (`Ibexa\Contracts\Calendar\EventCollection`):

```php
$eventCollection = $eventList->getEvents();
$output->writeln('First event: ' . $eventCollection->first()->getName() . '; date: ' . $eventCollection->first()->getDateTime()->format('T Y-m-d H:i:s'));
```

You can process the events in a collection using the `find(Closure $predicate)`, `filter(Closure $predicate)`, `map(Closure $callback)` or `slice(int $offset, ?int $length = null)` methods of `EventCollection`, for example:

```php
$newCollection = $eventCollection->slice(3, 5);
foreach ($newCollection as $event) {
    $output->writeln('New collection: ' . $event->getName() . '; date: ' . $event->getDateTime()->format('T Y-m-d H:i:s'));
}
```

### Performing calendar actions

You can perform a calendar action (for example, reschedule or unschedule calendar events) using the `CalendarServiceInterface::executeAction()` method. You must pass an `Ibexa\Contracts\Calendar\EventAction\EventActionContext` instance as argument. `EventActionContext` defines events on which the action is performed, and action-specific parameters, for example, a new date:

```php
$newDate = new \DateTimeImmutable('2023-12-06T13:00:00+00:00');
$context = new RescheduleEventActionContext($eventCollection, $newDate);

$this->calendarService->executeAction($context);
```
