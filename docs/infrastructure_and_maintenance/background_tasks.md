---
description: Use Ibexa Messenger to run processes in the background and conserve system resources.
month_change: true
---

# Background tasks

Some operations in [[= product_name =]] don’t have to run immediately when a user clicks a button, for example, re-indexing product prices or processing bulk data.
Running such operations in real time could slow down the system and disrupt the user experience.

To solve this, [[= product_name =]] provides a package called [[= product_name_base =]] Messenger, which is an overlay to [Symfony Messenger]([[= symfony_doc =]]/messenger.html), and it's job is to queue tasks and run them in the background.
[[= product_name =]] sends messages (or commands) that represent the work to be done later.
These messages are stored in a queue and picked up by a background worker, which ensures that resource-heavy tasks are executed at a convenient time, without putting excessive load on the system.

[[= product_name_base =]] Messenger supports multiple storage backends, such as Doctrine, Redis/Valkey, and PostgreSQL, and gives developers the flexibility to create their own message handlers for custom use cases.

## How it works

[[= product_name_base =]] Messenger uses a command bus as a queue that stores messages, or commands, which tell the system what you want to happen, and separates them from the handler, which is the code that actually performs the task.

The process works as follows:

1. A message PHP object is dispatched, for example, `ProductPriceReindex`.
2. The message is wrapped in an envelope, which may contain additional metadata, called [stamps](#stamps).
3. The message is placed in the [transport queue](#route-message-to-background-queue).
It can be a Doctrine table, a Redis/Valkey queue, and so on.
4. A worker process continuously reads messages from the queue, pulls them into the default bus `ibexa.messenger.bus` and assigns them to the right handler.
5. A handler service processes the message (executes the command).
You can register multiple handlers for different jobs.

Here is an example of how you can extend your code and use [[= product_name_base =]] Messenger to process your tasks:

### Configure package

Create a config file, for example, `config/packages/ibexa_messenger.yaml` and define your transport:

``` yaml
ibexa_messenger:

    # The DSN of the transport, as expected by Symfony Messenger transport factory.
    transport_dsn:        'doctrine://default?table_name=ibexa_messenger_messages&auto_setup=false'
    deduplication_lock_storage:
        enabled:              true

        # Doctrine DBAL primary connection or custom service
        type:                 doctrine # One of "doctrine"; "custom"; "service"

        # The service ID of a custom Lock Store, if "service" type is selected
        service:              null

        # The DSN of the lock store, if "custom" type is selected
        dsn:                  null
```

!!! note "Supported transports"

    You can define different transports: [[= product_name_base =]] Messenger has been tested to work with Redis, MySQL, PostgreSQL.
    For more information, see [Symfony Messenger documentation](https://symfony.com/doc/current/messenger.html#transports-async-queued-messages) or [Symfony Messenger tutorial](https://symfonycasts.com/screencast/messenger/install).

### Start worker

Use a process manager of your choice to run the following command, or make it start together with the server:

``` bash
php bin/console messenger:consume ibexa.messenger.transport --bus=ibexa.messenger.bus --siteaccess=<OPTIONAL>
```

Use the `--siteaccess` option to set the default [SiteAccess](multisite_configuration.md#siteaccess-configuration) and [repository](repository_configuration.md#defining-custom-connection) for the worker process.
The worker uses this SiteAccess for every message that doesn't have a [`SiteAccessStamp`](#siteaccessstamp).

If a message has a `SiteAccessStamp`, the worker uses the SiteAccess from the stamp instead to process this message.
Thanks to this, one worker process can handle messages coming from different SiteAccesses.

In [multi-repository setups](repository_configuration.md), run one worker process for each repository.
With this setup, each worker process can connect to the right database.

!!! caution "Multi-repository setups"

    Doctrine transport works across multiple repositories without issues, but other transports may need to be adjusted, so that queues across different repositories are not accidentally shared.

#### Configure for production environment

In production, make sure that [[= product_name_base =]] Messenger keeps running.
You can configure a process manager, such as [Supervisor]([[= symfony_doc =]]/messenger.html#messenger-supervisor) or [systemd]([[= symfony_doc =]]/messenger.html#systemd-configuration), to restart the worker if it stops.

To prevent issues with memory leaks or stale processes, run the worker with execution limits:

- `--limit` limits the number of messages the worker processes before exiting.
- `--time-limit` limits the execution time in seconds before the worker exits.
- `--memory-limit` restricts the maximum memory usage.

The following example shows how you can specify these limits:

``` bash
php bin/console messenger:consume ibexa.messenger.transport --bus=ibexa.messenger.bus --limit=100 --time-limit=60 --memory-limit=256M
```

For more information, see [Symfony production recommendation for the Messenger component]([[= symfony_doc =]]/messenger.html#deploying-to-production).

If you deploy your application on [[= product_name_cloud =]], using [Workers](https://fixed.docs.upsun.com/guides/symfony/workers.html) is recommended.

## Dispatch message

To have a task processed in the background by [[= product_name_base =]] Messenger:

1. Inject the `ibexa.messenger.bus` service as an object implementing the `Symfony\Component\Messenger\MessageBusInterface` interface.
2. Dispatch an appropriate message, for example a [custom message](#register-custom-message-and-handler), by using the `MessageBusInterface::dispatch()` method, exactly as described in [Symfony Messenger documentation]([[= symfony_doc =]]/messenger.html#dispatching-the-message).

``` yaml
services:
    SomeClassThatSchedulesExecutionInTheBackground:
        arguments:
            $bus: '@ibexa.messenger.bus'
```

``` php
[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 1, 3) =]]

[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 5, 5) =]]
[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 10, 15) =]]
[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 17, 22) =]]
[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 30, 31) =]]
```

3. [Route the message to the background queue](#route-message-to-background-queue).
Otherwise the bus calls the handler immediately, in the same process that dispatches the message.

4. Additionally, attach message metadata by using [stamps](#stamps).

### Stamps

You can attach [Stamps]([[= symfony_doc =]]/messenger.html#envelopes-stamps) to a message envelope to add additional metadata and control processing of the message.

The `ibexa.messenger.bus` message bus uses the default Symfony Messenger [middleware]([[= symfony_doc =]]/messenger.html#middleware) and doesn't support all stamps that are available in Symfony.

You can use the following Symfony stamps:

- [`DelayStamp`](https://github.com/symfony/symfony/blob/[[= symfony_version =]]/src/Symfony/Component/Messenger/Stamp/DelayStamp.php)
- [`DispatchAfterCurrentBusStamp`]([[= symfony_doc =]]/messenger.html#dispatchaftercurrentbusmiddleware-middleware)
- [`HandlerArgumentsStamp`]([[= symfony_doc =]]/messenger.html#additional-handler-arguments)
- [`SerializerStamp`]([[= symfony_doc =]]/messenger.html#serializing-messages)

On top of the supported Symfony stamps, [[= product_name =]] provides the following ones:

- [`DeduplicateStamp`](#deduplicatestamp)
- [`SudoStamp`](#sudostamp)
- [`UserPermissionStamp`](#userpermissionstamp)
- [`SiteAccessStamp`](#siteaccessstamp)

#### DeduplicateStamp

[`DeduplicateStamp`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Messenger-Stamp-DeduplicateStamp.html) prevents duplicate messages from being processed.
When you attach it to a message, the system uses a lock to ensure that only one message with the same key is handled at a time.

For more information, see [Symfony documentation about message deduplication]([[= symfony_doc =]]/messenger.html#message-deduplication).

!!! caution

    The `ibexa.messenger.bus` bus doesn't support the [`Symfony\Component\Messenger\Stamp\DeduplicateStamp`](https://github.com/symfony/symfony/blob/[[= symfony_version =]]/src/Symfony/Component/Messenger/Stamp/DeduplicateStamp.php) stamp.

    You must use the `Ibexa\Contracts\Messenger\Stamp\DeduplicateStamp` stamp instead.

The following example shows how you can attach the `DeduplicateStamp` to the message:

``` php
[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 6, 6, remove_indent=True) =]]
[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 9, 9, remove_indent=True) =]]

[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 27, 28, remove_indent=True) =]]
```

#### SudoStamp

[`SudoStamp`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Messenger-Stamp-SudoStamp.html) causes the handler to [use sudo mode](php_api.md#using-sudo), bypassing all permission checks when processing the message.

It's automatically attached to every dispatched message.

!!! caution

    Starting with Ibexa DXP 5.0.9, the behavior of automatically attaching a `SudoStamp` to every message is deprecated and will be removed in 6.0.
    For messages that should be processed without taking permissions into account, always attach the `SudoStamp` manually to keep your code forward-compatible.

The following example shows how you can attach the `SudoStamp` to the message:

``` php
[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 7, 7, remove_indent=True) =]]
[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 9, 10, remove_indent=True) =]]

[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 25, 25, remove_indent=True) =]]
```

#### UserPermissionStamp

[`UserPermissionStamp`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Messenger-Stamp-UserPermissionStamp.html) allows you to [set the repository user](php_api.md#setting-the-repository-user) to process the message.
When the user is set, handlers execute actions on their behalf and take their permissions into account.

If you don't attach this stamp, the messages are processed by the default repository user called anonymous user.
By combing this stamp with [`SudoStamp`](#sudostamp), you can set the repository user and skip the permission checks at the same time.

The following example shows how you can use `UserPermissionStamp` to preserve the current repository user after the message is dispatched.

``` php
[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 5, 5, remove_indent=True) =]]
[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 8, 10, remove_indent=True) =]]

[[= include_code('code_samples/background_tasks/src/Dispatcher/SomeClassThatSchedulesExecutionInTheBackground.php', 23, 24, remove_indent=True) =]]
```

#### SiteAccessStamp

[`Ibexa\Contracts\Messenger\Stamp\SiteAccessStamp`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Messenger-Stamp-SiteAccessStamp.html) contains the name of the [SiteAccess](siteaccess.md) that dispatched the message.

You don't need to add this stamp manually, [[= product_name_base =]] Messenger attaches this stamp to each dispatched message automatically.
The stamp contains the SiteAccess that is current at the moment of dispatch.

Before the worker calls the handler, it changes the configuration scope to the SiteAccess from the stamp.
The handler then reads [SiteAccess-aware configuration](multisite_configuration.md#siteaccess-configuration) for the SiteAccess that dispatched the message, and not for the SiteAccess that the worker process started with.

!!! caution "The stamp doesn't change the current SiteAccess"

    The stamp changes the configuration scope only.
    It doesn't change the SiteAccess in the `Ibexa\Core\MVC\Symfony\SiteAccess\SiteAccessServiceInterface` service.
    `SiteAccessServiceInterface::getCurrent()` always returns the SiteAccess that the worker process started with, for all messages.

    To get a SiteAccess-aware value in a handler, use the [`ConfigResolverInterface` service](dynamic_configuration.md).

## Extend Ibexa Messenger

To handle a custom use case with background tasks, you need the following elements:

- a message class to hold the data
- a handler class to perform the task, registered on the `ibexa.messenger.bus` bus
- a message provider to [route the message to the transport queue](#route-message-to-background-queue)
- code to [dispatch the message](#dispatch-message)

If you don't route the message to the transport queue, the bus calls the handler synchronously, in the same process that dispatches the message.

### Register custom message and handler

To handle additional use cases with background tasks, first create a [custom message and handler class]([[= symfony_doc =]]/messenger.html#creating-a-message-handler):

``` php
[[= include_code('code_samples/background_tasks/src/Message/SomeMessage.php') =]]
```

``` php
[[= include_code("code_samples/background_tasks/src/MessageHandler/SomeHandler.php") =]]
```

Add a service definition to `config/services.yaml` and set the `bus` to `ibexa.messenger.bus`:

``` yaml hl_lines="4-5"
services:
    App\MessageHandler\SomeHandler:
        tags:
            - name: messenger.message_handler
              bus: ibexa.messenger.bus
```

At this point the handler processes the messages synchronously.
To move the work to the background, [route the message to the background queue](#route-message-to-background-queue).

### Route message to background queue

To process the message in the background, send it to a transport queue.
[[= product_name_base =]] Messenger uses message providers instead of [Symfony `framework.messenger.routing` configuration]([[= symfony_doc =]]/messenger.html#routing-messages-to-a-transport).

A message provider is a service that implements the [`MessageProviderInterface`](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Messenger-Transport-MessageProviderInterface.html) interface, and the `getHandledClasses()` method must return the list of message classes that [[= product_name_base =]] Messenger must send to the queue to process in the background.

The `getHandledClasses()` method can also return a parent class or an interface.
In this case, all messages that extend this class, or implement this interface, go to the background queue.

To send `SomeMessage` to the background queue, create the following provider:

``` php hl_lines="12"
[[= include_file('code_samples/background_tasks/src/Messenger/SomeMessageProvider.php') =]]
```

If you're not using service autoconfiguration, add the `ibexa.messenger.sender_message_provider` tag to the service:

``` yaml hl_lines="4"
services:
    App\Messenger\SomeMessageProvider:
        tags:
            - name: ibexa.messenger.sender_message_provider
```
