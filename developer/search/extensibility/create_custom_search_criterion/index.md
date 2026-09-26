# Create custom Search Criterion

Create custom Search Criterion to use with Solr and Elasticsearch search engines.

To provide support for a custom Search Criterion, do the following.

## Create Criterion class

First, create a `CameraManufacturerCriterion.php` file that contains the Criterion class:

```php
<?php

declare(strict_types=1);

namespace App\Query\Criterion;

use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion\Operator\Specifications;

final class CameraManufacturerCriterion extends Criterion
{
    /**
     * @param string|string[] $value Manufacturer name(s) to be matched.
     */
    public function __construct($value)
    {
        parent::__construct(null, null, $value);
    }

    public function getSpecifications(): array
    {
        return [
            new Specifications(
                Operator::IN,
                Specifications::FORMAT_ARRAY,
                Specifications::TYPE_STRING
            ),
            new Specifications(
                Operator::EQ,
                Specifications::FORMAT_SINGLE,
                Specifications::TYPE_STRING
            ),
        ];
    }
}
```

## Create Criterion visitor

Then, add a `CameraManufacturerVisitor` class, implementing `CriterionVisitor`:

**Solr**

```php
<?php

declare(strict_types=1);

namespace App\Query\Criterion\Solr;

use App\Query\Criterion\CameraManufacturerCriterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\CriterionInterface;
use Ibexa\Contracts\Solr\Query\CriterionVisitor;

final class CameraManufacturerVisitor extends CriterionVisitor
{
    public function canVisit(CriterionInterface $criterion): bool
    {
        return $criterion instanceof CameraManufacturerCriterion;
    }

    /**
     * @param \App\Query\Criterion\CameraManufacturerCriterion $criterion
     */
    public function visit(CriterionInterface $criterion, ?CriterionVisitor $subVisitor = null): string
    {
        $expressions = array_map(
            fn ($value): string => 'exif_camera_manufacturer_id:"' . $this->escapeQuote((string) $value) . '"',
            $criterion->value
        );

        return '(' . implode(' OR ', $expressions) . ')';
    }
}
```

**Elasticsearch**

```php
<?php

declare(strict_types=1);

namespace App\Query\Criterion\Elasticsearch;

use App\Query\Criterion\CameraManufacturerCriterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\CriterionInterface;
use Ibexa\Contracts\Elasticsearch\Query\CriterionVisitor;
use Ibexa\Contracts\Elasticsearch\Query\LanguageFilter;

final class CameraManufacturerVisitor implements CriterionVisitor
{
    public function supports(CriterionInterface $criterion, LanguageFilter $languageFilter): bool
    {
        return $criterion instanceof CameraManufacturerCriterion;
    }

    /**
     * @param \App\Query\Criterion\CameraManufacturerCriterion $criterion
     */
    public function visit(CriterionVisitor $dispatcher, CriterionInterface $criterion, LanguageFilter $languageFilter): array
    {
        return [
            'terms' => [
                'exif_camera_manufacturer_id' => (array)$criterion->value,
            ],
        ];
    }
}
```

Finally, register the visitor as a service.

Search Criteria can be valid for both Content and Location search. To choose the search type, use either `content` or `location` in the tag when registering the visitor as a service:

**Solr**

```yaml
services:
    App\Query\Criterion\Solr\CameraManufacturerVisitor:
    tags:
        - { name: ibexa.search.solr.query.content.criterion.visitor }
        - { name: ibexa.search.solr.query.location.criterion.visitor }
```

**Elasticsearch**

```yaml
services:
    App\Query\Criterion\Elasticsearch\CameraManufacturerVisitor:
    tags:
        - { name: ibexa.search.elasticsearch.query.content.criterion.visitor }
        - { name: ibexa.search.elasticsearch.query.location.criterion.visitor }
```

This example pretends a new `exif_camera_manufacturer_id` data is indexed. For more information about indexing new additional data, see [Solr document field mappers](../solr_document_field_mappers/index.md) or [Index custom Elasticsearch data](../index_custom_elasticsearch_data/index.md).
