---
description: Inject the SiteAccess service to get SiteAccess information in your custom PHP code.
---

# Injecting SiteAccess

The [service container](php_api.md#service-container) exposes the SiteAccess through the `Ibexa\Core\MVC\Symfony\SiteAccess\SiteAccessService` service, which fulfills the `Ibexa\Core\MVC\Symfony\SiteAccess\SiteAccessServiceInterface` contract.
This means you can inject it into any custom service constructor, type hinting that contract.
You can get the current SiteAccess from that service by calling the `SiteAccessServiceInterface::getCurrent` method.
	
For example, define a service which depends on the Repository's ContentService and the SiteAccessService.

``` yaml
services:
    App\MyService:
        arguments: ['@Ibexa\Core\MVC\Symfony\SiteAccess\SiteAccessService']
```

``` php
declare(strict_types=1);
	
namespace App;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Core\MVC\Symfony\SiteAccess\SiteAccessServiceInterface;

class MyService
{
    /** @var \Ibexa\Contracts\Core\Repository\ContentService */
    private $contentService;

    /** @var \Ibexa\Core\MVC\Symfony\SiteAccess\SiteAccessServiceInterface */
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
