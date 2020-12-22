# Catalog segmentation [[% include 'snippets/commerce_badge.md' %]]

Catalogs, especially in B2B shops, are often segmented even by customers. 

An ERP system can provide a segmentation code such as "certified".
A customer with this code can get more products than an anonymous user or a customer without the code.

A customer can even have individual products which are available for this customer only.

## How it works

eContent can use an additional database table to segment the catalog. 

``` 
desc sve_object_catalog;
+--------------+------------------+------+-----+---------+-------+
| Field        | Type             | Null | Key | Default | Extra |
+--------------+------------------+------+-----+---------+-------+
| node_id      | int(11) unsigned | NO   | PRI | NULL    |       |
| catalog_code | char(20)         | NO   | PRI |         |       |
+--------------+------------------+------+-----+---------+-------+
```

For each `node_id` one or more `catalog_codes` can be defined. 

The configuration is per SiteAccess or SiteAccess group.
You can extend the eContent service to change the logic for providing the catalog codes.

## Implement different catalog filtering

You can configure eContent so that catalog elements have assigned roles (so different users can see different content).

Adjust configuration like in the following example:

``` 
silver_econtent.default.filter_SQL_where: 'sve_object_catalog.node_id = obj.node_id AND sve_object_catalog.catalog_code IN (%%catalog_code%%)'

silver_econtent.default.catalog_filter_default_catalogcode:
    - ANONYMOUS

silver_econtent.default.section_filter: enabled
```

`admin` does not normally use segmentation, but you can enable it for this SiteAccess as well:

`silver_econtent.admin.section_filter: disabled`

## Custom segmentation logic

If you need custom logic, override `ConfigEcontentCatalogSegmentationService` to return the catalog codes
which are used in your context (e.g. depending on the user). 

Catalog segmentation uses a service to define which users are allowed to see the content specified in segmentated parts of the catalog.

The default configuration uses `ConfigEcontentCatalogSegmentationService`
that returns a collection of catalog codes specified in the configuration.
The service implements `EcontentCatalogSegmentationServiceInterface`.

You can implement this interface when you need a custom algorithm
for showing specific products to specific users.

The following example service replaces the default implementation:

``` php
<?php

namespace Silversolutions\Bundle\EshopBundle\Service;

use eZ\Publish\Core\MVC\ConfigResolverInterface;
use Silversolutions\Bundle\EshopBundle\Api\EcontentCatalogSegmentationServiceInterface;

/**
 * Simple user group based implementation.
 */
class MyCustomUserEcontentCatalogSegmentationService implements EcontentCatalogSegmentationServiceInterface
{
    /**
     * @var string
     */
    private $userGroup;

    /**
     * Set via external instance depending on the request session
     *
     * @param string $groupCode
     */
    public function setUserGroup($groupCode)
    {
        $this->userGroup = $groupCode;
    }

    /**
     * Place the logic that fetches the desired catalog codes here:
     */
    public function getCatalogCodes()
    {
        // Get catalog codes from Ez users or from ERP (static array here)
        if ($this->userGroup === 'VIP') {
            return array('VIP', 'NORMAL')
        } else {
            return array('NORMAL');
        }
    }
}
```

## Indexing catalog codes

The eContent indexer indexes all catalog codes from an element in a multi-value field called `main_catalog_segments_ms`.

This field stores all catalog codes for a given element. 

``` 
# Example of Solr index
"main_catalog_segments_ms": [
    "ALL",
    "NORMAL"
]
```
