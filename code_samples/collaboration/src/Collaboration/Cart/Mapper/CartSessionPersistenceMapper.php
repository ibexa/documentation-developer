<?php declare(strict_types=1);

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
        $token = $createStruct->getToken();
        $owner = $createStruct->getOwner();
        $hasPublicLink = $createStruct->hasPublicLink();

        assert($token !== null);
        assert($owner !== null);
        assert($hasPublicLink !== null);

        return new CartSessionCreateStruct(
            $token,
            $createStruct->getCart()->getIdentifier(),
            $owner->getUserId(),
            $createStruct->isActive(),
            $hasPublicLink,
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
