---
description: Use PHP API to manage invitations and sessions while using collaborative editing feature.
month_change: false
---

# Collaborative editing API

[[= product_name =]]'s Collaborative editing API provides two services for managing sessions and invitations, which differ in function:

- [`InvitationServiceInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-(?)-InvitationServiceInterface.html) is used to request product data
- [`SessionServiceInterface`](../api/php_api/php_api_reference/classes/Ibexa-Contracts-(?)-SessionServiceInterface.html) is used to modify products

``` php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace Ibexa\Tests\Integration\Collaboration;

use DateTimeImmutable;
use Ibexa\Contracts\Collaboration\Invitation\InvitationCreateStruct;
use Ibexa\Contracts\Collaboration\Invitation\InvitationInterface;
use Ibexa\Contracts\Collaboration\Invitation\InvitationQuery;
use Ibexa\Contracts\Collaboration\Invitation\InvitationStatus;
use Ibexa\Contracts\Collaboration\Invitation\InvitationUpdateStruct;
use Ibexa\Contracts\Collaboration\Invitation\Query\Criterion;
use Ibexa\Contracts\Collaboration\Invitation\Query\SortClause;
use Ibexa\Contracts\Collaboration\InvitationServiceInterface;
use Ibexa\Contracts\Collaboration\SessionServiceInterface;
use Ibexa\Contracts\Core\Repository\Exceptions\InvalidArgumentException;
use Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException;
use Ibexa\Contracts\Core\Test\IbexaKernelTestTrait;
use Ibexa\Contracts\CoreSearch\Values\Query\SortDirection;
use Ibexa\Contracts\Test\Core\IbexaKernelTestCase;

final class InvitationServiceTest extends IbexaKernelTestCase
{
    use IbexaKernelTestTrait;

    private const EXAMPLE_SESSION_ID = 1;
    private const EXAMPLE_INVITATION_ID = 1;
    private const EXAMPLE_PARTICIPANT_ID = 1;

    private const EXAMPLE_INVITATION_A = 1;
    private const EXAMPLE_INVITATION_B = 2;
    private const EXAMPLE_INVITATION_C = 3;

    protected function setUp(): void
    {
        self::bootKernel();
        self::setAdministratorUser();
    }
```