<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Collaboration\Cart\Mapper;

use App\Collaboration\Cart\Persistence\Values\CartSessionCreateStruct;
use App\Collaboration\Cart\Persistence\Values\CartSessionUpdateStruct;
use Ibexa\Collaboration\Mapper\Persistence\SessionPersistenceMapperInterface;
use Ibexa\Collaboration\Persistence\Values\AbstractSessionCreateStruct as PersistenceSessionCreateStruct;
use Ibexa\Collaboration\Persistence\Values\AbstractSessionUpdateStruct as PersistenceSessionUpdateStruct;
use Ibexa\Contracts\Collaboration\Session\AbstractSessionCreateStruct as SessionCreateStruct;
use Ibexa\Contracts\Collaboration\Session\AbstractSessionUpdateStruct as SessionUpdateStruct;
use Ibexa\Contracts\Collaboration\Session\SessionInterface;

final class CartSessionPersistenceMapper implements SessionPersistenceMapperInterface
{
    /**
     * @param \App\Collaboration\Cart\CartSessionCreateStruct $createStruct
     */
    public function toPersistenceCreateStruct(
        SessionCreateStruct $createStruct
    ): PersistenceSessionCreateStruct {
        return new CartSessionCreateStruct(
            $createStruct->getToken(),
            $createStruct->getCart()->getIdentifier(),
            $createStruct->getOwner()->getUserId(),
            $createStruct->isActive(),
            $createStruct->hasPublicLink(),
            new \DateTimeImmutable(),
            new \DateTimeImmutable()
        );
    }

    public function toPersistenceUpdateStruct(
        SessionInterface $session,
        SessionUpdateStruct $updateStruct
    ): PersistenceSessionUpdateStruct {
        return new CartSessionUpdateStruct(
            $session->getId(),
            $updateStruct->getToken(),
            ($updateStruct->getOwner() ?? $session->getOwner())->getUserId()
        );
    }
}
