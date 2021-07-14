# Injecting SiteAccess

The [service container](../service_container.md) exposes the SiteAccess as the `@ezpublish.siteaccess` service,
so you can inject it using setter injection into any custom service.
The service should implement the `eZ\Publish\Core\MVC\Symfony\SiteAccess\SiteAccessAware` interface.

For example, define a service which depends on the Repository's ContentService and the current SiteAccess.

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
