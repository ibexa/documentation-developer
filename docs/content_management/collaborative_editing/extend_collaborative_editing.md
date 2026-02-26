---
description: Extend Collaborative editing
month_change: true
---

# Extend Collaborative editing

Thanks to the ability to extend the [Collaborative editing](collaborative_editing_guide.md) feature, you can add even more functionalities that can improve workflows not only within content editing but also when working, for example, with the product.
In the example below, you will learn how to extend this feature to enable a shared Cart functionality in the Commerce system.

!!! tip

    If you prefer learning from videos, you can check a presentation from Ibexa Summit 2025 that covers the Collaborative editing feature:

    [_Collaboration: greater than the sum of the parts_](https://www.youtube.com/watch?v=dRB-SDlgX0I) by Marek Nocoń

## Create tables to hold Cart session data

First, you need to set up the database layer and define the collaboration context, in this example, Cart.
Create the necessary tables to store the data and to link the collaboration session with the Cart you want to share.

In the `data/schema.sql` file create a database table to store a reference to the session context.
In this example, it represents the shopping Cart (identified by the Cart identifier) and an additional numeric ID stored in the database.

=== "MySQL"

    ``` sql
        CREATE TABLE ibexa_collaboration_cart
        (
            id INT NOT NULL PRIMARY KEY,
            cart_identifier VARCHAR(255) NOT NULL,
            CONSTRAINT ibexa_collaboration_cart_ibexa_collaboration_id_fk
                FOREIGN KEY (id) REFERENCES ibexa_collaboration (id)
                    ON DELETE CASCADE
        ) COLLATE = utf8mb4_general_ci;
    ```

=== "PostgreSQL"

    ``` sql
    CREATE TABLE ibexa_collaboration_cart (
    id INTEGER NOT NULL PRIMARY KEY,
    cart_identifier VARCHAR(255) NOT NULL,
    CONSTRAINT ibexa_collaboration_cart_ibexa_collaboration_id_fk
        FOREIGN KEY (id) REFERENCES ibexa_collaboration (id)
        ON DELETE CASCADE
    );
    ```

## Set up the persistence layer

To extend Collaborative editing feature to support shared Cart collaboration, you need to prepare the persistence layer.
This layer handles how the data about collaboration session and the Cart is stored, retrieved, and managed in the database.

It ensures that when a user creates, joins, or updates a Cart session, the system can track session status, participants, and permissions.

### Implement the persistence gateway

The Gateway is the layer that connects the collaboration feature to the database.
It handles all the create, read, update, and delete operations for collaboration sessions, ensuring that session data is stored and retrieved correctly.

It also uses a Discriminator to specify the session type, so it can interact with the correct tables and data structures.
This way, the system knows which Gateway to use to get or save the right data for each session type.

When creating the Database Gateways and mappers, you can use the built-in service tag: `ibexa.collaboration.persistence.session.gateway`:

```yaml
    tags:
    - { name: 'ibexa.collaboration.persistence.session.gateway' }
```

In the `Collaboration/Cart/Persistence/Gateway` directory create the following files:

- `DatabaseSchema` - defines and creates the database tables needed to store shared Cart collaboration session data:

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/Persistence/Gateway/DatabaseSchema.php') =]]
```

- `DatabaseGateway` - implements the gateway logic for getting and retrieving shared Cart collaboration data from the database, using a Discriminator to indicate the type of session (in this case, a Cart session):

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/Persistence/Gateway/DatabaseGateway.php') =]]
```

### Define persistence Value objects

Value objects describe how collaboration session data is represented in the database.
Persistence gateway uses them to store, retrieve, and manipulate session information, such as the session ID, associated Cart, participants, and scopes.

In the `Collaboration/Cart/Persistence/Values` directory create the following Value Objects:

- `CartSession` - represents the Cart collaboration session data:

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/Persistence/Values/CartSession.php') =]]
```

- `CartSessionCreateStruct` - defines the data needed to create a new Cart collaboration session:

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/Persistence/Values/CartSessionCreateStruct.php') =]]
```

- `CartSessionUpdateStruct` - defines the data used to update an existing Cart collaboration session:

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/Persistence/Values/CartSessionUpdateStruct.php') =]]
```

### Create the Cart session Struct objects

The next step involves the Public API — you need to integrate it with the database to store data and retrieve it from the tables created before.
You need to create new files to define the data that is passed into the public API which are then used by the [SessionService](https://doc.ibexa.co/en/latest/api/php_api/php_api_reference/classes/Ibexa-Contracts-Collaboration-SessionServiceInterface.html) and public API handlers.

In the `Collaboration/Cart` directory create the following Session Structs:

- `CartSessionCreateStruct` - holds all necessary properties (like session token, participants, scopes, and the Cart reference) needed by the `SessionService` to create the shared Cart session:

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/CartSessionCreateStruct.php') =]]
```

- `CartSessionUpdateStruct` - defines the properties used to update an existing Cart collaboration session, including participants, scopes, and metadata:

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/CartSessionUpdateStruct.php') =]]
```

- `CartSession` - represents a Cart collaboration session, storing its ID, token, associated Cart, participants, and scope:

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/CartSession.php') =]]
```

- `CartSessionType` - defines the type of the collaboration session (in this case indicating it’s a Cart session):

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/CartSessionType.php') =]]
```

## Create mappers

Mappers are used to return session data into the format the database needs and to send it to the repository.

In the `src/Collaboration/Cart/Mapper` folder create four mappers:

- `CartProxyMapper` - creates a simplified version of the Cart with only the necessary data to reduce memory usage in collaboration sessions.

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/Mapper/CartProxyMapper.php') =]]
```

- `CartProxyMapperInterface` - defines how a Cart should be converted into a simplified object used in collaboration session and specifies what methods the mapper must implement.

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/Mapper/CartProxyMapperInterface.php') =]]
```

- `CartSessionDomainMapper` - builds the session object that the app works with.

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/Mapper/CartSessionDomainMapper.php') =]]
```

- `CartSessionPersistenceMapper` - prepares session data to be saved or updated in the database.

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/Mapper/CartSessionPersistenceMapper.php') =]]
```

## Allow participants to access the Cart

To start collaborating, you need to work on permissions.
This involves decorating the `PermissionResolver` and `CartResolver`.

This step makes sure that if a Cart is part of a Cart collaboration session, users can access it due to the given permission, and in all other cases, it falls back to the default implementation.

!!! caution "Decorating permissions"

    Be careful when decorating permissions to change the behavior only as necessary, ensuring the Cart is shared only with the intended users.

In the `src/Collaboration/Cart` directory, create the following files:

- `PermissionResolverDecorator` – customizes the permission resolver to handle access rules for Cart collaboration sessions, allowing participants to view or edit shared Carts while preserving default permission checks for all other cases. Here you can decide what scope is available for this collaboration session by choosing between `view` or `edit`.

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/PermissionResolverDecorator.php') =]]
```

- `CartResolverDecorator` – resolves the shared Carts in collaboration sessions, it checks if a Cart belongs to a collaboration session.

``` php
[[= include_file('code_samples/collaboration/src/Collaboration/Cart/CartResolverDecorator.php') =]]
```

## Build dedicated controllers to manage the Cart sharing flow

To support Cart sharing, you need to create controllers which handle the collaboration flow.
They are responsible for starting a sharing session, adding participants, and allowing users to join an existing shared Cart.

You need to create two controllers:

- `ShareCartCreateController` - to create the Cart collaboration session and add participants
- `ShareCartJoinController` that enables joining the session.

### `ShareCartCreateController`

When you enter the user email address and submit it, the request is handled by this controller.
It captures the email address and checks whether the form has been submitted.
If yes, the form data is retrieved, and the `cartResolver` verifies whether there is currently a shared Cart.

If a shared Cart exists, the Cart is retrieved and a session is created (`$cart` becomes the session context).
In the next step, `addParticipant`, the user whose email address was provided is added to the session and assigned a scope (either `view` or `edit`).

``` php
[[= include_file('code_samples/collaboration/src/Controller/ShareCartCreateController.php') =]]
```

### `ShareCartJoinController`

It enables joining a Cart session.
The session token created earlier is passed in the URL, and in the `Join` action the system attempts to retrieve the session associated with that token.
If the token is invalid, an exception is thrown indicating that the session cannot be accessed.
If the session exists, the session parameter (`collaboration_session`) is retrieved and store the token.
Finally, `redirectToRoute` redirects the user to the Cart view and passes the identifier of the shared Cart.

``` php
[[= include_file('code_samples/collaboration/src/Controller/ShareCartJoinController.php') =]]
```

!!! caution "Session parameter"

    Avoid using a generic session parameter name such as `collaboration_session` (it's used here only for example purposes).
    The user can participate in multiple sessions simultaneously (of one or many types), so using this parameter would cause it to be constantly overwritten.
    Therefore, active sessions should not be resolved based on such parameter.

## Integrate with Symfony forms by adding forms and templates

To support inviting users to a shared Cart, you need to create a dedicated form and a data class.
The form collects the email address of the user that you want to invite, and the data class is used to safely pass that information from the form to the controller.

- `ShareCartType` - a simple form for entering the email address of the user you want to invite to share the Cart. The form contains a single input field where you enter the email address manually.

``` php
[[= include_file('code_samples/collaboration/src/Form/Type/ShareCartType.php') =]]
```

- `ShareCartData` - this class holds the email address submitted through the form and pass it to the controller.

``` php
[[= include_file('code_samples/collaboration/src/Form/Data/ShareCartData.php') =]]
```

The last step is to integrate the new session type into your application by adding templates.
In this step, the view is rendered.

You need to add following templates in the `templates/themes/standard/cart` folder:

- `share` - this Twig template defines the view for the Cart sharing form. It renders the form where a user can enter an email address to invite someone to collaborate on the Cart.

``` php
[[= include_file('code_samples/collaboration/templates/themes/standard/cart/share.html.twig') =]]
```

- `share_result` - this Twig template renders the result page after a Cart has been shared. If the shared Cart exists in the system, the created session object is passed to the view and displayed. A message like "Cart has been shared…" is displayed, along with a link to access the session.

``` php
[[= include_file('code_samples/collaboration/templates/themes/standard/cart/share_result.html.twig') =]]
```

- `view` - is the template that shows the Cart page. It displays the Cart content and includes the “Share Cart” button and other elements for Cart collaboration.

``` php
[[= include_file('code_samples/collaboration/templates/themes/standard/cart/view.html.twig') =]]
```
