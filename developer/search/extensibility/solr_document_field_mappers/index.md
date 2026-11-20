# Solr document field mappers

Use document field mappers to add additional data in Solr search engine.

You can use document field mappers to index additional data in the search engine.

The additional data can come from external sources (for example, the [Raptor recommendation connector](../../../recommendations/raptor_integration/raptor_connector/index.md), or from internal ones. An example of indexing internal data is indexing data through the location hierarchy: from the parent location to the child location, or indexing child data on the parent location. You can use this to find the content with full-text search, or to simplify a search in a complicated data model.

To do this effectively, you must understand how the data is indexed with the Solr search engine. Solr uses [documents](https://solr.apache.org/guide/solr/9_8/getting-started/documents-fields-schema-design.html#how-solr-sees-the-world) as a unit of data that is indexed. Documents are indexed per translation, as content blocks. A block is a nested document structure. When used in Ibexa DXP, a parent document represents content, and locations are indexed as child documents of the content item. To avoid duplication, full-text data is indexed on the content document only. Knowing this, you can index additional data by the following:

- All block documents (meaning content and its locations, all translations)
- All block documents per translation
- Content documents
- Content documents per translation
- Location documents

Additional data is indexed by implementing a document field mapper and registering it at one of the five extension points described above. You can create the field mapper class anywhere inside your bundle, as long as you register it as a Symfony service. There are three different field mappers. Each mapper implements two methods, by the same name, but accepting different arguments:

- [`ContentFieldMapper`](../../../../../../ibexa/solr/src/contracts/FieldMapper/ContentTranslationFieldMapper.php)
  - [`::accept(Content $content)`](../../../../../../ibexa/solr/src/contracts/FieldMapper/ContentTranslationFieldMapper.php)
  - [`::mapFields(Content $content)`](../../../../../../ibexa/solr/src/contracts/FieldMapper/ContentTranslationFieldMapper.php)
- [`Ibexa\Contracts\Solr\FieldMapper\ContentTranslationFieldMapper`](../../../../../../ibexa/solr/src/contracts/FieldMapper/ContentTranslationFieldMapper.php)
  - [`::accept(Content $content, $languageCode)`](../../../../../../ibexa/solr/src/contracts/FieldMapper/ContentTranslationFieldMapper.php)
  - [`::mapFields(Content $content, $languageCode)`](../../../../../../ibexa/solr/src/contracts/FieldMapper/ContentTranslationFieldMapper.php)
- [`Ibexa\Contracts\Solr\FieldMapper\LocationFieldMapper`](../../../../../../ibexa/solr/src/contracts/FieldMapper/LocationFieldMapper.php)
  - [`::accept(Location $content)`](../../../../../../ibexa/solr/src/contracts/FieldMapper/LocationFieldMapper.php)
  - [`::mapFields(Location $content)`](../../../../../../ibexa/solr/src/contracts/FieldMapper/LocationFieldMapper.php)

Mappers can be used on the extension points by registering them with the [service container](../../../api/php_api/php_api/index.md#service-container) by using service tags, as follows:

- All block documents
  - `ibexa.search.solr.field.mapper.block`
- All block documents per translation
  - `ibexa.search.solr.field.mapper.block.translation`
- Content documents
  - `ibexa.search.solr.field.mapper.content`
- Content documents per translation
  - `ibexa.search.solr.field.mapper.content.translation`
- Location documents
  - `ibexa.search.solr.field.mapper.location`

The following example shows how you can index data from the parent location content, to make it available for search on the child content. The example relies on a use case of indexing webinar data on the webinar events, which are children of the webinar. The field mapper could then look like this:

```php
<?php declare(strict_types=1);

namespace App\Search\FieldMapper;

use Ibexa\Contracts\Core\Persistence\Content;
use Ibexa\Contracts\Core\Persistence\Content\Handler as ContentHandler;
use Ibexa\Contracts\Core\Persistence\Content\Location\Handler as LocationHandler;
use Ibexa\Contracts\Core\Search;
use Ibexa\Contracts\Solr\FieldMapper\ContentFieldMapper;

class WebinarEventParentNameFieldMapper extends ContentFieldMapper
{
    public function __construct(
        protected ContentHandler $contentHandler,
        protected LocationHandler $locationHandler
    ) {
    }

    public function accept(Content $content): bool
    {
        // ContentType with ID 42 is webinar event
        return $content->versionInfo->contentInfo->contentTypeId === 42;
    }

    /**
     * @return \Ibexa\Contracts\Core\Search\Field[]
     */
    public function mapFields(Content $content): array
    {
        $mainLocationId = $content->versionInfo->contentInfo->mainLocationId;
        $location = $this->locationHandler->load($mainLocationId);
        $parentLocation = $this->locationHandler->load($location->parentId);
        $parentContentInfo = $this->contentHandler->loadContentInfo($parentLocation->contentId);

        return [
            new Search\Field(
                'parent_name',
                $parentContentInfo->name,
                new Search\FieldType\StringField()
            ),
        ];
    }
}
```

You index text data only on the content document, therefore, you would register the service like this:

```yaml
services:
    App\Search\FieldMapper\WebinarEventParentNameFieldMapper:
        arguments:
            - '@Ibexa\Contracts\Core\Persistence\Content\Handler'
            - '@Ibexa\Contracts\Core\Persistence\Content\Location\Handler'
        tags:
            - {name: ibexa.search.solr.field.mapper.content}
```

> **Caution: Permission issues when using Repository API in document field mappers**
>
> Document field mappers are low-level and expect to be able to index all content regardless of current user permissions. If you use PHP API in your custom document field mappers, apply [`sudo()`](../../../api/php_api/php_api/index.md#using-sudo), or use the Persistence SPI layer as in the example above.
