<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Collaboration\Cart\Mapper;

use App\Collaboration\Cart\CartSession;
use Ibexa\Collaboration\Mapper\Domain\ParticipantCollectionDomainMapperInterface;
use Ibexa\Collaboration\Mapper\Domain\SessionDomainMapperInterface;
use Ibexa\Collaboration\Mapper\Domain\UserProxyDomainMapperInterface;
use Ibexa\Collaboration\Persistence\Values\AbstractSession as SessionData;
use Ibexa\Contracts\Collaboration\Session\SessionInterface;

/**
 * @template-implements \Ibexa\Collaboration\Mapper\Domain\SessionDomainMapperInterface<
 *     \App\Collaboration\Cart\Persistence\Values\CartSession
 * >
 */
final class CartSessionDomainMapper implements SessionDomainMapperInterface
{
    public function __construct(
        private CartProxyMapperInterface $cartProxyMapper,
        private UserProxyDomainMapperInterface $userDomainMapper,
        private ParticipantCollectionDomainMapperInterface $participantCollectionDomainMapper
    ) {
    }

    /**
     * @param \App\Collaboration\Cart\Persistence\Values\CartSession $data
     */
    public function fromPersistence(SessionData $data): SessionInterface
    {
        return new CartSession(
            $data->getId(),
            $this->cartProxyMapper->createCartProxy($data->getCartIdentifier()),
            $data->getToken(),
            $this->userDomainMapper->createUserProxy($data->getOwnerId()),
            $this->participantCollectionDomainMapper->createParticipantCollectionProxy($data->getId()),
            $data->isActive(),
            $data->hasPublicLink(),
            $data->getCreatedAt(),
            $data->getUpdatedAt(),
        );
    }
}
