<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\Collaboration\Cart\Persistence\Gateway;

use App\Collaboration\Cart\Persistence\Values\CartSessionCreateStruct as CreateStruct;
use App\Collaboration\Cart\Persistence\Values\CartSessionUpdateStruct as UpdateStruct;
use Doctrine\DBAL\Types\Types;
use Ibexa\Collaboration\Persistence\Session\Inner\GatewayInterface;
use Ibexa\Collaboration\Persistence\Values\AbstractSessionCreateStruct;
use Ibexa\Collaboration\Persistence\Values\AbstractSessionUpdateStruct;
use Ibexa\Contracts\CorePersistence\Gateway\AbstractDoctrineDatabase;
use Ibexa\Contracts\CorePersistence\Gateway\DoctrineSchemaMetadata;
use Ibexa\Contracts\CorePersistence\Gateway\DoctrineSchemaMetadataInterface;

/**
 * @phpstan-type TRow array{
 *     id: int,
 *     cart_identifier: string
 * }
 *
 * @template-extends \Ibexa\Contracts\CorePersistence\Gateway\AbstractDoctrineDatabase<TRow>
 *
 * @template-implements \Ibexa\Collaboration\Persistence\Session\Inner\GatewayInterface<TRow, CreateStruct, UpdateStruct>
 */
final class DatabaseGateway extends AbstractDoctrineDatabase implements GatewayInterface
{
    public const DISCRIMINATOR = 'cart';

    protected function buildMetadata(): DoctrineSchemaMetadataInterface
    {
        return new DoctrineSchemaMetadata(
            $this->connection,
            null,
            $this->getTableName(),
            [
                DatabaseSchema::COLUMN_ID => Types::INTEGER,
                DatabaseSchema::COLUMN_CART_IDENTIFIER => Types::STRING,
            ],
            [DatabaseSchema::COLUMN_ID]
        );
    }

    protected function getTableName(): string
    {
        return DatabaseSchema::TABLE_NAME;
    }

    public function getDiscriminator(): string
    {
        return self::DISCRIMINATOR;
    }

    /**
     * @param \App\Collaboration\Cart\Persistence\Values\CartSessionCreateStruct $createStruct
     */
    public function create(int $sessionId, AbstractSessionCreateStruct $createStruct): void
    {
        $this->doInsert([
            DatabaseSchema::COLUMN_ID => $sessionId,
            DatabaseSchema::COLUMN_CART_IDENTIFIER => $createStruct->getCartIdentifier(),
        ]);
    }

    /**
     * @param \Ibexa\Collaboration\Persistence\Values\AbstractSessionUpdateStruct $updateStruct
     */
    public function update(AbstractSessionUpdateStruct $updateStruct): void
    {
        // There is nothing to update
    }
}
