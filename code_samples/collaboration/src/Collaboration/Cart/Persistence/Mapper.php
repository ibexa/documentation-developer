<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Collaboration\Cart\Persistence;

use App\Collaboration\Cart\Persistence\Values\CartSession;
use Ibexa\Collaboration\Persistence\Session\Inner\MapperInterface;
use Ibexa\Collaboration\Persistence\Values\AbstractSession;

/**
 * @phpstan-type TRow array{
 *     id: int,
 *     token: string,
 *     owner_id: int,
 *     is_active: bool,
 *     has_public_link: bool,
 *     created_at: \DateTimeImmutable,
 *     updated_at: \DateTimeImmutable,
 *     cart_cart_identifier: string,
 * }
 *
 * @template-implements \Ibexa\Collaboration\Persistence\Session\Inner\MapperInterface<TRow>
 */
final class Mapper implements MapperInterface
{
    public function extractFromRow(array $row): AbstractSession
    {
        return new CartSession(
            $row['id'],
            $row['cart_cart_identifier'],
            $row['token'],
            $row['owner_id'],
            $row['is_active'],
            $row['has_public_link'],
            $row['created_at'],
            $row['updated_at']
        );
    }
}
