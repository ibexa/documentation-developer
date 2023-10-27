---
description: Inject the SiteAccess service to get SiteAccess information in your custom PHP code.
---

# Injecting SiteAccess

The [service container](../../api/public_php_api.md#service-container) exposes the SiteAccess through the `@ezpublish.siteaccess_service` service, which fulfills the `\eZ\Publish\Core\MVC\Symfony\SiteAccess\SiteAccessServiceInterface` contract.
This means you can inject it into any custom service constructor, type hinting that contract.
You can get the current SiteAccess from that service by calling the `SiteAccessServiceInterface::getCurrent` method.
	
For example, define a service which depends on the Repository's ContentService and the SiteAccessService.

``` yaml
services:
    App\MyService:
        arguments: ['@ezpublish.siteaccess_service']
```

``` php
declare(strict_types=1);
	
namespace App;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\Core\MVC\Symfony\SiteAccess\SiteAccessServiceInterface;

class MyService
{
    /** @var \eZ\Publish\API\Repository\ContentService */
    private $contentService;

    /** @var \eZ\Publish\Core\MVC\Symfony\SiteAccess\SiteAccessServiceInterface */
    private $siteAccessService;

    public function __construct(
        SiteAccessServiceInterface $siteAccessService,
        ContentService $contentService
    ) {
        $this->siteAccessService = $siteAccessService;
        $this->contentService = $contentService;
    }
}
```
