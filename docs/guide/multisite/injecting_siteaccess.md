# Injecting SiteAccess

The [service container](../service_container.md) exposes the SiteAccess as the `@ezpublish.siteaccess` service,
so you can inject it using setter injection into any custom service.
The service should implement the `eZ\Publish\Core\MVC\Symfony\SiteAccess\SiteAccessAware` interface.

For example, define a service which depends on the Repository's ContentService and the current SiteAccess.

``` yaml
services:
    App\MyService:
        arguments: ['@ezpublish.api.service.content']
        calls:
            - [setSiteAccess, ['@ezpublish.siteaccess']]
```

``` php
namespace App;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\Core\MVC\Symfony\SiteAccess;
use eZ\Publish\Core\MVC\Symfony\SiteAccess\SiteAccessAware;

class MyService implements SiteAccessAware
{
    /**
     * @var \eZ\Publish\API\Repository\ContentService
     */
    private $contentService;

    /**
     * @var \eZ\Publish\Core\MVC\Symfony\SiteAccess
     */
    private $siteAccess;

    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;
    }

    public function setSiteAccess(SiteAccess $siteAccess = null)
    {
        $this->siteAccess = $siteAccess;
    }
}
```
