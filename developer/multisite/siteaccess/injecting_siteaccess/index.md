# Injecting SiteAccess

Inject the SiteAccess service to get SiteAccess information in your custom PHP code.

The [service container](../../../api/php_api/php_api/index.md#service-container) exposes the SiteAccess through the `Ibexa\Core\MVC\Symfony\SiteAccess\SiteAccessService` service, which fulfills the `Ibexa\Core\MVC\Symfony\SiteAccess\SiteAccessServiceInterface` contract. This means you can inject it into any custom service constructor, type hinting that contract. You can get the current SiteAccess from that service by calling the `SiteAccessServiceInterface::getCurrent` method.

For example, define a service which depends on the Repository's ContentService and the SiteAccessService.

```yaml
services:
    App\MyService:
        arguments: ['@Ibexa\Core\MVC\Symfony\SiteAccess\SiteAccessService']
```

```php
<?php

declare(strict_types=1);

namespace App;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Core\MVC\Symfony\SiteAccess\SiteAccessServiceInterface;

class MyService
{
    public function __construct(
        private readonly SiteAccessServiceInterface $siteAccessService,
        private readonly ContentService $contentService
    ) {
    }
}
```
