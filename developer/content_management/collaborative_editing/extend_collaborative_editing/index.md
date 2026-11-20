# Extend Collaborative editing

Extend Collaborative editing

Thanks to the ability to extend the [Collaborative editing](../collaborative_editing_guide/index.md) feature, you can introduce additional functionalities to enhance workflows not only in the context of content editing but also when working with products. The example below demonstrates how to extend the feature to enable a shared Cart functionality in the Commerce system.

> **Tip: Tip**
>
> If you prefer learning from videos, watch the Ibexa Summit 2025 presentation that covers the Collaborative editing feature:
>
> [*Collaboration: greater than the sum of the parts*](https://www.youtube.com/watch?v=dRB-SDlgX0I) by Marek Nocoń

## Create tables to hold Cart session data

First, set up the database layer and define the collaboration context, in this example, Cart. Create the necessary tables to store the data and to link the collaboration session with the Cart you want to share.

In the `data/schema.sql` file, create a database table to store a reference to the session context. In this example, the context is a shopping Cart, identified by `cart_identifier` and linked to the collaboration session through the Cart’s numeric ID stored in the database.

**MySQL**

```sql
CREATE TABLE ibexa_collaboration_cart (
    id INT NOT NULL PRIMARY KEY,
    cart_identifier VARCHAR(255) NOT NULL,
    CONSTRAINT ibexa_collaboration_cart_ibexa_collaboration_id_fk
        FOREIGN KEY (id) REFERENCES ibexa_collaboration (id)
            ON DELETE CASCADE
) COLLATE = utf8mb4_general_ci;
```

**PostgreSQL**

```sql
CREATE TABLE ibexa_collaboration_cart (
    id INTEGER NOT NULL PRIMARY KEY,
    cart_identifier VARCHAR(255) NOT NULL,
    CONSTRAINT ibexa_collaboration_cart_ibexa_collaboration_id_fk
        FOREIGN KEY (id) REFERENCES ibexa_collaboration (id)
            ON DELETE CASCADE
);
```

## Set up persistence layer

Now you need to prepare the persistence layer, which is responsible for storing, retrieving, and managing collaboration session and Cart data in the database.

It ensures that when a user creates, joins, or updates a Cart session, the system can track session status, participants, and permissions.

### Implement persistence gateway

The Gateway is the layer that connects the collaboration feature to the database. It handles all the create, read, update, and delete operations for collaboration sessions, ensuring that session data is stored and retrieved correctly.

It also uses a Discriminator to specify the session type. Based on the type, the Gateway interacts with the appropriate tables and data structures. This way, the system uses the correct Gateway to get or save data for each session type.

When creating the Database Gateways and mappers, you can use the built-in service tag:

- `ibexa.collaboration.persistence.session.gateway` - for the database gateway:

```yaml
tags:
  - { name: 'ibexa.collaboration.persistence.session.gateway', discriminator: 'my_session_type' }
```

- `ibexa.collaboration.persistence.session.mapper` - for the mapper that creates a session from a persistence raw row:

```yaml
tags:
  - { name: 'ibexa.collaboration.persistence.session.mapper', discriminator: 'my_session_type' }
```

- `ibexa.collaboration.service.session.domain.mapper` - for the mapper that creates a session from a persistence object:

```yaml
tags:
  - { name: 'ibexa.collaboration.service.session.domain.mapper', type: App\…\MyPersistentSession }
```

- `ibexa.collaboration.service.session.persistence.mapper` - for the mapper that converts a session into a structure used to create or update persistence:

```yaml
tags:
  - { name: 'ibexa.collaboration.service.session.persistence.mapper', type: 'my_session_type' }
```

In the `src/Collaboration/Cart/Persistence/Gateway/` directory, create the following files:

- `DatabaseSchema` - defines the database tables needed to store shared Cart collaboration session data:

```php
<?php declare(strict_types=1);

namespace App\Collaboration\Cart\Persistence\Gateway;

final class DatabaseSchema
{
    public const string TABLE_NAME = 'ibexa_collaboration_cart';

    public const string COLUMN_ID = 'id';
    public const string COLUMN_CART_IDENTIFIER = 'cart_identifier';

    private function __construct()
    {
        // This class is not intended to be instantiated
    }
}
```

- `DatabaseGateway` - implements the gateway logic for getting and retrieving shared Cart collaboration data from the database. It uses a Discriminator to identify the type of session (in this case, a Cart session):

```php
<?php declare(strict_types=1);

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
    public const string DISCRIMINATOR = 'cart';

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
```

### Define persistence Value objects

Value objects describe how collaboration session data is represented in the database. Persistence gateway uses them to store, retrieve, and manipulate session information, such as the session ID, associated Cart, participants, and scopes.

```yaml
    App\Collaboration\Cart\Mapper\CartSessionDomainMapper:
        tags:
            -   name: 'ibexa.collaboration.service.session.domain.mapper'
                type: App\Collaboration\Cart\Persistence\Values\CartSession
```

In the `src/Collaboration/Cart/Persistence/Values/` directory, create the following Value Objects:

- `CartSession` - represents the Cart collaboration session data:

```php
<?php declare(strict_types=1);

namespace App\Collaboration\Cart\Persistence\Values;

use DateTimeImmutable;
use Ibexa\Collaboration\Persistence\Values\AbstractSession;

final class CartSession extends AbstractSession
{
    public function __construct(
        int $id,
        private readonly string $cartIdentifier,
        string $token,
        int $userId,
        bool $isActive,
        bool $hasPublicLink,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt
    ) {
        parent::__construct($id, $token, $userId, $isActive, $hasPublicLink, $createdAt, $updatedAt);
    }

    public function getCartIdentifier(): string
    {
        return $this->cartIdentifier;
    }
}
```

- `CartSessionCreateStruct` - defines the data needed to create a new Cart collaboration session:

```php
<?php declare(strict_types=1);

namespace App\Collaboration\Cart\Persistence\Values;

use App\Collaboration\Cart\CartSessionType;
use DateTimeImmutable;
use Ibexa\Collaboration\Persistence\Values\AbstractSessionCreateStruct;

final class CartSessionCreateStruct extends AbstractSessionCreateStruct
{
    public function __construct(
        string $token,
        private string $cartIdentifier,
        int $ownerId,
        bool $isActive,
        bool $hasPublicLink,
        ?DateTimeImmutable $createdAt = null,
        ?DateTimeImmutable $updatedAt = null
    ) {
        parent::__construct($token, $ownerId, $isActive, $hasPublicLink, $createdAt, $updatedAt);
    }

    public function getCartIdentifier(): string
    {
        return $this->cartIdentifier;
    }

    public function setCartIdentifier(string $cartIdentifier): void
    {
        $this->cartIdentifier = $cartIdentifier;
    }

    public function getDiscriminator(): string
    {
        return CartSessionType::IDENTIFIER;
    }
}
```

- `CartSessionUpdateStruct` - defines the data used to update an existing Cart collaboration session:

```php
<?php declare(strict_types=1);

namespace App\Collaboration\Cart\Persistence\Values;

use App\Collaboration\Cart\CartSessionType;
use Ibexa\Collaboration\Persistence\Values\AbstractSessionUpdateStruct;

final class CartSessionUpdateStruct extends AbstractSessionUpdateStruct
{
    public function getDiscriminator(): string
    {
        return CartSessionType::IDENTIFIER;
    }
}
```

### Create Cart session Struct objects

The next step is to integrate the Public API with the database so that it can store and retrieve data from the tables created earlier. You need to create new files to define the data that is passed into the public API. This data is then used by the [`SessionService`](../../../../../../ibexa/collaboration/src/contracts/SessionServiceInterface.php) and public API handlers.

In the `src/Collaboration/Cart/` directory, create the following Session Structs:

- `CartSessionCreateStruct` - holds all necessary properties (like session token, participants, scopes, and the Cart reference) needed by the `SessionService` to create the shared Cart session:

```php
<?php declare(strict_types=1);

namespace App\Collaboration\Cart;

use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Collaboration\Session\AbstractSessionCreateStruct;

final class CartSessionCreateStruct extends AbstractSessionCreateStruct
{
    public function __construct(private CartInterface $cart)
    {
        parent::__construct();
    }

    public function getCart(): CartInterface
    {
        return $this->cart;
    }

    public function setCart(CartInterface $cart): void
    {
        $this->cart = $cart;
    }

    public function getType(): string
    {
        return CartSessionType::IDENTIFIER;
    }
}
```

- `CartSessionUpdateStruct` - defines the properties used to update an existing Cart collaboration session, including participants, scopes, and metadata:

```php
<?php declare(strict_types=1);

namespace App\Collaboration\Cart;

use Ibexa\Contracts\Collaboration\Session\AbstractSessionUpdateStruct;

final class CartSessionUpdateStruct extends AbstractSessionUpdateStruct
{
    public function getType(): string
    {
        return CartSessionType::IDENTIFIER;
    }
}
```

- `CartSession` - represents a Cart collaboration session, storing its ID, token, associated Cart, participants, and scope:

```php
<?php declare(strict_types=1);

namespace App\Collaboration\Cart;

use DateTimeInterface;
use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Collaboration\Participant\ParticipantCollectionInterface;
use Ibexa\Contracts\Collaboration\Session\AbstractSession;
use Ibexa\Contracts\Core\Repository\Values\User\User;

final class CartSession extends AbstractSession
{
    public function __construct(
        int $id,
        private readonly CartInterface $cart,
        string $token,
        User $owner,
        ParticipantCollectionInterface $participants,
        bool $isActive,
        bool $hasPublicLink,
        DateTimeInterface $createdAt,
        DateTimeInterface $updatedAt
    ) {
        parent::__construct($id, $token, $owner, $participants, $isActive, $hasPublicLink, $createdAt, $updatedAt);
    }

    public function getCart(): CartInterface
    {
        return $this->cart;
    }
}
```

- `CartSessionType` - defines the type of the collaboration session (in this case it indicates it’s a Cart session):

```php
<?php declare(strict_types=1);

namespace App\Collaboration\Cart;

use Ibexa\Contracts\Collaboration\Session\SessionScopeInterface;

final class CartSessionType implements SessionScopeInterface
{
    public const string SCOPE_VIEW = 'view';
    public const string SCOPE_EDIT = 'edit';

    public const string IDENTIFIER = 'cart';

    private function __construct()
    {
        // This class is not intended to be instantiated
    }

    public function getDefaultScope(): string
    {
        return self::SCOPE_VIEW;
    }

    public function isValidScope(string $scope): bool
    {
        return in_array($scope, $this->getScopes(), true);
    }

    public function getScopes(): array
    {
        return [
            self::SCOPE_VIEW,
            self::SCOPE_EDIT,
        ];
    }
}
```

## Create mappers

Mappers convert session data into the format required by the database and pass it to the repository.

In the `src/Collaboration/Cart/Mapper/` directory, create following mappers:

- `CartProxyMapper` - creates a simplified version of the Cart with only the necessary data to reduce memory usage in collaboration sessions:

```php
<?php declare(strict_types=1);

namespace App\Collaboration\Cart\Mapper;

use Ibexa\Contracts\Cart\CartServiceInterface;
use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Core\Repository\Repository;
use Ibexa\Core\Repository\ProxyFactory\ProxyGeneratorInterface;
use ProxyManager\Proxy\LazyLoadingInterface;

final readonly class CartProxyMapper implements CartProxyMapperInterface
{
    public function __construct(
        private Repository $repository,
        private CartServiceInterface $cartService,
        private ProxyGeneratorInterface $proxyGenerator
    ) {
    }

    public function createCartProxy(string $identifier): CartInterface
    {
        $initializer = function (
            &$wrappedObject,
            LazyLoadingInterface $proxy,
            $method,
            array $parameters,
            &$initializer
        ) use ($identifier): bool {
            $initializer = null;
            $wrappedObject = $this->repository->sudo(fn (): CartInterface => $this->cartService->getCart($identifier));

            return true;
        };

        return $this->proxyGenerator->createProxy(CartInterface::class, $initializer);
    }
}
```

- `CartProxyMapperInterface` - defines how a Cart should be converted into a simplified object that is used in collaboration session and specifies what methods the mapper must implement:

```php
<?php declare(strict_types=1);

namespace App\Collaboration\Cart\Mapper;

use Ibexa\Contracts\Cart\Value\CartInterface;

interface CartProxyMapperInterface
{
    public function createCartProxy(string $identifier): CartInterface;
}
```

- `CartSessionDomainMapper` - builds the session object from persistence object:

```php
<?php declare(strict_types=1);

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
final readonly class CartSessionDomainMapper implements SessionDomainMapperInterface
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
```

- `CartSessionPersistenceMapper` - prepares session data to be saved or updated in the database:

```php
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
```

Then, in the `src/Collaboration/Cart/Persistence/` directory, create the following mapper:

- `Persistence/Mapper` - builds the session object from persistence row:

```php
<?php declare(strict_types=1);

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
```

In `services.yaml`, declare and tags the gateway and the mappers:

```yaml
services:
    # …
    App\Collaboration\Cart\Persistence\Gateway\DatabaseGateway:
        arguments:
            $connection: '@ibexa.persistence.connection'
        tags:
            -   name: 'ibexa.collaboration.persistence.session.gateway'
                discriminator: !php/const App\Collaboration\Cart\Persistence\Gateway\DatabaseGateway::DISCRIMINATOR

    App\Collaboration\Cart\Persistence\Mapper:
        tags:
            -   name: 'ibexa.collaboration.persistence.session.mapper'
                discriminator: !php/const App\Collaboration\Cart\Persistence\Gateway\DatabaseGateway::DISCRIMINATOR

    App\Collaboration\Cart\Mapper\CartSessionDomainMapper:
        tags:
            -   name: 'ibexa.collaboration.service.session.domain.mapper'
                type: App\Collaboration\Cart\Persistence\Values\CartSession

    App\Collaboration\Cart\Mapper\CartSessionPersistenceMapper:
        tags:
            -   name: 'ibexa.collaboration.service.session.persistence.mapper'
                type: !php/const App\Collaboration\Cart\CartSessionType::IDENTIFIER
```

## Allow participants to access Cart

To enable collaboration, you must configure the appropriate permissions. This involves decorating the `PermissionResolver` and `CartResolver`.

This ensures that when a Cart is part of a Cart collaboration session, users can access it based on the defined permissions. In all other cases, the system falls back to the default implementation.

> **Caution: Decorating permissions**
>
> When decorating permissions, be careful to change the behavior only as necessary, to ensure that the Cart is shared only with the intended users.

In the `src/Collaboration/Cart/` directory, create the following files:

- `PermissionResolverDecorator` – customizes the permission resolver to handle access rules for Cart collaboration sessions. It allows participants to view or edit shared Carts while preserving default permission checks for all other cases. Here you can decide what scope is available for this collaboration session by choosing between `view` or `edit`:

```php
<?php declare(strict_types=1);

namespace App\Collaboration\Cart;

use Ibexa\Contracts\Cart\Permission\Policy\Cart\Edit as CartEdit;
use Ibexa\Contracts\Cart\Permission\Policy\Cart\View as CartView;
use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Collaboration\SessionServiceInterface;
use Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException;
use Ibexa\Contracts\Core\Repository\Exceptions\UnauthorizedException;
use Ibexa\Contracts\ProductCatalog\Permission\Policy\PolicyInterface;
use Ibexa\Contracts\ProductCatalog\PermissionResolverInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class PermissionResolverDecorator implements PermissionResolverInterface
{
    public const string COLLABORATION_SESSION_ID = 'collaboration_session';

    private bool $nested = false;

    public function __construct(
        private readonly PermissionResolverInterface $innerPermissionResolver,
        private readonly SessionServiceInterface $sessionService,
        private readonly RequestStack $requestStack,
    ) {
    }

    public function canUser(PolicyInterface $policy): bool
    {
        $object = $policy->getObject();
        if ($this->nested === false && $this->isCartPolicy($policy) && $object instanceof CartInterface && $this->isSharedCart($object)) {
            return true;
        }

        return $this->innerPermissionResolver->canUser($policy);
    }

    public function assertPolicy(PolicyInterface $policy): void
    {
        $object = $policy->getObject();
        if ($this->nested === false && $this->isCartPolicy($policy) && $object instanceof CartInterface && $this->isSharedCart($object)) {
            return;
        }

        $this->innerPermissionResolver->assertPolicy($policy);
    }

    private function isCartPolicy(PolicyInterface $policy): bool
    {
        return $policy instanceof CartView || $policy instanceof CartEdit;
    }

    private function isSharedCart(?CartInterface $cart): bool
    {
        if ($cart === null) {
            return false;
        }

        try {
            $this->nested = true;

            /** @var \App\Collaboration\Cart\CartSession $session */
            $session = $this->getCurrentCartCollaborationSession();
            if ($session !== null) {
                try {
                    return $cart->getId() === $session->getCart()->getId();
                } catch (NotFoundException) {
                }
            }
        } finally {
            $this->nested = false;
        }

        return false;
    }

    private function getCurrentCartCollaborationSession(): ?CartSession
    {
        $token = $this->requestStack->getSession()->get(self::COLLABORATION_SESSION_ID);
        if ($token === null) {
            return null;
        }

        try {
            $session = $this->sessionService->getSessionByToken($token);
            if ($session instanceof CartSession) {
                return $session;
            }
        } catch (NotFoundException|UnauthorizedException) {
        }

        return null;
    }
}
```

- `CartResolverDecorator` – resolves the shared Carts in collaboration sessions by checking if a Cart belongs to a collaboration session:

```php
<?php declare(strict_types=1);

namespace App\Collaboration\Cart;

use Ibexa\Contracts\Cart\CartResolverInterface;
use Ibexa\Contracts\Cart\Value\CartInterface;
use Ibexa\Contracts\Collaboration\SessionServiceInterface;
use Ibexa\Contracts\Core\Repository\Exceptions\NotFoundException;
use Ibexa\Contracts\Core\Repository\Exceptions\UnauthorizedException;
use Ibexa\Contracts\Core\Repository\Values\User\User;
use Symfony\Component\HttpFoundation\RequestStack;

final readonly class CartResolverDecorator implements CartResolverInterface
{
    public function __construct(
        private CartResolverInterface $innerCartResolver,
        private SessionServiceInterface $sessionService,
        private RequestStack $requestStack
    ) {
    }

    public function resolveCart(?User $user = null): CartInterface
    {
        if ($this->hasSharedCart()) {
            return $this->getSharedCart() ?? $this->innerCartResolver->resolveCart($user);
        }

        return $this->innerCartResolver->resolveCart($user);
    }

    private function getSharedCart(): ?CartInterface
    {
        try {
            $session = $this->sessionService->getSessionByToken(
                $this->requestStack->getSession()->get(PermissionResolverDecorator::COLLABORATION_SESSION_ID)
            );

            if (!$session instanceof CartSession) {
                return null;
            }

            return $session->getCart();
        } catch (NotFoundException|UnauthorizedException) {
            return null;
        }
    }

    private function hasSharedCart(): bool
    {
        return $this->requestStack->getSession()->has(PermissionResolverDecorator::COLLABORATION_SESSION_ID);
    }
}
```

In `services.yaml`, declare those decorator services associated with what they decorate:

```yaml
services:
    # …
    App\Collaboration\Cart\PermissionResolverDecorator:
        decorates: Ibexa\Contracts\ProductCatalog\PermissionResolverInterface

    App\Collaboration\Cart\CartResolverDecorator:
        decorates: Ibexa\Contracts\Cart\CartResolverInterface
```

## Build dedicated controllers to manage Cart sharing flow

To support Cart sharing, create controllers which handle the collaboration flow. They are responsible for starting a sharing session, adding participants, and allowing users to join an existing shared Cart.

You need to create two controllers:

- `ShareCartCreateController` - creates the Cart collaboration session and adds participants
- `ShareCartJoinController` - allows to join the session

### `ShareCartCreateController`

This controller handles the request when you enter an email address of the user that you want to invite and submit it. It captures the email address and checks whether the form has been submitted. If yes, the form data is retrieved, and the `cartResolver` verifies whether there is currently a shared Cart.

If a shared Cart exists, the Cart is retrieved and a session is created (`$cart` becomes the session context). In the `addParticipant` step, the user whose email address was provided is added to the session and assigned a scope (either `view` or `edit`).

```php
<?php declare(strict_types=1);

namespace App\Controller;

use App\Collaboration\Cart\CartSessionCreateStruct;
use App\Collaboration\Cart\CartSessionType;
use App\Form\Type\ShareCartType;
use Ibexa\Contracts\Cart\CartResolverInterface;
use Ibexa\Contracts\Collaboration\Participant\ExternalParticipantCreateStruct;
use Ibexa\Contracts\Collaboration\SessionServiceInterface;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/shared-cart/create', name: 'app.shared_cart.create')]
final class ShareCartCreateController extends AbstractController
{
    public function __construct(
        private readonly SessionServiceInterface $sessionService,
        private readonly CartResolverInterface $cartResolver
    ) {
    }

    public function __invoke(Request $request): Response
    {
        $form = $this->createForm(
            ShareCartType::class,
            null,
            [
                'method' => 'POST',
            ]
        );

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var \App\Form\Data\ShareCartData $data */
            $data = $form->getData();

            // Handle the form submission
            $cart = $this->cartResolver->resolveCart();

            $session = $this->sessionService->createSession(
                new CartSessionCreateStruct($cart)
            );

            $email = $data->getEmail();
            if ($email === null) {
                throw new InvalidArgumentException('Email cannot be null');
            }

            $this->sessionService->addParticipant(
                $session,
                new ExternalParticipantCreateStruct(
                    $email,
                    CartSessionType::SCOPE_EDIT
                )
            );

            return $this->render(
                '@ibexadesign/cart/share_result.html.twig',
                [
                    'session' => $session,
                ]
            );
        }

        return $this->render(
            '@ibexadesign/cart/share.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
```

### `ShareCartJoinController`

It enables joining a Cart session. The session token created earlier is passed in the URL, and in the `join` action, the system attempts to retrieve the session associated with that token. If the token is invalid, an exception is thrown to indicate that the session cannot be accessed. If the session exists, the session parameter (`collaboration_session`) is retrieved and the session stores the token. Finally, `redirectToRoute` redirects the user to the Cart view and passes the identifier of the shared Cart.

```php
<?php declare(strict_types=1);

namespace App\Controller;

use App\Collaboration\Cart\CartSession;
use Ibexa\Contracts\Collaboration\SessionServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route('/shared-cart/join/{token}', name: 'app.shared_cart.join')]
final class ShareCartJoinController extends AbstractController
{
    public const string CURRENT_COLLABORATION_SESSION = 'collaboration_session';

    public function __construct(
        private readonly SessionServiceInterface $sessionService,
    ) {
    }

    public function __invoke(Request $request, string $token): RedirectResponse
    {
        $session = $this->sessionService->getSessionByToken($token);
        if ($session instanceof CartSession) {
            $request->getSession()->set(self::CURRENT_COLLABORATION_SESSION, $session->getToken());

            return $this->redirectToRoute('ibexa.cart.view', [
                'identifier' => $session->getCart()->getIdentifier(),
            ]);
        }

        throw $this->createAccessDeniedException();
    }
}
```

> **Caution: Session parameter**
>
> Avoid using a generic session parameter name such as `collaboration_session` (it's used here only for example purposes). The user can participate in multiple sessions simultaneously (of one or many types), so using such name would cause the parameter to be constantly overwritten. Therefore, active sessions should not be resolved based on such parameter.

## Integrate with Symfony forms by adding forms and templates

To support inviting users to a shared Cart, you need to create a dedicated form and a data class. The form collects the email address of the user that you want to invite, and the data class is used to safely pass that information from the form to the controller.

- `ShareCartType` - a simple form for entering an email address of the user you want to invite to share the Cart. The form contains a single input field where you enter the email address manually:

```php
<?php declare(strict_types=1);

namespace App\Form\Type;

use App\Form\Data\ShareCartData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @extends AbstractType<ShareCartData>
 */
final class ShareCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email', EmailType::class, [
            'label' => 'E-mail',
        ])->add('submit', SubmitType::class, [
            'label' => 'Share',
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShareCartData::class,
        ]);
    }
}
```

- `ShareCartData` - a class that holds the email address submitted through the form and passes it to the controller:

```php
<?php declare(strict_types=1);

namespace App\Form\Data;

final class ShareCartData
{
    public function __construct(
        private ?string $email = null
    ) {
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }
}
```

The last step is to integrate the new session type into your application by adding templates. In this step, the view is rendered.

You need to add the following Twig templates in the `src/templates/themes/storefront/cart/` directory:

- `share` - defines the view for the Cart sharing form. It renders the form where a user can enter an email address to invite someone to collaborate on the Cart:

```php
{% extends '@ibexadesign/storefront/layout.html.twig' %}

{% block content %}
    {{ form_start(form) }}
        {{ form_label(form.email, null, { 'label_attr': { 'class': 'ibexa-store-label' }}) }}
        {{ form_widget(form.email, { 'attr': { 'class': 'ibexa-store-input' } }) }}
        {{ form_widget(form.submit, { 'attr': { 'class': 'ibexa-store-btn ibexa-store-btn--primary' } }) }}
    {{ form_end(form) }}
{% endblock %}
```

![Share email](https://doc.ibexa.co/en/5.0/content_management/collaborative_editing/img/share_email.png)

- `share_result` - renders the result page after a Cart has been shared. If the shared Cart exists in the system, the created session object is passed to the view and displayed. A message like "Cart has been shared…" is displayed, along with a link to access the session:

```php
{% extends '@ibexadesign/storefront/layout.html.twig' %}

{% block content %}
    <p class="ibexa-store-notice-card ibexa-store-notice-card--success">
        Cart has been shared successfully! Link to session:&nbsp;
        <a href="{{ path('app.shared_cart.join', { token: session.getToken() }) }}">
            {{ url('app.shared_cart.join', { token: session.getToken() }) }}
        </a>
    </p>
{% endblock %}
```

![Share message](https://doc.ibexa.co/en/5.0/content_management/collaborative_editing/img/share_message.png)

- `view` - shows the Cart page. It displays the Cart content and includes the “Share Cart” button:

```php
{% extends '@IbexaStorefront/themes/storefront/cart/view.html.twig' %}

{% block content %}
    <div style="text-align: right">
        <a href="{{ path('app.shared_cart.create') }}" class="ibexa-store-btn ibexa-store-btn--secondary">Share cart</a>
    </div>
    {{ parent() }}
{% endblock %}
```

![Share button](https://doc.ibexa.co/en/5.0/content_management/collaborative_editing/img/share_button.png)
