---
description: Use Ibexa Messenger to run processes in the background and conserve system resources.
month_change: true
---

# Background tasks

Some operations in [[= product_name =]] don’t have to run immediately when a user clicks a button, for example, re-indexing product prices or processing bulk data.
Running such operations in real time could slow down the system and disrupt the user experience.

To solve this, [[= product_name =]] provides a package called [[= product_name_base =]] Messenger, which is an overlay to [Symfony Messenger](https://symfony.com/doc/current/messenger.html), and it's job is to queue tasks and run them in the background.
[[= product_name =]] sends messages (or commands) that represent the work tto be done later.
These messages are stored in a queue and picked up by a background worker, which ensures that resource-heavy tasks are executed at a convenient time, without putting excessive load on the system.

[[= product_name_base =]] Messenger supports multiple storage backends, such as Doctrine, Redis, and PostgreSQL, and gives developers the flexibility to create their own message handlers for custom use cases.

## How it works

[[= product_name_base =]] Messenger uses a command bus as a queue that stores messages, or commands, which tell the system what you want to happen, and separates them from the handler, which is the code that actually performs the task.

The process works as follows:

1. A message PHP object is dispatched, for example, `ProductPriceReindex`.
2. The message is wrapped in an envelope, which may contain additional metadata, called stamps, for example, `DeduplicateStamp`.
3. The message is placed in the transport queue.
It can be a Doctrine table, a Redis queue, and so on.
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
    For more information, see [Symfony Messenger documentation](https://symfony.com/doc/current/messenger.html#transports-async-queued-messages) or [Symfony Messenger tutorial](https://symfonycasts.com/screencast/messenger/install#installing-messenger).

### Start worker

Use a process manager of your choice to run the following command, or make it start together with the server:

``` bash
php bin/console messenger:consume ibexa.messenger.transport --bus=ibexa.messenger.bus --siteaccess=<OPTIONAL>`
```

In multi-repository setups, the worker process always works for a repository that you indicate by using the `--siteaccess` option, therefore you may need to run multiple workers, one for each SiteAccess.

!!! warning "Multi-repository setups"

    Doctrine transport works across multiple repositories without issues, but other transports may need to be adjusted, so that queues across different repositories are not accidentally shared.

### Dispatch message

``` php
use Symfony\Component\Messenger\MessageBusInterface;

final SomeClassThatSchedulesExecutionInTheBackground 
{
    public function __construct(
        // Service: "ibexa.messenger.bus"
        MessageBusInterface $bus
    )

    public function schedule(object $message): void
    {
        // Dispatch directly. Message is wrapped with envelope without any stamps.
        $this->bus->dispatch($message);

        // Alternatively, wrap with stamps. In this case, DeduplicateStamp ensures 
        // that if similar command exists in the queue (or is being processed)
        // it will not be queued again.
        $envelope = Envelope::wrap(
            $message, 
            [new DeduplicateStamp('command-name-1'),
        ]);

        $this->bus->dispatch($envelope);
    }
}
```

### Register handler

Create the handler class:

``` php
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class SomeHandler implements MessageHandlerInterface
{
    public function __invoke(SomeMessage $message): void
    {
        // Handle message.
        return;
    }
}
```

Add a service definition to `config/services.yaml`:

``` yaml
services:
    Ibexa\Bundle\Foo\Message\SomeHandler:
        tags:
            - name: messenger.message_handler
              bus: ibexa.messenger.bus
```
